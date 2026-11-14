<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Jenis Tagihan - Al Asror
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

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <h2 class="fw-bold mb-1">
                                    Jenis Tagihan
                                </h2>

                                <p class="text-muted mb-0">
                                    Kelola jenis tagihan pondok.
                                </p>

                            </div>

                            <a
                                href="{{ route('admin.jenis-tagihan.create') }}"
                                class="btn btn-primary"
                            >
                                + Tambah Jenis
                            </a>

                        </div>

                    </div>

                </div>


                @if (session('success'))

                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>

                @endif


                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table table-hover align-middle">

                                <thead class="table-light">

                                    <tr>

                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Keterangan</th>
                                        <th>Pembebanan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @forelse ($jenisTagihan as $index => $item)

                                        <tr>

                                            <td>
                                                {{ $jenisTagihan->firstItem() + $index }}
                                            </td>

                                            <td class="fw-semibold">
                                                {{ $item->nama }}
                                            </td>

                                            <td>
                                                {{ $item->keterangan ?? '-' }}
                                            </td>

                                            <td>
                                                @if($item->is_bulanan)

                                                    <span class="badge text-bg-primary">
                                                        Bulanan
                                                    </span>

                                                @else

                                                    <span class="badge text-bg-info">
                                                        Sekali Bayar
                                                    </span>

                                                @endif
                                            </td>    

                                            <td>

                                                @if ($item->is_active)

                                                    <span class="badge bg-success">
                                                        Aktif
                                                    </span>

                                                @else

                                                    <span class="badge bg-secondary">
                                                        Tidak Aktif
                                                    </span>

                                                @endif

                                            </td>

                                            <td>

                                                <a
                                                    href="{{ route(
                                                        'admin.jenis-tagihan.edit',
                                                        $item->id
                                                    ) }}"
                                                    class="btn btn-warning btn-sm"
                                                >
                                                    Edit
                                                </a>

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td
                                                colspan="5"
                                                class="text-center text-muted py-4"
                                            >
                                                Belum ada jenis tagihan.
                                            </td>

                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>


                        {{ $jenisTagihan->links() }}

                    </div>

                </div>

            </div>

        </main>

    </div>

</div>

</body>

</html>