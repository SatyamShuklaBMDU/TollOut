@extends('include.master')
@section('style-area')
    <style>
        .dt-button {
            background-color: #f66f01 !important;
            color: white !important;
            border: none !important;
            border-radius: 8px !important;
        }
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 12px !important;
        }
        .table-centered th, .table-centered td {
            text-align: center;
            vertical-align: middle;
        }
        .dataTables_length label{
            margin-left: 20px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('content-area')

    <div class="pagetitle">
        <h1>All Users</h1>
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
                    <div class="row justify-content-center"style="
                    margin-top: 20px !important;">
                        <div class="col-lg-12 ">
                            <div class="row mb" style="margin-bottom: 30px; margin-left: 5px;">
                            <form action="{{route('user-filters')}}" method="post">
                                    @csrf
                                    <div class="row">
                                    @include('admin.date')
                                    <div class="col-sm-1" style="margin-left: 10px; margin-top: 0px;">
                                        <a class="btn text-white shadow-lg" href="{{route('user-show')}}"
                                            style="background-color:#f66f01;">Reset</a>
                                    </div>
                                    </div>
                                </form>
                            </div>
                            <!-- Table -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="customerTable" class="display nowrap table-centered" style="width:100%">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>S No.</th>
                                                    <th>Creation Date</th>
                                                    <th>CIN No.</th>
                                                    <th>Profile</th>
                                                    {{-- <th>Mr./Miss</th> --}}
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
    
    <script type="text/javascript">
        $(function () {
            var table = $('#customerTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('user-report-show') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'created_at', name: 'Creation_Date'},
                    {data: 'customer_id', name: 'CIN no.'},
                    {data: 'profile', name: 'Profile', orderable: false, searchable: false},
                    {data: 'name', name: 'Name'},
                    {data: 'phone', name: 'Phone'},
                    {data: 'email', name: 'Email'},
                    {data: 'dob', name: 'DOB'},
                    {data: 'status', name: 'Action', orderable: false, searchable: false}
                ],
                dom: 'Blfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                lengthMenu: [10, 25, 50, 75, 100],
                pageLength: 10
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
                        // alert('Status updated successfully!');
                        Swal.fire({
                            title: "Status Updated Successfully",
                            // text: "Thanks for Subscription",
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
