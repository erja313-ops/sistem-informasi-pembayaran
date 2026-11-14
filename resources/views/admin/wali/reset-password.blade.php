<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Reset Password - Pesantren Al Asror</title>
    <style>
        *{box-sizing:border-box}
        body{margin:0;min-height:100vh;font-family:"Segoe UI",Arial,sans-serif;background:#eef3f0;color:#1f2937}
        .page{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px}
        .card{width:min(100%,560px);padding:34px;border-radius:20px;background:#fff;box-shadow:0 20px 55px rgba(15,23,42,.12)}
        .icon{width:52px;height:52px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;border-radius:14px;background:#edf8f2;color:#198754;font-size:22px}
        h1{margin:0 0 8px;font-size:1.8rem;color:#111827}
        .intro{margin:0 0 25px;color:#6b7280;line-height:1.6}
        .alert{margin-bottom:20px;padding:12px 14px;border-radius:11px;font-size:.9rem}
        .success{border:1px solid #a3cfbb;background:#effaf4;color:#146c43}
        .error{border:1px solid #f1b0b7;background:#fff2f3;color:#842029}
        .field{margin-bottom:18px}
        label{display:block;margin-bottom:8px;font-weight:600;font-size:.9rem}
        .input-wrap{position:relative}
        input{width:100%;height:48px;padding:0 46px 0 14px;border:1px solid #d1d5db;border-radius:11px;outline:none;font-size:.95rem}
        input:focus{border-color:#198754;box-shadow:0 0 0 4px rgba(25,135,84,.11)}
        .toggle{position:absolute;top:50%;right:7px;width:34px;height:34px;transform:translateY(-50%);display:inline-flex;align-items:center;justify-content:center;border:0;border-radius:8px;background:transparent;color:#6b7280;cursor:pointer}
        .toggle:hover{background:#eef7f2;color:#198754}
        .button{width:100%;min-height:48px;margin-top:4px;border:0;border-radius:11px;background:#198754;color:#fff;font-weight:700;cursor:pointer}
        .button:hover{background:#157347}
        .back{display:block;margin-top:18px;color:#198754;text-align:center;font-size:.9rem;font-weight:600;text-decoration:none}
        .back:hover{text-decoration:underline}
        @media(max-width:480px){.page{padding:12px}.card{padding:24px 20px;border-radius:16px}}
    </style>
</head>
<body>
<div class="page">
    <div class="card">
        <div class="icon"><i class="bi bi-shield-lock-fill"></i></div>
        <h1>Reset Password Wali</h1>
        <p class="intro">Admin dapat menetapkan password baru untuk akun wali yang mengalami kendala login.</p><div style="margin-bottom:22px;padding:14px;border-radius:12px;background:#f8faf9"><strong style="display:block;margin-bottom:4px;color:#111827">{{ $user->name }}</strong><span style="color:#6b7280;font-size:.9rem">Username: {{ $user->username }}</span></div>

                @if($errors->any())
            <div class="alert error" role="alert">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.wali.reset-password.update', $user) }}">
            @csrf

            <div class="field">
                <label for="password">Password Baru</label>
                <div class="input-wrap">
                    <input id="password" name="password" type="password" autocomplete="new-password" required>
                    <button type="button" class="toggle" data-target="password" aria-label="Tampilkan password">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <div class="field">
                <label for="password_confirmation">Konfirmasi Password Baru</label>
                <div class="input-wrap">
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required>
                    <button type="button" class="toggle" data-target="password_confirmation" aria-label="Tampilkan password">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="button"><i class="bi bi-check2-circle"></i> Simpan Password Baru</button>
        </form>

        <a href="{{ route('admin.wali.index') }}" class="back"><i class="bi bi-arrow-left"></i> Kembali ke Data Wali</a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggle').forEach(function (button) {
        button.addEventListener('click', function () {
            const target = document.getElementById(button.dataset.target);
            const icon = button.querySelector('i');
            if (!target || !icon) return;

            const show = target.type === 'password';
            target.type = show ? 'text' : 'password';
            icon.classList.toggle('bi-eye', !show);
            icon.classList.toggle('bi-eye-slash', show);
        });
    });
});
</script>
</body>
</html>