@extends('master')
@section('content')
    <div class="container-fluid">
        <h1 class="mt-4">Users</h1>
        
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Users
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{!! $user->name !!}</td>
                            <td>{!! $user->email !!}</td>
                            <td>{!! $user->phone !!}</td>
                            <td> @if($user->role != 1) <a href="{!! url('user-delete/'.$user->id) !!}" class="btn btn-danger" onclick="return confirm('Are you sure want to delete?')"> <i>Delete</i> </a> @endif</td>

                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
