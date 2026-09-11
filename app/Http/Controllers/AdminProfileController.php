<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminProfileController extends Controller
{
    public function edit(): View
    {
        $profile = Profile::firstOrCreate(['user_id' => auth()->id()], [
            'title' => 'Full-Stack Developer',
            'bio' => '',
        ]);
        $profile->load('user');
        return view('admin.profile.edit', compact('profile'));
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $profile = Profile::firstOrCreate(['user_id' => auth()->id()]);
        $data = $request->validated();
        $profile->user->update(['name' => $data['name']]);
        unset($data['name'], $data['avatar']);

        if ($request->hasFile('avatar')) {
            if ($profile->avatar) {
                Storage::disk('public')->delete($profile->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('profile', 'public');
        }

        $profile->update($data);
        return back()->with('success', 'Profile updated successfully.');
    }
}
