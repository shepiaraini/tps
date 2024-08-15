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
            font-family: 'League Spartan', sans-serif; /* Apply League Spartan font to sensor data card */
        }

        .sensor-data-card h2 {
    background-image: linear-gradient(135deg, #4BC0C0, #7F7FFF); /* Ubah warna gradasi sesuai preferensi Anda */
    color: white;
    padding: 10px 0;
    margin: -20px -20px 20px -20px;
    font-size: 25px;
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
    font-weight: bold;
    font-family: 'League Spartan', sans-serif; /* Tetapkan font yang Anda inginkan */
}
    /* ... (your existing styles) ... */

.main {
    padding: 20px; /* Add some padding to the main content area */
}

h1 {
    text-align: center;
    margin-bottom: 20px;
    color: #333; /* Darker text for better contrast */
}

.peringatan, .saran {
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
    margin-bottom: 20px;
}

.peringatan {
    background-color: #ffe5e5; /* Softer red */
    color: #d9534f; /* Darker red text */
    border: 1px solid #d9534f; /* Add a border */
}

.saran {
    background-color: #fff9e6; /* Softer yellow */
    color: #8a6d3b; /* Darker yellow text */
    border: 1px solid #8a6d3b; /* Add a border */
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 30px;
}

.data-table th, .data-table td {
    border: 1px solid #ddd;
    padding: 15px; /* Increase padding for better spacing */
    text-align: left; /* Left-align text */
}

.data-table th {
    background-color: #38703d; /* Green header background */
    color: white;
    font-weight: bold;
}

.data-table tr:nth-child(even) {
    background-color: #f9f9f9;
}
        .sensor-data-card .value {
            font-size: 30px;
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
            max-width: 600px; /* Set the max-width to make the chart narrower */
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
        <h1 style="font-family: 'Book Antiqua', serif;">Informasi Tempat Sampah</h1>
   
        <div class="sensor-data-container">
    @if ($tsampah)
    <div class="sensor-data-card">
        <h2>Waktu</h2>
        <div class="value">{{ $tsampah->created_at ?? '' }}</div>
    </div>
    <div class="sensor-data-card">
        <h2>Ketinggian Sampah</h2>
        <div class="value">{{ $tsampah->nilai_tinggi_sampah ?? '' }}</div>
        <div class="unit">Cm</div>
    </div>
    <div class="sensor-data-card">
        <h2>Volume Tempat Sampah</h2>
        <div class="value">{{ $volumeTempatSampah ?? '' }}</div>
        <div class="unit">Cm³</div>
    </div>
    <div class="sensor-data-card">
        <h2>Keterangan</h2>
        <div class="value">{{ $tsampah->keterangan ?? '' }}</div>
    </div>
    @else
    <div class="sensor-data-card">
        <h2>No Data</h2>
        <div class="value">No data available</div>
    </div>
    @endif
</div>

        @if ($tsampah->nilai_tinggi_sampah > 6)  
        <div class="peringatan">
            <p><strong>PERINGATAN: </strong>Tempat sampah hampir penuh!</p>
            <p>Saran: Segera kosongkan tempat sampah untuk menjaga kebersihan dan mencegah penumpukan sampah.</p>
        </div>
        @elseif ($tsampah->nilai_tinggi_sampah < 3)
            <div class="saran">
                <p>Tempat sampah dalam kondisi aman  .</p>
            </div>
        @else
            <div class="saran">
                <p>Tempat sampah masih dalam kondisi baik.</p>
            </div>
        @endif
    </div>
    
    <canvas id="chartKetinggianAir"></canvas>

    <form action="{{ route('data-sensor.deleteAll') }}" method="POST">
        @csrf
    </form>
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
    var waktu = [];
    var ketinggianSampah = [];

    @if ($tsampah)
        waktu.push("{{ $tsampah->created_at }}");
        ketinggianSampah.push({{ $tsampah->nilai_tinggi_sampah ?? 'null' }});
    @endif

    // Mengubah nilai ketinggian sampah menjadi 100 ketika penuh untuk warna merah
    if (ketinggianSampah.length > 0 && ketinggianSampah[0] === 100) {
        var backgroundColor = 'rgba(255, 99, 132, 0.2)';
        var borderColor = 'rgba(255, 99, 132, 1)';
    } else {
        var backgroundColor = 'rgba(75, 192, 192, 0.2)';
        var borderColor = 'rgba(75, 192, 192, 1)';
    }

    // Menambahkan nilai ketinggian sampah kosong (0 cm)
    var waktuKosong = ["2024-07-03 08:00:00", "2024-07-03 09:00:00"];
    var ketinggianSampahKosong = [0, 0];

    var ctx = document.getElementById('chartKetinggianAir').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: waktu.concat(waktuKosong), // Menggabungkan label waktu penuh dan kosong
            datasets: [{
                label: 'Ketinggian Sampah (cm)',
                data: ketinggianSampah.concat(ketinggianSampahKosong), // Menggabungkan data ketinggian sampah penuh dan kosong
                backgroundColor: backgroundColor,
                borderColor: borderColor,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

</body>
</html>
