@extends('component.layout2')

@section('title')
    Assessment Management
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
    Assessment
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
                                        <a class="btn btn-sm btn-outline-primary assign-btn" href="{{ route('assessment.detail', $jadwal->id) }}"
                                            data-id="{{ $jadwal->id }}">
                                            <span class="btn-text"><i class="ti ti-pencil me-2"></i> Assessment</span>
                                            <span class="spinner-border spinner-border-sm d-none" role="status"
                                                aria-hidden="true"></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
