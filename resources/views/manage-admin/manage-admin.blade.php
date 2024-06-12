{{-- @dd($users); --}}
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
        .dataTables_length{
            margin-top: 10px;
        }

        .dataTables_wrapper .dataTables_filter input {
            border-radius: 12px !important;
        }
        .statusSwitch {
            --s: 20px;
            /* adjust this to control the size*/

            height: calc(var(--s) + var(--s)/5);
            width: auto;
            /* some browsers need this */
            aspect-ratio: 2.25;
            border-radius: var(--s);
            margin: calc(var(--s)/2);
            display: grid;
            cursor: pointer;
            background-color: #ff7a7a;
            box-sizing: content-box;
            overflow: hidden;
            transition: .3s .1s;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        .statusSwitch:before {
            content: "";
            padding: calc(var(--s)/10);
            --_g: radial-gradient(circle closest-side at calc(100% - var(--s)/2) 50%, #000 96%, #0000);
            background:
                var(--_g) 0 /var(--_p, var(--s)) 100% no-repeat content-box,
                var(--_g) var(--_p, 0)/var(--s) 100% no-repeat content-box,
                #fff;
            mix-blend-mode: darken;
            filter: blur(calc(var(--s)/12)) contrast(11);
            transition: .4s, background-position .4s .1s,
                padding cubic-bezier(0, calc(var(--_i, -1)*200), 1, calc(var(--_i, -1)*200)) .25s .1s;
        }

        .statusSwitch:checked {
            background-color: #85ff7a;
        }

        .statusSwitch:checked:before {
            padding: calc(var(--s)/10 + .05px) calc(var(--s)/10);
            --_p: 100%;
            --_i: 1;
        }
    </style>
    
@endsection

@section('content-area')
    <div class="pagetitle">
        <h1>All Admin</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Home</a></li>
                <li class="breadcrumb-item active">All Admin</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">
        <div class="row">
            <section class="main_content dashboard_part">
                <div class="main_content_iner">
                    <div class="container-fluid plr_30 body_white_bg pt_30">
                        <div class="row justify-content-center"style="margin-top: 20px !important;">
                                                                            
                            <div class="col-lg-12 ">
                                <div class="row mb" style="margin-bottom: 30px; margin-left: 5px;">
                                    <form action="{{ route('filter-admin') }}" method="post">
                                        @csrf
                                        <div class="row">
                                            @include('admin.date')
                                            <div class="col-sm-1 mt-4" style="margin-left: 10px; margin-top: 0px;">
                                                <a class="btn text-white shadow-lg" href="{{ route('manage-admin') }}"
                                                    style="background-color:#f66f01;box-shadow: 2px 10px 9px 0px #00000063 !important">Reset</a>
                                            </div>
                                            <div class="col-md-1 mt-4">
                                                <a href="{{ route('add-admin')}}" class="btn shadow btn-xs sharp me-1 text-white"
                                                    
                                                    style="margin-left:1.5rem; width: 65px;height: 36px;text-align: center;font-size:1rem;box-shadow: 2px 10px 9px 0px #00000063 !important;line-height:normal;background: #033496;">Add</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- Table -->
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="card">
                                    <div class="card-body table-responsive">
                                        <table id="customerTable" class="display nowrap" style="width:100%">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>S no.</th>    
                                                    <th>Registration Date</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Role </th>  
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $user)
                                                    <tr class="odd" data-user-id="{{ $user->id }}">
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td class="text-center">{{ \Carbon\Carbon::parse($user->created_at) }}
                                                        </td>
                                                        <td class="sorting_1 text-center">{{ $user->name }} </td>
                                                        <td class="text-center">{{ $user->email }}</td>
                                                        <td class="text-center">
                                                            <select class="form-select ChangeRole text-center" data-user-id="{{ $user->id }}"
                                                                aria-label="Default select example">
                                                                <option selected>Choose Role</option>
                                                                @foreach ($roles as $role)
                                                                    <option value="{{ $role->id }}"
                                                                        {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                                                        {{ $role->role }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <div class="d-flex justify-content-center">
                                                                <a href="{{ route('edit-admin',encrypt($user->id))}}" class="btn btn-primary shadow btn-xs sharp me-1 edit-category"style="background-color:#033496;border:none"><i class="fas fa-pencil-alt"></i></a>
                                                                <a data-notify-id="{{ $user->id }}"
                                                                    class="btn btn-danger shadow btn-xs sharp deleteBtn"><i
                                                                        class="fas fa-trash"></i></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.statusSwitch').forEach(function(switchButton) {
                switchButton.addEventListener('change', function() {
                    var status = this.checked ? 1 : 0;
                    var categoryId = this.dataset.categoryId;
                    updateStatus(categoryId, status);
                });
            });
        });
    </script>

    <script>
       $(document).ready(function() {
            $('#customerTable').DataTable({
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
        });
    </script>
    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif
    </script>
  
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.deleteBtn').forEach(function(deleteButton) {
                deleteButton.addEventListener('click', function() {
                    var userId = this.dataset.notifyId;
                    swal.fire({
                        title: 'Are you sure?',
                        text: 'You will not be able to recover this Aadmin!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            deleteFAQ(userId);
                        }
                    });
                });
            });
        });

        function deleteFAQ(notifyId) {
            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var url = "{{ route('delete-admin', ':notifyId') }}".replace(':notifyId', notifyId);
            fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': token
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to delete Admin');
                    }
                    return response.json();
                })
                .then(data => {
                    swal.fire({
                        title: 'Deleted!',
                        text: 'The Admin has been deleted.',
                        icon: 'success',
                        timer: 2000
                    }).then(() => {
                        location.reload();
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    swal.fire({
                        title: 'Error!',
                        text: 'Failed to delete Admin.',
                        icon: 'error'
                    });
                });
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.ChangeRole').forEach(select => {
                select.addEventListener('change', function() {
                    const userId = this.dataset.userId;
                    const roleId = this.value;
                    fetch('{{ url('change-role') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}', // Ensure CSRF token is correctly passed
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                user_id: userId,
                                role_id: roleId
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated!',
                                text: 'User role has been updated successfully.'
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!'
                            });
                        });
                });
            });
        });
    </script>
@endsection
