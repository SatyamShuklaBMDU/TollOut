<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::latest()->get();
        return view('Notifications.notification', compact('notifications'));
    }

    public function store(Request $request)
    {
        
        $validate = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageFileName = uniqid() . '.' . $request->image->extension();
            $imagePath = $request->file('image')->move(public_path('Notification/'), $imageFileName);
            $imageRelativePath = 'Notification/' . $imageFileName;
        }
        $notification = new Notification();
        $notification->title = $request->input('title');
        $notification->description = $request->input('message');
        $notification->image = $imageRelativePath ?? '';
        $notification->save();

        return redirect()->back()->with('success', 'Notification created successfully');
    }

    public function edit($id)
    {
        $notification = Notification::find($id);
        return $notification;
    }

    public function update(Request $request)
    {
        $notification = Notification::find($request->id);
        $validate = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageFileName = uniqid() . '.' . $request->image->extension();
            $imagePath = $request->file('image')->move(public_path('Notification/'), $imageFileName);
            $imageRelativePath = 'Notification/' . $imageFileName;
            $notification->image = $imageRelativePath;
        }
        $notification->title = $request->input('title');
        $notification->description = $request->input('message');
        $notification->save();

        return redirect()->back()->with('success', 'Notification updated successfully');
    }

    public function delete($id)
    {
        $notify = Notification::findOrFail($id);
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
        $notifications = Notification::whereBetween('created_at', [$startDate, $endDate])->get();
        return view('Notifications.notification', ['notifications' => $notifications, 'start' => $startDate, 'end' => $endDate]);
    }
}
