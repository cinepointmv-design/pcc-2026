
@extends('layouts.admin-main')


@section('adminpage')
            <!-- table section -->
            <form action="{{url('/remove-lab')}}" method="post" >
                @csrf
            <div class="table-col">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 row align-items-center heading-wrapper">
                            <div class="col-md-6 col-12">
                                <h1>Labs</h1>
                            </div>
                            <div class="col-md-6 col-12">
                                <a href="{{url('/add-lab')}}" class="btn d-block ms-md-auto ms-none">Add Lab</a>
                            </div>
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
                                                    <button class="dropdown-item" href="{{url('/remove-lab')}}" onclick="return confirmDelete();">
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
                                        <!-- <div class="search-col">
                                            <div class="serach-input">
                                                <span class="search-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                    </svg>
                                                </span>
                                                <input type="search" placeholder="Search">
                                            </div>
                                        </div> -->
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
                                                <th>Lab Name</th>
                                                <th>Batch</th>
                                                <th>Total Seats</th>
                                                <th>Pending Seats</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($labs as $lab)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="selected_lab[]" class="select-checkbox" value="{{ $lab->id }}">
                                                </td>
                                                  <td>{{ $lab->lab_name }} </td>
                                                  <td><select name="batch" id="batch_{{ $lab->id }}">
                                                    <option value="">Select Batch</option>
                                                    @php                                                       
                                                        $lab =  App\Models\Lab::findOrFail($lab->id);
                                                        $batches = $lab->batches;
                                                    @endphp
                                                    @foreach ($batches as $batch)
                                                    <option value="{{ $batch->id }}">{{ $batch->batch }}</option>
                                                    @endforeach
                                                </select>
                                                  </td>
                                                <td name="total_seats" id="total_seats_{{ $lab->id }}">N/A</td>
                                                <td name="pending_seats" id="pending_seats_{{ $lab->id }}">N/A</td>
                                                <td>
                                                    <a class="edit-btn" href="{{url('/edit-lab/' . $lab->id)}}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path
                                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                            </path>
                                                        </svg>
                                                        Edit</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="table-pagination">
                                    {{ $labs->links('pagination::bootstrap-4') }}
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

    <script>
        function confirmDelete() {
            return confirm('Are you sure to delete?');
        }

        document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('select[name="batch"]').forEach(function (select) {
        select.addEventListener('change', function () {
            var batchId = this.value;
            var labId = this.id.split('_')[1];
            fetchSeats(batchId, labId);
        });
    });
});




function fetchSeats(batchId, labId) {
        $.ajax({
            // url: '/get-course-details/' + courseId,
            url: '{{ url("/fetch-seats") }}'+ '/' + batchId,
            method: 'GET',
            success: function (response) {
                document.getElementById('total_seats_' + labId).innerText = response.total_seats;
                document.getElementById('pending_seats_' + labId).innerText = response.pending_seats;
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            }
        });
    }

    </script>
    

    @endsection