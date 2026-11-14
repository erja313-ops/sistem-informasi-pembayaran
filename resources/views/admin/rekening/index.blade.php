<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Rekening Pondok</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body>

@include('admin.partials.sidebar')

<div class="container-fluid py-4 px-3 px-md-4">

    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    <div
        class="
            d-flex
            justify-content-between
            align-items-center
            flex-wrap
            gap-2
            mb-4
        "
    >

        <div>

            <h2 class="fw-bold mb-1">
                Rekening Pondok
            </h2>

            <p class="text-muted mb-0">
                Kelola rekening resmi untuk pembayaran transfer.
            </p>

        </div>

        <a
            href="{{ route('admin.rekening.create') }}"
            class="btn btn-success"
        >
            <i class="bi bi-plus-circle"></i>
            Tambah Rekening
        </a>

    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th>No</th>
                            <th>Bank</th>
                            <th>Nomor Rekening</th>
                            <th>Atas Nama</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($rekening as $index => $item)

                        <tr>

                            <td>
                                {{ $index + 1 }}
                            </td>

                            <td>
                                <strong>
                                    {{ $item->bank }}
                                </strong>
                            </td>

                            <td>
                                {{ $item->nomor_rekening }}
                            </td>

                            <td>
                                {{ $item->atas_nama }}
                            </td>

                            <td>

                                @if($item->is_active)

                                    <span class="badge bg-success">
                                        Aktif
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        Nonaktif
                                    </span>

                                @endif

                            </td>

                            <td>
                                {{ $item->keterangan ?? '-' }}
                            </td>

                            <td>

                                <div class="d-flex gap-1 flex-wrap">

                                    <a
                                        href="{{ route(
                                            'admin.rekening.edit',
                                            $item->id
                                        ) }}"
                                        class="btn btn-sm btn-primary"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route(
                                            'admin.rekening.toggle',
                                            $item->id
                                        ) }}"
                                        method="POST"
                                    >

                                        @csrf

                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="btn btn-sm
                                            {{ $item->is_active
                                                ? 'btn-warning'
                                                : 'btn-success' }}"
                                        >

                                            {{ $item->is_active
                                                ? 'Nonaktifkan'
                                                : 'Aktifkan' }}

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="text-center text-muted py-4"
                            >
                                Belum ada rekening pondok.
                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</body>
</html>