<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MetaResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return new MetaResource($products);
    }

    public function show($id)
    {
        $payment = Product::find($id);

        return new MetaResource($payment);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'price'   => 'required',
            'image'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $new_product = Product::create([
            'name'     => $request->name,
            'price'   => $request->price,
            'image'   => $request->image,
        ]);

        //return response
        return new MetaResource($new_product);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'price'   => 'required',
            'image'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $product = Product::find($id);

        $product->update($request->all());

        return new MetaResource($product);
    }

    public function destroy($id)
    {

        $product = Product::find($id);

        $product->delete();

        return new MetaResource(null, null, 204);
    }
}
