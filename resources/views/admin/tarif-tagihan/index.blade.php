<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Tarif Tagihan - Al Asror
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
                                    Tarif Tagihan
                                </h2>

                                <p class="text-muted mb-0">
                                    Kelola tarif berdasarkan tanggal berlaku.
                                </p>

                            </div>

                            <a
                                href="{{ route(
                                    'admin.tarif-tagihan.create'
                                ) }}"
                                class="btn btn-primary"
                            >
                                + Tambah Tarif
                            </a>

                        </div>

                    </div>

                </div>


                @if (session('success'))

                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>

                @endif


                <div class="alert alert-info">

                    <strong>Catatan:</strong>

                    Tarif yang sudah digunakan untuk tagihan lama
                    tidak perlu diubah. Untuk perubahan tarif,
                    tambahkan tarif baru dengan tanggal berlaku baru.

                </div>


                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table table-hover align-middle">

                                <thead class="table-light">

                                    <tr>

                                        <th>No</th>
                                        <th>Jenis Tagihan</th>
                                        <th>Nominal</th>
                                        <th>Berlaku Mulai</th>
                                        <th>Berlaku Sampai</th>
                                        <th>Keterangan</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @forelse ($tarif as $index => $item)

                                        <tr>

                                            <td>
                                                {{ $tarif->firstItem() + $index }}
                                            </td>

                                            <td class="fw-semibold">

                                                {{
                                                    $item
                                                        ->jenisTagihan
                                                        ->nama
                                                    ?? '-'
                                                }}

                                            </td>

                                            <td>

                                                Rp {{ number_format(
                                                    $item->nominal,
                                                    0,
                                                    ',',
                                                    '.'
                                                ) }}

                                            </td>

                                            <td>

                                                {{
                                                    \Carbon\Carbon::parse(
                                                        $item->berlaku_mulai
                                                    )->format('d-m-Y')
                                                }}

                                            </td>

                                            <td>

                                                @if ($item->berlaku_sampai)

                                                    {{
                                                        \Carbon\Carbon::parse(
                                                            $item->berlaku_sampai
                                                        )->format('d-m-Y')
                                                    }}

                                                @else

                                                    <span class="text-muted">
                                                        Tidak dibatasi
                                                    </span>

                                                @endif

                                            </td>

                                            <td>
                                                {{ $item->keterangan ?? '-' }}
                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td
                                                colspan="6"
                                                class="text-center text-muted py-4"
                                            >
                                                Belum ada data tarif.
                                            </td>

                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>


                        {{ $tarif->links() }}

                    </div>

                </div>

            </div>

        </main>

    </div>

</div>

</body>

</html>