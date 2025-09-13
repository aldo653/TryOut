@extends('component.layout')

@section('title')
    Dashboard
@endsection

@section('head')
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css?v=2.1.0') }}" rel="stylesheet" />
@endsection


@section('crw1')
    Home
@endsection

@section('crw2')
    Dashboard
@endsection

@section('Dashboard')

@section('konten')

    <body class="g-sidenav-show   bg-gray-100">
        <div class="min-height-300 bg-dark position-absolute w-100"></div>
        @include('component.sidebar')
        <main class="main-content position-relative border-radius-lg ">
            @include('component.header')
            <div class="container-fluid py-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <!-- Bagian kiri gambar -->
                                <div class="col-md-3 text-center" style="margin: -40px;">
                                    <div id="lottie-container" style="width: 200px; height: 200px; margin: auto;"></div>
                                </div>
                                <div class="col-md-9">
                                    <strong class="fw-bold text-primary mb-2" style="font-size: 20px;">
                                        Sistem Informasi Manajemen Administrasi
                                    </strong><br>
                                    <b class="fw-semibold text-dark">
                                        Ma'had Al Jamiah UIN Raden Fatah Palembang
                                    </b><br>
                                    <p class="text-sm font-weight-bold mb-0">
                                        Sistem ini dirancang untuk mendukung proses penilaian yang lebih
                                        transparan, terintegrasi, dan mudah diakses oleh seluruh civitas akademika.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 col-md-6 col-md-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <strong>Grafik Riwayat Poin</strong>

                                    <div class="d-flex align-items-center">
                                        @if (Auth::user()->gender == 'Laki-Laki')
                                            <img src="{{ asset('assets/img/user-7.jpg') }}" alt="Profile"
                                                class="me-2 rounded-circle"
                                                style="width: 25px; height: 25px; object-fit: cover;">
                                        @elseif(Auth::user()->gender == 'Perempuan')
                                            <img src="{{ asset('assets/img/user-6.jpg') }}" alt="Profile"
                                                class="me-2 rounded-circle"
                                                style="width: 25px; height: 25px; object-fit: cover;">
                                        @endif
                                        @if ($nilai_mhs->nilai_total >= 50)
                                            <strong class="fw-semibold text-success">{{ $nilai_mhs->nilai_total }}</strong>
                                        @elseif($nilai_mhs->nilai_total >= 4)
                                            <strong class="fw-semibold text-warning">{{ $nilai_mhs->nilai_total }}</strong>
                                        @elseif($nilai_mhs->nilai_total >= 3)
                                            <strong class="fw-semibold text-danger">{{ $nilai_mhs->nilai_total }}</strong>
                                        @endif

                                    </div>
                                </div>
                                <div class="card-body">
                                    <canvas id="grafikKegiatanPunishment"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-md-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <strong>Daftar Surat Panggilan</strong>
                                    @if ($nilai_mhs->status == 'Lulus')
                                        <button type="submit" class="btn btn-sm btn-outline-primary"
                                            style="height: 30px; padding: 0 10px;"><a class="text-primary" href="{{route('raport.download')}}"><i
                                                class="ti ti-file-download me-2"></i>Unduh Raport</a></button>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                    No</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    No. Surat</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                    Tenggat</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                    Perihal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($riwayat_sp as $index => $sp)
                                                <tr>
                                                    <td class="align-middle text-center">
                                                        <span
                                                            class="text-secondary text-xs font-weight-bold">{{ $index + 1 }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex px-2 py-1 align-items-center">
                                                            <div class="me-2 d-flex align-items-center">
                                                                <a href="{{ route('spmhs.download', $sp->id) }}"
                                                                    class="text-decoration-none">
                                                                    <i class="ti ti-file-text text-primary"
                                                                        style="font-size: 1.2rem; cursor: pointer;"></i>
                                                                </a>
                                                            </div>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $sp->no_surat }}</h6>
                                                                <p class="text-xs text-secondary mb-0">
                                                                    {{ $sp->created_at->format('d M Y') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span class="text-secondary text-xs font-weight-bold">
                                                            {{ \Carbon\Carbon::parse($sp->tenggat)->format('d M Y') }}
                                                        </span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <p class="text-xs text-secondary mb-0">{{ $sp->perihal }}</p>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4"
                                                            class="text-center py-4">
                                                            <img src="{{ asset('assets/img/nodata.png') }}"
                                                                alt="Tidak ada data" style="width: 120px; opacity: 0.7;">
                                                        <p class="text-muted mt-2 mb-0">Belum ada riwayat surat peringatan
                                                        </p>
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
            </div>
        </main>

        <!--   Core JS Files   -->
        <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js"></script>
        <script>
            // Inisialisasi Lottie
            lottie.loadAnimation({
                container: document.getElementById('lottie-container'),
                renderer: 'svg',
                loop: true,
                autoplay: true,
                path: "{{ asset('assets/img/learning.json') }}"
            });
        </script>

        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="../assets/js/argon-dashboard.min.js?v=2.1.0"></script>
        <script>
            // Data User per Role
            const rawData = @json($dataset);

            const labels = rawData.map(item => {
                const date = new Date(item.x);
                return date.toLocaleDateString('id-ID'); // format dd/mm/yyyy
            });

            const dataY = rawData.map(item => item.y);

            const ctx = document.getElementById('grafikKegiatanPunishment').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Poin Kegiatan & Punishment',
                        data: dataY,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                    }]
                },
                options: {
                    responsive: true,
                    interaction: {
                        mode: 'nearest',
                        intersect: false
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                // tampilkan custom tooltip
                                label: function(context) {
                                    const item = rawData[context.dataIndex];
                                    return `${item.type.toUpperCase()}: ${item.label} (Poin: ${item.y})`;
                                }
                            }
                        },
                        legend: {
                            display: true
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Tanggal'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Poin'
                            }
                        }
                    }
                }
            });
        </script>
    </body>
@endsection
