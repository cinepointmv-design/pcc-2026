@extends('layouts.admin-main')

@section('adminpage')

<div id="dayRangeForm" class="create-form">
    <div class="col-md-6 col-12">
        <h1>Upcoming Birthdays</h1>
    </div>

    @if(session('success'))
    <div class="alert alert-success mt-4 alert-dismissible fade show slide-from-right auto-dismiss" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger mt-4 alert-dismissible fade show slide-from-right auto-dismiss" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


    <div class="table-col" style="display: block;">
        <div class="">
            <div class="row">
                <div class="col-md-12 row align-items-center heading-wrapper">
                    <!-- Your table heading content -->
                </div>
                <div class="col-md-12 m-auto">
                    <div class="table-card">
                        <div class="table-container">
                            <table class="table table-hover data-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Father's Name </th>
                                        <th>Date Of Birth</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="clientTableBody">
                                    @foreach ($students as $student)
                                        <tr>
                                            <td>{{$student->name}}</td>
                                            <td>{{$student->phone}}</td>
                                            <td>{{$student->fathername ? $student->fathername : "N/A" }}</td>
                                            <td>{{$student->DOB}}</td>
                                            <td><a href="{{url('/send-birthday-message/' . $student->phone)}}">Send Message</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-pagination">
                            {{-- {{ $students->links('pagination::bootstrap-4') }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Function to fade out the alerts after 3 seconds (adjust as needed)
        $(".auto-dismiss").delay(5000).fadeOut("slow");
    });
</script>

@endsection
