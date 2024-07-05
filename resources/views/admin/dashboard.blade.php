@extends('include.master')
@section('style-area')
    <style>
        .main_content {
            padding-left: 283px;
            padding-bottom: 0% !important;
            padding-right: 12px;
        }
    </style>
         
@endsection

@section('content-area')

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">
            <!-- Users Card -->
            <div class="col-xxl-4 col-md-4">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Active User</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-fill-check"></i>
                    </div>
                    <div class="ps-3">
                        <h6>{{ $users}}</h6>
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <!-- End Users Card -->

            <!-- Active Category Card -->
            <div class="col-xxl-4 col-md-4">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Active Category</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-list-ul"></i>
                    </div>
                    <div class="ps-3">
                        <h6>{{ $category}}</h6>
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <!-- End Active Category Card -->

            <!-- Sub Category Card -->
            <div class="col-xxl-4 col-md-4">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Active Sub Category</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-grid-3x2-gap"></i>
                    </div>
                    <div class="ps-3">
                        <h6>{{ $subcategory }}</h6>
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <!-- End Sub Category Card -->
      ` </div>
      </div>
    </div>
    </section>

@endsection


@section('script-area')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var loginMessage = document.getElementById('loginMessage');
            if (loginMessage) {
                setTimeout(function() {
                    loginMessage.style.display = 'none';
                }, 3000);
            }
        });
    </script>
@endsection

