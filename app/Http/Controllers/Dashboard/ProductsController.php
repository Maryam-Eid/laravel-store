<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ProductRequest;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.products.index',
            [
                'products' => Product::with(['category', 'store'])->paginate()
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(Product $product)
    {
        return view('dashboard.products.edit', [
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->except('tags'));

        $tags = json_decode($request->post('tags'));

        if (empty($tags)) {
            $product->tags()->detach();
        } else {
            $tag_ids = [];

            foreach ($tags as $item) {
                $slug = Str::slug($item->value);
                $tag = Tag::firstOrCreate(
                    ['slug' => $slug],
                    ['name' => $item->value, 'slug' => $slug]
                );
                $tag_ids[] = $tag->id;
            }

            $product->tags()->sync($tag_ids);
        }

        return redirect()->route('dashboard.products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
