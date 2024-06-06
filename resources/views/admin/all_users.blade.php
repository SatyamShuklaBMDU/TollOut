@extends('include.master')
@section('style-area')
    <style>
        .dt-button {
            background-color: #f66f01 !important;
            color: white !important;
            border: none !important;
            border-radius: 8px !important;

        }
        .dataTables_wrapper .dataTables_filter input{
            border-radius: 12px !important;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
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
                                        <table id="customerTable" class="display nowrap" style="width:100%">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>S No.</th>
                                                    <th>Creation Date</th>
                                                    <th>CIN No.</th>
                                                    <th>Name</th>
                                                    {{-- <th>Gender</th> --}}
                                                    <th>Phone</th>
                                                    <th>Email</th>
                                                    <th>DOB</th>
                                                    {{-- <th>View</th> --}}
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach($users as $user)
                                                <tr class="text-center">
                                                    <td class="text-center">{{  $loop->iteration }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($user->created_at)) }}</td>
                                                    <td>{{ $user->customer_id }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    {{-- <td>{{ $user->gender }}</td> --}}
                                                    <td>{{ $user->phone }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    {{-- <td>{{ $user->dob }}</td> --}}
                                                    <td>
                                                        <a href="">
                                                            <span id="togglePassword" class="eye-icon">
                                                                👁️
                                                            </span>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <select class="form-select change-status-dropdown" data-customer-id="{{ $user->id }}">
                                                            <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Activate</option>
                                                            <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Deactivate</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            @endforeach
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
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#customerTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>

@endsection

