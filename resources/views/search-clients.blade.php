
@extends('layouts.main')


@section('page')
            <!-- table section -->
            <form action="{{url('/delete/clients')}}" method="post" >
                @csrf
            <div class="table-col">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 row align-items-center heading-wrapper">
                            <div class="col-md-6 col-12">
                                <h1>Search Result For : {{$query}}</h1>
                            </div>
                         
                        </div>
                        @if($clients->count() > 0)
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
                                    
                                </div>
                               @php
                            
                               @endphp
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
                                                <th>Action</th>
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
                                                    <a class="edit-btn" href="{{url('/payment-edit/' . $client->id)}}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                                            viewBox="0 0 320 512">
                                                            <path
                                                                d="M0 64C0 46.3 14.3 32 32 32H96h16H288c17.7 0 32 14.3 32 32s-14.3 32-32 32H231.8c9.6 14.4 16.7 30.6 20.7 48H288c17.7 0 32 14.3 32 32s-14.3 32-32 32H252.4c-13.2 58.3-61.9 103.2-122.2 110.9L274.6 422c14.4 10.3 17.7 30.3 7.4 44.6s-30.3 17.7-44.6 7.4L13.4 314C2.1 306-2.7 291.5 1.5 278.2S18.1 256 32 256h80c32.8 0 61-19.7 73.3-48H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H185.3C173 115.7 144.8 96 112 96H96 32C14.3 96 0 81.7 0 64z" />
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="table-pagination">
                                    {{ $clients->appends(['search' => $query])->links('pagination::bootstrap-4') }}
                                   
                                </div>
                            </div>
                        </div>
                        @else
                        <h5>No Client found.</h5>
                    @endif
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


        
    </script>

    

    @endsection