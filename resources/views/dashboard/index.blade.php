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
                                <div class="card-header">
                                    <strong>Grafik Pengguna</strong>
                                </div>
                                <div class="card-body">
                                    <canvas id="grafikUser"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <strong>Grafik Jadwal</strong>
                                </div>
                                <div class="card-body">
                                    <canvas id="grafikJadwal"></canvas>
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
            const userLabels = {!! json_encode($user->pluck('name')) !!};
            const userData = {!! json_encode($user->pluck('users_count')) !!};

            const ctxUser = document.getElementById('grafikUser').getContext('2d');
            new Chart(ctxUser, {
                type: 'line',
                data: {
                    labels: userLabels,
                    datasets: [{
                        label: 'Jumlah User',
                        data: userData,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 3,
                        tension: 0.4, // bikin garis smooth
                        fill: true,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Data Jadwal per Hari
            const jadwalLabels = {!! json_encode($jadwal->pluck('hari')) !!};
            const jadwalData = {!! json_encode($jadwal->pluck('total')) !!};

            const ctxJadwal = document.getElementById('grafikJadwal').getContext('2d');
            new Chart(ctxJadwal, {
                type: 'line',
                data: {
                    labels: jadwalLabels,
                    datasets: [{
                        label: 'Jumlah Jadwal',
                        data: jadwalData,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 3,
                        tension: 0.4, // smooth curve, bukan patah
                        fill: true,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    </body>
@endsection
