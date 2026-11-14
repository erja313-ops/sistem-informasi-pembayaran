<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan Keuangan</title>

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

        .ringkasan {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .box {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 25px;
            text-align: center;
        }

        .box h3 {
            margin-top: 0;
        }

        .nominal {
            font-size: 25px;
            font-weight: bold;
        }

        .text-end {
            text-align: right;
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

            .ringkasan {
                grid-template-columns: repeat(3, 1fr);
            }

        }

        @media (max-width: 700px) {

            .ringkasan {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>

<body>

<div class="container">

    {{-- KOP --}}
    <div class="card">

        <div class="kop-laporan">

            <h1>PONDOK PESANTREN AL ASROR</h1>

            <h2>LAPORAN KEUANGAN</h2>

            <p>
                Rekapitulasi pemasukan dan pengeluaran
            </p>

        </div>

    </div>


    {{-- FILTER --}}
    <div class="card">

        <h3>Filter Periode Laporan</h3>

        <form
            action="{{ route('laporan.keuangan') }}"
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


    {{-- RINGKASAN --}}
    <div class="card">

        <div style="
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        ">

            <h3>
                Ringkasan Keuangan
            </h3>

            <button
                type="button"
                class="btn-cetak"
                onclick="window.print()"
            >
                Cetak Laporan
            </button>

        </div>


        <div class="ringkasan">

            {{-- PEMASUKAN --}}
            <div class="box">

                <h3>
                    Total Pemasukan
                </h3>

                <div class="nominal">

                    Rp {{ number_format(
                        $ringkasan['pemasukan'],
                        0,
                        ',',
                        '.'
                    ) }}

                </div>

            </div>


            {{-- PENGELUARAN --}}
            <div class="box">

                <h3>
                    Total Pengeluaran
                </h3>

                <div class="nominal">

                    Rp {{ number_format(
                        $ringkasan['pengeluaran'],
                        0,
                        ',',
                        '.'
                    ) }}

                </div>

            </div>


            {{-- SALDO --}}
            <div class="box">

                <h3>
                    Saldo
                </h3>

                <div class="nominal">

                    Rp {{ number_format(
                        $ringkasan['saldo'],
                        0,
                        ',',
                        '.'
                    ) }}

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>