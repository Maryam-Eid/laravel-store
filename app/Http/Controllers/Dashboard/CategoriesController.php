<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.categories.index', [
            'categories' => Category::query()
                ->with('parent')
                ->when(request()->filled('name'), function ($query) {
                    $query->where('name', 'LIKE', '%' . request('name') . '%');
                })
                ->when(request()->filled('status'), function ($query) {
                    $query->whereStatus(request('status'));
                })
                ->withCount('products')
                ->orderBy('name')
                ->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.categories.create',
            [
                'categories' => Category::all(),
                'parents' => Category::all()
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $request->merge([
            'slug' => str::slug($request['name'])
        ]);

        $data = $request->except('image');

        $data['image'] = $this->uploadImage($request);

        Category::create($data);

        return redirect()->route('dashboard.categories.index')
            ->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('dashboard.categories.show', [
            'category' => $category,
            'products' => $category->products()->with('store')->latest()->paginate(5)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('dashboard.categories.edit',
            [
                'category' => $category,
                'parents' => Category::where('id', '<>', $category->id)
                    ->where(function ($q) use ($category) {
                        $q->whereNotNull('parent_id')
                            ->orwhere('parent_id', '<>', $category->id);
                    })
                    ->get()
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $old_image = $category->image;

        $request->merge([
            'slug' => str::slug($request['name'])
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request);
        }

        $category->update($data);

        if ($old_image && isset($data['image'])) {
            Storage::disk('uploads')->delete($old_image);
        }

        return redirect()->route('dashboard.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('dashboard.categories.index')
            ->with('success', 'Category deleted successfully!');
    }

    protected function uploadImage(Request $request)
    {
        if (!$request->hasFile('image')) return;

        return $request->file('image')->store('uploads', 'public');

    }

    public function trash()
    {
        return view('dashboard.categories.trash',
            [
                'categories' => Category::onlyTrashed()->paginate(10)
            ]);
    }

    public function restore($id)
    {
        Category::onlyTrashed()->findOrFail($id)->restore();

        return redirect()->route('dashboard.categories.trash')
            ->with('success', 'Category restored successfully!');
    }

    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->forceDelete();

        return redirect()->route('dashboard.categories.trash')
            ->with('success', 'Category deleted forever!');
    }
}
