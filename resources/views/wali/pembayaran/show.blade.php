<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Detail Pembayaran - Pondok Pesantren Al Asror
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

            @include('wali.partials.sidebar')

        </div>


        <main class="col p-4 main-content">

            <div class="container-fluid">


                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                            <div>

                                <h1 class="fw-bold mb-1">
                                    Detail Pembayaran
                                </h1>

                                <p class="text-muted mb-0">
                                    Informasi transaksi pembayaran.
                                </p>

                            </div>

                            <a
                                href="{{ route(
                                    'wali.pembayaran.riwayat'
                                ) }}"
                                class="btn btn-outline-secondary"
                            >
                                ← Riwayat
                            </a>

                        </div>

                    </div>

                </div>


                @if(session('success'))

                    <div class="alert alert-success shadow-sm">

                        {{ session('success') }}

                    </div>

                @endif


                {{-- INFORMASI PEMBAYARAN --}}

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-body">

                        <h4 class="fw-bold mb-4">
                            Informasi Pembayaran
                        </h4>

                        <div class="row g-3">

                            <div class="col-md-6">

                                <div class="info-box">

                                    <div class="text-muted small">
                                        Kode Transaksi
                                    </div>

                                    <div class="fw-bold fs-5">
                                        {{ $pembayaran->kode_transaksi }}
                                    </div>

                                </div>

                            </div>


                            <div class="col-md-6">

                                <div class="info-box">

                                    <div class="text-muted small">
                                        Metode Pembayaran
                                    </div>

                                    <div class="fw-bold fs-5">
                                        {{ ucfirst($pembayaran->metode) }}
                                    </div>

                                </div>

                            </div>


                            <div class="col-md-6">

                                <div class="info-box">

                                    <div class="text-muted small">
                                        Tanggal Pembayaran
                                    </div>

                                    <div class="fw-bold fs-5">

                                        {{ \Carbon\Carbon::parse(
                                            $pembayaran->tanggal_bayar
                                        )->format('d-m-Y H:i') }}

                                    </div>

                                </div>

                            </div>


                            <div class="col-md-6">

                                <div class="info-box">

                                    <div class="text-muted small">
                                        Nominal
                                    </div>

                                    <div class="fw-bold fs-5">

                                        Rp {{ number_format(
                                            $pembayaran->total_transfer,
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    </div>

                                </div>

                            </div>

                        </div>


                        <div class="mt-4">

                            <div class="text-muted small mb-1">
                                Status
                            </div>

                            @if (
                                $pembayaran->status
                                === 'menunggu_verifikasi'
                            )

                                <span class="badge bg-warning text-dark fs-6">
                                    Menunggu Verifikasi
                                </span>

                            @elseif (
                                $pembayaran->status
                                === 'diterima'
                            )

                                <span class="badge bg-success fs-6">
                                    Diterima
                                </span>

                            @elseif (
                                $pembayaran->status
                                === 'ditolak'
                            )

                                <span class="badge bg-danger fs-6">
                                    Ditolak
                                </span>

                            @endif

                        </div>


                        @if (
                            $pembayaran->status === 'ditolak'
                        )

                            <div class="alert alert-danger mt-4 mb-0">

                                <strong>
                                    Alasan Penolakan:
                                </strong>

                                <div class="mt-1">

                                    {{
                                        $pembayaran->alasan_penolakan
                                        ?? '-'
                                    }}

                                </div>

                            </div>

                        @endif

                    </div>

                </div>


                {{-- DETAIL --}}

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-body">

                        <h4 class="fw-bold mb-3">
                            Rincian Pembayaran
                        </h4>

                        <div class="table-responsive">

                            <table class="table table-hover align-middle">

                                <thead class="table-light">

                                    <tr>

                                        <th>
                                            Jenis Tagihan
                                        </th>

                                        <th>
                                            Santri
                                        </th>

                                        <th class="text-end">
                                            Dibayar
                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach (
                                        $pembayaran->detailPembayaran
                                        as $detail
                                    )

                                        <tr>

                                            <td class="fw-semibold">

                                                {{
                                                    $detail->detailTagihan
                                                        ->jenisTagihan
                                                        ->nama
                                                    ?? '-'
                                                }}

                                            </td>

                                            <td>

                                                {{
                                                    $detail
                                                        ->detailTagihan
                                                        ->tagihan
                                                        ->santri
                                                        ->nama
                                                    ?? '-'
                                                }}

                                            </td>

                                            <td class="text-end">

                                                Rp {{ number_format(
                                                    $detail->nominal_dibayar,
                                                    0,
                                                    ',',
                                                    '.'
                                                ) }}

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>


                <a
                    href="{{ route('wali.dashboard') }}"
                    class="btn btn-secondary"
                >
                    ← Kembali ke Dashboard
                </a>


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