@extends('layouts.dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div>
                @if (session('message'))
                <div class="alert alert-success" role="alert">
                    {{ session('message') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <strong>Hoops!</strong> {{session('error')}}
                </div>
            @endif

            </div>
            <div class="card">

                <div class="card-header">{{ __('Wallet Transactions') }}
                    <button type="button" class="btn btn-primary btn-sm float-right mr-2" data-toggle="modal" data-target="#modelId">
                        Deposit
                    </button>
                    <button type="button" class="btn btn-danger btn-sm float-right mr-2" data-toggle="modal" data-target="#withdraw">
                        Withdraw
                    </button>
                </div>

                <div class="card-body">
                    <table class="table table-sm table-centered mb-0">
                        <thead class="thead-dark">
                        <tr>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach (Auth::user() ->transactions ->reverse()  as $trans)
                                <tr>
                                    <td>{{ $trans -> type }}</td>
                                    <td>{{ $trans -> amount }}</td>
                                    <td>{{ $trans -> confirmed ? "Paid" : "Unpaid" }}</td>
                                    <td>{{ $trans -> created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>




    <!-- Modal -->
    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Deposit Via Mpesa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
{{--                <form action="{{ route('paypal') }}" method="post">--}}
                <form action="{{ route('wallet') }}" method="post">
                <div class="modal-body">

                        @csrf
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="text" class="form-control" name="amount" id="amount">
                        </div>
                        <div class="form-group">
                          <label for="phone">Phone number</label>
                          <input type="text" name="phone" id="phone" class="form-control" placeholder="0700000000" required minlength="10" maxlength="10" aria-describedby="helpId">
                          <small id="helpId" class="text-muted">Enter your mobile number</small>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Deposit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
   
    <div class="modal fade" id="withdraw" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Withdraw</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('wallet.withdraw') }}" method="post">
                <div class="modal-body">

                        @csrf
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="text" class="form-control" name="amount" id="amount">
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone number</label>
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="0700000000" required minlength="10" maxlength="10" aria-describedby="helpId">
                            <small id="helpId" class="text-muted">Enter your mobile number</small>
                          </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">withdraw</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection

