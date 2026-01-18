@extends('layouts.main')


@section('page')
            <!-- form section -->
            <div class="form-col">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 row align-items-center heading-wrapper">
                            <div class="col-md-6 col-12">
                                <h1>Edit Client Services</h1>
                            </div>
                            <div class="col-md-12 d-none">
                                <div class="form-step">
                                    <ul class="form-stepper form-stepper-horizontal mx-auto">
                                        <!-- Step 1 -->
                                        <li class="form-stepper-completed text-center form-stepper-list" step="1">
                                            <a class="mx-2">
                                                <span class="form-stepper-circle">
                                                    <span>1</span>
                                                </span>
                                                <div class="label">Client Basic Details</div>
                                            </a>
                                        </li>
                                        <!-- Step 2 -->
                                        <li class="form-stepper-completed text-center form-stepper-list" step="2">
                                            <a class="mx-2">
                                                <span class="form-stepper-circle text-muted">
                                                    <span>2</span>
                                                </span>
                                                <div class="label text-muted">Services</div>
                                            </a>
                                        </li>
                                        <!-- Step 3 -->
                                        <li class="form-stepper-active text-center form-stepper-list" step="3">
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
                            <form class="create-form form-card" method="POST" action="{{url('/savepaymentedit')}}">
                                @csrf
                                <div class="row">
                                    @foreach($services as $service)
                                <div class="row service-row">
                                    <div class="col-md-3">
                                        <label for="">Services Selected<sup>*</sup></label>
                                        <input hidden type="text" name="service_id" value="{{ $service->id }}" required readonly>
                                        <input type="text" name="service" value="{{ $service->service }}" required readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="duration_{{ $service->id }}">Duration (In Months) <sup>*</sup></label>
                                        <select name="duration" class="duration" required>
                                            <option value="">Select An Option</option>
                                            <!-- Populate duration options -->
                                            @for ($i = 1; $i <= 24; $i++)
                                                <option value="{{ $i }}" {{ $i == $service->duration_months ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="charges_{{ $service->id }}">Charges (in RS)<sup>*</sup></label>
                                        <input type="number" name="charges" id="charges" value="{{ $service->charges }}" required>
                                       
                                    </div>
                                    <div class="col-md-3">
                                        <label>Next Due<sup>*</sup></label>
                                        <input type="date" name="next_due" class="next-due" required disabled>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="">Description</label>
                                        <textarea name="description" rows="2">{{$service->description }}</textarea>
                                    </div>
                                </div>
                            @endforeach
            
                                    <div class="col-md-12">
                                        <div class="form-btn-col">
                                            <button type="submit" onclick="submitServiceForms()" class="btn">Submit</button>
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

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>

function submitServiceForms() {
    let allServiceData = collectServiceFormData();
    console.log(allServiceData);

    $.ajax({
        url: "{{ url('/savepaymentedit') }}",
        type: "POST",
        data: {
            "_token": "{{ csrf_token() }}",
            "serviceData": allServiceData
        },
        success: function (response) {
            console.log(response);
            // Handle success response
        },
        error: function (xhr, status, error) {
            console.error('AJAX error:', error);
            // Handle error
        }
    });
}

function collectServiceFormData() {
    let serviceData = [];
    $('.service-row').each(function(index, element) {
        let serviceForm = $(element);
        let service = {
            'user_id': serviceForm.find('input[name="user_id"]').val(),
            'service_id': serviceForm.find('input[name="service_id"]').val(),
            'service_name': serviceForm.find('input[name="service"]').val(),
            'duration': serviceForm.find('select[name="duration"]').val(),
            'charges': serviceForm.find('input[name="charges"]').val(),
            'description': serviceForm.find('textarea[name="description"]').val()
        };
        serviceData.push(service);
    });
    return serviceData;
}

        $(document).ready(function () {
            $('.duration').on('change', function () {
                var selectedDuration = $(this).val();
                var currentDate = new Date();
                var nextDueDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + parseInt(selectedDuration), currentDate.getDate());
                var formattedDueDate = formatDate(nextDueDate);
                $(this).closest('.service-row').find('.next-due').val(formattedDueDate);
            });

            // Trigger the change event for duration on page load
            $('.duration').trigger('change');

            function formatDate(date) {
                var yyyy = date.getFullYear();
                var mm = String(date.getMonth() + 1).padStart(2, '0'); // January is 0
                var dd = String(date.getDate()).padStart(2, '0');
                return yyyy + '-' + mm + '-' + dd;
            }
        });


        
$(document).ready(function () {
                
   

        

                function getServiceDetails(serviceId, durationSelect, chargesInput) {
                    $.ajax({
                        url: "{{ url('getserviceprice') }}",
                        type: 'GET',
                        data: {
                            service_id: serviceId,
                            duration: durationSelect.val()
                        },
                        success: function (response) {
                            if (response.success) {
                                chargesInput.val(response.price); // Update charges based on the service and duration selected
                            } else {
                                console.log('Price fetching unsuccessful');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('AJAX error:', error);
                        }
                    });
                }

                function getServiceId(serviceName, durationSelect, chargesInput) {
                $.ajax({
                    url: "{{ url('getallserviceid') }}",
                    type: 'GET',
                    data: {
                        service_name: serviceName
                    },
                    success: function (response) {
                        console.log(response);
                        if (response.success) {
                            // On success, fetch service ID and call getServiceDetails function
                            getServiceDetails(response.service_id, durationSelect, chargesInput);
                        } else {
                            console.log('Service ID fetching unsuccessful');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX error:', error);
                    }
                });
                }

                function handleServiceChange() {
                var serviceName = $(this).val(); // Get selected service name
                var durationSelect = $(this).closest('.service-row').find('select[name="duration"]');
                var chargesInput = $(this).closest('.service-row').find('input[name="charges"]');
                durationSelect.val('1'); // Set duration to 1 when service is changed
                getServiceId(serviceName, durationSelect, chargesInput); // Call function to get service ID
            }

            function handleDurationChange() {
                var serviceName = $(this).closest('.service-row').find('input[name="service"]').val(); 
                console.log(serviceName);
                var durationSelect = $(this);
                var chargesInput = $(this).closest('.service-row').find('input[name="charges"]');
                getServiceId(serviceName, durationSelect, chargesInput); // Call function to get service ID
            }

            // Initial handling for the first form
            $(document).on('change', '.service-row input[name="service"]', handleServiceChange);
            $(document).on('change', '.service-row select[name="duration"]', handleDurationChange);



        });
    </script>


        @endsection