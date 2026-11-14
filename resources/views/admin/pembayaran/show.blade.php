<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Pembayaran - Pondok Pesantren Al Asror</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f9;
            color: #222;
        }

        .container {
            width: 90%;
            max-width: 1100px;
            margin: 40px auto;
        }

        .header {
            background: white;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .header h1 {
            margin: 0 0 10px;
            font-size: 32px;
        }

        .header p {
            margin: 0;
            color: #666;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .card h2 {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 22px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .info-item {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .info-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 6px;
        }

        .info-value {
            font-size: 17px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background: #f1f1f1;
        }

        .text-right {
            text-align: right;
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
        }

        .status-diterima {
            background: #d1e7dd;
            color: #0f5132;
        }

        .status-menunggu {
            background: #fff3cd;
            color: #664d03;
        }

        .status-ditolak {
            background: #f8d7da;
            color: #842029;
        }

        .button {
            display: inline-block;
            padding: 11px 18px;
            border-radius: 7px;
            text-decoration: none;
            color: white;
            background: #6c757d;
        }

        .button:hover {
            opacity: 0.9;
        }

        @media (max-width: 700px) {
            .info-grid {
                grid-template-columns: 1fr;
            }

            .container {
                width: 94%;
            }

            .card {
                padding: 18px;
            }

            table {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    {{-- HEADER --}}
    <div class="header">

        <h1>Detail Pembayaran</h1>

        <p>
            Pondok Pesantren Al Asror
        </p>

    </div>

    @if(session('success'))

        <div
            style="
                background:#d1e7dd;
                color:#0f5132;
                padding:15px 20px;
                border-radius:8px;
                margin-bottom:25px;
            "
        >
            {{ session('success') }}
        </div>

    @endif


    {{-- INFORMASI PEMBAYARAN --}}
    <div class="card">

        <h2>Informasi Pembayaran</h2>

        <div class="info-grid">

            <div class="info-item">

                <div class="info-label">
                    Kode Transaksi
                </div>

                <div class="info-value">
                    {{ $pembayaran->kode_transaksi ?? '-' }}
                </div>

            </div>


            <div class="info-item">

                <div class="info-label">
                    Metode Pembayaran
                </div>

                <div class="info-value">
                    {{ ucfirst($pembayaran->metode ?? '-') }}
                </div>

            </div>


            <div class="info-item">

                <div class="info-label">
                    Tanggal Pembayaran
                </div>

                <div class="info-value">

                    @if($pembayaran->tanggal_bayar)
                        {{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d-m-Y H:i') }}
                    @else
                        -
                    @endif

                </div>

            </div>


            <div class="info-item">

                <div class="info-label">
                    Status
                </div>

                @if ($pembayaran->metode === 'transfer' && $pembayaran->bukti_pembayaran)

                    <div class="card shadow-sm border-0 mt-4">

                        <div class="card-body">

                            <h4 class="fw-bold mb-3">
                                Bukti Pembayaran
                            </h4>

                            {{-- kode bukti pembayaran yang sudah berhasil --}}

                            @php
                                $fileBukti = $pembayaran->bukti_pembayaran;
                                $urlBukti = asset('storage/' . $fileBukti);

                                $extension = strtolower(
                                    pathinfo($fileBukti, PATHINFO_EXTENSION)
                                );
                            @endphp


                            @if (in_array($extension, ['jpg', 'jpeg', 'png']))

                                <div style="margin-top:15px;">

                                    <img
                                        src="{{ $urlBukti }}"
                                        alt="Bukti Pembayaran"
                                        style="
                                            max-width:100%;
                                            max-height:600px;
                                            border:1px solid #ddd;
                                            border-radius:8px;
                                        "
                                    >

                                </div>

                                <div style="margin-top:15px;">

                                    <a
                                        href="{{ $urlBukti }}"
                                        target="_blank"
                                        class="btn"
                                        style="background:#0d6efd;"
                                    >
                                        Buka Bukti di Tab Baru
                                    </a>

                                </div>

                            @elseif ($extension === 'pdf')

                                <p>
                                    Bukti pembayaran berupa file PDF.
                                </p>

                                <a
                                    href="{{ $urlBukti }}"
                                    target="_blank"
                                    class="btn"
                                    style="background:#dc3545;"
                                >
                                    📄 Buka Bukti PDF
                                </a>

                            @else

                                <p>
                                    File bukti pembayaran tidak dapat ditampilkan
                                    secara langsung.
                                </p>

                                <a
                                    href="{{ $urlBukti }}"
                                    target="_blank"
                                    class="btn"
                                    style="background:#0d6efd;"
                                >
                                    Buka File Bukti
                                </a>

                            @endif

                        </div>

                    </div>

                @endif

                <div class="info-value">

                    @if($pembayaran->status === 'diterima')

                        <span class="badge bg-success">
                            Diterima
                        </span>

                    @elseif($pembayaran->status === 'ditolak')

                        <span class="badge bg-danger">
                            Ditolak
                        </span>

                    @else

                        <span class="badge bg-warning text-dark">
                            Menunggu Verifikasi
                        </span>

                    @endif

                </div>

            </div>


            <div class="info-item">

                <div class="info-label">
                    Nominal Tagihan
                </div>

                <div class="info-value">

                    Rp {{ number_format($pembayaran->nominal_tagihan ?? 0, 0, ',', '.') }}

                </div>

            </div>


            <div class="info-item">

                <div class="info-label">
                    Total Transfer
                </div>

                <div class="info-value">

                    Rp {{ number_format($pembayaran->total_transfer ?? 0, 0, ',', '.') }}

                </div>

            </div>

        </div>

    </div>


    {{-- DETAIL TAGIHAN --}}
    <div class="card">

        <h2>Detail Tagihan yang Dibayar</h2>

        <div style="overflow-x:auto;">

            <table>

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Jenis Tagihan</th>

                        <th>Santri</th>

                        <th class="text-right">
                            Nominal Dibayar
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($pembayaran->detailPembayaran as $index => $detail)

                        <tr>

                            <td>
                                {{ $index + 1 }}
                            </td>

                            <td>

                                {{ $detail->detailTagihan->jenisTagihan->nama ?? '-' }}

                            </td>

                            <td>

                                {{ $detail->detailTagihan->tagihan->santri->nama ?? '-' }}

                            </td>

                            <td class="text-right">

                                Rp {{ number_format($detail->nominal_dibayar ?? 0, 0, ',', '.') }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4" style="text-align:center;">

                                Belum ada detail pembayaran.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- TOTAL --}}
    <div class="card">

        <h2>Total Pembayaran</h2>

        <div style="font-size:28px; font-weight:bold;">

            Rp {{ number_format($pembayaran->hitungTotalDibayar(), 0, ',', '.') }}

        </div>

    </div>


    <div style="display:flex; gap:10px; flex-wrap:wrap;">

        <a
            href="{{ route('admin.pembayaran.index') }}"
            class="button"
        >
            ← Kembali ke Data Pembayaran
        </a>

        @if($pembayaran->status !== 'diterima')

            <form
                action="{{ route('admin.pembayaran.terima', $pembayaran->id) }}"
                method="POST"
                style="display:inline;"
            >

                @csrf

                <button
                    type="submit"
                    class="button"
                    style="background:#198754; border:none; cursor:pointer;"
                    onclick="return confirm('Apakah Anda yakin ingin menerima pembayaran ini?')"
                >
                    ✓ Terima Pembayaran
                </button>

            </form>

        @endif

    </div>

    @if ($pembayaran->status === 'menunggu_verifikasi')

        <div class="mt-4">

            <form action="{{ route('admin.pembayaran.tolak', $pembayaran->id) }}" method="POST">

                @csrf

                <div class="mb-3">
                    <label for="alasan_penolakan" class="form-label">
                        Alasan Penolakan
                    </label>

                    <textarea
                        name="alasan_penolakan"
                        id="alasan_penolakan"
                        class="form-control"
                        rows="4"
                        placeholder="Contoh: Bukti pembayaran tidak jelas atau nominal transfer tidak sesuai."
                        required
                    ></textarea>
                </div>

                <button type="submit" class="btn btn-danger">
                    Tolak Pembayaran
                </button>

            </form>

        </div>

    @endif

</div>

</body>
</html>