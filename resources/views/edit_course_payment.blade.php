@extends('layouts.admin-main')


@section('adminpage')

            <!-- form section -->
            <div class="form-col">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 row align-items-center heading-wrapper">
                            
                            <div class="col-md-12">
                                <div class="form-step">
                                    <ul class="form-stepper form-stepper-horizontal mx-auto">
                                        <!-- Step 1 -->
                                        <li class="form-stepper-completed text-center form-stepper-list" step="1">
                                            <a class="mx-2">
                                                <span class="form-stepper-circle">
                                                    <span>1</span>
                                                </span>
                                                <div class="label">Add Student</div>
                                            </a>
                                        </li>
                                        <!-- Step 2 -->
                                        <li class="form-stepper-completed text-center form-stepper-list" step="2">
                                            <a class="mx-2">
                                                <span class="form-stepper-circle text-muted">
                                                    <span>2</span>
                                                </span>
                                                <div class="label text-muted">Select Course</div>
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
                        </div>
                        <div class="col-md-12 m-auto">
                            @php
                            // Retrieve the service session data
                            $studentCourses = session('student_courses');
                            $totalPrice = 0;
            
                            if (!is_null($studentCourses) && (is_array($studentCourses) || is_object($studentCourses))) {
                            @endphp
            
                            <form action="" method="post" class="create-form" id="payment-form">
                                @csrf
                                <div class="row">
                                    @foreach ($studentCourses as $course)
                                    @php
                                    // Fetch the course details from the database based on course_id
                                    $courseDetails = DB::table('courses')->where('id', $course['course'])->first();
            
                                    // Calculate the total price for each course
                                    $courseTotalPrice = $course['fees'];
            
                                    // Calculate next due based on the duration
                                    $nextDue = date('Y-m-d', strtotime("+{$course['duration']} months"));
                                    $totalPrice += $courseTotalPrice;
                                    @endphp
            
                                    <div class="col-md-12 formdata">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="">Selected Course </label>
                                                <input type="text" required readonly value="{{ $courseDetails ? $courseDetails->course_name : 'Unknown' }}">
                                            </div>
                                           
                                            <div class="col-md-6">
                                                <label for="">Course Fees (In Rupees)</label>
                                                <input type="number" name="fees" required id="fees"  value="{{ $course['fees'] }}">
                                            </div>

                                        </div>
                                      
                                    </div>
                                    @endforeach

                                   
                                    
                                       
                                    
                                    <div class="col-md-6">
                                        <label for="">Total Price of Selected Courses (In Rupees)</label>
                                        <input type="number" required name="total_fees"  id="total-price" value="{{$feesdetail['total_fees']}}" >
                                    </div>

                                    <div class="col-md-6">
                                                <label for="">Next Due Date</label>
                                                <input type="date" id="nextDueDate" required >
                                            </div>

                                    <div class="col-md-6">
                                        <label for="">Total Paid Fees (In Rupees)</label>
                                        <input type="number" required name="total-paid-fees"  id="total-paid-fees" value="{{$feesdetail['total_paid_fees']}}" >
                                    </div>

                                    <div class="col-md-6">
                                        <label for="">Pending Fees (In Rupees)</label>
                                        <input type="number" required name="pending-fees" value="{{$feesdetail['pending_fees']}}"  id="pending-fees" >
                                    </div>
                                  
                                </div>
            
                            @php
                            }
                            @endphp
            
                            <div class="col-md-12">
                                <div class="form-btn-col">   
                                   <button type="button" class="btn" id="simulate-payment-button">Submit</button>
                                    <button onclick="goback()" type="button" class="btn btn-second">Back</button>
                                </div>
                            </div>
                    </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Include Google Pay library -->
<script src="https://pay.google.com/gp/p/js/pay.js"></script>

<script>

    // Function to calculate pending fees
function calculatePendingFees() {
    const totalFees = parseFloat(document.getElementById('total-price').value);
    const totalPaidFees = parseFloat(document.getElementById('total-paid-fees').value);

    // Check if the total paid fees is a valid number and is less than or equal to total fees
    if (!isNaN(totalPaidFees) && totalPaidFees <= totalFees) {
        const pendingFees = totalFees - totalPaidFees;
        // Display the pending fees in the input field
        document.getElementById('pending-fees').value = pendingFees;
    } else {
        // If total paid fees is greater than total fees, display 0 in pending fees
        document.getElementById('pending-fees').value = 0;
    }
}

// Event listener for changes in total paid fees input
document.getElementById('total-paid-fees').addEventListener('input', calculatePendingFees);

// Event listener for changes in total fees input
document.getElementById('total-price').addEventListener('input', calculatePendingFees);

// Event listener for changes in total fees input
document.getElementById('fees').addEventListener('input', calculatePendingFees);


     document.addEventListener('DOMContentLoaded', function() {
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
    });

    function calculateTotalPrice() {
        let totalPrice = 0;

        // Select all input elements of type 'number' within the form
        const feeInputs = document.querySelectorAll('input[name="fees"]');
        
        // Loop through each input element and sum up the values
        feeInputs.forEach(function(input) {
            // Check if the input value is a valid number
            if (!isNaN(input.value) && input.value !== '') {
                totalPrice += parseFloat(input.value);
            }
        });

        // Display the total price in the total-price input field
        document.getElementById('total-price').value = totalPrice;
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
    document.querySelectorAll('input[type="number"]').forEach(function(input) {
        input.addEventListener('input', calculateTotalPrice);
    });

    function submitForm() {

    let totalFees = parseFloat($('#total-price').val());
    let totalPaidFees = parseFloat($('#total-paid-fees').val());
    let pendingFees = parseFloat($('#pending-fees').val());
    let nextDueDate = $('#nextDueDate').val();

    // Submit all form data
    $.ajax({
        url: '{{url('/edit-student-register')}}',
        method: 'POST',
        data: {
           "_token": "{{ csrf_token() }}",
            "total_fees": totalFees,
            "total_paid_fees": totalPaidFees,
            "pending_fees": pendingFees,
            "next_due_date": nextDueDate
        },
        success: function(response) {
            // Handle success response
            console.log(response);
            window.location.href = '{{url('/student-register-done')}}';
        },
        error: function(xhr) {
            // Handle error response
            console.log(xhr.responseText);
        }
    });
}

function validateForm() {
    // Get the values of the required fields
    const totalFees = document.getElementById('total-price').value.trim();
    const totalPaidFees = document.getElementById('total-paid-fees').value.trim();
    const nextDueDate = document.getElementById('nextDueDate').value.trim();

    // Check if any required field is empty
    if (totalFees === '' || totalPaidFees === '' || nextDueDate === '') {
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
        alert('Student updated successfully'); // Show the alert

        // Call the function to submit the form data after the alert
        submitForm();

        // Redirect to the 'student-register-done' page
        
    }
});

$('#total-paid-fees').on('input', function() {
        let totalFees = parseFloat($('#total-price ').val()); // Get total fees as a float
        let enteredPayableFees = parseFloat($('#total-paid-fees').val()); // Get entered payable fees as a float

        // Check if entered payable fees exceed total fees
        if (enteredPayableFees > totalFees) {
            alert('Payable fees cannot exceed Total fees.'); // Display an alert message
            $('#total-paid-fees ').val(''); // Clear the entered value in the payable fees field
            
            // You can also prevent form submission or handle it in any way suitable for your application
        }
    });
</script>

    </main>

   @endsection
