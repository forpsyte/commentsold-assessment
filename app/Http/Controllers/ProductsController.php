<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProductsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function index(\Illuminate\Http\Request $request)
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
     * @return RedirectResponse
     */
    public function save()
    {
        Auth::user()->products()->create(
            Request::validate([
                'product_name' => ['required', 'max:128'],
                'description' => ['required', 'max:512'],
                'style' => ['required', 'max:32'],
                'brand' => ['required', 'max:32'],
                'url' => ['nullable', 'max:256'],
                'product_type' => ['required', 'max:255'],
                'shipping_price' => ['required', 'integer'],
                'note' => ['nullable', 'max:512']
            ])
        );

        Cache::tags('user.products.' . Auth::id())->flush();
        return Redirect::route('products')->with('success', 'Product created.');
    }

    /**
     * @param Product $product
     * @return RedirectResponse|Response
     */
    public function edit(Product $product)
    {
        if (Auth::id() !== $product->user_id) {
            return Redirect::route('products')->with('error', 'Product does not exist.');
        }

        return Inertia::render('Products/Edit', [
            'product' => [
                'id' => $product->id,
                'name' => $product->product_name,
                'description' => $product->description,
                'style' => $product->style,
                'brand' => $product->brand,
                'url' => $product->url,
                'type' => $product->product_type,
                'shipping_price' => strval($product->shipping_price),
                'note' => $product->note,
            ]
        ]);
    }

    /**
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(Product $product)
    {
        if (Auth::id() !== $product->user_id) {
            return Redirect::route('products')->with('error', 'Product does not exist.');
        }

        $product->update(
            Request::validate([
                'product_name' => ['required', 'max:128'],
                'description' => ['required', 'max:512'],
                'style' => ['required', 'max:32'],
                'brand' => ['required', 'max:32'],
                'url' => ['nullable', 'max:256'],
                'product_type' => ['required', 'max:255'],
                'shipping_price' => ['required', 'integer'],
                'note' => ['nullable', 'max:512']
            ])
        );

        Cache::tags('user.products.' . Auth::id())->flush();
        return Redirect::back()->with('success', 'Product updated.');
    }

    /**
     * @param Product $product
     * @return RedirectResponse
     */
    public function delete(Product $product)
    {
        if (Auth::id() !== $product->user_id) {
            return Redirect::route('products')->with('error', 'Product does not exist.');
        }

        $product->delete();
        Cache::tags('user.products.' . Auth::id())->flush();
        return Redirect::route('products')->with('success', 'Product deleted.');
    }
}
