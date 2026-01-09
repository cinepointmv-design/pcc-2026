
@extends('layouts.main')

@section('title', 'Clients - BCRM')

@section('page')
            <!-- table section -->
            <form action="{{url('/delete/clients')}}" method="post" >
                @csrf
            <div class="table-col">
              
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 row align-items-center heading-wrapper">
                            <div class="col-md-6 col-12">
                                <h1>Clients</h1>
                            </div>
                            <div class="col-md-6 col-12">
                                <a href="{{url('/create-client-1')}}" class="btn d-block ms-md-auto ms-none">New Client</a>
                            </div>
                        </div>
                        <div class="col-md-12 m-auto">
                            <div class="table-card">
                                <div class="table-header d-flex align-items-center">
                                    <div class="col-md-6">
                                        <div class="dropdown profile-dropdown delete-dropdown" id="delete-dropdown">
                                            <button class="delete-btn" data-bs-toggle="dropdown">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <button type="submit" class="dropdown-item" id="deleteBtn" onclick="return confirmDelete();">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd"
                                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        <span>
                                                            Delete Selected
                                                        </span>
                                                    </button>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end">
                                        <div class="search-col">
                                            <div class="serach-input">
                                                <span class="search-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                    </svg>
                                                </span>
                                                <input id="searchInput" type="search" name="search" placeholder="Search">
                                            </div>
                                        </div>
                                        <!-- <div class="dropdown profile-dropdown delete-dropdown check-item-dropdown">
                                            <button class="delete-btn" data-bs-toggle="dropdown">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2">
                                                    </path>
                                                </svg>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item">
                                                        <input type="checkbox" id="title-check">
                                                        <label for="title-check">Title</label>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item">
                                                        <input type="checkbox" id="site-check">
                                                        <label for="site-check">Site</label>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div> -->
                                    </div>
                                </div>
                                {{-- <div class="table-selection-col">
                                    <p>
                                        <span>10</span> records selected.
                                        <button class="select-all">Select all <span>86</span>.</button>
                                        <button type="button" class="deselect-all"> Deselect all.</button>
                                    </p>
                                </div> --}}
                                <div class="table-container">
                                    <table class="table table-hover data-table">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input type="checkbox" id="selectAll" > 
                                                </th>
                                                <th>Name</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Business Name</th>
                                                <th>Location</th>
                                                <th>Whatsapp Number</th>
                                                <th>Whatsapp Api</th>
                                                <th>SMS Api</th>
                                                <th colspan="4" >Action</th>
                                            </tr>
                                        </thead>
                                        <tbody  id="clientTableBody">
                                            @foreach ($clients as $client)
                                            <tr class="client-row">
                                                <td>
                                                    <input type="checkbox" name="selected_clients[]" class="select-checkbox" value="{{ $client->id }}">
                                                </td>
                                                    <td>{{ $client->name }} </td>
                                                    <td>{{ $client->username }} </td>
                                                    <td>{{ $client->email }} </td>
                                                    <td>{{ $client->phone }} </td>
                                                    <td>{{ $client->business_name }} </td>
                                                    <td>{{ $client->location }} </td>
                                                    <td>{{ $client->whatsapp_number }} </td>
                                                    <td>{{ $client->whatsapp_api }} </td>
                                                    <td>{{ $client->sms_api }}</td>
                                                  
                                                <td>
                                                    <a class="edit-btn" href="{{url('/clients-edit/' . $client->id )}}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path
                                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                            </path>
                                                        </svg>
                                                        Edit</a>
                                                </td>
                                                <td>
                                                    <a class="edit-btn" href="{{url('/client-service-edit/' . $client->id)}}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path
                                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                            </path>
                                                        </svg>Edit Client Service
                                                    </a>
                                                   
                                                </td>
                                                <td>
                                                    <a href="{{url('/delete-client/' . $client->id)}}" class="edit-btn" style="color: red" onclick="return confirmDelete();">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd"
                                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="table-pagination">
                                    {{ $clients->links('pagination::bootstrap-4') }}
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>

    <!-- Add jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>

    function confirmDelete() {
                return confirm('Are you sure to delete ?');
            }

$(document).ready(function() {
    $('#searchInput').on('input', function () {
        var searchText = $(this).val().toLowerCase();
        
        $.ajax({
            url: "{{ url('/search-clients') }}",
            method: 'post',
            data: {
                _token: '{{ csrf_token() }}',
                searchText: searchText
            },
            success: function (response) {
                    console.log(response);

            if (response && response.clients  && response.clients.length > 0) {
                let studentsHtml = ''; // Initialize an empty string to store HTML

                // Loop through the data array in the response and construct table rows
                response.clients.forEach(student => {
                
                    studentsHtml += `
                        <tr class="client-row">
                            <td>
                                <input type="checkbox" name="selected_clients[]" class="select-checkbox" value="${student.id}">
                            </td>
                            <td>${student.name}</td>
                            <td>${student.username}</td>
                            <td>${student.email}</td>
                            <td>${student.phone ? student.phone : 'N/A'}</td>
                            <td>${student.business_name ? student.business_name : 'N/A'}</td>
                            <td>${student.location ? student.location : 'N/A'}</td>
                            <td>${student.whatsapp_number ? student.whatsapp_number : 'N/A'}</td>
                            <td>${student.whatsapp_api ? student.whatsapp_api : 'N/A'}</td>
                            <td>${student.sms_api ? student.sms_api : 'N/A'}</td>`;
                        studentsHtml += ` 
                            <td>
                                <a class="edit-btn" href="{{ url('/clients-edit') }}/${student.id}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor" aria-hidden="true">
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                        </path>
                                    </svg>
                                    Edit</a>
                            </td>
                            <td>
                                <a class="edit-btn" href="{{ url('/client-service-edit') }}/${student.id}">
                                    Edit Client Service
                                </a>
                            </td>
                            <td>
                                <a href="{{url('/delete-client/')}}/${student.id}" class="edit-btn" style="color: red" onclick="return confirmDelete();">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    
                                </a>
                            </td>
                        </tr>
                    `;
                });

                // Update the table body with the constructed HTML
                $('#clientTableBody').html(studentsHtml);
                // Render pagination links using Laravel pagination links provided in the response
                $('.table-pagination').html("");

            } else {
                $('#clientTableBody').html('<tr><td colspan="2">No Client found</td></tr>');
                $('.table-pagination').html(''); // Clear pagination if no data found
            }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                // Handle the error here if necessary
            }
        });

    });
});

        
    </script>

    

    @endsection