@extends('layouts.main')

@section('page')
    <!-- form section -->
    <div class="form-col">
        <!-- ... (other HTML content) ... -->

        <div class="col-md-12 m-auto">
            <form id="service-form" class="create-form" method='post' action="{{url('/save-service')}}">
                @csrf
                <div class="row gx-0">
                    <div id="service-forms">
                        <div class="form-card mb-4" >
                            <fieldset>
                                <legend>Service Details</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Service<sup>*</sup></label>
                                        <input name="service" id="service" type="text" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Charges (in RS)<sup>*</sup></label>
                                        <input name="charges" id="charges" type="number" required>
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

@endsection
