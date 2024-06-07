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
        <h1>All Categories</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Home</a></li>
                <li class="breadcrumb-item active">All Categories</li>
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
                                            <div class="col-md-1 mt-4">
                                                <a href="{{ route('category.store')}}" class="btn shadow btn-xs sharp me-1 text-white"
                                                    data-bs-toggle="modal" data-bs-target="#categoryModal"
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
                                                        <th style="text-align: center;">Sr No.</th>
                                                        <th style="text-align: center;">Creating Date</th>
                                                        <th style="text-align: center;">Category Name</th>
                                                        <th style="text-align: center;">Category Image</th>
                                                        <th style="text-align: center;">Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($categories as $category)
                                                        <tr>
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td style="text-align: center;">
                                                                {{ $category->created_at->timezone('Asia/Kolkata')->format('d F Y') }}
                                                            </td>
                                                            <td style="text-align: center;">{{ $category->name }}</td>
                                                            {{-- <td style="text-align: center;">{{ $category->description }} --}}
                                                            </td>
                                                            <td style="text-align: center;"><a
                                                                    href="{{ asset($category->image) }}" target="_blank"
                                                                    rel="noopener noreferrer"><img class="rounded-circle"
                                                                        width="35"height="35"
                                                                        src="{{ asset($category->image) }}"
                                                                        alt=""></a>
                                                            </td>
                                                            <td>
                                                                <input style="transform: translateY(0px);"
                                                                    class="statusSwitch"
                                                                    {{ $category->status == '1' ? 'checked' : '' }}
                                                                    data-category-id="{{ $category->id }}" type="checkbox">
                                                            </td>
                                                            <td style="text-align: center;">
                                                                <div class="d-flex">
                                                                    <a class="btn btn-primary shadow btn-xs sharp me-1 edit-category" data-id="{{ $category->id }}" data-bs-toggle="modal" data-bs-target="#editCategoryModal"><i class="fas fa-pencil-alt"></i></a>
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
    <div class="modal fade" id="categoryModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h2">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="categoryName" class="form-label text-dark fw-bold h5">Category
                                Name</label>
                            <input type="text" name="name" class="form-control border-dark" id="categoryName"
                                placeholder="Enter Category Name">
                        </div>
                        {{-- <div class="mb-3">
                            <label for="notificationMessage" class="form-label text-dark fw-bold h5">Notification
                                Message</label>
                            <textarea class="form-control border-dark" name="message" id="notificationMessage" rows="3"
                                placeholder="Enter Notification Message"></textarea>
                        </div> --}}
                        <div class="mb-3">
                            <label for="categoryImage" class="form-label text-dark fw-bold h5">Image</label>
                            <input type="file" name="image" class="form-control border-dark" id="categoryImage">
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
    <div class="modal fade" id="editCategoryModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h2">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('category.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST') <!-- Change to @method('PUT') if using PUT method -->
                    <div class="modal-body">
                        <input type="hidden" name="id" id="notifyId">
                        <div class="mb-3">
                            <label for="editCategoryName" class="form-label text-dark fw-bold h5">Category Name</label>
                            <input type="text" class="form-control border-dark" id="editCategoryName" name="name" placeholder="Enter Category Name">
                        </div>
                        <div class="mb-3">
                            <label for="editCategoryImage" class="form-label text-dark fw-bold h5">Category Image</label>
                            <input type="file" class="form-control border-dark" id="editCategoryImage" name="image">
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
