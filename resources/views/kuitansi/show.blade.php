<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Kuitansi {{ $pembayaran->kode_transaksi }}
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {

            margin: 0;

            background: #f3f4f6;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            color: #111827;

        }

        .receipt-wrapper {

            max-width: 760px;

            margin: 30px auto;

            padding: 15px;

        }

        .receipt {

            background: white;

            border-radius: 14px;

            padding: 28px;

            box-shadow:
                0 8px 30px
                rgba(0,0,0,.08);

        }

        .header {

            text-align: center;

            border-bottom:
                2px dashed #d1d5db;

            padding-bottom: 20px;

            margin-bottom: 20px;

        }

        .logo {

            width: 60px;

            height: 60px;

            margin: 0 auto 10px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 14px;

            background: #198754;

            color: white;

            font-weight: 800;

            font-size: 20px;

        }

        .header h1 {

            margin: 0;

            font-size: 23px;

        }

        .header p {

            margin: 5px 0 0;

            color: #6b7280;

        }

        .transaction-box {

            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 12px;

            margin-bottom: 20px;

        }

        .info {

            background: #f8fafc;

            padding: 12px;

            border-radius: 10px;

        }

        .label {

            display: block;

            font-size: 12px;

            color: #6b7280;

            margin-bottom: 4px;

        }

        .value {

            font-weight: 700;

            word-break: break-word;

        }

        .status {

            display: inline-block;

            padding: 6px 10px;

            border-radius: 999px;

            font-size: 12px;

            font-weight: 700;

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

        table {

            width: 100%;

            border-collapse: collapse;

            margin-top: 15px;

        }

        th,
        td {

            padding: 10px 8px;

            border-bottom:
                1px solid #e5e7eb;

            text-align: left;

        }

        th {

            font-size: 12px;

            color: #6b7280;

        }

        .text-right {

            text-align: right;

        }

        .total-box {

            margin-top: 20px;

            padding-top: 15px;

            border-top:
                2px dashed #d1d5db;

            display: flex;

            justify-content: space-between;

            align-items: center;

        }

        .total-label {

            font-weight: 700;

        }

        .total {

            font-size: 24px;

            font-weight: 800;

        }

        .footer {

            margin-top: 25px;

            text-align: center;

            color: #6b7280;

            font-size: 12px;

        }

        .actions {

            display: flex;

            gap: 10px;

            flex-wrap: wrap;

            margin-top: 20px;

        }

        .btn {

            border: none;

            text-decoration: none;

            padding: 11px 16px;

            border-radius: 8px;

            cursor: pointer;

            font-weight: 700;

            font-size: 14px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

        }

        .btn-print {

            background: #198754;

            color: white;

        }

        .btn-share {

            background: #0d6efd;

            color: white;

        }

        .btn-back {

            background: #6c757d;

            color: white;

        }

        @media (max-width: 600px) {

            .receipt-wrapper {

                margin: 10px auto;

                padding: 8px;

            }

            .receipt {

                padding: 18px;

                border-radius: 10px;

            }

            .transaction-box {

                grid-template-columns: 1fr;

            }

        }

        @media print {

            body {

                background: white;

            }

            .receipt-wrapper {

                width: 80mm;

                max-width: 80mm;

                margin: 0;

                padding: 0;

            }

            .receipt {

                box-shadow: none;

                border-radius: 0;

                padding: 4mm;

            }

            .actions {

                display: none;

            }

            @page {

                size: 80mm auto;

                margin: 0;

            }

            table {

                font-size: 11px;

            }

            .total {

                font-size: 18px;

            }

        }

    </style>

</head>

<body>

<div class="receipt-wrapper">

    <div class="receipt">

        <div class="header">

            <div class="logo">
                AA
            </div>

            <h1>
                Pondok Pesantren Al Asror
            </h1>

            <p>
                Kuitansi Pembayaran
            </p>

        </div>

        @php

            $detailPertama =
                $pembayaran
                    ->detailPembayaran
                    ->first();

            $santri =
                $detailPertama
                    ?->detailTagihan
                    ?->tagihan
                    ?->santri;

        @endphp

        <div class="transaction-box">

            <div class="info">

                <span class="label">
                    Kode Transaksi
                </span>

                <span class="value">
                    {{ $pembayaran->kode_transaksi }}
                </span>

            </div>

            <div class="info">

                <span class="label">
                    Tanggal
                </span>

                <span class="value">

                    {{ \Carbon\Carbon::parse(
                        $pembayaran->tanggal_bayar
                    )->format('d-m-Y H:i') }}

                </span>

            </div>

            <div class="info">

                <span class="label">
                    Santri
                </span>

                <span class="value">

                    {{ $santri->nama ?? '-' }}

                </span>

            </div>

            <div class="info">

                <span class="label">
                    Metode
                </span>

                <span class="value">

                    {{ ucfirst(
                        $pembayaran->metode ?? '-'
                    ) }}

                </span>

            </div>

            <div class="info">

                <span class="label">
                    Status
                </span>

                <span>

                    @if(
                        $pembayaran->status === 'diterima'
                    )

                        <span
                            class="
                                status
                                status-diterima
                            "
                        >
                            DITERIMA
                        </span>

                    @elseif(
                        $pembayaran->status === 'ditolak'
                    )

                        <span
                            class="
                                status
                                status-ditolak
                            "
                        >
                            DITOLAK
                        </span>

                    @else

                        <span
                            class="
                                status
                                status-menunggu
                            "
                        >
                            MENUNGGU VERIFIKASI
                        </span>

                    @endif

                </span>

            </div>

        </div>


        <table>

            <thead>

                <tr>

                    <th>
                        Jenis
                    </th>

                    <th>
                        Periode
                    </th>

                    <th class="text-right">
                        Dibayar
                    </th>

                </tr>

            </thead>

            <tbody>

            @forelse(
                $pembayaran->detailPembayaran
                as $detail
            )

                @php

                    $detailTagihan =
                        $detail->detailTagihan;

                    $tagihan =
                        $detailTagihan->tagihan;

                @endphp

                <tr>

                    <td>

                        {{
                            $detailTagihan
                                ->jenisTagihan
                                ->nama
                            ?? '-'
                        }}

                    </td>

                    <td>

                        @if($tagihan)

                            {{ \Carbon\Carbon::create(
                                $tagihan->periode_tahun,
                                $tagihan->periode_bulan,
                                1
                            )->translatedFormat('F Y') }}

                        @else

                            -

                        @endif

                    </td>

                    <td class="text-right">

                        Rp
                        {{
                            number_format(
                                $detail->nominal_dibayar,
                                0,
                                ',',
                                '.'
                            )
                        }}

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="3"
                        style="text-align:center"
                    >
                        Tidak ada detail pembayaran.
                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>


        <div class="total-box">

            <div class="total-label">
                Total Pembayaran
            </div>

            <div class="total">

                Rp
                {{
                    number_format(
                        $pembayaran
                            ->hitungTotalDibayar(),
                        0,
                        ',',
                        '.'
                    )
                }}

            </div>

        </div>


        <div class="footer">

            Kuitansi ini dibuat oleh
            Sistem Informasi Manajemen Keuangan
            Pondok Pesantren Al Asror.

            <br><br>

            Kode transaksi:
            {{ $pembayaran->kode_transaksi }}

        </div>


        @unless(isset($isPublic) && $isPublic)

            <div class="actions">

                <button
                    type="button"
                    class="btn btn-print"
                    onclick="window.print()"
                >
                    🖨 Cetak
                </button>


                @if($shareUrl)

                    <button
                        type="button"
                        class="btn btn-share"
                        onclick="
                            shareKuitansi(
                                @js($shareUrl)
                            )
                        "
                    >
                        ↗ Bagikan
                    </button>

                @endif


                <button
                    type="button"
                    class="btn btn-back"
                    onclick="history.back()"
                >
                    ← Kembali
                </button>

            </div>

        @endunless

    </div>

</div>


<script>

async function shareKuitansi(url) {

    const shareData = {

        title:
            'Kuitansi Pembayaran Al Asror',

        text:
            'Kuitansi pembayaran ' +
            '{{ $pembayaran->kode_transaksi }}',

        url: url

    };


    if (
        navigator.share
    ) {

        try {

            await navigator.share(
                shareData
            );

            return;

        } catch (error) {

            if (
                error.name ===
                'AbortError'
            ) {

                return;

            }

        }

    }


    try {

        await navigator.clipboard.writeText(
            url
        );

        alert(
            'Link kuitansi berhasil disalin.'
        );

    } catch (error) {

        prompt(
            'Salin link kuitansi:',
            url
        );

    }

}

</script>

</body>
</html>