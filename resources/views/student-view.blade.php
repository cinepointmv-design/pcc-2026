
@extends('layouts.admin-main')


@section('adminpage')
<div class="container">
    <div class="col-md-6 col-12 heading-wrapper">
        <h1> Student Detail</h1>
    </div>
    @foreach ($students as $student)
                
    <div class="form-card">
        <form action="{{url('/delete-single-student/' . $student->id )}}" class="create-form" method="post">
            @csrf
            
           
            <div class="row">
                <div class="col-md-4">
                    <label for="">Name<sup>*</sup></label>
                    <input hidden  name="student_id" id="student_id" type="text" required value="{{$student->id}}" readonly>
                    <input name="name" id="name" type="text" required value="{{$student->name}}" readonly>
                </div>

                <div class="col-md-4">
                    <label for="">Email<sup>*</sup></label>
                    <input name="email" type="email"  required value="{{$student->email}}" readonly>
                   
                </div>
                <div class="col-md-4">
                    <label for="">Mobile Number<sup>*</sup></label>
                    <input name="phone" type="tel" required value="{{$student->phone}}" readonly>
                </div>
                <div class="col-md-4">
                    <label for="">Whatsapp No.</label>
                    <input name="whatsapp_number" type="tel" value="{{$student->whatsapp_number}}" readonly>
                </div>
                <div class="col-md-4">
                    <label for="">Father's Name<sup></sup></label>
                    <input name="fathername" type="text" value="{{$student->fathername}}" readonly>
                </div>
                <div class="col-md-4">
                    <label for="">Date Of Birth<sup></sup></label>
                    <input name="DOB" id='DOB' type="date" value="{{$student->DOB}}" readonly>
                </div>
                <div class="col-md-4">
                    <label for="">Joining Date<sup></sup></label>
                    <input name="joiningdate" id='joiningdate' type="date" value="{{$student->joiningdate}}" readonly>
                </div>
                <div class="col-md-4">
                    <label for="">Gender<sup></sup></label>
                    <input name="DOB" id='DOB' type="text" value="{{$student->gender}}" readonly>
                </div>
                <div class="col-md-4">
                    <label for="">Address<sup></sup></label>
                    <input name="address" type="text" value="{{$student->address}}" readonly>
                </div>
                <div class="col-md-4">
                    <label for="">City<sup></sup></label>
                    <input name="city" type="text" value="{{$student->city}}" readonly>
                </div>
                <div class="col-md-4">
                    <label for="">Pincode<sup></sup></label>
                    <input name="pincode" type="number" value="{{$student->pincode}}" readonly>
                </div>
                <div class="col-md-4">
                    <label for="">Community</label>
                    <input name="community" type="text" value="{{$student->community}}" readonly>
                </div>
                <div class="col-md-4">
                    <label for="">Qualification</label>
                    <input name="qualification" type="text" value="{{$student->qualification}}" readonly>
                </div>
                {{-- <div class="col-md-4">
                    <label for="">Joining Date	</label>
                    <input name="qualification" type="date" value="{{$student->joiningdate}}" readonly>
                </div> --}}

                <hr>
                
                @php
               
                foreach ($student->studentCourses as $course) {
                    $data =  $course->course->course_name ;
                    $batch = $course->batch;

                    $batch_name = App\Models\Batch::where('id',$batch)->value('batch');
            
                @endphp

                <div class="col-md-6">
                    <label for="">Selected Course</label>
                    <input name="qualification" type="text" value="{{$data}}" readonly>
                </div>
                <div class="col-md-6">
                    <label for="">Batch Timing</label>
                    <input name="qualification" type="text" value="{{$batch_name}}" readonly>
                </div>
               @php }
               
               @endphp
               
                <div class="col-md-12">
                    <div class="form-btn-col">
                        <a href="" class= " btn view-payment-logs" data-student-id="{{ $student->id }}">View Payments log</a>
                        <a class="btn" href="{{url('/edit-students/' . $student->id )}}">Edit</a>
                        <button class="btn " onclick="return  confirmDelete()" type="submit" style="background: rgb(248, 54, 54)" href="" >Delete</button>
                        <button onclick="goback()" type="button" class="btn btn-second">Back</button>
                        
                    </div>
                </div>
            </div>
           
        </form>

        <div class="col-md-12 m-auto view-payment-log mt-5" style="display: none;">
            <div class="table-card">
                <div class="modal-header">
                    <h5 class="modal-title">Payment Logs</h5>
                    <button type="button" class="btn-close btn-close-payment-log" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="table-container">
                    <table class="table table-hover data-table">
                        <thead>
                            <tr>  
                                <th>Paid Amount</th>
                                <th>Payment Date</th>    
                            </tr>
                        </thead>
                        <tbody id="paymentLogTableBody">
                            <!-- Table rows will be dynamically added here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

  </div>
  @endforeach
</div>
    <!-- Add jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/YOUR_API_KEY/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>


    <script>
        $(document).ready(function () {
        $('.btn-close-payment-log').on('click', function () {
            location.reload();
            $('.view-payment-log').hide();
        });
    });

$(document).ready(function () {
        // Attach a click event handler to all elements with the class 'view-payment-logs'
        $('.view-payment-logs').on('click', function (e) {
            e.preventDefault();
            var studentId = $(this).data('student-id');
            $.ajax({
                type: 'GET',
                url: '{{ url("/student-payment-logs") }}' + '/' + studentId,
                dataType: 'json',
                success: function (data) {
                    console.log('Response Data:', data);
                    if (data.success) {
                        // Clear existing rows
                        $('#paymentLogTableBody').empty();

                        // Append rows for each payment log entry
                        $.each(data.paymentLogs, function (index, fee) {
                            var row = '<tr class="client-row">' +
                                '<td>' + fee.pay_amount + '</td>' +
                                '<td>' + fee.payment_date + '</td>' +
                                '</tr>';

                            $('#paymentLogTableBody').append(row);
                        });

                        // Show the payment log table
                        $('.view-payment-log').show();
                    } else {
                        console.error('Error fetching payment details:', data.message);
                    }
                },
                error: function (error) {
                    console.error('Error fetching payment details:', error);
                }
            });
        });
    });

function confirmDelete() {
            return confirm('Are you sure to delete ?');
        }

        $(document).ready(function() {
        $('#searchInput').on('input', function () {
            var searchText = $(this).val().toLowerCase();

            $.ajax({
                url: "{{ url('/search-students') }}",
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    searchText: searchText
                },
                success: function (response) {
                    console.log(response);

if (response && response.students && response.students.data && response.students.data.length > 0) {
    let studentsHtml = ''; // Initialize an empty string to store HTML

    // Loop through the data array in the response and construct table rows
    response.students.data.forEach(student => {
        let batchHtml = '';
        let course_name = '';

            // Loop through student courses to retrieve batch information
            student.student_courses.forEach(course => {
                batchHtml += `${course.batch} <br>`;
            });

            student.courses.forEach(course => {
                course_name += `${course.course_name} <br>`;
            });

        studentsHtml += `
            <tr class="client-row">
                <td>
                    <input type="checkbox" name="selected_students[]" class="select-checkbox" value="${student.id}">
                </td>
                <td>${student.name}</td>
                <td>${student.email}</td>
                <td>${student.phone}</td>
                <td>${student.whatsapp_number ? student.whatsapp_number : 'N/A'}</td>
                <td>${student.fathername ? student.fathername : 'N/A'}</td>
                <td>${student.DOB ? student.DOB : 'N/A'}</td>
                <td>${student.gender ? student.gender : 'N/A'}</td>
                <td>${student.address ? student.address : 'N/A'}</td>
                <td>${student.city ? student.city : 'N/A'}</td>
                <td>${student.pincode ? student.pincode : 'N/A'}</td>
                <td>${student.community ? student.community : 'N/A'}</td>
                <td>${student.qualification ? student.qualification : 'N/A'}</td>
                <td>${student.joiningdate}</td>`;
                studentsHtml += `   
                <td>${course_name}</td>
                <td>${batchHtml}</td>
            `;
            studentsHtml += ` 
                <td>
                    <a class="edit-btn" href="{{ url('/edit-students') }}/${student.id}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path
                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                            </path>
                        </svg>
                        Edit</a>
                </td>
            </tr>
        `;
    });

    // Update the table body with the constructed HTML
    $('#clientTableBody').html(studentsHtml);
} else {
    $('#clientTableBody').html('<tr><td colspan="2">No students found</td></tr>');
}
},
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    // Handle the error here if necessary
                }
            });
        });
    });
        
    </script>

    

    @endsection