@extends('layouts.dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Apply for ') .$job -> title }}</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                        <form action="{{ route('job.apply.post', $job) }}" method="POST" enctype="multipart/form-data">

                        @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Bid</label>
                                        <input type="number" name="bid" class="form-control" placeholder="$">
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <label>Proposal</label>
                                <textarea class="form-control" name="proposal_text" placeholder="Proposal Text" rows="3"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Send proposal</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
@endsection



