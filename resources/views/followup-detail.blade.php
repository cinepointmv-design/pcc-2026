@extends('layouts.admin-main')

@section('adminpage')
    <!-- table section -->
    <form>
        <div class="table-col">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-12 mb-5">
                        <div class="row">
                            <div class="col-md-6 d-flex flex-column justify-content-center">
                                <h1 class="">FollowUps Details</h1>
                            </div>
                        </div>
                    </div>

                    <div class="row create-form mb-5" id="dateInputs">
                        <div class="col-md-2">
                            <label for="followup-status" class="me-2">Select Status</label>
                            <select id="followup-status" class="form-select mx-auto">
                                <option value="all">All</option>
                                <option value="open">Open</option>
                                <option value="close">Close</option>
                                <option value="lead">Lead</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="startDate">Start date</label>
                            <input type="date" id="startDate">
                        </div>
                        <div class="col-md-3">
                            <label for="endDate">End date</label>
                            <input type="date" id="endDate">
                        </div>
                        <div class="col-md-2 d-flex align-items-center">
                            <button id="showResult" class="btn" style="padding: 9px 30px;">Show Result</button>
                        </div>
                        <div class="col-md-2 d-flex align-items-center">
                            <button id="clearResult" class="btn" style="padding: 9px 30px;">Clear Result</button>
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
                                                <button type="submit" class="dropdown-item" id="deleteBtn"
                                                    onclick="return confirmDelete();">
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
                                <div class="col-md-6 d-flex justify-content-end"></div>
                            </div>

                            <div class="table-container">
                                <table class="table table-hover data-table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            {{-- <th>Email</th> --}}
                                            <th>Phone</th>
                                            <th>followup_date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody id="clientTableBody">

                                    </tbody>
                                </table>
                            </div>
                            <div class="table-pagination">
                                {{-- {{ $enquiry->links('pagination::bootstrap-4') }} --}}
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

        function fetchResults(url) {
            var formData = {
                status: $('#followup-status').val(),
                startDate: $('#startDate').val(),
                endDate: $('#endDate').val(),
                _token: '{{ csrf_token() }}'
            };

            $.ajax({
                type: 'get',
                url: url,
                data: formData,
                dataType: 'json',
                success: function (data) {
                    // Update the table body with the fetched data
                    updateTableBody(data.enquiries.data);
                    updatePagination(data.enquiries, formData.status);
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }

        // Function to update the table body
        function updateTableBody(enquiries) {
            var tableBody = $('#clientTableBody');
            tableBody.empty(); // Clear existing data

            // Append the new data to the table body
            $.each(enquiries, function (index, enquiry) {
                var row = "<tr class='client-row'>" +
                    "<td id='name'>" + enquiry.name + "</td>" +
                    
                    "<td>" + enquiry.phone + "</td>" +
                    "<td>" + enquiry.followup_date + "</td>" +
                    "<td>" + enquiry.status + "</td>" +
                    "<td><a class='edit-btn' href='{{ url('/view-followup/') }}/" + enquiry.id + "'>View</a></td>" +
                    "</tr>";

                tableBody.append(row);
            });
        }

        function updatePagination(pagination, status) {
    var paginationHtml = '<nav aria-label="Page navigation"><ul class="pagination">';

    // Add the previous arrow if available
    if (pagination.prev_page_url) {
        paginationHtml += '<li class="page-item"><a class="page-link" href="' + addStatusToUrl(pagination.prev_page_url, status) + '">«</a></li>';
    }

    // Add the next arrow if available
    if (pagination.next_page_url) {
        paginationHtml += '<li class="page-item"><a class="page-link" href="' + addStatusToUrl(pagination.next_page_url, status) + '">»</a></li>';
    }

    paginationHtml += '</ul></nav>';

    $(".table-pagination").html(paginationHtml);
}







        // Helper function to add status to the URL
        function addStatusToUrl(url, status) {
            // Check if the URL already contains a query string
            if (url.includes('?')) {
                return url + '&status=' + status;
            } else {
                return url + '?status=' + status;
            }
        }

        $(document).ready(function () {
            // Call the fetchResults function when the document is ready
            fetchResults('{{ url('/filter-enquiry') }}');

            // Show Result button click event
            $('#showResult').click(function (e) {
                e.preventDefault();
                fetchResults('{{ url('/filter-enquiry') }}');
            });

            // Next button click event
            $('.table-pagination').on('click', '.pagination a', function (e) {
                e.preventDefault();
                var pageUrl = $(this).attr('href');
                fetchResults(pageUrl);
            });

            // Clear Result button click event
            $('#clearResult').click(function (e) {
                e.preventDefault();
                // Clear the values of the status, start date, and end date fields
                $('#followup-status').val('all');
                $('#startDate').val('');
                $('#endDate').val('');
                // Trigger the logic to fetch and display all results
                fetchResults('{{ url('/filter-enquiry') }}');
            });
        });
    </script>
@endsection
