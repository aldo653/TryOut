@extends('component.layout2')

@section('title')
    Holistic Assessment Management
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
                        <h6 class="mb-4 font-weight-bolder">Holistic Assessment Data</h6>
                        <div class="d-flex">
                            <form method="GET" action="" class="d-flex">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control form-control-sm me-2"
                                    style="height: 30px; padding: 2px 8px; font-size: 0.8rem;"
                                    placeholder="Cari mahasiswa...">
                                <button type="submit" class="btn btn-sm btn-outline-primary"
                                    style="height: 30px; padding: 0 10px;"> <i class="ti ti-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="container my-4">
                    <div class="row g-3">
                        @foreach ($nilai_mhs as $item)
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="card h-100 shadow-sm"
                                    style="background-image: url('{{ asset('assets/img/bg-card.png') }}'); background-size: cover; background-position: center;">
                                    <div class="card-body text-center">
                                        @if ($item->gender == 'Perempuan')
                                            <img src="{{ asset('assets/img/user-6.jpg') }}" width="50px" height="50px"
                                                class="mb-3 rounded-circle" alt="logo">
                                        @else
                                            <img src="{{ asset('assets/img/user-7.jpg') }}" width="50px" height="50px"
                                                class="mb-3 rounded-circle" alt="logo">
                                        @endif
                                        <h6 class="mb-1" style="font-size: 17px;">
                                            {{ $item->mhs_name ?? 'Tidak ada nama kegiatan' }}</h6>
                                        <h6 class="card-subtitle text-muted mb-2" style="font-size: 14px;">
                                            {{ $item->nip_nim ?? 'Tidak diketahui' }}
                                        </h6>

                                        @php
                                            $class = '';
                                            if ($item->nilai_total >= 0 && $item->nilai_total <= 50) {
                                                $class = 'text-danger';
                                            } elseif ($item->nilai_total >= 51 && $item->nilai_total <= 69) {
                                                $class = 'text-warning';
                                            } elseif ($item->nilai_total >= 70 && $item->nilai_total <= 100) {
                                                $class = 'text-success';
                                            }
                                        @endphp

                                        <b class="{{ $class }}" style="font-size: 15px;">- {{ $item->nilai_total }}
                                            -</b>
                                    </div>
                                    <div class="mb-2 text-center">
                                        @if ($item->nilai_total >= 60 && $item->nilai_total <= 69)
                                            <button class="btn btn-sm btn-outline-danger assign-btn w-60"
                                                data-id="{{ $item->mhs_id }}" data-nim="{{ $item->nip_nim }}"
                                                data-nama="{{ $item->mhs_name }}" data-tipe="SP1" data-bs-toggle="modal"
                                                data-bs-target="#sp">
                                                <span class="btn-text"><i class="ti ti-alert-triangle me-2"></i> Peringatan
                                                    1</span>
                                                <span class="spinner-border spinner-border-sm d-none" role="status"
                                                    aria-hidden="true"></span>
                                            </button>
                                        @elseif ($item->nilai_total >= 50 && $item->nilai_total <= 59)
                                            <button class="btn btn-sm btn-outline-danger assign-btn w-60"
                                                data-id="{{ $item->mhs_id }}" data-nim="{{ $item->nip_nim }}"
                                                data-nama="{{ $item->mhs_name }}" data-tipe="SP2" data-bs-toggle="modal"
                                                data-bs-target="#sp">
                                                <span class="btn-text"><i class="ti ti-alert-triangle me-2"></i> Peringatan
                                                    2</span>
                                                <span class="spinner-border spinner-border-sm d-none" role="status"
                                                    aria-hidden="true"></span>
                                            </button>
                                        @elseif ($item->nilai_total < 50)
                                            <button class="btn btn-sm btn-outline-danger assign-btn w-60"
                                                data-id="{{ $item->mhs_id }}" data-nim="{{ $item->nip_nim }}"
                                                data-nama="{{ $item->mhs_name }}" data-tipe="SP3" data-bs-toggle="modal"
                                                data-bs-target="#sp">
                                                <span class="btn-text"><i class="ti ti-alert-triangle me-2"></i> Peringatan
                                                    3</span>
                                                <span class="spinner-border spinner-border-sm d-none" role="status"
                                                    aria-hidden="true"></span>
                                            </button>
                                        @endif
                                        <a class="btn btn-sm btn-outline-primary assign-btn w-60"
                                            href="{{ route('assessment.holistic.detail', $item->mhs_id) }}"
                                            data-id="{{ $item->id }}">
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

    <div class="modal fade" id="sp" tabindex="-1" aria-labelledby="sp" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <form id="form-sp" method="POST" action="#">
                    @csrf
                    <div class="modal-header">
                        <h6 class="font-weight-bolder text-black mb-0">Surat Peringatan</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nim" class="form-label">NIM</label>
                                    <input type="text" class="form-control" id="tipe" name="tipe"
                                        style="height: 30px; padding: 2px 8px; font-size: 0.8rem;" placeholder="Tipe..."
                                        readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="no_surat" class="form-label">No Surat</label>
                                    <input type="text" class="form-control" id="no_surat" name="no_surat"
                                        style="height: 30px; padding: 2px 8px; font-size: 0.8rem;"
                                        placeholder="No. Surat..." required>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nim" class="form-label">NIM</label>
                                    <input type="text" class="form-control" id="nim" name="nim"
                                        style="height: 30px; padding: 2px 8px; font-size: 0.8rem;" placeholder="NIM..."
                                        readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nip_nim" class="form-label">Nama Mahasiswa</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        style="height: 30px; padding: 2px 8px; font-size: 0.8rem;" placeholder="Nama..."
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nim" class="form-label">Alasan</label>
                                    <input type="text" class="form-control" id="alasan" name="alasan"
                                        style="height: 30px; padding: 2px 8px; font-size: 0.8rem;"
                                        placeholder="Alasan..." required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nip_nim" class="form-label">Tenggat Waktu</label>
                                    <input type="date" class="form-control" id="tenggat" name="tenggat"
                                        style="height: 30px; padding: 2px 8px; font-size: 0.8rem;"
                                        placeholder="Tanggal..." required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            style="height: 30px; padding: 0 10px;" data-bs-dismiss="modal"><i
                                class="ti ti-x me-2"></i>Batal</button>
                        <button type="submit" class="btn btn-sm btn-outline-primary"
                            style="height: 30px; padding: 0 10px;"><i class="ti ti-refresh me-2"></i>Generate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = document.getElementById('sp');
            modal.addEventListener('show.bs.modal', function(event) {
                let button = event.relatedTarget;
                let id = button.getAttribute('data-id'); 
                let nim = button.getAttribute('data-nim');
                let nama = button.getAttribute('data-nama');
                let tipe = button.getAttribute('data-tipe');

                modal.querySelector('#nim').value = nim;
                modal.querySelector('#nama').value = nama;
                modal.querySelector('#tipe').value = tipe;

                let form = modal.querySelector('#form-sp');
                form.action = `/pdf/sp1/${id}`;
            });
        });
    </script>
@endsection
