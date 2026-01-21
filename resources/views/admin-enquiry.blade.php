@extends('layouts.admin-main')

@section('adminpage')

<style>
    /* Filter Styles */
    .filter-dropdown-content {
        display: none; /* Hidden by default */
        background-color: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .filter-group label { font-size: 12px; font-weight: 600; color: #555; margin-bottom: 6px; display: block; }
    .filter-select { width: 100%; padding: 8px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; color: #333; outline: none; }
    .filter-select:focus { border-color: #4361ee; }
    
    .filter-btn {
        background: #fff; border: 1px solid #ccc; padding: 8px 15px; border-radius: 6px; 
        color: #333; cursor: pointer; font-weight: 500; display: flex; align-items: center; gap: 8px;
        transition: all 0.2s; font-size: 14px;
    }
    .filter-btn:hover, .filter-btn.active { background: #f8f9fa; border-color: #999; color: #000; }
    .result-count { font-size: 13px; font-weight: 600; color: #4361ee; margin-left: 10px; }
    
    /* Clear Button Style */
    .btn-clear-filters {
        font-size: 13px; font-weight: 500; text-decoration: none; color: #dc3545; 
        display: inline-flex; align-items: center; gap: 5px; cursor: pointer;
        padding: 6px 12px; border: 1px solid #ffccd0; border-radius: 6px; background: #fff0f1;
        transition: 0.2s;
    }
    .btn-clear-filters:hover { background: #ffe5e7; border-color: #dc3545; }
</style>

<form action="{{url('/remove-enquiry')}}" method="post">
    @csrf
    <div class="table-col">
        <div class="container">
            <div class="row">
                <div class="col-md-12 row align-items-center heading-wrapper">
                    <div class="col-md-6 col-12">
                        <h1>Enquiries</h1>
                    </div>
                    <div class="col-md-6 col-12">
                        <a href="{{url('/create-enquiry')}}" class="btn d-block ms-md-auto ms-none">New Enquiry</a>
                    </div>
                </div>

                <div class="col-md-12 m-auto">
                    <div class="table-card">
                        
                        <div id="filterPanel" class="filter-dropdown-content">
                            <div class="row align-items-end">
                                <div class="col-md-3 mb-2">
                                    <div class="filter-group">
                                        <label>Date Range</label>
                                        <select id="dateFilter" class="filter-select">
                                            <option value="all">All Time</option>
                                            <option value="today">Today</option>
                                            <option value="yesterday">Yesterday</option>
                                            <option value="5_days">Last 5 Days</option>
                                            <option value="1_week">Last 1 Week</option>
                                            <option value="1_month">Last 1 Month</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-2">
                                    <div class="filter-group">
                                        <label>Course</label>
                                        <select id="courseFilter" class="filter-select">
                                            <option value="all">All Courses</option>
                                            @foreach($courses as $course)
                                                <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-2">
                                    <div class="filter-group">
                                        <label>Status</label>
                                        <select id="statusFilter" class="filter-select">
                                            <option value="all">All Status</option>
                                            <option value="open">Open</option>
                                            <option value="close">Close</option>
                                            <option value="lead">Lead</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-2 text-end">
                                    <button type="button" id="clearFiltersBtn" class="btn-clear-filters">
                                        <i class="fa fa-times-circle"></i> Clear Filters
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="table-header d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="dropdown profile-dropdown delete-dropdown" id="delete-dropdown">
                                    <button class="delete-btn" type="button" data-bs-toggle="dropdown">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <button type="submit" class="dropdown-item" id="deleteBtn" onclick="return confirmDelete();">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span>Delete Selected</span>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="filter-btn" id="toggleFilterBtn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
                                    </svg>
                                    Filters
                                </button>

                                <div class="search-col">
                                    <div class="serach-input">
                                        <span class="search-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                        </span>
                                        <input id="searchInput" type="search" name="search" placeholder="Search..." onkeydown="return event.key != 'Enter';">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="px-3 pb-2">
                            <span id="resultCountBadge" class="result-count" style="display:none;">0 Results Found</span>
                        </div>

                        <div class="table-container">
                            <table class="table table-hover data-table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Course</th>
                                        <th>Enquiry Date</th>
                                        <th>Followup Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="clientTableBody">
                                    @foreach ($enquiry as $enquiries)
                                    <tr class="client-row">
                                        <td>
                                            <input type="checkbox" name="selected_enquiries[]" class="select-checkbox" value="{{ $enquiries->id }}">
                                        </td>
                                        <td id="name">{{ $enquiries->name }}</td>
                                        <td><a href="https://wa.me/+91{{ $enquiries->phone }}">{{ $enquiries->phone }}</a></td>
                                        <td>
                                            @php $courseIds = json_decode($enquiries->course_id); @endphp
                                            @if ($courseIds)
                                                @foreach ($courseIds as $courseId)
                                                    @php $course = App\Models\Courses::find($courseId); @endphp
                                                    {{ $course ? $course->course_name : 'N/A' }}@if (!$loop->last), <br>@endif
                                                @endforeach
                                            @else N/A @endif
                                        </td>
                                        <td>{{ $enquiries->enquirydate }}</td>
                                        <td>{{ $enquiries->followup_date }}</td>
                                        <td>{{ $enquiries->status }}</td>
                                        <td>
                                            <a class="edit-btn" href="{{url('/edit-enquiry/' . $enquiries->id )}}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                </svg>
                                                Edit
                                            </a>
                                            @if ($enquiries->status !== 'lead')
                                            <a class="edit-btn ms-4" href="{{url('/add-students/' . $enquiries->id)}}">Add Student</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-pagination">
                            {{ $enquiry->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    // 1. Toggle Filter Panel
    $('#toggleFilterBtn').click(function() {
        $('#filterPanel').slideToggle('fast');
        $(this).toggleClass('active');
    });

    // 2. Select All Checkbox
    document.getElementById('selectAll').addEventListener('change', function() {
        let checkboxes = document.querySelectorAll('.select-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    function confirmDelete() { return confirm('Are you sure to delete?'); }

    // 3. Helper for Courses
    const allCourses = @json($courses); 

    function getCourseNamesHtml(courseIdArray) {
        if (!courseIdArray) return 'N/A';
        let names = [];
        courseIdArray.forEach(id => {
            let course = allCourses.find(c => c.id == id);
            if(course) names.push(course.course_name);
        });
        return names.join(', <br>');
    }

    // 4. MAIN SEARCH FUNCTION
    function fetchResults() {
        let searchText = $('#searchInput').val().trim();
        let dateFilter = $('#dateFilter').val();
        let statusFilter = $('#statusFilter').val();
        let courseFilter = $('#courseFilter').val();

        $.ajax({
            url: '{{url("/search-enquiry")}}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                searchText: searchText,
                dateFilter: dateFilter,
                statusFilter: statusFilter,
                courseFilter: courseFilter
            },
            success: function (response) {
                $('#clientTableBody').empty();

                if (response.status === 'success' && response.enquiry.length > 0) {
                    
                    // Show Count
                    $('#resultCountBadge').text(response.count + ' Results Found').show();

                    // Build Rows
                    response.enquiry.forEach(enquiry => {
                        let courseIds = JSON.parse(enquiry.course_id);
                        let courseHtml = getCourseNamesHtml(courseIds);
                        
                        let addStudentBtn = '';
                        if(enquiry.status !== 'lead') {
                            addStudentBtn = `<a class="edit-btn ms-4" href="{{ url('/add-students') }}/${enquiry.id}">Add Student</a>`;
                        }

                        let row = `
                            <tr class="client-row">
                                <td><input type="checkbox" name="selected_enquiries[]" class="select-checkbox" value="${enquiry.id}"></td>
                                <td id="name">${enquiry.name}</td>
                                <td><a href="https://wa.me/+91${enquiry.phone}">${enquiry.phone}</a></td>
                                <td>${courseHtml}</td>
                                <td>${enquiry.enquirydate || ''}</td>
                                <td>${enquiry.followup_date || ''}</td>
                                <td>${enquiry.status}</td>
                                <td>
                                    <a class="edit-btn" href="{{ url('/edit-enquiry') }}/${enquiry.id}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="16" height="16">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                        </svg> Edit
                                    </a>
                                    ${addStudentBtn}
                                </td>
                            </tr>
                        `;
                        $('#clientTableBody').append(row);
                    });

                    $('.table-pagination').hide(); 
                } else {
                    $('#resultCountBadge').text('0 Results Found').show();
                    $('#clientTableBody').html('<tr><td colspan="11" class="text-center">No records found</td></tr>');
                    $('.table-pagination').hide();
                }
            },
            error: function (e) { console.error(e); }
        });
    }

    // 5. Event Listeners
    $(document).ready(function() {
        $('#searchInput').on('keyup', fetchResults);
        $('#dateFilter').on('change', fetchResults);
        $('#statusFilter').on('change', fetchResults);
        $('#courseFilter').on('change', fetchResults);

        // CLEAR FILTERS Logic
        $('#clearFiltersBtn').click(function() {
            // Reset dropdowns to 'all'
            $('#dateFilter').val('all');
            $('#statusFilter').val('all');
            $('#courseFilter').val('all');
            
            // Clear text
            $('#searchInput').val('');
            
            // Fetch default results
            fetchResults();
        });
    });
</script>

@endsection