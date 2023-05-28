
@extends('layouts.app')

@section('content')


<div class="container">
        <div class="row">

            <div class="col-md-4 offset-md-4">
                <div class="card form-holder">
                    <div class="card-body">
<h1>Edit Profile</h1>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="bio">Bio</label>
        <textarea class="form-control" name="bio" id="bio" rows="3">{{ $user->bio }}</textarea>
    </div>

    <div class="form-group">
        <label for="interests">Interests</label>
        <input class="form-control" type="text" name="interests" id="interests" value="{{ $user->interests }}">
    </div>

    <div class="form-group">
        <label for="contact_number">Contact Number</label>
        <input class="form-control" type="text" name="contact_number" id="contact_number" value="{{ $user->contact_number }}">
    </div>

    <div class="form-group">
        <label for="profile_picture">Profile Picture</label>
        <input class="form-control" type="file" name="profile_picture" id="profile_picture" value="{{ $user->profile_picture }}">
    </div>

    <div class="form-group">
        <button class="form-control btn btn-primary" type="submit">Update Profile</button>
    </div>
</form>
@endsection
