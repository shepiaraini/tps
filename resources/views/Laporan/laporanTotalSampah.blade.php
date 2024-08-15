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
        font-size: 22px; /* Base font size increased to 22px */
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
        margin-top: 25px; /* Slightly increased */
        border-collapse: collapse;
    }

    .sensor-data-table th,
    .sensor-data-table td {
        border: 1px solid #ddd;
        padding: 12px; /* Increased padding */
        text-align: center;
        font-size: 22px; /* Increased to match base font size */
    }

    .sensor-data-table th {
        background-color: #f2f2f2;
        font-size: 24px; /* Slightly larger than base for headers */
    }

    h1 {
        text-align: center;
        margin-top: 35px; /* Slightly increased */
        font-family: 'Book Antiqua', serif;
        font-size: 44px; /* Doubled from original size */
    }

    .print-button {
        text-align: center;
        margin-top: 25px; /* Slightly increased */
    }

    .print-button button {
        margin-right: 12px; /* Slightly increased */
        font-size: 22px; /* Increased to match base font size */
        padding: 10px 20px; /* Added padding for better touch targets */
    }

    .summary {
        text-align: center;
        margin-top: 25px; /* Slightly increased */
        font-size: 22px; /* Increased to match base font size */
    }

    .card {
        border: 1px solid #ddd;
        border-radius: 10px; /* Slightly increased */
        padding: 15px; /* Increased padding */
        margin-bottom: 25px; /* Slightly increased */
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1); /* Slightly increased */
        text-align: center;
    }

    .card-header {
        font-weight: bold;
        background-color: #f2f2f2;
        border-bottom: 1px solid #ddd;
        padding: 12px; /* Increased padding */
        font-size: 26px; /* Increased from original size */
    }

    .card-body {
        padding: 15px; /* Increased padding */
        font-size: 22px; /* Increased to match base font size */
    }

    .badge {
        display: inline-block;
        padding: 0.5em 1em;
        font-size: 18px; /* Increased from original size */
        font-weight: bold;
        color: #fff;
        background-color: #007bff;
        border-radius: 0.25rem;
    }

    .badge-danger {
        background-color: #dc3545;
    }

    .badge-warning {
        background-color: #ffc107;
        color: #212529;
    }

    .badge-primary {
        background-color: #007bff;
    }

    .additional-info {
        font-size: 20px; /* Increased from original size */
        margin-top: 15px; /* Slightly increased */
        color: #333;
    }

    .comparison-info {
        font-size: 24px; /* Increased from original size */
        font-weight: bold;
        color: #555;
        margin-top: 15px; /* Slightly increased */
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
        <h1>Laporan Total Sampah Per Hari</h1>

        <!-- <form method="GET" action="{{ route('laporanTotalSampah') }}">
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <input type="date" name="start_date" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <input type="date" name="end_date" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Lihat Laporan</button>
                </div>
            </div>
        </form> -->

        <div class="print-button">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cetakModal">Cetak</button>
        </div>

        @php
            function formatTanggalIndonesia($date)
            {
                setlocale(LC_TIME, 'id_ID');
                \Carbon\Carbon::setLocale('id');
                return \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y');
            }
        @endphp

        <div class="sensor-data-container">
            @php
                $previousVolume = null;
            @endphp

            @foreach ($dailySummary as $date => $totalVolume)
            <div class="card">
                <div class="card-header">
                    {{ formatTanggalIndonesia($date) }}
                </div>
                <div class="card-body">
                    <p><strong>Total Volume Sampah:</strong> {{ $totalVolume }} cm³</p>
                    @if ($previousVolume !== null)
                        <div class="comparison-info">
                            Volume sampah hari ini 
                            @if ($totalVolume > $previousVolume)
                                <span class="badge badge-danger">lebih besar</span> dari kemarin.
                            @elseif ($totalVolume < $previousVolume)
                                <span class="badge badge-warning">lebih kecil</span> dari kemarin.
                            @else
                                <span class="badge badge-primary">sama</span> dengan kemarin.
                            @endif
                        </div>
                    @endif
                    <div class="additional-info">
                        <p>Volume sampah yang tinggi dapat menyebabkan penumpukan sampah yang berlebihan dan berdampak negatif pada lingkungan. Pastikan untuk mengelola sampah dengan baik untuk menghindari masalah kesehatan dan kebersihan.</p>
                    </div>
                </div>
            </div>
            @php
                $previousVolume = $totalVolume;
            @endphp
            @endforeach
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
                <form method="GET" action="{{ route('cetakTotalSampah') }}">
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
