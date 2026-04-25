{{-- @extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <!-- Bagian statistik card (4 card atas) -->
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Barang</p>
                                <h5 class="font-weight-bolder mb-0">
                                    1,245
                                    <span class="text-success text-sm font-weight-bolder">+12%</span>
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="ni ni-box text-lg opacity-10"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Barang Dipinjam</p>
                                <h5 class="font-weight-bolder mb-0">
                                    342
                                    <span class="text-success text-sm font-weight-bolder">+8%</span>
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="ni ni-cart text-lg opacity-10"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Peminjam Aktif</p>
                                <h5 class="font-weight-bolder mb-0">
                                    187
                                    <span class="text-danger text-sm font-weight-bolder">-5%</span>
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="ni ni-single-02 text-lg opacity-10"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Pengembalian Hari Ini</p>
                                <h5 class="font-weight-bolder mb-0">
                                    45
                                    <span class="text-success text-sm font-weight-bolder">+15%</span>
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="ni ni-check-bold text-lg opacity-10"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contoh bagian chart atau table (sesuaikan dengan kebutuhan app kamu) -->
    <div class="row mt-4">
        <div class="col-lg-7 mb-lg-0 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Statistik Peminjaman Bulanan</h6>
                    <p class="text-sm">
                        <i class="fa fa-arrow-up text-success"></i>
                        <span class="font-weight-bold">15% lebih banyak</span> dibanding bulan lalu
                    </p>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <!-- Canvas untuk chart (akan diisi script di bawah) -->
                        <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6>Peminjaman Terbaru</h6>
                </div>
                <div class="card-body p-3">
                    <!-- Daftar peminjaman terbaru bisa di-loop dari controller -->
                    <ul class="list-group">
                        <li class="list-group-item border-0 px-0 py-2">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape icon-sm me-3 bg-gradient-primary shadow text-center">
                                    <i class="ni ni-single-02 text-white"></i>
                                </div>
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-sm">Yuri meminjam Laptop Dell</h6>
                                    <span class="text-xs">28 Feb 2026, 10:30 WIB</span>
                                </div>
                            </div>
                        </li>
                        <!-- Tambah item lain sesuai data -->
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <!-- Script Chart.js untuk dashboard -->
    <script>
        var ctx2 = document.getElementById("chart-line").getContext("2d");

        var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);
        gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
        gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
        gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)');

        var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);
        gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
        gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
        gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)');

        new Chart(ctx2, {
            type: "line",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul"],
                datasets: [{
                    label: "Peminjaman",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#cb0c9f",
                    borderWidth: 3,
                    backgroundColor: gradientStroke1,
                    fill: true,
                    data: [50, 80, 120, 150, 200, 180, 220],
                },
                {
                    label: "Pengembalian",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#3A416F",
                    borderWidth: 3,
                    backgroundColor: gradientStroke2,
                    fill: true,
                    data: [40, 70, 110, 140, 190, 170, 210],
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                interaction: { intersect: false, mode: 'index' },
                scales: {
                    y: { grid: { drawBorder: false, display: true, drawOnChartArea: true, drawTicks: false, borderDash: [5, 5] }, ticks: { display: true, padding: 10, color: '#b2b9bf', font: { size: 11, family: "Open Sans" } } },
                    x: { grid: { drawBorder: false, display: false, drawOnChartArea: false, drawTicks: false, borderDash: [5, 5] }, ticks: { display: true, color: '#b2b9bf', padding: 20, font: { size: 11, family: "Open Sans" } } }
                }
            }
        });
    </script>
@endsection --}}