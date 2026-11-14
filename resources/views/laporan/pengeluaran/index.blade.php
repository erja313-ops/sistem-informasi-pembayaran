<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan Pengeluaran</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 30px;
            background: #f5f5f5;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        .card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        h1,
        h2 {
            margin-top: 0;
        }

        .kop-laporan {
            text-align: center;
        }

        .kop-laporan h1 {
            margin-bottom: 5px;
        }

        .kop-laporan h2 {
            margin-top: 0;
        }

        .filter {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        select,
        button {
            padding: 9px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background: #0d6efd;
            color: white;
            border: none;
            cursor: pointer;
        }

        .btn-cetak {
            background: #198754;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        th {
            background: #f2f2f2;
        }

        .text-end {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        @media print {

            body {
                background: white;
                padding: 0;
            }

            .filter,
            .btn-cetak {
                display: none !important;
            }

            .card {
                border: none;
            }

            .kop-laporan {
                text-align: center;
            }

        }

    </style>

</head>

<body>

<div class="container">

    {{-- KOP LAPORAN --}}
    <div class="card">

        <div class="kop-laporan">

            <h1>PONDOK PESANTREN AL ASROR</h1>

            <h2>LAPORAN PENGELUARAN</h2>

            <p>
                Rekap pengeluaran berdasarkan kategori
            </p>

        </div>

    </div>


    {{-- FILTER --}}
    <div class="card">

        <h3>Filter Periode Laporan</h3>

        <form
            action="{{ route('laporan.pengeluaran') }}"
            method="GET"
            class="filter"
        >

            <div class="form-group">

                <label>Bulan</label>

                <select name="bulan">

                    @for ($i = 1; $i <= 12; $i++)

                        <option
                            value="{{ $i }}"
                            {{ $bulan == $i ? 'selected' : '' }}
                        >
                            {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                        </option>

                    @endfor

                </select>

            </div>


            <div class="form-group">

                <label>Tahun</label>

                <select name="tahun">

                    @for ($i = now()->year - 2; $i <= now()->year + 1; $i++)

                        <option
                            value="{{ $i }}"
                            {{ $tahun == $i ? 'selected' : '' }}
                        >
                            {{ $i }}
                        </option>

                    @endfor

                </select>

            </div>


            <div class="form-group">

                <label>Kategori</label>

                <select name="kategori_id">

                    <option value="">
                        Semua Kategori
                    </option>

                    @foreach ($kategori as $item)

                        <option
                            value="{{ $item->id }}"
                            {{ $kategoriId == $item->id ? 'selected' : '' }}
                        >
                            {{ $item->nama }}
                        </option>

                    @endforeach

                </select>

            </div>


            <button type="submit">
                Tampilkan
            </button>

        </form>

    </div>


    {{-- PERIODE --}}
    <div class="card">

        <p>
            <strong>Periode:</strong>

            {{ $mulai->format('d-m-Y') }}

            sampai

            {{ $sampai->format('d-m-Y') }}
        </p>

        <p>
            <strong>Dicetak pada:</strong>

            {{ now()->format('d-m-Y H:i') }}
        </p>

    </div>


    {{-- RINCIAN --}}
    <div class="card">

        <div style="
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        ">

            <h3>
                Rincian Pengeluaran
            </h3>

            <button
                type="button"
                class="btn-cetak"
                onclick="window.print()"
            >
                Cetak Laporan
            </button>

        </div>


        <table>

            <thead>

                <tr>

                    <th width="60">
                        No
                    </th>

                    <th>
                        Kategori Pengeluaran
                    </th>

                    <th class="text-end">
                        Total Pengeluaran
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse ($rekap as $index => $item)

                    <tr>

                        <td class="text-center">
                            {{ $index + 1 }}
                        </td>

                        <td>
                            {{ $item['nama'] }}
                        </td>

                        <td class="text-end">
                            Rp {{ number_format(
                                $item['total_pengeluaran'],
                                0,
                                ',',
                                '.'
                            ) }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="3"
                            class="text-center"
                        >
                            Belum ada data pengeluaran.
                        </td>

                    </tr>

                @endforelse

            </tbody>


            <tfoot>

                <tr>

                    <th
                        colspan="2"
                        class="text-end"
                    >
                        TOTAL PENGELUARAN
                    </th>

                    <th class="text-end">

                        Rp {{ number_format(
                            $totalPengeluaran,
                            0,
                            ',',
                            '.'
                        ) }}

                    </th>

                </tr>

            </tfoot>

        </table>

    </div>

</div>

</body>

</html>