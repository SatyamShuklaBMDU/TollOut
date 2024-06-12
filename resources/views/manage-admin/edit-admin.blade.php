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
        <h1>Edit Admin</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Home</a></li>
                <li class="breadcrumb-item active">Edit Admin</li>
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
                                            <form class="notification-form shadow rounded p-4" action="{{ route('edit-admin-store',$users->id)}}" method="post">
                                                @csrf
                                                <div class="form-group my-1">
                                                    <label for="exampleInputEmail1">User Name</label>
                                                    <input type="text" name="name" value="{{ $users->name }}" class="form-control" style="font-size: 15px;"
                                                        id="exampleInputsubject"
                                                        placeholder="Please Enter Your Name">
                                                    @if ($errors->has('name'))
                                                        <span class="help-block">{{ $errors->first('name') }}</span>
                                                    @endif
                                                </div>
                                                <div class="form-group my-1">
                                                    <label for="exampleInputEmail1">Email</label>
                                                    <input type="email" name="email" value="{{ $users->email }}" class="form-control" style="font-size: 15px;"
                                                        id="exampleInputsubject" aria-describedby="textHelp"
                                                        placeholder="Please Enter Your Email">
                                                    @if ($errors->has('email'))
                                                        <script type="text/javascript">
                                                            alert(`{{ $errors->first('email') }}`)
                                                        </script>
                                                    @endif
                                                </div>                                              
                                                <div class="form-group my-1">
                                                    <label for="exampleInputEmail1">Create Password</label>
                                                    <input type="password" name="password" class="form-control" id="password-field" style="font-size: 15px;"
                                                        aria-describedby="textHelp" placeholder="*****">
                                                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password pe-4"></span>
                                                    <small style="color:#f66f01">(minimum 8 characters)</small>
                                                    @if ($errors->has('password'))
                                                        <span class="help-block">{{ $errors->first('password') }}</span>
                                                    @endif
                                                </div>
                                                <button type="submit" class="btn btn-success btn-lg mt-3" style="transform: translateX(0rem);background-color:#f66f01;border:none">Save Changes</button>    
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
    
@endsection
