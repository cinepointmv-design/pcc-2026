@extends('layouts.main')

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
        <form  id="service-form"  class="create-form" method='post' action="{{ url('/clients-edit-2') }}">
            @csrf
            <input hidden type="text" name="user_id" value="{{ $client->id }}"> <!-- User ID outside the loop -->
           
            <div class="row gx-0">
                <div id="service-forms" >
                    @php
                        // dd($services);
                    @endphp
                @foreach($services as $service)
                
                    <div class="form-card mb-4">
                        <div class="close-btn" onclick="deleteService(this)"  data-service-id="{{ $service->id }}" style="text-align: right; margin-bottom: 10px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                <path d="M3.646 3.646a.5.5 0 0 1 .708 0L8 7.293l4.646-4.647a.5.5 0 0 1 .708.708L8.707 8l4.647 4.646a.5.5 0 0 1-.708.708L8 8.707l-4.646 4.647a.5.5 0 0 1-.708-.708L7.293 8 2.646 3.354a.5.5 0 0 1 0-.708z"/>
                            </svg>
                        </div>
                        <fieldset>
                            <legend>Service Details</legend>
                            <div class="row">
                                <div class="col-md-4">
                                    <input hidden type="text" id="service_id" name="service_id" value="{{ $service->id }}">
                                    <label for="service_{{ $service->id }}">Service<sup>*</sup></label>
                                    <select name="service" id="service" required>
                                        <option value="">Select An Option</option>
                                        <option value="{{ $service->service }}"  selected>{{ $service->service }}</option>
                                        <!-- Other service options if needed -->
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="duration_{{ $service->id }}">Duration (In Months) <sup>*</sup></label>
                                    <select name="duration" id="duration" required>
                                        <option value="">Select An Option</option>
                                        <!-- Populate duration options -->
                                        @for ($i = 1; $i <= 24; $i++)
                                            <option value="{{ $i }}" {{ $i == $service->duration_months ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="charges_{{ $service->id }}">Charges (in RS)<sup>*</sup></label>
                                    <input type="number" name="charges" id="charges" value="{{ $service->charges }}" 
                                    required>
                                </div>
                                <div class="col-md-12">
                                    <label for="description_{{ $service->id }}">Description</label>
                                    <textarea name="description" id="description" rows="2">{{ $service->description }}</textarea>
                                </div>
                                <!-- Other fields -->
                            </div>
                        </fieldset>
                    </div>
                @endforeach
                <!-- ... (other HTML content) ... -->
            </div>
        </div>
            <div class="col-md-12">
                <div class="form-btn-col">
                    <button type="button" onclick="addMoreService()" class="btn">Add More</button>
                    <button type="submit"  onclick="submitServiceForms()" class="btn">Next</button>
                    <button onclick="goback()" type="button" class="btn btn-second">Back</button>

                </div>
            </div>
        </form>
    </div>


    <!-- Add jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>



   // Function to delete service based on the clicked close button
function deleteService(button) {
    var confirmation = confirm('Are you sure to delete?');
    var serviceId = $(button).data('service-id');

    console.log(serviceId);

    var totalServices = $('.form-card').length;

    if (confirmation) {
        
    if (serviceId !== '' && totalServices > 1) {
        // Send an AJAX request to delete service based on service ID
        $.ajax({
            url: "{{ url('/delete-service') }}",
            type: "post",
            data: {
                "_token": "{{ csrf_token() }}",
                "service_id": serviceId 
            },
            success: function (response) {
                // Handle success response
                $(button).closest('.form-card').remove(); // Remove the deleted service form from the UI
            },
            error: function (xhr, status, error) {
                // Handle error
            }
        });
    } else {
        // Avoid removing the only service available
        alert("At least one service is required.");
    }

}
}


  function collectServiceFormData() {
    let services = []; // Array to hold service data

    $('.form-card').each(function(index, element) {
        let serviceForm = $(element);

        // Construct individual service object
        let service = {
            'service_id': serviceForm.find('input[name="service_id"]').val(),
            'service': serviceForm.find('select[name="service"]').val(),
            'duration': serviceForm.find('select[name="duration"]').val(),
            'charges': serviceForm.find('input[name="charges"]').val(),
            'description': serviceForm.find('textarea[name="description"]').val()
        };

        services.push(service); // Add service object to the array
    });
    
    return services; // Return array of service objects
}

function submitServiceForms() {
    let allServiceData = collectServiceFormData();

    

    $.ajax({
        url: "{{ url('/clients-edit-2') }}",
        type: "post",
        data: {
            "_token": "{{ csrf_token() }}",
            "user_id": "{{ $client->id }}",
            "services": allServiceData 
        },
        success: function (response) {
        },
        error: function (xhr, status, error) {
            // Handle error
        }
    });
}


$(document).ready(function () {

    
    console.log('jQuery loaded successfully.');

   // Function to fetch service details including price
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

// Function to fetch service ID based on selected service name
function getServiceId(serviceName, durationSelect, chargesInput) {
    $.ajax({
        url: "{{ url('getallserviceid') }}",
        type: 'GET',
        data: {
            service_name: serviceName
        },
        success: function (response) {
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
    var durationSelect = $(this).closest('.form-card').find('select[name="duration"]');
    var chargesInput = $(this).closest('.form-card').find('input[name="charges"]');
    
    getServiceId(serviceName, durationSelect, chargesInput); // Call function to get service ID and fetch details
    
    // Trigger a change event for the duration select to update options
    durationSelect.trigger('change');
}

// Event listener for service change in newly added forms
$(document).on('change', '.form-card:not(:first) select[name="service"]', function() {
    var serviceName = $(this).val(); // Get selected service name
    var durationSelect = $(this).closest('.form-card').find('select[name="duration"]');
    var chargesInput = $(this).closest('.form-card').find('input[name="charges"]');
    
    // Set duration to 1 when a service is selected in a newly added form
    // durationSelect.val('1');
    
    // Fetch service details for 1 month duration
    getServiceId(serviceName, durationSelect, chargesInput); // Call function to get service ID and fetch details
});

// Event listener for service change in newly added forms
$(document).on('change', '.form-card select[name="service"]', handleServiceChange);

// Function to handle duration change
function handleDurationChange() {
    var serviceName = $(this).closest('.form-card').find('select[name="service"] option:selected').text(); // Get selected service name
    var durationSelect = $(this);
    var chargesInput = $(this).closest('.form-card').find('input[name="charges"]');
    getServiceId(serviceName, durationSelect, chargesInput); // Call function to get service ID and fetch details
}

// Event listener for service change in newly added forms
$(document).on('change', '.form-card select[name="service"]', handleServiceChange);

// Event listener for duration change in newly added forms
$(document).on('change', '.form-card select[name="duration"]', handleDurationChange);

// Trigger price calculation for the initial service in the form
$('.form-card select[name="service"]').trigger('change');

function addMoreService() {
        let serviceCounter = $('.form-card').length + 1;
        const serviceFormsContainer = $('#service-forms');
        const serviceFormTemplate = $('.form-card').first().clone(true);

        // Clear input values in the cloned form
        serviceFormTemplate.find('legend').text(`Service Details ${serviceCounter}`);
        serviceFormTemplate.find('input[name="user_id"]').val('');
        serviceFormTemplate.find('input[name="service_id"]').val('');
        serviceFormTemplate.find('select[name="service"]').val('');
        serviceFormTemplate.find('select[name="duration"]').val('1');
        serviceFormTemplate.find('input[name="charges"]').val('');
        serviceFormTemplate.find('textarea[name="description"]').val('');

         // Remove existing options in select element before populating new service list
    serviceFormTemplate.find('select[name="service"]').empty();

// Fetch service list for the new form only
$.ajax({
    url: "{{ url('getallservices') }}",
    type: 'GET',
    success: function (response) {
        if (response.success) {
            // Populate options for the select element in the newly added form
            response.services.forEach(function (service) {
                serviceFormTemplate.find('select[name="service"]').append(
                    $('<option></option>').text(service.name).val(service.name)
                );
            });
        } else {
            console.log('Service list fetching unsuccessful');
        }
    },
    error: function (xhr, status, error) {
        console.error('AJAX error:', error);
    }
});       
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

                // Append a default option to the select element in the newly added form
        serviceFormTemplate.find('select[name="service"]').prepend($('<option></option>').text('Select An Option').val(''));
            }

            


        serviceFormsContainer.append(serviceFormTemplate);
    }

    // Event listener for adding more service forms
    $('.form-btn-col button[type="button"]').on('click', addMoreService);


    
    
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
