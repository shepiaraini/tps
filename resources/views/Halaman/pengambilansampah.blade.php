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
        <h1>Keputusan Berdasarkan Data Sensor</h1> <!-- Center-aligned title -->
        <h2>Nilai Terbaru</h2>
        <div class="sensor-data-container">
            <table class="sensor-data-table">
                <thead>
                    <tr>
                        <th>Indikator</th>
                        <th>Nilai Terakhir</th>
                        <th>Kategori</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Tanggal / Waktu</td>
                        <td>{{ $latestValues['created_at'] ? $latestValues['created_at'] : 'Data tidak tersedia' }}</td>
                    </tr>
                    <tr>
                        <td>Deteksi Sampah</td>
                        <td>{{ isset($latestValues['deteksisampah']) ? $latestValues['deteksisampah'] : 'Data tidak tersedia' }}</td>
                        <td>{{ isset($latestValues['deteksisampah']) ? $kategori['sampah'] : 'Data tidak tersedia' }}</td>
                    </tr>
                    <tr>
                        <td>Tinggi Air</td>
                        <td>{{ isset($latestValues['tinggiair']) ? $latestValues['tinggiair'] . " Cm" : 'Data tidak tersedia' }}</td>
                        <td>{{ isset($latestValues['tinggiair']) ? $kategori['tinggiAir'] : 'Data tidak tersedia' }}</td>
                    </tr>
                    <tr>
                        <td>Tempat Sampah</td>
                        <td>{{ isset($latestValues['tempatsampah']) ? $latestValues['tempatsampah'] . " Cm³" : 'Data tidak tersedia' }}</td>
                        <td>{{ isset($latestValues['tempatsampah']) ? $kategori['tempatSampah'] : 'Data tidak tersedia' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <h2>Hasil</h2> <!-- Center-aligned title -->
        <div class="sensor-data-container">
            <table class="sensor-data-table">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$output_kondisi}}</td>
                        <td>{{$tindakan}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <BR><BR>
        <h2>History</h2>
        <div class="sensor-data-container">
            <table class="sensor-data-table">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Deteksi Sampah</th>
                        <th>Tinggi Air</th>
                        <th>Tempat Sampah</th>
                        <th>Status</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latestDataHasil as $history)
                    <tr>
                        <td>{{ $history['created_at'] }}</td>
                        <td>{{ $history['deteksisampah'] }}</td>
                        <td>{{ $history['tinggiair'] }}</td>
                        <td>{{ $history['tempatsampah'] }}</td>
                        <td>{{ $history['output_kondisi'] }}</td>
                        <td>{{ $history['tindakan'] }}</td>
                    </tr>
                    @endforeach
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

</body>
</html>
