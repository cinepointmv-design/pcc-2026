@extends('layouts.admin-main')

@section('adminpage')
    <!-- table section -->
    <form id="dualActionForm" method="POST" action="" class="create-form">
        @csrf

        <div class="table-col">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 row align-items-center heading-wrapper">
                        <div class="col-md-6 col-12">
                            <h1>Fees Detail</h1>
                        </div>
                        <div class="col-md-6 col-12 d-flex justify-content-end">
                            <button onclick="goback()" type="button" class="btn btn-first">Back</button>
                        </div>
                    </div>
                    <div class="col-md-12 m-auto">
                        <div class="table-card">
                            <div class="table-container">
                                <table class="table table-hover data-table">
                                    <thead>
                                        <tr>
                                            {{-- <th>
                                                <input type="checkbox" id="selectAll" > 
                                            </th> --}}
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Father's Name</th>
                                            <th>Course</th>
                                            <th>Duration (In months)</th>
                                            <th>Course Fees</th>
                                            <th>Total Fees</th>
                                            <th>Paid Fees</th>
                                            <th>Pending Fees</th>
                                            <th>Next Due</th>
                                            <th colspan="4">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="clientTableBody">
                                        @foreach ($students as $student)
                                            @php
                                                $courses = $student->courses;      
                                                $fees = App\Models\StudentFees::where('student_id', $student->id)->latest('created_at')->first();
                                            @endphp

                                            @if ($courses->isNotEmpty())
                                                {{-- Display the student's details in the first row --}}
                                                <tr class="client-row">
                                                    <td rowspan="{{ $courses->count() }}">{{ $student->name }}</td>
                                                    <td rowspan="{{ $courses->count() }}">{{ $student->phone }}</td>
                                                    <td rowspan="{{ $courses->count() }}">{{ $student->fathername ? $student->fathername : 'N/A' }}</td>
                                                    {{-- Display details of the first course --}}
                                                    <td>{{ $courses->first()->course_name }}</td>
                                                    <td>{{ $courses->first()->duration }}</td>
                                                    <td>{{ $courses->first()->fees }}</td>
                                                    <td rowspan="{{ $courses->count() }}">{{ $fees ? $fees->total_fees ?? 'N/A' : 'N/A' }}</td>
                                                    <td rowspan="{{ $courses->count() }}">{{ $fees ? $fees->total_paid_fees ?? 'N/A' : 'N/A' }}</td>
                                                    <td rowspan="{{ $courses->count() }}">{{ $fees ? $fees->pending_fees ?? 'N/A' : 'N/A' }}</td>
                                                    <td rowspan="{{ $courses->count() }}">{{ $fees ? $fees->next_due_date ?? 'N/A' : 'N/A' }}</td>
                                                    <td rowspan="{{ $courses->count() }}">
                                                        <i class="fa-solid fa-plus add-fees me-3" style="font-size: 18px; color:blue; cursor:pointer" ></i>
                                                        <i class="fa-regular fa-pen-to-square edit-fees me-3"  style="font-size: 18px; color:#01B81A; cursor:pointer"></i>
                                                        <a href="" class="view-payment-logs" data-student-id="{{ $student->id }}">View Payments log</a>

                                                       
                                                    </td>
                                                    
                                                    
                                                </tr>

                                                {{-- Display the rest of the courses in separate rows --}}
                                                @foreach ($courses->slice(1) as $course)
                                                    <tr class="client-row">
                                                        <td>{{ $course->course_name }}</td>
                                                        <td>{{ $course->duration }}</td>
                                                        <td>{{ $course->fees }}</td>
                                                      
                                                    </tr>
                                                @endforeach
                                            @else
                                                {{-- If the student has no courses --}}
                                                <tr class="client-row">
                                                    <td>{{ $student->name }}</td>
                                                    <td>{{ $student->phone }}</td>
                                                    <td>{{ $student->fathername ? $student->fathername : 'N/A' }}</td>
                                                    <td colspan="7">No courses found</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-pagination">
                                {{-- {{ $students->links('pagination::bootstrap-4') }} --}}
                            </div>
                        </div>
                    </div>

                     {{-- view fees --}}

                     <div class="col-md-12 m-auto view-payment-log mt-5" style="display: none;">
                        <div class="table-card">
                            <div class="modal-header">
                                <h5 class="modal-title">Payment Logs</h5>
                                <button type="button" class="btn-close btn-close-payment-log" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="table-container">
                                <table class="table table-hover data-table">
                                    <thead>
                                        <tr>  
                                            <th>Paid Amount</th>
                                            <th>Payment Date</th>    
                                        </tr>
                                    </thead>
                                    <tbody id="paymentLogTableBody">
                                        <!-- Table rows will be dynamically added here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    {{-- add-fees --}}

                    <div class="col-md-12 mt-5 add-fees-form" style="display: none;">

                        <div class="form-card ">   
                        <form action="" method="post" class="create-form" id="payment-form">
                            @csrf
                       
                            <div class="row">
        
                                <div class="col-md-12 ">
                                    <div class="col-md-6 col-12 mb-4">
                                        <h1>Add Fees</h1>
                                    </div>  
                                @foreach ($courses as $course)
                                  
                                   
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="">Selected Course </label>
                                            <input type="text" required readonly value="{{$course->course_name}}" >
                                        </div>
                                       
                                        <div class="col-md-6">
                                            <label for="">Course Fees (In Rupees)</label>
                                            <input type="number" name="fees" readonly required id="fees"  value="{{$course->fees}}" >
                                        </div>

                                    </div>
                                    
                                   
                                 @endforeach   
                                 <hr>
                                  
                                </div>

                                <div class="col-md-6">
                                    <label for="">Total Price of Selected Courses (In Rupees)</label>
                                    <input type="number" required name="total_fees" readonly  id="total-price" value="{{$fees->total_fees }}" >
                                </div>

                                <div class="col-md-6 date-div">
                                            <label for="">Next Due Date</label>
                                            <input type="date" id="nextDueDate" >
                                        </div>

                                <div class="col-md-6">
                                    <label for=""> Paid Fees (In Rupees)</label>
                                    <input type="number" required name="total-paid-fees" id="total-paid-fees" readonly value="{{$fees->total_paid_fees }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="">Pending Fees (In Rupees)</label>
                                    <input type="number" required name="pending-fees"  id="pending-fees" readonly value="{{$fees->pending_fees }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="">Add Fees (In Rupees)</label>
                                    <input type="number" required name="payable-fees"  id="payable-fees" >
                                </div>
                            
                                <div class="col-md-12">
                                    <Button class="btn btn-primary" id="simulate-payment-button">Submit</Button>
                                    <Button class="btn btn-danger ms-1" style="background:#d9534f;" id="cancel-button">Cancel</Button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>  
                
                <div class="col-md-12 mt-5 edit-fees-form" style="display: none;">

                    <div class="form-card ">   
                    <form action="" method="post" class="create-form" id="payment-form">
                        @csrf
                   
                        <div class="row">
    
                            <div class="col-md-12 ">
                                <div class="col-md-6 col-12 mb-4">
                                    <h1>Edit Fees</h1>
                                </div> 

                            @php
                                $student_id = $student->id;

                                    // Check the count of records for the student
                                    $recordCount = App\Models\StudentFees::where('student_id', $student_id)->count();

                                    // Fetch the appropriate record(s) based on the count
                                    if ($recordCount == 1) {
                                        // If there's only one record, fetch that directly
                                        $data = App\Models\StudentFees::where('student_id', $student_id)->latest('created_at')->first();
                                    } else {
                                        // If there are multiple records, skip the latest and fetch the second most recent record
                                        $data = App\Models\StudentFees::where('student_id', $student_id)
                                            ->orderBy('created_at', 'desc')
                                            ->skip(1)
                                            ->take(1)
                                            ->first();
                                    }
                               
                            @endphp      

                              
                            @foreach ($courses as $course)

                            
                               
                                                           
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Selected Course </label>
                                        <input type="text" required readonly value="{{$course->course_name}}" >
                                    </div>
                                   
                                    <div class="col-md-6">
                                        <label for="">Course Fees (In Rupees)</label>
                                        <input type="number" name="editfees" readonly required id="editfees"  value="{{$course->fees}}" >
                                    </div>

                                </div>
                                
                               
                             @endforeach   
                             <hr>
                              
                            </div>

                            

                            <div class="col-md-6">
                                <label for="">Total Price of Selected Courses (In Rupees)</label>
                                <input type="number" required name="total_edit_fees" readonly  id="total-edit-price" value="{{$data->total_fees }}" >
                            </div>

                            <div class="col-md-6 edit-date-div">
                                        <label for="">Next Due Date</label>
                                        <input type="date" id="editnextDueDate" >
                                    </div>

                            <div class="col-md-6">
                                <label for=""> Paid Fees (In Rupees)</label>
                                <input type="number" required name="edit-total-paid-fees" id="edit-total-paid-fees"  value="{{$data->total_paid_fees }}">
                            </div>

                            <div class="col-md-6">
                                <label for="">Pending Fees (In Rupees)</label>
                                <input type="number" required name="edit-pending-fees"  id="edit-pending-fees" readonly >
                            </div>

                            <div class="col-md-6">
                                <label for="">Add Fees (In Rupees)</label>
                                <input type="number" required name="edit-payable-fees"  id="edit-payable-fees" >
                            </div>
                        
                            <div class="col-md-12">
                                <Button class="btn btn-primary" id="edit-simulate-payment-button">Submit</Button>
                                <Button class="btn btn-danger ms-1" style="background:#d9534f;" id="edit-cancel-button">Cancel</Button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>  
                    
                </div>
            </div>
        </div>
    </form>

    <!-- Add jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/YOUR_API_KEY/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        function confirmDelete() {
            return confirm('Are you sure to delete?');
        }

        $(document).ready(function () {
        $('.btn-close-payment-log').on('click', function () {
            location.reload();
            $('.view-payment-log').hide();
        });
    });

        $(document).ready(function () {
        // Attach a click event handler to all elements with the class 'view-payment-logs'
        $('.view-payment-logs').on('click', function (e) {
            e.preventDefault();
            var studentId = $(this).data('student-id');
            $.ajax({
                type: 'GET',
                url: '{{ url("/student-payment-logs") }}' + '/' + studentId,
                dataType: 'json',
                success: function (data) {
                    console.log('Response Data:', data);
                    if (data.success) {
                        // Clear existing rows
                        $('#paymentLogTableBody').empty();

                        // Append rows for each payment log entry
                        $.each(data.paymentLogs, function (index, fee) {
                            var row = '<tr class="client-row">' +
                                '<td>' + fee.pay_amount + '</td>' +
                                '<td>' + fee.payment_date + '</td>' +
                                '</tr>';

                            $('#paymentLogTableBody').append(row);
                        });

                        // Show the payment log table
                        $('.view-payment-log').show();
                    } else {
                        console.error('Error fetching payment details:', data.message);
                    }
                },
                error: function (error) {
                    console.error('Error fetching payment details:', error);
                }
            });
        });
    });

        $(document).on('click', '#cancel-button', function(event) {
                event.preventDefault();
                // Hide all other 'Add Fees' forms before showing the current one
                $('.add-fees-form').hide();
            });

            $(document).on('click', '#edit-cancel-button', function(event) {
                event.preventDefault();
                // Hide all other 'Add Fees' forms before showing the current one
                $('.edit-fees-form').hide();
            });

            $(document).on('click', '.edit-fees', function(event) {
                event.preventDefault();
                // Hide all other 'Add Fees' forms before showing the current one
                $('.edit-fees-form').show();
            });     

        $(document).ready(function() {

            $(document).ready(function() {
                
                $('#edit-total-paid-fees').on('input', function() {
                    let total_fees = parseFloat('{{$data->total_fees}}');
                    let paid_fees = parseFloat($('#edit-total-paid-fees').val()); 

                    
                        let newPendingFees = total_fees - paid_fees;

                        console.log(newPendingFees);

                        // Update the 'Pending Fees' field with the new value
                        $('#edit-pending-fees').val(newPendingFees >= 0 ? newPendingFees : 0);
                        $('#edit-payable-fees').val(0);

                        let pending = parseFloat($('#edit-pending-fees').val()); 
                

                        if (pending === 0) {
                            $('.edit-date-div').hide();
                            $('#nextDueDate').val('');
                        } else {
                            $('.edit-date-div').show();
                        }

                        // Get the input element by ID
    const editnextDueField = document.getElementById('editnextDueDate');
    const currentDate = new Date();
  
    
    // Calculate the next due date (current date + 1 month)
    const editnextDueDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, currentDate.getDate());




    if (pending == 0) {
       $('.edit-date-div').hide();
    } else {
        // Format the next due date in 'YYYY-MM-DD' format
        const editformattedNextDueDate = editnextDueDate.toISOString().split('T')[0];

        // Set the value of the Next Due input field
        editnextDueField.value = editformattedNextDueDate;
    }
                    
                });

               


                $('#payable-fees , #edit-payable-fees').on('input', function() {
                    let totalFees = parseFloat('{{$fees->pending_fees}}'); // Get total fees as a float
                    let enteredPayableFees = parseFloat($('#payable-fees').val()); // Get entered payable fees as a float

                    let datafees = parseFloat('{{$data->pending_fees}}'); // Get total fees as a float
                    let editenteredPayableFees = parseFloat($('#edit-payable-fees').val()); // Get entered payable fees as a float

                    // Check if entered payable fees exceed total fees
                    if (enteredPayableFees > totalFees) {
                        alert('Payable fees cannot exceed Pending fees.'); // Display an alert message
                        $('#payable-fees ').val(''); // Clear the entered value in the payable fees field
                       
                        // You can also prevent form submission or handle it in any way suitable for your application
                    }
                });


                $('#payable-fees , #edit-payable-fees').on('input', function() {
                    let total_fees = parseFloat('{{$fees->total_fees}}');
                    let paid_fees = parseFloat('{{$fees->total_paid_fees}}');
                    let new_fees = parseFloat($('#payable-fees').val());

                    let edit_total_fees = parseFloat('{{$data->total_fees}}');
                    let edit_paid_fees = parseFloat('{{$data->total_paid_fees}}');
                    let edit_new_fees = parseFloat($('#edit-payable-fees').val());


                    if (isNaN(new_fees) && isNaN(edit_new_fees)) {
                        // If payable fees field is empty, set the original value of pending fees
                        $('#pending-fees').val('{{$fees->pending_fees}}');
                        $('#edit-pending-fees').val('{{$data->pending_fees}}');
                    } else {
                        let addedFees = paid_fees + new_fees;
                        let newPendingFees = total_fees - addedFees;

                        let editaddedFees = edit_paid_fees + edit_new_fees;
                        let editnewPendingFees = edit_total_fees - editaddedFees;

                        // Update the 'Pending Fees' field with the new value
                        $('#pending-fees').val(newPendingFees >= 0 ? newPendingFees : 0);
                        // Update the 'Pending Fees' field with the new value
                        $('#edit-pending-fees').val(editnewPendingFees >= 0 ? editnewPendingFees : 0);
                    }
                });
            });
        
            $(document).on('click', '.add-fees', function(event) {
                event.preventDefault();
                // Hide all other 'Add Fees' forms before showing the current one
                $('.add-fees-form').show();
            });
    });

        
    $(document).ready(function() {
    // Function to hide Next Due and Action columns if pending fees is zero
    function hideColumnsIfZeroPendingFees() {
        const pendingFees = parseFloat("{{$fees->pending_fees}}");

        if (pendingFees === 0) {
            // Hide Next Due column (index 9) and Action column (index 10) for all rows
            $('table.data-table tr').find('td:eq(9), th:eq(9)').hide();
            $('.add-fees').hide();
        }
    }

    hideColumnsIfZeroPendingFees(); // Call the function initially

    // Rest of your code...
});
       

document.addEventListener('DOMContentLoaded', function() {
    // Get the input element by ID
    const nextDueField = document.getElementById('nextDueDate');
    
    // Get the current date
    const currentDate = new Date();
    
    // Calculate the next due date (current date + 1 month)
    const nextDueDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, currentDate.getDate());

    // Get pending fees value from the hidden input field
    const pendingFeesValue = "{{$fees->pending_fees}}";


    if (pendingFeesValue == 0) {
       $('.date-div').hide();
    } else {
        // Format the next due date in 'YYYY-MM-DD' format
        const formattedNextDueDate = nextDueDate.toISOString().split('T')[0];

        // Set the value of the Next Due input field
        nextDueField.value = formattedNextDueDate;
    }

    // Get the input element by ID
    const editnextDueField = document.getElementById('editnextDueDate');
    
  
    
    // Calculate the next due date (current date + 1 month)
    const editnextDueDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, currentDate.getDate());

    // Get pending fees value from the hidden input field
    const editpendingFeesValue = "{{$data->pending_fees}}";


    if (editpendingFeesValue == 0) {
       $('.edit-date-div').hide();
    } else {
        // Format the next due date in 'YYYY-MM-DD' format
        const editformattedNextDueDate = editnextDueDate.toISOString().split('T')[0];

        // Set the value of the Next Due input field
        editnextDueField.value = editformattedNextDueDate;
    }
});

$(document).ready(function() {
    const nextDueField = $('.date-div');
    const pendingFeesInput = $('#pending-fees');
    const payableFeesInput = $('#payable-fees');

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
        }

    });
    }

    payableFeesInput.on('input', hideOrSetDueDate);

    // Add an event listener for changes in the pending fees field
    pendingFeesInput.on('change', function() {
        hideOrSetDueDate(); // Check and hide/show the next due date based on the new pending fees value
    });

    // hideOrSetDueDate(); // Initially check and hide if needed

    const editnextDueField = $('.edit-date-div');
    const editpendingFeesInput = $('#edit-pending-fees');
    const editpayableFeesInput = $('#edit-payable-fees');

    function edithideOrSetDueDate() {
        const editpendingFees = parseFloat(editpendingFeesInput.val());
        const editpayableFees = parseFloat(editpayableFeesInput.val());
       

        $(document).ready(function() { 
            const editpendingFeess = parseFloat(editpendingFeesInput.val());
           
       

        if (editpendingFeess === 0) {
            editnextDueField.hide();
            $('#editnextDueDate').val('');
        } else {
            editnextDueField.show();
        }

    });
    }

    editpayableFeesInput.on('input', function() {
        edithideOrSetDueDate(); // Check and hide/show the next due date based on the new pending fees value
    });

    // Add an event listener for changes in the pending fees field
    editpendingFeesInput.on('change', function() {
        edithideOrSetDueDate(); // Check and hide/show the next due date based on the new pending fees value
    });

    // hideOrSetDueDate(); // Initially check and hide if needed
});
    

    function submitForm() {

    let student_id = "{{$student->id}}";      
    let totalPaidFees = parseFloat($('#total-paid-fees').val());   
    let totalFees = parseFloat($('#total-price').val());     
    let payable_fees = parseFloat($('#payable-fees').val());
    let pendingFees = parseFloat($('#pending-fees').val());
    let nextDueDate = $('#nextDueDate').val();


    // Submit all form data
    $.ajax({
        url: '{{url('/addnewfees')}}',
        method: 'POST',
        data: {
           "_token": "{{ csrf_token() }}",
           "student_id":  student_id,
            "total_paid_fees": totalPaidFees + payable_fees,
            "pending_fees": pendingFees,
            "next_due_date": nextDueDate,
            "totalFees" : totalFees,
            "payable_fees" : payable_fees,
        },
        success: function(response) {
            console.log(response);
            location.reload();
            // Close the form after submission
            $('.add-fees-form').hide();
        },
        error: function(xhr) {
            // Handle error response
            console.log(xhr.responseText);
        }
    });
}

function validateForm() {
    // Get the values of the required fields
    const totalFees = $('payable-fees').val();
    const totalPaidFees = $('total-paid-fees').val();
    // const nextDueDate = document.getElementById('nextDueDate').value.trim();

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
        // Show a confirmation dialog
        let confirmation = confirm('Are you sure to add fees?');

        // Check user's choice
        if (confirmation) {
            // User clicked "OK," call the function to submit the form data
            submitForm();
        } else {
            // User clicked "Cancel," do nothing or handle accordingly
            console.log('User cancelled the operation.');
        }
    }
});


//--------------------- edit-fees -----------------------

function editsubmitForm() {

let student_id = "{{$student->id}}";      
let totalPaidFees = parseFloat($('#edit-total-paid-fees').val());   
let totalFees = parseFloat($('#total-edit-price').val());     
let payable_fees = parseFloat($('#edit-payable-fees').val());
let pendingFees = parseFloat($('#edit-pending-fees').val());
let nextDueDate = $('#editnextDueDate').val();


// Submit all form data
$.ajax({
    url: '{{url('/editnewfees')}}',
    method: 'get',
    data: {
       "_token": "{{ csrf_token() }}",
       "student_id":  student_id,
        "total_paid_fees": totalPaidFees + payable_fees,
        "pending_fees": pendingFees,
        "next_due_date": nextDueDate,
        "totalFees" : totalFees,
        "payable_fees" : payable_fees,
    },
    success: function(response) {
        console.log(response);
        location.reload();
        // Close the form after submission
        $('.edit-fees-form').hide();
    },
    error: function(xhr) {
        // Handle error response
        console.log(xhr.responseText);
    }
});
}

function editvalidateForm() {
// Get the values of the required fields
const totalFees = $('edit-payable-fees').val();
const totalPaidFees = $('edit-total-paid-fees').val();
// const nextDueDate = document.getElementById('nextDueDate').value.trim();

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
// Event listener for the "Edit Simulate Payment" button
document.getElementById('edit-simulate-payment-button').addEventListener('click', function (event) {
    event.preventDefault(); // Prevent default form submission

    if (editvalidateForm()) {
        // Show a confirmation dialog
        let confirmation = confirm('Are you sure to update fees?');

        // Check user's choice
        if (confirmation) {
            // User clicked "OK," call the function to submit the form data
            editsubmitForm();
        } else {
            // User clicked "Cancel," do nothing or handle accordingly
            console.log('User cancelled the operation.');
        }
    }
});



    </script>
  
  
  
@endsection
