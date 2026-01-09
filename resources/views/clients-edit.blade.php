@extends('layouts.main')


@section('page')

            <!-- form section -->
            <div class="form-col">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 row align-items-center heading-wrapper">
                            <div class="col-md-6 col-12">
                                <h1>Edit Client</h1>
                            </div>
                            {{-- <div class="col-md-6 col-12">
                                <a href="#" class="btn d-block ms-md-auto ms-none edit-del-btn">Delete</a>
                            </div> --}}
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
                                        <li class="form-stepper-unfinished text-center form-stepper-list" step="3">
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
                            <form action="{{url('/clients-edit-3')}}" method="post" class="create-form">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Name<sup>*</sup></label>
                                        <input hidden type="text" name="user_id" value="{{$client->id}}">
                                        <input type="text" name="name" id="name" value="{{$client->name}}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Username<sup>*</sup></label>
                                        <input type="text" name="username" readonly id="username" value="{{ $client->username }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Email<sup>*</sup></label>
                                        <input type="email" name="email" value="{{$client->email}}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Mobile Number<sup>*</sup></label>
                                        <input type="tel" name="phone" id="phone" maxlength="10" value="{{$client->phone}}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Business Name<sup>*</sup></label>
                                        <input type="text" name="business_name" value="{{$client->business_name}}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Loaction<sup>*</sup></label>
                                        <input type="text" name="location" value="{{$client->location}}"  required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Password<sup>*</sup></label>
                                        <input type="password" name="password" value="{{$client->password}}"  required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Whatsapp No.</label>
                                        <input type="tel" name="whatsapp_number" id="whatsapp_number" maxlength="10" value="{{$client->whatsapp_number}}" >
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Whatsapp Api</label>
                                        <input type="text" name="whatsapp_api" value="{{$client->whatsapp_api}}" >
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">SMS Api</label>
                                        <input type="text" name="sms_api" value="{{$client->sms_api}}"  >
                                    </div>
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

       <script>
        // Add this event listener to prevent non-numeric input in the phone field
     $('#phone').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
    });

    $('#whatsapp_number').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
    });
       </script>

        @endsection