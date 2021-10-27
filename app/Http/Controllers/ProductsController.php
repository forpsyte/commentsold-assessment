<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProductsController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $cacheTag = 'user.products.' . Auth::id();
        $cacheKey = 'products.' . $request->get('page', '1');
        return Inertia::render('Products/Index', [
            'products' => Cache::tags($cacheTag)->remember($cacheKey, 3600, function () {
                return Auth::user()->products()
                    ->paginate(10)
                    ->withQueryString()
                    ->through(function($product){
                        return [
                            'id' => $product->id,
                            'name' => $product->product_name,
                            'style' => $product->style,
                            'brand' => $product->brand,
                            'skus' => implode(", ", $product->skus)
                        ];
                    });
            })
        ]);
    }

    /**
     * @return Response
     */
    public function create()
    {
        return Inertia::render('Products/Create');
    }

    /**
     * @param SaveProductRequest $request
     * @return RedirectResponse
     */
    public function save(SaveProductRequest $request)
    {
        $validate = $request->validated();
        Auth::user()->products()->create($validate);
        Cache::tags('user.products.' . Auth::id())->flush();
        return Redirect::route('products')->with('success', 'Product created.');
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return RedirectResponse|Response
     */
    public function edit(Request $request, Product $product)
    {
        if (!$request->user()->can('update', $product))
        {
            return Redirect::route('products')->with('error', 'Product does not exist.');
        }

        return Inertia::render('Products/Edit', [
            'product' => $product->toArray()
        ]);
    }

    /**
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validate = $request->validated();
        $product->update($validate);
        Cache::tags('user.products.' . Auth::id())->flush();
        return Redirect::back()->with('success', 'Product updated.');
    }

    /**
     * @param Product $product
     * @return RedirectResponse
     */
    public function delete(Request $request, Product $product)
    {
        if (!$request->user()->can('update', $product))
        {
            return Redirect::route('products')->with('error', 'Product does not exist.');
        }

        $product->delete();
        Cache::tags('user.products.' . Auth::id())->flush();
        return Redirect::route('products')->with('success', 'Product deleted.');
    }
}
