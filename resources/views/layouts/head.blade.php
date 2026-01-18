

<!doctype html>
<html lang="en">

<head>
    <title>BCRM</title>
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
    <!-- Add jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

    <main>
        <!-- overlay -->
        <div class="overlay-bg">
        </div>
        
        <!-- sidebar -->
        <aside class="sidebar">
            <!-- header -->
            <header class="sidebar-header">
                <div class="d-flex align-items-center">
                    <button class="sidebar-close-btn">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20.25 7.5L16 12L20.25 16.5M3.75 12H12M3.75 17.25H16M3.75 6.75H16"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                        </svg>
                    </button>
                    <button class="sidebar-close-btn sidebar-show-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
                        </svg>
                    </button>
                    <a href="#">
                        <span class="logo text-align-center">
                            BCRM
                        </span>
                    </a>
                </div>
            </header>
            <div class="sidebar-nav">
                <ul class="nav nav-pills">
                    <li>
                        <ul class="nav nav-pills mb-auto">
                            <li class="nav-item">
                                <a href="{{url('/dashboard')}}" class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false)   ? 'active' : 'inactive'; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                        </path>
                                    </svg>
                                    <span class="text">
                                        Dashboard
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('/clients')}}" class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/clients') !== false || strpos($_SERVER['REQUEST_URI'], 'create-client-1') !== false || strpos($_SERVER['REQUEST_URI'], 'create-client-2') !== false || strpos($_SERVER['REQUEST_URI'], 'create-client-3') !== false || strpos($_SERVER['REQUEST_URI'], 'create-client-4') !== false || strpos($_SERVER['REQUEST_URI'], 'save-client') !== false || strpos($_SERVER['REQUEST_URI'], 'search-clients') !== false || strpos($_SERVER['REQUEST_URI'], '/save-edit-client') !== false)   ? 'active' : 'inactive'; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                        </path>
                                    </svg>
                                    <span class="text">
                                        Clients
                                    </span>

                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{url('/service')}}" class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/service') !== false || strpos($_SERVER['REQUEST_URI'], '/add-service') !== false || strpos($_SERVER['REQUEST_URI'], '/edit-service') !== false)   ? 'active' : 'inactive'; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                        </path>
                                    </svg>
                                    <span class="text">
                                        Service
                                    </span>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('/client-service')}}" class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/client-service') !== false)   ? 'active' : 'inactive'; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                        </path>
                                    </svg>
                                    <span class="text">
                                        Clients Services
                                    </span>

                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="/client-payment" class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/client-payment') !== false)   ? 'active' : 'inactive'; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                        </path>
                                    </svg>
                                    <span class="text">
                                        Clients Payments
                                    </span>

                                </a>
                            </li> --}}
                        </ul>
                    </li>
                </ul>

            </div>
        </aside>

        <div class="main-content">
            <!-- header -->
            <header class="main-header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 mx-auto d-flex">
                            <div class="col-md-6 d-flex align-items-center">
                                <!-- <div class="header-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb mb-0">
                                            <li class="breadcrumb-item active"><a href="#">Pages</a></li>
                                            <li class="breadcrumb-item" aria-current="page">List</li>
                                        </ol>
                                    </nav>
                                </div> -->
                                <button class="sidebar-close-btn-mb" >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="col-md-6 ms-auto">
                                <div class="dropdown profile-dropdown">
                                    @php
                                        // Check if 'name' session variable is set
                                        if (session()->has('admin_name')) {
                                            $name = session('admin_name');
                                            // Display the first letter of the name
                                            $firstLetter = substr($name, 0, 1);
                                        } else {
                                            echo "<p>The 'name' session variable is not set.</p>";
                                        }
                                    @endphp
                                    <button class="profile-img-wrapper ms-auto" data-bs-toggle="dropdown">
                                        @php
                                         if (session()->has('admin_name')) {
                                           echo  $firstLetter ;

                                        } 
                                        @endphp
                                        </button>
                                    <ul class="dropdown-menu">
                                        <li class="p-0">
                                            <div class="dropdown-header">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                <span>
                                                    @php
                                                        $name = session('admin_name');
                                                        echo $name;
                                                    @endphp
                                                </span>
                                            </div>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{url('/adminsignout')}}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                        d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                <span>
                                                    Sign Out
                                                </span>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </header>

            @php
        // Check if 'name' session variable exists
        if (!session()->has('admin_name')) {
            // 'name' session variable does not exist
            //\ return redirect('/');
            
            header('Location: '.url('/owner-login'));
            exit();
        }

       
        
        @endphp