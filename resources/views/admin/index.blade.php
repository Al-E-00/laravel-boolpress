@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="container">
                    <h1>@{{helloMessage}}</h1>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>

                <div class="links-page mt-3 mb-3 d-flex justify-content-center">
                    <button type="button" class="btn btn-warning" onclick="window.location='{{ url("admin/posts") }}'">Posts</button>
                    <button type="button" class="btn btn-warning ml-3" onclick="window.location='{{ url("admin/users") }}'">Users</button>
                    <button type="button" class="btn btn-danger ml-3" onclick="window.location='{{ url("/logout") }}'">Logout</button>
                </div>
                <div class="links-page mt-3 mb-3 d-flex justify-content-center">
                    <button type="button" class="btn btn-success" onclick="window.location='{{ url("/") }}'">Public page</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
