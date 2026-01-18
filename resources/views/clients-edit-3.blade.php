@extends('layouts.main')

@section('page')
<div class="form-col">
    <div class="container">
        <div class="row">
            <div class="col-md-12 row align-items-center heading-wrapper">
                <div class="col-md-6 col-12">
                    <h1>Edit Client</h1>
                </div>
                <div class="col-md-12">
                    <div class="form-step">
                        <ul class="form-stepper form-stepper-horizontal mx-auto">
                            <li class="form-stepper-completed text-center form-stepper-list" step="1">
                                <a class="mx-2">
                                    <span class="form-stepper-circle">
                                        <span>1</span>
                                    </span>
                                    <div class="label">Services</div>
                                </a>
                            </li>
                            <li class="form-stepper-completed text-center form-stepper-list" step="2">
                                <a class="mx-2">
                                    <span class="form-stepper-circle text-muted">
                                        <span>2</span>
                                    </span>
                                    <div class="label text-muted">Client Basic Details</div>
                                </a>
                            </li>
                            <li class="form-stepper-active text-center form-stepper-list" step="3">
                                <a class="mx-2">
                                    <span class="form-stepper-circle text-muted">
                                        <span>3</span>
                                    </span>
                                    <div class="label text-muted">Payment</div>
                                </a>
                            </li>
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
            </div>
            <div class="col-md-12 m-auto">
                @php
                   $storedServices = session('storedServices');
                @endphp
               
                <form action="{{url('/clients-edit-4')}}" method="post" class="create-form">
                    @csrf
                    
                    @if($storedServices)
                        @foreach ($storedServices as $serviceData)
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Service Selected<sup>*</sup></label>
                                {{-- Use ?? '' to prevent errors if key is missing --}}
                                <input type="text" required readonly value="{{ $serviceData['service'] ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label for="">Service Charges (in RS)<sup>*</sup></label>
                                {{-- Changed ID to Class to prevent duplicates --}}
                                <input type="number" name="charges[]" class="service-charge" required value="{{ $serviceData['charges'] ?? 0 }}">
                            </div>
                        </div>
                        {{-- Hidden textarea to pass description if needed --}}
                        <div class="col-md-12">
                            <label for="">Description</label>
                            <textarea rows="2" readonly>{{$serviceData['description'] ?? ''}}</textarea>
                        </div>
                        @endforeach
                    @endif
                   
                    <div class="row">
                        <hr>
                        <div class="col-md-6">
                            <label for="">Total Amount To Be Paid (in RS)<sup>*</sup></label>
                            {{-- Added null checks (?? 0) to prevent crash if payment history is empty --}}
                            <input type="number" required name="total_payment" id="total_payment" value="{{ $clientPayment->total_payment ?? 0 }}">
                        </div>
                        
                        <div class="col-md-6 date-div">
                            <label for="">Next Due<sup>*</sup></label>
                            <input type="date" required id="nextDueDate" name="next_due_date">
                        </div>
                        <div class="col-md-6">
                            <label for="">Paid Amount (In Rupees)</label>
                            <input type="number" required name="payable_amount" id="payable_amount" value="{{ $clientPayment->pay_amount ?? 0 }}">
                        </div>

                        <div class="col-md-6">
                            <label for="">Pending Amount (In Rupees)</label>
                            <input type="number" readonly required name="pending_amount" id="pending_amount" value="{{ $clientPayment->pending_amount ?? 0 }}">
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-btn-col">
                            <button id="simulate-payment-button" class="btn">Submit</button>
                            <button onclick="goback()" type="button" class="btn btn-second">Back</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://pay.google.com/gp/p/js/pay.js"></script>

<script>
    function calculatePendingFees() {
        const totalFees = parseFloat(document.getElementById('total_payment').value) || 0;
        const totalPaidFees = parseFloat(document.getElementById('payable_amount').value) || 0;

        if (!isNaN(totalPaidFees) && totalPaidFees <= totalFees) {
            const pendingFees = totalFees - totalPaidFees;
            document.getElementById('pending_amount').value = pendingFees;
        } else {
            // Keep pending 0 if paid exceeds total
            document.getElementById('pending_amount').value = 0;
        }
    }

    document.getElementById('payable_amount').addEventListener('input', calculatePendingFees);
    document.getElementById('total_payment').addEventListener('input', calculatePendingFees);
    
    // Listen to changes on ALL service charge inputs using class selector
    document.querySelectorAll('.service-charge').forEach(item => {
        item.addEventListener('input', calculateTotalPrice);
    });

    document.addEventListener('DOMContentLoaded', function() {
        nextDueDatecalulate();
        calculateTotalPrice(); // Calc initial total
        calculatePendingFees(); // Calc initial pending
    });

    function nextDueDatecalulate() {
        const nextDueField = document.getElementById('nextDueDate');
        const currentDate = new Date();
        const nextDueDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, currentDate.getDate());
        const formattedNextDueDate = nextDueDate.toISOString().split('T')[0];
        nextDueField.value = formattedNextDueDate;
    };

    function calculateTotalPrice() {
        let totalPrice = 0;
        const feeInputs = document.querySelectorAll('.service-charge');
        
        feeInputs.forEach(function(input) {
            if (!isNaN(input.value) && input.value !== '') {
                totalPrice += parseFloat(input.value);
            }
        });

        document.getElementById('total_payment').value = totalPrice;
        calculatePendingFees(); // Recalculate pending when total changes
    }

    function submitForm() {
        let totalFees = parseFloat($('#total_payment').val());
        let totalPaidFees = parseFloat($('#payable_amount').val());
        let pendingFees = parseFloat($('#pending_amount').val());
        let nextDueDate = $('#nextDueDate').val();

        $.ajax({
            url: '{{url('/clients-edit-4')}}',
            method: 'POST',
            data: {
               "_token": "{{ csrf_token() }}",
                "total_payment": totalFees,
                "payable_amount": totalPaidFees,
                "pending_amount": pendingFees,
                "next_due_date": nextDueDate
            },
            success: function(response) {
                // Redirect on success
                window.location.href = '{{url("/clients-edit-4")}}';
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }

    function validateForm() {
        const totalFees = document.getElementById('total_payment').value.trim();
        const totalPaidFees = document.getElementById('payable_amount').value.trim();
        
        if (totalFees === '' || totalPaidFees === '' ) {
            alert('Please fill in all required fields.');
            return false;
        }
        return true;
    }

    // Submit handler
    document.getElementById('simulate-payment-button').addEventListener('click', function (event) {
        event.preventDefault(); // Stop default form submit for this specific step to use AJAX
        if (validateForm()) {
            alert('Client Updated successful!');
            submitForm();
        }
    });

    $(document).ready(function() {
        const nextDueField = $('.date-div');
        const pendingFeesInput = $('#pending_amount');
        const payableFeesInput = $('#payable_amount');

        function hideOrSetDueDate() {
            const pendingFeess = parseFloat(pendingFeesInput.val()) || 0;
            if (pendingFeess === 0) {
                nextDueField.hide();
                $('#nextDueDate').val('');
            } else {
                nextDueField.show();
                nextDueDatecalulate();
            }
        }

        payableFeesInput.on('input', hideOrSetDueDate);
        pendingFeesInput.on('change', hideOrSetDueDate);

        $('#payable_amount').on('input', function() {
            let totalFees = parseFloat($('#total_payment ').val());
            let enteredPayableFees = parseFloat($('#payable_amount').val());

            if (enteredPayableFees > totalFees) {
                alert('Payable fees cannot exceed Pending fees.');
                $('#payable_amount ').val('');
            }
        });
    });
</script> 
@endsection