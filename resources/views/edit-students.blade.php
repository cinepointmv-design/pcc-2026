@extends('layouts.admin-main')


@section('adminpage')

            <!-- form section -->
            <div class="form-col">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 row align-items-center heading-wrapper">
                            <div class="col-md-6 col-12">
                                <h1>Edit Student</h1>
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
                                                <div class="label">Edit Student</div>
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
                            
                            <form action="{{url('/save-edit-students')}}" class="create-form" method="get">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Name<sup>*</sup></label>
                                        <input hidden  name="student_id" id="student_id" type="text" required value="{{$students->id}}">
                                        <input name="name" id="name" type="text" required value="{{$students->name}}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="">Email </label>
                                        <input name="email" type="email"   value="{{$students->email}}">
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Mobile Number<sup>*</sup></label>
                                        <input name="phone" type="tel" id="phone" maxlength="10" required value="{{$students->phone}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Whatsapp No.</label>
                                        <input name="whatsapp_number" id="whatsapp_number" type="tel" maxlength="10" value="{{$students->whatsapp_number}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Father's Name<sup></sup></label>
                                        <input name="fathername" type="text" value="{{$students->fathername}}" >
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Joining Date</label>
                                        <input name="joiningdate" type="date" value="{{$students->joiningdate}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Date Of Birth<sup></sup></label>
                                        <input name="DOB" id='DOB' type="date" value="{{$students->DOB}}" >
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Gender<sup></sup></label>
                                        <select name="gender" id="gender">
                                            <option value="">Select An Option</option>
                                            <option value="male" {{ $students->gender === 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ $students->gender === 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="others" {{ $students->gender === 'others' ? 'selected' : '' }}>Others</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Address<sup></sup></label>
                                        <input name="address" type="text" value="{{$students->address}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">City<sup></sup></label>
                                        <input name="city" type="text" value="{{$students->city}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Pincode<sup></sup></label>
                                        <input name="pincode" type="number" value="{{$students->pincode}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Community</label>
                                        <input name="community" type="text" value="{{$students->community}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Qualification</label>
                                        <input name="qualification" type="text" value="{{$students->qualification}}">
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <label for="">Board</label>
                                        <input name="board" type="text" value="{{$students->board}}">
                                    </div>
                                   
                                    <div class="col-md-6">
                                        <label for="">Percentage %</label>
                                        <input name="percentage" type="text" value="{{$students->percentage}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="passing_year">Passing Year</label>
                                        <select name="passing_year" id="passing_year_select">
                                            
                                            @php
                                                $currentYear = date('Y');
                                            @endphp
                                            @for ($year = 2000; $year <= 2024; $year++)
                                                <option value="{{ $year }}" {{ $students->passing_year == $year ? 'selected' : '' }}>
                                                    {{ $year }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Subjects</label>
                                        <input name="subjects" type="text" value="{{$students->subjects}}">
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