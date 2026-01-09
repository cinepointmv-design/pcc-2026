@extends('layouts.admin-main')


@section('adminpage')

            <!-- form section -->
            <div class="form-col">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 row align-items-center heading-wrapper">
                            <div class="col-md-6 col-12">
                                <h1>Edit Enquiry</h1>
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
                                                <div class="label">Edit Enquiry</div>
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
                            
                            <form action="{{url('/update-enquiry/'  . $enquiry->id)}}" class="create-form" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <input hidden type="text" name="id" value="{{$enquiry->id}}">
                                        <label for="">Name<sup>*</sup></label>
                                        <input name="name" id="name" type="text" required value="{{$enquiry->name}}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="">Email</label>
                                        <input name="email" type="email" value="{{$enquiry->email}}"  >
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Mobile Number<sup>*</sup></label>
                                        <input name="phone" type="tel" maxlength="10" value="{{$enquiry->phone}}" required id="phone">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Whatsapp No.<a  id="useSameNumberBtn" style="display: none; " class="ms-auto" href="">Use Same as Mobile Number</a></label>
                                        <input name="whatsapp_number" maxlength="10" value="{{$enquiry->whatsapp_number}}" type="tel" id="whatsapp_number">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Courses<sup>*</sup></label>
                                        <select name="course[]" id="course" multiple>
                                            @foreach($courses as $course)
                                                <option value="{{ $course->id }}" {{ in_array($course->id, json_decode($enquiry->course_id)) ? 'selected' : '' }}>
                                                    {{ $course->course_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="">Reference</label>
                                        <input name="reference" value="{{$enquiry->reference}}" type="text">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Enquiry Date</label>
                                        <input name="enquirydate" id='enquirydate' value="{{$enquiry->enquirydate}}" type="date">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Demo Date</label>
                                        <input name="demo_date" id='demo_date' value="{{$enquiry->demo_date}}" type="date">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Follow Up Date</label>
                                        <input name="followup_date" value="{{$enquiry->followup_date}}" type="date">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Status<sup></sup></label>
                                        <select name="status" id="status">
                                            <option value="open" {{ $enquiry->status === 'open' ? 'selected' : '' }}>Open</option>
                                            <option value="close" {{ $enquiry->status === 'close' ? 'selected' : '' }}>Close</option>
                                            <option value="lead" {{ $enquiry->status === 'lead' ? 'selected' : '' }}>Lead</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="">Address</label>
                                        <input name="address" value="{{$enquiry->address}}" type="text">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="">Description</label>
                                        <textarea name="description" type="text">{{$enquiry->description}}</textarea>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="form-btn-col">
                                            <button class="btn">Submit</button>
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
         // Add this event listener to prevent non-numeric input in the phone field
    $('#phone').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
    });

    $('#whatsapp_number').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
    });

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
    </script>

 @endsection