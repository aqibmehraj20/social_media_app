@extends('layouts.app')

@section('content')

<div class="container mt-4 mb-4 p-3 d-flex justify-content-center row ">
    <div class="card p-4 col-6">
        <div class=" image d-flex flex-column justify-content-center align-items-center">
             <button class="btn btn-secondary">
                 <img src="{{ asset('storage/profile_pictures/'.$user->profile_picture) }}" height="100" width="100" />
            </button>
            <span class="idd"><b>{{ $user->name }}</b></span>
            <span class="idd">{{ $user->email }}</span>
            <div class="d-flex flex-row justify-content-center align-items-center gap-2">
        </div>
        <div class="d-flex flex-row justify-content-center align-items-center mt-3">
             </div>
            <div class=" d-flex mt-2"> <button class="btn1 btn-dark" onclick="window.location.href='';">Edit Profile</button> </div>
             <div class="text mt-3">
                <b>Bio: </b> <span>{{ $user->bio }}<br><br>
                <b>Interests:</b> {{$user->interests}}<br><br>
                <b>Contact No. :</b> {{$user->contact_number}}

            </span>
             </div>
            </div>
        </div>



    </div>

</div>
@endsection
