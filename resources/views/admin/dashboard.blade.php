<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Dashboard Admin - Pondok Pesantren Al Asror
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <style>
        :root {
            --page-bg: #f5f7fb;
            --card-radius: 16px;
            --card-shadow: 0 4px 18px rgba(15, 23, 42, 0.07);
        }

        html, body {
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
            width: min(100%, 1500px);
            margin: 0 auto;
        }

        .dashboard-header-card,
        .dashboard-card,
        .dashboard-section-card {
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

        .dashboard-card {
            border-left: 4px solid transparent;
            height: 100%;
            overflow: hidden;
        }

        .dashboard-card .card-body {
            padding: 20px;
        }

        .card-blue { border-left-color: #0d6efd; }
        .card-yellow { border-left-color: #ffc107; }
        .card-green { border-left-color: #198754; }
        .card-red { border-left-color: #dc3545; }

        .dashboard-label {
            margin: 0 0 8px;
            color: #6b7280;
            font-size: .84rem;
            font-weight: 600;
            line-height: 1.35;
        }

        .dashboard-number {
            color: #111827;
            font-size: clamp(1.45rem, 2.3vw, 2rem);
            font-weight: 700;
            line-height: 1.15;
            overflow-wrap: anywhere;
        }

        .section-heading {
            margin: 0 0 5px;
            font-size: clamp(1.05rem, 1.6vw, 1.3rem);
            line-height: 1.35;
        }

        .section-subheading {
            margin: 0;
            color: #6b7280;
            font-size: .88rem;
            line-height: 1.5;
        }

        .chart-row {
            margin-bottom: 20px;
        }

        .chart-row:last-child {
            margin-bottom: 0;
        }

        .chart-label {
            margin-bottom: 7px;
            color: #374151;
            font-size: .88rem;
            font-weight: 700;
        }

        .chart-track {
            height: 22px;
            min-width: 0;
            background: #e9ecef;
            border-radius: 999px;
            overflow: hidden;
        }

        .chart-income,
        .chart-expense {
            height: 100%;
            min-width: 0;
            border-radius: inherit;
        }

        .chart-income { background: #198754; }
        .chart-expense { background: #dc3545; }

        .chart-value {
            flex: 0 0 auto;
            min-width: 94px;
            text-align: right;
        }

        .dashboard-table-wrap {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .dashboard-table-wrap table {
            min-width: 720px;
            margin-bottom: 0;
        }

        .dashboard-table-wrap th,
        .dashboard-table-wrap td {
            white-space: nowrap;
        }

        .dashboard-footer {
            margin-top: 18px;
            color: #6b7280;
            font-size: .82rem;
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

            .dashboard-card .card-body {
                padding: 16px;
            }

            .dashboard-number {
                font-size: 1.42rem;
            }

            .chart-row {
                margin-bottom: 18px;
            }

            .chart-value {
                min-width: 84px;
                font-size: .78rem;
            }

            .chart-track {
                height: 18px;
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

            .dashboard-card .card-body {
                padding: 14px;
            }

            .dashboard-label {
                font-size: .78rem;
            }

            .dashboard-number {
                font-size: 1.25rem;
            }

            .dashboard-table-wrap table {
                min-width: 680px;
            }
        }
    </style>


</head>

<body>

@include('admin.partials.sidebar')

    <main class="dashboard-main">

        <div class="dashboard-container">

                {{-- HEADER --}}

                <div class="card dashboard-header-card mb-4">

                    <div class="card-body">

                        <h1 class="dashboard-header-title fw-bold">
                            Dashboard Admin
                        </h1>

                        <p class="dashboard-header-subtitle">

                            Selamat datang,
                            <strong>
                                {{ auth()->user()->name }}
                            </strong>.

                        </p>

                    </div>

                </div>


                {{-- RINGKASAN --}}

                <div class="row g-3 mb-4">

                    <div class="col-6 col-md-6 col-xl-3">

                        <div class="card dashboard-card card-blue h-100">

                            <div class="card-body">

                                <p class="dashboard-label">Total Santri</p>

                                <div class="dashboard-number">
                                    {{ $totalSantri }}
                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="col-6 col-md-6 col-xl-3">

                        <div class="card dashboard-card card-yellow h-100">

                            <div class="card-body">

                                <p class="dashboard-label">Tagihan Belum Lunas</p>

                                <div class="dashboard-number">
                                    {{ $tagihanBelumLunas }}
                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="col-6 col-md-6 col-xl-3">

                        <div class="card dashboard-card card-blue h-100">

                            <div class="card-body">

                                <p class="dashboard-label">Menunggu Verifikasi</p>

                                <div class="dashboard-number">
                                    {{ $pembayaranMenunggu }}
                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="col-6 col-md-6 col-xl-3">

                        <div class="card dashboard-card card-green h-100">

                            <div class="card-body">

                                <p class="dashboard-label">Pemasukan Bulan Ini</p>

                                <div class="dashboard-number text-nowrap">

                                    Rp {{ number_format(
                                        $totalPemasukan,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- PENGELUARAN --}}

                <div class="row g-3 mb-4">

                    <div class="col-md-6">

                        <div class="card dashboard-card card-red">

                            <div class="card-body">

                                <p class="dashboard-label">Pengeluaran Bulan Ini</p>

                                <div class="dashboard-number text-nowrap">

                                    Rp {{ number_format(
                                        $totalPengeluaran,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- GRAFIK --}}

                <div class="card dashboard-section-card mb-4">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center mb-4">

                            <div>

                                <h4 class="section-heading fw-bold">
                                    Grafik Keuangan
                                </h4>

                                <p class="text-muted mb-0">
                                    Pemasukan dan pengeluaran
                                    tahun {{ $tahunGrafik }}
                                </p>

                            </div>

                        </div>


                        <div class="mb-4">

                            <span class="badge bg-success">
                                Pemasukan
                            </span>

                            <span class="badge bg-danger">
                                Pengeluaran
                            </span>

                        </div>


                        @foreach ($grafikBulanan as $item)

                            <div class="chart-row">

                                <div class="chart-label">
                                    {{ $item['nama_bulan'] }}
                                </div>


                                <div class="mb-2">

                                    <small class="text-muted">
                                        Pemasukan:
                                    </small>

                                    <div class="d-flex align-items-center gap-2">

                                        <div class="chart-track flex-grow-1">

                                            <div
                                                class="chart-income"
                                                style="
                                                    width:
                                                    {{ $nilaiMaksimalGrafik > 0
                                                        ? ($item['pemasukan'] / $nilaiMaksimalGrafik) * 100
                                                        : 0
                                                    }}%;
                                                "
                                            ></div>

                                        </div>

                                        <small class="fw-bold text-nowrap chart-value">

                                            Rp {{ number_format(
                                                $item['pemasukan'],
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                                        </small>

                                    </div>

                                </div>


                                <div>

                                    <small class="text-muted">
                                        Pengeluaran:
                                    </small>

                                    <div class="d-flex align-items-center gap-2">

                                        <div class="chart-track flex-grow-1">

                                            <div
                                                class="chart-expense"
                                                style="
                                                    width:
                                                    {{ $nilaiMaksimalGrafik > 0
                                                        ? ($item['pengeluaran'] / $nilaiMaksimalGrafik) * 100
                                                        : 0
                                                    }}%;
                                                "
                                            ></div>

                                        </div>

                                        <small class="fw-bold text-nowrap chart-value">

                                            Rp {{ number_format(
                                                $item['pengeluaran'],
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                                        </small>

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>


                {{-- PEMBAYARAN MENUNGGU VERIFIKASI --}}

                <div class="card dashboard-section-card mb-4">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <div>

                                <h4 class="section-heading fw-bold">
                                    Pembayaran Menunggu Verifikasi
                                </h4>

                                <p class="section-subheading">
                                    Maksimal 5 transaksi terbaru
                                </p>

                            </div>

                            <a
                                href="{{ route('admin.pembayaran.index') }}"
                                class="btn btn-outline-primary btn-sm"
                            >
                                Lihat Semua
                            </a>

                        </div>


                        @if ($pembayaranPending->count() > 0)

                            <div class="dashboard-table-wrap table-responsive">

                                <table class="table table-hover align-middle">

                                    <thead class="table-light">

                                        <tr>

                                            <th>
                                                No
                                            </th>

                                            <th>
                                                Kode Transaksi
                                            </th>

                                            <th>
                                                Metode
                                            </th>

                                            <th>
                                                Nominal
                                            </th>

                                            <th>
                                                Tanggal
                                            </th>

                                            <th>
                                                Aksi
                                            </th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        @foreach ($pembayaranPending as $index => $item)

                                            <tr>

                                                <td>
                                                    {{ $index + 1 }}
                                                </td>

                                                <td>

                                                    <strong>
                                                        {{ $item->kode_transaksi }}
                                                    </strong>

                                                </td>

                                                <td>

                                                    <span class="badge bg-info text-dark">
                                                        {{ ucfirst($item->metode) }}
                                                    </span>

                                                </td>

                                                <td>

                                                    Rp {{ number_format(
                                                        $item->total_transfer ?? 0,
                                                        0,
                                                        ',',
                                                        '.'
                                                    ) }}

                                                </td>

                                                <td>

                                                    {{ \Carbon\Carbon::parse(
                                                        $item->tanggal_bayar
                                                    )->format('d-m-Y H:i') }}

                                                </td>

                                                <td>

                                                    <a
                                                        href="{{ route(
                                                            'admin.pembayaran.show',
                                                            $item->id
                                                        ) }}"
                                                        class="btn btn-primary btn-sm"
                                                    >
                                                        Detail
                                                    </a>

                                                </td>

                                            </tr>

                                        @endforeach

                                    </tbody>

                                </table>

                            </div>

                        @else

                            <div class="alert alert-success mb-0">

                                Tidak ada pembayaran yang
                                menunggu verifikasi.

                            </div>

                        @endif

                    </div>

                </div>

                {{-- FOOTER INFO --}}

                <div class="dashboard-footer">

                    Sistem Informasi Manajemen Keuangan
                    Pondok Pesantren Al Asror

                </div>

            </div>
    </main>

</body>

</html>