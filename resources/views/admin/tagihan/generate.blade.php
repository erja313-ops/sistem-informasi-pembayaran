<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Generate Tagihan - Al Asror
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        body {
            background: #f5f7fb;
        }

        .sidebar-wrapper {
            min-height: 100vh;
            position: sticky;
            top: 0;
        }

        .main-content {
            min-height: 100vh;
        }

        .info-card {
            border-left: 5px solid #0d6efd;
        }

        @media (max-width: 767px) {

            .sidebar-wrapper {
                position: relative;
                min-height: auto;
            }

        }

    </style>

</head>

<body>

<div class="container-fluid">

    <div class="row">

        {{-- SIDEBAR --}}

        <div class="col-md-auto p-0 sidebar-wrapper">

            @include('admin.partials.sidebar')

        </div>


        {{-- CONTENT --}}

        <main class="col p-4 main-content">

            <div class="container-fluid">


                {{-- HEADER --}}

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-body">

                        <h1 class="fw-bold mb-1">
                            Generate Tagihan Bulanan
                        </h1>

                        <p class="text-muted mb-0">

                            Membuat atau memeriksa tagihan
                            untuk seluruh santri aktif.

                        </p>

                    </div>

                </div>


                @if (session('success'))

                    <div class="alert alert-success shadow-sm">

                        {{ session('success') }}

                    </div>

                @endif


                @if ($errors->any())

                    <div class="alert alert-danger shadow-sm">

                        <ul class="mb-0">

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                {{-- INFORMASI --}}

                <div class="card info-card border-0 shadow-sm mb-4">

                    <div class="card-body">

                        <h4 class="fw-bold">
                            Informasi
                        </h4>

                        <p class="mb-0">

                            Sistem akan memproses seluruh santri
                            dengan status <strong>aktif</strong>.
                            Jika tagihan pada periode tersebut
                            sudah ada, sistem tidak membuat
                            tagihan kedua.

                        </p>

                    </div>

                </div>


                {{-- FORM --}}

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <h4 class="fw-bold mb-4">
                            Pilih Periode
                        </h4>

                        <form
                            method="POST"
                            action="{{ route(
                                'admin.tagihan.generate.store'
                            ) }}"
                        >

                            @csrf


                            <div class="row g-3">


                                <div class="col-md-6">

                                    <label
                                        for="bulan"
                                        class="form-label"
                                    >
                                        Bulan
                                    </label>

                                    <select
                                        name="bulan"
                                        id="bulan"
                                        class="form-select"
                                        required
                                    >

                                        <option value="">
                                            -- Pilih Bulan --
                                        </option>

                                        @foreach ([
                                            1 => 'Januari',
                                            2 => 'Februari',
                                            3 => 'Maret',
                                            4 => 'April',
                                            5 => 'Mei',
                                            6 => 'Juni',
                                            7 => 'Juli',
                                            8 => 'Agustus',
                                            9 => 'September',
                                            10 => 'Oktober',
                                            11 => 'November',
                                            12 => 'Desember'
                                        ] as $nomor => $nama)

                                            <option
                                                value="{{ $nomor }}"
                                                {{ old('bulan', now()->month) == $nomor ? 'selected' : '' }}
                                            >
                                                {{ $nama }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <div class="col-md-6">

                                    <label
                                        for="tahun"
                                        class="form-label"
                                    >
                                        Tahun
                                    </label>

                                    <input
                                        type="number"
                                        name="tahun"
                                        id="tahun"
                                        class="form-control"
                                        value="{{ old(
                                            'tahun',
                                            now()->year
                                        ) }}"
                                        min="2020"
                                        max="2100"
                                        required
                                    >

                                </div>

                            </div>


                            <div class="mt-4">

                                <button
                                    type="submit"
                                    class="btn btn-success btn-lg"
                                >
                                    ⚙️ Generate / Periksa Tagihan
                                </button>

                                <a
                                    href="{{ route(
                                        'admin.tagihan.index'
                                    ) }}"
                                    class="btn btn-secondary btn-lg"
                                >
                                    Kembali

                                </a>

                            </div>

                        </form>

                    </div>

                </div>


                <div class="text-muted small mt-4">

                    Sistem Informasi Manajemen Keuangan
                    Pondok Pesantren Al Asror

                </div>

            </div>

        </main>

    </div>

</div>

</body>

</html>