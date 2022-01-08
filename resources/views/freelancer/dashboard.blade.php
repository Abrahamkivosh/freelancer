@extends('layouts.dashboard')

@section('content')
    <x-wallet/>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in! as freelancer') }}
                </div>
            </div>
        </div>
    </div>
@endsection
