<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function create()
    {
        return view('profile.createProfile');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'bio' => 'nullable|string|max:255',
            'interests' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image|max:2048', // Assuming profile picture will be uploaded as an image file
        ]);

        $user = Auth::user();

        $user->bio = $validatedData['bio'];
        $user->interests = $validatedData['interests'];
        $user->contact_number = $validatedData['contact_number'];
        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $path = $image->storeAs('public/profile_pictures', $filename);
            $user->profile_picture = $filename;
        }
        $user->save();
        return redirect('/profile/view');

    }

    public function edit()
    {
        $user = Auth::user();

        return view('profile.editProfile', compact('user'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'bio' => 'nullable|string|max:255',
            'interests' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image|max:2048',
        ]);
        $user = Auth::user();
        $user->bio = $validatedData['bio'];
        $user->interests = $validatedData['interests'];
        $user->contact_number = $validatedData['contact_number'];
        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $path = $image->storeAs('public/profile_pictures', $filename);
            $user->profile_picture = $filename;
        }
        $user->save();

        return redirect('/profile/view');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('profile.profile', compact('user'));
    }
}
