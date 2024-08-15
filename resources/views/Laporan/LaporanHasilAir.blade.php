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
            font-size: 20px; /* Base font size set to 20px */
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

        h1 {
            text-align: center;
            margin-top: 30px;
            font-family: 'Book Antiqua', serif;
            font-size: 40px; /* Adjusted from base size */
        }

        .print-button {
            text-align: center;
            margin-top: 25px;
        }

        .print-button button {
            margin-right: 15px;
            font-size: 22px; /* Slightly larger than base size */
            padding: 10px 20px;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .card-header {
            font-weight: bold;
            background-color: #f2f2f2;
            border-bottom: 1px solid #ddd;
            padding: 15px;
            font-size: 24px; /* Larger than base size */
        }

        .card-body {
            padding: 20px;
            font-size: 20px; /* Same as base size */
        }

        .badge {
            display: inline-block;
            padding: 0.5em 1em;
            font-size: 18px; /* Slightly smaller than base size */
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
            font-size: 18px; /* Slightly smaller than base size */
            margin-top: 15px;
            color: #333;
        }

        .comparison-info {
            font-size: 22px; /* Slightly larger than base size */
            font-weight: bold;
            color: #555;
            margin-top: 15px;
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
    <div class="container">
        <h1>Data Tinggi Air Berbahaya</h1>

        <div class="print-button">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cetakModal">Cetak</button>
        </div>

        @if($dataBerbahaya->isEmpty())
            <p>Tidak ada data tinggi air yang berbahaya saat ini.</p>
        @else
            @php
                function formatTanggalIndonesia($date)
                {
                    setlocale(LC_TIME, 'id_ID');
                    \Carbon\Carbon::setLocale('id');
                    return \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y');
                }

                $previousDate = null;
                $dangerCount = [];
                $currentDate = null;
            @endphp

            @foreach ($dataBerbahaya as $date => $group)
                @php
                    $currentDate = $date;
                    $dangerCount[$currentDate] = $group->count();
                @endphp

                <div class="card">
                    <div class="card-header">{{ formatTanggalIndonesia($currentDate) }}</div>
                    <div class="card-body">
                        <p><strong>Total Berbahaya:</strong> {{ $dangerCount[$currentDate] }} kali</p>
                        <div class="additional-info">
                            <p>Pastikan warga sekitar waspada dan segera melakukan tindakan pencegahan jika terjadi peningkatan ketinggian air. Batas normal ketinggian air adalah di bawah 2 cm, sementara antara 2 dan 5 cm dianggap normal, dan di atas 5 cm dianggap berbahaya.</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
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
                <form method="GET" action="{{ route('cetakHasilAirBerbahaya') }}">
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
