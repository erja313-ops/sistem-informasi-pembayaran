<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Wali - Admin</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >
    <style>
        .wali-actions {
            display: flex;
            flex-wrap: wrap;
            gap: .25rem;
        }

        @media (max-width: 576px) {
            .flex-grow-1.p-4 {
                padding: 1rem !important;
            }

            .wali-actions .btn,
            .wali-actions form {
                width: 100%;
            }

            .wali-actions form .btn {
                width: 100%;
            }
        }
    </style>

</head>

<body>

<div class="d-flex">

    @include('admin.partials.sidebar')

    <div class="flex-grow-1 p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="fw-bold mb-1">
                    Data Wali Santri
                </h3>

                <p class="text-muted mb-0">
                    Kelola data wali dan akun login wali santri.
                </p>
            </div>

            <a
                href="{{ route('admin.wali.create') }}"
                class="btn btn-primary"
            >
                + Tambah Wali
            </a>

        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-sm mb-4">

            <div class="card-body">

                <form
                    method="GET"
                    action="{{ route('admin.wali.index') }}"
                >

                    <div class="row g-2">

                        <div class="col-md-10">

                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Cari nama wali, username, atau nomor HP..."
                                value="{{ $search }}"
                            >

                        </div>

                        <div class="col-md-2">

                            <button
                                type="submit"
                                class="btn btn-outline-primary w-100"
                            >
                                Cari
                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

        <div class="card shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-light">

                            <tr>
                                <th>No</th>
                                <th>Nama Wali</th>
                                <th>Username</th>
                                <th>No. HP</th>
                                <th>Jumlah Santri</th>
                                <th>Status Akun</th>
                                <th>Aksi</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($wali as $item)

                                <tr>

                                    <td>
                                        {{ $wali->firstItem() + $loop->index }}
                                    </td>

                                    <td>
                                        <strong>
                                            {{ $item->nama }}
                                        </strong>
                                    </td>

                                    <td>
                                        {{ $item->user->username ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $item->no_hp ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $item->santri->count() }} santri
                                    </td>

                                    <td>

                                        @if($item->user && $item->user->is_active)

                                            <span class="badge text-bg-success">
                                                Aktif
                                            </span>

                                        @else

                                            <span class="badge text-bg-secondary">
                                                Nonaktif
                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        <div class="wali-actions">

                                            <a
                                                href="{{ route('admin.wali.edit', $item->id) }}"
                                                class="btn btn-sm btn-warning"
                                            >
                                                <i class="bi bi-pencil-square"></i>
                                                Edit
                                            </a>

                                            @if($item->user)
                                                <a
                                                    href="{{ route('admin.wali.reset-password', $item->user->id) }}"
                                                    class="btn btn-sm btn-outline-primary"
                                                    title="Reset Password"
                                                    onclick="return confirm('Reset password untuk akun {{ addslashes($item->nama) }}?');"
                                                >
                                                    <i class="bi bi-key-fill"></i>
                                                    Reset Password
                                                </a>
                                            @endif

                                            <form
                                                action="{{ route('admin.wali.toggle-status', $item->id) }}"
                                                method="POST"
                                            >

                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-outline-secondary"
                                                >
                                                    {{ $item->user && $item->user->is_active
                                                        ? 'Nonaktifkan'
                                                        : 'Aktifkan'
                                                    }}
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
                                        Belum ada data wali.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="mt-3">
                    {{ $wali->links() }}
                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>