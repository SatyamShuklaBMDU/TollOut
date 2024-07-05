<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MainCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //


    public function getCategory()
    {
        $categories =MainCategory::where('status',0)->get();
        return response()->json(['data'=>$categories,'status'=>true]);
    }

    // get sub category by id
    public function getSubCategory($id)
    {
        $categories =SubCategory::where('status',0)->where('category_id',$id)->get();
        return response()->json(['data'=>$categories,'status'=>true]);
    }






}
