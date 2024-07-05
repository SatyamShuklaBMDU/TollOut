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
         .dataTables_length{
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

        @foreach ( $category as $cat)



        <h1>Sub Categories: {{$cat->name}}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Home</a></li>
                <li class="breadcrumb-item active">{{$cat->name}}</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    @endforeach
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
                                            <table id="customerTable" class="display nowrap table-centered" style="width:100%">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>S No.</th>
                                                        <th>Created Date</th>
                                                        <th>Name</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($subcategories as $subcat)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ date('d F Y', strtotime($subcat->created_at)) }}</td>
                                                        <td>{{ $subcat->name }}</td>
                                                        <td class="text-center d-flex justify-content-center">
                                                            <select name="category" id="" data-user-id="{{$subcat->id}}" class="form-select change-status-dropdown"style="width:7rem;">
                                                                <option value="0" {{ $subcat->status == 0 ? 'selected' :
                                                                '' }}>Active</option>
                                                                <option value="1" {{ $subcat->status == 1 ? 'selected' :
                                                                '' }}>Inactive</option>
                                                            </select>
                                                            </td>
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


        });
    });






    $(document).on('change', '.change-status-dropdown', function() {
        var customerId = this.dataset.userId;
        var status = $(this).val();
        console.log(customerId);

        $.ajax({
            url: '{{ Route('subcategory-status-update')}}',
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



