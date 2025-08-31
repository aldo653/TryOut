@extends('component.layout2')

@section('title')
    Punishment & Reward Management
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
    Punishment & Reward
@endsection

@section('konten')
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 font-weight-bolder">Punishment & Reward Data</h6>

                        <div class="d-flex">
                            <form method="GET" action="" class="d-flex">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control form-control-sm me-2"
                                    style="height: 30px; padding: 2px 8px; font-size: 0.8rem;"
                                    placeholder="Cari punishment/reward...">
                                <button type="submit" class="btn btn-sm btn-outline-primary"
                                    style="height: 30px; padding: 0 10px;"> <i class="ti ti-search"></i>
                                </button>
                            </form>
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambah"
                                style="height: 30px; padding: 0 10px; margin-left: 8px;">
                                <i class="ti ti-plus me-2"></i>Punishment & Reward
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
                                            Jenis</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Tipe</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Poin</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $filteredpinalties = $pinalties;
                                        if (request('search')) {
                                            $filteredpinalties = $pinalties->filter(function ($item) {
                                                return stripos($item->tipe, request('search')) !== false ||
                                                    stripos($item->jenis, request('search')) !== false ||
                                                    stripos($item->poin, request('search')) !== false;
                                            });
                                        }
                                    @endphp

                                    @forelse ($filteredpinalties as $index => $item)
                                        <tr>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $item->jenis }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $item->tipe }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $item->poin }}</p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="d-inline-flex align-items-center">
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-outline-primary me-2 text-primary font-weight-bold text-xs p-2 m-0 d-inline-flex align-items-center"
                                                        style="height: 30px; padding: 0 10px;" data-bs-toggle="modal"
                                                        data-bs-target="#editModal"
                                                        onclick="editPelanggaran({{ $item->id }})" title="Edit">
                                                        <i class="ti ti-pencil me-2"></i> Edit
                                                    </a>
                                                    <form id="delete-pelanggaran-{{ $item->id }}"
                                                        action="{{ route('pelanggaran.destroy', $item->id) }}"
                                                        method="POST" class="d-inline m-0 p-0">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-outline-danger text-danger font-weight-bold text-xs p-2 m-0 d-inline-flex align-items-center"
                                                            data-bs-toggle="tooltip" title="Hapus"
                                                            style="height: 30px; padding: 0 10px;"
                                                            onclick="confirmdeletePelanggaran({{ $item->id }})">
                                                            <i class="ti ti-trash me-2"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted"> <img
                                                    src="{{ asset('assets/img/nodata.png') }}" alt="No data"
                                                    style="width: 250px; height: auto;"></td>
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
                <form method="POST" action="{{ route('pelanggaran.store') }}">
                    @csrf
                    @method('POST')
                    <div class="modal-header">
                        <h6 class="font-weight-bolder text-black mb-0">Tambah Punishment/Reward Point</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="editName" class="form-label">Tipe</label>
                                    <select class="form-select" id="editName" name="jenis"
                                        style="height: 30px; padding: 2px 8px; font-size: 0.8rem;">
                                        <option value="" selected disabled>Pilih jenis...</option>
                                        <option value="Reward">Reward</option>
                                        <option value="Punishment">Punishment</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="editName" class="form-label">Tipe</label>
                                    <select class="form-select" id="editName" name="tipe"
                                        style="height: 30px; padding: 2px 8px; font-size: 0.8rem;">
                                        <option value="" selected disabled>Pilih tipe...</option>
                                        <option value="Ringan">Ringan</option>
                                        <option value="Sedang">Sedang</option>
                                        <option value="Berat">Berat</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="exampleInput" class="form-label">Poin</label>
                            <input type="number" class="form-control" id="exampleInput" name="poin"
                                style="height: 30px; padding: 2px 8px; font-size: 0.8rem;" placeholder="Poin...">
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
                <form method="POST" id="editPelanggaranForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h6 class="font-weight-bolder text-black mb-0">Edit Punishment/Reward</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="editName" class="form-label">Tipe</label>
                                    <select class="form-select" id="editJenis" name="jenis"
                                        style="height: 30px; padding: 2px 8px; font-size: 0.8rem;">
                                        <option value="" selected disabled>Pilih jenis...</option>
                                        <option value="Reward">Reward</option>
                                        <option value="Punishment">Punishment</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="editName" class="form-label">Tipe</label>
                                    <select class="form-select" id="editTipe" name="tipe"
                                        style="height: 30px; padding: 2px 8px; font-size: 0.8rem;">
                                        <option value="" selected disabled>Pilih tipe...</option>
                                        <option value="Ringan">Ringan</option>
                                        <option value="Sedang">Sedang</option>
                                        <option value="Berat">Berat</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="exampleInput" class="form-label">Poin</label>
                            <input type="number" class="form-control" id="editPoin" name="poin"
                                style="height: 30px; padding: 2px 8px; font-size: 0.8rem;" placeholder="Poin...">
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
        function editPelanggaran(id) {
            fetch(`/pelanggaran/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('editJenis').value = data.jenis;
                    document.getElementById('editTipe').value = data.tipe;
                    document.getElementById('editPoin').value = data.poin;
                    document.getElementById('editPelanggaranForm').action = `/pelanggaran/update/${id}`;
                })
                .catch(err => console.error(err));
        }
    </script>
    <script>
        function confirmdeletePelanggaran(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus pelanggaran ini?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-pelanggaran-${id}`).submit();
                }
            });
        }
    </script>
@endsection
