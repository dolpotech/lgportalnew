@extends('Backend.layouts.app')
@section('title', 'User')

@push('styles')

@endpush

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('getAllUsers')}}">Home</a></li>
                        <li class="breadcrumb-item active">User</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Users</h3>
                        <a href="{{route('createUser')}}" class="float-right">
                            <button type="button" class="btn btn-block btn-outline-secondary">Add User</button>
                        </a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="user" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Role</th>
                                <th>Type</th>
                                <th>LG/Ministry</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$user->roles[0]->name}}</td>
                                    <td>{{$user->type}}</td>
                                    <td>
                                        @if(isset($user->local_government))
                                            {{$user->local_government->name}}
                                        @elseif(isset($user->ministry))
                                            {{$user->ministry->name}}
                                        @endif
                                    </td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->phone_no}}</td>
                                    <td>{{$user->address}}</td>
                                    <td>{{$user->status}}</td>
                                    <td>
                                        <a href="/users/edit/{{$user->id}}" style="margin-right: 10px">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="/users/delete/{{$user->id}}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Role</th>
                                <th>Type</th>
                                <th>LG/Ministry</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')

@endpush
