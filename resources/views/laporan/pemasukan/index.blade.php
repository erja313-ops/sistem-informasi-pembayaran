<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan Pemasukan</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 30px;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .card-body {
            padding: 20px;
        }

        .card-header {
            padding: 15px 20px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #ddd;
        }

        h1,
        h3,
        h5 {
            margin-top: 0;
        }

        .text-muted {
            color: #666;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f8f9fa;
            text-align: left;
        }

        .text-end {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .total {
            font-weight: bold;
        }

        .period {
            font-size: 16px;
        }

        @media print {

            body {
                background-color: white;
                padding: 0;
            }

            .card {
                border: none;
                margin-bottom: 15px;
            }

            button,
            form {
                display: none !important;
            }

            .card-header {
                background-color: white;
            }

            .container {
                max-width: 100%;
            }

            .kop-laporan {
                text-align: center;
            }

            .kop-laporan h1 {
                font-size: 20px;
            }

            .kop-laporan h2 {
                font-size: 16px;
            }

        }

        .kop-laporan {
            text-align: center;
        }

        .kop-laporan h1 {
            margin-bottom: 5px;
            font-size: 24px;
        }

        .kop-laporan h2 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 20px;
        }

        .kop-laporan p {
            margin: 5px 0;
            color: #555;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="card">

            <div class="card-body">

                <div class="kop-laporan">

                    <h1>PONDOK PESANTREN AL ASROR</h1>

                    <h2>LAPORAN PEMASUKAN</h2>

                    <p>
                        Rekap pemasukan berdasarkan jenis tagihan
                    </p>

                    <p>
                        Periode:
                        <strong>
                            {{ $mulai->translatedFormat('F Y') }}
                        </strong>
                    </p>

                    <p>
                        Dicetak pada:
                        {{ now()->format('d-m-Y H:i') }}
                    </p>

                </div>

            </div>

        </div>


        <div class="card">

            <div class="card-header">
                <strong>Filter Periode Laporan</strong>
            </div>

            <div class="card-body">

                <form method="GET" action="{{ route('laporan.pemasukan') }}">

                    <div style="display: flex; gap: 15px; align-items: end; flex-wrap: wrap;">

                        <div>
                            <label for="bulan">
                                <strong>Bulan</strong>
                            </label>

                            <select
                                name="bulan"
                                id="bulan"
                                style="padding: 8px; margin-top: 5px;"
                            >
                                @for ($i = 1; $i <= 12; $i++)

                                    <option
                                        value="{{ $i }}"
                                        {{ (int) $bulan === $i ? 'selected' : '' }}
                                    >
                                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                    </option>

                                @endfor
                            </select>
                        </div>


                        <div>

                            <label for="tahun">
                                <strong>Tahun</strong>
                            </label>

                            <select
                                name="tahun"
                                id="tahun"
                                style="padding: 8px; margin-top: 5px;"
                            >

                                @for ($i = now()->year - 2; $i <= now()->year + 1; $i++)

                                    <option
                                        value="{{ $i }}"
                                        {{ (int) $tahun === $i ? 'selected' : '' }}
                                    >
                                        {{ $i }}
                                    </option>

                                @endfor

                            </select>

                        </div>

                        <div>

                            <label for="jenis_tagihan_id">
                                <strong>Jenis Tagihan</strong>
                            </label>

                            <select
                                name="jenis_tagihan_id"
                                id="jenis_tagihan_id"
                                style="padding: 8px; margin-top: 5px;"
                            >

                                <option value="">
                                    Semua Jenis
                                </option>

                                @foreach ($jenisTagihan as $jenis)

                                    <option
                                        value="{{ $jenis->id }}"
                                        {{ (string) $jenisTagihanId === (string) $jenis->id ? 'selected' : '' }}
                                    >
                                        {{ $jenis->nama }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <div>

                            <button
                                type="submit"
                                style="
                                    padding: 9px 18px;
                                    border: none;
                                    border-radius: 5px;
                                    cursor: pointer;
                                    background-color: #198754;
                                    color: white;
                                "
                            >
                                Tampilkan
                            </button>

                        </div>

                    </div>

                </form>


                <hr>

                <p class="period">
                    Periode:
                    <strong>
                        {{ $mulai->format('d-m-Y') }}
                        sampai
                        {{ $sampai->format('d-m-Y') }}
                    </strong>
                </p>

            </div>

        </div>


        <div class="card">

            <div class="card-header">

                <div style="
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    gap: 10px;
                    flex-wrap: wrap;
                ">

                    <strong>Rincian Pemasukan</strong>

                    <button
                        type="button"
                        onclick="window.print()"
                        style="
                            padding: 8px 15px;
                            border: none;
                            border-radius: 5px;
                            cursor: pointer;
                            background-color: #0d6efd;
                            color: white;
                        "
                    >
                        Cetak Laporan
                    </button>

                </div>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table>

                        <thead>

                            <tr>
                                <th width="60">No</th>
                                <th>Jenis Tagihan</th>
                                <th class="text-end">
                                    Total Pemasukan
                                </th>
                            </tr>

                        </thead>


                        <tbody>

                            @forelse ($rekap as $index => $item)

                                <tr>

                                    <td>
                                        {{ $index + 1 }}
                                    </td>

                                    <td>
                                        {{ $item['nama'] }}
                                    </td>

                                    <td class="text-end">
                                        Rp
                                        {{ number_format($item['total_pemasukan'], 0, ',', '.') }}
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="3" class="text-center">
                                        Belum ada data pemasukan.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>


                        <tfoot>

                            <tr class="total">

                                <th colspan="2" class="text-end">
                                    TOTAL PEMASUKAN
                                </th>

                                <th class="text-end">
                                    Rp
                                    {{ number_format($totalPemasukan, 0, ',', '.') }}
                                </th>

                            </tr>

                        </tfoot>

                    </table>

                </div>

            </div>

        </div>

    </div>

</body>

</html>