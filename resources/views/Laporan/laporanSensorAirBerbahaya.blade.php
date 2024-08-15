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
            text-align: center;
        }

        .sensor-data-table th {
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
            margin-top: 30px;
            font-family: 'Book Antiqua', serif;
        }

        .print-button {
            text-align: center;
            margin-top: 20px;
        }

        .summary {
            text-align: center;
            margin-top: 20px;
        }

        .filter-form {
            margin-top: 20px;
        }

        .filter-form .col-md-3, .filter-form .col-md-2 {
            margin-bottom: 10px;
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
        <h1>Laporan Keterangan Sensor Air - Berbahaya</h1>

        <form method="GET" action="{{ route('laporanSensorAirBerbahaya') }}" class="filter-form">
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <input type="date" name="start_date" class="form-control" required placeholder="Tanggal Mulai">
                </div>
                <div class="col-md-3">
                    <input type="date" name="end_date" class="form-control" required placeholder="Tanggal Akhir">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Lihat Laporan</button>
                </div>
            </div>
        </form>

        <div class="print-button">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cetakModal">Cetak</button>
        </div>

        <div class="sensor-data-container">
            <table class="sensor-data-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jumlah Berbahaya</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dailySummary as $summary)
                    <tr>
                        <td>{{ $summary['date'] }}</td>
                        <td>{{ $summary['berbahayaCount'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="cetakModal" tabindex="-1" aria-labelledby="cetakModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cetakModalLabel">Cetak Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="GET" action="{{ route('cetakSensorAirBerbahaya') }}">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Tanggal Akhir</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Cetak</button>
                </form>
            </div>
        </div>
    </div>
</div>

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

</body>
</html>