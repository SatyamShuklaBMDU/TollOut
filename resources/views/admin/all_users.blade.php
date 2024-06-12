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
        <h1>All User</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Home</a></li>
                <li class="breadcrumb-item active">All User</li>
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
                                    <form id="filterForm">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <p class="text-dark mt-4">
                                                    <b style="font-size: 15px;">
                                                        Filters:
                                                    </b>
                                                </p>
                                            </div>
                                            
                                            <div class="col-sm-2">
                                               
                                                    <label for="start_date"><strong>From:</strong></label>
                                                    <input type="date" id="start_date" name="start_date"
                                                        class="form-control">
                                                
                                            </div>
                                            <div class="col-sm-2 ms-4">
                                                
                                                    <label for="end_date"><strong>To:</strong></label>
                                                    <input type="date" id="end_date" name="end_date" class="form-control">
                                   
                                            </div>
                                            <div class="col-sm-1 ms-4" style="margin-left: 10px; margin-top: 0px;">
                                                <button type="button" id="filterButton" class="btn text-white shadow-lg mt-4"
                                                    style="background-color:#033496;box-shadow: 2px 10px 9px 0px #00000063 !important">Filter</button>
                                            </div>
                                            <div class="col-sm-1" style="margin-left: 10px; margin-top: 0px;">
                                                <button type="button" id="resetButton" class="btn text-white shadow-lg mt-4"
                                                    style="background-color:#f66f01;box-shadow: 2px 10px 9px 0px #00000063 !important">Reset</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- Table -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            {{-- <div id="tableLength" class="table-control"></div> --}}
                                            <table id="customerTable" class="display nowrap table-centered" style="width:100%">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>S No.</th>
                                                        <th>Creation Date</th>
                                                        <th>CIN No.</th>
                                                        <th>Profile</th>
                                                        <th>Name</th>
                                                        <th>Phone</th>
                                                        <th>Email</th>
                                                        <th>DOB</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
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
            </section>
        </div>
    </section>
@endsection

@section('script-area')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

    <script type="text/javascript">
        $(function () {
    var table = $('#customerTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('user-report-show') }}",
            type: "POST",
            data: function(d) {
                d._token = '{{ csrf_token() }}'; // Add CSRF token to the request
                d.start_date = $('#start_date').val();
                d.end_date = $('#end_date').val();
                // Log the data being sent to the server for debugging
                console.log('Data sent to server:', d);
            },
            dataSrc: function(json) {
                // Log the data being received from the server for debugging
                console.log('Data received from server:', json);
                return json.data;
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'created_at', name: 'created_at'},
            {data: 'customer_id', name: 'customer_id'},
            {data: 'profile', name: 'profile', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'phone', name: 'phone'},
            {data: 'email', name: 'email'},
            {data: 'dob', name: 'dob'},
            {data: 'status', name: 'status', orderable: false, searchable: false}
        ],
        dom: '<"top"Bf>rt<"bottom"lp><"clear">',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [10, 25, 50, 75, 100],
        pageLength: 10,
        drawCallback: function(settings) {
            // This function is no longer needed as lengthMenu and pagination are now correctly placed in the bottom div
        }
    });

    // Custom method for date comparison
    $.validator.addMethod("greaterThan", function(value, element, params) {
        var startDate = $(params).val();
        if (!/Invalid|NaN/.test(new Date(value)) && !/Invalid|NaN/.test(new Date(startDate))) {
            return new Date(value) >= new Date(startDate);
        }
        return true;
    }, 'End date must be greater than or equal to the start date.');

    $('#filterForm').validate({
        rules: {
            start_date: {
                required: true,
                date: true
            },
            end_date: {
                required: true,
                date: true,
                greaterThan: '#start_date'
            }
        },
        messages: {
            start_date: {
                required: "Start date is required",
                date: "Please enter a valid date"
            },
            end_date: {
                required: "End date is required",
                date: "Please enter a valid date",
                greaterThan: "End date must be greater than the start date"
            }
        },
        submitHandler: function(form) {
            table.ajax.reload();
        }
    });

    $('#filterButton').on('click', function() {
        $('#filterForm').submit();
    });

    $('#resetButton').on('click', function() {
        $('#start_date').val('');
        $('#end_date').val('');
        table.ajax.reload();
    });

    // Handle the change event for the status dropdown
    $(document).on('change', '.change-status-dropdown', function() {
        var customerId = $(this).data('customer-id');
        var status = $(this).val();

        $.ajax({
            url: '{{ route("change-user-status") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                customer_id: customerId,
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
});


    </script>
    
@endsection
