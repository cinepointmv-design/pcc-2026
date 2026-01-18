@extends('layouts.main')

@section('title', 'Clients - BCRM')

@section('page')
    <div class="form-col">
        <div class="col-md-12 mb-4">
            <div class="form-step">
                <ul class="form-stepper form-stepper-horizontal mx-auto">
                    <li class="form-stepper-active text-center form-stepper-list" step="1">
                        <a class="mx-2">
                            <span class="form-stepper-circle"><span>1</span></span>
                            <div class="label">Services</div>
                        </a>
                    </li>
                    <li class="form-stepper-unfinished text-center form-stepper-list" step="2">
                        <a class="mx-2">
                            <span class="form-stepper-circle text-muted"><span>2</span></span>
                            <div class="label text-muted">Client Basic Details</div>
                        </a>
                    </li>
                    <li class="form-stepper-unfinished text-center form-stepper-list" step="3">
                        <a class="mx-2">
                            <span class="form-stepper-circle text-muted"><span>3</span></span>
                            <div class="label text-muted">Payment</div>
                        </a>
                    </li>
                    <li class="form-stepper-unfinished text-center form-stepper-list" step="4">
                        <a class="mx-2">
                            <span class="form-stepper-circle text-muted"><span>4</span></span>
                            <div class="label text-muted">Done</div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-12 m-auto">
            <form id="service-form" class="create-form" method="post" action="{{url('/create-client-2')}}">
                @csrf
                <div class="row gx-0">
                    <div id="service-forms">
                        {{-- Initial Card --}}
                        <div class="form-card mb-4">
                            <fieldset>
                                <legend>Service Details 1</legend>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Service<sup>*</sup></label>
                                        <select name="services[0][service]" class="service-select" required onchange="handleServiceChange(this)">
                                            <option value="">Select An Option</option>
                                            @foreach($serviceName as $service)
                                                <option value="{{ $service->name }}">{{ $service->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Duration (In Months) <sup>*</sup></label>
                                        <select name="services[0][duration]" class="duration-select" required onchange="handleDurationChange(this)">
                                            <option value="">Select An Option</option>
                                            @for ($i = 1; $i <= 24; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Charges (in RS)<sup>*</sup></label>
                                        <input type="number" name="services[0][charges]" class="charges-input" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Description</label>
                                        <textarea name="services[0][description]" rows="2"></textarea>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-btn-col">
                            <button type="button" onclick="addMoreService()" class="btn">Add More</button>
                            <button type="submit" class="btn">Next</button>
                            <button onclick="goback()" type="button" class="btn btn-second">Back</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    // Handle Service Change to fetch Price
    function handleServiceChange(selectElement) {
        var serviceName = $(selectElement).val();
        var card = $(selectElement).closest('.form-card');
        var durationSelect = card.find('.duration-select');
        var chargesInput = card.find('.charges-input');
        
        durationSelect.val('1'); 

        if(serviceName) {
            $.ajax({
                url: "{{ url('getallserviceid') }}", 
                type: 'GET',
                data: { service_name: serviceName },
                success: function (response) {
                    if (response.success) {
                        getServicePrice(response.service_id, 1, chargesInput);
                    }
                }
            });
        }
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

    function addMoreService() {
        var index = $('.form-card').length; 
        var template = $('.form-card').first().clone();

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
        
        if(template.find('.close-btn').length === 0){
             template.prepend(`
                <div class="close-btn" onclick="removeCard(this)" style="text-align: right; margin-bottom: 10px; cursor: pointer;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                        <path d="M3.646 3.646a.5.5 0 0 1 .708 0L8 7.293l4.646-4.647a.5.5 0 0 1 .708.708L8.707 8l4.647 4.646a.5.5 0 0 1-.708.708L8 8.707l-4.646 4.647a.5.5 0 0 1-.708-.708L7.293 8 2.646 3.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                </div>
            `);
        } else {
             template.find('.close-btn').attr('onclick', 'removeCard(this)');
        }

        $('#service-forms').append(template);
    }

    function removeCard(btn) {
        if($('.form-card').length > 1) {
            $(btn).closest('.form-card').remove();
        } else {
            alert("At least one service is required.");
        }
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

    function goback() {
        window.history.back();
    }
</script>