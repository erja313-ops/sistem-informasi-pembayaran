<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Tambah Tarif Tagihan
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body class="bg-light">

<div class="container-fluid">

    <div class="row">

        <div class="col-md-auto p-0">

            @include('admin.partials.sidebar')

        </div>


        <main class="col p-4">

            <div class="container-fluid">


                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <h2 class="fw-bold mb-4">
                            Tambah Tarif Tagihan
                        </h2>


                        @if ($errors->any())

                            <div class="alert alert-danger">

                                <ul class="mb-0">

                                    @foreach ($errors->all() as $error)

                                        <li>
                                            {{ $error }}
                                        </li>

                                    @endforeach

                                </ul>

                            </div>

                        @endif


                        <form
                            method="POST"
                            action="{{ route(
                                'admin.tarif-tagihan.store'
                            ) }}"
                        >

                            @csrf


                            <div class="mb-3">

                                <label class="form-label">
                                    Jenis Tagihan
                                </label>

                                <select
                                    name="jenis_tagihan_id"
                                    class="form-select"
                                    required
                                >

                                    <option value="">
                                        -- Pilih Jenis --
                                    </option>

                                    @foreach (
                                        $jenisTagihan
                                        as $item
                                    )

                                        <option
                                            value="{{ $item->id }}"
                                            {{ old('jenis_tagihan_id') == $item->id ? 'selected' : '' }}
                                        >

                                            {{ $item->nama }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            <div class="mb-3">

                                <label class="form-label">
                                    Nominal
                                </label>

                                <input
                                    type="number"
                                    name="nominal"
                                    class="form-control"
                                    min="0"
                                    step="1"
                                    value="{{ old('nominal') }}"
                                    placeholder="Contoh: 350000"
                                    required
                                >

                            </div>


                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Berlaku Mulai
                                    </label>

                                    <input
                                        type="date"
                                        name="berlaku_mulai"
                                        class="form-control"
                                        value="{{ old('berlaku_mulai') }}"
                                        required
                                    >

                                </div>


                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Berlaku Sampai
                                    </label>

                                    <input
                                        type="date"
                                        name="berlaku_sampai"
                                        class="form-control"
                                        value="{{ old('berlaku_sampai') }}"
                                    >

                                    <div class="form-text">

                                        Kosongkan jika tarif
                                        belum memiliki tanggal akhir.

                                    </div>

                                </div>

                            </div>


                            <div class="mb-4">

                                <label class="form-label">
                                    Keterangan
                                </label>

                                <textarea
                                    name="keterangan"
                                    class="form-control"
                                    rows="3"
                                >{{ old('keterangan') }}</textarea>

                            </div>


                            <button
                                type="submit"
                                class="btn btn-success"
                            >
                                Simpan Tarif
                            </button>

                            <a
                                href="{{ route(
                                    'admin.tarif-tagihan.index'
                                ) }}"
                                class="btn btn-secondary"
                            >
                                Kembali
                            </a>

                        </form>

                    </div>

                </div>

            </div>

        </main>

    </div>

</div>

</body>

</html>