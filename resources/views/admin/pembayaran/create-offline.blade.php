<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Pembayaran Offline - Pondok Pesantren Al Asror
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        body {
            background: #f5f7fb;
        }

        .sidebar-wrapper {
            min-height: 100vh;
            position: sticky;
            top: 0;
        }

        .main-content {
            min-height: 100vh;
        }

        .search-result:hover {
            background: #f8f9fa;
        }

        .bill-card {
            border-left: 5px solid #ffc107;
        }

        .bill-card.selected {
            border-left-color: #198754;
        }

        .component-row {
            background: #fff;
        }

        .component-row.selected {
            background: #f0fff6;
        }

        .total-box {
            position: sticky;
            bottom: 15px;
            z-index: 10;
        }

        @media (max-width: 767px) {

            .sidebar-wrapper {
                position: relative;
                min-height: auto;
            }

        }

    </style>

</head>


<body>

<div class="container-fluid">

    <div class="row">


        {{-- SIDEBAR --}}

        <div class="col-md-auto p-0 sidebar-wrapper">

            @include('admin.partials.sidebar')

        </div>


        {{-- CONTENT --}}

        <main class="col p-4 main-content">

            <div class="container-fluid">


                {{-- HEADER --}}

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-body">

                        <h1 class="fw-bold mb-1">
                            Pembayaran Offline
                        </h1>

                        <p class="text-muted mb-0">

                            Cari santri dan catat pembayaran
                            untuk satu atau beberapa periode sekaligus.

                        </p>

                    </div>

                </div>


                {{-- ERROR --}}

                @if ($errors->any())

                    <div class="alert alert-danger shadow-sm">

                        <strong>
                            Terdapat kesalahan:
                        </strong>

                        <ul class="mb-0 mt-2">

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                {{-- SEARCH SANTRI --}}

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-body">

                        <h4 class="fw-bold mb-3">
                            1. Cari Santri
                        </h4>

                        <form
                            method="GET"
                            action="{{ route(
                                'admin.pembayaran.offline.create'
                            ) }}"
                        >

                            <div class="row g-2">

                                <div class="col-md-9">

                                    <label
                                        for="search"
                                        class="form-label"
                                    >
                                        Nama atau NIS
                                    </label>

                                    <input
                                        type="text"
                                        name="search"
                                        id="search"
                                        class="form-control form-control-lg"
                                        value="{{ $search ?? '' }}"
                                        placeholder="Contoh: Ahmad Fauzan"
                                        autofocus
                                    >

                                </div>


                                <div class="col-md-3 d-flex align-items-end">

                                    <button
                                        type="submit"
                                        class="btn btn-primary btn-lg w-100"
                                    >
                                        🔎 Cari Santri
                                    </button>

                                </div>

                            </div>

                        </form>

                        <div class="form-text mt-2">

                            Admin dapat mencari berdasarkan nama
                            sehingga tidak wajib mengetahui NIS.

                        </div>

                    </div>

                </div>


                {{-- HASIL PENCARIAN --}}

                @if (!empty($search))

                    <div class="card border-0 shadow-sm mb-4">

                        <div class="card-body">

                            <h4 class="fw-bold mb-3">
                                2. Pilih Santri
                            </h4>


                            @forelse ($santriHasil as $item)

                                <div class="border rounded p-3 mb-2 search-result">

                                    <div class="row align-items-center">

                                        <div class="col-md-8">

                                            <div class="fw-bold fs-5">

                                                {{ $item->nama }}

                                            </div>

                                            <div class="text-muted">

                                                NIS:
                                                {{ $item->nis }}

                                                |

                                                Kelas:
                                                {{ $item->kelas ?? '-' }}

                                            </div>

                                            <div class="small text-muted">

                                                Wali:
                                                {{ $item->wali->nama ?? '-' }}

                                            </div>

                                        </div>


                                        <div class="col-md-4 text-md-end mt-2 mt-md-0">

                                            <a
                                                href="{{ route(
                                                    'admin.pembayaran.offline.create',
                                                    [
                                                        'santri_id' =>
                                                            $item->id
                                                    ]
                                                ) }}"
                                                class="btn btn-success"
                                            >
                                                Pilih Santri
                                            </a>

                                        </div>

                                    </div>

                                </div>

                            @empty

                                <div class="alert alert-warning mb-0">

                                    Santri dengan kata pencarian
                                    <strong>
                                        {{ $search }}
                                    </strong>
                                    tidak ditemukan.

                                </div>

                            @endforelse

                        </div>

                    </div>

                @endif


                {{-- SANTRI TERPILIH --}}

                @if ($santriTerpilih)

                    <div class="card border-0 shadow-sm mb-4">

                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                                <div>

                                    <div class="text-muted small">
                                        3. Santri Terpilih
                                    </div>

                                    <h3 class="fw-bold mb-1">

                                        {{ $santriTerpilih->nama }}

                                    </h3>

                                    <div class="text-muted">

                                        NIS:
                                        {{ $santriTerpilih->nis }}

                                        |

                                        Kelas:
                                        {{ $santriTerpilih->kelas ?? '-' }}

                                    </div>

                                </div>


                                <a
                                    href="{{ route(
                                        'admin.pembayaran.offline.create'
                                    ) }}"
                                    class="btn btn-outline-secondary"
                                >
                                    Ganti Santri
                                </a>

                            </div>

                        </div>

                    </div>


                    {{-- FORM BAYAR --}}

                    <form
                        action="{{ route(
                            'admin.pembayaran.offline.store'
                        ) }}"
                        method="POST"
                    >

                        @csrf


                        {{-- TUNGGAKAN --}}

                        <div class="card border-0 shadow-sm mb-4">

                            <div class="card-body">

                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">

                                    <div>

                                        <h4 class="fw-bold mb-1">
                                            4. Pilih Tunggakan
                                        </h4>

                                        <p class="text-muted mb-0">

                                            Pilih komponen dari satu atau
                                            beberapa bulan yang ingin
                                            dibayar dalam satu transaksi.

                                        </p>

                                    </div>


                                    @if ($tagihan->count() > 0)

                                        <button
                                            type="button"
                                            id="pilih-semua"
                                            class="btn btn-outline-success"
                                        >
                                            ☑ Pilih Semua Tunggakan
                                        </button>

                                    @endif

                                </div>


                                @forelse ($tagihan as $item)

                                    @php

                                        $totalNominal =
                                            $item->detailTagihan
                                                ->sum('nominal');

                                        $totalDibayar =
                                            $item->hitungTotalDibayar();

                                        $sisaTagihan =
                                            $item->hitungSisa();

                                    @endphp


                                    <div
                                        class="card bill-card mb-3"
                                        data-tagihan="{{ $item->id }}"
                                    >

                                        <div class="card-body">


                                            {{-- HEADER BULAN --}}

                                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">

                                                <div>

                                                    <h5 class="fw-bold mb-1">

                                                        {{ sprintf(
                                                            '%02d',
                                                            $item->periode_bulan
                                                        ) }}

                                                        -
                                                        {{ $item->periode_tahun }}

                                                    </h5>

                                                    <div class="small text-muted">

                                                        Total:
                                                        Rp {{ number_format(
                                                            $totalNominal,
                                                            0,
                                                            ',',
                                                            '.'
                                                        ) }}

                                                        |

                                                        Sudah dibayar:
                                                        Rp {{ number_format(
                                                            $totalDibayar,
                                                            0,
                                                            ',',
                                                            '.'
                                                        ) }}

                                                    </div>

                                                </div>


                                                <div class="text-md-end">

                                                    <div class="small text-muted">
                                                        Sisa
                                                    </div>

                                                    <div class="fw-bold fs-5 text-danger">

                                                        Rp {{ number_format(
                                                            $sisaTagihan,
                                                            0,
                                                            ',',
                                                            '.'
                                                        ) }}

                                                    </div>

                                                </div>

                                            </div>


                                            {{-- PILIH SEMUA BULAN --}}

                                            <div class="form-check mb-3">

                                                <input
                                                    class="form-check-input pilih-bulan"
                                                    type="checkbox"
                                                    id="bulan_{{ $item->id }}"
                                                    data-tagihan="{{ $item->id }}"
                                                >

                                                <label
                                                    class="form-check-label fw-semibold"
                                                    for="bulan_{{ $item->id }}"
                                                >
                                                    Pilih semua komponen pada
                                                    periode ini
                                                </label>

                                            </div>


                                            {{-- KOMPONEN --}}

                                            <div class="table-responsive">

                                                <table class="table table-sm align-middle">

                                                    <thead class="table-light">

                                                        <tr>

                                                            <th width="60">
                                                                Pilih
                                                            </th>

                                                            <th>
                                                                Jenis
                                                            </th>

                                                            <th class="text-end">
                                                                Sisa
                                                            </th>

                                                            <th width="200">
                                                                Nominal Dibayar
                                                            </th>

                                                        </tr>

                                                    </thead>


                                                    <tbody>

                                                        @foreach (
                                                            $item->detailTagihan
                                                            as $detail
                                                        )

                                                            @php

                                                                $sisaDetail =
                                                                    $detail->hitungSisa();

                                                            @endphp


                                                            @if ($sisaDetail > 0)

                                                                <tr
                                                                    class="component-row"
                                                                    data-tagihan="{{ $item->id }}"
                                                                >

                                                                    <td>

                                                                        <input
                                                                            type="checkbox"
                                                                            class="form-check-input detail-check"
                                                                            name="detail_id[]"
                                                                            value="{{ $detail->id }}"
                                                                            data-tagihan="{{ $item->id }}"
                                                                        >

                                                                    </td>


                                                                    <td class="fw-semibold">

                                                                        {{
                                                                            $detail
                                                                                ->jenisTagihan
                                                                                ->nama
                                                                            ?? '-'
                                                                        }}

                                                                    </td>


                                                                    <td class="text-end text-danger">

                                                                        Rp {{ number_format(
                                                                            $sisaDetail,
                                                                            0,
                                                                            ',',
                                                                            '.'
                                                                        ) }}

                                                                    </td>


                                                                    <td>

                                                                        <input
                                                                            type="number"
                                                                            class="form-control nominal-input"
                                                                            name="nominal[{{ $detail->id }}]"
                                                                            data-detail="{{ $detail->id }}"
                                                                            data-sisa="{{ $sisaDetail }}"
                                                                            min="1"
                                                                            max="{{ $sisaDetail }}"
                                                                            step="1"
                                                                            placeholder="Nominal"
                                                                            disabled
                                                                        >

                                                                    </td>

                                                                </tr>

                                                            @endif

                                                        @endforeach

                                                    </tbody>

                                                </table>

                                            </div>

                                        </div>

                                    </div>

                                @empty

                                    <div class="alert alert-success">

                                        Santri ini tidak mempunyai
                                        tunggakan yang belum lunas.

                                    </div>

                                @endforelse

                            </div>

                        </div>


                        {{-- TOTAL --}}

                        @if ($tagihan->count() > 0)

                            <div class="card border-0 shadow-sm total-box mb-4">

                                <div class="card-body">

                                    <div class="row align-items-center">

                                        <div class="col-md-8">

                                            <div class="text-muted">
                                                Total Pembayaran
                                            </div>

                                            <div
                                                class="display-6 fw-bold text-success"
                                                id="total-pembayaran"
                                            >
                                                Rp 0
                                            </div>

                                            <div class="small text-muted">

                                                Total ini akan menjadi
                                                satu transaksi offline.

                                            </div>

                                        </div>


                                        <div class="col-md-4 text-md-end mt-3 mt-md-0">

                                            <button
                                                type="submit"
                                                class="btn btn-success btn-lg"
                                            >
                                                💵 Simpan Pembayaran
                                            </button>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        @endif

                    </form>

                @endif


                <div class="text-muted small mt-4">

                    Sistem Informasi Manajemen Keuangan
                    Pondok Pesantren Al Asror

                </div>

            </div>

        </main>

    </div>

</div>


<script>


    function formatRupiah(angka)
    {

        return new Intl.NumberFormat(
            'id-ID'
        ).format(angka);

    }


    function updateTotal()
    {

        let total = 0;


        document.querySelectorAll(
            '.nominal-input'
        ).forEach(function (input) {

            if (!input.disabled) {

                const nilai =
                    parseFloat(
                        input.value
                    ) || 0;

                total += nilai;

            }

        });


        document.getElementById(
            'total-pembayaran'
        ).textContent =
            'Rp ' +
            formatRupiah(total);

    }


    function updateDetail(
        checkbox
    )
    {

        const detailId =
            checkbox.value;


        const input =
            document.querySelector(
                '.nominal-input[data-detail="' +
                detailId +
                '"]'
            );


        const row =
            checkbox.closest(
                '.component-row'
            );


        if (checkbox.checked) {

            input.disabled = false;

            /*
             * Saat dipilih, otomatis isi dengan
             * seluruh sisa komponen.
             */
            if (!input.value) {

                input.value =
                    input.dataset.sisa;

            }

            row.classList.add(
                'selected'
            );

        } else {

            input.disabled = true;

            input.value = '';

            row.classList.remove(
                'selected'
            );

        }


        updateTotal();

    }


    /*
     * Checkbox per komponen.
     */
    document.querySelectorAll(
        '.detail-check'
    ).forEach(function (checkbox) {

        checkbox.addEventListener(
            'change',
            function () {

                updateDetail(
                    this
                );

            }
        );

    });


    /*
     * Input nominal.
     */
    document.querySelectorAll(
        '.nominal-input'
    ).forEach(function (input) {

        input.addEventListener(
            'input',
            function () {

                const max =
                    parseFloat(
                        this.dataset.sisa
                    );

                let nilai =
                    parseFloat(
                        this.value
                    ) || 0;


                if (nilai > max) {

                    this.value = max;

                }


                updateTotal();

            }
        );

    });


    /*
     * Pilih semua komponen
     * dalam satu bulan.
     */
    document.querySelectorAll(
        '.pilih-bulan'
    ).forEach(function (bulanCheckbox) {

        bulanCheckbox.addEventListener(
            'change',
            function () {

                const tagihanId =
                    this.dataset.tagihan;


                document.querySelectorAll(
                    '.detail-check[data-tagihan="' +
                    tagihanId +
                    '"]'
                ).forEach(function (checkbox) {

                    checkbox.checked =
                        bulanCheckbox.checked;

                    updateDetail(
                        checkbox
                    );

                });

            }
        );

    });


    /*
     * Pilih semua tunggakan
     * seluruh bulan.
     */
    const pilihSemua =
        document.getElementById(
            'pilih-semua'
        );


    if (pilihSemua) {

        pilihSemua.addEventListener(
            'click',
            function () {

                const semuaCheckbox =
                    document.querySelectorAll(
                        '.detail-check'
                    );


                let semuaDipilih = true;

                semuaCheckbox.forEach(
                    function (checkbox) {

                        if (!checkbox.checked) {

                            semuaDipilih = false;

                        }

                    }
                );


                /*
                 * Kalau semuanya sudah dipilih,
                 * klik berikutnya akan membatalkan.
                 */
                const target =
                    !semuaDipilih;


                semuaCheckbox.forEach(
                    function (checkbox) {

                        checkbox.checked =
                            target;

                        updateDetail(
                            checkbox
                        );

                    }
                );


                document.querySelectorAll(
                    '.pilih-bulan'
                ).forEach(
                    function (checkbox) {

                        checkbox.checked =
                            target;

                    }
                );


                pilihSemua.textContent =
                    target
                        ? '☐ Batalkan Semua'
                        : '☑ Pilih Semua Tunggakan';

            }
        );

    }

</script>

</body>

</html>