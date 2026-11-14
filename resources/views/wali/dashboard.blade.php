<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Dashboard Wali</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >


    <style>
        :root {
            --page-bg: #f5f7fb;
            --card-radius: 16px;
            --card-shadow: 0 4px 18px rgba(15, 23, 42, 0.07);
        }

        html,
        body {
            margin: 0;
            min-height: 100%;
        }

        body {
            background: var(--page-bg);
        }

        .dashboard-main {
            width: 100%;
            min-height: 100vh;
            padding: 28px;
        }

        .dashboard-container {
            width: min(100%, 1400px);
            margin: 0 auto;
        }

        .dashboard-header-card,
        .dashboard-section-card,
        .summary-card {
            border: 0;
            border-radius: var(--card-radius);
            box-shadow: var(--card-shadow);
        }

        .dashboard-header-card .card-body,
        .dashboard-section-card .card-body {
            padding: 24px 26px;
        }

        .dashboard-header-title {
            margin: 0 0 7px;
            color: #111827;
            font-size: clamp(1.4rem, 2.2vw, 2rem);
            line-height: 1.2;
        }

        .dashboard-header-subtitle {
            margin: 0;
            color: #6b7280;
            font-size: .95rem;
            line-height: 1.6;
        }

        .summary-card {
            height: 100%;
            overflow: hidden;
        }

        .summary-card .card-body {
            min-height: 124px;
            padding: 18px;
        }

        .summary-label {
            margin: 0 0 7px;
            color: #6b7280;
            font-size: .82rem;
            font-weight: 600;
            line-height: 1.35;
        }

        .summary-value {
            color: #111827;
            font-size: clamp(1.3rem, 2.1vw, 1.8rem);
            font-weight: 700;
            line-height: 1.15;
            overflow-wrap: anywhere;
        }

        .summary-icon {
            flex: 0 0 auto;
            font-size: clamp(1.9rem, 3vw, 2.4rem) !important;
        }

        .section-heading {
            margin: 0;
            font-size: clamp(1.05rem, 1.6vw, 1.3rem);
            line-height: 1.35;
        }

        .dashboard-table-wrap {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .dashboard-table-wrap table {
            min-width: 700px;
            margin-bottom: 0;
        }

        .dashboard-table-wrap th,
        .dashboard-table-wrap td {
            white-space: nowrap;
        }

        .student-item {
            height: 100%;
            padding: 16px;
            border: 1px solid rgba(15, 23, 42, .08);
            border-radius: 14px;
            background: #fff;
        }

        @media (max-width: 991.98px) {
            .dashboard-main {
                padding: 22px;
            }

            .dashboard-header-card .card-body,
            .dashboard-section-card .card-body {
                padding: 21px;
            }
        }

        @media (max-width: 767.98px) {
            .dashboard-main {
                padding: 16px;
            }

            .dashboard-header-card .card-body,
            .dashboard-section-card .card-body {
                padding: 18px;
            }

            .dashboard-header-title {
                font-size: 1.35rem;
            }

            .dashboard-header-subtitle {
                font-size: .88rem;
            }

            .summary-card .card-body {
                min-height: 105px;
                padding: 15px;
            }

            .summary-label {
                font-size: .76rem;
            }

            .summary-value {
                font-size: 1.28rem;
            }

            .summary-icon {
                font-size: 1.9rem !important;
            }
        }

        @media (max-width: 480px) {
            .dashboard-main {
                padding: 12px;
            }

            .dashboard-header-card .card-body,
            .dashboard-section-card .card-body {
                padding: 16px;
            }

            .summary-card .card-body {
                padding: 13px;
            }

            .summary-value {
                font-size: 1.18rem;
            }

            .student-item {
                padding: 14px;
            }

            .dashboard-table-wrap table {
                min-width: 660px;
            }
        }
    </style>

</head>

<body>

@include('wali.partials.sidebar')

<main class="dashboard-main">

    <div class="dashboard-container">

        <!-- HEADER -->

        <div class="card dashboard-header-card mb-4">

            <div class="card-body">

                <h1 class="dashboard-header-title fw-bold">
                    Dashboard Wali Santri
                </h1>

                <p class="dashboard-header-subtitle">
                    Selamat datang,
                    <strong>{{ $wali->nama }}</strong>.
                </p>

            </div>

        </div>


        <!-- SUMMARY -->

        <div class="row g-4 mb-4">


            <div class="col-6 col-md-3">

                <div class="card summary-card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <p class="summary-label">
                                    Jumlah Santri
                                </p>

                                <div class="summary-value fw-bold">
                                    {{ $santri->count() }}
                                </div>

                            </div>

                            <i
                                class="bi bi-people-fill summary-icon fs-1 text-primary"
                            ></i>

                        </div>

                    </div>

                </div>

            </div>


            <div class="col-6 col-md-3">

                <div class="card summary-card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <p class="summary-label">
                                    Tagihan Belum Lunas
                                </p>

                                <div class="summary-value fw-bold">
                                    {{ $jumlahTagihanBelumLunas }}
                                </div>

                            </div>

                            <i
                                class="bi bi-receipt summary-icon fs-1 text-warning"
                            ></i>

                        </div>

                    </div>

                </div>

            </div>


            <div class="col-6 col-md-3">

                <div class="card summary-card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <p class="summary-label">
                                    Total Tunggakan
                                </p>

                                <div class="summary-value fw-bold">
                                    Rp {{ number_format(
                                        $totalTunggakan,
                                        0,
                                        ',',
                                        '.'
                                    ) }}
                                </div>

                            </div>

                            <i
                                class="bi bi-cash-stack summary-icon fs-1 text-danger"
                            ></i>

                        </div>

                    </div>

                </div>

            </div>


            <div class="col-6 col-md-3">

                <div class="card summary-card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <p class="summary-label">
                                    Menunggu Verifikasi
                                </p>

                                <div class="summary-value fw-bold">
                                    {{ $pembayaranMenunggu }}
                                </div>

                            </div>

                            <i
                                class="bi bi-hourglass-split summary-icon fs-1 text-primary"
                            ></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- DAFTAR SANTRI -->

        <div class="card dashboard-section-card mb-4">

            <div class="card-body">

                <h2 class="section-heading fw-bold mb-3">
                    Data Santri
                </h2>

                <div class="row g-3">

                    @forelse($santri as $item)

                        <div class="col-md-6">

                            <div class="student-item">

                                <div class="d-flex">

                                    <div class="me-3">

                                        <i
                                            class="bi bi-person-circle summary-icon fs-1 text-primary"
                                        ></i>

                                    </div>

                                    <div>

                                        <h6 class="fw-bold mb-1">
                                            {{ $item->nama }}
                                        </h6>

                                        <div class="text-muted small">

                                            NIS:
                                            {{ $item->nis }}

                                            <br>

                                            Kelas:
                                            {{ $item->kelas }}

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="col-12">

                            <div class="alert alert-warning mb-0">
                                Belum ada santri yang terhubung.
                            </div>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>


        <!-- TAGIHAN -->

        <div class="card dashboard-section-card mb-4">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h2 class="section-heading fw-bold mb-0">
                        Tagihan Belum Lunas
                    </h2>

                    <a
                        href="{{ route('wali.tagihan.index') }}"
                        class="btn btn-sm btn-outline-primary"
                    >
                        Lihat Semua
                    </a>

                </div>


                <div class="dashboard-table-wrap table-responsive">

                    <table class="table align-middle">

                        <thead class="table-light">

                            <tr>
                                <th>Santri</th>
                                <th>Periode</th>
                                <th>Total</th>
                                <th>Sisa</th>
                                <th>Status</th>
                                <th></th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse(
                                $tagihanBelumLunas->take(5)
                                as $item
                            )

                                <tr>

                                    <td>
                                        {{ $item->santri->nama }}
                                    </td>

                                    <td>
                                        {{ \Carbon\Carbon::create(
                                            $item->periode_tahun,
                                            $item->periode_bulan,
                                            1
                                        )->translatedFormat('F Y') }}
                                    </td>

                                    <td>
                                        Rp {{ number_format(
                                            $item->detailTagihan->sum('nominal'),
                                            0,
                                            ',',
                                            '.'
                                        ) }}
                                    </td>

                                    <td>

                                        <strong>
                                            Rp {{ number_format(
                                                $item->hitungSisa(),
                                                0,
                                                ',',
                                                '.'
                                            ) }}
                                        </strong>

                                    </td>

                                    <td>

                                        @if($item->status === 'sebagian')

                                            <span class="badge text-bg-warning">
                                                Sebagian
                                            </span>

                                        @else

                                            <span class="badge text-bg-danger">
                                                Belum Bayar
                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        <a
                                            href="{{ route('wali.tagihan.show', $item->id) }}"
                                            class="btn btn-sm btn-primary"
                                        >
                                            Detail
                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="6"
                                        class="text-center text-success py-4"
                                    >

                                        <i
                                            class="bi bi-check-circle-fill fs-2"
                                        ></i>

                                        <div class="mt-2">
                                            Semua tagihan sudah lunas.
                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        <!-- PEMBAYARAN TERAKHIR -->

        <div class="card dashboard-section-card">

            <div class="card-body">

                <h2 class="section-heading fw-bold mb-3">
                    Pembayaran Terakhir
                </h2>

                <div class="dashboard-table-wrap table-responsive">

                    <table class="table align-middle">

                        <thead class="table-light">

                            <tr>
                                <th>Kode Transaksi</th>
                                <th>Tanggal</th>
                                <th>Metode</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($pembayaranTerakhir as $item)

                                <tr>

                                    <td>
                                        <strong>
                                            {{ $item->kode_transaksi }}
                                        </strong>
                                    </td>

                                    <td>
                                        {{ \Carbon\Carbon::parse(
                                            $item->tanggal_bayar
                                        )->format('d-m-Y H:i') }}
                                    </td>

                                    <td>
                                        {{ ucfirst($item->metode) }}
                                    </td>

                                    <td>
                                        Rp {{ number_format(
                                            $item->total_transfer,
                                            0,
                                            ',',
                                            '.'
                                        ) }}
                                    </td>

                                    <td>

                                        @if($item->status === 'diterima')

                                            <span class="badge text-bg-success">
                                                Diterima
                                            </span>

                                        @elseif($item->status === 'menunggu_verifikasi')

                                            <span class="badge text-bg-warning">
                                                Menunggu Verifikasi
                                            </span>

                                        @else

                                            <span class="badge text-bg-danger">
                                                Ditolak
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="5"
                                        class="text-center text-muted py-4"
                                    >
                                        Belum ada transaksi pembayaran.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>
    </div>

</main>

</body>

</html>