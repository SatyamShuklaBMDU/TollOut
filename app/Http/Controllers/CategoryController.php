<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(){
       
        $categories = Category::latest()->get();
        return view("category.category",compact("categories"));
    }
    public function store(Request $request)
    {
     
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'required|image|max:2048',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageFileName = uniqid() . '.' . $request->image->extension();
            $imagePath = $request->file('image')->move(public_path('Category/'), $imageFileName);
            $imageRelativePath = 'Category/' . $imageFileName;
        }
        $Category = new Category();
        $Category->name = $request->name;
        $Category->image = $imageRelativePath ?? '';
        $Category->save();

        return redirect()->back()->with('success', 'Category created successfully');
    }

    public function edit($id)
    {
        $Category = Category::find($id);
        return $Category;
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $Category = Category::find($request->id);

        $validate = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageFileName = uniqid() . '.' . $request->image->extension();
            $imagePath = $request->file('image')->move(public_path('Category/'), $imageFileName);
            $imageRelativePath = 'Category/' . $imageFileName;
            $Category->image = $imageRelativePath;
        }
        $Category->name = $request->name ? $request->name :$Category->name;
       
        $Category->save();

        return redirect()->back()->with('success', 'Category Updated Successfully');
    }

    public function delete($id)
    {
        $notify = Category::findOrFail($id);
        $notify->delete();
        return response()->json(['success' => true]);
    }

    public function filterdata(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);
        $startDate = $request->start;
        $endDate = $request->end;
        $categories = Category::whereBetween('created_at', [$startDate, $endDate])->get();
        return view('category.category', ['category' => $categories, 'start' => $startDate, 'end' => $endDate]);
    }
    public function updateStatus(Request $request)
    {
        // dD($request->all());
        $category = Category::findOrFail($request->categoryId);
        // dd($category);
        $category->status = $request->status;
        $category->save();

        return response()->json(['message' => 'Status updated successfully']);
    }

    
}
