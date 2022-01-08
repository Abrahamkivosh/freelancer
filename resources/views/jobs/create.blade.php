@extends('layouts.dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('message'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                        <form action="{{ route('job.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Job Title</label>
                                        <input type="text" name="title" value="{{ old('title') }}" class="form-control" placeholder="Job Title">
                                        @error('title')
                                        <span class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>File</label>
                                        <input type="file" class="form-control" name="file">
                                        @error('file')
                                        <span class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Delivery Date</label>
                                        <input type="date" name="delivery_date"  value="{{ old('delivery_date') }}" class="form-control">
                                        @error('delivery_date')
                                        <span class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Budget</label>
                                <input type="number" name="budget"  value="{{ old('budget') }}" class="form-control" placeholder="$">
                                @error('budget')
                                <span class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="description" placeholder="Job Description" rows="3"></textarea>
                                @error('description')
                                <span class="invalid-feedback text-danger" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Post Job</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
@endsection



