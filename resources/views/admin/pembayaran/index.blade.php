<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Pembayaran</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        }

        h1 {
            margin-top: 0;
        }

        .filter {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        select,
        button,
        .btn-reset {
            padding: 10px 14px;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        button {
            background: #2563eb;
            color: white;
            border: none;
            cursor: pointer;
        }

        .btn-reset {
            text-decoration: none;
            color: #333;
            background: #eee;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        th {
            background: #f8f9fa;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
        }

        .menunggu {
            background: #fff3cd;
            color: #856404;
        }

        .diterima {
            background: #d1e7dd;
            color: #0f5132;
        }

        .ditolak {
            background: #f8d7da;
            color: #842029;
        }

        .btn-detail {
            text-decoration: none;
            color: #2563eb;
            font-weight: bold;
        }
    </style>
</head>

<body class="bg-light">

<div class="container py-4">

    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                <div>

                    <h2 class="fw-bold mb-1">
                        Data Pembayaran
                    </h2>

                    <p class="text-muted mb-0">
                        Kelola dan verifikasi pembayaran santri.
                    </p>

                </div>

                <a
                    href="{{ route('admin.pembayaran.offline.create') }}"
                    class="btn btn-success"
                >
                    + Pembayaran Offline
                </a>

            </div>
         
        </div>

    </div>

</div>

<div class="card shadow-sm border-0 mb-4">

    <div class="card-body">

        <h5 class="fw-bold mb-3">
            Filter Pembayaran
        </h5>

        <form
            method="GET"
            action="{{ route('admin.pembayaran.index') }}"
        >

            <div class="row g-2 align-items-end">

                <div class="col-md-5">

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
                            value="menunggu_verifikasi"
                            {{ request('status') === 'menunggu_verifikasi' ? 'selected' : '' }}
                        >
                            Menunggu Verifikasi
                        </option>

                        <option
                            value="diterima"
                            {{ request('status') === 'diterima' ? 'selected' : '' }}
                        >
                            Diterima
                        </option>

                        <option
                            value="ditolak"
                            {{ request('status') === 'ditolak' ? 'selected' : '' }}
                        >
                            Ditolak
                        </option>

                    </select>

                </div>

                <div class="col-md-auto">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Filter
                    </button>

                </div>

                <div class="col-md-auto">

                    <a
                        href="{{ route('admin.pembayaran.index') }}"
                        class="btn btn-secondary"
                    >
                        Reset
                    </a>

                </div>

            </div>

        </form>

    </div>

</div>

<div class="card shadow-sm border-0">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Kode Transaksi</th>
                        <th>Metode</th>
                        <th>Nominal</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                @forelse ($pembayaran as $index => $item)

                    <tr>

                        <td>
                            {{ $pembayaran->firstItem() + $index }}
                        </td>

                        <td>
                            <strong>
                                {{ $item->kode_transaksi }}
                            </strong>
                        </td>

                        <td>
                            {{ ucfirst($item->metode) }}
                        </td>

                        <td>
                            Rp {{ number_format($item->total_transfer, 0, ',', '.') }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($item->tanggal_bayar)->format('d-m-Y H:i') }}
                        </td>

                        <td>

                            @if ($item->status === 'menunggu_verifikasi')

                                <span class="badge bg-warning text-dark">
                                    Menunggu Verifikasi
                                </span>

                            @elseif ($item->status === 'diterima')

                                <span class="badge bg-success">
                                    Diterima
                                </span>

                            @elseif ($item->status === 'ditolak')

                                <span class="badge bg-danger">
                                    Ditolak
                                </span>

                            @endif

                        </td>

                        <td>
                            <a
                                href="{{ route('admin.pembayaran.show', $item->id) }}"
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
                                    class="btn btn-success btn-sm"
                                >
                                    Kuitansi
                                </a>

                            @else

                                <a
                                    href="{{ route(
                                        'kuitansi.show',
                                        $item->id
                                    ) }}"
                                    class="btn btn-secondary btn-sm"
                                >
                                    Bukti
                                </a>

                            @endif
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" style="text-align:center;">
                            Belum ada data pembayaran.
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>
    
    <div class="mt-3">

        {{ $pembayaran->links() }}

    </div>

</div>

</body>
</html>