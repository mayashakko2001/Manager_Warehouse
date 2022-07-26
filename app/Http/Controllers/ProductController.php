<?php

namespace App\Http\Controllers;

use Exception;
use Faker\Core\File;
use App\Models\Product;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Controllers\ApiController;
use App\Http\Resources\ProductRecource;
use Illuminate\Support\Facades\Storage;


class ProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  $this->success(ProductRecource::collection(Product::all()), 200);
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
    public function store(ProductRequest $request)
    {
        
        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('/public/products');
        }
            
            $product = Product::create([
            'department_id' => $request->input('department_id'),
            'name' => $request->input('name'),
            'image_path' => $path,
            'product_code' => $request->input('product_code'),
            'purchasing_price' => $request->input('purchasing_price'),
            'seling_price' => $request->input('seling_price'),
            'note' => $request->input('note')
        ]);

        return $this->success(new ProductRecource($product), 200, 'Added Product successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {

        try {
            $product = Product::find($product);

            return $this->success(new ProductRecource($product), 200);

        } catch (Exception $ex) {
            return $this->error(['id not founde'], 'The Product of this id cannot be found', 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request,$product)
    {
        $product = Product::find($product);

        if ($product) {

            if ($request->hasFile('image_path')) {
                $path = $request->file('image_path')->store('/public/products');
            }

            $product->update([
                'department_id' => $request->input('department_id'),
                'name' => $request->input('name'),
                'image_path' => $path,
                'product_code' => $request->input('product_code'),
                'purchasing_price' => $request->input('purchasing_price'),
                'seling_price' => $request->input('seling_price'),
                'note' => $request->input('note')
            ]);
            return $this->success(new ProductRecource($product), 200, 'product updated successfully');
        } 
        else {
            return $this->error('id not founde', 'The product of this id cannot be found', 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($product)
    {
        $product = Product::find($product);
        if ($product) {
           
            $product->delete();

            return $this->responseDelete();
        } else {
            return $this->error('id not founde', 'The product of this id cannot be found', 404);
        }
    }
}
