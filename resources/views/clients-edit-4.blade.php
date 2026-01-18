@extends('layouts.main')

@section('page')

            <!-- form section -->
            <div class="form-col">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 row align-items-center heading-wrapper">
                            <div class="col-md-6 col-12">
                                <h1>Edit Client</h1>
                            </div>
                            {{-- <div class="col-md-6 col-12">
                                <a href="#" class="btn d-block ms-md-auto ms-none edit-del-btn">Delete</a>
                            </div> --}}
                            <div class="col-md-12">
                                <div class="form-step">
                                    <ul class="form-stepper form-stepper-horizontal mx-auto">
                                        <!-- Step 1 -->
                                        <li class="form-stepper-completed text-center form-stepper-list" step="1">
                                            <a class="mx-2">
                                                <span class="form-stepper-circle">
                                                    <span>1</span>
                                                </span>
                                                <div class="label">Services</div>
                                            </a>
                                        </li>
                                        <!-- Step 2 -->
                                        <li class="form-stepper-completed text-center form-stepper-list" step="2">
                                            <a class="mx-2">
                                                <span class="form-stepper-circle text-muted">
                                                    <span>2</span>
                                                </span>
                                                <div class="label text-muted">Client Basic Details</div>
                                            </a>
                                        </li>
                                        <!-- Step 3 -->
                                        <li class="form-stepper-completed text-center form-stepper-list" step="3">
                                            <a class="mx-2">
                                                <span class="form-stepper-circle text-muted">
                                                    <span>3</span>
                                                </span>
                                                <div class="label text-muted">Payment</div>
                                            </a>
                                        </li>
                                        <!-- Step 4 -->
                                        <li class="form-stepper-active text-center form-stepper-list" step="3">
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
                            <div class="col-md-6 col-12">

                            </div>
                        </div>
                        <div class="col-md-6 m-auto">
                            @php
                            $clientinfo = session('clientinfo');
                             
                           @endphp
                            <form class="create-form">
                                <div class="row gx-0">
                                    <div class="form-card mb-4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Username</label>
                                                <div class="input-show">
                                                    <p class="user-show">{{$clientinfo['username']}}</p>
                                                    <span class="copy-btn user-copy">
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                                            viewBox="0 0 384 512">
                                                            <path
                                                                d="M280 64h40c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128C0 92.7 28.7 64 64 64h40 9.6C121 27.5 153.3 0 192 0s71 27.5 78.4 64H280zM64 112c-8.8 0-16 7.2-16 16V448c0 8.8 7.2 16 16 16H320c8.8 0 16-7.2 16-16V128c0-8.8-7.2-16-16-16H304v24c0 13.3-10.7 24-24 24H192 104c-13.3 0-24-10.7-24-24V112H64zm128-8a24 24 0 1 0 0-48 24 24 0 1 0 0 48z" />
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label>Password</label>
                                                <div class="input-show">
                                                    <p class="pass-show">{{$clientinfo['password']}}</p>
                                                    <span class="copy-btn pass-copy">
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                                            viewBox="0 0 384 512">
                                                            <path
                                                                d="M280 64h40c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128C0 92.7 28.7 64 64 64h40 9.6C121 27.5 153.3 0 192 0s71 27.5 78.4 64H280zM64 112c-8.8 0-16 7.2-16 16V448c0 8.8 7.2 16 16 16H320c8.8 0 16-7.2 16-16V128c0-8.8-7.2-16-16-16H304v24c0 13.3-10.7 24-24 24H192 104c-13.3 0-24-10.7-24-24V112H64zm128-8a24 24 0 1 0 0-48 24 24 0 1 0 0 48z" />
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </main>
    @endsection