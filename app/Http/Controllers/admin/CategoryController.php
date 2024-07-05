<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use App\Models\SubCategory;

class CategoryController extends Controller
{

    public function index(){
        $categories=MainCategory::all();
        return view('category.index',compact('categories'));
    }

    public function changeStatus(Request $request)
    {
        $category = MainCategory::findOrFail($request->category_id);
        $category->status = $request->status;
        $category->save();

        if($category->status == "1"){
            SubCategory::where('category_id', $category->id)->update(['status'=>'1']);
        }

        return response()->json(['success' => 'Status updated successfully!']);
    }

}
