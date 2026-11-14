<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Wali - Admin</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body>

<div class="d-flex">

    @include('admin.partials.sidebar')

    <div class="flex-grow-1 p-4">

        <h3 class="fw-bold mb-4">
            Edit Wali Santri
        </h3>

        @if($errors->any())

            <div class="alert alert-danger">

                <ul class="mb-0">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif

        <form
            action="{{ route('admin.wali.update', $wali->id) }}"
            method="POST"
        >

            @csrf
            @method('PUT')

            <div class="card shadow-sm mb-4">

                <div class="card-body">

                    <h5 class="fw-bold mb-3">
                        Data Wali
                    </h5>

                    <div class="mb-3">

                        <label class="form-label">
                            Nama Wali
                        </label>

                        <input
                            type="text"
                            name="nama"
                            class="form-control"
                            value="{{ old('nama', $wali->nama) }}"
                            required
                        >

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            No. HP
                        </label>

                        <input
                            type="text"
                            name="no_hp"
                            class="form-control"
                            value="{{ old('no_hp', $wali->no_hp) }}"
                        >

                    </div>

                    <div>

                        <label class="form-label">
                            Alamat
                        </label>

                        <textarea
                            name="alamat"
                            class="form-control"
                            rows="3"
                        >{{ old('alamat', $wali->alamat) }}</textarea>

                    </div>

                </div>

            </div>

            <div class="card shadow-sm mb-4">

                <div class="card-body">

                    <h5 class="fw-bold mb-3">
                        Akun Login
                    </h5>

                    <div class="mb-3">

                        <label class="form-label">
                            Username
                        </label>

                        <input
                            type="text"
                            name="username"
                            class="form-control"
                            value="{{ old('username', $wali->user->username ?? '') }}"
                            required
                        >

                    </div>

                    <div>

                        <label class="form-label">
                            Password Baru
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                        >

                        <small class="text-muted">
                            Kosongkan jika password tidak ingin diubah.
                        </small>

                    </div>

                </div>

            </div>

            <div class="card shadow-sm mb-4">

                <div class="card-body">

                    <h5 class="fw-bold mb-3">
                        Santri Tanggungan
                    </h5>

                    @foreach($santri as $item)

                        <div class="form-check mb-2">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="santri_id[]"
                                value="{{ $item->id }}"
                                id="santri{{ $item->id }}"
                                {{ $item->wali_id == $wali->id ? 'checked' : '' }}
                            >

                            <label
                                class="form-check-label"
                                for="santri{{ $item->id }}"
                            >
                                <strong>
                                    {{ $item->nama }}
                                </strong>
                                — NIS {{ $item->nis }}
                                — Kelas {{ $item->kelas }}
                            </label>

                        </div>

                    @endforeach

                </div>

            </div>

            <div class="d-flex gap-2">

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Simpan Perubahan
                </button>

                <a
                    href="{{ route('admin.wali.index') }}"
                    class="btn btn-secondary"
                >
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html>