<?php

namespace App\Http\Controllers;

use App\Http\Requests\importProductRequest;
use Exception;
use App\Models\Import;
use Illuminate\Http\Request;
use App\Models\importProduct;
use function PHPSTORM_META\map;
use App\Models\inventoryProduct;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\ImportsRequest;
use App\Http\Resources\ImportProductResource;
use App\Http\Resources\ImportsResource;
use App\Models\Product;

class ImportsController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return  $this->success(ImportsResource::collection(Import::all()), 200);
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
    public function store(ImportsRequest $request)
    {
        $import = Import::create([
            'bill_number' => $request->bill_number,
            'shipping_charge_price' => $request->shipping_charge_price,
            'dealer_id' => $request->dealer_id,
        ]);

        $productPriceTotal = 0;

        foreach ($request->products as $product) {


            $inventory_product = inventoryProduct::where('product_id', $product['id'])->first();

            // if it already existes just pluse the quantity number than we have added to the old one
            if ($inventory_product) {
                $inventory_product->quantity += $product['quantity'];
                $inventory_product->update();
            } else {
                inventoryProduct::create([
                    'product_id' => $product['id'],
                    'quantity' => $product['quantity']
                ]);
            }

            $ip = importProduct::where('import_id', $import->id)->where('product_id', $product['id'])->first();
            if ($ip) {
                $ip->quantity += $product['quantity'];
                $ip->update();
                $productPriceTotal += $ip->product->seling_price * $product['quantity'];
            } else {

                $importProduct = importProduct::create([
                    'import_id' => $import->id,
                    'product_id' => $product['id'],
                    'quantity' => $product['quantity'],
                ]);
                $productPriceTotal += $importProduct->product->seling_price * $importProduct->quantity;
            }
        }

        $import->total_price = $productPriceTotal + $import->shipping_charge_price;
        $import->update();
        return $this->success(new ImportsResource($import), 200, 'Added import successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($import)
    {
        try {
            $import = Import::find($import);

            return $this->success(new ImportsResource($import), 200);
        } catch (Exception $ex) {
            return $this->error(['id not founde'], 'The Import of this id cannot be found', 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($import)
    {
        try {
            $import = Import::find($import);

            return $this->success(new ImportsResource($import), 200);
        } catch (Exception $ex) {
            return $this->error(['id not founde'], 'The Import of this id cannot be found', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ImportsRequest $request, $import)
    {
        $import = Import::find($import);
        if ($import) {
            $import->update([
                [
                    'bill_number' => $request->bill_number,
                    'shipping_charge_price' => $request->shipping_charge_price,
                    'dealer_id' => $request->dealer_id,
                    'total_price' => null,
                ]
            ]);
            return $this->success(new ImportsResource($import), 200, 'import updated successfully');
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
    public function destroy($import)
    {
        $import = Import::find($import);
        if ($import) {
            $import->delete();
            return $this->responseDelete();
        } else {
            return $this->error('id not founde', 'The Import of this id cannot be found', 404);
        }
    }
}
