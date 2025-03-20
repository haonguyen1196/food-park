<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ProfilePasswordUpdateRequest;
use App\Http\Requests\Frontend\ProfileUpdateRequest;
use App\Traits\FileUploadTrait;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use FileUploadTrait;
    function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        toastr('Profile updated successfully', 'success');

        return redirect()->back();
    }

    function updatePassword(ProfilePasswordUpdateRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

        toastr('Password updated successfully!', 'success');
        return redirect()->back();
    }

    function updateAvatar(Request $request)
    {
        try {

            // Xác thực tệp tải lên
            $request->validate([
                'avatar' => 'image|max:2048', // 2048 KB = 2 MB
            ]);

            $imagePath = $this->uploadImage($request, 'avatar');
            $user = Auth::user();
            $user->avatar = $imagePath;
            $user->save();

            return response()->json(['status' => 'success', 'message' => 'Avatar updated successfully!']);
        } catch(\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'message' => $e->errors()]);
        }
    }
}