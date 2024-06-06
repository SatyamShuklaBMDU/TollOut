<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Symfony\Component\HttpFoundation\Response;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::where('is_published', true)->latest()->get();
        return response()->json([
            'status' => true,
            'message' => 'Faq List',
            'data' => $faqs,
        ], Response::HTTP_OK);
    }
}
