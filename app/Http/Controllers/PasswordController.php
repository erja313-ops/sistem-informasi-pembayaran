<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    public function edit()
    {
        return view('akun.password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'current_password.current_password' => 'Password lama tidak sesuai.',
            'password.required' => 'Password baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi password baru tidak sama.',
        ]);

        $user = $request->user();
        $user->password = $request->password;
        $user->save();

        return back()->with(
            'success',
            'Password berhasil diubah. Gunakan password baru saat login berikutnya.'
        );
    }

    public function adminReset(Request $request, User $user)
    {
        if ($user->role !== 'wali') {
            abort(404);
        }

        $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'password.required' => 'Password baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi password baru tidak sama.',
        ]);

        $user->password = $request->password;
        $user->save();

        return redirect()
            ->route('admin.wali.index')
            ->with(
                'success',
                'Password akun wali berhasil direset. Sampaikan password sementara kepada wali dan minta wali menggantinya setelah login.'
            );
    }
}