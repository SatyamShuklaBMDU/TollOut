<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\customer;
use Yajra\DataTables\Facades\Datatables;

class UserController extends Controller
{
    public function users()
    {
        $users = customer::all();
        return view("admin.all_users", compact("users"));
    }
    public function filter(Request $request)
    {
        // dd($request);
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);
        $start = $request->start;
        $end = $request->end;
        $users = customer::whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.all_users', compact('users', 'start', 'end'));
    }
    public function show()
    {

        // $users = customer::all();
        return view('admin.all_users', compact('users'));
    }
    public function userreportshow()
    {
        if (request()->ajax()) {
            $data = customer::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('profile', function($row) {
                    $imageUrl = asset($row->profile);
                    if (!empty($row->profile) && file_exists(public_path($row->profile))) {
                        return '<img src="' . $imageUrl . '" alt="Profile Picture" width="50" height="50">';
                    } else {
                        return 'Profile Not Found';
                    }
                })
                ->editColumn('created_at', function($row) {
                    return date('d-m-Y', strtotime($row->created_at));
                })
                ->editColumn('status', function ($row) {
                    $statusDropdown = '<select class="form-select change-status-dropdown" data-customer-id="' . $row->id . '">
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
