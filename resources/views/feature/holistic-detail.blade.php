@extends('component.layout2')

@section('title')
    Holistic Assessment
@endsection

@section('head')
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/3.34.1/tabler-icons.min.css">
    <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css?v=2.1.0') }}" rel="stylesheet" />
@endsection

@section('crw1')
    Assessment
@endsection

@section('crw2')
    {{ $detail['mhs_name'] ?? 'Holistic' }}
@endsection

@section('konten')
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body pb-0 d-flex justify-content-between align-items-center">
                        <h6 class="mb-4 font-weight-bolder">Assessment Data</h6>
                        <div class="d-flex">
                            <button class="btn btn-sm btn-outline-primary me-2" style="height: 30px; padding: 0 10px;"
                                data-bs-toggle="modal" data-bs-target="#tambah"><i class="ti ti-plus me-2"></i> Holistic
                                Assessment</button>
                            <a href="{{ route('pdf.history', $detail['mhs_id']) }}"
                                class="btn btn-sm btn-outline-primary d-inline-flex align-items-center"
                                style="padding: 4px 10px; line-height: 1.4;">
                                <i class="ti ti-download me-2"></i>
                                Unduh Laporan
                            </a>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                                <h6 class="mb-2 font-weight-bolder">Riwayat Penilaian</h6>
                                <div class="d-flex">
                                    <form method="GET" action="" class="d-flex">
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            class="form-control form-control-sm me-2"
                                            style="height: 30px; padding: 2px 8px; font-size: 0.8rem;"
                                            placeholder="Cari penilaian...">
                                        <button type="submit" class="btn btn-sm btn-outline-primary"
                                            style="height: 30px; padding: 0 10px;"> <i class="ti ti-search"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body px-0 pt-0 pb-2">
                                <div class="table-responsive p-2">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                    No</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Kegiatan</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                    Pengampu</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                    Deskripsi</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                    Status</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                    Poin Pengurangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($detail['details'] as $item)
                                                <tr>
                                                    <td class="align-middle text-center">
                                                        <p class="text-xs font-weight-bold mb-0 text-center">
                                                            {{ $loop->iteration }}</p>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $item->nama_kegiatan ?? '-' }}</p>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <p class="text-xs font-weight-bold mb-0 text-center">
                                                            {{ $item->pengampu ?? '-' }}</p>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <p class="text-xs font-weight-bold mb-0 text-center">
                                                            {{ $item->deskripsi ?? '-' }}</p>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <p class="text-xs font-weight-bold mb-0 text-center">
                                                            {{ $item->status ?? '-' }}</p>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <p class="text-xs font-weight-bold mb-0 text-center">
                                                            {{ $item->poin_kegiatan ?? '-' }}</p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                                <h6 class="mb-2 font-weight-bolder">Holistic Assessment</h6>
                                <div class="d-flex">
                                    <form method="GET" action="" class="d-flex">
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            class="form-control form-control-sm me-2"
                                            style="height: 30px; padding: 2px 8px; font-size: 0.8rem;"
                                            placeholder="Cari holistic...">
                                        <button type="submit" class="btn btn-sm btn-outline-primary"
                                            style="height: 30px; padding: 0 10px;"> <i class="ti ti-search"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body px-0 pt-0 pb-2">
                                <div class="table-responsive p-2">
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
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                    Tipe</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                    Tanggal</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                    Deskripsi</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                    Poin</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                    Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($reward['rewards'] as $item)
                                                <tr>
                                                    <td class="align-middle text-center">
                                                        <p class="text-xs font-weight-bold mb-0 text-center">
                                                            {{ $loop->iteration }}</p>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $item->jenis ?? '-' }}</p>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <p class="text-xs font-weight-bold mb-0 text-center">
                                                            {{ $item->tipe ?? '-' }}</p>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <p class="text-xs font-weight-bold mb-0 text-center">
                                                            {{ $item->tgl ?? '-' }}</p>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <p class="text-xs font-weight-bold mb-0 text-center">
                                                            {{ $item->deskripsi ?? '-' }}</p>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <p class="text-xs font-weight-bold mb-0 text-center">
                                                            @if ($item->poin < 0)
                                                                <span class="text-danger">
                                                                    {{ $item->poin ?? '0' }}
                                                                </span>
                                                            @else
                                                                <span class="text-success">
                                                                    {{ $item->poin ?? '0' }}
                                                                </span>
                                                            @endif
                                                        </p>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <form id="delete-pelanggaran-{{ $item->id }}"
                                                            action="{{ route('assessment.holistic.destroy', $item->id) }}"
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
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambah" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('assessment.holistic.store') }}">
                    @csrf
                    @method('POST')
                    <div class="modal-header">
                        <h6 class="font-weight-bolder text-black mb-0">Holistic Assessment</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-2">
                                    <label for="editName" class="form-label">Tipe</label>
                                    <select class="form-select" id="editName" name="jenis"
                                        style="height: 30px; padding: 2px 8px; font-size: 0.8rem;">
                                        <option value="" selected disabled>Pilih jenis...</option>
                                        <option value="Reward">Reward</option>
                                        <option value="Punishment">Punishment</option>
                                    </select>
                                </div>
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
                                <div class="mb-2">
                                    <label for="editName" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" id="editName" name="tgl"
                                        style="height: 30px; padding: 2px 8px; font-size: 0.8rem;"
                                        placeholder="Tanggal...">
                                    <input type="hidden" name="mhs_id" value="{{ $detail['mhs_id'] }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-2">
                                    <label for="editName" class="form-label">Deskripsi</label>
                                    <textarea type="date" class="form-control" id="editName" name="deskripsi"
                                        style="height: 170px; padding: 2px 8px; font-size: 0.8rem;" placeholder="Deskripsi..."></textarea>
                                </div>
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

    <script>
        function confirmdeletePelanggaran(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus holistic ini?',
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
