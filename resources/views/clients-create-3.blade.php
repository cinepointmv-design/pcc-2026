@extends('layouts.main')

@section('title', 'Clients - BCRM')

@section('page')
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
                                <li class="form-stepper-completed text-center form-stepper-list" step="1">
                                    <a class="mx-2">
                                        <span class="form-stepper-circle"><span>1</span></span>
                                        <div class="label">Services</div>
                                    </a>
                                </li>
                                <li class="form-stepper-completed text-center form-stepper-list" step="2">
                                    <a class="mx-2">
                                        <span class="form-stepper-circle"><span>2</span></span>
                                        <div class="label">Client Basic Details</div>
                                    </a>
                                </li>
                                <li class="form-stepper-active text-center form-stepper-list" step="3">
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
                </div>
                <div class="col-md-12 m-auto">
                    @php
                    $storedServices = session('storedServices', []);
                    @endphp
    
                    <form action="{{ url('/create-client-4') }}" method="post" class="create-form">
                        @csrf
                        
                        @if(is_array($storedServices) && count($storedServices) > 0)
                            @foreach ($storedServices as $serviceData)
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Service Selected<sup>*</sup></label>
                                        <input type="text" required readonly value="{{ $serviceData['service_name'] ?? '' }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Service Charges (in RS)<sup>*</sup></label>
                                        {{-- Class 'service-charge' used for calculation --}}
                                        <input type="number" name="charges[]" class="service-charge" required value="{{ $serviceData['charges'] ?? 0 }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label>Description</label>
                                    <textarea rows="2" readonly>{{ $serviceData['description'] ?? '' }}</textarea>
                                </div>
                            @endforeach
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Total Amount To Be Paid (in RS)<sup>*</sup></label>
                                    <input type="number" required name="total_payment" id="total_payment">
                                </div>
                               
                                <div class="col-md-6">
                                    <label>Paid Amount (In Rupees)</label>
                                    <input type="number" required name="payable_amount" id="payable_amount">
                                </div>

                                <div class="col-md-6">
                                    <label>Pending Amount (In Rupees)</label>
                                    <input type="number" readonly required name="pending_amount" id="pending_amount">
                                </div>
                                <div class="col-md-6 date-div">
                                    <label>Next Due<sup>*</sup></label>
                                    <input type="date" required id="nextDueDate" name="next_due_date">
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning">No services selected. Please return to Step 1.</div>
                        @endif
    
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
@endsection

<script src="https://pay.google.com/gp/p/js/pay.js"></script>

<script>
    // DEFENSIVE HELPER: Gets element safely
    function getEl(id) {
        return document.getElementById(id);
    }

    function calculatePendingFees() {
        const totalEl = getEl('total_payment');
        const paidEl = getEl('payable_amount');
        const pendingEl = getEl('pending_amount');

        if (!totalEl || !paidEl || !pendingEl) return;

        const totalFees = parseFloat(totalEl.value) || 0;
        const totalPaidFees = parseFloat(paidEl.value) || 0;

        if (!isNaN(totalPaidFees) && totalPaidFees <= totalFees) {
            const pendingFees = totalFees - totalPaidFees;
            pendingEl.value = pendingFees;
        } else {
            pendingEl.value = 0;
        }
    }

    // Run this safely on load
    document.addEventListener('DOMContentLoaded', function() {
        const payAmount = getEl('payable_amount');
        const totalAmount = getEl('total_payment');

        // Safely attach listeners
        if (payAmount) payAmount.addEventListener('input', calculatePendingFees);
        if (totalAmount) totalAmount.addEventListener('input', calculatePendingFees);
        
        document.querySelectorAll('.service-charge').forEach(item => {
            item.addEventListener('input', calculateTotalPrice);
        });

        // Run initial calculations
        nextDueDatecalulate();
        calculateTotalPrice(); 
    });

    function nextDueDatecalulate() {
        const nextDueField = getEl('nextDueDate');
        if(nextDueField) {
            const currentDate = new Date();
            // Set to 1 Month from now
            const nextDueDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, currentDate.getDate());
            const formattedNextDueDate = nextDueDate.toISOString().split('T')[0];
            nextDueField.value = formattedNextDueDate;
        }
    };

    function calculateTotalPrice() {
        let totalPrice = 0;
        const feeInputs = document.querySelectorAll('.service-charge');
        
        feeInputs.forEach(function(input) {
            if (!isNaN(input.value) && input.value !== '') {
                totalPrice += parseFloat(input.value);
            }
        });

        const totalPayment = getEl('total_payment');
        if(totalPayment) {
            totalPayment.value = totalPrice;
            calculatePendingFees(); // Recalculate pending whenever total updates
        }
    }

    function submitForm() {
        if(!getEl('total_payment')) return; // Safety check

        let totalFees = parseFloat(getEl('total_payment').value);
        let totalPaidFees = parseFloat(getEl('payable_amount').value);
        let pendingFees = parseFloat(getEl('pending_amount').value);
        let nextDueDate = getEl('nextDueDate').value;

        $.ajax({
            url: '{{url('/create-client-4')}}',
            method: 'POST',
            data: {
               "_token": "{{ csrf_token() }}",
                "total_payment": totalFees,
                "payable_amount": totalPaidFees,
                "pending_amount": pendingFees,
                "next_due_date": nextDueDate
            },
            success: function(response) {
                window.location.href = "{{url('/clients-create-4')}}";
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }

    function validateForm() {
        const totalEl = getEl('total_payment');
        const paidEl = getEl('payable_amount');

        if (!totalEl || !paidEl) return false;

        const totalFees = totalEl.value.trim();
        const totalPaidFees = paidEl.value.trim();
        
        if (totalFees === '' || totalPaidFees === '' ) {
            alert('Please fill in all required fields.');
            return false;
        }
        return true;
    }

    const submitBtn = getEl('simulate-payment-button');
    if(submitBtn) {
        submitBtn.addEventListener('click', function (event) {
            event.preventDefault();
            if (validateForm()) {
                alert('Client Register successful!');
                submitForm();
            }
        });
    }

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

        if(payableFeesInput.length) {
            payableFeesInput.on('input', hideOrSetDueDate);
            pendingFeesInput.on('change', hideOrSetDueDate);

            $('#payable_amount').on('input', function() {
                let totalFees = parseFloat($('#total_payment ').val());
                let enteredPayableFees = parseFloat($('#payable_amount').val());

                if (enteredPayableFees > totalFees) {
                    alert('Payable fees cannot exceed Total fees.');
                    $('#payable_amount ').val('');
                }
            });
        }
    });
    
    function goback() {
        window.history.back();
    }
</script>