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
        <h1>All Feedback</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Home</a></li>
                <li class="breadcrumb-item active">All Feedback</li>
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
                                    <form action="{{ route('filter-category') }}" method="post">
                                        @csrf
                                        <div class="row">
                                            @include('admin.date')
                                            <div class="col-sm-1 mt-4" style="margin-left: 10px; margin-top: 0px;">
                                                <a class="btn text-white shadow-lg" href="{{ route('show-category') }}"
                                                    style="background-color:#f66f01;box-shadow: 2px 10px 9px 0px #00000063 !important">Reset</a>
                                            </div>
                                            {{-- <div class="col-md-1 mt-4">
                                                <a href="{{ route('category.store')}}" class="btn shadow btn-xs sharp me-1 text-white"
                                                    data-bs-toggle="modal" data-bs-target="#categoryModal"
                                                    style="margin-left:1.5rem; width: 65px;height: 36px;text-align: center;font-size:1rem;box-shadow: 2px 10px 9px 0px #00000063 !important;line-height:normal;background: #033496;">Add</a>
                                            </div> --}}
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
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="customerTable" class="display nowrap" style="width:100%">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>S No.</th>
                                                        <th>Created Date</th>
                                                        <th>Customer Id</th>
                                                        <th>Name</th>
                                                        <th>Subject</th>
                                                        <th>Message</th>
                                                        <th>Reply Date</th>
                                                        <th>Reply</th>
                                                        <th style="text-align: center;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($categories as $category)
                                                        <tr>
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td style="text-align: center;">
                                                                {{ $category->created_at->timezone('Asia/Kolkata')->format('d F Y') }}
                                                            </td>
                                                            <td style="text-align: center;">{{ $category->customer->customer_id }}</td>
                                                            <td style="text-align: center;">{{ $category->customer->name }}</td>
                                                            <td style="text-align: center;">{{ $category->subject }}</td>
                                                            <td style="text-align: center;">{{ $category->message }}</td>
                                                            <td style="text-align: center;">{{ $category->reply_date->format('d F Y h:i A') }}</td>
                                                            <td style="text-align: center;">{{ $category->reply }}</td>
                                                            <td style="text-align: center;">
                                                                <div class="d-flex justify-content-center">
                                                                    <a href="#"
                                                                        class="btn btn-success shadow btn-1x sharp me-1 reply-btn" style="background-color:#033496;border:none"
                                                                        data-feedback-id="{{ $category->id }}"
                                                                        data-bs-toggle="modal" data-bs-target="#basicModal">Reply
                                                                    </a>
                                                                    <a data-notify-id="{{ $category->id }}"
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
                </div>
            </section>
        </div>
    </section>
    {{-- Modal Content --}}
    <div class="modal fade" id="basicModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h2">Reply Feedback</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <form id="replyForm"action="{{ route('feedback-reply') }}" method="post">
                    @csrf
                    <div  class="modal-body">
                        <input type="hidden" id="feedbackId" name="feedbackId">
                        <div class="mb-3">
                            <label for="blogTitle" class="form-label text-dark fw-bold h5">Compose Response</label>
                            <input type="text" class="form-control border-dark" name='reply'id="replyMessage"
                                placeholder="Enter Compose Response" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal"style="background-color:#033496;border:none">Close</button>
                        <button type="submit" class="btn btn-primary" id="sendReply"style="background-color:#f66f01;border:none">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script-area')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const replyButtons = document.querySelectorAll('.reply-btn');
        replyButtons.forEach(button => {
            button.addEventListener('click', function() {
                const feedbackId = this.getAttribute('data-feedback-id');
                document.getElementById('feedbackId').value = feedbackId;
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
                        throw new Error('Failed to delete Feedback');
                    }
                    return response.json();
                })
                .then(data => {
                    swal.fire({
                        title: 'Deleted!',
                        text: 'The Feedback has been deleted.',
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
                        text: 'Failed to delete Feedback.',
                        icon: 'error'
                    });
                });
        }
    </script>
@endsection
