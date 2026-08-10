<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TaskCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $pageTitle = 'Task Categories';
        $categories = TaskCategory::latest()->paginate(getPaginate());
        return view('admin.category.index', compact('pageTitle', 'categories'));
    }

    public function store(Request $request, $id = null)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:task_categories,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $category = $id ? TaskCategory::findOrFail($id) : new TaskCategory();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->description = $request->description;
        $category->icon = $request->icon ?? 'fas fa-tasks';
        $category->status = $request->status ?? 1;
        $category->save();

        $message = $id ? 'Category updated.' : 'Category created.';
        return back()->with('success', $message);
    }

    public function toggleStatus($id)
    {
        $category = TaskCategory::findOrFail($id);
        $category->status = $category->status == 1 ? 0 : 1;
        $category->save();
        return back()->with('success', 'Category status updated.');
    }

    public function delete($id)
    {
        $category = TaskCategory::findOrFail($id);
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }
}
