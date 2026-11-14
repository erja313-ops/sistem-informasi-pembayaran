<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wali;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class WaliController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->search ?? '');

        $query = Wali::with([
            'user',
            'santri'
        ])->orderBy('nama');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('no_hp', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('username', 'like', '%' . $search . '%');
                  });
            });
        }

        $wali = $query->paginate(10)->withQueryString();

        return view('admin.wali.index', compact(
            'wali',
            'search'
        ));
    }

    public function create()
    {
        $santri = Santri::whereNull('wali_id')
            ->where('status', 'aktif')
            ->orderBy('nama')
            ->get();

        return view('admin.wali.create', compact('santri'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:30',
            'alamat' => 'nullable|string',
            'username' => 'required|string|max:100|unique:users,username',
            'password' => 'required|string|min:6',
            'santri_id' => 'nullable|array',
            'santri_id.*' => 'integer|exists:santri,id',
        ]);

        DB::transaction(function () use ($request) {

            $user = User::create([
                'name' => $request->nama,
                'username' => $request->username,
                'email' => null,
                'password' => $request->password,
                'role' => 'wali',
                'is_active' => true,
            ]);

            $wali = Wali::create([
                'user_id' => $user->id,
                'nama' => $request->nama,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);

            if ($request->filled('santri_id')) {
                Santri::whereIn('id', $request->santri_id)
                    ->update([
                        'wali_id' => $wali->id
                    ]);
            }
        });

        return redirect()
            ->route('admin.wali.index')
            ->with(
                'success',
                'Data wali dan akun login berhasil dibuat.'
            );
    }

    public function edit($id)
    {
        $wali = Wali::with([
            'user',
            'santri'
        ])->findOrFail($id);

        $santri = Santri::where('status', 'aktif')
            ->where(function ($query) use ($wali) {
                $query->whereNull('wali_id')
                    ->orWhere('wali_id', $wali->id);
            })
            ->orderBy('nama')
            ->get();

        return view(
            'admin.wali.edit',
            compact('wali', 'santri')
        );
    }

    public function update(Request $request, $id)
    {
        $wali = Wali::with('user')->findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:30',
            'alamat' => 'nullable|string',

            'username' => [
                'required',
                'string',
                'max:100',
                Rule::unique('users', 'username')
                    ->ignore($wali->user_id),
            ],

            'password' => 'nullable|string|min:6',

            'santri_id' => 'nullable|array',
            'santri_id.*' => 'integer|exists:santri,id',
        ]);

        DB::transaction(function () use ($request, $wali) {

            $wali->update([
                'nama' => $request->nama,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);

            $wali->user->update([
                'name' => $request->nama,
                'username' => $request->username,
            ]);

            if ($request->filled('password')) {
                $wali->user->update([
                    'password' => $request->password,
                ]);
            }

            Santri::where('wali_id', $wali->id)
                ->update([
                    'wali_id' => null
                ]);

            if ($request->filled('santri_id')) {
                Santri::whereIn('id', $request->santri_id)
                    ->update([
                        'wali_id' => $wali->id
                    ]);
            }
        });

        return redirect()
            ->route('admin.wali.index')
            ->with(
                'success',
                'Data wali berhasil diperbarui.'
            );
    }

    public function toggleStatus($id)
    {
        $wali = Wali::with('user')->findOrFail($id);

        $wali->user->update([
            'is_active' => ! $wali->user->is_active
        ]);

        return redirect()
            ->route('admin.wali.index')
            ->with(
                'success',
                'Status akun wali berhasil diperbarui.'
            );
    }
}