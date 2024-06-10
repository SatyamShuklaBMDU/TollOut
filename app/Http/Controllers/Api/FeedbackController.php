<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

                                   

class FeedbackController extends Controller
{
    public function index(Request $request){
        // dd($request->all());
        $validator=validator::make($request->all(),[
            'subject' => 'required',
            'message' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['status'=> false,'message'=> $validator->errors()],400);
        }
        $feedback = feedback::create([            
            'customer_id' => Auth::id(),
            'subject' => $request->subject,
            'message' => $request->message,
        ]);
        if ($feedback) {
            return response()->json(['message' => 'Your Feedback has been Submitted Successfully', 'status' => true], 200);
        } else {
            return response()->json(['message' => 'failed', 'status' => false], 500);
        }
    }
    public function GetFeedback(){
        $feedback = feedback::where('customer_id',Auth::id())->get();
        dd($feedback);
        if($feedback){
            return response()->json(['status' => true, 'message' => 'Feedback get successfully', 'feedback' => $feedback],200);
        }
        else{
        return response()->json(['status' => false, 'message' => 'Feedback not found'],400);
        }
    }
}
