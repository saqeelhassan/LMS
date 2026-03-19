<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InstallController extends Controller
{
    public function show(): View|RedirectResponse
    {
        if (file_exists(storage_path('installed'))) {
            return redirect()->route('login')->with('info', 'Application is already installed.');
        }

        $envPath = base_path('.env');
        $hasEnv = File::exists($envPath);
        $examplePath = base_path('.env.example');

        return view('pages.install.index', [
            'hasEnv' => $hasEnv,
            'dbConnection' => $hasEnv ? (config('database.default') ?? 'mysql') : 'mysql',
            'dbHost' => $hasEnv ? config('database.connections.mysql.host') : '127.0.0.1',
            'dbPort' => $hasEnv ? config('database.connections.mysql.port') : '3306',
            'dbDatabase' => $hasEnv ? config('database.connections.mysql.database') : '',
            'dbUsername' => $hasEnv ? config('database.connections.mysql.username') : 'root',
            'dbPassword' => $hasEnv ? config('database.connections.mysql.password') : '',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        if (file_exists(storage_path('installed'))) {
            return redirect()->route('login')->with('info', 'Application is already installed.');
        }

        $validated = $request->validate([
            'db_connection' => ['required', 'string', 'in:mysql,sqlite'],
            'db_host' => ['required_if:db_connection,mysql', 'nullable', 'string', 'max:255'],
            'db_port' => ['nullable', 'string', 'max:10'],
            'db_database' => ['required_if:db_connection,mysql', 'nullable', 'string', 'max:255'],
            'db_username' => ['nullable', 'string', 'max:255'],
            'db_password' => ['nullable', 'string', 'max:255'],
            'admin_first_name' => ['required', 'string', 'max:100'],
            'admin_last_name' => ['required', 'string', 'max:100'],
            'admin_email' => ['required', 'string', 'email', 'max:255'],
            'admin_password' => ['required', 'string', 'confirmed', 'min:8'],
        ], [
            'admin_password.confirmed' => 'The password confirmation does not match.',
            'admin_password.min' => 'Password must be at least 8 characters.',
        ]);

        try {
            $this->writeEnv($validated);

            if ($validated['db_connection'] === 'mysql') {
                $this->testDatabaseConnection(
                    $validated['db_host'],
                    $validated['db_port'] ?? '3306',
                    $validated['db_database'],
                    $validated['db_username'] ?? '',
                    $validated['db_password'] ?? ''
                );
            }

            $this->setRuntimeDatabaseConfig($validated);
            Artisan::call('migrate', ['--force' => true]);

            $this->runSeeders();

            $role = Role::where('name', 'SuperAdmin')->first();
            if (! $role) {
                throw new \RuntimeException('SuperAdmin role not found after seeding.');
            }

            $user = User::updateOrCreate(
                ['email' => strtolower(trim($validated['admin_email']))],
                [
                    'role_id' => $role->id,
                    'password' => $validated['admin_password'],
                    'is_active' => true,
                ]
            );

            UserDetail::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'first_name' => $validated['admin_first_name'],
                    'last_name' => $validated['admin_last_name'],
                ]
            );

            File::put(storage_path('installed'), date('c') . "\nInstalled via web installer.\n");

            return redirect()->route('login')->with('success', 'Installation complete. You can now log in with your Super Admin account.');
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withErrors(['install' => 'Installation failed: ' . $e->getMessage()])
                ->withInput($request->except('admin_password', 'admin_password_confirmation', 'db_password'));
        }
    }

    private function writeEnv(array $validated): void
    {
        $envPath = base_path('.env');
        $content = File::exists($envPath)
            ? File::get($envPath)
            : (File::exists(base_path('.env.example')) ? File::get(base_path('.env.example')) : '');

        $replacements = [
            'DB_CONNECTION' => $validated['db_connection'],
        ];

        if ($validated['db_connection'] === 'mysql') {
            $replacements['DB_HOST'] = $validated['db_host'] ?? '127.0.0.1';
            $replacements['DB_PORT'] = $validated['db_port'] ?? '3306';
            $replacements['DB_DATABASE'] = $validated['db_database'] ?? '';
            $replacements['DB_USERNAME'] = $validated['db_username'] ?? 'root';
            $replacements['DB_PASSWORD'] = $validated['db_password'] ?? '';
        }

        foreach ($replacements as $key => $value) {
            $escaped = str_replace(['\\', '"'], ['\\\\', '\\"'], $value);
            $pattern = '/^' . preg_quote($key, '/') . '=.*/m';
            $replacement = $key . '=' . (preg_match('/\s|#/', $escaped) ? '"' . $escaped . '"' : $escaped);
            if (preg_match($pattern, $content)) {
                $content = preg_replace($pattern, $replacement, $content, 1);
            } else {
                $content .= "\n" . $replacement . "\n";
            }
        }

        if (! preg_match('/^APP_KEY=/m', $content) || preg_match('/^APP_KEY=\s*$/m', $content)) {
            $key = 'base64:' . base64_encode(Str::random(32));
            if (preg_match('/^APP_KEY=/m', $content)) {
                $content = preg_replace('/^APP_KEY=.*/m', 'APP_KEY=' . $key, $content, 1);
            } else {
                $content = preg_replace('/(^APP_NAME=.*)/m', '$1' . "\nAPP_KEY=" . $key, $content, 1);
            }
        }

        File::put($envPath, $content);
    }

    /**
     * Set database config for this request so migrate and seeders use the new .env values.
     */
    private function setRuntimeDatabaseConfig(array $validated): void
    {
        config(['database.default' => $validated['db_connection']]);

        if ($validated['db_connection'] === 'mysql') {
            config([
                'database.connections.mysql.host' => $validated['db_host'] ?? '127.0.0.1',
                'database.connections.mysql.port' => $validated['db_port'] ?? '3306',
                'database.connections.mysql.database' => $validated['db_database'] ?? '',
                'database.connections.mysql.username' => $validated['db_username'] ?? 'root',
                'database.connections.mysql.password' => $validated['db_password'] ?? '',
            ]);
        }

        app('db')->purge();
        app('db')->reconnect();
    }

    private function testDatabaseConnection(string $host, string $port, string $database, string $username, string $password): void
    {
        $pdo = new \PDO(
            "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4",
            $username,
            $password,
            [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
        );
    }

    private function runSeeders(): void
    {
        $seeders = [
            \Database\Seeders\RoleSeeder::class,
            \Database\Seeders\CourseModeSeeder::class,
            \Database\Seeders\PaymentMethodSeeder::class,
        ];

        foreach ($seeders as $seederClass) {
            Artisan::call('db:seed', ['--class' => $seederClass, '--force' => true]);
        }
    }
}
