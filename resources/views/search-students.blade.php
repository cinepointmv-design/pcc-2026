
@extends('layouts.admin-main')


@section('adminpage')
            <!-- table section -->


           
            <div class="table-col">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 row align-items-center heading-wrapper">
                            <div class="col-md-6 col-12">
                                <h1>Search Result For : {{$query}}</h1>
                            </div>
                            {{-- <div class="col-md-6 col-12">
                                <a href="/add-students" class="btn d-block ms-md-auto ms-none">Add Student</a>
                            </div> --}}
                        </div>
                        @if($students->count() > 0)
                        <div class="col-md-12 m-auto">
                            <div class="table-card">
                                <div class="table-header d-flex align-items-center">
                                    <div class="col-md-6">
                                        <div class="dropdown profile-dropdown delete-dropdown" id="delete-dropdown">
                                            <button class="delete-btn" data-bs-toggle="dropdown">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <form action="{{url('/remove-students')}}" method="post" >
                                                    @csrf
                                                <li>
                                                    <button type="submit" class="dropdown-item" id="deleteBtn" onclick="return confirmDelete();">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd"
                                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        <span>
                                                            Delete Selected
                                                        </span>
                                                    </button>
                                                </li>
                                                </form>

                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end">
                                        {{-- <form class="search-col" action="/search-students" method="GET">
                                            <div class="serach-input">
                                                <span class="search-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                    </svg>
                                                </span>
                                                <input id="searchInput" type="search" name="search" placeholder="Search">
                                            </div>
                                        </form> --}}
                                        <!-- <div class="dropdown profile-dropdown delete-dropdown check-item-dropdown">
                                            <button class="delete-btn" data-bs-toggle="dropdown">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2">
                                                    </path>
                                                </svg>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item">
                                                        <input type="checkbox" id="title-check">
                                                        <label for="title-check">Title</label>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item">
                                                        <input type="checkbox" id="site-check">
                                                        <label for="site-check">Site</label>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div> -->
                                    </div>
                                </div>
                                {{-- <div class="table-selection-col">
                                    <p>
                                        <span>10</span> records selected.
                                        <button class="select-all">Select all <span>86</span>.</button>
                                        <button type="button" class="deselect-all"> Deselect all.</button>
                                    </p>
                                </div> --}}
                                <div class="table-container">
                                    <table class="table table-hover data-table">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input type="checkbox" id="selectAll" > 
                                                </th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Mobile Number</th>
                                                <th>Whatsapp Number</th>
                                                <th>Father's Name</th>
                                                <th>Date Of Birth</th>
                                                <th>Gender</th>
                                                <th>Address</th>
                                                <th>City </th>
                                                <th>Pincode</th>
                                                <th>Community</th>
                                                <th>Qualification</th>
                                                <th>Board </th>
                                                <th>Subjects</th>
                                                <th>Percentage </th>
                                                <th>Passing Year</th>
                                                <th>Joining Date</th>
                                                <th>Course</th>
                                                <th>Batch Time</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody  id="clientTableBody">
                                            @foreach ($students as $student)
                                            <tr class="client-row">
                                                <td>
                                                    <input type="checkbox" name="selected_students[]" class="select-checkbox" value="{{ $student->id }}">
                                                </td>
                                                    <td>{{ $student->name }} </td>
                                                    <td>{{ $student->email }} </td>
                                                    <td>{{ $student->phone }} </td>
                                                    <td>{{ $student->whatsapp_number }} </td>
                                                    <td>{{ $student->fathername }} </td>
                                                    <td>{{ $student->DOB }} </td>
                                                    <td>{{ $student->gender }} </td>
                                                    <td>{{ $student->address }} </td>
                                                    <td>{{ $student->city }} </td>
                                                    <td>{{ $student->pincode }} </td>
                                                    <td>{{ $student->community }} </td>
                                                    <td>{{ $student->qualification }} </td>
                                                    <td>{{ $student->board }} </td>
                                                    <td>{{ $student->subjects }} </td>
                                                    <td>{{ $student->percentage }} </td>
                                                    <td>{{ $student->passing_year }} </td>
                                                    <td>{{ $student->joiningdate }} </td>
                                                    <td>
                                                        <!-- Display course names based on course_id -->
                                                        @foreach($student->studentCourses as $course)
                                                            {{ $course->course->course_name }}<br>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <!-- Display batch times in another field -->
                                                        @foreach($student->studentCourses as $course)
                                                            {{ $course->batch }}<br>
                                                        @endforeach
                                                    </td>
                                                    
                                                <td>
                                                    <a class="edit-btn" href="{{url('/edit-students/' . $student->id )}}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path
                                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                            </path>
                                                        </svg>
                                                        Edit</a>
                                                </td>
                                                {{-- <td>
                                                    <a class="edit-btn" href="{{url('/payment-edit/' . $student->id)}}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                                            viewBox="0 0 320 512">
                                                            <path
                                                                d="M0 64C0 46.3 14.3 32 32 32H96h16H288c17.7 0 32 14.3 32 32s-14.3 32-32 32H231.8c9.6 14.4 16.7 30.6 20.7 48H288c17.7 0 32 14.3 32 32s-14.3 32-32 32H252.4c-13.2 58.3-61.9 103.2-122.2 110.9L274.6 422c14.4 10.3 17.7 30.3 7.4 44.6s-30.3 17.7-44.6 7.4L13.4 314C2.1 306-2.7 291.5 1.5 278.2S18.1 256 32 256h80c32.8 0 61-19.7 73.3-48H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H185.3C173 115.7 144.8 96 112 96H96 32C14.3 96 0 81.7 0 64z" />
                                                        </svg>
                                                    </a>
                                                </td> --}}
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="table-pagination">
                                    {{ $students->appends(['search' => $query])->links('pagination::bootstrap-4') }}
                                    <!-- <button class="pagination-btn-mb prev-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </button> -->
                                    {{-- <div class="results">
                                        <p>Showing 1 to 2 of 2 results</p>
                                    </div>
                                    <div class="entries ">
                                        <div
                                            class="form-group text-right d-flex align-items-center justify-content-center">
                                            <select class="form-select" id="entriesPerPage">
                                                <option>5</option>
                                                <option>10</option>
                                                <option>25</option>
                                                <option>20</option>
                                                <option>All</option>
                                            </select>
                                            <label for="entriesPerPage">
                                                <p class="ms-2">per page</p>
                                            </label>
                                        </div>
                                    </div> --}}
                                    <!-- <div class="pagination-col d-flex justify-content-end">
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination mb-0">
                                                <li class="page-item">
                                                    <a class="page-link" href="#" aria-label="Previous">
                                                        <span aria-hidden="true">
                                                            <span aria-hidden="true">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 20 20" fill="currentColor"
                                                                    aria-hidden="true">
                                                                    <path fill-rule="evenodd"
                                                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                                        clip-rule="evenodd"></path>
                                                                </svg>
                                                            </span>
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="page-item"><a class="page-link active" href="#">1</a></li>
                                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                                <li class="page-item">
                                                    <a class="page-link" href="#" aria-label="Next">
                                                        <span aria-hidden="true">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor" aria-hidden="true">
                                                                <path fill-rule="evenodd"
                                                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div> -->
                                    <!-- <button class="pagination-btn-mb next-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </button> -->
                                </div>
                            </div>
                        </div>
                            @else
                    <h5>No Student found.</h5>
                @endif
                        
                    </div>
                </div>
            </div>

        </div>


    <!-- Add jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/YOUR_API_KEY/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>


    <script>

function confirmDelete() {
            return confirm('Are you sure to delete ?');
        }

       
    </script>

    

    @endsection