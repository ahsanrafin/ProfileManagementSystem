@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h1 class="display-2 float-left">Hey! Whats up <br><span class="text-danger font-weight-bold">{{ auth()->user()->name }}</span></h1>
                    <img style="width: 400px" class="float-right img-fluid mt-3 mb-3" src="{{ url('/uploads/'. auth()->user()->profile_image) }}" alt="{{ auth()->user()->name }}">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
