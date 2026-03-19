<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BranchController extends Controller
{
    public function index(): View
    {
        $branches = Branch::orderBy('name')->paginate(15);

        return view('super-admin.branches.index', compact('branches'));
    }

    public function create(): View
    {
        return view('super-admin.branches.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50', 'unique:branches,code'],
            'address' => ['nullable', 'string', 'max:500'],
            'phone' => ['nullable', 'string', 'max:50'],
        ]);

        Branch::create([...$validated, 'is_active' => true]);

        return redirect()->route('super-admin.branches.index')->with('success', 'Branch created.');
    }

    public function edit(Branch $branch): View
    {
        return view('super-admin.branches.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50', 'unique:branches,code,' . $branch->id],
            'address' => ['nullable', 'string', 'max:500'],
            'phone' => ['nullable', 'string', 'max:50'],
            'is_active' => ['boolean'],
        ]);

        $branch->update([...$validated, 'is_active' => $request->boolean('is_active')]);

        return redirect()->route('super-admin.branches.index')->with('success', 'Branch updated.');
    }

    public function show(Branch $branch): RedirectResponse
    {
        return redirect()->route('super-admin.branches.edit', $branch);
    }

    public function destroy(Branch $branch): RedirectResponse
    {
        $branch->delete();

        return redirect()->route('super-admin.branches.index')->with('success', 'Branch removed.');
    }
}
