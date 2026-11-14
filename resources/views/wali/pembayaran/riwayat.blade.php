<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Riwayat Pembayaran - Pondok Pesantren Al Asror
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
                                    Riwayat Pembayaran
                                </h1>

                                <p class="text-muted mb-0">
                                    Riwayat transaksi pembayaran wali.
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


                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <div class="table-responsive">

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
                                            Santri
                                        </th>

                                        <th>
                                            Metode
                                        </th>

                                        <th class="text-end">
                                            Nominal
                                        </th>

                                        <th>
                                            Tanggal
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

                                    @forelse (
                                        $pembayaran
                                        as $index => $item
                                    )

                                        @php

                                            $detail =
                                                $item->detailPembayaran
                                                    ->first();

                                            $santri =
                                                $detail
                                                    ?->detailTagihan
                                                    ?->tagihan
                                                    ?->santri;

                                        @endphp

                                        <tr>

                                            <td>
                                                {{ $pembayaran->firstItem() + $index }}
                                            </td>

                                            <td>

                                                <strong>

                                                    {{
                                                        $item->kode_transaksi
                                                    }}

                                                </strong>

                                            </td>

                                            <td>

                                                {{
                                                    $santri->nama
                                                    ?? '-'
                                                }}

                                            </td>

                                            <td>

                                                <span class="badge bg-info text-dark">

                                                    {{
                                                        ucfirst(
                                                            $item->metode
                                                        )
                                                    }}

                                                </span>

                                            </td>

                                            <td class="text-end">

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

                                                @if (
                                                    $item->status
                                                    === 'menunggu_verifikasi'
                                                )

                                                    <span class="badge bg-warning text-dark">

                                                        Menunggu Verifikasi

                                                    </span>

                                                @elseif (
                                                    $item->status
                                                    === 'diterima'
                                                )

                                                    <span class="badge bg-success">

                                                        Diterima

                                                    </span>

                                                @elseif (
                                                    $item->status
                                                    === 'ditolak'
                                                )

                                                    <span class="badge bg-danger">

                                                        Ditolak

                                                    </span>

                                                @endif


                                                @if (
                                                    $item->status
                                                    === 'ditolak'
                                                    && $item->alasan_penolakan
                                                )

                                                    <div class="small text-danger mt-2">

                                                        <strong>
                                                            Alasan:
                                                        </strong>

                                                        {{
                                                            $item->alasan_penolakan
                                                        }}

                                                    </div>

                                                @endif

                                            </td>

                                            <td>

                                                <a
                                                    href="{{ route(
                                                        'wali.pembayaran.show',
                                                        $item->id
                                                    ) }}"
                                                    class="btn btn-primary btn-sm"
                                                >
                                                    Detail
                                                </a>

                                            </td>

                                            <td>
                                                @if($item->status === 'diterima')

                                                    <a
                                                        href="{{ route(
                                                            'kuitansi.show',
                                                            $item->id
                                                        ) }}"
                                                        class="btn btn-sm btn-success"
                                                    >
                                                        Kuitansi
                                                    </a>

                                                @else

                                                    <a
                                                        href="{{ route(
                                                            'kuitansi.show',
                                                            $item->id
                                                        ) }}"
                                                        class="btn btn-sm btn-secondary"
                                                    >
                                                        Bukti
                                                    </a>

                                                @endif
                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td
                                                colspan="8"
                                                class="text-center text-muted py-4"
                                            >
                                                Belum ada riwayat pembayaran.
                                            </td>

                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>


                <div class="mt-3">

                    {{ $pembayaran->withQueryString()->links() }}

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