<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Bayar Tagihan - Pondok Pesantren Al Asror
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

        .summary-card {
            border-left: 5px solid #198754;
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

        <div class="col-md-auto p-0 sidebar-wrapper">

            @include('wali.partials.sidebar')

        </div>


        <main class="col p-4 main-content">

            <div class="container-fluid">

                {{-- HEADER --}}

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-body">

                        <h1 class="fw-bold mb-1">
                            Bayar Tagihan
                        </h1>

                        <p class="text-muted mb-0">
                            Pilih komponen yang ingin dibayar.
                        </p>

                    </div>

                </div>


                {{-- ERROR --}}

                @if ($errors->any())

                    <div class="alert alert-danger">

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


                {{-- INFORMASI TAGIHAN --}}

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-body">

                        <h4 class="fw-bold mb-3">
                            Informasi Tagihan
                        </h4>

                        <div class="row g-3">

                            <div class="col-md-4">

                                <div class="bg-light rounded p-3">

                                    <div class="text-muted small">
                                        Santri
                                    </div>

                                    <strong>
                                        {{ $tagihan->santri->nama ?? '-' }}
                                    </strong>

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="bg-light rounded p-3">

                                    <div class="text-muted small">
                                        Periode
                                    </div>

                                    <strong>

                                        {{ sprintf(
                                            '%02d',
                                            $tagihan->periode_bulan
                                        ) }}
                                        -
                                        {{ $tagihan->periode_tahun }}

                                    </strong>

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="bg-light rounded p-3">

                                    <div class="text-muted small">
                                        Sisa Tagihan
                                    </div>

                                    <strong class="text-success">

                                        Rp {{ number_format(
                                            $tagihan->hitungSisa(),
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    </strong>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <form
                    action="{{ route(
                        'wali.pembayaran.store',
                        $tagihan->id
                    ) }}"
                    method="POST"
                    enctype="multipart/form-data"
                >

                    @csrf


                    {{-- KOMPONEN --}}

                    <div class="card border-0 shadow-sm mb-4">

                        <div class="card-body">

                            <h4 class="fw-bold mb-3">
                                Komponen yang Dibayar
                            </h4>

                            <div class="table-responsive">

                                <table class="table table-hover align-middle">

                                    <thead class="table-light">

                                        <tr>

                                            <th>
                                                Pilih
                                            </th>

                                            <th>
                                                Jenis Tagihan
                                            </th>

                                            <th class="text-end">
                                                Sisa
                                            </th>

                                            <th>
                                                Nominal Dibayar
                                            </th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        @forelse (
                                            $detailTagihan
                                            as $detail
                                        )

                                            <tr>

                                                <td>

                                                    <input
                                                        type="checkbox"
                                                        class="form-check-input"
                                                        name="detail_id[]"
                                                        value="{{ $detail->id }}"
                                                        onchange="toggleNominal({{ $detail->id }})"
                                                    >

                                                </td>

                                                <td class="fw-semibold">

                                                    {{
                                                        $detail->jenisTagihan->nama
                                                        ?? '-'
                                                    }}

                                                </td>

                                                <td class="text-end">

                                                    Rp {{ number_format(
                                                        $detail->hitungSisa(),
                                                        0,
                                                        ',',
                                                        '.'
                                                    ) }}

                                                </td>

                                                <td>

                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        name="nominal[{{ $detail->id }}]"
                                                        id="nominal_{{ $detail->id }}"
                                                        min="1"
                                                        max="{{ $detail->hitungSisa() }}"
                                                        placeholder="Nominal"
                                                        disabled
                                                    >

                                                </td>

                                            </tr>

                                        @empty

                                            <tr>

                                                <td
                                                    colspan="4"
                                                    class="text-center text-muted py-4"
                                                >

                                                    Tidak ada komponen
                                                    yang dapat dibayar.

                                                </td>

                                            </tr>

                                        @endforelse

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>


                    {{-- METODE --}}

                    <div class="card border-0 shadow-sm mb-4">

                        <div class="card-body">

                            <h4 class="fw-bold mb-3">
                                Metode Pembayaran
                            </h4>

                            <div class="mb-3">

                                <label
                                    for="metode"
                                    class="form-label"
                                >
                                    Pilih Metode
                                </label>

                                <select
                                    name="metode"
                                    id="metode"
                                    class="form-select"
                                    onchange="toggleBukti(); toggleRekening()"
                                    required
                                >

                                    <option value="">
                                        -- Pilih Metode --
                                    </option>

                                    <option value="offline">
                                        Offline
                                    </option>

                                    <option value="transfer">
                                        Transfer
                                    </option>

                                </select>

                            </div>

                            <div>

                                @if($rekeningPondok->count() > 0)

                                    <div
                                        id="rekening-transfer"
                                        class="card border-0 shadow-sm mb-4"
                                        style="display: none;"
                                    >

                                        <div class="card-body">

                                            <div class="d-flex align-items-start gap-3 mb-4">

                                                <div
                                                    class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0"
                                                    style="
                                                        width:48px;
                                                        height:48px;
                                                        background:#e8f5ee;
                                                        color:#198754;
                                                    "
                                                >

                                                    <i class="bi bi-bank fs-4"></i>

                                                </div>

                                                <div>

                                                    <h4 class="fw-bold mb-1">
                                                        Rekening Resmi Pondok
                                                    </h4>

                                                    <p class="text-muted mb-0">
                                                        Silakan transfer ke salah satu rekening
                                                        resmi berikut.
                                                    </p>

                                                </div>

                                            </div>


                                            @foreach($rekeningPondok as $rekening)

                                                <div
                                                    class="border rounded-3 p-3 mb-3"
                                                >

                                                    <div
                                                        class="
                                                            d-flex
                                                            justify-content-between
                                                            align-items-start
                                                            gap-2
                                                            flex-wrap
                                                        "
                                                    >

                                                        <div>

                                                            <div class="text-muted small">
                                                                Bank
                                                            </div>

                                                            <div class="fw-bold fs-5">
                                                                {{ $rekening->bank }}
                                                            </div>

                                                        </div>

                                                        <span class="badge bg-success">
                                                            Aktif
                                                        </span>

                                                    </div>


                                                    {{-- NOMOR REKENING --}}

                                                    <div class="mt-3">

                                                        <div class="text-muted small mb-1">
                                                            Nomor Rekening
                                                        </div>

                                                        <div
                                                            class="
                                                                d-flex
                                                                align-items-center
                                                                gap-2
                                                                flex-wrap
                                                            "
                                                        >

                                                            <strong
                                                                class="fs-5"
                                                            >
                                                                {{ $rekening->nomor_rekening }}
                                                            </strong>

                                                            <button
                                                                type="button"
                                                                class="btn btn-sm btn-outline-primary"
                                                                onclick="copyToClipboard(
                                                                    '{{ $rekening->nomor_rekening }}',
                                                                    'Nomor rekening berhasil disalin.'
                                                                )"
                                                            >

                                                                <i class="bi bi-copy"></i>

                                                                Salin

                                                            </button>

                                                        </div>

                                                    </div>


                                                    {{-- ATAS NAMA --}}

                                                    <div class="mt-3">

                                                        <div class="text-muted small">
                                                            Atas Nama
                                                        </div>

                                                        <div class="fw-semibold">
                                                            {{ $rekening->atas_nama }}
                                                        </div>

                                                    </div>


                                                    @if($rekening->keterangan)

                                                        <div
                                                            class="
                                                                alert
                                                                alert-light
                                                                border
                                                                mt-3
                                                                mb-0
                                                            "
                                                        >

                                                            <i class="bi bi-info-circle"></i>

                                                            {{ $rekening->keterangan }}

                                                        </div>

                                                    @endif

                                                </div>

                                            @endforeach


                                            <div class="alert alert-warning mb-0">

                                                <div class="fw-bold">
                                                    Perhatian
                                                </div>

                                                <div class="small mt-1">
                                                    Pastikan nomor rekening dan nama penerima
                                                    sudah sesuai sebelum melakukan transfer.
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                @endif

                            </div>

                            <div
                                id="bukti-wrapper"
                                class="p-3 bg-light rounded"
                                style="display:none;"
                            >

                                <label
                                    for="bukti_pembayaran"
                                    class="form-label fw-semibold"
                                >
                                    Bukti Pembayaran
                                </label>

                                <input
                                    type="file"
                                    name="bukti_pembayaran"
                                    id="bukti_pembayaran"
                                    class="form-control"
                                    accept=".jpg,.jpeg,.png,.pdf"
                                >

                                <div class="form-text">
                                    JPG, PNG, atau PDF. Maksimal 2 MB.
                                </div>

                            </div>

                            <div class="alert alert-warning mt-3 mb-0">

                                <strong>
                                    Catatan:
                                </strong>

                                Untuk transfer, bukti pembayaran wajib
                                diunggah dan transaksi akan menunggu
                                verifikasi admin.

                            </div>

                        </div>

                    </div>


                    {{-- TOMBOL --}}

                    <div class="d-flex gap-2 flex-wrap">

                        <a
                            href="{{ route(
                                'wali.tagihan.show',
                                $tagihan->id
                            ) }}"
                            class="btn btn-secondary"
                        >
                            Kembali
                        </a>

                        <button
                            type="submit"
                            class="btn btn-success"
                        >
                            💳 Kirim Pembayaran
                        </button>

                    </div>

                </form>


                <div class="text-muted small mt-4">

                    Sistem Informasi Manajemen Keuangan
                    Pondok Pesantren Al Asror

                </div>

            </div>

        </main>

    </div>

</div>


<script>

    function toggleNominal(id) {

        const checkbox =
            document.querySelector(
                'input[name="detail_id[]"][value="' + id + '"]'
            );

        const nominal =
            document.getElementById(
                'nominal_' + id
            );

        if (checkbox.checked) {

            nominal.disabled = false;
            nominal.required = true;

        } else {

            nominal.disabled = true;
            nominal.required = false;
            nominal.value = '';

        }

    }


    function toggleBukti() {

        const metode =
            document.getElementById('metode').value;

        const wrapper =
            document.getElementById('bukti-wrapper');

        const bukti =
            document.getElementById('bukti_pembayaran');

        if (metode === 'transfer') {

            wrapper.style.display = 'block';
            bukti.required = true;

        } else {

            wrapper.style.display = 'none';
            bukti.required = false;
            bukti.value = '';

        }

    } 

    
    function toggleRekening() {

        const metode =
            document.getElementById('metode');

        const rekeningTransfer =
            document.getElementById(
                'rekening-transfer'
            );


        if (
            !metode ||
            !rekeningTransfer
        ) {
            return;
        }


        if (
            metode.value === 'transfer'
        ) {

            rekeningTransfer.style.display =
                'block';

        } else {

            rekeningTransfer.style.display =
                'none';

        }

    }

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            toggleRekening();

        }
    );

    
    function copyToClipboard(
        text,
        message
    ) {

        if (
            navigator.clipboard &&
            window.isSecureContext
        ) {

            navigator.clipboard
                .writeText(text)
                .then(function () {

                    alert(message);

                })
                .catch(function () {

                    fallbackCopy(
                        text,
                        message
                    );

                });

            return;
        }


        fallbackCopy(
            text,
            message
        );

    }


    function fallbackCopy(
        text,
        message
    ) {

        const textarea =
            document.createElement(
                'textarea'
            );


        textarea.value = text;

        textarea.style.position =
            'fixed';

        textarea.style.left =
            '-9999px';


        document.body.appendChild(
            textarea
        );


        textarea.focus();
        textarea.select();


        try {

            document.execCommand(
                'copy'
            );

            alert(message);

        } catch (error) {

            prompt(
                'Salin teks berikut:',
                text
            );

        }


        document.body.removeChild(
            textarea
        );

    }


</script>
</body>

</html>