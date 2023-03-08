@extends('Backend.layouts.app')
@section('title', 'Template')

@push('styles')

@endpush

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Template</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('getAllTemplates')}}">Home</a></li>
                        <li class="breadcrumb-item active">Template</li>
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
                            <h3 class="card-title">Templates</h3>
                            <a href="{{route('createTemplates')}}" class="float-right">
                                <button type="button" class="btn btn-block btn-outline-secondary">Add Template</button>
                            </a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="template" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Insertion Type</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($templates as $template)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$template->name}}</td>
                                        <td>{{$template->insertion_type}}</td>
                                        <td>{{date('d-m-Y', strtotime($template->created_at))}}</td>
                                        <td>
                                            <a href="/templates/edit/{{$template->id}}" style="margin-right: 10px">
                                                    <i class="fa fa-edit"></i>
                                            </a>
{{--                                            <a href="/templates/delete/{{$template->id}}">--}}
{{--                                                    <i class="fa fa-trash"></i>--}}
{{--                                            </a>--}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Insertion Type</th>
                                    <th>Created At</th>
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
