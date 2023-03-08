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
                        <li class="breadcrumb-item">Template</li>
                        <li class="breadcrumb-item active">Add</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Templates</h3>
                        </div>
                        <div class="card-body" id="app">
                            <add-template :field_types="{{ json_encode(getTemplateFieldsForVueJs()) }}"
                                          :config="{{ json_encode([
                                            'getAdminUserUrl' => url('/templates/')
                                        ]) }}"
                            ></add-template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    {{--Vue app js--}}
@endpush
