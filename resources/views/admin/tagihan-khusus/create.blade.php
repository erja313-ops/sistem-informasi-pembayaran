<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Buat Tagihan Khusus</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

</head>

<body>

<div class="d-flex">

    @include('admin.partials.sidebar')

    <div class="flex-grow-1 p-4">

        <div class="mb-4">

            <h3 class="fw-bold">
                Buat Tagihan Khusus
            </h3>

            <p class="text-muted mb-0">
                Buat tagihan sekali bayar untuk seluruh atau sebagian santri.
            </p>

        </div>


        @if(session('success'))

            <div class="alert alert-success">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>

        @endif


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
            action="{{ route('admin.tagihan-khusus.store') }}"
            method="POST"
        >

            @csrf


            <!-- JENIS -->

            <div class="card shadow-sm mb-4">

                <div class="card-body">

                    <h5 class="fw-bold mb-3">
                        Informasi Tagihan
                    </h5>


                    <div class="mb-3">

                        <label class="form-label">
                            Jenis Tagihan
                        </label>

                        <select
                            name="jenis_tagihan_id"
                            class="form-select"
                            required
                        >

                            <option value="">
                                -- Pilih Jenis Tagihan --
                            </option>

                            @foreach($jenisTagihan as $jenis)

                                <option
                                    value="{{ $jenis->id }}"
                                    {{ old('jenis_tagihan_id') == $jenis->id ? 'selected' : '' }}
                                >
                                    {{ $jenis->nama }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Tanggal Kegiatan / Pembebanan
                        </label>

                        <input
                            type="date"
                            name="tanggal_kegiatan"
                            class="form-control"
                            value="{{ old('tanggal_kegiatan', now()->format('Y-m-d')) }}"
                            required
                        >

                        <small class="text-muted">
                            Tarif yang dipakai akan mengikuti tarif yang berlaku pada tanggal ini.
                        </small>

                    </div>


                    <div>

                        <label class="form-label">
                            Keterangan
                        </label>

                        <textarea
                            name="keterangan"
                            class="form-control"
                            rows="3"
                            placeholder="Contoh: Ziarah wali santri Oktober 2026"
                        >{{ old('keterangan') }}</textarea>

                    </div>

                </div>

            </div>


            <!-- TARGET -->

            <div class="card shadow-sm mb-4">

                <div class="card-body">

                    <h5 class="fw-bold mb-3">
                        Target Santri
                    </h5>


                    <div class="mb-4">

                        <div class="form-check mb-2">

                            <input
                                class="form-check-input"
                                type="radio"
                                name="target"
                                value="semua"
                                id="targetSemua"
                                {{ old('target', 'semua') === 'semua' ? 'checked' : '' }}
                            >

                            <label
                                class="form-check-label"
                                for="targetSemua"
                            >
                                <strong>
                                    Semua Santri Aktif
                                </strong>
                            </label>

                        </div>


                        <div class="form-check mb-2">

                            <input
                                class="form-check-input"
                                type="radio"
                                name="target"
                                value="kelas"
                                id="targetKelas"
                                {{ old('target') === 'kelas' ? 'checked' : '' }}
                            >

                            <label
                                class="form-check-label"
                                for="targetKelas"
                            >
                                <strong>
                                    Berdasarkan Kelas
                                </strong>
                            </label>

                        </div>


                        <div class="form-check">

                            <input
                                class="form-check-input"
                                type="radio"
                                name="target"
                                value="santri"
                                id="targetSantri"
                                {{ old('target') === 'santri' ? 'checked' : '' }}
                            >

                            <label
                                class="form-check-label"
                                for="targetSantri"
                            >
                                <strong>
                                    Santri Tertentu
                                </strong>
                            </label>

                        </div>

                    </div>


                    <!-- KELAS -->

                    <div
                        id="pilihanKelas"
                        class="mb-3"
                    >

                        <label class="form-label">
                            Pilih Kelas
                        </label>

                        <select
                            name="kelas"
                            class="form-select"
                        >

                            <option value="">
                                -- Pilih Kelas --
                            </option>

                            @foreach($kelas as $itemKelas)

                                <option
                                    value="{{ $itemKelas }}"
                                    {{ old('kelas') == $itemKelas ? 'selected' : '' }}
                                >
                                    Kelas {{ $itemKelas }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <!-- SANTRI -->

                    <div id="pilihanSantri">

                        <label class="form-label">
                            Pilih Santri
                        </label>

                        <select
                            name="santri_id[]"
                            class="form-select"
                            multiple
                            size="10"
                        >

                            @foreach($santri as $item)

                                <option
                                    value="{{ $item->id }}"
                                    {{ in_array(
                                        $item->id,
                                        old('santri_id', [])
                                    ) ? 'selected' : '' }}
                                >
                                    {{ $item->nama }}
                                    — NIS {{ $item->nis }}
                                    — Kelas {{ $item->kelas }}
                                </option>

                            @endforeach

                        </select>

                        <small class="text-muted">
                            Gunakan Ctrl + klik untuk memilih beberapa santri.
                        </small>

                    </div>

                </div>

            </div>


            <div class="d-flex gap-2">

                <button
                    type="submit"
                    class="btn btn-primary"
                >

                    <i class="bi bi-check2-circle"></i>
                    Buat Tagihan

                </button>


                <a
                    href="{{ route('admin.tagihan.index') }}"
                    class="btn btn-secondary"
                >

                    Kembali

                </a>

            </div>

        </form>

    </div>

</div>


<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const radios =
            document.querySelectorAll(
                'input[name="target"]'
            );

        const pilihanKelas =
            document.getElementById(
                'pilihanKelas'
            );

        const pilihanSantri =
            document.getElementById(
                'pilihanSantri'
            );


        function updateTarget() {

            const selected =
                document.querySelector(
                    'input[name="target"]:checked'
                );


            if (!selected) {
                return;
            }


            if (selected.value === 'kelas') {

                pilihanKelas.style.display =
                    'block';

                pilihanSantri.style.display =
                    'none';

            }

            else if (selected.value === 'santri') {

                pilihanKelas.style.display =
                    'none';

                pilihanSantri.style.display =
                    'block';

            }

            else {

                pilihanKelas.style.display =
                    'none';

                pilihanSantri.style.display =
                    'none';

            }

        }


        radios.forEach(
            function (radio) {

                radio.addEventListener(
                    'change',
                    updateTarget
                );

            }
        );


        updateTarget();

    }
);

</script>

</body>

</html>