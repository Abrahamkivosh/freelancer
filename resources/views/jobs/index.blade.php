@extends('layouts.dashboard')

@section('content')
      <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('My Jobs') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        <table class="table" id="jobs">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Budget</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($jobs as $job)
                                <tr>
                                    <td scope="row">{{ $job -> iteration }}</td>
                                    <td>{{ $job -> title }}</td>
                                    <td>{{ $job -> description }}</td>
                                    <td>{{ $job -> status }}</td>
                                    <td>{{ $job -> budget }}</td>
                                    <td>
                                        <a href="{{ route('job.show', $job) }}" class="btn btn-sm btn-outline-warning">view</a>
                                        @if(Auth::user() -> role_id == 3)
                                            <a href="{{ route('job.edit', $job) }}" class="btn btn-sm btn-outline-success">edit</a>

                                            <form method="post" action="{{ route('job.destroy', $job) }}">
                                                @method('delete')
                                                @csrf
                                                <button type="submit"  class="btn btn-sm btn-outline-danger">Delete</button>
                                            </form>
                                        @endif
                                        @if( Auth::user() -> role_id == 2)
                                            @if (Auth::user() -> proposals -> has( $job ->id))
                                                No Action Needed
                                            @else
                                                @if($job -> status == 'closed')
                                                    No Action Needed
                                                @else
                                                    <a href="{{ route('job.apply', $job) }}" class="btn btn-sm btn-outline-info">Apply</a>

                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
@endsection
