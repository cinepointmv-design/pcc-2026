@extends('layouts.admin-main')

@section('adminpage')
    <!-- form section -->
    <div class="form-col">
        <!-- ... (other HTML content) ... -->

        <div class="col-md-12 m-auto">
            <form id="service-form" class="create-form" method='post' action="{{url('/save-course')}}">
                @csrf
                <div class="row gx-0">
                    <div id="service-forms">
                        <div class="form-card mb-4" >
                            <fieldset>
                                <legend>Course Detail</legend>
                                <div class="row"> 
                                    <div class="col-md-12">
                                        <input type="text" hidden name="client_id" value=" @php
                                        if (session()->has('client_id')) {
                                          echo  $client_id = session('client_id');
                                       } 
                                       @endphp
                                        ">
                                        <label for="">Course Name<sup>*</sup></label>
                                        <input name="course_name" id="course" type="text" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Fees (in RS)<sup>*</sup></label>
                                        <input name="fees" id="fees" type="number" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Duration (in Months)<sup>*</sup></label>
                                        <input name="duration" id="duration" type="number" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Lab Name<sup>*</sup></label>
                                        <select name="lab_number" id="lab_number" required>
                                            <option value="0">Select An Option</option>
                                            @foreach ($labs as $lab)
                                                <option value="{{ $lab->id }}">{{ $lab->lab_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Total Seats<sup>*</sup></label>
                                        <input name="seats" id="seats" type="number" required>
                                    </div>
                                    
                                    
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-btn-col">
                            <button type="submit"  class="btn">Add</button>
                            <button onclick="goback()" type="button" class="btn btn-second">Back</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- Add jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        // Change event listener for the lab select dropdown
        $('#lab_number').change(function() {
            // Fetch the selected lab number
            var labNumber = $(this).val();

            // Perform an AJAX request to retrieve the corresponding lab details
            $.ajax({
                url: '{{ url("/get-lab-details") }}' + '/' + labNumber, // Replace this URL with your endpoint to get lab details
                method: 'GET',
                success: function(response) {
                    // Update the seats field with the retrieved value
                    $('#seats').val(response.total_seats);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>

@endsection
