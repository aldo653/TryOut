@extends('component.layout2')

@section('title')
    Assignment Management
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
    Assignment
@endsection

@section('konten')
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body pb-0 d-flex justify-content-between align-items-center">
                        <h6 class="mb-4 font-weight-bolder">Assignment Data</h6>
                        <div class="d-flex">
                            <form method="GET" action="" class="d-flex">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control form-control-sm me-2"
                                    style="height: 30px; padding: 2px 8px; font-size: 0.8rem;" placeholder="Cari jadwal...">
                                <button type="submit" class="btn btn-sm btn-outline-primary"
                                    style="height: 30px; padding: 0 10px;"> <i class="ti ti-search"></i>
                                </button>
                            </form>
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#tambahjadwal" style="height: 30px; padding: 0 10px; margin-left: 8px;">
                                <i class="ti ti-plus me-2"></i>Jadwal
                            </button>
                        </div>
                    </div>
                </div>
                <div class="container my-4">
                    <div class="row g-3">
                        @foreach ($jadwals as $jadwal)
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="card h-100 shadow-sm"
                                    style="background-image: url('{{ asset('assets/img/bg-card.png') }}'); background-size: cover; background-position: center;">
                                    <div class="card-body text-center">
                                        <img src="{{ asset('assets/img/Logo UIN.png') }}" width="50px" height="50px"
                                            class="mb-3" alt="logo">
                                        <h6 class="mb-1" style="font-size: 17px;">
                                            {{ $jadwal->nama_kegiatan ?? 'Tidak ada nama kegiatan' }}</h6>
                                        <h6 class="card-subtitle text-muted mb-2" style="font-size: 14px;">
                                            {{ $jadwal->pengampu_nama ?? 'Tidak diketahui' }}
                                        </h6>


                                        <p class="mb-1" style="font-size: 13px;">{{ ucfirst($jadwal->hari) }}</p>
                                        <p class="mb-1" style="font-size: 13px;">{{ $jadwal->waktu_mulai }} s.d
                                            {{ $jadwal->waktu_selesai }}</p>
                                        <p class="mb-1" style="font-size: 13px;">{{ $jadwal->lokasi ?? '-' }}</p>
                                        <p class="mb-0" style="font-size: 13px;">{{ $jadwal->deskripsi ?? '-' }}</p>
                                    </div>
                                    <div class="mb-2 text-center">
                                        @if ($jadwal->is_assigned)
                                            <button class="btn btn-sm btn-primary text-white unassign-btn"
                                                data-id="{{ $jadwal->id }}" data-memberId="{{ $jadwal->memberjadwal_id }}">
                                                <i class="ti ti-check me-2"></i> Assigned
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-outline-primary assign-btn"
                                                data-id="{{ $jadwal->id }}">
                                                <span class="btn-text"><i class="ti ti-pencil me-2"></i> Assign</span>
                                                <span class="spinner-border spinner-border-sm d-none" role="status"
                                                    aria-hidden="true"></span>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // === UNTUK ASSIGN ===
        document.querySelectorAll('.assign-btn').forEach(button => {
            button.addEventListener('click', function() {
                const jadwalId = this.getAttribute('data-id');
                const btn = this;
                const btnText = btn.querySelector('.btn-text');
                const spinner = btn.querySelector('.spinner-border');

                spinner.classList.remove('d-none');
                btn.disabled = true;

                fetch("{{ route('assignment.assign') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            jadwal_pengampu_id: jadwalId
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === "success") {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data berhasil di-assign!',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            // Ubah tombol jadi Unassign
                            btn.classList.remove('btn-outline-primary');
                            btn.classList.add('btn-primary', 'text-white', 'unassign-btn');
                            btn.innerHTML = '<i class="ti ti-check me-2"></i> Assigned';

                            window.location.reload(); // Reload halaman untuk memperbarui tampilan
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Gagal assign. Silakan coba lagi!',
                            });
                        }
                    })
                    .catch(() => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Silakan coba lagi nanti!',
                        });
                    })
                    .finally(() => {
                        spinner.classList.add('d-none');
                        btn.disabled = false;
                    });
            });
        });

        // === UNTUK UNASSIGN ===
        document.querySelectorAll('.unassign-btn').forEach(button => {
            button.addEventListener('click', function() {
                const memberId = this.getAttribute('data-memberId');
                const btn = this;

                Swal.fire({
                    title: 'Konfirmasi',
                    text: "Apakah Anda yakin ingin mengundurkan diri dari jadwal ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, keluar',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`{{ url('/assessment/member/delete') }}/${memberId}`, {
                                method: "DELETE",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                }
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.status === "success") {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: 'Anda berhasil keluar dari jadwal!',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });

                                    window.location.reload(); // Reload halaman untuk memperbarui tampilan
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: 'Tidak dapat keluar dari jadwal ini.'
                                    });
                                }
                            })
                            .catch(() => {
                                window.location.reload(); // Reload halaman jika terjadi error
                            });
                    }
                });
            });
        });
    </script>
@endsection
