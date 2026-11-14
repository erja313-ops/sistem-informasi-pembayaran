<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Pengeluaran</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 700px;
            margin: auto;
        }

        .card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        textarea {
            min-height: 100px;
        }

        button,
        .btn-kembali {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        button {
            background: #0d6efd;
            color: white;
        }

        .btn-kembali {
            background: #6c757d;
            color: white;
        }

        .error {
            color: #b02a37;
            margin-bottom: 15px;
        }

    </style>

</head>

<body>

<div class="container">

    <div class="card">

        <h1>Tambah Pengeluaran</h1>

        <p>
            Masukkan data pengeluaran pondok.
        </p>


        @if ($errors->any())

            <div class="error">

                <strong>Terdapat kesalahan:</strong>

                <ul>

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        <form
            action="{{ route('admin.pengeluaran.store') }}"
            method="POST"
        >

            @csrf


            <div class="form-group">

                <label for="kategori_id">
                    Kategori Pengeluaran
                </label>

                <select
                    name="kategori_id"
                    id="kategori_id"
                    required
                >

                    <option value="">
                        -- Pilih Kategori --
                    </option>

                    @foreach ($kategori as $item)

                        <option
                            value="{{ $item->id }}"
                            {{ old('kategori_id') == $item->id ? 'selected' : '' }}
                        >
                            {{ $item->nama }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div class="form-group">

                <label for="tanggal">
                    Tanggal
                </label>

                <input
                    type="date"
                    name="tanggal"
                    id="tanggal"
                    value="{{ old('tanggal', now()->format('Y-m-d')) }}"
                    required
                >

            </div>


            <div class="form-group">

                <label for="nominal">
                    Nominal
                </label>

                <input
                    type="number"
                    name="nominal"
                    id="nominal"
                    min="1"
                    value="{{ old('nominal') }}"
                    placeholder="Contoh: 100000"
                    required
                >

            </div>


            <div class="form-group">

                <label for="keterangan">
                    Keterangan
                </label>

                <textarea
                    name="keterangan"
                    id="keterangan"
                    placeholder="Contoh: Pembelian alat kebersihan"
                >{{ old('keterangan') }}</textarea>

            </div>


            <a
                href="{{ route('admin.pengeluaran.index') }}"
                class="btn-kembali"
            >
                Kembali
            </a>

            <button type="submit">
                Simpan Pengeluaran
            </button>

        </form>

    </div>

</div>

</body>

</html>