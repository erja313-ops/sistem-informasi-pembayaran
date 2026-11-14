<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Data Santri - Pondok Pesantren Al Asror
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

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>
                        <h3 class="fw-bold mb-1">
                            Data Santri
                        </h3>

                        <p class="text-muted mb-0">
                            Kelola data santri Pondok Pesantren Al Asror.
                        </p>
                    </div>

                    <a
                        href="{{ route('admin.santri.create') }}"
                        class="btn btn-primary"
                    >
                        <i class="bi bi-person-plus-fill"></i>
                        + Tambah Santri
                    </a>

                </div>


                {{-- FILTER --}}

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-body">

                        <h5 class="fw-bold mb-3">
                            Pencarian dan Filter
                        </h5>

                        <form
                            method="GET"
                            action="{{ route('admin.santri.index') }}"
                        >

                            <div class="row g-2">

                                <div class="col-md-6">

                                    <label
                                        for="search"
                                        class="form-label"
                                    >
                                        Nama / NIS
                                    </label>

                                    <input
                                        type="text"
                                        name="search"
                                        id="search"
                                        class="form-control"
                                        value="{{ request('search') }}"
                                        placeholder="Contoh: Ahmad atau 260001"
                                    >

                                </div>


                                <div class="col-md-4">

                                    <label
                                        for="kelas"
                                        class="form-label"
                                    >
                                        Kelas
                                    </label>

                                    <select
                                        name="kelas"
                                        id="kelas"
                                        class="form-select"
                                    >

                                        <option value="">
                                            Semua Kelas
                                        </option>

                                        @foreach ($kelas as $item)

                                            <option
                                                value="{{ $item }}"
                                                {{ request('kelas') === $item ? 'selected' : '' }}
                                            >
                                                {{ $item }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <div class="col-md-2 d-flex align-items-end gap-2">

                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                    >
                                        Cari
                                    </button>

                                    <a
                                        href="{{ route('admin.santri.index') }}"
                                        class="btn btn-secondary"
                                    >
                                        Reset
                                    </a>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>


                {{-- TABEL --}}

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <div>

                                <h5 class="fw-bold mb-1">
                                    Daftar Santri
                                </h5>

                                <p class="text-muted mb-0">
                                    Total hasil:
                                    {{ $santri->total() }}
                                    santri
                                </p>

                            </div>

                        </div>


                        <div class="table-responsive">

                            <table class="table table-hover align-middle">

                                <thead class="table-light">

                                    <tr>

                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>Wali</th>
                                        <th>Status</th>
                                        <th>aksi</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @forelse ($santri as $index => $item)

                                        <tr>

                                            <td>
                                                {{ $santri->firstItem() + $index }}
                                            </td>

                                            <td>
                                                {{ $item->nis }}
                                            </td>

                                            <td class="fw-semibold">
                                                {{ $item->nama }}
                                            </td>

                                            <td>
                                                {{ $item->kelas ?? '-' }}
                                            </td>

                                            <td>
                                                {{ $item->wali->nama ?? '-' }}
                                            </td>

                                            <td>

                                                @if ($item->status === 'aktif')

                                                    <span class="badge bg-success">
                                                        Aktif
                                                    </span>

                                                @else

                                                    <span class="badge bg-secondary">
                                                        {{ ucfirst($item->status ?? '-') }}
                                                    </span>

                                                @endif

                                            </td>

                                            <td>
                                                <a
                                                    href="{{ route('admin.santri.edit', $item->id) }}"
                                                    class="btn btn-sm btn-warning"
                                                >
                                                    <i class="bi bi-pencil-square"></i>
                                                    Edit
                                                </a>
                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td
                                                colspan="6"
                                                class="text-center text-muted py-4"
                                            >
                                                Data santri tidak ditemukan.
                                            </td>

                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>


                        <div class="mt-3">

                            {{ $santri->links() }}

                        </div>

                    </div>

                </div>


                <div class="text-muted small mt-4">

                    Sistem Informasi Manajemen Keuangan
                    Pondok Pesantren Al Asror

                </div>

            </div>

        </main>

    </div>

</div>

</body>

</html>