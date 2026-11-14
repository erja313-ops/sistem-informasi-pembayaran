<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Tambah Santri</title>

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
                Tambah Santri
            </h3>

            <p class="text-muted mb-0">
                Tambahkan data santri baru ke dalam sistem.
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
            action="{{ route('admin.santri.store') }}"
            method="POST"
        >

            @csrf

            <div class="card shadow-sm mb-4">

                <div class="card-body">

                    <h5 class="fw-bold mb-3">
                        Data Santri
                    </h5>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                NIS
                            </label>

                            <input
                                type="text"
                                name="nis"
                                class="form-control"
                                value="{{ old('nis') }}"
                                required
                            >

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Nama Santri
                            </label>

                            <input
                                type="text"
                                name="nama"
                                class="form-control"
                                value="{{ old('nama') }}"
                                required
                            >

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Jenis Kelamin
                            </label>

                            <select
                                name="jenis_kelamin"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    -- Pilih Jenis Kelamin --
                                </option>

                                <option
                                    value="Laki-laki"
                                    {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}
                                >
                                    Laki-laki
                                </option>

                                <option
                                    value="Perempuan"
                                    {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}
                                >
                                    Perempuan
                                </option>

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Kelas
                            </label>

                            <input
                                type="text"
                                name="kelas"
                                class="form-control"
                                value="{{ old('kelas') }}"
                                placeholder="Contoh: 1A"
                                required
                            >

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Status
                            </label>

                            <select
                                name="status"
                                class="form-select"
                                required
                            >

                                <option
                                    value="aktif"
                                    {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}
                                >
                                    Aktif
                                </option>

                                <option
                                    value="nonaktif"
                                    {{ old('status') == 'nonaktif' ? 'selected' : '' }}
                                >
                                    Nonaktif
                                </option>

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Wali Santri
                            </label>

                            <select
                                name="wali_id"
                                class="form-select"
                            >

                                <option value="">
                                    -- Belum Memiliki Wali --
                                </option>

                                @foreach($wali as $item)

                                    <option
                                        value="{{ $item->id }}"
                                        {{ old('wali_id') == $item->id ? 'selected' : '' }}
                                    >
                                        {{ $item->nama }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="col-12 mb-3">

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

            </div>

            <div class="d-flex gap-2">

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Simpan Santri
                </button>

                <a
                    href="{{ route('admin.santri.index') }}"
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