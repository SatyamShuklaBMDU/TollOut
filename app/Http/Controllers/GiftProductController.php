<?php

namespace App\Http\Controllers;

use App\Models\ProductsForRedeem;
use Illuminate\Http\Request;

class GiftProductController extends Controller
{
    //

    public function index()
    {
        $products=ProductsForRedeem::all();
        return view('gift-product.index',compact('products'));
    }

    public function addProduct(Request $request){
        $request->validate([
            'name'=>'required',
            'image'=>'required',
            'price'=>'required',
        ]);
        $product=new ProductsForRedeem();
        $product->name=$request->name;


        $image = $request->file('image');
                $image_name = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('ProductGiftimages'), $image_name);
            $image_path = 'ProductGiftimages/' . $image_name;
            $product->image=$image_path;
        
        // }
        $product->price=$request->price;
        $product->save();
        return redirect()->back()->with('success','Product Added Successfully');

        // return $request->all();
        }




        public function update($productsForRedeem,Request $request){

            // dd($request->image);
            $productsForRedeems=ProductsForRedeem::where('id',$productsForRedeem)->first();

            $productsForRedeems->name=$request->name;
            $productsForRedeems->price=$request->price;

            if($request->hasFile('image')){
                $image = $request->file('image');
                $image_name = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('ProductGiftimages'), $image_name);
                $image_path = 'ProductGiftimages/' . $image_name;
                $productsForRedeems->image=$image_path;
            }
            $productsForRedeems->update();


            return redirect()->back()->with('success','Product Update Successfully');
        }


        public function delete($productsForRedeem){


            $productsForRedeems=ProductsForRedeem::where('id',$productsForRedeem)->first();
            $productsForRedeems->delete();


            return redirect()->back()->with('success','Product Delete Successfully');



        }




}
