@extends('component.layout2')

@section('title')
    Assessment Detail
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
    {{ $jadwal->nama_kegiatan ?? 'Detail Assessment' }}
@endsection

@section('konten')
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 font-weight-bolder">Assessment Data</h6>

                        @if ($member->count() > 0)
                            <div class="d-flex">
                                <form method="GET" action="" class="d-flex">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        class="form-control form-control-sm me-2"
                                        style="height: 30px; padding: 2px 8px; font-size: 0.8rem;"
                                        placeholder="Cari mahasiswa/i...">
                                    <button type="submit" class="btn btn-sm btn-outline-primary"
                                        style="height: 30px; padding: 0 10px;">
                                        <i class="ti ti-search"></i>
                                    </button>
                                </form>
                                <button type="button" class="btn btn-sm btn-outline-primary ms-2"
                                    style="height: 30px; padding: 0 10px;" data-bs-toggle="modal" data-bs-target="#tambah">
                                    <i class="ti ti-plus me-2"></i> Tambah Kehadiran
                                </button>
                            </div>
                        @endif
                    </div>

                    <div class="card-body responsive px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <form method="POST" action="{{ route('assessment.store_kehadiran') }}">
                                @csrf
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                No</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Nama Mahasiswa</th>
                                            @foreach ($quantity as $item)
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    {{ $item->deskripsi }}</th>
                                            @endforeach
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $filteredmember = $member;
                                            if (request('search')) {
                                                $filteredmember = $member->filter(function ($item) {
                                                    return stripos($item->name, request('search')) !== false;
                                                });
                                            }

                                            // Hitung jumlah kolom: No + Nama + quantity + Aksi
                                            $colspan = 2 + count($quantity) + 1;
                                        @endphp

                                        @forelse ($filteredmember as $index => $member)
                                            <tr>
                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $member->mhs_nama }}</p>
                                                </td>
                                                @foreach ($quantity as $item)
                                                    <td class="text-center">
                                                        <select class="form-select form-select-sm status-select"
                                                            name="kehadiran[{{ $member->mhs_id }}][{{ $item->id }}]"
                                                            style="height: 30px; padding: 2px 8px; font-size: 0.8rem;">
                                                            <option value="" disabled
                                                                {{ !isset($kehadiran[$member->mhs_id][$item->id]) ? 'selected' : '' }}>
                                                                Pilih
                                                            </option>
                                                            <option value="Hadir"
                                                                {{ isset($kehadiran[$member->mhs_id][$item->id]) && $kehadiran[$member->mhs_id][$item->id] == 'Hadir' ? 'selected' : '' }}>
                                                                Hadir
                                                            </option>
                                                            <option value="Alfa"
                                                                {{ isset($kehadiran[$member->mhs_id][$item->id]) && $kehadiran[$member->mhs_id][$item->id] == 'Alfa' ? 'selected' : '' }}>
                                                                Alfa
                                                            </option>
                                                            <option value="Izin"
                                                                {{ isset($kehadiran[$member->mhs_id][$item->id]) && $kehadiran[$member->mhs_id][$item->id] == 'Izin' ? 'selected' : '' }}>
                                                                Izin
                                                            </option>
                                                            <option value="Sakit"
                                                                {{ isset($kehadiran[$member->mhs_id][$item->id]) && $kehadiran[$member->mhs_id][$item->id] == 'Sakit' ? 'selected' : '' }}>
                                                                Sakit
                                                            </option>
                                                        </select>
                                                    </td>
                                                @endforeach
                                                <td class="align-middle text-center">
                                                    <div class="d-inline-flex align-items-center">
                                                        <button type="button"
                                                            class="btn btn-outline-danger text-danger font-weight-bold text-xs p-2 m-0 d-inline-flex align-items-center"
                                                            data-bs-toggle="tooltip" title="Hapus"
                                                            style="height: 30px; padding: 0 10px;"
                                                            onclick="confirmDeletemember({{ $member->id }})">
                                                            <i class="ti ti-trash me-2"></i> Hapus
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="{{ $colspan }}" class="text-center text-muted">
                                                    <img src="{{ asset('assets/img/nodata.png') }}" alt="No data"
                                                        style="width: 250px; height: auto;">
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>

                                </table>
                                @if ($member->count() > 0)
                                    <div class="text-end" style="margin: 20px;">
                                        <button type="submit"
                                            class="btn btn-outline-primary text-primary font-weight-bold text-xs p-2 m-0 d-inline-flex align-items-center"
                                            data-bs-toggle="tooltip" style="height: 30px; padding: 0 10px;">
                                            <i class="ti ti-device-floppy me-2"></i> Simpan
                                        </button>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                    <form id="delete-member-form" method="POST" style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambah" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('assessment.store_quantity') }}">
                    @csrf
                    @method('POST')
                    <div class="modal-header">
                        <h6 class="font-weight-bolder text-black mb-0">Tambah Kehadiran</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleInput" class="form-label">Deskripsi</label>
                            <input type="text" class="form-control" id="exampleInput" name="deskripsi"
                                style="height: 30px; padding: 2px 8px; font-size: 0.8rem;" placeholder="Deskripsi...">
                            <input type="hidden" value="{{ $jadwal->jadwal_pengampu_id ?? $jadwal->id }}"
                                name="jadwal_pengampu_id">
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
        function confirmDeletemember(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus anggota ini?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.getElementById('delete-member-form');
                    form.action = "/assessment/member/delete/" + id; // sesuaikan dengan route('member.destroy', id)
                    form.submit();
                }
            });
        }
    </script>

    <script>
        document.querySelectorAll('.status-select').forEach(select => {
            function updateColor() {
                select.classList.remove('hadir', 'alfa', 'izin', 'sakit');
                if (select.value.toLowerCase() === 'hadir') select.classList.add('hadir');
                if (select.value.toLowerCase() === 'alfa') select.classList.add('alfa');
                if (select.value.toLowerCase() === 'izin') select.classList.add('izin');
                if (select.value.toLowerCase() === 'sakit') select.classList.add('sakit');
            }
            select.addEventListener('change', updateColor);
            updateColor(); // panggil saat load awal biar langsung sesuai database
        });
    </script>

@endsection
