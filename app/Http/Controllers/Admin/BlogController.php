<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Website Operations: Blog CRUD (admin).
 */
class BlogController extends Controller
{
    /**
     * Fetching all blogs for admin list (latest first).
     */
    public function index(Request $request): View
    {
        $blogs = Blog::with('author.userDetail')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.blogs.index', compact('blogs'));
    }

    public function create(): View
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:blogs,slug'],
            'content' => ['nullable', 'string'],
            'status' => ['required', 'string', 'in:draft,published'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $slug = $validated['slug'] ?? Str::slug($validated['title']);
        // Ensure unique slug when auto-generated
        if (empty($validated['slug']) && Blog::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . now()->format('YmdHis');
        }

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('blogs', 'public');
        }

        Blog::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'content' => $validated['content'] ?? '',
            'status' => $validated['status'],
            'image' => $path,
            'author_id' => auth()->id(),
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog created.');
    }

    public function edit(Blog $blog): View
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:blogs,slug,' . $blog->id],
            'content' => ['nullable', 'string'],
            'status' => ['required', 'string', 'in:draft,published'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $slug = $validated['slug'] ?? Str::slug($validated['title']);
        if (empty($validated['slug']) && Blog::where('slug', $slug)->where('id', '!=', $blog->id)->exists()) {
            $slug = $slug . '-' . $blog->id;
        }

        $path = $blog->image;
        if ($request->hasFile('image')) {
            if ($blog->image && Storage::disk('public')->exists($blog->image)) {
                Storage::disk('public')->delete($blog->image);
            }
            $path = $request->file('image')->store('blogs', 'public');
        }

        $blog->update([
            'title' => $validated['title'],
            'slug' => $slug,
            'content' => $validated['content'] ?? '',
            'status' => $validated['status'],
            'image' => $path,
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog updated.');
    }

    public function destroy(Blog $blog): RedirectResponse
    {
        if ($blog->image && Storage::disk('public')->exists($blog->image)) {
            Storage::disk('public')->delete($blog->image);
        }
        $blog->delete();
        return redirect()->route('admin.blogs.index')->with('success', 'Blog deleted.');
    }
}
