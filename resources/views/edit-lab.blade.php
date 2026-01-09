@extends('layouts.admin-main')

@section('adminpage')
    <!-- form section -->
    <div class="form-col">
        <!-- ... (other HTML content) ... -->

        <div class="col-md-12 m-auto">
            <form id="service-form" class="create-form" method='post' action="{{url('/update-lab/' . $labs->id)}}">
                @csrf
                <div class="row gx-0">
                    <div id="service-forms">
                        <div class="form-card mb-4" >
                            <fieldset>
                                <legend>Lab Detail</legend>
                                <div id="batch-section">
                                    <div class="row batch-row">
                                    <div class="col-md-12">
                                        <label for="">Lab Name<sup>*</sup></label>
                                        <input name="lab_name" id="lab_name" type="text" required value="{{$labs->lab_name}}">
                                    </div>
                                    @foreach($batch as $batchData)
                                    <div class="col-md-6">
                                        <label for="start_batch">Batch Timing<sup>*</sup></label>
                                        <div class="row">
                                           
                                            <div class="col-md-6">
                                                <input hidden name="batch_id[]" required value="{{$batchData->id}}">
                                                <input type="text" class="start_batch" name="start_batch[]" required placeholder="Select Start Time" value="{{$batchData->batch}}">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="end_batch" name="end_batch[]" required placeholder="Select End Time" value="{{$batchData->batch}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for=""> Pending Seats<sup>*</sup></label></label>
                                        <input name="pending_seats[]" type="number" required value="{{$batchData->pending_seats}}">
                                       
                                    </div> 

                                    <div class="col-md-3">
                                        <label for=""> Total Seats<sup>*</sup><span class="remove-rows" data-batch-id="{{$batchData->id}}">✖</span></label></label>
                                        <input name="seats[]" type="number" required value="{{$batchData->total_seats}}">
                                       
                                    </div>
                                    
                                   
                                    @endforeach
                                    
                                </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <button type="button" onclick="addBatchRow()" class="btn btn-add">Add More Batch</button>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-btn-col">
                            <button type="submit" class="btn">Update</button>
                            <button onclick="goback()" type="button" class="btn btn-second">Back</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
<!-- Include jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Include Select2 JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>

$(document).on('click', '.remove-rows', function() {
        var batchId = $(this).data('batch-id');
        if (confirm('Are you sure you want to delete this batch?')) {
            $.ajax({
                url: '{{ url("/delete-batch") }}'+ '/' + batchId,
                type: 'get',
                success: function(response) {
                    if (response.success) {
                        $(this).closest('.batch-rows').remove();
                        location.reload();
                    } else {
                        alert('Failed to delete batch. Please try again.');
                    }
                },
                error: function() {
                    alert('Failed to delete batch. Please try again.');
                }
            });
        }
    });
    
    function deleteBatchRow(button) {
        var batchRow = button.closest('.batch-row');
        if (batchRow) {
            // Show confirmation alert
            if (confirm('Are you sure you want to delete this batch?')) {
                batchRow.remove();
            }
        } else {
            console.error('Parent row not found.');
        }
    }
     // Function to split batch timing string and set start and end time
     function setBatchTiming(batchString, startInput, endInput) {
        var timings = batchString.split(' to ');
        if (timings.length === 2) {
            startInput.value = timings[0].trim();
            endInput.value = timings[1].trim();
        } else {
            console.error('Invalid batch timing format');
        }
    }

    // Call the function for each batch row
    document.addEventListener('DOMContentLoaded', function() {
        var startInputs = document.querySelectorAll('.start_batch');
        var endInputs = document.querySelectorAll('.end_batch');
        var batchStrings = {!! json_encode($batch->pluck('batch')) !!}; // Assuming $batch is a collection

        for (var i = 0; i < startInputs.length; i++) {
            setBatchTiming(batchStrings[i], startInputs[i], endInputs[i]);
        }
    });


    // Initialize batch time pickers for the newly added form sections
    flatpickr('.start_batch', {
        enableTime: true,
        noCalendar: true,
        dateFormat: 'h:i K', // Format to display hours, minutes, and AM/PM
        time_24hr: false, // Use 12-hour format
    });

    flatpickr('.end_batch', {
        enableTime: true,
        noCalendar: true,
        dateFormat: 'h:i K', // Format to display hours, minutes, and AM/PM
        time_24hr: false, // Use 12-hour format
    });

    // Function to add a new batch row
    function addBatchRow() {
        var batchSection = document.getElementById('batch-section');
        var batchRow = document.createElement('div');
        batchRow.className = 'row batch-row';
        batchRow.innerHTML = `
           
            <div class="col-md-6">
                <label for="start_batch">Batch Timing<sup>*</sup></label>
                <div class="row">
                    <div class="col-md-6">
                        
                        <input type="text" class="start_batch" name="start_batch[]" required placeholder="Select Start Time">
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="end_batch" name="end_batch[]" required placeholder="Select End Time">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <label for="">Seats<sup>*</sup>
                <span class="remove-row" onclick="removeBatchRow(this)">✖</span></label>
                <input name="seats[]" type="number" required>
                
            </div>
            
        `;
        batchSection.appendChild(batchRow);

        // Reinitialize flatpickr for new batch time pickers
        flatpickr('.start_batch', {
            enableTime: true,
            noCalendar: true,
            dateFormat: 'h:i K', // Format to display hours, minutes, and AM/PM
            time_24hr: false, // Use 12-hour format
        });

        flatpickr('.end_batch', {
            enableTime: true,
            noCalendar: true,
            dateFormat: 'h:i K', // Format to display hours, minutes, and AM/PM
            time_24hr: false, // Use 12-hour format
        });
    }

    // Function to remove a batch row
    function removeBatchRow(button) {
        var batchRow = button.closest('.batch-row');
        if (batchRow) {
            batchRow.remove();
        } else {
            console.error('Parent row not found.');
        }
    }
</script>


@endsection
