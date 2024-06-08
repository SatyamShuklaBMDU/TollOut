@extends('include.master')
@section('style-area')
    <style>

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
        .field-icon {
            float: right;
            margin-left: -25px;
            margin-top: -25px;
            position: relative;
            z-index: 2;
        }
    </style>
    
@endsection

@section('content-area')
    <div class="pagetitle">
        <h1>Add Admin's</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Home</a></li>
                <li class="breadcrumb-item active">Add Admin's</li>
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
                                <div class="container-fluid">
                                    <div class="row dashboard-header" style="">
                                        {{--  <div class="row">
                                            <div class="main-header">
                                                <h3 class="my-2 pl-4">Manage Admins</h3>
                                            </div>
                                        </div>  --}}
                                        <div class="col-md-12">
                                            <form class="notification-form shadow rounded p-4" action="{{ route('admin-store') }}" method="post">
                                                <div class="form-group my-1">
                                                    <label for="exampleInputEmail1">User Name</label>
                                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" style="font-size: 15px;"
                                                        id="exampleInputsubject"
                                                        placeholder="Please Enter Your Name">
                                                    @if ($errors->has('name'))
                                                        <span class="help-block">{{ $errors->first('name') }}</span>
                                                    @endif
                                                </div>
                                                <div class="form-group my-1">
                                                    <label for="exampleInputEmail1">Email</label>
                                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" style="font-size: 15px;"
                                                        id="exampleInputsubject" aria-describedby="textHelp"
                                                        placeholder="Please Enter Your Email">
                                                    @if ($errors->has('email'))
                                                        <script type="text/javascript">
                                                            alert(`{{ $errors->first('email') }}`)
                                                        </script>
                                                    @endif
                                                </div>
                                                @csrf
                                                <div class="form-group my-1">
                                                    <label for="exampleInputEmail1">Create Password</label>
                                                    <input type="password" name="password" class="form-control" id="password-field" style="font-size: 15px;"
                                                        aria-describedby="textHelp" placeholder="*****">
                                                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password pe-4"></span>
                                                    @if ($errors->has('password'))
                                                        <span class="help-block">{{ $errors->first('password') }}</span>
                                                    @endif
                                                </div>
                                                <div class="form-group my-1">
                                                    <label for="exampleInputEmail1">Role</label>
                                                    <input type="text" name="role" class="form-control" id="exampleInputsubject" style="font-size: 15px;"
                                                        aria-describedby="textHelp" placeholder="Role">
                                                    @if ($errors->has('role'))
                                                        <span class="help-block">{{ $errors->first('role') }}</span>
                                                    @endif
                                                </div>
                                                <h3 class="my-3">Assign Modules</h3>
                                                
                                                    <div class="wrapper ms-1">
                                                        <div class="row">
                                                            <div class="form-check col-3">
                                                                <input class="form-check-input" type="checkbox" value="usermanagement"
                                                                    id="usermanagement" name="permission[]">
                                                                <label class="form-check-label" for="usermanagement">
                                                                     Users Management
                                                                </label>
                                                            </div>
                                                            <!-- <div class="col-md-4"> -->
                                                            <div class="form-check col-3">
                                                                <input class="form-check-input" type="checkbox" value="faqmanagement" id="faqmanagement"
                                                                    name="permission[]">
                                                                <label class="form-check-label" for="faqmanagement">
                                                                    F.A.Q Management
                                                                </label>
                                                            </div>
                                                            <div class="form-check col-3" style="">
                                                                <input class="form-check-input" type="checkbox" value="notificationmanagement" id="notificationmanagement"
                                                                    name="permission[]">
                                                                <label class="form-check-label" for="notificationmanagement">
                                                                    Notification Management
                                                                </label>
                                                            </div>
                                                            <div class="form-check col-3">
                                                                <input class="form-check-input" type="checkbox" value="categorymanagement" id="categorymanagement"
                                                                    name="permission[]">
                                                                <label class="form-check-label" for="categorymanagement">
                                                                    Catogry Management
                                                                </label>
                                                            </div>
                                                      
                                                        </div>
                                                        {{-- <div class="row">
                                                            <div class="form-check col-3">
                                                                <input class="form-check-input" type="checkbox" value="blogmanagement" id="blogmanagement"
                                                                    name="permission[]">
                                                                <label class="form-check-label" for="blogmanagement">
                                                                    Blog Management
                                                                </label>
                                                            </div>
                                                            <div class="form-check col-3">
                                                                <input class="form-check-input" type="checkbox" value="notifications" id="notifications"
                                                                    name="permission[]">
                                                                <label class="form-check-label" for="notifications">
                                                                    Notification
                                                                </label>
                                                            </div>
                                                
                                                    
                                                            <div class="form-check col-3">
                                                                <input class="form-check-input " type="checkbox" value="customermanagement"
                                                                    id="customermanagement" name="permission[]">
                                                                <label class="form-check-label" for="customermanagement">
                                                                    Customer Management
                                                                </label>
                                                            </div>
                                                            <div class="form-check col-3">
                                                                <input class="form-check-input" type="checkbox" value="booking"
                                                                    id="booking" name="permission[]">
                                                                <label class="form-check-label" for="booking">
                                                                    Booking & Scheduling
                                                                </label>
                                                            </div>
                                                        </div>
                                                    
                                                 
                                                        <div class="row">
                                                            <div class="form-check col-3">
                                                                <input class="form-check-input" type="checkbox" value="payment"
                                                                    id="payment" name="permission[]">
                                                                <label class="form-check-label" for="payment">
                                                                    Payment & Invoicing
                                                                </label>
                                                            </div>
                                               
                                                            <div class="form-check col-3">
                                                                <input class="form-check-input" type="checkbox" value="feedback"
                                                                    id="feedback" name="permission[]">
                                                                <label class="form-check-label" for="feedback">
                                                                    Feedback
                                                                </label>
                                                            </div>
                                                            <div class="form-check col-3">
                                                                <input class="form-check-input" type="checkbox" value="complaint"
                                                                    id="complaint" name="permission[]">
                                                                <label class="form-check-label" for="complaint">
                                                                    Complaint
                                                                </label>
                                                            </div>

                                                            <div class="form-check col-3">
                                                                <input class="form-check-input" type="checkbox" value="referral"
                                                                    id="referral" name="permission[]">
                                                                <label class="form-check-label" for="referral">
                                                                    Referral & Earning
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-check col-3">
                                                                <input class="form-check-input" type="checkbox" value="review"
                                                                    id="review" name="permission[]">
                                                                <label class="form-check-label" for="review">
                                                                    Review & Rating
                                                                </label>
                                                            </div>
                                                        </div> --}}
                                                    <button type="submit" class="btn btn-success btn-lg mt-3" style="transform: translateX(0rem);background-color:#f66f01;border:none">Assign Roles</button>
                                                </div>
                                            </div>
                                                
                                            </form>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $(".toggle-password").click(function() {
                $(this).toggleClass("fa-eye fa-eye-slash");
                var input = $($(this).attr("toggle"));

                if (input.attr("type") == "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });
            if ($("#all").is(":checked")) { 
                $("input[type=checkbox]").prop('checked', true);
            }
            $("#all").click(function() {
                $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
            });
        });
    </script>

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

        function updateStatus(categoryId, status) {
            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var url = "{{ route('update-category-status') }}";
            var data = {
                _token: token,
                categoryId: categoryId,
                status: status
            };

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': token
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Status updated successfully'
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred'
                    });
                });
        }
    </script>

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
    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif
    </script>
    <script>
        $(document).ready(function() {
            $('.edit-category').click(function() {
                var notification_id = $(this).data('id');
                var url = '{{ route('category.edit', ':id') }}';
                url = url.replace(':id', notification_id);
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#notifyId').val(response.id);
                        $('#editCategoryName').val(response.name);
                        // $('#editNotificationMessage').val(response.message);
                        $('#editCategoryModal').modal('show');
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.deleteBtn').forEach(function(deleteButton) {
                deleteButton.addEventListener('click', function() {
                    var userId = this.dataset.notifyId;
                    swal.fire({
                        title: 'Are you sure?',
                        text: 'You will not be able to recover this Notification!',
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
            var url = "{{ route('category.destroy', ':notifyId') }}".replace(':notifyId', notifyId);
            fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': token
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to delete Category');
                    }
                    return response.json();
                })
                .then(data => {
                    swal.fire({
                        title: 'Deleted!',
                        text: 'The Category has been deleted.',
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
                        text: 'Failed to delete Category.',
                        icon: 'error'
                    });
                });
        }
    </script>
@endsection
