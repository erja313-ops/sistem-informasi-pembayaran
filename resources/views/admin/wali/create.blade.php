<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Wali - Admin</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body>

<div class="d-flex">

    @include('admin.partials.sidebar')

    <div class="flex-grow-1 p-4">

        <div class="mb-4">

            <h3 class="fw-bold">
                Tambah Wali Santri
            </h3>

            <p class="text-muted">
                Membuat data wali sekaligus akun login.
            </p>

        </div>

        @if($errors->any())

            <div class="alert alert-danger">

                <strong>
                    Terdapat kesalahan:
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif

        <form
            action="{{ route('admin.wali.store') }}"
            method="POST"
        >

            @csrf

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
                            value="{{ old('nama') }}"
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
                            value="{{ old('no_hp') }}"
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
                        >{{ old('alamat') }}</textarea>

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
                            value="{{ old('username') }}"
                            required
                        >

                        <small class="text-muted">
                            Digunakan wali untuk login ke sistem.
                        </small>

                    </div>

                    <div>

                        <label class="form-label">
                            Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            required
                        >

                    </div>

                </div>

            </div>

            <div class="card shadow-sm mb-4">

                <div class="card-body">

                    <h5 class="fw-bold mb-3">
                        Hubungkan Santri
                    </h5>

                    <p class="text-muted">
                        Pilih santri yang menjadi tanggungan wali ini.
                    </p>

                    @forelse($santri as $item)

                        <div class="form-check mb-2">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="santri_id[]"
                                value="{{ $item->id }}"
                                id="santri{{ $item->id }}"
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

                    @empty

                        <div class="alert alert-info mb-0">
                            Semua santri aktif saat ini sudah memiliki wali.
                        </div>

                    @endforelse

                </div>

            </div>

            <div class="d-flex gap-2">

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Simpan Wali
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