@extends('layouts.admin-main')

@section('adminpage')
    <!-- form section -->
    <div class="form-col">
        <!-- ... (other HTML content) ... -->
        <div class="col-md-12 mb-4">
            <div class="form-step">
                <ul class="form-stepper form-stepper-horizontal mx-auto">
                    <!-- Step 1 -->
                    <li class="form-stepper-completed text-center form-stepper-list" step="1">
                        <a class="mx-2">
                            <span class="form-stepper-circle">
                                <span>1</span>
                            </span>
                            <div class="label">Edit Student</div>
                        </a>
                    </li>
                    <!-- Step 2 -->
                    <li class="form-stepper-active text-center form-stepper-list" step="2">
                        <a class="mx-2">
                            <span class="form-stepper-circle text-muted">
                                <span>2</span>
                            </span>
                            <div class="label text-muted">Select Course</div>
                        </a>
                    </li>
                    <!-- Step 3 -->
                    <li class="form-stepper-unfinished text-center form-stepper-list" step="3">
                        <a class="mx-2">
                            <span class="form-stepper-circle text-muted">
                                <span>3</span>
                            </span>
                            <div class="label text-muted">Payment</div>
                        </a>
                    </li>
                    <!-- Step 4 -->
                    <li class="form-stepper-unfinished text-center form-stepper-list" step="4">
                        <a class="mx-2">
                            <span class="form-stepper-circle text-muted">
                                <span>4</span>
                            </span>
                            <div class="label text-muted">Done</div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-12 m-auto">
                <form id="service-form" class="create-form" method='get' action="{{url('/save-edit-student-course')}}" onsubmit="submitServiceForms(event)">
                @csrf
                <div class="row gx-0">
                    <div id="service-forms">
                        {{-- @php
                           echo "<pre>";
                            print_r($studentCourses);
                            die();
                        @endphp --}}
                        @foreach($coursesWithBatches as $course)
                        <div class="form-card mb-4" >
                            
                            <div class="close-btn" onclick="deleteService(this)"  data-course-id="{{ $course->id }} "data-student-id="{{$student_id}}" style="text-align: right; margin-bottom: 10px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                    <path d="M3.646 3.646a.5.5 0 0 1 .708 0L8 7.293l4.646-4.647a.5.5 0 0 1 .708.708L8.707 8l4.647 4.646a.5.5 0 0 1-.708.708L8 8.707l-4.646 4.647a.5.5 0 0 1-.708-.708L7.293 8 2.646 3.354a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </div>
                            <fieldset>
                                <legend>Course Detail</legend>
                                <div class="row"> 
                                    <div class="col-md-12">
                                        <label for="">Courses<sup>*</sup></label>
                                        <select name="course" id="course" required>
                                                <option  value="{{ $course->id }}">{{ $course->course_name }}</option>
                                            
                                        </select>
                                    </div>
                                   
                                    

                                   
                                        <?php
                                        foreach ($course->studentCourses as $studentCourse) {
                                            $selectedBatch = $studentCourse->batch; // Assuming this is the selected 
                                             
                                            $batch_name = App\Models\Batch::where('id',$selectedBatch)->value('batch');
                                            // echo $batch_name;
                                        }
                                        ?>

                                         

                                    <div class="col-md-6">
                                        <label for="">Batch<sup>*</sup></label>
                                        <select name="batch" id="batch" required data-selected-batch="{{ $selectedBatch }}">
                                            <option value="0">Select An Option</option>
                                            
                                            <!-- Batch options will be populated dynamically using JavaScript -->
                                        </select>
                                    </div>

                                    

                                    <div class="col-md-6">
                                        <label for="">Course Fees<sup>*</sup></label>
                                        <input name="fees" id="fees" type="number" required value="{{$course->fees}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Duration Of Course<sup>*</sup></label>
                                        <input name="duration" id="duration" type="number"  value="{{$course->duration}}">
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <label for="">Seats<sup>*</sup></label>
                                        <input name="seats" id="seats" type="number" required>
                                    </div> --}}
                                    <div class="col-md-6">
                                        <label for="">Lab No.<sup>*</sup></label>
                                        <input name="lab_number" id="lab_number" type="text" readonly value="{{$course->lab->lab_name}}">
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        @endforeach
                    </div>
                   
                   
                    <div class="col-md-12">
                        <div class="form-btn-col">
                            <button type="button" onclick="addMoreService()" class="btn">Add More</button>
                            <button type="submit"  onclick="submitServiceForms()" class="btn">Next</button>
                            <button onclick="goback()" type="button" class="btn btn-second">Back</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- Add jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
  

$(document).on('change', 'select[name="course"]', function () {
    var courseId = $(this).val();
    var formSection = $(this).closest('.form-card');

    $.ajax({
        url: '{{ url("/get-batches-by-lab-number") }}' + '/' + courseId,
        method: 'GET',
        success: function (response) {
            // Clear previous options
            formSection.find('select[name="batch"]').empty();

            // Populate batch options
            $.each(response.batch, function(index, batch) {
                const availableSeats = batch.pending_seats;
                const optionText = `${batch.batch} - Available Seats: ${availableSeats}/${batch.total_seats}`;
                if (availableSeats > 0) {
                    formSection.find('select[name="batch"]').append(`<option value="${batch.id}">${optionText}</option>`);
                } else {
                    formSection.find('select[name="batch"]').append(`<option value="${batch.id}" disabled>${optionText} (No Seats Available)</option>`);
                }
            });

            // Pre-select the batch that comes from the database
            var selectedBatchId = '{{ $selectedBatch->batch ?? null }}'; // Assuming $selectedBatch is passed from the backend
            if (selectedBatchId) {
                formSection.find('select[name="batch"]').val(selectedBatchId);
            }
        },
        error: function (xhr) {
            console.log(xhr.responseText);
        }
    });
});

$(document).ready(function() {
    // Function to fetch batches for each course on page load
    function fetchBatchesForSelectedCourses() {
        // Loop through each form section
        $('.form-card').each(function() {
            var courseId = $(this).find('select[name="course"]').val();
            var formSection = $(this);
            var selectedBatchId = formSection.find('select[name="batch"]').data('selected-batch');

            // Make AJAX request to fetch batches for the selected course
            $.ajax({
                url: '{{ url("/get-batches-by-lab-number") }}' + '/' + courseId,
                method: 'GET',
                success: function (response) {
                    // Clear previous options
                    formSection.find('select[name="batch"]').empty();

                    // Populate batch options
                    $.each(response.batch, function(index, batch) {
                        const availableSeats = batch.pending_seats;
                        const optionText = `${batch.batch} - Available Seats: ${availableSeats}/${batch.total_seats}`;
                        if (availableSeats > 0) {
                            // Create an option element
                            var option = $('<option>', {
                                value: batch.id,
                                text: optionText
                            });

                            // Check if this batch is the selected one
                            if (selectedBatchId == batch.id) {
                                option.prop('selected', true);
                            }

                            // Append the option to the select element
                            formSection.find('select[name="batch"]').append(option);
                        } else {
                            // Create and append a disabled option for batches with no available seats
                            formSection.find('select[name="batch"]').append(`<option value="${batch.id}" disabled>${optionText} (No Seats Available)</option>`);
                        }
                    });
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    }

    // Call the function to fetch batches for selected courses on page load
    fetchBatchesForSelectedCourses();
});

       

document.addEventListener('DOMContentLoaded', function() {
    flatpickr('#start_batch', {
        enableTime: true,
        noCalendar: true,
        dateFormat: 'h:i K', // Format to display hours, minutes, and AM/PM
        time_24hr: false, // Use 12-hour format
    });

    flatpickr('#end_batch', {
        enableTime: true,
        noCalendar: true,
        dateFormat: 'h:i K', // Format to display hours, minutes, and AM/PM
        time_24hr: false, // Use 12-hour format
    });
});   

function validateAllForms() {
    let isValid = true;

    // Loop through each form section
    $('.form-card').each(function() {
        // Find all input elements within this form section
        const inputs = $(this).find('input[required], select[required]');
        
        // Check if any required field is empty
        inputs.each(function() {
            if ($(this).val() === '' || ($(this).is('select') && $(this).val() === '0')) {
                isValid = false;
                return false; // Exit the loop early if any field is empty
            }
        });
        
        if (!isValid) {
            return false; // Exit the loop early if any field is empty
        }
    });

    return isValid;
}


function submitServiceForms(event) {
    event.preventDefault();
    // Validate all forms before submitting
    const isAllValid = validateAllForms();
    // Gather data from all form sections

    if (isAllValid) {
    let formData = [];
    $('.form-card').each(function(index) {
        let batchText = $(this).find('#batch option:selected').text();
        let startTime = batchText.substring(0, batchText.indexOf(' to'));
        let endIndex = batchText.indexOf('-') - 1;
        let endTime = batchText.substring(batchText.indexOf(':') - 2, endIndex).trim();
        let newIndex = endTime.indexOf('to') + 3; // Get the index of 'to' and move 3 characters ahead to skip 'to '
        let endBatch = endTime.substring(newIndex).trim();

        let courseData = {
            course: $(this).find('select[name="course"]').val(),
            // batch: $(this).find('select[name="batch"]').val(),
            fees: $(this).find('input[name="fees"]').val(),
            duration: $(this).find('input[name="duration"]').val(),
            lab_number: $(this).find('input[name="lab_number"]').val(),
            batch: $(this).find('#batch').val(), // Assuming the start time is in a separate input
            start_batch: startTime,
            end_batch: endBatch,
            // Add more fields if needed
        };
        formData.push(courseData);
    });
    
console.log(formData);

    // Submit all form data
    $.ajax({
        url: '{{url('/save-edit-student-course')}}',
        method: 'get',
        data: { 
            "_token": "{{ csrf_token() }}",
            "courses" : formData 
        },
        success: function (response) {
            // Handle success response
            console.log(response);
            window.location.href = "{{ url('/save-edit-student-course') }}";
        },
        error: function (xhr) {
            // Handle error response
            console.log(xhr.responseText);
        }
    });
}else{
    
    alert('Please fill in all required fields.');
}
}




function removeLastService() {
        let serviceForms = $('.form-card');
        if (serviceForms.length > 1) {
            serviceForms.last().remove(); // Remove the last added service form
        } else {
            alert("Cannot remove the last service form.");
        }
    }

 


$(document).ready(function () {

    // Event listener for course selection change
    $(document).on('change', 'select[name="course"]', function () {
        var courseId = $(this).val();
        var formSection = $(this).closest('.form-card');
        var selectedCourses = []; // Array to store selected courses

        // Get all selected courses
        $('select[name="course"]').each(function () {
            selectedCourses.push($(this).val());
        });

        // Check if the selected course has already been chosen
        var count = 0;
        for (var i = 0; i < selectedCourses.length; i++) {
            if (selectedCourses[i] == courseId) {
                count++;
            }
        }

        // If the selected course has been chosen more than once, display alert and reset form
        if (count > 1) {
            alert('This course is already selected.');
            $(this).val('0'); // Reset the selected value
            formSection.find('input[name="fees"]').val('');
            formSection.find('input[name="duration"]').val('');
            formSection.find('input[name="lab_number"]').val('');
            return;
        }



            $.ajax({
                // url: '/get-course-details/' + courseId,
                url: '{{ url("/get-course-details") }}' + '/' + courseId,
                method: 'GET',
                success: function (response) {
                    formSection.find('input[name="fees"]').val(response.fees);
                    formSection.find('input[name="duration"]').val(response.duration);
                    formSection.find('input[name="lab_number"]').val(response.lab_number);
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

    // Add more service form sections
   // Function to add more service forms
   function addMoreService() {
    let serviceCounter = $('.form-card').length + 1;
    const serviceFormsContainer = $('#service-forms');
    const serviceFormTemplate = $('.form-card').first().clone(true);

    serviceFormTemplate.find('legend').text(`Course Detail ${serviceCounter}`);
    serviceFormTemplate.find('select[name="course"]').val(''); // Reset the course selection

    // Clear other input fields
    serviceFormTemplate.find('select[name="batch"]').val('');
    serviceFormTemplate.find('input[name="fees"]').val('');
    serviceFormTemplate.find('input[name="duration"]').val('');
    serviceFormTemplate.find('input[name="lab_number"]').val('');

    // Append close icon only for additional forms
    if (serviceCounter > 1) {
        serviceFormTemplate.find('.close-btn').remove(); // Remove deleteService button
        serviceFormTemplate.prepend(`
            <div class="close-icon" style="text-align: right; margin-bottom: 10px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                    <path d="M3.646 3.646a.5.5 0 0 1 .708 0L8 7.293l4.646-4.647a.5.5 0 0 1 .708.708L8.707 8l4.647 4.646a.5.5 0 0 1-.708.708L8 8.707l-4.646 4.647a.5.5 0 0 1-.708-.708L7.293 8 2.646 3.354a.5.5 0 0 1 0-.708z"/>
                </svg>
            </div>
        `);                    
    }

    // // Initialize batch time pickers for the newly added form sections
    // const startTimePicker = serviceFormTemplate.find('.start_batch');
    // const endTimePicker = serviceFormTemplate.find('.end_batch');

    // flatpickr(startTimePicker[0], {
    //     enableTime: true,
    //     noCalendar: true,
    //     dateFormat: 'h:i K',
    //     time_24hr: false,
    // });

    // flatpickr(endTimePicker[0], {
    //     enableTime: true,
    //     noCalendar: true,
    //     dateFormat: 'h:i K',
    //     time_24hr: false,
    // });

    // Fetch course list and populate the select dropdown
    $.ajax({
        url: '{{url('/get-course-list')}}', // Replace with your route for fetching courses
        method: 'GET',
        success: function (response) {
            const courseSelect = serviceFormTemplate.find('select[name="course"]');
            courseSelect.empty(); // Clear existing options

            // Add the "Select Course" option with value 0 at the beginning
            courseSelect.append('<option value="0">Select An Option</option>');

            response.forEach(course => {
                let option = `<option value="${course.id}"`;

                if (course.seats === 0) {
                    option += ' disabled';
                }

                option += `>${course.course_name}`;

                if (course.seats === 0) {
                    option += ' (No Seats Available)';
                }

                option += `</option>`;
                courseSelect.append(option);
            });
        },
        error: function (xhr) {
            console.log(xhr.responseText);
        }
    });

    // Append the newly created form after the last existing form
    const existingForms = $('.form-card');
    if (existingForms.length > 0) {
        existingForms.last().after(serviceFormTemplate);
    } else {
        serviceFormsContainer.append(serviceFormTemplate);
    }
}

// Event listener for adding more service forms
$('.form-btn-col button[type="button"]').on('click', addMoreService);


    $(document).on('click', '.form-card .close-icon', function () {
            $(this).closest('.form-card').remove();
        });

        

   
});


 // Function to delete service based on the clicked close button
 function deleteService(button) {
    if (confirm('Are you sure to delete?')) {
        var courseId = $(button).data('course-id');
        var studentId = $(button).data('student-id');
        var formCard = $(button).closest('.form-card'); // Find the closest form-card element

        var totalServices = $('.form-card').length;

        if (courseId !== '' && totalServices > 1) {
            // Send an AJAX request to delete service based on service ID
            $.ajax({
                url: "{{ url('/delete-edit-select-course') }}",
                type: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "courseId": courseId,
                    "studentId": studentId
                },
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        formCard.remove(); // Remove the deleted service form from the UI
                    } else {
                        alert('Failed to delete the course.');
                    }
                },
                error: function (xhr, status, error) {
                    // Handle error
                    console.error(xhr.responseText); // Log the error response for debugging
                    alert('Error occurred while deleting the course. See console for details.');
                }
            });
        } else {
            // Avoid removing the only service available
            alert("At least one service is required.");
        }
    }
}


</script>



@endsection
