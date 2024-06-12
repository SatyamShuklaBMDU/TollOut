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
        .dataTables_length{
            margin-top: 10px;
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
        <h1>All FAQ's</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Home</a></li>
                <li class="breadcrumb-item active">All FAQ's</li>
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
                                    <form action="{{ route('filter-faq') }}" method="post">
                                        @csrf
                                        <div class="row">
                                            @include('admin.date')
                                            <div class="col-sm-1 mt-4" style="margin-left: 10px; margin-top: 0px;">
                                                <a class="btn text-white shadow-lg" href="{{ route('faq-index') }}"
                                                    style="background-color:#f66f01;box-shadow: 2px 10px 9px 0px #00000063 !important">Reset</a>
                                            </div>
                                            <div class="col-md-1  mt-4">
                                                <a href="#" class="btn shadow btn-xs sharp me-1 text-white"
                                                    data-bs-toggle="modal" data-bs-target="#basicModal2"
                                                    style="margin-left:1.5rem; width: 65px;height: 36px;text-align: center;font-size:1rem;box-shadow: 2px 10px 9px 0px #00000063 !important;line-height:normal;background: #033496;">Add</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <!-- Table -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="customerTable" class="display nowrap" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Sr NO.</th>
                                                        <th class="text-center">Created Date</th>
                                                        {{-- <th>Update Date, Time</th> --}}
                                                        <th class="text-center">FAQ Title</th>
                                                        <th class="text-center">FAQ Description</th>
                                                        <th class="text-center">Status</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($faqs as $faq)
                                                        <tr class="text-center">
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $faq->created_at->timezone('Asia/Kolkata')->format('d F Y') }}
                                                            </td>
                                                            {{-- <td>{{ $faq->updated_at->timezone('Asia/Kolkata')->format('d F Y, h:i A') }}</td> --}}
                                                            <td>{{ $faq->question }}</td>
                                                            {{-- <td>{{ $faq->answer }}</td> --}}
                                                            <td>
                                                                <a data-bs-toggle="tooltip"
                                                                    title="{{ ($faq->answer) }}"
                                                                    data-placement="top">
                                                                    {{ \Illuminate\Support\Str::limit($faq->answer, 49) }}
                                                                </a>
                                                            </td>
                                                            <td class="d-flex justify-content-center">
                                                                <input style="transform: translateY(0px);"
                                                                    class="statusSwitch"
                                                                    {{ $faq->is_published == '1' ? 'checked' : '' }}
                                                                    data-faq-id="{{ $faq->id }}" type="checkbox">
                                                            </td>
                                                            <td>
                                                                <div class="d-flex justify-content-center">
                                                                    <a href="#"
                                                                        class="btn btn-primary shadow btn-xs sharp me-1 editBtn"style="background-color:#033496;border:none";
                                                                        data-faq-id="{{ $faq->id }}"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#basicModal"><i
                                                                            class="fas fa-pencil-alt"></i></a>
                                                                    <button
                                                                        class="btn btn-danger shadow btn-xs sharp deleteBtn"
                                                                        data-faq-id="{{ $faq->id }}"><i
                                                                            class="fas fa-trash"></i></button>
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
    <div class="modal fade" id="basicModal2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h2">Add FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('faqs-store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="faqTitle" class="form-label text-dark fw-bold h5">FAQ Title</label>
                            <input type="text" name="title" class="form-control border-dark" id="faqTitle"
                                placeholder="Enter FAQ Title">
                            <small class="text-primary h6">(e.g., How to use our product)</small>
                        </div>
                        <div class="mb-3">
                            <label for="faqDescription" class="form-label text-dark fw-bold h5">FAQ Description</label>
                            <textarea class="form-control border-dark" id="faqDescription" rows="3" placeholder="Enter FAQ Description" name="description"></textarea>
                            <small class="text-primary h6">(Provide a brief description of the FAQ)</small>
                        </div>  
                        
                        <div class="modal-footer">
                        <button type="button" class="btn btn-danger light h6" style="background-color:#033496;border:none" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="saveFAQBtn" class="btn btn-primary h6" style="background-color:#f66f01;border:none">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h2">Edit FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editFAQForm">
                        <input type="hidden" id="editFaqId" name="editFaqId">
                        <div class="mb-3">
                            <label for="editFaqTitle" class="form-label text-dark fw-bold h5">FAQ Title</label>
                            <input type="text" class="form-control border-dark" id="editFaqTitle"
                                placeholder="Enter FAQ Title">
                            <small class="text-primary h6">(e.g., How to use our product)</small>
                        </div>
                        <div class="mb-3">
                            <label for="editFaqDescription" class="form-label text-dark fw-bold h5">FAQ
                                Description</label>
                            <textarea class="form-control border-dark" id="editFaqDescription" rows="3"
                                placeholder="Enter FAQ Description"></textarea>
                            <small class="text-primary h6">(Provide a brief description of the FAQ)</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light h6" data-bs-dismiss="modal" style="background-color:#033496;border:none">Close</button>
                    <button type="button" id="updateFAQBtn" class="btn btn-primary h6"style="background-color:#f66f01;border:none">Save Changes</button>
                </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.statusSwitch').forEach(function(switchButton) {
                switchButton.addEventListener('change', function() {
                    var status = this.checked ? 1 : 0;
                    var faqId = this.dataset.faqId;
                    updateStatus(faqId, status);
                });
            });
        });

        function updateStatus(faqId, status) {
            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var url = "{{ route('update-faq-status') }}";
            var data = {
                _token: token,
                faq_id: faqId,
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
                        title: 'Status Updated Successfully',
                        // text: 'Status Updated Successfully'
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
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.editBtn').forEach(function(editButton) {
                editButton.addEventListener('click', function() {
                    var faqId = this.dataset.faqId;
                    fetchFaqDetails(faqId);
                });
            });
        });

        function fetchFaqDetails(faqId) {
            var url = "{{ route('faq-details', ':faqId') }}".replace(':faqId', faqId);
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('editFaqId').value = data.id;
                    document.getElementById('editFaqTitle').value = data.question;
                    document.getElementById('editFaqDescription').value = data.answer;
                    $('#editModal').modal('show');
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
    <script>
        document.getElementById("updateFAQBtn").addEventListener("click", function() {
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var faqId = document.getElementById("editFaqId").value;
            var title = document.getElementById("editFaqTitle").value;
            var description = document.getElementById("editFaqDescription").value;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "{{ route('update-faq') }}", true);
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.setRequestHeader("X-CSRF-Token", csrfToken);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // var response = JSON.parse(xhr.responseText);
                    //     toastr.success(response.success);
                    $('#editModal').modal('hide');
                    location.reload();
                    // setTimeout(function() {
                    //         location.reload();
                    //     }, 2000); 
                }
            };
            var data = JSON.stringify({
                faq_id: faqId,
                title: title,
                description: description
            });
            xhr.send(data);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.deleteBtn').forEach(function(deleteButton) {
                deleteButton.addEventListener('click', function() {
                    var faqId = this.dataset.faqId;
                    swal.fire({
                        title: 'Are you sure?',
                        text: 'You will not be able to recover this FAQ!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            deleteFAQ(faqId);
                        }
                    });
                });
            });
        });

        function deleteFAQ(faqId) {
            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var url = "{{ route('faq-delete', ':faqId') }}".replace(':faqId', faqId);
            fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': token
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to delete FAQ');
                    }
                    return response.json();
                })
                .then(data => {
                    swal.fire({
                        title: 'Deleted!',
                        text: 'The FAQ has been deleted.',
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
                        text: 'Failed to delete FAQ.',
                        icon: 'error'
                    });
                });
        }
    </script>
@endsection
