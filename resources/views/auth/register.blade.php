<!DOCTYPE html>
<html lang="en"> <!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>AdminLTE 4 | Register Page v2</title><!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="AdminLTE 4 | Register Page v2">
    <meta name="author" content="ColorlibHQ">
    <meta name="description"
        content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS.">
    <meta name="keywords"
        content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard">
    <!--end::Primary Meta Tags--><!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous">
    <!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css"
        integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous">
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css"
        integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous">
    <!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}"><!--end::Required Plugin(AdminLTE)-->
</head> <!--end::Head--> <!--begin::Body-->

<body class="register-page bg-body-secondary">
    <div class="register-box"> <!-- /.register-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header"> <a href="../index2.html"
                    class="link-dark text-center link-offset-2 link-opacity-100 link-opacity-50-hover">
                    <h1 class="mb-0"> <b>Admin</b>LTE
                    </h1>
                </a> </div>
            <div class="card-body register-card-body">
                <p class="register-box-msg">Register a new membership</p>
                @if (session('fail'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('fail') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('storRegistration') }}" method="post">
                    @csrf
                    <div class="input-group mb-1">
                        <div class="form-floating"> <input id="registerFullName" type="text" class="form-control"
                                name="name" placeholder=""> <label for="registerFullName">Full Name</label> </div>
                        <div class="input-group-text"> <span class="bi bi-person"></span> </div>

                    </div>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    <div class="input-group mb-1">
                        <div class="form-floating"> <input id="registerEmail" type="email" class="form-control"
                                name="email" placeholder=""> <label for="registerEmail">Email</label> </div>
                        <div class="input-group-text"> <span class="bi bi-envelope"></span> </div>


                    </div>

                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="input-group mb-1">
                        <div class="form-floating"> <input id="phone" type="number" name="phone"
                                class="form-control" placeholder=""> <label for="phone">Mobile</label> </div>
                        <div class="input-group-text"> <span class="bi bi-telephone"></span> </div>


                    </div>
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    <div class="input-group mb-1">
                        <div class="form-floating">
                            <input id="registerPassword" type="password" name="password" class="form-control"
                                placeholder="">
                            <label for="registerPassword">Password</label>
                        </div>
                        <div class="input-group-text"> <span class="bi bi-lock"></span></div>

                    </div>

                    @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                    <div class="input-group mb-1">
                        <div class="form-floating">
                            <input id="password_confirmation" name="password_confirmation" type="password"
                                class="form-control" placeholder="">
                            <label for="registerPassword">Re-Password</label>
                        </div>
                        <div class="input-group-text"> <span class="bi bi-lock"></span> </div>
                    </div>
                    <!--begin::Row-->
                    <div class="input-group mb-1">
                        <div class="form-floating">
                            <select class="form-select form-control" id="country" name="country_id" required>
                                @forelse ($datas as $value)
                                    <option value="{{ $value->id }}" {{ $value->id == 18 ? 'selected' : '' }}>
                                        {{ $value->name }}</option>
                                @empty
                                    <option value="18">BANGLADESH</option>
                                @endforelse

                            </select>
                            <label for="country">Country</label>
                        </div>
                        <div class="invalid-feedback">
                            Please select a valid Country.
                        </div>

                        <div class="input-group-text"><span class="bi bi-flag"></span> </div>


                    </div>

                    @error('country_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror


                    <div class="input-group mb-1">
                        <div class="form-floating">
                            <select class="form-select form-control" id="gender" name="gender_id" required>
                                @forelse ($genders as $gvalue)
                                    <option value="{{ $gvalue->id }}" {{ $value->id == 1 ? 'selected' : '' }}>
                                        {{ $gvalue->name }}</option>
                                @empty
                                    <option value="1">Male</option>
                                @endforelse

                            </select>
                            <label for="country">Gender</label>
                        </div>
                        <div class="invalid-feedback">
                            Please select a valid Gender.
                        </div>

                        <div class="input-group-text"><span class="bi bi-gender-ambiguous"></span> </div>


                    </div>
                    @error('gender_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                    <!--begin::Row-->
                    <div class="row mt-1">
                        <div class="col-8 d-inline-flex align-items-center">
                            <div class="form-check"> <input class="form-check-input" type="checkbox" value=""
                                    id="flexCheckDefault"> <label class="form-check-label" for="flexCheckDefault">
                                    I agree to the <a href="#">terms</a> </label> </div>
                        </div> <!-- /.col -->
                        <div class="col-4">
                            <div class="d-grid gap-2"> <button type="submit" class="btn btn-primary">Sign
                                    In</button> </div>
                        </div> <!-- /.col -->
                    </div> <!--end::Row-->
                </form>
                {{-- <div class="social-auth-links text-center mb-3 d-grid gap-2">
                    <p>- OR -</p> <a href="#" class="btn btn-primary"> <i class="bi bi-facebook me-2"></i> Sign in using Facebook
                    </a> <a href="#" class="btn btn-danger"> <i class="bi bi-google me-2"></i> Sign in using Google+
                    </a>
                </div> <!-- /.social-auth-links --> --}}
                <p class="mb-0"> <a href="login.html" class="link-primary text-center">
                        I already have a membership
                    </a> </p>
            </div> <!-- /.register-card-body -->
        </div>
    </div> <!-- /.register-box --> <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js"
        integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script> <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="{{ asset('js/adminlte.min.js') }}"></script> <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
        const Default = {
            scrollbarTheme: "os-theme-light",
            scrollbarAutoHide: "leave",
            scrollbarClickScroll: true,
        };
        document.addEventListener("DOMContentLoaded", function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (
                sidebarWrapper &&
                typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined"
            ) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script> <!--end::OverlayScrollbars Configure--> <!--end::Script-->

<script>
    $(document).ready(function() {
        setTimeout(function() {
            $(".alert").alert('close');
        }, 5000); // Closes the alert after 5 seconds
    });
</script>
</body><!--end::Body-->

</html>
