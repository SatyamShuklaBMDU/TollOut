<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\feedback;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
   
    public function index(){
       
        $categories = feedback::latest()->get();
        return view("category.category",compact("categories"));
    }
    public function reply(Request $request)
    {
       
        $feedback_reply = feedback::find($request->feedbackId);
        $validator = Validator::make($request->all(), [
            'feedbackId' => 'required|exists:feedback,id',
            'reply' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }
        $feedback_reply->reply = $request->reply;
        // $feedback->reply_person_id = auth()->user()->id;
        $feedback_reply->reply_date = now();
        $feedback_reply->save();
        return redirect('/feedback')->with('successs', 'Reply Successfully!');
    }

    public function delete($id)
    {
        $notify = feedback::findOrFail($id);
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
        $categories = feedback::whereBetween('created_at', [$startDate, $endDate])->get();
        return view('category.category', ['categories' => $categories, 'start' => $startDate, 'end' => $endDate]);
    }    
}
