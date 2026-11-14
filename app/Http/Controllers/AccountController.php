<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Menampilkan profil akun pengguna yang sedang login.
     */
    public function index(Request $request)
    {
        $user = $request->user()->load('wali.santri');

        return view('akun.index', compact('user'));
    }
}