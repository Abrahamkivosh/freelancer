@extends('layouts.front')


@section('content')


    <!-- START HERO -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <div class="mt-md-4">
                        <div>
                            
                            <span class="text-white-50 ml-1">Welcome to </span>
                        </div>
                        <h2 class="text-white font-weight-normal mb-4 mt-3 hero-title">
                           Freelance Platform
                        </h2>

                        <p class="mb-4 font-16 text-white-50"></p>

                        <a href="{{ route('login') }}" class="btn btn-success">Preview <i
                                class="mdi mdi-arrow-right ml-1"></i></a>
                    </div>
                </div>
                <div class="col-md-5 offset-md-2">
                    <div class="text-md-right mt-3 mt-md-0">
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END HERO -->

    

@endsection
