<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Detail Tagihan - Pondok Pesantren Al Asror
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

        .info-box {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 18px;
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

        <div class="col-md-auto p-0 sidebar-wrapper">

            @include('admin.partials.sidebar')

        </div>


        <main class="col p-4 main-content">

            <div class="container-fluid">


                {{-- HEADER --}}

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                            <div>

                                <h1 class="fw-bold mb-1">
                                    Detail Tagihan
                                </h1>

                                <p class="text-muted mb-0">
                                    Pemeriksaan rincian tagihan santri.
                                </p>

                            </div>

                            <a
                                href="{{ route('admin.tagihan.index') }}"
                                class="btn btn-outline-secondary"
                            >
                                ← Kembali
                            </a>

                        </div>

                    </div>

                </div>


                {{-- INFORMASI SANTRI --}}

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-body">

                        <h4 class="fw-bold mb-3">
                            Informasi Santri
                        </h4>

                        <div class="row g-3">

                            <div class="col-md-4">

                                <div class="info-box">

                                    <div class="text-muted small">
                                        NIS
                                    </div>

                                    <div class="fw-bold fs-5">
                                        {{ $tagihan->santri->nis ?? '-' }}
                                    </div>

                                </div>

                            </div>


                            <div class="col-md-4">

                                <div class="info-box">

                                    <div class="text-muted small">
                                        Nama
                                    </div>

                                    <div class="fw-bold fs-5">
                                        {{ $tagihan->santri->nama ?? '-' }}
                                    </div>

                                </div>

                            </div>


                            <div class="col-md-4">

                                <div class="info-box">

                                    <div class="text-muted small">
                                        Kelas
                                    </div>

                                    <div class="fw-bold fs-5">
                                        {{ $tagihan->santri->kelas ?? '-' }}
                                    </div>

                                </div>

                            </div>


                            <div class="col-md-4">

                                <div class="info-box">

                                    <div class="text-muted small">
                                        Periode
                                    </div>

                                    <div class="fw-bold fs-5">

                                        {{ sprintf(
                                            '%02d',
                                            $tagihan->periode_bulan
                                        ) }}
                                        -
                                        {{ $tagihan->periode_tahun }}

                                    </div>

                                </div>

                            </div>


                            <div class="col-md-4">

                                <div class="info-box">

                                    <div class="text-muted small">
                                        Status Tagihan
                                    </div>

                                    <div class="mt-1">

                                        @if ($tagihan->status === 'lunas')

                                            <span class="badge bg-success">
                                                Lunas
                                            </span>

                                        @elseif ($tagihan->status === 'sebagian')

                                            <span class="badge bg-warning text-dark">
                                                Sebagian
                                            </span>

                                        @else

                                            <span class="badge bg-danger">
                                                Belum Bayar
                                            </span>

                                        @endif

                                    </div>

                                </div>

                            </div>


                            <div class="col-md-4">

                                <div class="info-box">

                                    <div class="text-muted small">
                                        Sisa
                                    </div>

                                    <div class="fw-bold fs-5">

                                        Rp {{ number_format(
                                            $tagihan->hitungSisa(),
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- RINCIAN --}}

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-body">

                        <h4 class="fw-bold mb-3">
                            Rincian Tagihan
                        </h4>

                        <div class="table-responsive">

                            <table class="table table-hover align-middle">

                                <thead class="table-light">

                                    <tr>

                                        <th>
                                            No
                                        </th>

                                        <th>
                                            Jenis Tagihan
                                        </th>

                                        <th class="text-end">
                                            Nominal
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

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach (
                                        $tagihan->detailTagihan
                                        as $index => $detail
                                    )

                                        <tr>

                                            <td>
                                                {{ $index + 1 }}
                                            </td>

                                            <td class="fw-semibold">

                                                {{
                                                    $detail
                                                        ->jenisTagihan
                                                        ->nama
                                                    ?? '-'
                                                }}

                                            </td>

                                            <td class="text-end">

                                                Rp {{ number_format(
                                                    $detail->nominal,
                                                    0,
                                                    ',',
                                                    '.'
                                                ) }}

                                            </td>

                                            <td class="text-end">

                                                Rp {{ number_format(
                                                    $detail->hitungTotalDibayar(),
                                                    0,
                                                    ',',
                                                    '.'
                                                ) }}

                                            </td>

                                            <td class="text-end">

                                                Rp {{ number_format(
                                                    $detail->hitungSisa(),
                                                    0,
                                                    ',',
                                                    '.'
                                                ) }}

                                            </td>

                                            <td>

                                                @if ($detail->status === 'lunas')

                                                    <span class="badge bg-success">
                                                        Lunas
                                                    </span>

                                                @elseif ($detail->status === 'sebagian')

                                                    <span class="badge bg-warning text-dark">
                                                        Sebagian
                                                    </span>

                                                @else

                                                    <span class="badge bg-danger">
                                                        Belum Bayar
                                                    </span>

                                                @endif

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                                <tfoot class="table-light">

                                    <tr>

                                        <th colspan="2" class="text-end">
                                            TOTAL
                                        </th>

                                        <th class="text-end">

                                            Rp {{ number_format(
                                                $tagihan->detailTagihan->sum('nominal'),
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                                        </th>

                                        <th class="text-end">

                                            Rp {{ number_format(
                                                $tagihan->hitungTotalDibayar(),
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                                        </th>

                                        <th class="text-end">

                                            Rp {{ number_format(
                                                $tagihan->hitungSisa(),
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                                        </th>

                                        <th>
                                            -
                                        </th>

                                    </tr>

                                </tfoot>

                            </table>

                        </div>

                    </div>

                </div>


                {{-- RIWAYAT PEMBAYARAN UNTUK TAGIHAN INI --}}

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-body">

                        <h4 class="fw-bold mb-3">
                            Pembayaran Terkait
                        </h4>

                        <div class="table-responsive">

                            <table class="table table-hover align-middle">

                                <thead class="table-light">

                                    <tr>

                                        <th>
                                            Kode Transaksi
                                        </th>

                                        <th>
                                            Metode
                                        </th>

                                        <th class="text-end">
                                            Nominal
                                        </th>

                                        <th>
                                            Status
                                        </th>

                                        <th>
                                            Tanggal
                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @php
                                        $semuaPembayaran = $tagihan
                                            ->detailTagihan
                                            ->flatMap(
                                                fn ($detail) =>
                                                    $detail
                                                        ->detailPembayaran
                                                        ->map(
                                                            fn ($dp) =>
                                                                $dp->pembayaran
                                                        )
                                                )
                                            ->filter()
                                            ->unique('id')
                                            ->sortByDesc('tanggal_bayar');
                                    @endphp


                                    @forelse (
                                        $semuaPembayaran
                                        as $pembayaran
                                    )

                                        <tr>

                                            <td>

                                                <strong>
                                                    {{
                                                        $pembayaran
                                                            ->kode_transaksi
                                                    }}
                                                </strong>

                                            </td>

                                            <td>
                                                {{ ucfirst(
                                                    $pembayaran->metode
                                                ) }}
                                            </td>

                                            <td class="text-end">

                                                Rp {{ number_format(
                                                    $pembayaran->total_transfer,
                                                    0,
                                                    ',',
                                                    '.'
                                                ) }}

                                            </td>

                                            <td>

                                                @if (
                                                    $pembayaran->status
                                                    === 'diterima'
                                                )

                                                    <span class="badge bg-success">
                                                        Diterima
                                                    </span>

                                                @elseif (
                                                    $pembayaran->status
                                                    === 'ditolak'
                                                )

                                                    <span class="badge bg-danger">
                                                        Ditolak
                                                    </span>

                                                @else

                                                    <span class="badge bg-warning text-dark">
                                                        Menunggu Verifikasi
                                                    </span>

                                                @endif

                                            </td>

                                            <td>

                                                {{
                                                    \Carbon\Carbon::parse(
                                                        $pembayaran->tanggal_bayar
                                                    )->format('d-m-Y H:i')
                                                }}

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td
                                                colspan="5"
                                                class="text-center text-muted py-4"
                                            >
                                                Belum ada pembayaran terkait.
                                            </td>

                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

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