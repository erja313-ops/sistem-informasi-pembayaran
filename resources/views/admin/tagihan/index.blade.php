<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Data Tagihan - Pondok Pesantren Al Asror
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
                            Data Tagihan
                        </h1>

                        <p class="text-muted mb-0">
                            Daftar tagihan seluruh santri.
                        </p>

                    </div>

                </div>


                {{-- FILTER --}}

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-body">

                        <h5 class="fw-bold mb-3">
                            Pencarian dan Filter
                        </h5>

                        <form
                            method="GET"
                            action="{{ route('admin.tagihan.index') }}"
                        >

                            <div class="row g-3">


                                <div class="col-md-4">

                                    <label
                                        for="search"
                                        class="form-label"
                                    >
                                        Nama / NIS Santri
                                    </label>

                                    <input
                                        type="text"
                                        name="search"
                                        id="search"
                                        class="form-control"
                                        value="{{ request('search') }}"
                                        placeholder="Contoh: Ahmad / 260001"
                                    >

                                </div>


                                <div class="col-md-2">

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
                                    >

                                        <option value="">
                                            Semua Bulan
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
                                        ] as $nomor => $namaBulan)

                                            <option
                                                value="{{ $nomor }}"
                                                {{ (string) request('bulan') === (string) $nomor ? 'selected' : '' }}
                                            >
                                                {{ $namaBulan }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <div class="col-md-2">

                                    <label
                                        for="tahun"
                                        class="form-label"
                                    >
                                        Tahun
                                    </label>

                                    <select
                                        name="tahun"
                                        id="tahun"
                                        class="form-select"
                                    >

                                        <option value="">
                                            Semua Tahun
                                        </option>

                                        @foreach ($tahun as $item)

                                            <option
                                                value="{{ $item }}"
                                                {{ (string) request('tahun') === (string) $item ? 'selected' : '' }}
                                            >
                                                {{ $item }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <div class="col-md-2">

                                    <label
                                        for="status"
                                        class="form-label"
                                    >
                                        Status
                                    </label>

                                    <select
                                        name="status"
                                        id="status"
                                        class="form-select"
                                    >

                                        <option value="">
                                            Semua Status
                                        </option>

                                        <option
                                            value="belum_bayar"
                                            {{ request('status') === 'belum_bayar' ? 'selected' : '' }}
                                        >
                                            Belum Bayar
                                        </option>

                                        <option
                                            value="sebagian"
                                            {{ request('status') === 'sebagian' ? 'selected' : '' }}
                                        >
                                            Sebagian
                                        </option>

                                        <option
                                            value="lunas"
                                            {{ request('status') === 'lunas' ? 'selected' : '' }}
                                        >
                                            Lunas
                                        </option>

                                    </select>

                                </div>


                                <div class="col-md-2 d-flex align-items-end gap-2">

                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                    >
                                        Filter
                                    </button>

                                    <a
                                        href="{{ route('admin.tagihan.index') }}"
                                        class="btn btn-secondary"
                                    >
                                        Reset
                                    </a>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>


                {{-- TABEL --}}

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <div>

                                <h5 class="fw-bold mb-1">
                                    Daftar Tagihan
                                </h5>

                                <p class="text-muted mb-0">
                                    Total:
                                    {{ $tagihan->total() }}
                                    tagihan
                                </p>

                            </div>

                        </div>


                        <div class="table-responsive">

                            <table class="table table-hover align-middle">

                                <thead class="table-light">

                                    <tr>

                                        <th>
                                            No
                                        </th>

                                        <th>
                                            Santri
                                        </th>

                                        <th>
                                            NIS
                                        </th>

                                        <th>
                                            Periode
                                        </th>

                                        <th class="text-end">
                                            Total
                                        </th>

                                        <th class="text-end">
                                            Dibayar
                                        </th>

                                        <th class="text-end">
                                            Sisa
                                        </th>

                                        <th>
                                            Status
                                        </th>

                                        <th>
                                            Aksi
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @forelse ($tagihan as $index => $item)

                                        <tr>

                                            <td>
                                                {{ $tagihan->firstItem() + $index }}
                                            </td>

                                            <td class="fw-semibold">
                                                {{ $item->santri->nama ?? '-' }}
                                            </td>

                                            <td>
                                                {{ $item->santri->nis ?? '-' }}
                                            </td>

                                            <td>

                                                {{ sprintf(
                                                    '%02d',
                                                    $item->periode_bulan
                                                ) }}
                                                -
                                                {{ $item->periode_tahun }}

                                            </td>

                                            <td class="text-end">

                                                Rp {{ number_format(
                                                    $item->detailTagihan->sum('nominal'),
                                                    0,
                                                    ',',
                                                    '.'
                                                ) }}

                                            </td>

                                            <td class="text-end">

                                                Rp {{ number_format(
                                                    $item->hitungTotalDibayar(),
                                                    0,
                                                    ',',
                                                    '.'
                                                ) }}

                                            </td>

                                            <td class="text-end">

                                                Rp {{ number_format(
                                                    $item->hitungSisa(),
                                                    0,
                                                    ',',
                                                    '.'
                                                ) }}

                                            </td>

                                            <td>

                                                @if ($item->status === 'lunas')

                                                    <span class="badge bg-success">
                                                        Lunas
                                                    </span>

                                                @elseif ($item->status === 'sebagian')

                                                    <span class="badge bg-warning text-dark">
                                                        Sebagian
                                                    </span>

                                                @else

                                                    <span class="badge bg-danger">
                                                        Belum Bayar
                                                    </span>

                                                @endif

                                            </td>

                                            <td>

                                                <a
                                                    href="{{ route(
                                                        'admin.tagihan.show',
                                                        $item->id
                                                    ) }}"
                                                    class="btn btn-primary btn-sm"
                                                >
                                                    Detail
                                                </a>

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td
                                                colspan="9"
                                                class="text-center text-muted py-4"
                                            >

                                                Data tagihan tidak ditemukan.

                                            </td>

                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>


                        <div class="mt-3">

                            {{ $tagihan->links() }}

                        </div>

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