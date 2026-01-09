
@extends('layouts.admin-main')


@section('adminpage')
<div class="container">
    <div class="col-md-6 col-12 heading-wrapper">
        <h1> FollowUps Detail</h1>
    </div>
    @php
        // dd($enquiry);
        // die();
    @endphp
    @foreach ($enquiry as $student)
                
    <div class="form-card">
        <form action="{{url('/update-followup/' . $student->id )}}" class="create-form" method="post">
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
                    <label for="">Followup Date<sup></sup></label>
                    <input name="DOB" id='DOB' type="text" value="{{$student->followup_date}}" readonly>
                </div>
                
               
                <div class="col-md-4">
                    <label for="">Selected Course</label>
                    @php
                        $courses = json_decode($student->course_id); // Assuming 'course_id' is the field in the Enquiry model
                    @endphp
                
                    @if (!empty($courses))
                        @foreach ($courses as $courseId)
                            @php
                                $course = \App\Models\Courses::find($courseId);
                            @endphp
                            @if ($course)
                                <input name="course_names" type="text" value="{{ $course->course_name }}" readonly>
                                @if (!$loop->last)
                                    <br>
                                @endif
                            @endif
                        @endforeach
                    @else
                        <span>N/A</span>
                    @endif
                </div>
                
                <div class="col-md-4">
                    <label for="">Course Fees</label>
                    @if (!empty($courses))
                        @foreach ($courses as $courseId)
                            @php
                                $course = \App\Models\Courses::find($courseId);
                            @endphp
                            @if ($course)
                                <input name="course_fees" type="text" value="{{ $course->fees }}" readonly>
                                @if (!$loop->last)
                                    <br>
                                @endif
                            @endif
                        @endforeach
                    @else
                        <span>N/A</span>
                    @endif
                </div>
                
                
                

                {{-- <div class="col-md-12">
                    <label for="">Description	</label>
                    <textarea name="" id="" cols="30" rows="3">{{$student->description}}</textarea>
                </div> --}}

                <hr>

                @if (!$followup->isEmpty())
                    
                <div class="col-md-12 col-12 heading-wrapper mb-2 mt-2">
                    <h1> Call Log</h1>
                
                </div>
                @foreach ($followup as $followupdetail)
                <div class="col-md-2">
                    <label for="">Call  Date	</label>
                    <input name="qualification" type="date" value="{{$followupdetail->call}}" readonly>
                </div>
                <div class="col-md-2">
                    <label for="">Call  Time	</label>
                    <input name="qualification" type="time" value="{{$followupdetail->time}}" readonly>
                </div>
                <div class="col-md-3">
                    <label for="">Status	</label>
                    <input name="qualification" type="text" value="{{$followupdetail->status}}" readonly>
                </div>

                <div class="col-md-5">
                    <label for="">Description	</label>
                    <input name="qualification" type="text" value="{{$followupdetail->description}}" readonly>
                </div>
                

                @endforeach

                <hr class="my-2">

                @endif

                

                <div class="col-md-12 col-12 heading-wrapper mb-3 mt-3">
                    <h1> Update followUp</h1>
                
                </div>
       
                <div class="col-md-6">
                    <label for="">Followup Date<sup></sup></label>
                    <input name="followup_date" id='followup_date' type="date" value="{{$student->followup_date}}">
                </div>

                <div class="col-md-6">
                    <label for="">Status<sup></sup></label>
                    <select name="status" id="status">
                        <option value="open" {{ $student->status === 'open' ? 'selected' : '' }}>Open</option>
                        <option value="close" {{ $student->status === 'close' ? 'selected' : '' }}>Close</option>
                        <option value="lead" {{ $student->status === 'lead' ? 'selected' : '' }}>Lead</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="">Description <sup></sup></label>
                    <textarea name="followupDescription" id="followupDescription" cols="30" rows="2">{{$student->description}}</textarea>
                </div>
               
                <div class="col-md-12">
                    <div class="form-btn-col">
                        {{-- <a class="btn" href="{{url('/update-followup/' . $student->id )}}">Update</a> --}}
                        <button class="btn " onclick="confirmUpdate()" type="submit" >Update</button>
                        <a class="btn" onclick="confirmUpdate()" href="{{url('/delete-followups/' . $student->id )}}" style="background: rgb(248, 54, 54)">Delete</a>
                        <button onclick="goback()" type="button" class="btn btn-second">Back</button>
                    </div>
                </div>
            </div>
           
        </form>

  </div>
  @endforeach
</div>
    <!-- Add jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/YOUR_API_KEY/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>


    <script>


document.addEventListener('DOMContentLoaded', function () {
        // Get the form element
        var form = document.querySelector('.create-form');

        // Add a submit event listener to the form
        form.addEventListener('submit', function (event) {
            // Prompt the user for confirmation
            var confirmation = confirm('Are you sure to update?');

            // If user clicks "Cancel," prevent the form submission
            if (!confirmation) {
                event.preventDefault();
            }
        });

        // Your other script code...
    });


function confirmDelete() {
            return confirm('Are you sure to delete?');
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