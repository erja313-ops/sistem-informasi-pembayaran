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
            height: 100%;
        }

        .info-label {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 18px;
            font-weight: 600;
        }

        .summary-box {
            border-left: 5px solid;
        }

        .summary-total {
            border-left-color: #0d6efd;
        }

        .summary-paid {
            border-left-color: #198754;
        }

        .summary-remaining {
            border-left-color: #dc3545;
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

            @include('wali.partials.sidebar')

        </div>


        {{-- CONTENT --}}

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
                                    Rincian tagihan santri
                                </p>

                            </div>

                            <a
                                href="{{ route('wali.dashboard') }}"
                                class="btn btn-outline-secondary"
                            >
                                ← Dashboard
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

                            <div class="col-md-6">

                                <div class="info-box">

                                    <div class="info-label">
                                        NIS
                                    </div>

                                    <div class="info-value">
                                        {{ $tagihan->santri->nis ?? '-' }}
                                    </div>

                                </div>

                            </div>


                            <div class="col-md-6">

                                <div class="info-box">

                                    <div class="info-label">
                                        Nama Santri
                                    </div>

                                    <div class="info-value">
                                        {{ $tagihan->santri->nama ?? '-' }}
                                    </div>

                                </div>

                            </div>


                            <div class="col-md-6">

                                <div class="info-box">

                                    <div class="info-label">
                                        Kelas
                                    </div>

                                    <div class="info-value">
                                        {{ $tagihan->santri->kelas ?? '-' }}
                                    </div>

                                </div>

                            </div>


                            <div class="col-md-6">

                                <div class="info-box">

                                    <div class="info-label">
                                        Periode
                                    </div>

                                    <div class="info-value">

                                        {{ sprintf(
                                            '%02d',
                                            $tagihan->periode_bulan
                                        ) }}
                                        -
                                        {{ $tagihan->periode_tahun }}

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- RINGKASAN --}}

                <div class="row g-3 mb-4">

                    <div class="col-md-4">

                        <div class="card border-0 shadow-sm summary-box summary-total h-100">

                            <div class="card-body">

                                <div class="text-muted">
                                    Total Tagihan
                                </div>

                                <div class="fs-3 fw-bold">

                                    Rp {{ number_format(
                                        $tagihan->detailTagihan->sum('nominal'),
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="col-md-4">

                        <div class="card border-0 shadow-sm summary-box summary-paid h-100">

                            <div class="card-body">

                                <div class="text-muted">
                                    Total Dibayar
                                </div>

                                <div class="fs-3 fw-bold">

                                    Rp {{ number_format(
                                        $tagihan->hitungTotalDibayar(),
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="col-md-4">

                        <div class="card border-0 shadow-sm summary-box summary-remaining h-100">

                            <div class="card-body">

                                <div class="text-muted">
                                    Sisa Tagihan
                                </div>

                                <div class="fs-3 fw-bold">

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


                {{-- RINCIAN --}}

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">

                            <div>

                                <h4 class="fw-bold mb-1">
                                    Rincian Tagihan
                                </h4>

                                <p class="text-muted mb-0">
                                    Detail komponen pembayaran.
                                </p>

                            </div>


                            @if ($tagihan->hitungSisa() > 0)

                                <a
                                    href="{{ route(
                                        'wali.pembayaran.create',
                                        $tagihan->id
                                    ) }}"
                                    class="btn btn-success"
                                >
                                    💳 Bayar Tagihan
                                </a>

                            @endif

                        </div>


                        <div class="table-responsive">

                            <table class="table table-hover align-middle">

                                <thead class="table-light">

                                    <tr>

                                        <th>No</th>

                                        <th>Jenis Tagihan</th>

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

                                    @forelse (
                                        $tagihan->detailTagihan
                                        as $index => $detail
                                    )

                                        <tr>

                                            <td>
                                                {{ $index + 1 }}
                                            </td>

                                            <td class="fw-semibold">

                                                {{
                                                    $detail->jenisTagihan->nama
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

                                    @empty

                                        <tr>

                                            <td
                                                colspan="6"
                                                class="text-center text-muted py-4"
                                            >
                                                Belum ada rincian tagihan.
                                            </td>

                                        </tr>

                                    @endforelse

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


                <div class="text-muted small">

                    Sistem Informasi Manajemen Keuangan
                    Pondok Pesantren Al Asror

                </div>

            </div>

        </main>

    </div>

</div>

</body>

</html>