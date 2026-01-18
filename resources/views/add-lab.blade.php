@extends('layouts.admin-main')

@section('adminpage')
    <!-- form section -->
    <div class="form-col">
        <!-- ... (other HTML content) ... -->

        <div class="col-md-12 m-auto">
            <form id="service-form" class="create-form" method='post' action="{{url('/save-lab')}}">
                @csrf
                <div class="row gx-0">
                    <div id="service-forms">
                        <div class="form-card mb-4">
                            <fieldset>
                                <legend>Lab Detail</legend>
                                <div id="batch-section">
                                    <div class="row batch-row">
                                        <div class="col-md-12">
                                            <label for="">Lab Name<sup>*</sup></label>
                                            <input name="lab_name" id="lab_name" type="text" required>
                                            <input type="text" hidden name="client_id" value="{{ session('client_id') }}">
                                        </div>
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
                                            <label for="">Seats<sup>*</sup></label>
                                            <input name="seats[]" type="number" required>
                                        </div>
                                       
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
                            <button type="submit" class="btn">Add</button>
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
