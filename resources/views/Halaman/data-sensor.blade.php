<!DOCTYPE html>
<html lang="en">
<head>
    @include('tools.header')
    <style>
        body {
            font-family: 'Book Antiqua', serif;
            background-image: linear-gradient(45deg, #61E44C, #E2EAF4, #EFC3CA, #E2EAF4);
            background-size: 400% 400%;
            animation: gradientAnimation 10s ease infinite;
        }

        @keyframes gradientAnimation {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        .sensor-data-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .sensor-data-table th,
        .sensor-data-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center; /* Center-align text */
        }

        .sensor-data-table th {
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center; /* Center-align title */
            margin-top: 30px;
            font-family: 'Book Antiqua', serif;
        }

        #combinedChart {
            margin-top: 20px;
            width: 80%;
            max-width: 800px; /* Set the max-width to make the chart narrower */
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
<header id="header" class="header fixed-top d-flex align-items-center" style="background-image: linear-gradient(245.59deg, #D6A4A4, #DAE2F8);">
    <div class="d-flex align-items-center justify-content-between">
        <img src="images/logomonstera.png" alt="" style="max-width: 50px; max-height: 50px;">
        <span class="d-none d-lg-block" style="font-size: 24px; font-weight: bold;">SPS</span>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    @include('tools.navbar')
</header>

<aside id="sidebar" class="sidebar">
    @include('tools.sidebar')
</aside>

<main id="main" class="main">
    <div>
        <h1>Data Sensor</h1> <!-- Center-aligned title -->
        <div class="sensor-data-container">
            <table class="sensor-data-table">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Waktu Deteksi Sampah</th>
                        <th>Hasil Deteksi Sampah</th>
                        <th>Keterangan</th>
                        <th>Waktu Ketinggian Air</th>
                        <th>Ketinggian Air</th>
                        <th>Keterangan</th>
                        <th>Waktu Tempat Sampah</th>
                        <th>Tinggi Sampah</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $maxRows = max(count($deteks), count($dtair), count($tsampah));
                    @endphp
                    @for ($i = 0; $i < $maxRows; $i++)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $deteks[$i]->created_at ?? '' }}</td>
                        <td>{{ $deteks[$i]->nilai_deteksi ?? '' }}</td>
                        <td>{{ $deteks[$i]->keterangan ?? '' }}</td>
                        <td>{{ $dtair[$i]->created_at ?? '' }}</td>
                        <td>{{ $dtair[$i]->nilai_tinggi_air ?? '' }}</td>
                        <td>{{ $dtair[$i]->keterangan ?? '' }}</td>
                        <td>{{ $tsampah[$i]->created_at ?? '' }}</td>
                        <td>{{ $tsampah[$i]->nilai_tinggi_sampah ?? '' }}cm</td>
                        <td>{{ $tsampah[$i]->keterangan ?? '' }}</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>

    <!-- Grafik Gabungan -->
    <canvas id="combinedChart"></canvas>
</main>

<footer id="footer" class="footer">
    <div class="copyright">
        &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
</footer>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

@include('tools.script')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data dari PHP
    var waktuDeteksiSampah = {!! json_encode($deteks->pluck('created_at')->toArray()) !!};
    var hasilDeteksiSampah = {!! json_encode($deteks->pluck('nilai_deteksi')->toArray()) !!};
    var waktuKetinggianAir = {!! json_encode($dtair->pluck('created_at')->toArray()) !!};
    var ketinggianAir = {!! json_encode($dtair->pluck('nilai_tinggi_air')->toArray()) !!};
    var waktuTempatSampah = {!! json_encode($tsampah->pluck('created_at')->toArray()) !!};
    var tinggiSampah = {!! json_encode($tsampah->pluck('nilai_tinggi_sampah')->toArray()) !!};

    // Menggabungkan semua waktu (diasumsikan sama)
    var labels = waktuDeteksiSampah;

    // Menggabungkan data dari ketiga sensor dengan menambahkan kondisi untuk panjang garis
    var dataDeteksiSampah = hasilDeteksiSampah.map((value) => ({ x: null, y: value, borderWidth: (value > 80) ? 3 : 1 }));
    var dataKetinggianAir = ketinggianAir.map((value) => ({ x: null, y: value, borderWidth: (value > 100) ? 3 : 1 }));
    var dataTinggiSampah = tinggiSampah.map((value) => ({ x: null, y: value, borderWidth: (value > 50) ? 3 : 1 }));

    // Menampilkan grafik gabungan
    var ctx = document.getElementById('combinedChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Deteksi Sampah',
                    data: dataDeteksiSampah,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    yAxisID: 'yAxisDeteksiSampah'
                },
                {
                    label: 'Ketinggian Air',
                    data: dataKetinggianAir,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    yAxisID: 'yAxisKetinggianAir'
                },
                {
                    label: 'Tinggi Sampah',
                    data: dataTinggiSampah,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    yAxisID: 'yAxisTinggiSampah'
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                },
                yAxisDeteksiSampah: {
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Deteksi Sampah'
                    }
                },
                yAxisKetinggianAir: {
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Ketinggian Air'
                    },
                    grid: {
                        display: false
                    }
                },
                yAxisTinggiSampah: {
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Tinggi Sampah'
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>

</body>
</html>
