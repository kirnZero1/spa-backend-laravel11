<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        return response([
            "products" => $products
        ]);
    }

    public function show(string $id){
        $product = Product::find($id);
        return response(['product' => $product]);
    }

    public function store(Request $request){
        $fields = $request->validate([
            "name" => "required|string",
            "qty" => "required|integer",
            "price" => "required|decimal:0,2",
            "description" => "nullable"
        ]);

        $product = Product::create([
            "name" => $fields['name'],
            "qty" => $fields['qty'],
            "price" => $fields['price'],
            "description" => $fields['description']
        ]);

        $response = [
            'product' => $product,
            'message' => 'Successfully created a product'
        ];

        return response($response, 201);
    }
    public function update(Request $request, string $id){
        $fields = $request->validate([
            "name" => "required|string",
            "qty" => "required|integer",
            "price" => "required|decimal:0,2",
            "description" => "nullable"
        ]);
        $product = Product::find($id);
        $product->update($fields);
        $response = [
            'product' => $product,
            'message' => 'Successfully updated a product'
        ];

        return response($response, 201);
    }

    public function destroy(string $id){
            $product = Product::destroy($id);
            $response = [
                'message' => 'Successfully deleted a product'
            ];
    
            return response($response, 201);
    }
}
