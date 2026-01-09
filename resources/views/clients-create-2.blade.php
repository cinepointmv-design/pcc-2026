@extends('layouts.main')

@section('title', 'Clients - BCRM')

@section('page')
    <!-- form section -->
    <div class="form-col">
        <!-- ... (other HTML content) ... -->
        <div class="col-md-12 mb-4">
            <div class="form-step">
                <ul class="form-stepper form-stepper-horizontal mx-auto">
                    <!-- Step 1 -->
                    <li class="form-stepper-active text-center form-stepper-list" step="1">
                        <a class="mx-2">
                            <span class="form-stepper-circle">
                                <span>1</span>
                            </span>
                            <div class="label">Services</div>
                        </a>
                    </li>
                    <!-- Step 2 -->
                    <li class="form-stepper-unfinished text-center form-stepper-list" step="2">
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
        <div class="col-md-12 m-auto">
            <form id="service-form" class="create-form" method='get' action="{{url('/create-client-2')}}">
                @csrf
                <div class="row gx-0">
                    <div id="service-forms">
                        <div class="form-card mb-4" >
                            <fieldset>
                                @php
                                    $storedServices = session('storedServices', []); 
                                    // if ($storedServices) {
                                    //     dd($storedServices);
                                    // }                                 
                                   
                                @endphp
                                @if (count($storedServices) > 0)
                                @foreach ($storedServices as $index => $storedService)
                                <legend>Service Details</legend>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">Service<sup>*</sup></label>
                                        <select name="service" id="service" required>
                                            <option value="0">Select An Option</option>
                                            @foreach($serviceName as $service)
                                                <option value="{{ $service->id }}" {{ $storedService['service_name'] == $service->name ? 'selected' : '' }}>
                                                    {{ $service->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Duration (In Months) <sup>*</sup></label>
                                        <select name="duration" id="duration" required>
                                            <option value="0">Select An Option</option>
                                            @for ($i = 1; $i <= 24; $i++)
                                            <option value="{{ $i }}" {{ $storedService['duration'] == $i ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Charges (in RS)<sup>*</sup></label>
                                        <input name="charges" id="charges" type="number" required value="{{ $storedService['charges'] }}">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="">Description</label>
                                        <textarea name="description" rows="2">{{ $storedService['description'] }}</textarea>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <legend>Service Details</legend>
                                <div class="row">                                    
                                    <div class="col-md-4">
                                        <label for="">Service<sup>*</sup></label>
                                        <select name="service" id="service" required>
                                            <option value="0">Select An Option</option>
                                            @foreach($serviceName as $service)
                                                <option  value="{{ $service->id }}">{{ $service->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Duration (In Months) <sup>*</sup></label>
                                        <select name="duration" id="duration" required>
                                            <option value="0">Select An Option</option>
                                            @for ($i = 1; $i <= 24; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Charges (in RS)<sup>*</sup></label>
                                        <input name="charges" id="charges" type="number" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="">Description</label>
                                        <textarea name="description" rows="2"></textarea>
                                    </div>
                                </div>
                                @endif
                            </fieldset>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-btn-col">
                            <button type="button" onclick="addMoreService()" class="btn">Add More</button>
                            <button type="submit"  onclick="submitServiceForms()" class="btn">Next</button>
                            {{-- <a type="submit"  onclick="submitServiceForms()" class="btn">Next</a> --}}
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
     function removeLastService() {
        let serviceForms = $('.form-card');
        if (serviceForms.length > 1) {
            serviceForms.last().remove(); // Remove the last added service form
        } else {
            alert("Cannot remove the last service form.");
        }
    }

    function submitServiceForms() {
        
            let allServiceData = collectServiceFormData();

            
            $.ajax({
                url: "{{url('/create-client-2')}}",
                type: "get",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "serviceData": allServiceData
                },
                success: function (response) {
                    console.log(response);
                    // // Handle success response or redirect
                    // window.location.href = "{{ url('/clients-create-3') }}";
                },
                error: function (xhr, status, error) {
                    // Handle error
                }
            });
        }

        function collectServiceFormData() {
    let serviceData = [];
    $('.form-card').each(function(index, element) {
        let serviceForm = $(element);
        let service = {
            'service_name': serviceForm.find('select[name="service"] option:selected').text(), // Get selected service name
            'duration': serviceForm.find('select[name="duration"]').val(),
            'charges': serviceForm.find('input[name="charges"]').val(),
            'description': serviceForm.find('textarea[name="description"]').val()
        };
        serviceData.push(service);
    });
    return serviceData;
}



$(document).ready(function () {

    
    console.log('jQuery loaded successfully.');

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


    function handleServiceChange() {
        var serviceId = $(this).val();
        var durationSelect = $(this).closest('.form-card').find('select[name="duration"]');
        var chargesInput = $(this).closest('.form-card').find('input[name="charges"]');
        durationSelect.val('1'); // Set duration to 1 when service is changed
        getServiceDetails(serviceId, durationSelect, chargesInput);
    }

    function handleDurationChange() {
        var serviceId = $(this).closest('.form-card').find('select[name="service"]').val();
        var durationSelect = $(this);
        var chargesInput = $(this).closest('.form-card').find('input[name="charges"]');
        getServiceDetails(serviceId, durationSelect, chargesInput);
    }

    // Initial handling for the first form
    $(document).on('change', '.form-card select[name="service"]', handleServiceChange);
    $(document).on('change', '.form-card select[name="duration"]', handleDurationChange);

    function addMoreService() {
            let serviceCounter = $('.form-card').length + 1;
            const serviceFormsContainer = $('#service-forms');
            const serviceFormTemplate = $('.form-card').first().clone(true);

            serviceFormTemplate.find('legend').text(`Service Details ${serviceCounter}`);
            serviceFormTemplate.find('input[name="charges"]').val('');
            serviceFormTemplate.find('select[name="duration"]').val();
            serviceFormTemplate.find('textarea[name="description"]').val('');

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

            serviceFormsContainer.append(serviceFormTemplate);
        }


    // Event listener for adding more service forms
    $('.form-btn-col button[type="button"]').on('click', addMoreService);

    // Event listener for changing duration
    $(document).on('change', '.form-card select[name="duration"]', function() {
        var serviceId = $(this).closest('.form-card').find('select[name="service"]').val();
        console.log(serviceId);
        var duration = $(this).val();
        var chargesInput = $(this).closest('.form-card').find('input[name="charges"]');
        getServiceDetails(serviceId, $(this), chargesInput);
    });

   

    $(document).on('click', '.form-card .close-icon', function () {
            $(this).closest('.form-card').remove();
        });
        

   
});


// Function to check for duplicate service selection
function checkDuplicateService(serviceId, currentForm) {
    let isDuplicate = false;

    // Loop through all service dropdowns in previously added forms
    $('.form-card').not(currentForm).find('select[name="service"]').each(function() {
        if ($(this).val() === serviceId) {
            isDuplicate = true;
            return false; // Break the loop early if duplicate is found
        }
    });

    return isDuplicate;
}

// Event listener for service selection change
$(document).on('change', '.form-card select[name="service"]', function() {
    let selectedServiceId = $(this).val();
    let currentForm = $(this).closest('.form-card');
    let isDuplicate = checkDuplicateService(selectedServiceId, currentForm);

    if (isDuplicate) {
        alert('Service already selected in another form.');
        // Reset all fields in the current form
        currentForm.find('input, select, textarea').val('');
    }
});
    
</script>

@endsection
