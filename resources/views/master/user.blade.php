@extends('component.layout2')

@section('title')
    User Management
@endsection

@section('head')
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/3.34.1/tabler-icons.min.css">
    <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css?v=2.1.0') }}" rel="stylesheet" />
@endsection

@section('crw1')
    Master
@endsection

@section('crw2')
    User
@endsection

@section('konten')
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 font-weight-bolder">Users Data</h6>

                        <div class="d-flex">
                            <form method="GET" action="" class="d-flex">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control form-control-sm me-2"
                                    style="height: 30px; padding: 2px 8px; font-size: 0.8rem;" placeholder="Cari user...">
                                <button type="submit" class="btn btn-sm btn-outline-primary"
                                    style="height: 30px; padding: 0 10px;"> <i class="ti ti-search"></i>
                                </button>
                            </form>
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambah"
                                style="height: 30px; padding: 0 10px; margin-left: 8px;">
                                <i class="ti ti-plus me-2"></i>User
                            </button>
                        </div>
                    </div>

                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                            No</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            NIP/NIM</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Nama</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Gender</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Role</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="userTableBody">
                                    {{-- Spinner row, default hidden --}}
                                    <tr id="loadingRow" class="d-none">
                                        <td colspan="6" class="text-center py-5">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <p class="mt-2 text-muted">Mencari data...</p>
                                        </td>
                                    </tr>

                                    @php
                                        $filteredUsers = $user;
                                        if (request('search')) {
                                            $search = strtolower(request('search'));
                                            $filteredUsers = $user->filter(function ($item) use ($search) {
                                                $roles = strtolower($item->getRoleNames()->implode(', '));
                                                return str_contains(strtolower($item->nip_nim), $search) ||
                                                    str_contains(strtolower($item->gender), $search) ||
                                                    str_contains(strtolower($item->name), $search) ||
                                                    str_contains($roles, $search);
                                            });
                                        }
                                    @endphp

                                    @forelse ($filteredUsers as $index => $user)
                                        <tr>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $user->nip_nim }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $user->name }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $user->gender }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ $user->getRoleNames()->first() }}</p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="d-inline-flex align-items-center">
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-outline-primary me-2 text-primary font-weight-bold text-xs p-2 m-0 d-inline-flex align-items-center"
                                                        style="height: 30px; padding: 0 10px;" data-bs-toggle="modal"
                                                        data-bs-target="#editModal" onclick="edituser({{ $user->id }})"
                                                        title="Edit">
                                                        <i class="ti ti-pencil me-2"></i> Edit
                                                    </a>
                                                    <form id="delete-form-{{ $user->id }}"
                                                        action="{{ route('user.destroy', $user->id) }}" method="POST"
                                                        class="d-inline m-0 p-0">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-outline-danger text-danger font-weight-bold text-xs p-2 m-0 d-inline-flex align-items-center"
                                                            data-bs-toggle="tooltip" title="Hapus"
                                                            style="height: 30px; padding: 0 10px;"
                                                            onclick="confirmDelete({{ $user->id }})">
                                                            <i class="ti ti-trash me-2"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">
                                                <img src="{{ asset('assets/img/nodata.png') }}" alt="No data"
                                                    style="width: 250px; height: auto;">
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambah" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('user.store') }}">
                    @csrf
                    @method('POST')
                    <div class="modal-header">
                        <h6 class="font-weight-bolder text-black mb-0">Tambah User</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nip_nim" class="form-label">NIP/NIM</label>
                                    <input type="text" class="form-control" id="nip_nim" name="nip_nim"
                                        style="height: 30px; padding: 2px 8px; font-size: 0.8rem;"
                                        placeholder="NIP/NIM...">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nip_nim" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        style="height: 30px; padding: 2px 8px; font-size: 0.8rem;" placeholder="Nama...">
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-select form-select" name="gender"
                                        style="height: 30px; padding: 2px 8px; font-size: 0.8rem;">
                                        <option value="" disabled selected>Select Gender</option>
                                        <option value="Laki-laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="Role" class="form-label">Role</label>
                                    <select class="form-select form-select" name="role"
                                        style="height: 30px; padding: 2px 8px; font-size: 0.8rem;">
                                        <option value="" disabled selected>Select Role</option>
                                        @foreach ($role as $item)
                                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="nip_nim" class="form-label">Password</label>
                            <input type="text" class="form-control" id="password" name="password"
                                style="height: 30px; padding: 2px 8px; font-size: 0.8rem;" placeholder="Password...">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            style="height: 30px; padding: 0 10px;" data-bs-dismiss="modal"><i
                                class="ti ti-x me-2"></i>Batal</button>
                        <button type="submit" class="btn btn-sm btn-outline-primary"
                            style="height: 30px; padding: 0 10px;"><i class="ti ti-device-floppy me-2"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" id="edituserForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h6 class="font-weight-bolder text-black mb-0">Edit user</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nip_nim" class="form-label">NIP/NIM</label>
                                    <input type="text" class="form-control" id="edit_nip_nim" name="nip_nim"
                                        style="height: 30px; padding: 2px 8px; font-size: 0.8rem;"
                                        placeholder="NIP/NIM...">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nip_nim" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="edit_nama" name="nama"
                                        style="height: 30px; padding: 2px 8px; font-size: 0.8rem;" placeholder="Nama...">
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-select form-select" id="edit_gender" name="gender"
                                        style="height: 30px; padding: 2px 8px; font-size: 0.8rem;">
                                        <option value="" disabled selected>Select Gender</option>
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="Role" class="form-label">Role</label>
                                    <select class="form-select form-select" id="edit_role" name="role"
                                        style="height: 30px; padding: 2px 8px; font-size: 0.8rem;">
                                        <option value="" disabled selected>Select Role</option>
                                        @foreach ($role as $item)
                                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="nip_nim" class="form-label">Password</label>
                            <input type="text" class="form-control" id="password" name="password"
                                style="height: 30px; padding: 2px 8px; font-size: 0.8rem;" placeholder="Password...">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal"
                            style="height: 30px; padding: 0 10px;">
                            <i class="ti ti-x me-2"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-sm btn-outline-primary"
                            style="height: 30px; padding: 0 10px;">
                            <i class="ti ti-device-floppy me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script>
        function edituser(id) {
            fetch(`/user/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_nama').value = data.name;
                    document.getElementById('edit_gender').value = data.gender;
                    document.getElementById('edit_nip_nim').value = data.nip_nim;
                    const roleSelect = document.getElementById('edit_role');
                    for (let option of roleSelect.options) {
                        if (option.value.toLowerCase() === data.roles[0].name.toLowerCase()) {
                            option.selected = true;
                            break;
                        }
                    }
                    document.getElementById('password').value = data.password;
                    document.getElementById('edituserForm').action = `/user/update/${id}`;
                })
                .catch(err => console.error(err));
        }
    </script>
    <script>
        document.getElementById('searchForm').addEventListener('submit', function() {
            // Sembunyikan semua baris user
            document.querySelectorAll('#userTableBody tr').forEach(row => {
                if (row.id !== 'loadingRow') row.classList.add('d-none');
            });

            // Tampilkan baris loading
            document.getElementById('loadingRow').classList.remove('d-none');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(userId) {
            Swal.fire({
                title: 'Yakin ingin menghapus user ini?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${userId}`).submit();
                }
            });
        }
    </script>
@endsection
