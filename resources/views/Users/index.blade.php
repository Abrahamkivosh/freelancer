@extends('layouts.dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('System Users') }}
                    <button type="button" class="btn btn-primary btn-sm float-right mr-2" data-toggle="modal"
                        data-target="#modeladduser">
                        Add User
                    </button>

                </div>

                <div class="card-body">
                    <table class="table table-sm table-centered mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Balance</th>
                                <th>Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                                <tr>
                                    <td>{{ ++$key}}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->balance }}</td>
                                    <td>
                                        @switch($user->role_id)
                                            @case(1)
                                                <span class="badge badge-primary h3 ">Adminitrator</span>
                                            @break
                                            @case(2)
                                                <span class="badge badge-info h3 ">Freelancer</span>
                                            @break
                                            @case(3)
                                                <span class="badge badge-secondary h3 ">Client</span>
                                            @break


                                            @default
                                                <span class="badge badge-danger h3 ">N/A</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <a class=" btn btn-primary" href="{{ route('users.show', $user->id) }}">View</a>
                                        <a class=" btn btn-warning" href="{{ route('users.show', $user->id) }}">Edit</a>
                                        <a class=" btn btn-danger" 
                                        onclick="event.preventDefault();
                                        document.getElementById('delete-user').submit();"
                                        href="#">Delete</a>

                                        <form id="delete-user" action="{{ route('users.destroy',$user->id) }}" method="POST" class="d-none">
                                            @method('DELETE')
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            {{ $users->links() }}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modeladduser" tabindex="-1" role="dialog" aria-labelledby="modeladduserLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modeladduserLabel">Add new user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <form action="{{ route('users.store') }}" method="post">
                        @csrf

                        <div class=" form-group ">
                            <input id="username" type="text" placeholder="User Name"
                                class="form-control @error('username') is-invalid @enderror" name="username"
                                value="{{ old('username') }}" required autocomplete="username" autofocus>

                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="form-group ">


                            <input id="email" type="email" placeholder="User Email"
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>



                        <div class="form-group ">

                            <select class="form-control custom" name="country" required>
                                <option value="">Please Select a Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->abbr }}">{{ $country->name }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group ">


                            <select class="form-control" name="role" required>
                                <option value="">Select Account type</option>
                                <option value="1">Administrator</option>
                                <option value="2">Freelancer</option>
                                <option value="3">Client</option>
                            </select>

                        </div>

                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>

            </div>
        </div>
    </div>




@endsection
