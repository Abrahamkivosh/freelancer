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
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Client</th>
                            <th>Accepted</th>
                            <th>Status</th>
                            <th>Budget</th>
                            <th>Your Bid</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach (Auth::user() ->proposals as $proposal)
                            <tr>
                                <td>{{ $proposal ->job -> title }}</td>
                                <td>{{ $proposal ->job ->user -> name }}</td>
                                <td>{{ $proposal  -> accepted }}</td>
                                <td>{{ $proposal  -> status }}</td>
                                <td>{{ $proposal ->job -> budget }}</td>
                                <td>{{ $proposal -> bid }}</td>
                                <td>
                                    @if($proposal -> status == 'delivered')
                                       <a href="{{ route('jobProposal.show', $proposal) }}" class="btn btn-dark">view</a>
                                    @else
                                        @if( $proposal -> accepted)
                                            <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                        data-target="#modelId">
                                                    Deliver
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="modelId" tabindex="-1" role="dialog"
                                                     aria-labelledby="modelTitleId" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Modal title</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form method="post" action="{{ route('jobProposal.update', $proposal) }}" enctype="multipart/form-data">
                                                                <div class="modal-body">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <div class="form-group">
                                                                        <label for="">Remarks</label>
                                                                        <textarea name="remarks" class="form-control"></textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="">File</label>
                                                                        <input type="file" class="form-control" name="file" id="file">
                                                                    </div>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                N/A
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
