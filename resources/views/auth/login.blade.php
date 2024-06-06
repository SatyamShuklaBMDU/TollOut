<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toll Out</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body
    style="background-image: url(images/bg1.jpg);background-position: center center;
    background-repeat:  no-repeat;
    background-attachment: fixed;
    background-size:  cover;">

    <div class="container" style="margin: 3rem auto;">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-lg">
                    <img src="images/final 06.png" alt="">
                    <div class="p-2">
                        @if (session('status'))
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ session('status') }}
                            </div>
                         @endif

                        @if ($errors->any())
                            <div class="mb-4 alert alert-danger text-center">
                                {{-- <ul class="list-disc list-inside text-sm text-red-600"> --}}
                                    @foreach ($errors->all() as $error)
                                        <li style="list-style: none">{{ $error }}</li>
                                    @endforeach
                                {{-- </ul> --}}
                            </div>
                        @endif
                        <div class="my-1">
                            <!-- <div class="wrapper text-center">
                            <img src="" class="wrapper mt-4"alt="" style="width: 180px;height: 50px;">
                        </div> -->
                            <h4 class="text-center mt-3 h4"style="color:#051650;">Sign In Your Account</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('login') }}" method="post">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="email">Email ID</label>
                                    <input type="email" id="email" name="email" class="form-control py-4"
                                        placeholder="Enter Your Email" style="border-radius: 15px;"required>
                                </div>
                                <div class="form-group my-3">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password"
                                        class="form-control py-4"placeholder="Enter Your Password" required
                                        style="border-radius: 15px;">
                                </div>
                                <div class="form-group my-4 ms-3">
                                    <input type="checkbox" class="form-check-input"id="basic_checkbox_1"
                                        style="margin-left:5px">
                                    <label class="form-check-label" for="basic_checkbox_1"
                                        style="padding-left: 30px;">Remember My Preference</label>
                                </div>
                                <button type="submit"
                                    class="btn btn-primary btn-block py-2 shadow-sm"style="border-radius: 15px; background-color:#f66f01;border:none;">Sign
                                    In</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
