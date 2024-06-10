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
    </style>
@endsection

@section('content-area')
    <div class="pagetitle">
        <h1>All Notifications</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Home</a></li>
                <li class="breadcrumb-item active">All Notification</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">
        <div class="row">
            <section class="main_content dashboard_part">
                <div class="main_content_iner">
                    <div class="container-fluid plr_30 body_white_bg pt_30">
                        <div class="row justify-content-center"style="
                                                                            margin-top: 20px !important;">
                            <div class="col-lg-12 ">
                                <div class="row mb" style="margin-bottom: 30px; margin-left: 5px;">
                                    <form action="{{ route('filter-notification') }}" method="post">
                                        @csrf
                                        <div class="row">
                                            @include('admin.date')
                                            <div class="col-sm-1 mt-4" style="margin-left: 10px; margin-top: 0px;">
                                                <a class="btn text-white shadow-lg" href="{{ route('show-notification') }}"
                                                    style="background-color:#f66f01;box-shadow: 2px 10px 9px 0px #00000063 !important">Reset</a>
                                            </div>
                                            <div class="col-md-1 mt-4">
                                                <a href="#" class="btn shadow btn-xs sharp me-1 text-white"
                                                    data-bs-toggle="modal" data-bs-target="#notificationModal"
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
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="customerTable" class="display nowrap" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Sr NO.</th>
                                                        <th class="text-center">Creating Date</th>
                                                        <th class="text-center">Title</th>
                                                        <th class="text-center">Messgae </th>
                                                        <th class="text-center">Image</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($notifications as $notification)
                                                        <tr>
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td class="text-center">
                                                                {{ $notification->created_at->timezone('Asia/Kolkata')->format('d F Y') }}
                                                            </td>
                                                            <td class="text-center">{{ $notification->title }}</td>
                                                            <td class="text-center">{{ $notification->description }}
                                                            </td>
                                                            <td class="text-center"><a
                                                                    href="{{ asset($notification->image) }}" target="_blank"
                                                                    rel="noopener noreferrer"><img class="rounded-circle"
                                                                        width="35"height="35"
                                                                        src="{{ asset($notification->image) }}"
                                                                        alt=""></a>
                                                            </td>
                                                            <td style="text-align: center;">
                                                                <div class="d-flex justify-content-center">
                                                                    <a class="btn btn-primary shadow btn-xs sharp me-1 edit-notification"
                                                                        data-id="{{ $notification->id }}"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#editNotificationModal"><i
                                                                            class="fas fa-pencil-alt"></i></a>
                                                                    <a data-notify-id="{{ $notification->id }}"
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
    <div class="modal fade" id="notificationModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h2">Add Notification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('notifications.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="notificationTitle" class="form-label text-dark fw-bold h5">Notification
                                Title</label>
                            <input type="text" name="title" class="form-control border-dark" id="notificationTitle"
                                placeholder="Enter Notification Title">
                        </div>
                        <div class="mb-3">
                            <label for="notificationMessage" class="form-label text-dark fw-bold h5">Notification
                                Message</label>
                            <textarea class="form-control border-dark" name="message" id="notificationMessage" rows="3"
                                placeholder="Enter Notification Message"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="notificationImage" class="form-label text-dark fw-bold h5">Image</label>
                            <input type="file" name="image" class="form-control border-dark" id="notificationImage">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--edit notification-->
    <div class="modal fade" id="editNotificationModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h2">Edit Notification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('notifications.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="notifyId">
                        <div class="mb-3">
                            <label for="notificationTitle" class="form-label text-dark fw-bold h5">Notification
                                Title</label>
                            <input type="text" class="form-control border-dark" id="editNotificationTitle"
                                name="title" placeholder="Enter Notification Title">
                        </div>
                        <div class="mb-3">
                            <label for="notificationMessage" class="form-label text-dark fw-bold h5">Notification
                                Message</label>
                            <textarea class="form-control border-dark" id="editNotificationMessage" rows="3" name="message"
                                placeholder="Enter Notification Message"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editNotificationImage" class="form-label text-dark fw-bold h5">Image</label>
                            <input type="file" class="form-control border-dark" id="editNotificationImage"
                                name="image">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
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
        $(document).ready(function() {
            $('.edit-notification').click(function() {
                var notification_id = $(this).data('id');
                var url = '{{ route('notifications.edit', ':id') }}';
                url = url.replace(':id', notification_id);
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#notifyId').val(response.id);
                        $('#editNotificationTitle').val(response.title);
                        $('#editNotificationMessage').val(response.description);
                        $('#editNotificationModal').modal('show');
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
            var url = "{{ route('notifications.destroy', ':notifyId') }}".replace(':notifyId', notifyId);
            fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': token
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to delete Notification');
                    }
                    return response.json();
                })
                .then(data => {
                    swal.fire({
                        title: 'Deleted!',
                        text: 'The Notification has been deleted.',
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
                        text: 'Failed to delete Notification.',
                        icon: 'error'
                    });
                });
        }
    </script>
@endsection
