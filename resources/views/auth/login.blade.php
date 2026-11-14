<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <title>Login - Pesantren Al Asror</title>

    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            min-height: 100%;
        }

        body {
            margin: 0;
            font-family:
                Inter,
                "Segoe UI",
                Roboto,
                Helvetica,
                Arial,
                sans-serif;
            background:
                radial-gradient(circle at top left, rgba(25, 135, 84, 0.14), transparent 34%),
                radial-gradient(circle at bottom right, rgba(25, 135, 84, 0.10), transparent 30%),
                #eef3f0;
            color: #1f2937;
        }

        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 28px;
        }

        .login-card {
            width: min(100%, 980px);
            min-height: 590px;
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            overflow: hidden;
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 22px 60px rgba(15, 23, 42, 0.14);
        }

        /* Panel identitas pesantren.
           Nanti foto pesantren bisa dipasang di bagian ini
           tanpa mengubah struktur form login. */
        .brand-panel {
            position: relative;
            display: flex;
            align-items: flex-end;
            padding: 44px;
            overflow: hidden;
            color: #ffffff;
            background:
                linear-gradient(
                    145deg,
                    rgba(17, 104, 64, 0.96),
                    rgba(25, 135, 84, 0.92)
                );
        }

        .brand-panel::before,
        .brand-panel::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }

        .brand-panel::before {
            width: 360px;
            height: 360px;
            top: -150px;
            right: -130px;
            border: 1px solid rgba(255, 255, 255, 0.13);
            box-shadow:
                0 0 0 34px rgba(255, 255, 255, 0.045),
                0 0 0 68px rgba(255, 255, 255, 0.025);
        }

        .brand-panel::after {
            width: 220px;
            height: 220px;
            bottom: -130px;
            left: -80px;
            background: rgba(255, 255, 255, 0.06);
        }

        .brand-content {
            position: relative;
            z-index: 2;
            max-width: 520px;
        }

        .brand-icon {
            width: 58px;
            height: 58px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.12);
            font-size: 28px;
        }

        .brand-content h1 {
            margin: 0 0 12px;
            font-size: clamp(2rem, 4vw, 3rem);
            line-height: 1.1;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .brand-content p {
            margin: 0;
            max-width: 460px;
            font-size: 1rem;
            line-height: 1.75;
            color: rgba(255, 255, 255, 0.88);
        }

        .brand-note {
            margin-top: 22px;
            font-size: 0.86rem;
            color: rgba(255, 255, 255, 0.72);
        }

        .form-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 50px;
            background: #ffffff;
        }

        .form-wrapper {
            width: min(100%, 390px);
        }

        .welcome-text {
            margin-bottom: 30px;
        }

        .welcome-text .small-title {
            margin-bottom: 7px;
            color: #198754;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
        }

        .welcome-text h2 {
            margin: 0 0 8px;
            font-size: clamp(1.8rem, 3vw, 2.2rem);
            color: #111827;
            font-weight: 700;
        }

        .welcome-text p {
            margin: 0;
            color: #6b7280;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .error-box {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 22px;
            padding: 13px 14px;
            border: 1px solid #f1b0b7;
            border-radius: 12px;
            background: #fff2f3;
            color: #842029;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .error-box i {
            margin-top: 1px;
            flex: 0 0 auto;
        }

        .form-group {
            margin-bottom: 19px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #374151;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .input-wrapper {
            position: relative;
        }

        .form-control {
            width: 100%;
            height: 50px;
            padding: 0 14px;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            outline: none;
            background: #ffffff;
            color: #111827;
            font-size: 0.95rem;
            transition:
                border-color 0.2s ease,
                box-shadow 0.2s ease,
                background 0.2s ease;
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        .form-control:focus {
            border-color: #198754;
            box-shadow: 0 0 0 4px rgba(25, 135, 84, 0.12);
        }

        .password-input {
            padding-right: 48px;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 7px;
            width: 36px;
            height: 36px;
            transform: translateY(-50%);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 0;
            border-radius: 9px;
            background: transparent;
            color: #6b7280;
            cursor: pointer;
            font-size: 18px;
            transition:
                background 0.2s ease,
                color 0.2s ease;
        }

        .toggle-password:hover,
        .toggle-password:focus-visible {
            background: #eef7f2;
            color: #198754;
            outline: none;
        }

        .forgot-row {
            display: flex;
            justify-content: flex-end;
            margin-top: -5px;
            margin-bottom: 24px;
        }

        .forgot-link {
            border: 0;
            padding: 0;
            background: transparent;
            color: #198754;
            font-size: 0.88rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }

        .forgot-link:hover {
            color: #12663f;
            text-decoration: underline;
        }

        .login-button {
            width: 100%;
            min-height: 50px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            border: 0;
            border-radius: 12px;
            background: #198754;
            color: #ffffff;
            font-size: 0.96rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 9px 20px rgba(25, 135, 84, 0.20);
            transition:
                transform 0.2s ease,
                background 0.2s ease,
                box-shadow 0.2s ease;
        }

        .login-button:hover {
            background: #157347;
            transform: translateY(-1px);
            box-shadow: 0 12px 24px rgba(25, 135, 84, 0.24);
        }

        .login-button:focus-visible {
            outline: 3px solid rgba(25, 135, 84, 0.22);
            outline-offset: 2px;
        }

        .login-footer {
            margin-top: 26px;
            color: #9ca3af;
            font-size: 0.78rem;
            line-height: 1.5;
            text-align: center;
        }

        /* Modal lupa password */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 100;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: rgba(17, 24, 39, 0.52);
        }

        .modal-backdrop.show {
            display: flex;
        }

        .help-modal {
            width: min(100%, 430px);
            padding: 26px;
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 24px 70px rgba(0, 0, 0, 0.20);
        }

        .help-icon {
            width: 46px;
            height: 46px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            border-radius: 13px;
            background: #edf8f2;
            color: #198754;
            font-size: 21px;
        }

        .help-modal h3 {
            margin: 0 0 8px;
            font-size: 1.2rem;
            color: #111827;
        }

        .help-modal p {
            margin: 0;
            color: #6b7280;
            line-height: 1.65;
            font-size: 0.92rem;
        }

        .close-modal {
            width: 100%;
            margin-top: 20px;
            min-height: 44px;
            border: 0;
            border-radius: 10px;
            background: #f3f4f6;
            color: #374151;
            font-weight: 600;
            cursor: pointer;
        }

        .close-modal:hover {
            background: #e5e7eb;
        }

        @media (max-width: 820px) {
            .login-page {
                padding: 18px;
            }

            .login-card {
                grid-template-columns: 1fr;
                min-height: auto;
                max-width: 620px;
            }

            .brand-panel {
                min-height: 230px;
                padding: 30px;
            }

            .brand-content h1 {
                font-size: 2rem;
            }

            .brand-content p {
                line-height: 1.6;
            }

            .brand-note {
                display: none;
            }

            .form-panel {
                padding: 36px 30px 32px;
            }
        }

        @media (max-width: 480px) {
            .login-page {
                padding: 12px;
            }

            .login-card {
                border-radius: 18px;
            }

            .brand-panel {
                min-height: 205px;
                padding: 24px 22px;
            }

            .brand-icon {
                width: 48px;
                height: 48px;
                margin-bottom: 14px;
                border-radius: 13px;
                font-size: 22px;
            }

            .brand-content h1 {
                margin-bottom: 8px;
                font-size: 1.7rem;
            }

            .brand-content p {
                font-size: 0.88rem;
            }

            .form-panel {
                padding: 30px 22px 25px;
            }

            .welcome-text {
                margin-bottom: 24px;
            }

            .welcome-text h2 {
                font-size: 1.65rem;
            }

            .form-control {
                height: 48px;
            }

            .login-button {
                min-height: 48px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition: none !important;
                animation: none !important;
            }
        }
    </style>
</head>

<body>
<div class="login-page">

    <div class="login-card">

        <!-- IDENTITAS PESANTREN -->
        <section class="brand-panel">
            <div class="brand-content">
                <div class="brand-icon" aria-hidden="true">
                    <i class="bi bi-building"></i>
                </div>

                <h1>Pesantren Al Asror</h1>

                <p>
                    Sistem Informasi Manajemen Keuangan dan
                    Pembayaran Syahriah.
                </p>

                <div class="brand-note">
                    Pengelolaan pembayaran yang lebih teratur,
                    mudah, dan transparan.
                </div>
            </div>
        </section>

        <!-- FORM LOGIN -->
        <section class="form-panel">
            <div class="form-wrapper">

                <div class="welcome-text">
                    <div class="small-title">Akses Sistem</div>
                    <h2>Selamat Datang</h2>
                    <p>
                        Silakan masuk menggunakan akun yang telah
                        terdaftar pada sistem.
                    </p>
                </div>

                @if ($errors->any())
                    <div class="error-box" role="alert">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <div>{{ $errors->first() }}</div>
                    </div>
                @endif

                <form action="{{ route('login.process') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="username">
                            Username
                        </label>

                        <input
                            type="text"
                            name="username"
                            id="username"
                            class="form-control"
                            value="{{ old('username') }}"
                            placeholder="Masukkan username"
                            autocomplete="username"
                            required
                            autofocus
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">
                            Password
                        </label>

                        <div class="input-wrapper">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control password-input"
                                placeholder="Masukkan password"
                                autocomplete="current-password"
                                required
                            >

                            <button
                                type="button"
                                class="toggle-password"
                                id="togglePassword"
                                title="Tampilkan password"
                                aria-label="Tampilkan password"
                                aria-pressed="false"
                            >
                                <i class="bi bi-eye" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>

                    <div class="forgot-row">
                        <button
                            type="button"
                            class="forgot-link"
                            id="forgotPassword"
                        >
                            Lupa Password?
                        </button>
                    </div>

                    <button type="submit" class="login-button">
                        <i class="bi bi-box-arrow-in-right" aria-hidden="true"></i>
                        <span>Login</span>
                    </button>
                </form>

                <div class="login-footer">
                    &copy; {{ date('Y') }} Pondok Pesantren Al Asror
                </div>

            </div>
        </section>

    </div>
</div>

<!-- INFORMASI LUPA PASSWORD -->
<div
    class="modal-backdrop"
    id="forgotPasswordModal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="forgotPasswordTitle"
>
    <div class="help-modal">
        <div class="help-icon" aria-hidden="true">
            <i class="bi bi-key-fill"></i>
        </div>

        <h3 id="forgotPasswordTitle">Lupa Password?</h3>

        <p>
            Untuk keamanan akun, silakan hubungi Admin Pondok Pesantren
            untuk melakukan reset password.
        </p>

        <button
            type="button"
            class="close-modal"
            id="closeForgotPassword"
        >
            Mengerti
        </button>
    </div>
</div>

<script>
(function () {

    function initLoginPage() {

        const password =
            document.getElementById('password');

        const togglePassword =
            document.getElementById('togglePassword');

        const forgotPassword =
            document.getElementById('forgotPassword');

        const forgotPasswordModal =
            document.getElementById('forgotPasswordModal');

        const closeForgotPassword =
            document.getElementById('closeForgotPassword');


        /*
        ========================================
        TOGGLE PASSWORD
        ========================================
        */

        if (password && togglePassword) {

            togglePassword.onclick = function () {

                const icon =
                    togglePassword.querySelector('i');

                const isHidden =
                    password.type === 'password';


                password.type =
                    isHidden
                        ? 'text'
                        : 'password';


                if (icon) {

                    icon.classList.remove(
                        'bi-eye',
                        'bi-eye-slash'
                    );

                    icon.classList.add(
                        isHidden
                            ? 'bi-eye-slash'
                            : 'bi-eye'
                    );

                }


                togglePassword.title =
                    isHidden
                        ? 'Sembunyikan password'
                        : 'Tampilkan password';


                togglePassword.setAttribute(
                    'aria-label',
                    isHidden
                        ? 'Sembunyikan password'
                        : 'Tampilkan password'
                );


                togglePassword.setAttribute(
                    'aria-pressed',
                    isHidden
                        ? 'true'
                        : 'false'
                );

            };

        }


        /*
        ========================================
        MODAL LUPA PASSWORD
        ========================================
        */

        function openForgotPasswordModal() {

            if (!forgotPasswordModal) {
                return;
            }

            forgotPasswordModal.classList.add('show');

            document.body.style.overflow = 'hidden';


            if (closeForgotPassword) {

                setTimeout(function () {

                    closeForgotPassword.focus();

                }, 50);

            }

        }


        function closeForgotPasswordModal() {

            if (!forgotPasswordModal) {
                return;
            }

            forgotPasswordModal.classList.remove('show');

            document.body.style.overflow = '';


            if (forgotPassword) {

                forgotPassword.focus();

            }

        }


        if (forgotPassword) {

            forgotPassword.onclick =
                openForgotPasswordModal;

        }


        if (closeForgotPassword) {

            closeForgotPassword.onclick =
                closeForgotPasswordModal;

        }


        if (forgotPasswordModal) {

            forgotPasswordModal.onclick =
                function (event) {

                    if (
                        event.target ===
                        forgotPasswordModal
                    ) {

                        closeForgotPasswordModal();

                    }

                };

        }


        document.addEventListener(
            'keydown',
            function (event) {

                if (
                    event.key === 'Escape' &&
                    forgotPasswordModal &&
                    forgotPasswordModal.classList.contains('show')
                ) {

                    closeForgotPasswordModal();

                }

            }
        );

    }


    if (
        document.readyState ===
        'loading'
    ) {

        document.addEventListener(
            'DOMContentLoaded',
            initLoginPage
        );

    } else {

        initLoginPage();

    }

})();
</script>
</body>
</html>
