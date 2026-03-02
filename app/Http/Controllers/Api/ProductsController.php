<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Product::class, 'product');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::filter($request->query())
            ->with(['category:id,name', 'store:id,name', 'tags'])
            ->paginate();

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'store_id' => 'required|exists:stores,id',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:active,inactive',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|gt:price',
        ]);

        $user = $request->user();
        if (!$user->tokenCan('products.create')) {
            abort(403, 'Not allowed');
        }

        return Product::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string|max:255',
            'store_id' => 'sometimes|required|exists:stores,id',
            'category_id' => 'sometimes|required|exists:categories,id',
            'status' => 'sometimes|required|in:active,inactive',
            'price' => 'sometimes|required|numeric|min:0',
            'compare_price' => 'nullable|numeric|gt:price',
        ]);

        $user = $request->user();
        if (!$user->tokenCan('products.update')) {
            abort(403, 'Not allowed');
        }

        $product->update($request->all());

        return Response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user->tokenCan('products.delete')) {
            abort(403, 'Not allowed');
        }

        Product::destroy($product);
        return response()->noContent();
    }
}
