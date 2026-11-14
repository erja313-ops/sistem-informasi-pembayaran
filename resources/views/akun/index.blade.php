<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <title>Profil Akun - Pesantren Al Asror</title>

    <style>
        * { box-sizing: border-box; }

        .account-page {
            min-height: 100vh;
            padding: 32px;
            background: #f8f9fa;
        }

        .account-container {
            width: min(100%, 820px);
            margin: 0 auto;
        }

        .account-header {
            margin-bottom: 22px;
        }

        .account-header h1 {
            margin: 0 0 5px;
            color: #212529;
            font-size: clamp(1.55rem, 3vw, 2rem);
            font-weight: 700;
        }

        .account-header p {
            margin: 0;
            color: #6c757d;
        }

        .account-card {
            overflow: hidden;
            border: 0;
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.08);
        }

        .account-banner {
            padding: 30px;
            background: linear-gradient(135deg, #146c43, #198754);
            color: #fff;
        }

        .identity {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .avatar {
            width: 64px;
            height: 64px;
            flex: 0 0 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.25);
            font-size: 25px;
            font-weight: 700;
        }

        .identity h2 {
            margin: 0 0 4px;
            font-size: 1.3rem;
            font-weight: 700;
        }

        .identity p {
            margin: 0;
            color: rgba(255,255,255,.82);
            font-size: .92rem;
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 8px;
            padding: 5px 10px;
            border-radius: 999px;
            background: rgba(255,255,255,.13);
            color: #fff;
            font-size: .78rem;
            font-weight: 700;
        }

        .account-body {
            padding: 30px;
        }

        .section-title {
            margin-bottom: 15px;
            color: #212529;
            font-size: 1rem;
            font-weight: 700;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .info-item {
            min-width: 0;
            padding: 16px;
            border: 1px solid #e9ecef;
            border-radius: 13px;
            background: #fbfcfc;
        }

        .info-label {
            margin-bottom: 5px;
            color: #6c757d;
            font-size: .78rem;
            font-weight: 600;
        }

        .info-value {
            color: #212529;
            font-size: .94rem;
            font-weight: 600;
            word-break: break-word;
        }

        .account-note {
            margin-top: 20px;
            padding: 13px 14px;
            border-radius: 11px;
            background: #f8faf9;
            color: #6c757d;
            font-size: .84rem;
            line-height: 1.6;
        }

        .account-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 24px;
        }

        .account-actions .btn {
            min-height: 44px;
            padding-left: 16px;
            padding-right: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-radius: 10px;
            font-weight: 700;
        }

        @media (max-width: 700px) {
            .account-page {
                padding: 22px;
            }

            .account-banner,
            .account-body {
                padding: 24px;
            }
        }

        @media (max-width: 520px) {
            .account-page {
                padding: 14px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .identity {
                align-items: flex-start;
            }

            .account-actions {
                flex-direction: column;
            }

            .account-actions .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>

@if ($user->role === 'admin')
    @include('admin.partials.sidebar')
@else
    @include('wali.partials.sidebar')
@endif

<main class="account-page">
    <div class="account-container">

        <div class="account-header">
            <h1>Profil Akun</h1>
            <p>Informasi akun yang sedang digunakan untuk mengakses sistem.</p>
        </div>

        <div class="account-card">

            <div class="account-banner">
                <div class="identity">
                    <div class="avatar">
                        {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                    </div>

                    <div>
                        <h2>{{ $user->name }}</h2>
                        <p>{{ $user->username }}</p>

                        <div class="role-badge">
                            <i class="bi bi-shield-check"></i>
                            {{ $user->role === 'admin' ? 'Administrator' : 'Wali Santri' }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="account-body">
                <div class="section-title">Informasi Akun</div>

                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Nama</div>
                        <div class="info-value">{{ $user->name }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Username</div>
                        <div class="info-value">{{ $user->username }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Hak Akses</div>
                        <div class="info-value">
                            {{ $user->role === 'admin' ? 'Administrator' : 'Wali Santri' }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Status Akun</div>
                        <div class="info-value">
                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                        </div>
                    </div>

                    @if ($user->role === 'wali' && $user->wali)
                        <div class="info-item">
                            <div class="info-label">Jumlah Santri</div>
                            <div class="info-value">
                                {{ $user->wali->santri->count() }} Santri
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">No. HP</div>
                            <div class="info-value">
                                {{ $user->wali->no_hp ?: '-' }}
                            </div>
                        </div>
                    @endif
                </div>

                @if ($user->role === 'wali')
                    <div class="account-note">
                        Username digunakan untuk login dan perubahan username dikelola oleh Admin.
                        Password dapat diganti sendiri melalui menu Ganti Password.
                    </div>
                @else
                    <div class="account-note">
                        Halaman ini digunakan untuk melihat identitas akun Admin.
                        Penggantian password tersedia melalui menu Ganti Password.
                    </div>
                @endif

                <div class="account-actions">
                    <a
                        href="{{ route('akun.password.edit') }}"
                        class="btn btn-success"
                    >
                        <i class="bi bi-shield-lock-fill"></i>
                        Ganti Password
                    </a>

                    @if ($user->role === 'admin')
                        <a
                            href="{{ route('admin.dashboard') }}"
                            class="btn btn-light border"
                        >
                            <i class="bi bi-arrow-left"></i>
                            Kembali
                        </a>
                    @else
                        <a
                            href="{{ route('wali.dashboard') }}"
                            class="btn btn-light border"
                        >
                            <i class="bi bi-arrow-left"></i>
                            Kembali
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>

</body>
</html>
