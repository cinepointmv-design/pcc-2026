@extends('layouts.admin-main')

@section('adminpage')
  <div class="container">
    <div class="col-md-6 col-12 heading-wrapper">
        <h1>Search Student</h1>
    </div>
    <div class="form-card">
    <form id="searchForm" class="create-form">
        @csrf
      <div class="row">
        <div class="col-md-4">
          <label for="studentNumber" class="form-label">Student Number:</label>
          <input type="text"  id="studentNumber" name="studentNumber">
        </div>
        <div class="col-md-4">
          <label for="courseSelect" class="form-label">Select Course:</label>
          <select name="course" id="course" required>
            <option value="0">Select An Option</option>
            @foreach($courses as $course)
                @php
                    $selected = isset($course_id) && $course_id == $course->id ? 'selected' : '';
                    $disabled = $course->seats === 0 ? 'disabled' : '';
                @endphp
                <option value="{{ $course->id }}" {{ $selected }} {{ $disabled }}>
                    {{ $course->course_name }}{{ $course->seats === 0 ? ' (No Seats Available)' : '' }}
                </option>
            @endforeach
        </select>
        </div>
        <div class="col-md-4">
            <label for="">Lab No.<sup>*</sup></label>
            <input name="lab_number" id="lab_number" type="text" readonly>
        </div>
        <div class="col-md-4">
            <label for="startDate" class="form-label">Start Date:</label>
            <input type="date" id="startDate" name="startDate" max="<?php echo date("Y-m-d"); ?>">
        </div>
        <div class="col-md-4 mb-0">
            <label for="endDate" class="form-label">End Date:</label>
            <input type="date" id="endDate" name="endDate" value="<?php echo date("Y-m-d"); ?>" max="<?php echo date("Y-m-d"); ?>">
        </div>
        <div class="col-md-4 align-self-center">
          <button type="submit" class="btn btn-primary" style="padding: 11px 33px">Search Student</button>
        </div>
      </div>
    </form>

</div>
<div class="result mt-5"></div>
<div class="table-col" style="display: none;">
    <div class="">
        <div class="row">
            <div class="col-md-12 row align-items-center heading-wrapper">

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
                                    <th>Lab Name</th>    
                                    <th>Action</th>
                                  
                                </tr>
                            </thead>
                            <tbody  id="clientTableBody">
                                <tr class="client-row">
                                   
                                </tr>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    

    $(document).ready(function() {

        document.getElementById('endDate').addEventListener('change', function() {
        var endDate = new Date(this.value);
        var startDate = new Date(document.getElementById('startDate').value);
        var currentDate = new Date();

        // If the end date is earlier than the current date
        if (endDate < currentDate) {
            // Restrict the start date to not exceed the end date
            document.getElementById('startDate').max = this.value;

            // If the start date is later than the end date, adjust it to the end date
            if (startDate > endDate) {
                document.getElementById('startDate').value = this.value;
            }
        } else {
            // If the end date is the current date or future date, remove restrictions on the start date
            document.getElementById('startDate').max = "";
        }
    });

    // Set end date to present date
    document.getElementById('endDate').value = new Date().toISOString().substr(0, 10);

         // Function to fetch labs based on the selected course
         function fetchLabs(courseId) {
            // AJAX request to fetch labs associated with the selected course
            $.ajax({
                // url: '/get-course-details/'  + courseId, 
                url: '{{ url("/get-course-details") }}' + '/' +  courseId,
                method: 'GET',
                success: function(response) {
                    $('#lab_number').val(response.lab_number);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        // Event listener for Course dropdown change
        $('#course').change(function() {
            var selectedCourseId = $(this).val();

            if (selectedCourseId !== '0') { // Check if a course is selected
                fetchLabs(selectedCourseId); // Call the function to fetch labs
            } else {
                $('#lab_number').val(''); // Clear the Lab Number input if no course is selected
            }
        });


$('#searchForm').submit(function(event) {
    event.preventDefault(); // Prevent the default form submission

    // Get values from the filled input fields
    var studentNumber = $('#studentNumber').val();
    var courseId = $('#course').val();
    var labNumber = $('#lab_number').val();
    var startDate = $('#startDate').val();
    var endDate = $('#endDate').val();

    // AJAX request to fetch data based on input fields
    $.ajax({
        url: '{{url('/get-students-through-number')}}',
        method: 'POST',
        data: {
            "_token": "{{ csrf_token() }}",
            "studentNumber": studentNumber,
            "courseId": courseId,
            "labNumber": labNumber,
            "startDate": startDate,
            "endDate": endDate
        },
        success: function(response) {
    console.log(response);

    $('.table-col').slideDown();
    $('.result').empty();
    $('#clientTableBody').empty();

    if (response.student && response.student.length > 0 && response.lab && response.lab.length > 0) {
        var students = response.student;
        var labs = response.lab;

        students.forEach(function(student) {
            if (student.courses && student.courses.length > 0) {
                student.courses.forEach(function(course, index) {
                    var newRow = "<tr class='client-row'>";
                    
                    if (index === 0) {
                        newRow += "<td rowspan='" + student.courses.length + "'>" + (student.name ? student.name : 'N/A') + "</td>" +
                            "<td rowspan='" + student.courses.length + "'>" + (student.phone ? student.phone : 'N/A') + "</td>";
                    }

                    newRow += "<td>" + (course.course_name ? course.course_name : 'N/A') + "</td>";

                    // Find the corresponding lab_name based on course's lab_number
                    var matchingLab = labs.find(function(labItem) {
                        return labItem.id === course.lab_number;
                    });

                    newRow += "<td>" + (course.fees ? course.fees : 'N/A') + "</td>";

                    newRow += "<td>" + (matchingLab && matchingLab.lab_name ? matchingLab.lab_name : 'N/A') + "</td>";

                    

                    if (index === 0) {
                        newRow += "<td rowspan='" + student.courses.length + "'><a href='" + "{{ url('/fees-detail?student_id=') }}" + student.id + "'>View More</a></td>";
                    }

                    newRow += "</tr>";
                    $('#clientTableBody').append(newRow);
                });
            } else {
                var newRow = "<tr class='client-row'>" +
                    "<td>" + (student.name ? student.name : 'N/A') + "</td>" +
                    "<td>" + (student.phone ? student.phone : 'N/A') + "</td>" +
                    "<td colspan='3'>N/A</td>" +
                    "<td><a href='" + "{{ url('/fees-detail?student_id=') }}" + student.id + "'>View More</a></td>" +
                    "</tr>";

                $('#clientTableBody').append(newRow);
            }
        });
    } else {
        $('.table-col').slideUp();
        $('#clientTableBody').empty();
        $('.result').append("<h4>Student or lab data not found</h4>");
    }
},
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
             });      
          });
</script>
  
  @endsection
