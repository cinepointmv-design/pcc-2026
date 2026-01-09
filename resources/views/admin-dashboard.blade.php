@extends('layouts.admin-main')


@section('adminpage')

    

            <!-- chart section -->
            <div class="chart-col">
                <div class="container">
                    <div class="row">
                        <!-- welcome -->
                        <div class="col-md-12 m-auto">
                            <div class="card p-5">
                                <div class=" col-md-12 justify-content-between align-items-center">
                                    <h3 style="text-transform: capitalize;
                                    font-weight: 600;
                                    margin-bottom: 12px;">Hi, Welcome Back To <span >Client Dashboard</span>
                                    </h3>
                                    <p style="font-size: 15px;
                                    font-weight: 500;
                                    text-transform: capitalize;" class="mb-3">Explore the dashboard and manage students</p>
                                    <button
                                        class='btn mt-1' style="font-size: 14px;
                                        color: white;
                                        min-height: 45px;
                                        border-radius: 6px;
                                        font-weight: 500;
                                        padding: 0 35px;">Explore Now</button>
                                </div>


                            </div>
                        </div>
                        
                        <div class="col-md-12 m-auto">
                            <div class="revenue-grid">
                                <div class="card p-4">
                                    <span>Total Students</span>
                                    <h4>{{ $studentsCount }}</h4>
                                </div>
                                <div class="card p-4">
                                    <span>Total Enquiries</span>
                                    <h4>{{ $inquiriesCount }}</h4>
                                </div>
                                <div class="card p-4">
                                    <span>Total Courses</span>
                                    <h4>{{ $coursesCount }}</h4>
                                </div>
                                <div class="card p-4">
                                    <span>Total Labs</span>
                                    <h4>{{ $labsCount }}</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </main>
 @endsection
    