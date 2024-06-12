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
        <h1>Add Role</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Home</a></li>
                <li class="breadcrumb-item active">Add Role</li>
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
                                            <form class="notification-form shadow rounded p-4" action="{{ route('role-store') }}" method="post">
                                                @csrf
                                                <div class="form-group my-1">
                                                    <label for="exampleInputEmail1">Role</label>
                                                    <input type="text" name="role" class="form-control" id="exampleInputsubject" style="font-size: 15px;"
                                                        aria-describedby="textHelp" placeholder="Role" value="{{ old('email') }}">
                                                        <span style="color:#f66f01">(e.g., Manager,Tester)</span>
                                                    @if ($errors->has('role'))
                                                        <span class="help-block">{{ $errors->first('role') }}</span>
                                                    @endif
                                                </div>
                                                <h3 class="my-3">Assign Role</h3>
                                                
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
                                                                <input class="form-check-input" type="checkbox" value="feedbackmanagement" id="feedbackmanagement"
                                                                    name="permission[]">
                                                                <label class="form-check-label" for="feedbackmanagement">
                                                                    Feedback Management
                                                                </label>
                                                            </div>
                                                        </div>
                                                    <button type="submit" class="btn btn-success btn-lg mt-3" style="transform: translateX(0rem);background-color:#f66f01;border:none">Assign Roles</button>
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

      
    </script>
@endsection
