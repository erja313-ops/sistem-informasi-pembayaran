<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Edit Rekening</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body>

@include('admin.partials.sidebar')

<div class="container-fluid py-4 px-3 px-md-4">

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <h2 class="fw-bold mb-4">
                Edit Rekening Pondok
            </h2>

            @if($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <form
                action="{{ route(
                    'admin.rekening.update',
                    $rekening->id
                ) }}"
                method="POST"
            >

                @csrf

                @method('PUT')


                <div class="mb-3">

                    <label class="form-label">
                        Nama Bank
                    </label>

                    <input
                        type="text"
                        name="bank"
                        class="form-control"
                        value="{{ old(
                            'bank',
                            $rekening->bank
                        ) }}"
                        required
                    >

                </div>


                <div class="mb-3">

                    <label class="form-label">
                        Nomor Rekening
                    </label>

                    <input
                        type="text"
                        name="nomor_rekening"
                        class="form-control"
                        value="{{ old(
                            'nomor_rekening',
                            $rekening->nomor_rekening
                        ) }}"
                        required
                    >

                </div>


                <div class="mb-3">

                    <label class="form-label">
                        Atas Nama
                    </label>

                    <input
                        type="text"
                        name="atas_nama"
                        class="form-control"
                        value="{{ old(
                            'atas_nama',
                            $rekening->atas_nama
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
                        rows="3"
                    >{{ old(
                        'keterangan',
                        $rekening->keterangan
                    ) }}</textarea>

                </div>


                <div class="form-check mb-4">

                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        class="form-check-input"
                        id="is_active"
                        {{ $rekening->is_active
                            ? 'checked'
                            : '' }}
                    >

                    <label
                        class="form-check-label"
                        for="is_active"
                    >
                        Rekening aktif
                    </label>

                </div>


                <div class="d-flex gap-2">

                    <a
                        href="{{ route(
                            'admin.rekening.index'
                        ) }}"
                        class="btn btn-secondary"
                    >
                        Kembali
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

</body>
</html>