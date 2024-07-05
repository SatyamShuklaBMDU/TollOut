<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\MainCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index($cat){
        $category=MainCategory::where('id',$cat)->get();
        $subcategories =SubCategory::where('category_id',$cat)->get();

        // $subcategories=$category->subcategory;

        // dd($subcategories);
        return view('subcategories.index', compact( 'subcategories','category'));
    }


    public function changeStatus(Request $request)
    {
        $category = SubCategory::findOrFail($request->category_id);
        $category->status = $request->status;
        $category->save();
        return response()->json(['success' => 'Status updated successfully!']);
    }




}
