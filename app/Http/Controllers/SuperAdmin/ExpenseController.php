<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExpenseController extends Controller
{
    public function index(Request $request): View
    {
        $expenses = Expense::with('branch', 'recorder')
            ->when($request->filled('type'), fn ($q) => $q->where('type', $request->type))
            ->when($request->filled('branch'), fn ($q) => $q->where('branch_id', $request->branch))
            ->latest('expense_date')
            ->paginate(15)
            ->withQueryString();

        $branches = Branch::where('is_active', true)->orderBy('name')->get();

        return view('super-admin.expenses.index', compact('expenses', 'branches'));
    }

    public function create(): View
    {
        $branches = Branch::where('is_active', true)->orderBy('name')->get();
        $instructors = User::whereHas('role', fn ($q) => $q->where('name', 'Instructor'))
            ->with('userDetail')
            ->where('is_active', true)
            ->orderBy('email')
            ->get();
        $admins = User::whereHas('role', fn ($q) => $q->where('name', 'Admin'))
            ->with('userDetail')
            ->where('is_active', true)
            ->orderBy('email')
            ->get();
        $selectedPayee = old('payee_user_id') ? User::with('userDetail')->find(old('payee_user_id')) : null;

        return view('super-admin.expenses.create', compact('branches', 'instructors', 'admins', 'selectedPayee'));
    }

    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'type' => ['required', 'string', 'in:salary,lab_maintenance,server,other'],
            'description' => ['nullable', 'string', 'max:500'],
            'amount' => ['required', 'numeric', 'min:0'],
            'expense_date' => ['required', 'date'],
            'branch_id' => ['nullable', 'integer', 'exists:branches,id'],
        ];
        if ($request->input('type') === 'salary') {
            $rules['payee_user_id'] = ['required', 'integer', 'exists:users,id'];
            $rules['payee_name'] = ['required', 'string', 'max:255'];
        }
        $validated = $request->validate($rules);

        Expense::create([
            ...$validated,
            'payee_user_id' => $request->input('type') === 'salary' ? $request->input('payee_user_id') : null,
            'payee_name' => $request->input('type') === 'salary' ? $request->input('payee_name') : null,
            'recorded_by' => auth()->id(),
        ]);

        return redirect()->route('super-admin.expenses.index')->with('success', 'Expense recorded.');
    }

    public function edit(Expense $expense): View
    {
        $this->authorizeSuperAdmin();
        $expense->load('payee.userDetail');
        $branches = Branch::where('is_active', true)->orderBy('name')->get();
        $instructors = User::whereHas('role', fn ($q) => $q->where('name', 'Instructor'))
            ->with('userDetail')
            ->where('is_active', true)
            ->orderBy('email')
            ->get();
        $admins = User::whereHas('role', fn ($q) => $q->where('name', 'Admin'))
            ->with('userDetail')
            ->where('is_active', true)
            ->orderBy('email')
            ->get();

        return view('super-admin.expenses.edit', compact('expense', 'branches', 'instructors', 'admins'));
    }

    public function update(Request $request, Expense $expense): RedirectResponse
    {
        $this->authorizeSuperAdmin();
        $rules = [
            'type' => ['required', 'string', 'in:salary,lab_maintenance,server,other'],
            'description' => ['nullable', 'string', 'max:500'],
            'amount' => ['required', 'numeric', 'min:0'],
            'expense_date' => ['required', 'date'],
            'branch_id' => ['nullable', 'integer', 'exists:branches,id'],
        ];
        if ($request->input('type') === 'salary') {
            $rules['payee_user_id'] = ['required', 'integer', 'exists:users,id'];
            $rules['payee_name'] = ['required', 'string', 'max:255'];
        }
        $validated = $request->validate($rules);

        $expense->update([
            ...$validated,
            'payee_user_id' => $request->input('type') === 'salary' ? $request->input('payee_user_id') : null,
            'payee_name' => $request->input('type') === 'salary' ? $request->input('payee_name') : null,
        ]);

        return redirect()->route('super-admin.expenses.index')->with('success', 'Expense updated.');
    }

    public function destroy(Expense $expense): RedirectResponse
    {
        $this->authorizeSuperAdmin();
        $expense->delete();

        return redirect()->route('super-admin.expenses.index')->with('success', 'Expense deleted.');
    }

    private function authorizeSuperAdmin(): void
    {
        if (auth()->user()->role?->name !== 'SuperAdmin') {
            abort(403, 'Only Super Admin can edit or delete expenses.');
        }
    }
}
