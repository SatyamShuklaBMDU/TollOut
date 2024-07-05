<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductsForRedeem;
use Illuminate\Http\Request;

class GiftProductController extends Controller
{
    //
    public function index()
    {
        try{
        $gift_products = ProductsForRedeem::where('status',1)->get();
        
        $products=  Array();
        foreach($gift_products as $product){
            
           $giftProduct = [
        'name' => $product->name,
        'image' => asset($product->image),
        'coin' => $product->price,
    ];
                
                $products[]=$giftProduct;
            
        }
        
        
        
        return response()->json(['products'=>$products],200);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
            }

    }
}
