<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Product::get(),200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request, Product $product)
    {
    //    return $request->all();
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        if($request->hasFile('image')){
            $name = $request->image->getClientOriginalName();
            $request->image->move(public_path('/product'), $name);
            $product->image = 'product/' . $name;
        }
        if($product->save()){
            return response()->json(['message' => 'Product created'],200);
        }
        return response()->json(['message' => 'Failed to create product'],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        if(is_null($product)){
            return response()->json(['message' => 'Failed to create product'],404);
        }
        return response()->json($product,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request)
    {
        $product = Product::find($request->id);
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        if($request->hasFile('image')){
            if(file_exists($product->image)){
                    @unlink($product->image);
            }
            $name = $request->image->getClientOriginalName();
            $request->image->move(public_path('/product'), $name);
            $product->image = 'product/' . $name;
        }

        if($product->save()){
            return response()->json(['message' => 'Product updated'],200);
        }
        return response()->json(['message' => 'Failed to update product'],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $product = Product::find($id);
        if(file_exists($product->image)){
            @unlink($product->image);
        }
        if($product->delete()){
            return response()->json(['message' => 'Product Deleted'],200);
        }
    }
}
