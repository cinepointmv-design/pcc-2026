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
                                        <li class="form-stepper-completed text-center form-stepper-list" step="2">
                                            <a class="mx-2">
                                                <span class="form-stepper-circle text-muted">
                                                    <span>2</span>
                                                </span>
                                                <div class="label text-muted">Client Basic Details</div>
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
                            @php
                            
                            // Retrieve the service session data
                               $storedServices = session('storedServices');
                              
                               @endphp
                           
                            <form action="{{url('/clients-edit-4')}}" method="post"  class="create-form">
                                @csrf
                                @foreach ($storedServices as $serviceData)

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Service Selected<sup>*</sup></label>
                                        <input type="text" required readonly value="{{ $serviceData['service'] }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Service Charges (in RS)<sup>*</sup></label>
                                        <input type="number" name="charges" id="charges"  required value="{{ $serviceData['charges'] }}">
                                    </div>
                                   
                                </div>
                               
                            @endforeach
                           
                            <div class="row">
                                <hr>
                                <div class="col-md-6">
                                    <label for="">Total Amount To Be Paid (in RS)<sup>*</sup></label>
                                    <input type="number" required name="total_payment"  id="total_payment" value="{{$clientPayment->total_payment}}">
                                </div>
                                {{-- <div class="col-md-6">
                                    <label for="">Total Paid (in RS)<sup>*</sup></label>
                                    <input type="number" required name="total_paid_amount"  id="total_paid_amount" value="{{$clientPayment->total_paid_amount}}">
                                </div> --}}
                                <div class="col-md-6 date-div">
                                    <label for="">Next Due<sup>*</sup></label>
                                    <input type="date" required id="nextDueDate">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Paid Amount (In Rupees)</label>
                                    <input type="number" required name="payable_amount"  id="payable_amount" value="{{$clientPayment->pay_amount}}">
                                </div>

                                <div class="col-md-6">
                                    <label for="">Pending Amount (In Rupees)</label>
                                    <input type="number" readonly required name="pending_amount"  id="pending_amount" value="{{$clientPayment->pending_amount}}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="">Description</label>
                                <textarea rows="2">{{$serviceData['description']}}</textarea>
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

        </div>
        
        <script src="https://pay.google.com/gp/p/js/pay.js"></script>

<script>

    // Function to calculate pending fees
function calculatePendingFees() {
    const totalFees = parseFloat(document.getElementById('total_payment').value);
    const totalPaidFees = parseFloat(document.getElementById('payable_amount').value);

    // Check if the total paid fees is a valid number and is less than or equal to total fees
    if (!isNaN(totalPaidFees) && totalPaidFees <= totalFees) {
        const pendingFees = totalFees - totalPaidFees;
        // Display the pending fees in the input field
        document.getElementById('pending_amount').value = pendingFees;
    } else {
        // If total paid fees is greater than total fees, display 0 in pending fees
        document.getElementById('pending_amount').value ;
    }
}



// Event listener for changes in total paid fees input
document.getElementById('payable_amount').addEventListener('input', calculatePendingFees);

// Event listener for changes in total fees input
document.getElementById('total_payment').addEventListener('input', calculatePendingFees);

// Event listener for changes in total fees input
document.getElementById('charges').addEventListener('input', calculatePendingFees);


     document.addEventListener('DOMContentLoaded', function() {
        nextDueDatecalulate();

    });

        function nextDueDatecalulate() {
        // Get the input element by ID
        const nextDueField = document.getElementById('nextDueDate');
        
        // Get the current date
        const currentDate = new Date();
        
        // Calculate the next due date (current date + 1 month)
        const nextDueDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, currentDate.getDate());

        // Format the next due date in 'YYYY-MM-DD' format
        const formattedNextDueDate = nextDueDate.toISOString().split('T')[0];

        // Set the value of the Next Due input field
        nextDueField.value = formattedNextDueDate;
    };



    function calculateTotalPrice() {
        let totalPrice = 0;

        // Select all input elements of type 'number' within the form
        const feeInputs = document.querySelectorAll('input[name="charges"]');
        
        // Loop through each input element and sum up the values
        feeInputs.forEach(function(input) {
            // Check if the input value is a valid number
            if (!isNaN(input.value) && input.value !== '') {
                totalPrice += parseFloat(input.value);
            }
        });

        // Display the total price in the total-price input field
        document.getElementById('total_payment').value = totalPrice;
    }

    // Call the calculateTotalPrice function when the document is loaded
    document.addEventListener('DOMContentLoaded', function() {
        calculateTotalPrice();
    });

    // Call the calculateTotalPrice function when the document is loaded
    document.addEventListener('DOMContentLoaded', function() {
        calculatePendingFees();
    });

    // Event listener for changes in the fees inputs to recalculate total price
    document.querySelectorAll('input[name="charges"]').forEach(function(input) {
        input.addEventListener('input', calculateTotalPrice);
    });

    function submitForm() {

    let totalFees = parseFloat($('#total_payment').val());
    let total_paid_amount = parseFloat($('#total_paid_amount').val());
    let totalPaidFees = parseFloat($('#payable_amount').val());
    let pendingFees = parseFloat($('#pending_amount').val());
    let nextDueDate = $('#nextDueDate').val();

    // Submit all form data
    $.ajax({
        url: '{{url('/clients-edit-4')}}',
        method: 'POST',
        data: {
           "_token": "{{ csrf_token() }}",
            "total_payment": totalFees,
            "payable_amount": totalPaidFees,
            "pending_amount": pendingFees,
            "total_paid_amount" : total_paid_amount,
            "next_due_date": nextDueDate
        },
        success: function(response) {
            // Handle success response
            window.location.href = '{{url("/clients-edit-4")}}';
            console.log(response);
        },
        error: function(xhr) {
            // Handle error response
            console.log(xhr.responseText);
        }
    });
}

function validateForm() {
    // Get the values of the required fields
    const totalFees = document.getElementById('total_payment').value.trim();
    const totalPaidFees = document.getElementById('payable_amount').value.trim();
    const nextDueDate = document.getElementById('nextDueDate').value.trim();

    // Check if any required field is empty
    if (totalFees === '' || totalPaidFees === '' ) {
        // Show an alert or message indicating that required fields are empty
        alert('Please fill in all required fields.');
        return false; // Prevent form submission
    }

    // If all required fields are filled, allow form submission
    return true;
}


// Event listener for the "Simulate Payment" button
document.getElementById('simulate-payment-button').addEventListener('click', function (event) {
    event.preventDefault(); // Prevent default form submission

    if (validateForm()) {
        // Simulate a successful payment response
        alert('Client Updated successful!'); // Show the alert

        // Call the function to submit the form data after the alert
        submitForm();

        // Redirect to the 'student-register-done' page
        
    }
});

$(document).ready(function() {
    const nextDueField = $('.date-div');
    const pendingFeesInput = $('#pending_amount');
    const payableFeesInput = $('#payable_amount');

    function hideOrSetDueDate() {
        const pendingFees = parseFloat(pendingFeesInput.val());
        const payableFees = parseFloat(payableFeesInput.val());
       

        $(document).ready(function() { 
            const pendingFeess = parseFloat(pendingFeesInput.val());
            console.log(pendingFeess);
       

        if (pendingFeess === 0) {
            nextDueField.hide();
            $('#nextDueDate').val('');
        } else {
            nextDueField.show();
            nextDueDatecalulate();
            
        }

    });
    }

    payableFeesInput.on('input', hideOrSetDueDate);

    // Add an event listener for changes in the pending fees field
    pendingFeesInput.on('change', function() {
        hideOrSetDueDate(); // Check and hide/show the next due date based on the new pending fees value
    });

    $('#payable_amount').on('input', function() {
                    let totalFees = parseFloat($('#total_payment ').val()); // Get total fees as a float
                    let enteredPayableFees = parseFloat($('#payable_amount').val()); // Get entered payable fees as a float

                    // Check if entered payable fees exceed total fees
                    if (enteredPayableFees > totalFees) {
                        alert('Payable fees cannot exceed Pending fees.'); // Display an alert message
                        $('#payable_amount ').val(''); // Clear the entered value in the payable fees field
                       
                        // You can also prevent form submission or handle it in any way suitable for your application
                    }
                });

    
});




</script> 

        @endsection