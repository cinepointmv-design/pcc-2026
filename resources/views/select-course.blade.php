@extends('layouts.admin-main')

@section('adminpage')

<!-- form section -->
<div class="form-col">
    <div class="col-md-12 mb-4">
        <div class="form-step">
            <ul class="form-stepper form-stepper-horizontal mx-auto">
                <!-- Step 1 -->
                <li class="form-stepper-completed text-center form-stepper-list" step="1">
                    <a class="mx-2">
                        <span class="form-stepper-circle">
                            <span>1</span>
                        </span>
                        <div class="label">Add Student</div>
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

   

    @if (isset($course_id))
    @php
    $courseIds = json_decode($course_id); // Assuming 'course_id' is a JSON array in the controller
    @endphp
    <div class="col-md-12 m-auto">
        <form id="service-form" class="create-form" method='get' action="{{ url('/save-student-data') }}" onsubmit="submitServiceForms(event)">
            @csrf
            <div class="row gx-0">
                <div id="service-forms">
                    @foreach($courseIds as $index => $courseId)
                        <div class="form-card mb-4">
                            @if ($index > 0) <!-- Exclude the close button for the first form -->
            <div class="close-icon" style="text-align: right; margin-bottom: 10px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                    <path d="M3.646 3.646a.5.5 0 0 1 .708 0L8 7.293l4.646-4.647a.5.5 0 0 1 .708.708L8.707 8l4.647 4.646a.5.5 0 0 1-.708.708L8 8.707l-4.646 4.647a.5.5 0 0 1-.708-.708L7.293 8 2.646 3.354a.5.5 0 0 1 0-.708z"/>
                </svg>
            </div>
        @endif
                            <fieldset>
                                <legend>Course Detail {{ $index + 1 }}</legend>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="">Courses<sup>*</sup></label>
                                        <select name="course" id="course" required>
                                            <option value="0">Select An Option</option>
                                            @foreach($courses as $course)
                                                @php
                                                    $selected = isset($courseId) && $courseId == $course->id ? 'selected' : '';
                                                @endphp
                                                <option value="{{ $course->id }}" {{ $selected }} >
                                                    {{ $course->course_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- <div class="col-md-6">
                                        <label for="batch">Batch Timing<sup>*</sup></label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" id="start_batch" required name="start_batch" class="start_batch" placeholder="Select Start Time">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" id="end_batch" required name="end_batch" class="end_batch" placeholder="Select End Time">
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-6">
                                        <label for="">Batch<sup>*</sup> </label>
                                        <select name="batch" required id="batch">
                                            <option value="0">Select An Option</option>
                                            <!-- Batch options will be populated dynamically using JavaScript -->
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="">Course Fees<sup>*</sup></label>
                                        <input name="fees" id="fees" type="number" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Duration Of Course<sup>*</sup></label>
                                        <input name="duration" id="duration" type="number" >
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Lab Name<sup>*</sup></label>
                                        <input name="lab_number" id="lab_number" type="text" readonly>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    @endforeach
                </div>

                <div class="col-md-12">
                    <div class="form-btn-col">
                        <button type="button" onclick="addMoreService()" class="btn">Add More</button>
                        <button type="submit" onclick="submitServiceForms()" class="btn">Next</button>
                        <button onclick="goback()" type="button" class="btn btn-second">Back</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @else    
    <div class="col-md-12 m-auto">
        <form id="service-form" class="create-form" method='get' action="{{ url('/save-student-data') }}" onsubmit="submitServiceForms(event)">
            @csrf
            <div class="row gx-0">
                <div id="service-forms">
                        <div class="form-card mb-4">
                            <fieldset>
                                <legend>Course Detail</legend>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="">Courses<sup>*</sup></label>
                                        <select name="course" id="course" required>
                                            <option value="0">Select An Option</option>
                                            @foreach($courses as $course)
                                                @php
                                                    $selected = isset($courseId) && $courseId == $course->id ? 'selected' : '';
                                                @endphp
                                                <option value="{{ $course->id }}" {{ $selected }} >
                                                    {{ $course->course_name }} 
                                                   
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- <div class="col-md-6">
                                        <label for="batch">Batch Timing<sup>*</sup></label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" id="start_batch" required name="start_batch" class="start_batch" placeholder="Select Start Time">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" id="end_batch" required name="end_batch" class="end_batch" placeholder="Select End Time">
                                            </div>
                                        </div>
                                    </div> --}}

                                    <div class="col-md-6">
                                        <label for="">Batch<sup>*</sup></label>
                                        <select name="batch" id="batch" required>
                                            <option value="0">Select An Option</option>
                                            <!-- Batch options will be populated dynamically using JavaScript -->
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="">Course Fees<sup>*</sup></label>
                                        <input name="fees" id="fees" type="number" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Duration Of Course<sup>*</sup></label>
                                        <input name="duration" id="duration" type="number" >
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Lab Name<sup>*</sup></label>
                                        <input name="lab_number" id="lab_number" type="text" readonly>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                </div>

                <div class="col-md-12">
                    <div class="form-btn-col">
                        <button type="button" onclick="addMoreService()" class="btn">Add More</button>
                        <button type="submit" onclick="submitServiceForms()" class="btn">Next</button>
                        <button onclick="goback()" type="button" class="btn btn-second">Back</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @endif

    
</div>
</main>


<!-- Add jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@if(isset($course_id))
<script>
// Assuming you have the pre-selected course IDs in a variable
const preSelectedCourseIds = {!! json_encode($courseIds) !!};

// Call the function on page load
$(document).ready(function() {
    // Assuming your form section has a specific class or ID, adjust as needed
    const formSection = $('.form-card');

    // Call the function with pre-selected course IDs and the form section
    setFormValuesBasedOnMultipleCourse(preSelectedCourseIds, formSection);
});

// Event listener for removing a service form
$(document).on('click', '.form-card .close-icon', function () {
        const removedCourseId = $(this).closest('.form-card').find('select[name="course"]').val();
        selectedCourses = selectedCourses.filter(courseId => courseId !== removedCourseId);
        $(this).closest('.form-card').remove();
        disableSelectedCourses(); // Disable selected courses in other dropdowns
    });

function setFormValuesBasedOnMultipleCourse(courseIds, formSection) {
    $.ajax({
        url: '{{ url("/get-multiple-course-details") }}' + '/' + courseIds,
        method: 'GET',
        success: function (responses) {
            console.log(responses);
             // Assuming responses is an array of objects containing details for each course
             $.each(responses, function(index, response) {
                // Update form fields for each course
                formSection.eq(index).find('input[name="fees"]').val(response.fees);
                formSection.eq(index).find('input[name="duration"]').val(response.duration);
                formSection.eq(index).find('input[name="lab_number"]').val(response.lab_number);
            });
        },
        error: function (xhr) {
            console.log(xhr.responseText);
        }
    });
}

</script>
@endif


<script>

$(document).ready(function() {
        // Function to fade out the alerts after 3 seconds (adjust as needed)
        $(".auto-dismiss").delay(5000).fadeOut("slow");
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

   
    if (isAllValid) {
    
    
    let formData = [];
    $('.form-card').each(function(index) {
        let batchText = $(this).find('#batch option:selected').text();

    // Extract start time
    let startTime = batchText.substring(0, batchText.indexOf(' to'));

    // Extract end time
    let endIndex = batchText.indexOf('-') - 1;
    let endTime = batchText.substring(batchText.indexOf(':') - 2, endIndex).trim();

    // Extract the end time
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
        url: '{{url('/save-student-data')}}',
        method: 'get',
        data: { 
            "_token": "{{ csrf_token() }}",
            "courses" : formData 
        },
        success: function (response) {
            // Handle success response
            console.log(response);
             window.location.href = "{{ url('/save-student-data') }}";
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

// Fetch batches based on the lab number when a course is selected
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
                    formSection.find('select[name="batch"]').append(`<option value="${batch.id}">${optionText}</option>`);
                } else {
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
   


function removeLastService() {
        let serviceForms = $('.form-card');
        if (serviceForms.length > 1) {
            serviceForms.last().remove(); // Remove the last added service form
        } else {
            alert("Cannot remove the last service form.");
        }
    }

   
$(document).ready(function () {

     // Array to store selected courses
     let selectedCourses = [];

    // Function to fetch course details and fill related fields
    function setFormValuesBasedOnCourse(courseId, formSection) {
        $.ajax({
            // url: '/get-course-details/' + courseId,
            url: '{{ url("/get-course-details") }}'+ '/' + courseId,
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

        
    }

    
   // Check if a course_id is available
const courseId = '{{ $course_id ?? '' }}'; // Get the course_id value from PHP
if (courseId) {
    // Fetch course details and fill related fields for the first form
    setFormValuesBasedOnCourse(courseId, $('.form-card').first());
}

   

    // Function to disable selected courses in other dropdowns
    function disableSelectedCourses() {
        $('select[name="course"]').each(function () {
            const selectedCourse = $(this).val();
            $('select[name="course"] option').prop('disabled', false); // Reset all options

            // Disable selected course in other dropdowns
            $('select[name="course"]').not($(this)).find(`option[value="${selectedCourse}"]`).prop('disabled', true);
        });
    }

    // Fetch course details using AJAX when a course is selected
    $(document).on('change', 'select[name="course"]', function () {
        var courseId = $(this).val();
        var formSection = $(this).closest('.form-card');
        // If selectedCourses array is empty/null, initialize it
        if (selectedCourses.length === 0) {
            $('select[name="course"]').each(function () {
                selectedCourses.push($(this).val()); // Populate the array with selected courses
            });
        }

        // Check if the selected course is already chosen in other forms
        if (selectedCourses.includes(courseId)) {
            if ($('select[name="course"]').filter(function () {
                return $(this).val() === courseId;
            }).length > 1) {
                alert('This course is already selected.');
                $(this).val('0'); // Reset the selected value
                return;
            }
        }

        // Update selectedCourses array with the latest selections
        selectedCourses = [];
        $('select[name="course"]').each(function () {
            selectedCourses.push($(this).val());
        });
        disableSelectedCourses(); // Disable selected courses in other dropdowns

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
    function addMoreService() {
        let serviceCounter = $('.form-card').length + 1;
        const serviceFormsContainer = $('#service-forms');
        const serviceFormTemplate = $('.form-card').first().clone(true);

        serviceFormTemplate.find('legend').text(`Course Detail ${serviceCounter}`);
        serviceFormTemplate.find('select[name="course"]').val('0');
        serviceFormTemplate.find('input[name="start_batch"]').val('');
        serviceFormTemplate.find('input[name="end_batch"]').val('');
        serviceFormTemplate.find('input[name="fees"]').val('');
        serviceFormTemplate.find('input[name="duration"]').val('');
        serviceFormTemplate.find('input[name="lab_number"]').val('');

        // Append close icon only for additional forms
        if (serviceCounter > 1) {
            serviceFormTemplate.prepend(`
                <div class="close-icon" style="text-align: right; margin-bottom: 10px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                        <path d="M3.646 3.646a.5.5 0 0 1 .708 0L8 7.293l4.646-4.647a.5.5 0 0 1 .708.708L8.707 8l4.647 4.646a.5.5 0 0 1-.708.708L8 8.707l-4.646 4.647a.5.5 0 0 1-.708-.708L7.293 8 2.646 3.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                </div>
            `);
        }

        // Set batch time pickers for newly added form sections
        serviceFormTemplate.find('.start_batch').removeAttr('id').attr('id', `start_batch`);
        serviceFormTemplate.find('.end_batch').removeAttr('id').attr('id', `end_batch`);
        
        serviceFormsContainer.append(serviceFormTemplate);

        // Initialize batch time pickers for the newly added form sections
        flatpickr(`#start_batch`, {
            enableTime: true,
            noCalendar: true,
            dateFormat: 'h:i K', // Format to display hours, minutes, and AM/PM
            time_24hr: false, // Use 12-hour format
        });

        flatpickr(`#end_batch`, {
            enableTime: true,
            noCalendar: true,
            dateFormat: 'h:i K', // Format to display hours, minutes, and AM/PM
            time_24hr: false, // Use 12-hour format
        });
    }

    // Event listener for adding more service forms
    $('.form-btn-col button[type="button"]').on('click', addMoreService);

    $(document).on('click', '.form-card .close-icon', function () {
        const removedCourseId = $(this).closest('.form-card').find('select[name="course"]').val();
        selectedCourses = selectedCourses.filter(courseId => courseId !== removedCourseId);
        $(this).closest('.form-card').remove();
        disableSelectedCourses();
    });

   
});





</script>



@endsection
