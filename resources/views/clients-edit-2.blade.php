@extends('layouts.main')

@section('page')
<div class="form-col">
    <div class="col-md-12 mb-4">
        <div class="form-step">
            <ul class="form-stepper form-stepper-horizontal mx-auto">
                <li class="form-stepper-active text-center form-stepper-list" step="1">
                    <a class="mx-2">
                        <span class="form-stepper-circle">
                            <span>1</span>
                        </span>
                        <div class="label">Services</div>
                    </a>
                </li>
                <li class="form-stepper-unfinished text-center form-stepper-list" step="2">
                    <a class="mx-2">
                        <span class="form-stepper-circle text-muted">
                            <span>2</span>
                        </span>
                        <div class="label text-muted">Client Basic Details</div>
                    </a>
                </li>
                <li class="form-stepper-unfinished text-center form-stepper-list" step="3">
                    <a class="mx-2">
                        <span class="form-stepper-circle text-muted">
                            <span>3</span>
                        </span>
                        <div class="label text-muted">Payment</div>
                    </a>
                </li>
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
        <form id="service-form" class="create-form" method='post' action="{{ url('/clients-edit-2') }}">
            @csrf
            <input hidden type="text" name="user_id" value="{{ $client->id }}">
           
            <div class="row gx-0">
                <div id="service-forms">
                    {{-- Loop through existing services --}}
                    @foreach($services as $index => $service)
                    <div class="form-card mb-4">
                        <div class="close-btn" onclick="deleteService(this)" data-service-id="{{ $service->id }}" style="text-align: right; margin-bottom: 10px; cursor: pointer;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                <path d="M3.646 3.646a.5.5 0 0 1 .708 0L8 7.293l4.646-4.647a.5.5 0 0 1 .708.708L8.707 8l4.647 4.646a.5.5 0 0 1-.708.708L8 8.707l-4.646 4.647a.5.5 0 0 1-.708-.708L7.293 8 2.646 3.354a.5.5 0 0 1 0-.708z"/>
                            </svg>
                        </div>
                        <fieldset>
                            <legend>Service Details {{ $index + 1 }}</legend>
                            <div class="row">
                                <div class="col-md-4">
                                    {{-- Notice the array syntax: services[$index][key] --}}
                                    <input hidden type="text" name="services[{{ $index }}][service_id]" value="{{ $service->id }}">
                                    <label>Service<sup>*</sup></label>
                                    <select name="services[{{ $index }}][service]" class="service-select" required onchange="handleServiceChange(this)">
                                        <option value="">Select An Option</option>
                                        <option value="{{ $service->service }}" selected>{{ $service->service }}</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Duration (In Months) <sup>*</sup></label>
                                    <select name="services[{{ $index }}][duration]" class="duration-select" required onchange="handleDurationChange(this)">
                                        <option value="">Select An Option</option>
                                        @for ($i = 1; $i <= 24; $i++)
                                            <option value="{{ $i }}" {{ $i == $service->duration_months ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Charges (in RS)<sup>*</sup></label>
                                    <input type="number" name="services[{{ $index }}][charges]" class="charges-input" value="{{ $service->charges }}" required>
                                </div>
                                <div class="col-md-12">
                                    <label>Description</label>
                                    <textarea name="services[{{ $index }}][description]" rows="2">{{ $service->description }}</textarea>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-btn-col">
                    <button type="button" onclick="addMoreService()" class="btn">Add More</button>
                    <button type="submit" class="btn">Next</button>
                    <button onclick="goback()" type="button" class="btn btn-second">Back</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    // Function to delete service based on the clicked close button
    function deleteService(button) {
        var confirmation = confirm('Are you sure to delete?');
        var serviceId = $(button).data('service-id');
        var totalServices = $('.form-card').length;

        if (confirmation) {
            // Delete from database if it has an ID
            if (serviceId !== '' && serviceId !== undefined && totalServices > 1) {
                $.ajax({
                    url: "{{ url('/delete-service') }}",
                    type: "post",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "service_id": serviceId 
                    },
                    success: function (response) {
                        $(button).closest('.form-card').remove(); 
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                    }
                });
            } else if (totalServices > 1) {
                 // If it's a newly added card without ID, just remove from DOM
                 $(button).closest('.form-card').remove();
            } else {
                alert("At least one service is required.");
            }
        }
    }

    // Handle Service Change to fetch ID and Price
    function handleServiceChange(selectElement) {
        var serviceName = $(selectElement).val();
        var card = $(selectElement).closest('.form-card');
        var durationSelect = card.find('.duration-select');
        var chargesInput = card.find('.charges-input');
        
        // Fetch service ID first
        $.ajax({
            url: "{{ url('getallserviceid') }}",
            type: 'GET',
            data: { service_name: serviceName },
            success: function (response) {
                if (response.success) {
                    // Then fetch price
                    getServicePrice(response.service_id, durationSelect.val(), chargesInput);
                }
            }
        });
    }

    // Handle Duration Change
    function handleDurationChange(selectElement) {
        var card = $(selectElement).closest('.form-card');
        var serviceName = card.find('.service-select').val();
        var duration = $(selectElement).val();
        var chargesInput = card.find('.charges-input');

        if(serviceName) {
            $.ajax({
                url: "{{ url('getallserviceid') }}",
                type: 'GET',
                data: { service_name: serviceName },
                success: function (response) {
                    if (response.success) {
                        getServicePrice(response.service_id, duration, chargesInput);
                    }
                }
            });
        }
    }

    // Helper to get price
    function getServicePrice(serviceId, duration, chargesInput) {
        $.ajax({
            url: "{{ url('getserviceprice') }}",
            type: 'GET',
            data: { service_id: serviceId, duration: duration },
            success: function (response) {
                if (response.success) {
                    chargesInput.val(response.price);
                }
            }
        });
    }

    // Add More Service Function
    function addMoreService() {
        var index = $('.form-card').length; // Calculate new index based on current count
        var template = $('.form-card').first().clone();

        // Update inputs with new index and clear values so they don't conflict
        template.find('input[name*="[service_id]"]').remove(); // Remove ID field for new entry
        
        template.find('select.service-select')
            .attr('name', 'services[' + index + '][service]')
            .val('')
            .attr('onchange', 'handleServiceChange(this)');
            
        template.find('select.duration-select')
            .attr('name', 'services[' + index + '][duration]')
            .val('1')
            .attr('onchange', 'handleDurationChange(this)');
            
        template.find('input.charges-input')
            .attr('name', 'services[' + index + '][charges]')
            .val('');
            
        template.find('textarea')
            .attr('name', 'services[' + index + '][description]')
            .val('');
        
        template.find('legend').text('Service Details ' + (index + 1));
        
        // Setup close button
        template.find('.close-btn')
            .attr('onclick', 'deleteService(this)')
            .removeAttr('data-service-id'); // Remove data-id since it's new

        $('#service-forms').append(template);
        
        // Populate service options dynamically for the new dropdown
         $.ajax({
            url: "{{ url('getallservices') }}",
            type: 'GET',
            success: function (response) {
                if (response.success) {
                    var select = template.find('select.service-select');
                    select.empty().append('<option value="">Select An Option</option>');
                    response.services.forEach(function (service) {
                        select.append($('<option></option>').text(service.name).val(service.name));
                    });
                }
            }
        });
    }

    // Check for duplicates
    $(document).on('change', '.service-select', function() {
        let currentSelect = $(this);
        let selectedValue = currentSelect.val();
        let isDuplicate = false;

        $('.service-select').not(currentSelect).each(function() {
            if ($(this).val() === selectedValue && selectedValue !== "") {
                isDuplicate = true;
                return false;
            }
        });

        if (isDuplicate) {
            alert('Service already selected.');
            currentSelect.val('');
            currentSelect.closest('.form-card').find('.charges-input').val('');
        }
    });

</script>
@endsection