<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Product;
use Validator;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        return $this->sendResponse($products->toArray(), 'Products successfully retrieved.');
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
    public function store(Request $request)
    {
        $input -> $request->all();

        $validate = Validator::make($input, [
            'name' => 'required',
            'details' => 'required'
        ]);

        if ($validate->fails()) {
            return $this->sendError('Validation Error', $validate->errors());
        }

        $product = Product::create($input);

        return $this->sendResponse($product->toArray(), 'Product Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if(is_null($product)) {
            return $this->sendError('Product not found!');
        }
        
        return $this->sendResponse($product->toArray(), 'Product successfully retrieved.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $input = $request->all();

        $validate = Validator::make($input, [
            'name' => 'required',
            'details' => 'required'
        ]);

        if ($validate->fails()) {
            return $this->sendError('Validation Error', $validate->errors());
        }

        $product->name = $input['name'];
        $product->details = $input['details'];
        $product->save();
        
        return $this->sendResponse($product->toArray(), 'Product Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return $this->sendResponse($product->toArray(), 'Product deleted successfully.');
    }
}
