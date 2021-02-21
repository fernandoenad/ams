@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Users Management</h3>
    <div class="row justify-content-center">
        <div class="col-md-9">
            @if (session('message'))
                <div class="alert alert-success">
                    <strong>Success!</strong> {{ session('message') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    User List
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <small>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="10%">ID</th>
                                    <th>Name</th>
                                    <th width="20%">Email</th>
                                    <th width="15%">Created at</th>
                                    <th width="15%">Updated at</th>
                                    <th width="12%" class="text-right"></th>
                                </tr>
                            </thead>
                            <tbody> 
                                @if(sizeof($users) > 0)
                                    <?php $i=1;?>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $user->name ?? '' }}</strong></td>
                                            <td>{{ $user->email ?? '' }}</td>
                                            <td>{{ date('M d, Y', strtotime($user->created_at)) ?? '' }}</td>
                                            <td>{{ date('M d, Y', strtotime($user->updated_at)) ?? '' }}</td>
                                            <td class="text-right">
                                                @if($user->id == 1) 
                                                @else
                                                    <a href="{{ route('users.update', $user->id) }}" class="btn btn-warning btn-sm"
                                                        onClick="return confirm('This action is resets password to password.\n Are you sure you wish to proceed?')">
                                                        <i class="fas fa-recycle" title="Reset password"></i></a>
                                                
                                                    <a href="{{ route('users.destroy', $user->id) }}" class="btn btn-danger btn-sm"
                                                        onclick="event.preventDefault();
                                                        if(confirm('This action deletes the user and is IRREVERSIBLE.\n Are you sure you wish to proceed?')){
                                                            document.getElementById('users-delete').submit();
                                                        } else {
                                                            return false;
                                                        }">
                                                        <i class="fas fa-trash-alt" title="Delete user"></i></a>
                                                    
                                                    <form id="users-delete" action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-none">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr><td colspan="6">No record found.</td></tr>
                                @endif
                            </tbody>
                        </table>
                        </small>
                    </div>
                </div>
                <div class="card-footer p-0">
                </div>
            </div>
        </div>
        <div class="col-md-3">
           @include('users._tools')
        </div>
    </div>
</div>
@endsection
