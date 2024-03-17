<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ProfileRequest;
use Illuminate\Http\Request;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('dashboard.profile.edit',[
           'user' => Auth::user(),
            'countries' => Countries::getNames(),
            'locales' => Languages::getNames(),
        ]);
    }

    public function update(ProfileRequest $request)
    {
        Auth::user()->profile->fill($request->validated())->save();

        return redirect()->route('dashboard.profile.edit')
            ->with('success', 'Profile updated successfully!');
    }
}
