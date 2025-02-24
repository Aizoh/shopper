<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function searchFront(Request $request){

        $products = Product::where('name',  $request->name)->get();
        return $products->toArray();
    }
}
