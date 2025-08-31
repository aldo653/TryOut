@extends('component.layout2')

@section('title')
    Permission Management
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
    Permission
@endsection

@section('konten')
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 font-weight-bolder">Permissions Data</h6>

                        <div class="d-flex">
                            <form method="GET" action="" class="d-flex">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control form-control-sm me-2"
                                    style="height: 30px; padding: 2px 8px; font-size: 0.8rem;"
                                    placeholder="Cari permission...">
                                <button type="submit" class="btn btn-sm btn-outline-primary"
                                    style="height: 30px; padding: 0 10px;"> <i class="ti ti-search"></i>
                                </button>
                            </form>
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambah"
                                style="height: 30px; padding: 0 10px; margin-left: 8px;">
                                <i class="ti ti-plus me-2"></i>Permission
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
                                            Permissions</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $filteredPermissions = $permissions;
                                        if (request('search')) {
                                            $filteredPermissions = $permissions->filter(function ($item) {
                                                return stripos($item->name, request('search')) !== false;
                                            });
                                        }
                                    @endphp

                                    @forelse ($filteredPermissions as $index => $permission)
                                        <tr>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $permission->name }}</p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="d-inline-flex align-items-center">
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-outline-primary me-2 text-primary font-weight-bold text-xs p-2 m-0 d-inline-flex align-items-center"
                                                        style="height: 30px; padding: 0 10px;" data-bs-toggle="modal"
                                                        data-bs-target="#editModal"
                                                        onclick="editPermission({{ $permission->id }})" title="Edit">
                                                        <i class="ti ti-pencil me-2"></i> Edit
                                                    </a>
                                                    <form id="delete-permission-{{ $permission->id }}"
                                                        action="{{ route('permission.destroy', $permission->id) }}"
                                                        method="POST" class="d-inline m-0 p-0">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-outline-danger text-danger font-weight-bold text-xs p-2 m-0 d-inline-flex align-items-center"
                                                            data-bs-toggle="tooltip" title="Hapus"
                                                            style="height: 30px; padding: 0 10px;"
                                                            onclick="confirmDeletePermission({{ $permission->id }})">
                                                            <i class="ti ti-trash me-2"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">Tidak ada data
                                                ditemukan</td>
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
                <form method="POST" action="{{ route('permission.store') }}">
                    @csrf
                    @method('POST')
                    <div class="modal-header">
                        <h6 class="font-weight-bolder text-black mb-0">Tambah Permission</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="exampleInput" class="form-label">Nama Permission</label>
                            <input type="text" class="form-control" id="exampleInput" name="name"
                                style="height: 30px; padding: 2px 8px; font-size: 0.8rem;" placeholder="Nama permission...">
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
                <form method="POST" id="editPermissionForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h6 class="font-weight-bolder text-black mb-0">Edit Permission</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Nama Permission</label>
                            <input type="text" class="form-control" id="editName" name="name"
                                style="height: 30px; padding: 2px 8px; font-size: 0.8rem;"
                                placeholder="Nama permission...">
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
        function editPermission(id) {
            fetch(`/permission/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('editName').value = data.name;
                    document.getElementById('editPermissionForm').action = `/permission/update/${id}`;
                })
                .catch(err => console.error(err));
        }
    </script>
    <script>
        function confirmDeletePermission(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus permission ini?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-permission-${id}`).submit();
                }
            });
        }
    </script>
@endsection
