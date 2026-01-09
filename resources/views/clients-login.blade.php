{{-- @php
    if (session()->has('name')) {
            // 'name' session variable does not exist
            header("Location: /admin-dashboard");
            exit();
        }
@endphp --}}

@php
if (session()->has('name')) {
    $redirectUrl = url('/admin-dashboard');
    echo '<script>window.location.href = "' . $redirectUrl . '";</script>';
    exit(); // Optional: You may exit to stop further PHP execution if needed
}
@endphp    
<!doctype html>
<html lang="en">

<head>
    <title>Login - BCRM</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- css -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}" />
    <!-- google font -->
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&amp;display=swap"
        rel="stylesheet" />
    <!-- chart js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <!-- trix editor -->
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
</head>

<body class="login-page">
    
    <div class="login-col">
        <div class="login-box">
            <div class="logo-txt">
                <span class="logo text-center">
                </span>
            </div>
            <h1 class="text-center">Client Login</h1>
            <form class="create-form" method="POST" action="{{ url('/admin-dashboard') }}">
                @csrf
                
                <label for="login">Email/Username <sup>*</sup></label>
                <input type="text" name="login" id="login" required>
                        
                <label for="password">Password <sup>*</sup></label>
                <input type="password" name="password" id="password" required>
                        
                {{-- <div class="remember-col">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember" class="m-0">Remember me</label>
                </div> --}}
                        
                <button class="btn" type="submit">Sign In</button>
                 <!-- General error container -->
                 @if ($errors->any())
                    <div class="alert alert-danger mt-4">
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                    </div>
                 @endif
                
            </form>
            
        </div>
        
    </div>
    

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

</body>

</html>
