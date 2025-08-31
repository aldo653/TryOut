@extends('component.layout2')

@section('title')
    Kegiatan Management
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
    Kegiatan
@endsection

@section('konten')
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 font-weight-bolder">Kegiatan Data</h6>

                        <div class="d-flex">
                            <form method="GET" action="" class="d-flex">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control form-control-sm me-2"
                                    style="height: 30px; padding: 2px 8px; font-size: 0.8rem;"
                                    placeholder="Cari kegiatan...">
                                <button type="submit" class="btn btn-sm btn-outline-primary"
                                    style="height: 30px; padding: 0 10px;"> <i class="ti ti-search"></i>
                                </button>
                            </form>
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#tambahkegiatan" style="height: 30px; padding: 0 10px; margin-left: 8px;">
                                <i class="ti ti-plus me-2"></i>Kegiatan
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
                                            Nama</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Deskripsi</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Poin Kehadiran</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="kegiatanTableBody">
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
                                        $filteredkegiatan = $kegiatan;
                                        if (request('search')) {
                                            $search = strtolower(request('search'));
                                            $filteredkegiatan = $kegiatan->filter(function ($item) use ($search) {
                                                return str_contains(strtolower($item->nama_kegiatan), $search) ||
                                                    str_contains(strtolower($item->deskripsi), $search) ||
                                                    str_contains(strtolower($item->poin_kegiatan), $search);
                                            });
                                        }
                                    @endphp

                                    @forelse ($filteredkegiatan as $index => $kegiatan)
                                        <tr>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $kegiatan->nama_kegiatan }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $kegiatan->deskripsi }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $kegiatan->poin_kegiatan }}</p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="d-inline-flex align-items-center">
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-outline-primary me-2 text-primary font-weight-bold text-xs p-2 m-0 d-inline-flex align-items-center"
                                                        style="height: 30px; padding: 0 10px;" data-bs-toggle="modal"
                                                        data-bs-target="#editModal"
                                                        onclick="editkegiatan({{ $kegiatan->id }})" title="Edit">
                                                        <i class="ti ti-pencil me-2"></i> Edit
                                                    </a>
                                                    <form id="delete-form-{{ $kegiatan->id }}"
                                                        action="{{ route('kegiatan.destroy', $kegiatan->id) }}"
                                                        method="POST" class="d-inline m-0 p-0">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-outline-danger text-danger font-weight-bold text-xs p-2 m-0 d-inline-flex align-items-center"
                                                            data-bs-toggle="tooltip" title="Hapus"
                                                            style="height: 30px; padding: 0 10px;"
                                                            onclick="confirmDelete({{ $kegiatan->id }})">
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

    <div class="modal fade" id="tambahkegiatan" tabindex="-1" aria-labelledby="tambah" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('kegiatan.store') }}">
                    @csrf
                    @method('POST')
                    <div class="modal-header">
                        <h6 class="font-weight-bolder text-black mb-0">Tambah kegiatan</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Kegiatan</label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    style="height: 30px; padding: 2px 8px; font-size: 0.8rem;"
                                    placeholder="Nama Kegiatan...">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi"
                                    style="height: 50px; padding: 2px 8px; font-size: 0.8rem;" placeholder="Deskripsi..."></textarea>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="poin" class="form-label">Poin</label>
                                <input type="number" class="form-control" id="poin" name="poin"
                                    style="height: 30px; padding: 2px 8px; font-size: 0.8rem;" placeholder="Poin...">
                            </div>
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

     <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="tambah" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" id="editkegiatanForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h6 class="font-weight-bolder text-black mb-0">Edit kegiatan</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Kegiatan</label>
                                <input type="text" class="form-control" id="edit_nama" name="nama"
                                    style="height: 30px; padding: 2px 8px; font-size: 0.8rem;"
                                    placeholder="Nama Kegiatan...">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="edit_deskripsi" name="deskripsi"
                                    style="height: 50px; padding: 2px 8px; font-size: 0.8rem;" placeholder="Deskripsi..."></textarea>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="poin" class="form-label">Poin</label>
                                <input type="number" class="form-control" id="edit_poin" name="poin"
                                    style="height: 30px; padding: 2px 8px; font-size: 0.8rem;" placeholder="Poin...">
                            </div>
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

    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script>
        function editkegiatan(id) {
            fetch(`/kegiatan/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_nama').value = data.nama_kegiatan;
                    document.getElementById('edit_deskripsi').value = data.deskripsi;
                    document.getElementById('edit_poin').value = data.poin_kegiatan;
                    document.getElementById('editkegiatanForm').action = `/kegiatan/update/${id}`;
                })
                .catch(err => console.error(err));
        }
    </script>
    <script>
        document.getElementById('searchForm').addEventListener('submit', function() {
            // Sembunyikan semua baris kegiatan
            document.querySelectorAll('#kegiatanTableBody tr').forEach(row => {
                if (row.id !== 'loadingRow') row.classList.add('d-none');
            });

            // Tampilkan baris loading
            document.getElementById('loadingRow').classList.remove('d-none');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(kegiatanId) {
            Swal.fire({
                title: 'Yakin ingin menghapus kegiatan ini?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${kegiatanId}`).submit();
                }
            });
        }
    </script>
@endsection
