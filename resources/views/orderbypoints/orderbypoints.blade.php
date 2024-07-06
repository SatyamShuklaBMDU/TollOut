@extends('include.master')
@section('style-area')
    <style>
        .dt-button {
            background-color: #f66f01 !important;
            color: white !important;
            border: none !important;
            border-radius: 8px !important;
            box-shadow: 2px 10px 9px 0px #00000063 !important
        }

        .dataTables_wrapper .dataTables_filter input {
            border-radius: 12px !important;
        }

        .table-centered th,
        .table-centered td {
            text-align: center;
            vertical-align: middle;
        }

        /* .dataTables_length label {
                margin-left: 20px;
            } */
        .dataTables_length {
            margin-top: 10px;
        }

        .dataTables_paginate {
            float: none;
            text-align: center;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('content-area')
    <div class="pagetitle">
        <h1>Orders By Coins History</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Home</a></li>
                <li class="breadcrumb-item active">Orders By Coins History</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">   
            <section class="main_content dashboard_part">
                <div class="main_content_iner">
                    <div class="container-fluid plr_30 body_white_bg pt_30">
                        <div class="row justify-content-center" style="margin-top: 20px !important;">
                            <div class="col-lg-12">
                                <div class="row mb" style="margin-bottom: 30px; margin-left: 5px;">
                                    <form action="{{ route('filter-order-by-points') }}" method="post">
                                        @csrf
                                        <div class="row">
                                            @include('admin.date')
                                            <div class="col-sm-1 mt-4" style="margin-left: 10px; margin-top: 0px;">
                                                <a class="btn text-white shadow-lg" href="{{ route('order-by-points') }}"
                                                    style="background-color:#f66f01;box-shadow: 2px 10px 9px 0px #00000063 !important">Reset</a>
                                            </div>
                                            
                                        </div>
                                    </form>
                                </div>
                                <!-- Table -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <div id="tableLength" class="table-control"></div>
                                            <table id="customerTable" class="display nowrap table-centered"
                                                style="width:100%">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>S No.</th>
                                                        <th>Order Date</th>
                                                        <th>User Name</th>
                                                        <th>Email ID</th>
                                                        <th>Phone</th>
                                                        <th>Alternate Phone</th>
                                                        <th>Product Name</th>
                                                        <th>Product Value</th>
                                                        <th>Product Image</th>
                                                        <th>Address</th>
                                                        <th>Pincode</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($orders as $order)
                                                        <tr class="text-center">
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $order->created_at->timezone('Asia/Kolkata')->format('d F Y h:i A') }}
                                                            </td>
                                                            <td>{{ $order->name }}</td>
                                                            <td>{{ $order->email }}</td>
                                                            <td>{{ $order->phone_no }}</td>
                                                            <td>{{ $order->allternate_no ?? '---' }}</td>
                                                            <td>{{ $order->product->name }}</td>
                                                            <td>{{ $order->product->price }}</td> 
                                                            <td>
                                                                <img src="{{ asset($order->product->image) }}"
                                                                    alt=""class="rounded-circle" width="35"
                                                                    height="35">
                                                            </td>
                                                            <td>{{ $order->address }}</td>
                                                            <td>{{ $order->pincode }}</td>
                                                            <td>
                                                                <select name="category" id="" data-user-id="{{$order->id}}" class="form-select change-status-dropdown"style="width:9rem;">
                                                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' :
                                                                    '' }}>Pending</option>
                                                                    <option value="approved" {{ $order->status == 'approved' ? 'selected' :
                                                                    '' }}>Approved</option>
                                                                    <option value="on deliviry" {{ $order->status == 'on delivery' ? 'selected' :
                                                                    '' }}>On Delivery</option>
                                                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' :
                                                                    '' }}>Delivered</option>
                                                                    <option value="cancel" {{ $order->status == 'cancel' ? 'selected' :
                                                                    '' }}>Cancelled
                                                                    </option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                            <div id="tablePagination" class="table-control"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </section>
    </div>
    </section>
@endsection


@section('script-area')
    <script>
        $(document).ready(function() {
            $('#customerTable').DataTable({
                dom: '<"top"Bf>rt<"bottom"lp><"clear">',
                buttons: [
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                }
            ],
                scrollX: true,
                // scrollY: 200,
            });
        });

        $(document).on('change', '.change-status-dropdown', function() {
            var customerId = this.dataset.userId;
            var status = $(this).val();
            console.log(customerId);

            $.ajax({
                url: '{{ Route('point-order-status-update') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    category_id: customerId,
                    status: status
                },
                success: function(response) {
                    Swal.fire({
                        title: "Status Updated Successfully",
                        icon: "success"
                    });
                    table.ajax.reload();
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: "An error occurred while updating the status.",
                    });
                }
            });
        });
    </script>
@endsection
