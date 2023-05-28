@extends('layouts.app')

@section('content')

<div class="container">
        <div class="row">

            <div class="col-md-4 offset-md-4">
                <div class="card form-holder">
                    <div class="card-body">
                        <h1>Create Post</h1>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('posts.store') }}">
    @csrf

    <div class="form-group">
                <label for="description">Description</label>
        <textarea name="description" id="description" rows="3">{{ old('description') }}</textarea>
    </div>

    <div>
        <button class="form-control btn btn-primary" type="submit">Create Post</button>
    </div>
</form>

@endsection

