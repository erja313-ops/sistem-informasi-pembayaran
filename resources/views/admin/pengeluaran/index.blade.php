<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Pengeluaran</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 30px;
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

        h1 {
            margin-top: 0;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            background: #0d6efd;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .success {
            background: #d1e7dd;
            color: #0f5132;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
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
            background: #f1f1f1;
        }

        .text-end {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="card">

        <h1>Data Pengeluaran</h1>

        <p>
            Daftar transaksi pengeluaran pondok.
        </p>

        <a
            href="{{ route('admin.pengeluaran.create') }}"
            class="btn"
        >
            + Tambah Pengeluaran
        </a>

    </div>


    @if (session('success'))

        <div class="success">
            {{ session('success') }}
        </div>

    @endif


    <div class="card">

        <table>

            <thead>

                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Keterangan</th>
                    <th>Nominal</th>
                </tr>

            </thead>

            <tbody>

                @forelse ($pengeluaran as $index => $item)

                    <tr>

                        <td class="text-center">
                            {{ $index + 1 }}
                        </td>

                        <td>
                            {{ $item->tanggal->format('d-m-Y') }}
                        </td>

                        <td>
                            {{ $item->kategori->nama ?? '-' }}
                        </td>

                        <td>
                            {{ $item->keterangan ?? '-' }}
                        </td>

                        <td class="text-end">
                            Rp {{ number_format($item->nominal, 0, ',', '.') }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" class="text-center">
                            Belum ada data pengeluaran.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

</body>

</html>