<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\importProduct;
use App\Models\inventoryProduct;
use App\Http\Requests\ImportsRequest;
use App\Http\Requests\importProductRequest;
use App\Http\Resources\ImportProductResource;

use function PHPUnit\Framework\isEmpty;

class import_productsController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  $this->success(ImportProductResource::collection(Importproduct::all()), 200);
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
    public function store(importProductRequest $request)
    {
        // adding the imported product to inventory_product table

        $inventory_product = inventoryProduct::where('product_id',$request->product_id)->first();
        
        // if it already existes just pluse the quantity number than we have added to the old one
        if ($inventory_product) {
            $inventory_product->quantity +=$request->quantity;

            $inventory_product->update();
        }else{
            inventoryProduct::create([
                'product_id'=> $request->product_id,
                'quantity'=> $request->quantity
            ]);
        }
        
        //if id_product is already existes in import_product_table just pluse the quantity

        $ip = importProduct::where('import_id',$request->import_id)->where('product_id',$request->product_id)->get();

        if(!$ip->isEmpty()){
            $importProduct = importProduct::where('product_id',$request->product_id)->where('import_id',$request->import_id)->first();
            $importProduct->quantity += $request->quantity;
            $importProduct->update();
            return $this->success(new ImportProductResource($importProduct), 200, 'Updated InventoryProduct successfully');
           }else{

                $importProduct = importProduct::create($request->all());
           }
           
    
        return $this->success(new ImportProductResource($importProduct), 200, 'Added InventoryProduct successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($import_id)
    {   
        try {
            $import = importProduct::where('import_id',$import_id)->get();
            
            return $this->success(ImportProductResource::collection($import), 200);
        } catch (Exception $ex) {
            return $this->error(['id not founde'], 'The import of this id cannot be found', 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($import_id)
    {
        try {
            $import = importProduct::where('import_id',$import_id)->get();
            
            return $this->success(ImportProductResource::collection($import), 200);
        } catch (Exception $ex) {
            return $this->error(['id not founde'], 'The import of this id cannot be found', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(importProductRequest $request, $import_product_id)
    {

        $import_product_id = importProduct::find($import_product_id);
        if ($import_product_id) {
            $import_product_id->update($request->all());
            return $this->success(new ImportProductResource($import_product_id), 200, 'import updated successfully');
        } else {
            return $this->error('id not founde', 'The import of this id cannot be found', 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($import_product_id)
    {
        $import_product_id = importProduct::find($import_product_id);
        if ($import_product_id) {
            $import_product_id->delete();
            return $this->responseDelete();
        } else {
            return $this->error('id not founde', 'The ImportProduct of this id cannot be found', 404);
        }
    }
}
