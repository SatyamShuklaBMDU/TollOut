<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index(Request $request){

        try{
        $validator=validator::make($request->all(),[
            'subcategory_id'=>'required|exists:sub_categories,id',
            'title'=>'nullable|string',
            'description'=>'nullable|string',
            'country'=>'nullable|string',
            'state'=>'nullable|string',
            'city'=>'nullable|string',
            'address'=>'nullable|string',
            'invoice'=>'required|image|mimes:jpeg,jpg,png,svg|max:2048',
            'image' => 'required|image|mimes:jpeg,jpg,png,svg|max:2048',
        ]);
        if($validator->fails()){
            return response()->json(['status'=> false,'message'=> $validator->errors()],Response::HTTP_BAD_REQUEST);
        }

        if ($request->hasFile('invoice') && $request->file('invoice')->isValid()) {
            $file = $request->file('invoice');
            $fileName = time(). rand(1000, 9999) .'.'.$file->getClientOriginalName();
            $file->move(public_path('invoice'), $fileName);
            $invoice = 'invoice/' . $fileName;
        }
        if ($request->hasFile('image') && $request->file('image')->isValid()){
            $image = $request->file('image');
            $imageName =  time(). rand(1000, 9999) .'.'.$image->getClientOriginalName();
            $image->move(public_path('products'), $imageName);
            $product = 'products/' .  $imageName;
        }

        $products = Product::create([            
            'customer_id' => Auth::id(),
            'subcategory_id'=> $request->subcategory_id,
            'title'=>$request->title,
            'description'=>$request->description,
            'country'=>$request->country,
            'state'=>$request->state,
            'city'=>$request->city,
            'address'=>$request->address,
            'invoice'=>$invoice,
            'image' =>$product,
        ]);
        // $data = $product->toArray();
       $products['invoice']='https://bmdublog.com/TollOut/public/' .$products->invoice;
       $products['image']='https://bmdublog.com/TollOut/public/' .$products->image;

        return response()->json(['status' => true,'message' => 'Product Post Succefully', 'data' => $products, ], Response::HTTP_OK);
    } 
    catch(\Exception $e){
        return response()->json(['message'=>$e->getMessage()],Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
    public function getproduct(){
        try {
        $products = Product::latest()->get();

            foreach($products as $product){
                $product['invoice']='https://bmdublog.com/TollOut/public/' .$product->invoice;
                $product['image']='https://bmdublog.com/TollOut/public/' .$product->image;
            }
                return response()->json(['status' => true, 'data' => $products], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function customerproduct(Request $request){
        try {
            $id = Auth::id();
            $products = Product::where('customer_id',$id)->get();
            if(!$products->isEmpty()){
                foreach($products as $product){
                    $product['invoice']='https://bmdublog.com/TollOut/public/' .$product->invoice;
                    $product['image']='https://bmdublog.com/TollOut/public/' .$product->image;
                }
                return response()->json(['status' => true, 'message'=>"Product fetched Successfully",'data' => $products], Response::HTTP_OK);
            }else{
                return response()->json(['status' => false, 'message'=>"You don't have any post.",'data' => $products], Response::HTTP_OK);
            }
                
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
