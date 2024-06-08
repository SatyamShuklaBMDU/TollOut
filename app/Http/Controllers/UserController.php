<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\customer;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function users()
    {
        $users = customer::latest()->get();
        return view("admin.all_users", compact("users"));
    }
    // public function filter(Request $request)
    // {
    //     // dd($request);
    //     $request->validate([
    //         'start' => 'required|date',
    //         'end' => 'required|date|after_or_equal:start',
    //     ]);
    //     $start = $request->start;
    //     $end = $request->end;
    //     $users = customer::whereDate('created_at', '>=', $start)
    //         ->whereDate('created_at', '<=', $end)
    //         ->orderBy('created_at', 'desc')
    //         ->get();
    //     return view('admin.all_users', compact('users', 'start', 'end'));
    // }
    public function show()
    {

        // $users = customer::all();
        return view('admin.all_users', compact('users'));
    }
    public function userreportshow(Request $request)
    {
        if ($request->ajax()) {
            $query = customer::query();
    
            // Check if date range is provided
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $startDate = $request->start_date;
                $endDate = $request->end_date;
    
                // Filter records based on the provided date range
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
    
            // Apply search filter if provided
            if ($request->has('search') && $request->search['value']) {
                $search = $request->search['value'];
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('customer_id', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            }
    
            $data = $query->latest()->get();
            return \Yajra\DataTables\Facades\DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('profile', function ($row) {
                    $imageUrl = asset($row->profile);
                    if (!empty($row->profile) && file_exists(public_path($row->profile))) {
                        return '<a href="'.$imageUrl.'" class="profile-link" data-toggle="modal" target="_blank"data-target="#profileModal"">
                                    <img src="' . $imageUrl . '" alt="Profile Picture" class="rounded-circle" width="35" height="35">
                                </a>';
                    } else {
                        $image = asset('images/no-profile-picture-15257.png');
                        return '<img src="'.$image.'"class="rounded-circle" width="35" height="35"</img>';
                    }
                })
                ->editColumn('created_at', function ($row) {
                    return date('d F Y', strtotime($row->created_at));
                })
                ->editColumn('status', function ($row) {
                    $statusDropdown = '<select style="width:7rem;display: flex;justify-content: center;"class="form-select change-status-dropdown" data-customer-id="' . $row->id . '">
                                        <option value="1"' . ($row->status == 1 ? ' selected' : '') . '>Active</option>
                                        <option value="0"' . ($row->status == 0 ? ' selected' : '') . '>Inactive</option>
                                    </select>';
                    return $statusDropdown;
                })
                ->rawColumns(['profile', 'status']) // Ensure 'profile' and 'status' are treated as raw HTML
                ->make(true);
        }
        return view('admin.all_users');
    }
    

    public function changeStatus(Request $request)
    {
        $customer = customer::findOrFail($request->customer_id);
        $customer->status = $request->status;
        $customer->save();

        return response()->json(['success' => 'Status updated successfully!']);
    }
}
