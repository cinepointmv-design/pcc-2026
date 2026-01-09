<!-- resources/views/your_blade_file.blade.php -->

@extends('layouts.admin-main')

@section('adminpage')

<div id="dayRangeForm" class="create-form">
    <div class="col-md-12 col-12 mb-5">
        <div class="row">
            <div class="col-md-6 d-flex flex-column justify-content-center">
                <h1 class="">Fees Management</h1>
            </div>
            <div class="col-md-6">
                <label for="feeType" class="me-2">Select Fee Type:</label>
                <select id="feeType" class="form-select mx-auto">
                    <option value="upcoming">Upcoming Fees</option>
                    <option value="pending">Pending Fees</option>
                    <option value="completed">Completed Fees</option>
                    <option value="paid">Paid Fees</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row" id="dateInputs">
        <div class="col-md-4">
            <label for="startDate">Start date</label>
            <input type="date" id="startDate">
        </div>
        <div class="col-md-4">
            <label for="endDate">End date</label>
            <input type="date" id="endDate">
        </div>
        <div class="col-md-4 d-flex align-items-center">
            <button id="showFeesBtn" class="btn" style="padding: 9px 20px;">Show Fees</button>
        </div>
    </div>

    <div class="table-col" style="display: none;">
        <div class="">
            <div class="row">
                <div class="col-md-12 row align-items-center heading-wrapper">
                    <!-- Your table heading content -->
                </div>
                <div class="col-md-12 m-auto">
                    <div class="table-card">
                        <div class="table-container">
                            <table class="table table-hover data-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Course</th>
                                        <th>Course Fees</th>
                                        <th>Next Due Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="clientTableBody">
                                    <!-- Table body rows will be dynamically populated -->
                                </tbody>
                            </table>
                        </div>
                        <div class="table-pagination">
                            {{-- {{ $students->links('pagination::bootstrap-4') }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    
    $(document).ready(function() {

        $('#feeType').change(function () {
            const selectedFeeType = $(this).val();
            // Show/hide start and end date based on the selected fee type
            if (selectedFeeType === 'upcoming' || selectedFeeType === 'paid') {
                $('#dateInputs').show();
                // Fetch upcoming fees based on the selected date
                fetchFees($('#startDate').val(), $('#endDate').val(), selectedFeeType);
            }  else {
                $('#dateInputs').hide();
                // Fetch pending/completed fees without considering dates
                fetchFees(null, null, selectedFeeType);
            }
        });
        
        // $('#feeType').change(function () {
        //     const selectedFeeType = $(this).val();
        //     // Show/hide start and end date based on the selected fee type
        //     if (selectedFeeType === 'paid') {
        //         $('#dateInputs').show();
        //         // Fetch upcoming fees based on the selected date
        //         fetchFees($('#startDate').val(), $('#endDate').val(), selectedFeeType);
        //     } else {
        //         $('#dateInputs').hide();
        //         // Fetch pending/completed fees without considering dates
        //         fetchFees(null, null, selectedFeeType);
        //     }
        // });

        // Function to get the date for the next 7 days
        function getNext7Days() {
            const today = new Date();
            const next7Days = new Date(today);
            next7Days.setDate(next7Days.getDate() + 7);
            return next7Days.toISOString().split('T')[0];
        }

        // Set default dates to next 7 days
        const defaultStartDate = new Date().toISOString().split('T')[0];
        const defaultEndDate = getNext7Days();

        $('#startDate').val(defaultStartDate);
        $('#endDate').val(defaultEndDate);

        // Function to retrieve fees based on the selected type and date
        function fetchFees(startDate, endDate, feeType) {
            $.ajax({
                url: '{{ url('/get-upcoming-fees') }}',
                method: 'GET',
                data: {
                    startDate: startDate,
                    endDate: endDate,
                    feeType: feeType,
                },
                success: function(response) {
                    console.log(response);
                    if (response.students.length > 0) {
                        // Show the table
                        $('.table-col').show();

                        // Get the table body element
                        var tableBody = $('#clientTableBody');
                        tableBody.empty(); // Clear any existing rows

                        response.students.forEach(function (student) {
                            student.studentcourse.forEach(function (course, index) {
                                var row = '<tr>';
                                if (index === 0) {
                                    row += `<td rowspan="${student.studentcourse.length}">${student.student.name}</td>`;
                                    row += `<td rowspan="${student.studentcourse.length}">${student.student.phone}</td>`;
                                    row += `<td>${course.course.course_name}</td>`;
                                    row += `<td>${course.fees}</td>`;
                                    row += `<td rowspan="${student.studentcourse.length}">${student.next_due_date}</td>`;
                                    row += `<td rowspan="${student.studentcourse.length}"><a href="{{ url('/fees-detail?student_id=') }}${student.student.id}">View More</a></td>`;
                                } else {
                                    row += `<td>${course.course.course_name}</td>`;
                                    row += `<td>${course.fees}</td>`;
                                }
                                row += '</tr>';
                                tableBody.append(row);
                            });
                        });
                    } else {
                        // If no students found, hide the table
                        $('.table-col').hide();
                    }
                },
                error: function(error) {
                    console.error('Error:', error);
                    // Hide the table in case of error
                    $('.table-col').hide();
                }
            });
        }

        // Show next 7 days' upcoming fees on page load
        fetchFees(defaultStartDate, defaultEndDate, 'upcoming');

        // Event listener for the button click
        $('#showFeesBtn').click(function(event) {
            event.preventDefault();
            const startDate = $('#startDate').val();
            const endDate = $('#endDate').val();
            const feeType = $('#feeType').val();

            // Fetch fees based on the selected type and date
            fetchFees(startDate, endDate, feeType);
        });
    });
</script>

@endsection
