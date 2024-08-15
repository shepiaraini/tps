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

        h1 {
            text-align: center;
            margin-top: 30px;
            font-family: 'Book Antiqua', serif;
        }

        .print-button {
            text-align: center;
            margin-top: 20px;
        }

        .print-button button {
            margin-right: 10px;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .card-header {
            font-weight: bold;
            background-color: #f2f2f2;
            border-bottom: 1px solid #ddd;
            padding: 8px;
        }

        .card-body {
            padding: 10px;
        }

        .badge {
            display: inline-block;
            padding: 0.5em 1em;
            font-size: 12px;
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
            font-size: 12px;
            margin-top: 10px;
            color: #333;
        }

        .comparison-info {
            font-size: 14px;
            font-weight: bold;
            color: #555;
            margin-top: 10px;
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
        <h1>Laporan Hasil Akhir</h1>

        <div class="print-button">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cetakModal">Cetak</button>
        </div>

        @if($hasilakhir->isEmpty())
            <p>Tidak ada data yang tersedia saat ini.</p>
        @else
            @foreach ($hasilakhir as $history)
                <div class="card">
                    <div class="card-header">{{ $history->created_at->format('l, d F Y') }}</div>
                    <div class="card-body">
                        <p><strong>Deteksi Sampah:</strong> {{ $history->deteksisampah }} (0: Tidak Terdeteksi, 1: Terdeteksi)</p>
                        <p><strong>Tinggi Air:</strong> {{ $history->tinggiair }} cm</p>
                        <p><strong>Tempat Sampah:</strong> {{ $history->tempatsampah }}</p>
                        <p><strong>Status:</strong> <span class="badge 
                            @if($history->output_kondisi == 'Aman (A)')
                                badge-success
                            @elseif($history->output_kondisi == 'Warning (W)')
                                badge-warning
                            @elseif($history->output_kondisi == 'Berbahaya (B)')
                                badge-danger
                            @endif
                        ">{{ $history->output_kondisi }}</span></p>
                        <p><strong>Tindakan:</strong> {{ $history->tindakan }}</p>
                        <div class="additional-info">
                            @if ($history->output_kondisi == 'Berbahaya (B)')
                                <p class="badge badge-danger">Kondisi Berbahaya! Segera lakukan tindakan pencegahan seperti evakuasi dan amankan barang berharga.</p>
                            @elseif ($history->output_kondisi == 'Warning (W)')
                                <p class="badge badge-warning">Perhatian! Kondisi mendekati batas berbahaya. Siaga dan waspada.</p>
                            @else
                                <p class="badge badge-primary">Kondisi Aman. Lanjutkan pemantauan rutin untuk memastikan keamanan.</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Menambahkan link navigasi untuk paginasi menggunakan Bootstrap -->
            <nav aria-label="Page navigation">
                {{ $hasilakhir->links('pagination::bootstrap-5') }}
            </nav>
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
                <form method="GET" action="{{ route('cetakHasilakhir') }}">
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
<script>
    $(document).ready(function() {
        $('#cetakModal').modal('hide');
        $('.btn-primary').click(function() {
            $('#cetakModal').modal('show');
        });
    });
</script>
</body>
</html>
