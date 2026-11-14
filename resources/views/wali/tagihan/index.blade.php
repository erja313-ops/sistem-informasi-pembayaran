<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Tagihan Saya - Wali Santri</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

</head>

<body>

<div class="d-flex">

    @include('wali.partials.sidebar')

    <div class="flex-grow-1 p-4">

        <div class="mb-4">

            <h3 class="fw-bold mb-1">
                Tagihan Santri
            </h3>

            <p class="text-muted mb-0">
                Daftar tagihan yang masih belum lunas atau belum dibayar.
            </p>

        </div>


    <div class="row g-3 mb-4">

        <div class="col-md-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-muted small">
                                Jumlah Tagihan Belum Lunas
                            </div>

                            <h3 class="fw-bold mb-0">
                                {{ $tagihan->total() }}
                            </h3>

                        </div>

                        <i
                            class="bi bi-receipt fs-2 text-warning"
                        ></i>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-muted small">
                                Santri Terdaftar
                            </div>

                            <h3 class="fw-bold mb-0">
                                {{ $santri->count() }}
                            </h3>

                        </div>

                        <i
                            class="bi bi-people-fill fs-2 text-primary"
                        ></i>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-muted small">
                                Informasi
                            </div>

                            <div class="fw-semibold">
                                Periksa rincian sebelum membayar.
                            </div>

                        </div>

                        <i
                            class="bi bi-info-circle-fill fs-2 text-primary"
                        ></i>

                    </div>

                </div>

            </div>

        </div>

    </div>
        
        <!-- FILTER -->

        <div class="card shadow-sm mb-4">

            <div class="card-body">

                <form
                    method="GET"
                    action="{{ route('wali.tagihan.index') }}"
                >

                    <div class="row g-3">

                        <div class="col-md-4">

                            <label class="form-label">
                                Santri
                            </label>

                            <select
                                name="santri_id"
                                class="form-select"
                            >

                                <option value="">
                                    Semua Santri
                                </option>

                                @foreach($santri as $item)

                                    <option
                                        value="{{ $item->id }}"
                                        {{ request('santri_id') == $item->id ? 'selected' : '' }}
                                    >
                                        {{ $item->nama }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="col-md-3">

                            <label class="form-label">
                                Bulan
                            </label>

                            <select
                                name="bulan"
                                class="form-select"
                            >

                                <option value="">
                                    Semua Bulan
                                </option>

                                @foreach(range(1, 12) as $bulanItem)

                                    <option
                                        value="{{ $bulanItem }}"
                                        {{ request('bulan') == $bulanItem ? 'selected' : '' }}
                                    >
                                        {{ \Carbon\Carbon::create()->month($bulanItem)->translatedFormat('F') }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="col-md-3">

                            <label class="form-label">
                                Tahun
                            </label>

                            <select
                                name="tahun"
                                class="form-select"
                            >

                                <option value="">
                                    Semua Tahun
                                </option>

                                @foreach($tahun as $tahunItem)

                                    <option
                                        value="{{ $tahunItem }}"
                                        {{ request('tahun') == $tahunItem ? 'selected' : '' }}
                                    >
                                        {{ $tahunItem }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="col-md-2 d-flex align-items-end">

                            <button
                                type="submit"
                                class="btn btn-primary w-100"
                            >
                                <i class="bi bi-search"></i>
                                Tampilkan
                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>


        <!-- DATA TAGIHAN -->

        <div class="card shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-light">

                            <tr>

                                <th style="width: 50px;">
                                    No
                                </th>

                                <th>
                                    Santri
                                </th>

                                <th>
                                    Periode
                                </th>

                                <th>
                                    Total Tagihan
                                </th>

                                <th>
                                    Dibayar
                                </th>

                                <th>
                                    Sisa
                                </th>

                                <th>
                                    Status
                                </th>

                                <th style="width: 100px;">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($tagihan as $item)

                                <tr>

                                    <td>
                                        {{ $tagihan->firstItem() + $loop->index }}
                                    </td>

                                    <td>

                                        <strong>
                                            {{ $item->santri->nama }}
                                        </strong>

                                        <br>

                                        <small class="text-muted">
                                            NIS {{ $item->santri->nis }}
                                        </small>

                                    </td>

                                    <td>

                                        {{ \Carbon\Carbon::create(
                                            $item->periode_tahun,
                                            $item->periode_bulan,
                                            1
                                        )->translatedFormat('F Y') }}

                                    </td>

                                    <td>

                                        Rp {{ number_format(
                                            $item->detailTagihan->sum('nominal'),
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    </td>

                                    <td>

                                        Rp {{ number_format(
                                            $item->hitungTotalDibayar(),
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    </td>

                                    <td>

                                        <strong>
                                            Rp {{ number_format(
                                                $item->hitungSisa(),
                                                0,
                                                ',',
                                                '.'
                                            ) }}
                                        </strong>

                                    </td>

                                    <td>

                                        @if($item->status === 'sebagian')

                                            <span class="badge text-bg-warning">
                                                Sebagian
                                            </span>

                                        @else

                                            <span class="badge text-bg-danger">
                                                Belum Bayar
                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        <a
                                            href="{{ route('wali.tagihan.show', $item->id) }}"
                                            class="btn btn-sm btn-primary"
                                        >
                                            <i class="bi bi-eye"></i>
                                            Detail
                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="8"
                                        class="text-center py-5"
                                    >

                                        <i
                                            class="bi bi-check-circle-fill text-success fs-1"
                                        ></i>

                                        <p class="mt-3 mb-0">
                                            Tidak ada tagihan yang belum lunas.
                                        </p>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                <div class="mt-3">

                    {{ $tagihan->links() }}

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>