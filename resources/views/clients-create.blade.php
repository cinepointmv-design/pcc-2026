@extends('layouts.main')

@section('title', 'Clients - BCRM')

@section('page')
    

            <!-- form section -->
            <div class="form-col">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 row align-items-center heading-wrapper">
                            <div class="col-md-6 col-12">
                                <h1>Create Client</h1>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-step">
                                    <ul class="form-stepper form-stepper-horizontal mx-auto">
                                        <!-- Step 1 -->
                                        <li class="form-stepper-completed text-center form-stepper-list" step="1">
                                            <a class="mx-2">
                                                <span class="form-stepper-circle">
                                                    <span>1</span>
                                                </span>
                                                <div class="label">Services</div>
                                            </a>
                                        </li>
                                        <!-- Step 2 -->
                                        <li class="form-stepper-active text-center form-stepper-list" step="2">
                                            <a class="mx-2">
                                                <span class="form-stepper-circle text-muted">
                                                    <span>2</span>
                                                </span>
                                                <div class="label text-muted">Client Basic Details</div>
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
                            
                            <form action="{{url('/create-client-3')}}" class="create-form" method="post">
                                @csrf
                                @php
                                    $clientData = session('clientData');
                                @endphp
                                @if ($clientData)
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Name<sup>*</sup></label>
                                        <input name="name" id="name" type="text" required value="{{$clientData['name']}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Username<sup>*</sup> @if($errors->has('username'))
                                            <p class="text-danger ms-auto ">{{ $errors->first('username') }}</p>
                                            @endif</label>
                                        <input name="username" id="username" type="text" value="{{$clientData['username']}}" required>
                                        
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Email<sup>*</sup>  @if($errors->has('email'))
                                            <p class="text-danger ms-auto">{{ $errors->first('email') }}</p>
                                            @endif</label>
                                        <input name="email" type="email" value="{{$clientData['email']}}" required>
                                       
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Mobile Number<sup>*</sup> @error('phone')
                                            <span class="text-danger  ms-auto">{{ $message }}</span>
                                            @enderror</label>
                                        <input name="phone" id="phone" maxlength="10" type="tel" required value="{{$clientData['phone']}}">
                                        
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Business Name<sup>*</sup></label>
                                        <input name="business_name" type="text" required value="{{$clientData['business_name']}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Loaction<sup>*</sup></label>
                                        <input name="location" type="text" required value="{{$clientData['location']}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Password<sup>*</sup></label>
                                        <input name="password" type="password" required value="{{$clientData['password']}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Whatsapp No. <a  id="useSameNumberBtn" style="display: none; " class="ms-auto" href="">Use Same as Mobile Number</a></label>
                                        <input name="whatsapp_number" maxlength="10" id="whatsapp_number" type="tel" value="{{$clientData['whatsapp_number']}}" >
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Whatsapp Api</label>
                                        <input name="whatsapp_api" type="text" value="{{$clientData['whatsapp_api']}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">SMS Api</label>
                                        <input name="sms_api" type="text" value="{{$clientData['sms_api']}}">
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-btn-col">
                                            <button class="btn">Next</button>
                                            <button onclick="goback()" type="button" class="btn btn-second">Back</button>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Name<sup>*</sup></label>
                                        <input name="name" id="name" type="text" required value="{{ old('name') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Username<sup>*</sup> @if($errors->has('username'))
                                            <p class="text-danger ms-auto ">{{ $errors->first('username') }}</p>
                                            @endif</label>
                                        <input name="username" id="username" type="text" value="{{ old('username') }}" required>
                                        
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Email<sup>*</sup>  @if($errors->has('email'))
                                            <p class="text-danger ms-auto">{{ $errors->first('email') }}</p>
                                            @endif</label>
                                        <input name="email" type="email" value="{{ old('email') }}" required>
                                       
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Mobile Number<sup>*</sup> @error('phone')
                                            <span class="text-danger  ms-auto">{{ $message }}</span>
                                            @enderror</label>
                                        <input name="phone" id="phone" maxlength="10" type="tel" required value="{{ old('phone') }}">
                                        
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Business Name<sup>*</sup></label>
                                        <input name="business_name" type="text" required value="{{ old('business_name') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Loaction<sup>*</sup></label>
                                        <input name="location" type="text" required value="{{ old('location') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Password<sup>*</sup></label>
                                        <input name="password" type="password" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Whatsapp No. <a  id="useSameNumberBtn" style="display: none; " class="ms-auto" href="">Use Same as Mobile Number</a></label>
                                        <input name="whatsapp_number" maxlength="10" id="whatsapp_number" type="tel" >
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Whatsapp Api</label>
                                        <input name="whatsapp_api" type="text" value="{{ old('whatsapp_api') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">SMS Api</label>
                                        <input name="sms_api" type="text" value="{{ old('sms_api') }}">
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-btn-col">
                                            <button class="btn">Next</button>
                                            <button onclick="goback()" type="button" class="btn btn-second">Back</button>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </main>

    <script>//get username
       // Add this event listener to prevent non-numeric input in the phone field
     $('#phone').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
    });

    $('#whatsapp_number').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
    });

        $(document).ready(function () {
           console.log('jQuery loaded successfully.'); // Check if jQuery is loaded
       
           // Check if the 'name' input field exists
           if ($('#name').length) {
               console.log('Name input field found.'); // Check if the 'name' input field exists
       
               // When user inputs a name, generate the username
               $('#name').on('input', function () {
                   var name = $(this).val();
                   console.log('Name entered:', name); // Check if the name is captured properly
                   var username = name.toLowerCase().replace(/\s/g, '') + '@admin'; // Generating username from the name
                   console.log('Generated username:', username); // Check the generated username
                   $('#username').val(username); // Setting the generated username in the input field
                   console.log('Username field updated.'); // Check if the username field is updated
               });
           } else {
               console.log('Name input field not found.'); // Log if 'name' input field is not found
           }
       });
       
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
</script>

 @endsection