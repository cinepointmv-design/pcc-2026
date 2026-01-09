
@extends('layouts.admin-main')


@section('adminpage')
            <!-- table section -->
            <form action="{{url('/remove-enquiry')}}" method="post" >
                @csrf
            <div class="table-col">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 row align-items-center heading-wrapper">
                            <div class="col-md-6 col-12">
                                <h1>FollowUps</h1>
                            </div>
                            {{-- <div class="col-md-6 col-12">
                                <a href="/create-enquiry" class="btn d-block ms-md-auto ms-none">New Enquiry</a>
                            </div> --}}
                        </div>
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

                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end">
                                        {{-- <div class="search-col">
                                            <div class="serach-input">
                                                <span class="search-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                    </svg>
                                                </span>
                                                <input id="searchInput" type="search" name="search" placeholder="Search">
                                            </div>
                                        </div> --}}
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
                                        
                                                {{-- <th>
                                                    <input type="checkbox" id="selectAll" > 
                                                </th> --}}
                                                <th>Name</th>
                                               
                                                <th>Phone</th>
                                                <th>followup_date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody  id="clientTableBody">
                                            {{-- @foreach ($enquiry as $enquiries) --}}
                                            @if ($enquiries)
                                                
                                            @foreach ($enquiries as $enquiry)
                                                
                                           
                                            <tr class="client-row">
                                                {{-- <td>
                                                    <input type="checkbox" name="selected_enquiries[]" class="select-checkbox" value="{{ $enquiries->id }}">
                                                </td> --}}
                                                    <td id="name">{{ $enquiry->enquiry->name }} </td>
                                                    
                                                    <td>{{ $enquiry->enquiry->phone }} </td>
                                                    {{-- <td>{{ $enquiries->whatsapp_number }} </td>
                                                    <td>{{ $enquiries->reference }} </td> --}}
                                                    {{-- <td>{{ $enquiries->course->course_name }}</td> --}}
                                                    {{-- <td>
                                                        @php
                                                            $course = App\Models\Courses::find($enquiries->course_id);
                                                        @endphp
                                                        {{ $course ? $course->course_name : 'N/A' }}
                                                    </td>
                                                    <td>{{ $enquiries->demo_date }}</td> --}}
                                                    <td>{{ $enquiry->enquiry->followup_date }}</td>
                                                    <td>{{ $enquiry->enquiry->status }}</td>
                                                    {{-- <td>{{ $enquiries->description }}</td> --}}
                                                    <td>
                                                        <a class="edit-btn" href="{{url('/view-followup/' . $enquiry->enquiry->id )}}">
                                                            
                                                            View</a>
                                                    </td>    
                                                    
                                                {{-- <td>
                                                    <a class="edit-btn" href="{{url('/edit-enquiry/' . $enquiries->enquiry->id )}}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path
                                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                            </path>
                                                        </svg>
                                                        Edit</a>
                                               
                                                    <a class="edit-btn ms-4"  href="{{url('/add-students/' . $enquiries->enquiry->id)}}">
                                                        Add Student
                                                    </a>
                                                </td> --}}
                                            </tr>
                                            @endforeach
                                            @endif
                                            {{-- @endforeach --}}
                                        </tbody>
                                    </table>
                                </div>
                                <div class="table-pagination">
                                    {{-- {{ $enquiry->links('pagination::bootstrap-4') }} --}}
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
                    </div>
                </div>
            </div>

        </div>
    </form>

    <!-- Add jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/YOUR_API_KEY/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>


    <script>
        function confirmDelete() {
            return confirm('Are you sure to delete?');
        }

        function fetchCourseName(courseId, rowId) {
    $.ajax({
        // url: `/fetch-course-name/${courseId}`, 
        url: '{{ url("/fetch-course-name") }}' + '/' + courseId,
        method: 'GET',
        success: function (courseResponse) {
            $(`#${rowId}`).html(courseResponse.course_name);
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
}
    
        $(document).ready(function () {
            $('#searchInput').on('keyup', function () {
                let searchText = $(this).val().trim();
                // Send an AJAX request to the server
                $.ajax({
                    url: '{{url('/search-enquiry')}}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        searchText: searchText
                    },
                    success: function (response) {
                        console.log(response);
                        // Clear the existing table body content
                        $('#clientTableBody').empty();
                        
                        // Check if response contains data in enquiry.data
                        if (response && response.enquiry && response.enquiry.data && response.enquiry.data.length > 0) {
                            // Loop through the response data and append to table body
                            response.enquiry.data.forEach(function (enquiry) {
                                let newRow = `
                                    <tr class="client-row">
                                        <td>
                                            <input type="checkbox" name="selected_enquiries[]" class="select-checkbox" value="${enquiry.id}"> 
                                        </td>
                                        <td>${enquiry.name ? enquiry.name : 'N/A'}</td>
                                        <td>${enquiry.email ? enquiry.email : 'N/A' }</td>
                                        <td>${enquiry.phone ? enquiry.phone : 'N/A'}</td>
                                        <td>${enquiry.whatsapp_number ? enquiry.whatsapp_number : 'N/A'}</td>
                                        <td>${enquiry.reference ? enquiry.reference : 'N/A'}</td>
                                        <td>${enquiry.course.course_name ? enquiry.course.course_name  : 'N/A'}</td>
                                        
                                        <td>${enquiry.demo_date ? enquiry.demo_date : 'N/A'}</td>
                                        <td>${enquiry.followup_date ? enquiry.followup_date : 'N/A'}</td>
                                        <td>${enquiry.description ? enquiry.description : 'N/A'}</td>
                                        <td>
                                            <a class="edit-btn" href="{{ url('/edit-enquiry') }}/${enquiry.id}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                </svg>
                                                Edit
                                            </a>
                                        
                                            
                                            <a class="edit-btn ms-4" href="{{ url('/add-students') }}/${enquiry.id}">
                                                Add Student
                                            </a>
                                        </td>
                                        <!-- Add other action columns as needed -->
                                    </tr>
                                `;
                                $('#clientTableBody').append(newRow);
                                
                                
                            });
                        } else {
                            // Show a message if no data is found
                            $('#clientTableBody').html('<tr><td colspan="11">No records found</td></tr>');
                        }
                    },
                    error: function (error) {
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>
    
    

    

    @endsection