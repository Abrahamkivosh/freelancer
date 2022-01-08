@extends('layouts.dashboard')

@section('content')
     <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ $job -> title }}
                    @if( Auth::user() -> role_id == 2)
                        <a href="{{ route('job.apply', $job) }}" class="btn btn-sm btn-outline-info flaot-right">Apply</a>
                    @endif
                </div>

                <div class="card-body">
                    <!-- project title-->
                    <h3 class="mt-0">
                        {{ $job -> title }}
                    </h3>
                    <div class="badge badge-secondary mb-3">{{ $job -> status }}</div>

                    <h5>Project Overview:</h5>

                    <p class="text-muted mb-2">
                        {{ $job -> description }}
                    </p>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-4">
                                <h5>File</h5>
                                <a href="{{route('down', $job )}}" class="btn btn-outline-warning"><i class="fa fa-download"></i>Download File</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <h5>End Date</h5>
                                <p>{{ $job -> delivery_date ->toDateString() }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <h5>Budget</h5>
                                <p>$ {{ $job -> budget }}</p>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    @if(Auth::user() -> role_id == 3)
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Proposals</div>
                <div class="card-body">
                    <table class="table" id="jobs">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Bid</th>
                            <th>Status</th>
                            <th>Delivery Date</th>
                            <th>Action</th>
                            <th>View</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($job -> proposals as $proposal)
                            <tr>
                                <td>{{ $proposal -> user -> name }}</td>
                                <td>{{ $proposal -> bid }}</td>
                                <td>
                                    @if ($proposal -> accepted)
                                        Accepted
                                    @else
                                        No Accepted
                                    @endif
                                </td>
                                <td>{{ $proposal -> delivery_date }}</td>
                                <td>
                                    @if ($proposal -> accepted)
                                        NO Action Needed
                                    @else
                                        <a href="{{ route('jobProposal.accept', $proposal) }}" class="btn btn-sm btn-outline-warning">Accept</a>

                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('jobProposal.show', $proposal) }}" class="btn btn-sm btn-outline-warning">Show</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

@endsection
