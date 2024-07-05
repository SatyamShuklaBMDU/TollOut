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
    @php
        use App\Models\Points;

    @endphp
    <div class="pagetitle">
        <h1>User Earn Coins</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Home</a></li>
                <li class="breadcrumb-item active">User Earn Coins</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-md-6 ms-1">
                <a class="btn shadow btn-xs sharp me-1 text-white" href="{{ url()->previous() }}"
                    style=" width: 65px;height: 36px;text-align: center;font-size:1rem;box-shadow: 2px 10px 9px 0px #00000063 !important;line-height:normal;background: #033496;">Back</a>
            </div>
            <section class="main_content dashboard_part">
                <div class="main_content_iner">
                    <div class="container-fluid plr_30 body_white_bg pt_30">
                        <div class="row justify-content-center" style="margin-top: 20px !important;">
                            <div class="col-lg-12">
                                {{-- <div class="row mb" style="margin-bottom: 30px; margin-left: 5px;">

                                    
                                </div> --}}
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
                                                        <th>CIN No.</th>
                                                        <th>Name</th>
                                                        <th>Total Earned</th>
                                                        <th>Available Coin</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($points as $point)
                                                        <tr class="text-center">
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>

                                                                @php
                                                                    $user_id = $point->user_id;
                                                                    $user = App\Models\customer::where(
                                                                        'id',
                                                                        $user_id,
                                                                    )->first();
                                                                @endphp


                                                                {{ $user->customer_id }}</td>
                                                            {{-- <td><img src="{{asset($product->image)}}" alt="" srcset="" width="50px"></td> --}}

                                                            <td>
                                                                <a href="{{ url('/points/show/' . $user->id) }}">
                                                                    {{ $user->name }}
                                                            </td>
                                                            {{-- <td><img src="{{asset($product->image)}}" alt="" srcset="" width="50px"></td> --}}
                                                            </a>
                                                            <td>
                                                                @php
                                                                    $total = 0;
                                                                    $total = Points::where(
                                                                        'user_id',
                                                                        $point->user_id,
                                                                    )->sum('points');
                                                                @endphp

                                                                {{ $total }}</td>


                                                            <td>

                                                                @php
                                                                    $redeem_points = Points::where(
                                                                        'user_id',
                                                                        $point->user_id,
                                                                    )->sum('redeem_points');
                                                                    $avialable = $total - $redeem_points;
                                                                @endphp

                                                                {{ $avialable }}</td>

                                                            {{-- <td>
                                                            <select name="category" id="" data-user-id="{{$product->id}}" class="change-status-dropdown">
                                                                <option value="1" {{ $product->status == 1 ? 'selected' :
                                                                '' }}>Active</option>
                                                                <option value="0" {{ $product->status == 0 ? 'selected' :
                                                                '' }}>Inactive</option>
                                                            </select>

                                                        </td>
                                                        <td>
                                                            <a href="" class="btn btn-primary edit-btn"
                                                            data-bs-toggle="modal" data-bs-target="#editManagerModal" data-bs-whatever="@mdo"
                                                            data-id="{{ $product->id }}"
                                                            data-name="{{ $product->name }}"
                                                            data-price="{{ $product->price }}"
                                                            >
                                                                <i class="fas fa-edit"></i>
                                                                </a>
                                                                <a href="#" class="btn btn-danger delete-btn" data-id="{{ $product->id }}">
                                                                    <i class="fas fa-trash"></i>
                                                                    </a>
                                                                    </td> --}}

                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{-- <div id="tablePagination" class="table-control"></div> --}}
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





    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Gift Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('gift-product-add') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" name="name" id="recipient-name">
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Image:</label>
                            <input type="file" class="form-control" name="image" id="message-text">
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Coin:</label>
                            <input type="number" class="form-control" name="price" id="message-text">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Manager Modal -->
    <div class="modal fade" id="editManagerModal" tabindex="-1" aria-labelledby="editManagerLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editManagerLabel">Edit Gift Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editManagerForm" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" name="name" id="edit_name">
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="col-form-label">Coin:</label>
                            <input type="number" name="price" id="edit_price" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="edit_image" class="col-form-label">Image:</label>
                            <input type="file" name="image" id="edit_image" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn forcolor">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script-area')
    <script>
        $(document).ready(function() {
            $('#customerTable').DataTable({
                dom: '<"top"Bf>rt<"bottom"lp><"clear">',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                scrollX: true,
                scrollY: 200,

            });
        });


        $('.edit-btn').click(function() {
            let seller = $(this).data();
            $('#edit_name').val(seller.name);
            $('#edit_price').val(seller.price);
            $('#editManagerForm').attr('action', `{{ url('/gift-product/update/') }}/${seller.id}`);
            $('#editManagerModal').modal('show');
        });



        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif


        $('.delete-btn').click(function() {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ url('/gift-product/') }}/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'Partner has been deleted.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                        }
                    });
                }
            });
        });


        $(document).on('change', '.change-status-dropdown', function() {
            var customerId = this.dataset.userId;
            var status = $(this).val();
            console.log(customerId);

            $.ajax({
                url: '{{ Route('gift-product-status') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    gift_product_id: customerId,
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
