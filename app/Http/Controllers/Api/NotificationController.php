<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Symfony\Component\HttpFoundation\Response;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::latest()->get();
        $baseUrl = 'https://bmdublog.com/TollOut/public/';
        $notifications->each(function ($item) use ($baseUrl) {
            $item->image = $baseUrl . $item->image;
        });
        if ($notifications->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'No Notification found.'], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'Notification Fetch Successfully.',
            'notifications' => $notifications,
        ], Response::HTTP_OK);
    }
}
