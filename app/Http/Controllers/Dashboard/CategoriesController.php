<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
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
        return view('dashboard.categories.index',
            [
                'categories' => Category::all()
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
    public function store(Request $request)
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
    public function show(string $id)
    {
        //
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
    public function update(Request $request, Category $category)
    {
        $old_image = $category->image;

        $request->merge([
            'slug' => str::slug($request['name'])
        ]);

        $data = $request->except('image');

        $data['image'] = $this->uploadImage($request);

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

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        return redirect()->route('dashboard.categories.index')
            ->with('success', 'Category deleted successfully!');
    }

    protected function uploadImage(Request $request)
    {
        if (!$request->hasFile('image')) return;

        return $request->file('image')->store('uploads', 'public');

    }
}
