<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Pembayaran Berhasil - Al Asror
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>

        body {

            margin: 0;

            min-height: 100vh;

            background:
                linear-gradient(
                    135deg,
                    #f0fdf4,
                    #f8fafc
                );

            font-family:
                Arial,
                Helvetica,
                sans-serif;

        }

        .confirmation-wrapper {

            min-height: 100vh;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 24px;

        }

        .confirmation-card {

            width: 100%;

            max-width: 650px;

            background: #ffffff;

            border-radius: 22px;

            box-shadow:
                0 20px 55px
                rgba(15, 23, 42, .12);

            overflow: hidden;

        }

        .confirmation-header {

            text-align: center;

            padding: 35px 25px 25px;

        }

        .success-icon {

            width: 74px;

            height: 74px;

            margin: 0 auto 20px;

            border-radius: 50%;

            display: flex;

            align-items: center;

            justify-content: center;

            background: #d1e7dd;

            color: #198754;

            font-size: 35px;

        }

        .confirmation-header h1 {

            margin: 0 0 8px;

            font-size: 28px;

            font-weight: 800;

            color: #111827;

        }

        .confirmation-header p {

            margin: 0;

            color: #6b7280;

            line-height: 1.6;

        }

        .status-box {

            margin: 0 25px 20px;

            padding: 16px;

            border-radius: 14px;

            background: #fff3cd;

            border: 1px solid #ffe69c;

            text-align: center;

        }

        .status-box .status-title {

            font-size: 13px;

            color: #664d03;

            margin-bottom: 5px;

        }

        .status-box .status-text {

            font-size: 18px;

            font-weight: 800;

            color: #664d03;

        }

        .transaction-section {

            padding: 5px 25px 25px;

        }

        .transaction-item {

            padding: 15px 16px;

            margin-bottom: 10px;

            border-radius: 12px;

            background: #f8fafc;

        }

        .transaction-label {

            font-size: 12px;

            color: #6b7280;

            margin-bottom: 5px;

        }

        .transaction-value {

            font-weight: 700;

            color: #111827;

            word-break: break-word;

        }

        .kode-wrapper {

            display: flex;

            align-items: center;

            gap: 10px;

            flex-wrap: wrap;

        }

        .kode-transaksi {

            font-size: 18px;

            letter-spacing: .5px;

            color: #198754;

        }

        .copy-button {

            border: 1px solid #198754;

            background: #ffffff;

            color: #198754;

            border-radius: 8px;

            padding: 7px 10px;

            cursor: pointer;

            font-weight: 700;

        }

        .copy-button:hover {

            background: #198754;

            color: #ffffff;

        }

        .info-box {

            margin-top: 15px;

            padding: 15px 16px;

            border-radius: 12px;

            background: #eef7ff;

            border: 1px solid #cfe2ff;

            color: #084298;

            line-height: 1.6;

        }

        .action-section {

            padding: 0 25px 30px;

        }

        .action-section .btn {

            min-height: 46px;

        }

        @media (max-width: 576px) {

            .confirmation-wrapper {

                padding: 12px;

            }

            .confirmation-header h1 {

                font-size: 23px;

            }

            .confirmation-header {

                padding-top: 28px;

            }

            .transaction-section,

            .action-section {

                padding-left: 18px;

                padding-right: 18px;

            }

            .status-box {

                margin-left: 18px;

                margin-right: 18px;

            }

        }

    </style>

</head>


<body>

<div class="confirmation-wrapper">

    <div class="confirmation-card">

        {{-- HEADER --}}

        <div class="confirmation-header">

            <div class="success-icon">

                <i class="bi bi-check-lg"></i>

            </div>


            <h1>
                Pembayaran Berhasil Dikirim
            </h1>


            <p>

                Data pembayaran telah berhasil
                masuk ke dalam sistem.

            </p>

        </div>


        {{-- STATUS --}}

        <div class="status-box">

            <div class="status-title">

                Status Pembayaran

            </div>

            <div class="status-text">

                Menunggu Verifikasi Admin

            </div>

        </div>


        {{-- INFORMASI TRANSAKSI --}}

        <div class="transaction-section">

            <div class="transaction-item">

                <div class="transaction-label">

                    Kode Transaksi

                </div>


                <div class="kode-wrapper">

                    <div
                        class="transaction-value kode-transaksi"
                        id="kodeTransaksi"
                    >
                        {{ $pembayaran->kode_transaksi }}
                    </div>


                    <button
                        type="button"
                        class="copy-button"
                        onclick="copyKodeTransaksi()"
                    >

                        <i class="bi bi-copy"></i>

                        Salin

                    </button>

                </div>

            </div>


            <div class="transaction-item">

                <div class="transaction-label">

                    Metode Pembayaran

                </div>


                <div class="transaction-value">

                    {{ ucfirst(
                        $pembayaran->metode
                    ) }}

                </div>

            </div>


            <div class="transaction-item">

                <div class="transaction-label">

                    Total Pembayaran

                </div>


                <div class="transaction-value">

                    Rp
                    {{
                        number_format(
                            $pembayaran->total_transfer,
                            0,
                            ',',
                            '.'
                        )
                    }}

                </div>

            </div>


            <div class="transaction-item">

                <div class="transaction-label">

                    Tanggal Pembayaran

                </div>


                <div class="transaction-value">

                    {{
                        \Carbon\Carbon::parse(
                            $pembayaran->tanggal_bayar
                        )->format(
                            'd-m-Y H:i'
                        )
                    }}

                </div>

            </div>


            <div class="info-box">

                <strong>
                    <i class="bi bi-info-circle"></i>
                    Informasi
                </strong>

                <br>

                Pembayaran belum dinyatakan lunas.
                Admin akan memeriksa bukti pembayaran
                dan melakukan verifikasi terlebih dahulu.

            </div>

        </div>


        {{-- ACTION --}}

        <div class="action-section">

            <div class="d-grid gap-2">

                <a
                    href="{{
                        route(
                            'wali.pembayaran.show',
                            $pembayaran->id
                        )
                    }}"
                    class="btn btn-success"
                >

                    <i class="bi bi-receipt"></i>

                    Lihat Detail Pembayaran

                </a>


                <a
                    href="{{
                        route(
                            'wali.pembayaran.riwayat'
                        )
                    }}"
                    class="btn btn-outline-secondary"
                >

                    <i class="bi bi-clock-history"></i>

                    Riwayat Pembayaran

                </a>


                <a
                    href="{{
                        route(
                            'wali.dashboard'
                        )
                    }}"
                    class="btn btn-outline-primary"
                >

                    <i class="bi bi-house"></i>

                    Kembali ke Dashboard

                </a>

            </div>

        </div>

    </div>

</div>


<script>

function copyKodeTransaksi() {

    const kode =
        document.getElementById(
            'kodeTransaksi'
        ).innerText.trim();


    if (
        navigator.clipboard &&
        window.isSecureContext
    ) {

        navigator.clipboard
            .writeText(kode)
            .then(function () {

                showCopyMessage();

            })
            .catch(function () {

                fallbackCopyKode(kode);

            });

        return;
    }


    fallbackCopyKode(kode);

}


function fallbackCopyKode(kode) {

    const textarea =
        document.createElement(
            'textarea'
        );


    textarea.value = kode;

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

        showCopyMessage();

    } catch (error) {

        prompt(
            'Salin kode transaksi:',
            kode
        );

    }


    document.body.removeChild(
        textarea
    );

}


function showCopyMessage() {

    alert(
        'Kode transaksi berhasil disalin.'
    );

}

</script>

</body>

</html>