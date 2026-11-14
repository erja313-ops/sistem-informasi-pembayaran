<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Edit Jenis Tagihan
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

                        <h2 class="fw-bold">
                            Edit Jenis Tagihan
                        </h2>

                        <form
                            method="POST"
                            action="{{ route(
                                'admin.jenis-tagihan.update',
                                $jenisTagihan->id
                            ) }}"
                        >

                            @csrf
                            @method('PUT')


                            <div class="mb-3">

                                <label class="form-label">
                                    Nama
                                </label>

                                <input
                                    type="text"
                                    name="nama"
                                    class="form-control"
                                    value="{{ old(
                                        'nama',
                                        $jenisTagihan->nama
                                    ) }}"
                                    required
                                >

                            </div>


                            <div class="mb-3">

                                <label class="form-label">
                                    Keterangan
                                </label>

                                <textarea
                                    name="keterangan"
                                    class="form-control"
                                    rows="4"
                                >{{ old(
                                    'keterangan',
                                    $jenisTagihan->keterangan
                                ) }}</textarea>

                            </div>


                            <div class="mb-3">

                                <label class="form-label">
                                    Status
                                </label>

                                <select
                                    name="is_active"
                                    class="form-select"
                                >

                                    <option
                                        value="1"
                                        {{ $jenisTagihan->is_active ? 'selected' : '' }}
                                    >
                                        Aktif
                                    </option>

                                    <option
                                        value="0"
                                        {{ !$jenisTagihan->is_active ? 'selected' : '' }}
                                    >
                                        Tidak Aktif
                                    </option>

                                </select>

                            </div>

                            <div class="mb-3">

                                <label class="form-label">
                                    Pembebanan
                                </label>

                                <select
                                    name="is_bulanan"
                                    class="form-select"
                                    required
                                >

                                    <option value="1">
                                        Tagihan Bulanan
                                    </option>

                                    <option value="0">
                                        Sekali Bayar
                                    </option>

                                </select>

                            </div>


                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Simpan Perubahan
                            </button>

                            <a
                                href="{{ route(
                                    'admin.jenis-tagihan.index'
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