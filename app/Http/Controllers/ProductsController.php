<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProductsController extends Controller
{
    /**
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Products/Index', [
            'products' => Auth::user()->products()
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

        return Redirect::route('products')->with('success', 'Product created.');
    }

    /**
     * @param Product $product
     * @return RedirectResponse|Response
     */
    public function edit(Product $product)
    {
        if (Auth::user()->id !== $product->user_id) {
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
        if (Auth::user()->id !== $product->user_id) {
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

        return Redirect::back()->with('success', 'Product updated.');
    }

    /**
     * @param Product $product
     * @return RedirectResponse
     */
    public function delete(Product $product)
    {
        if (Auth::user()->id !== $product->user_id) {
            return Redirect::route('products')->with('error', 'Product does not exist.');
        }

        $product->delete();
        return Redirect::route('products')->with('success', 'Product deleted.');
    }
}
