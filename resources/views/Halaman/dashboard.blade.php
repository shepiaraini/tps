<!DOCTYPE html>
<html lang="en">

<head>
    @include('tools.header')
    <style>
        body {
            font-family: 'Book Antiqua', serif;
        }

        .pagetitle h1,
        .breadcrumb-item a,
        .card-header,
        .card-body,
        .nav-link span,
        .footer span,
        .credits a {
            font-family: 'Book Antiqua', serif;
        }

        .chart-container {
            position: relative;
            height: 400px;
        }

        .donut-chart {
            position: relative;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            border: 10px solid #4BC0C0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        .donut-chart.bahaya {
            border-color: #dc3545; /* Red */
        }

        .donut-chart .value {
            font-size: 24px;
            font-weight: bold;
        }

        .card {
            height: 400px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .card-header {
            font-size: 18px;
            font-weight: bold;
            background-color: #f2f2f2;
            width: 100%;
            text-align: center;
            padding: 10px 0;
        }

        .card-body {
            width: 100%;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                <img src="assets/img/logo.png" alt="">
                <span class="d-none d-lg-block">SPS</span>
            </a>
            <i class="bi bi-list fs-3 toggle-sidebar-btn"></i>
        </div>
        @include('tools.navbar')
    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
        @include('tools.sidebar')
    </aside><!-- End Sidebar-->

    <main id="main" class="main">
        <div class="container-fluid">
            <div class="pagetitle">
                <h1>Dashboard</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->

            <div class="row">
                <!-- Ketinggian Air -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Ketinggian Air</div>
                        <div class="card-body">
                            <canvas id="tinggiAirChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Ketinggian Air Terakhir</div>
                        <div class="card-body">
                            <div class="donut-chart" id="donutTinggiAir">
                                <div class="value" id="lastTinggiAir">0 cm</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tinggi Sampah -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Volume Sampah</div>
                        <div class="card-body">
                            <canvas id="tinggiSampahChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Volume Sampah Terakhir</div>
                        <div class="card-body">
                            <div class="donut-chart" id="donutTinggiSampah">
                                <div class="value" id="lastTinggiSampah">0 cm3</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Deteksi Sampah -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Deteksi Sampah</div>
                        <div class="card-body">
                            <canvas id="deteksiSampahChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Deteksi Sampah Terakhir</div>
                        <div class="card-body">
                            <div class="donut-chart" id="donutDeteksiSampah">
                                <div class="value" id="lastDeteksiSampah">0</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short fs-3"></i>
    </a>

    @include('tools.script')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/luxon@2/build/global/luxon.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon"></script>

    <script>
        // Data fetching function
        async function fetchData() {
            const response = await fetch('/api/sensordata');
            const data = await response.json();
            return data;
        }

        // Initialize charts
        const ctxTinggiAir = document.getElementById('tinggiAirChart').getContext('2d');
        const ctxDeteksiSampah = document.getElementById('deteksiSampahChart').getContext('2d');
        const ctxTinggiSampah = document.getElementById('tinggiSampahChart').getContext('2d');

        let tinggiAirChart = new Chart(ctxTinggiAir, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Ketinggian Air',
                    data: [],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'second',
                            tooltipFormat: 'yyyy-LL-dd HH:mm:ss'
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        let deteksiSampahChart = new Chart(ctxDeteksiSampah, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Deteksi Sampah',
                    data: [],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'second',
                            tooltipFormat: 'yyyy-LL-dd HH:mm:ss'
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        let tinggiSampahChart = new Chart(ctxTinggiSampah, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Volume Sampah',
                    data: [],
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'second',
                            tooltipFormat: 'yyyy-LL-dd HH:mm:ss'
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Update charts
        function updateCharts(data) {
            const { tair, tempatsampah, deteksisampah } = data;

            // Update Ketinggian Air chart
            const tinggiAirLabels = tair.map(entry => entry.created_at);
            const tinggiAirData = tair.map(entry => entry.nilai_tinggi_air);

            tinggiAirChart.data.labels = tinggiAirLabels;
            tinggiAirChart.data.datasets[0].data = tinggiAirData.map((nilai, index) => ({
                x: tinggiAirLabels[index],
                y: nilai
            }));
            tinggiAirChart.data.datasets[0].borderColor = tinggiAirData.map(nilai => nilai >= 5 ? 'rgba(255, 99, 132, 1)' : 'rgba(75, 192, 192, 1)');
            tinggiAirChart.update();

            // Update Deteksi Sampah chart
            const deteksiSampahLabels = deteksisampah.map(entry => entry.created_at);
            const deteksiSampahData = deteksisampah.map(entry => entry.nilai_deteksi);

            deteksiSampahChart.data.labels = deteksiSampahLabels;
            deteksiSampahChart.data.datasets[0].data = deteksiSampahData.map((nilai, index) => ({
                x: deteksiSampahLabels[index],
                y: nilai
            }));
            deteksiSampahChart.update();

            // Update Tinggi Sampah chart
            const tinggiSampahLabels = tempatsampah.map(entry => entry.created_at);
            const tinggiSampahData = tempatsampah.map(entry => ({
                x: entry.created_at,
                y: entry.nilai_tinggi_sampah * 17 * 12,
                keterangan: entry.keterangan
            }));

            tinggiSampahChart.data.labels = tinggiSampahLabels;
            tinggiSampahChart.data.datasets[0].data = tinggiSampahData.map(entry => ({
                x: entry.x,
                y: entry.y
            }));
            tinggiSampahChart.data.datasets[0].borderColor = tinggiSampahData.map(entry => entry.keterangan === "TEMPAT SAMPAH PENUH" ? 'rgba(255, 99, 132, 1)' : 'rgba(153, 102, 255, 1)');
            tinggiSampahChart.update();

            // Update last values and apply styles
            const lastTinggiAir = document.getElementById('lastTinggiAir');
            lastTinggiAir.innerText = `${tair[0].nilai_tinggi_air} cm`;
            if (tair[0].nilai_tinggi_air >= 5) {
                document.getElementById('donutTinggiAir').classList.add('bahaya');
            } else {
                document.getElementById('donutTinggiAir').classList.remove('bahaya');
            }

            const lastDeteksiSampah = document.getElementById('lastDeteksiSampah');
            lastDeteksiSampah.innerText = `${deteksisampah[0].nilai_deteksi}`;

            const lastTinggiSampah = document.getElementById('lastTinggiSampah');
            lastTinggiSampah.innerText = `${tempatsampah[0].nilai_tinggi_sampah * 17 * 12} cm3`;
            if (tempatsampah[0].keterangan === "TEMPAT SAMPAH PENUH") {
                document.getElementById('donutTinggiSampah').classList.add('bahaya');
            } else {
                document.getElementById('donutTinggiSampah').classList.remove('bahaya');
            }
        }

        // Initial fetch and update
        fetchData().then(data => updateCharts(data));

        setInterval(() => {
            fetchData().then(data => updateCharts(data));
        }, 000);
    </script>

</body>

</html>
