@extends('layouts.admin-main')


@section('adminpage')



            <!-- form section -->
            <div class="form-col">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 row align-items-center heading-wrapper">
                            <div class="col-md-6 col-12">
                                <h1>Create Enquiry</h1>
                            </div>
                            
                            {{-- <div class="col-md-12">
                                <div class="form-step">
                                    <ul class="form-stepper form-stepper-horizontal mx-auto">
                                        <!-- Step 1 -->
                                        <li class="form-stepper-active text-center form-stepper-list" step="1">
                                            <a class="mx-2">
                                                <span class="form-stepper-circle">
                                                    <span>1</span>
                                                </span>
                                                <div class="label">Create Enquiry</div>
                                            </a>
                                        </li>
                                        <!-- Step 2 -->
                                        <li class="form-stepper-unfinished text-center form-stepper-list" step="2">
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
                            <div class="col-md-6 col-12">

                            </div> --}}
                        </div>
                        <div class="col-md-12 m-auto">
                            
                            <form id="enquiryForm" class="create-form"  >
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        {{-- <input type="text" hidden name="client_id" value=" @php
                                        if (session()->has('client_id')) {
                                          echo  $client_id = session('client_id');
                                       } 
                                       @endphp
                                        "> --}}
                                        <label for="">Name<sup>*</sup></label>
                                        <input type="text" hidden name="client_id" value=" @php
                                        if (session()->has('client_id')) {
                                          echo  $client_id = session('client_id');
                                       } 
                                       @endphp
                                        ">
                                        <input name="name" id="name" value="{{ old('name') }}" type="text" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="">Email @error('email')
                                            <span class="text-danger ms-auto">{{ $message }}</span>
                                            @enderror</label>
                                        <input name="email" type="email" value="{{ old('email') }}" >
                                       
                                    </div>

                                    <div class="col-md-6">
                                        <label for="">Mobile Number<sup>*</sup>  @error('phone')
                                            <span class="text-danger ms-auto">{{ $message }}</span>
                                            @enderror</label>
                                        <input name="phone" id="phone" maxlength="10" pattern="[0-9]" type="tel" value="{{ old('phone') }}" required>
                                       
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Whatsapp No.<a  id="useSameNumberBtn" style="display: none; " class="ms-auto" href="">Use Same as Mobile Number</a></label>
                                        <input name="whatsapp_number" maxlength="10" id="whatsapp_number" pattern="[0-9]{10}" type="tel">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Courses<sup>*</sup></label>
                                        <select name="course" id="course" multiple>
                                            {{-- <option value="0">Select An Option</option> --}}
                                            @foreach($courses as $course)
                                                <option  value="{{ $course->id }}">{{ $course->course_name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Reference</label>
                                        <input name="reference" value="{{ old('reference') }}" type="text">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Enquiry Date</label>
                                        <input name="enquirydate" id='enquirydate' value="{{ old('enquirydate') }}" type="date">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Demo Date</label>
                                        <input name="demo_date" value="{{ old('demo_date') }}" id='demo_date' type="date" required>
                                        @error('demo_date')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Follow Up Date</label>
                                        <input name="followup_date" value="{{ old('followup_date') }}" type="date" required>
                                        @error('followup_date')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Address</label>
                                        <input name="address" value="{{ old('address') }}" type="text">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="">Description</label>
                                        <textarea name="description" value="{{ old('description') }}" type="text"></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-btn-col">
                                            <button class="btn" type="submit" onclick="submitEnquiryForm(event)">Submit</button>

                                            <button onclick="goback()" type="button" class="btn btn-second">Back</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div id="welcomeMessage" style="display: none;">
                                <p>Welcome! Your enquiry has been successfully submitted.</p>
                                <button class="btn" onclick="sendWelcomeMessage()">Send Welcome Message</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <p id="dynamicWhatsappNumber" style="display: none;"></p>
        <p id="name" style="display: none;"></p>
    </main>

    {{-- <script>
        // Function to calculate follow-up date two days after the demo date
        function calculateFollowupDate() {
            var demoDate = document.getElementById('demo_date').value;
            var followupDateInput = document.getElementsByName('followup_date')[0];

            if (demoDate) {
                var demoDateObj = new Date(demoDate);
                demoDateObj.setDate(demoDateObj.getDate() + 2); // Adding two days

                var followupDate = demoDateObj.toISOString().slice(0, 10);
                followupDateInput.value = followupDate;
            }
        }

        // Call the function when the demo date changes
        document.getElementById('demo_date').addEventListener('change', calculateFollowupDate);
    </script> --}}
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/js/multi-select-tag.js"></script>

    <script>
       new MultiSelectTag('course', {
    onChange: function(values) {
        console.log(values)
    }
})
        
    </script>

    <script>
        $(document).ready(function() {
            $('#phone').on('input', function() {
                const mobileNumber = $(this).val().trim();
                const whatsappInput = $('#whatsapp_number');
                const useSameNumberBtn = $('#useSameNumberBtn');
    
                if (mobileNumber !== '') {
                    useSameNumberBtn.show();
    
                    useSameNumberBtn.off('click').on('click', function(event) {
                        event.preventDefault(); // Prevent form submission
                        whatsappInput.val(mobileNumber);
                    });
                } else {
                    useSameNumberBtn.hide();
                }
            });
        });

        function validateForm() {
        const name = document.getElementById('name').value;
        const phone = document.getElementById('phone').value;
        const course = document.getElementById('course').value;
        const demoDate = document.getElementById('demo_date').value;
        const followupDate = document.getElementsByName('followup_date')[0].value;

        if (name.trim() === '' ||  phone.trim() === '' || course === '0' || demoDate === '' || followupDate === '') {
            alert('Please fill in all required fields');
            return false; // Prevent form submission
        }

        // You can add more specific validation rules if needed
        
        return true; // Allow form submission if all fields are filled
    }

    function submitEnquiryForm(e) {
    e.preventDefault();

    // Manually serialize the form data, including the multiple selected courses
    const formData = new FormData($('#enquiryForm')[0]);

    // Get the selected courses from the multi-select dropdown
    const selectedCourses = $('#course').val();

    // Append the courses as an array to the FormData
    for (const course of selectedCourses) {
        formData.append('course[]', course);
    }

    // Log the form data for verification
    for (const pair of formData.entries()) {
        console.log(pair[0] + ', ' + pair[1]);
    }

    $.ajax({
        url: "{{ url('/save-enquiry') }}",
        method: 'POST',
        processData: false,
        contentType: false,
        data: formData,
        success: function (response) {
            // Hide form and show welcome message
            $('#enquiryForm').hide();
            $('#welcomeMessage').show();

            // Display success message
            $('#welcomeText').text('Welcome! Your enquiry has been successfully submitted.');

            // Set the dynamically obtained WhatsApp number
            const whatsappNumber = response.whatsapp_number;
            const name = response.name;
            $('#dynamicWhatsappNumber').text(whatsappNumber).show();
            $('#name').text(name).show();
        },
        error: function (error) {
            console.error('Error:', error);
            if (error.responseJSON && error.responseJSON.message) {
                alert(error.responseJSON.message);
            } else {
                alert('Enquiry submission failed. Please try again.');
            }
        }
    });
}



    // Add this event listener to prevent non-numeric input in the phone field
    $('#phone').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
    });

    $('#whatsapp_number').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
    });

    function sendWelcomeMessage() {
    // Get the dynamically set WhatsApp number
    const whatsappNumber = $('#dynamicWhatsappNumber').text();

    // Get the user's name from the form
    const userName = $('#name').text();

    // Check if both the number and user's name are available
    if (whatsappNumber && userName) {
        // Customize your welcome message
        const welcomeMessage = `Hi ${userName}, Welcome to Punjab Computer Center!`;

        // Encode the message for the WhatsApp link
        const encodedMessage = encodeURIComponent(welcomeMessage);

        // Generate the WhatsApp link with the dynamically set number and customized message
        const whatsappLink = `https://api.whatsapp.com/send?phone=${whatsappNumber}&text=${encodedMessage}`;

        // Open WhatsApp in a new tab with the pre-filled message
        window.open(whatsappLink, '_blank');
    } else {
        alert('WhatsApp number not available. Please try again.');
    }
}

    </script>

 @endsection