<!DOCTYPE html>
<html lang="en">
<head>
    @include('tools.header')
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;700&display=swap" rel="stylesheet">
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

        .sensor-data-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .sensor-data-card {
            background-color: white;
            border: 2px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 10px;
            padding: 20px;
            text-align: center;
            width: 250px;
            font-family: 'League Spartan', sans-serif;
        }

        .sensor-data-card h2 {
            background-image: linear-gradient(135deg, #4BC0C0, #7F7FFF);
            color: white;
            padding: 10px 0;
            margin: -20px -20px 20px -20px;
            font-size: 25px;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            font-weight: bold;
            font-family: 'League Spartan', sans-serif;
        }

        .sensor-data-card .value {
            font-size: 36px;
            font-weight: bold;
        }

        .sensor-data-card .unit {
            font-size: 18px;
            font-weight: bold;
        }

        h1 {
            text-align: center;
            font-family: 'Book Antiqua', serif;
        }

        #chartKetinggianAir {
            margin-top: 20px;
            width: 80%;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .peringatan, .saran { 
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-family: 'Book Antiqua', serif;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .peringatan {
            background: linear-gradient(135deg, #ffcccc, #ff6666);
            color: #800000; /* Dark red */
            border: 1px solid #ff3333;
        }

        .saran {
            background: linear-gradient(135deg, #ffffe0, #ffff99);
            color: #666600; /* Dark yellow */
            border: 1px solid #cccc00;
        }

        .peringatan p, .saran p {
            margin: 10px 0;
        }

        .peringatan strong, .saran strong {
            font-weight: bold;
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
    @include('tools.siderbarrr')
</aside>

<main id="main" class="main">
    <div>
        <h1 style="font-family: 'Book Antiqua', serif;">Informasi Ketinggian Air</h1>

        @if ($tair)
            @if ($tair->nilai_tinggi_air > 3) 
                <div class="peringatan">
                    <p><strong>PERINGATAN: </strong>Ketinggian air di atas 3 cm. Waspada potensi banjir!</p>
                    <p>Saran: Amankan barang berharga ke tempat yang lebih tinggi dan pantau informasi terbaru dari pihak berwenang.</p>
                </div>
                <script>showPopup();</script>
            @else
                <div class="saran">
                    <p>Ketinggian air masih dalam batas aman. Tetap pantau perubahan ketinggian air secara berkala.</p>
                </div>
            @endif

            <div class="sensor-data-container">
                <div class="sensor-data-card">
                    <h2>Waktu</h2>
                    <div class="value">{{ $tair->created_at ?? '' }}</div>
                </div>
                <div class="sensor-data-card">
                    <h2>Ketinggian Air</h2>
                    <div class="value">{{ $tair->nilai_tinggi_air ?? '' }}</div>
                    <div class="unit">cm</div>
                </div>
                <div class="sensor-data-card">
                    <h2>Keterangan</h2>
                    <div class="value">{{ $tair->keterangan ?? '' }}</div>
                </div>
            </div>
        @else
            <div class="sensor-data-card">
                <h2>No Data</h2>
                <div class="value">No data available</div>
            </div>
        @endif
    </div>
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

<div id="warningPopup" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #ff6666; color: white; padding: 20px; border-radius: 10px; z-index: 1000; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
    <h3>PERINGATAN!</h3>
    <p>Ketinggian air di atas 3 cm. Waspada potensi banjir!</p>
    <button onclick="closePopup()" style="background-color: white; color: #ff6666; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Tutup</button>
</div>

<script>
    function showPopup() {
        document.getElementById('warningPopup').style.display = 'block';
    }

    function closePopup() {
        document.getElementById('warningPopup').style.display = 'none';
    }

    // Check water level and show popup if necessary
    @if ($tair && $tair->nilai_tinggi_air > 3)
        showPopup();
    @endif
</script>

</body>
</html>