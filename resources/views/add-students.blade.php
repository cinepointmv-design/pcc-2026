@extends('layouts.admin-main')


@section('adminpage')

            <!-- form section -->
            <div class="form-col">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 row align-items-center heading-wrapper">
                            <div class="col-md-6 col-12">
                                <h1>Add Student</h1>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-step">
                                    <ul class="form-stepper form-stepper-horizontal mx-auto">
                                        <!-- Step 1 -->
                                        <li class="form-stepper-active text-center form-stepper-list" step="1">
                                            <a class="mx-2">
                                                <span class="form-stepper-circle">
                                                    <span>1</span>
                                                </span>
                                                <div class="label">Add Student</div>
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

                            </div>
                        </div>
                        <div class="col-md-12 m-auto">
                           
                            <form action="{{url('/save-students')}}" class="create-form" method="get">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <input hidden name="course" id="course" type="text">
                                        <label for="">Name<sup>*</sup></label>
                                        <input type="text" hidden name="client_id" value=" @php
                                        if (session()->has('client_id')) {
                                          echo  $client_id = session('client_id');
                                       } 
                                       @endphp
                                        ">
                                        <input name="name" id="name" type="text" required value="{{ old('name') }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="">Email @error('email')
                                            <span class="text-danger ms-auto">{{ $message }}</span>
                                            @enderror</label>
                                        <input name="email" id="email" type="email"   value="{{ old('email') }}">
                                        
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Mobile Number<sup>*</sup>@error('phone')
                                            <span class="text-danger ms-auto">{{ $message }}</span>
                                            @enderror</label>
                                        <input name="phone" id="phone" maxlength="10" pattern="[0-9]{10}" type="tel" required value="{{ old('phone') }}">
                                        
                                    </div>
                                    <div class="col-md-6">
                                        <label for="whatsapp_number">WhatsApp No. <a  id="useSameNumberBtn" style="display: none; " maxlength="10" pattern="[0-9]{10}" class="ms-auto" href="">Use Same as Mobile Number</a></label>
                                        
                                        <input name="whatsapp_number" id="whatsapp_number" type="tel" value="{{ old('whatsapp_number') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Father's Name<sup></sup></label>
                                        <input name="fathername" type="text" value="{{ old('fathername') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Joining Date</label>
                                        <input name="joiningdate" type="date" value="{{ old('joiningdate') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Date Of Birth<sup></sup></label>
                                        <input name="DOB" id='DOB' type="date" value="{{ old('DOB') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Gender<sup></sup></label>
                                        <select name="gender" id="gender">
                                            <option value="" @if (old('gender') == '') selected @endif>Select An Option</option>
                                            <option value="male" @if (old('gender') == 'male') selected @endif>Male</option>
                                            <option value="female" @if (old('gender') == 'female') selected @endif>Female</option>
                                            <option value="others" @if (old('gender') == 'others') selected @endif>Others</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Address<sup></sup></label>
                                        <input name="address" type="text" value="{{ old('address') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">City<sup></sup></label>
                                        <input name="city" type="text" value="{{ old('city') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Pincode<sup></sup></label>
                                        <input name="pincode" type="number" value="{{ old('pincode') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Community</label>
                                        <input name="community" type="text" value="{{ old('community') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Qualification</label>
                                        <input name="qualification" type="text" value="{{ old('qualification') }}">
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <label for="">Board</label>
                                        <input name="board" type="text">
                                    </div>
                                   
                                    <div class="col-md-6">
                                        <label for="">Percentage %</label>
                                        <input name="percentage" type="text">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="passing_year">Passing Year</label>
                                        <select name="passing_year" id="passing_year_select">
                                            
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Subjects</label>
                                        <input name="subjects" type="text">
                                    </div> --}}
                                    <div class="col-md-12">
                                        <div class="form-btn-col">
                                            <button class="btn">Next</button>
                                            <button onclick="goback()" type="button" class="btn btn-second">Back</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </main>

    @if(isset($enquiryData))
    <script>
        
        window.addEventListener('DOMContentLoaded', (event) => {
            const enquiryData = @json($enquiryData);

            // Function to set values in form fields
            function setFormValues() {
                document.getElementById('course').value = enquiryData.course_id || '';
                document.getElementById('name').value = enquiryData.name || '';
                document.getElementById('email').value = enquiryData.email || '';
                document.getElementById('phone').value = enquiryData.phone || '';
                document.getElementById('whatsapp_number').value = enquiryData.whatsapp_number || '';

                // Make AJAX request to set session value
        $.ajax({
            url: '{{url("/set-enquiry-id")}}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                enquiryId: enquiryData.id // Pass the enquiry ID to be stored in the session
            },
            success: function (response) {
                // Handle success if needed
                console.log('Enquiry ID stored in session successfully');
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                // Handle error if necessary
            }
        });
               
            }

            setFormValues();
        });
    </script>
@endif

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

     // Add this event listener to prevent non-numeric input in the phone field
     $('#phone').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
    });

    $('#whatsapp_number').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
    });
</script>



<script>
    // JavaScript code to populate the dropdown with years
    const passingYearSelect = document.getElementById('passing_year_select');

    // Get the current year
    const currentYear = new Date().getFullYear();

    // Loop through the years from 2000 to 2024 and create options
    for (let year = 2000; year <= 2024; year++) {
        const option = document.createElement('option');
        option.value = year;
        option.text = year;

        // Set the default value to the current year
        if (year === currentYear) {
            option.selected = true;
        }

        passingYearSelect.appendChild(option);
    }

    
</script>

 @endsection