<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login - LaundrySense</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets') }}/images/favicon.ico">

    <!-- App css -->
    <link href="{{ asset('assets') }}/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets') }}/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />
    <link href="{{ asset('assets') }}/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style" />

</head>

<body class="loading authentication-bg"
    data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center pb-0 fw-bold">LaundrySense</h4>
                                <p class="text-muted mb-4">Mohon masukkan informasi login Anda untuk melanjutkan.
                                </p>
                            </div>
                            @if (session('message'))
                                <div class="alert alert-danger">{{ session('message') }}</div>
                            @endif
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input class="form-control  @error('username') is-invalid @enderror" type="text"
                                        id="username" name="username" value="{{ old('username') }}"
                                        placeholder="Masukan username anda">
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <a href="#" class="text-muted float-end"><small>Lupa
                                            password?</small></a>
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" name="password" class="form-control"
                                            placeholder="Masukan password anda">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                    @error('password')
                                        <small class="text-danger">
                                            <strong>{{ $message }}</strong>
                                        </small>
                                    @enderror
                                </div>

                                <div class="mb-3 mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="checkbox-signin"
                                            name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="checkbox-signin">Ingat saya</label>
                                    </div>
                                </div>
                                <div class="mb-3 mb-0 text-center">
                                    <button class="btn btn-primary" type="submit"> Login </button>
                                </div>

                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->
    <!-- bundle -->
    <script src="{{ asset('assets') }}/js/vendor.min.js"></script>
    <script src="{{ asset('assets') }}/js/app.min.js"></script>

</body>

</html>
