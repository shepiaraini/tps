<!DOCTYPE html>
<html lang="en">
<head>
    @include('tools.header')
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8d7da;
            color: #333;
            font-size: 16px;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #003366;
        }

        .main {
            padding-top: 80px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: calc(100vh - 80px);
        }

        .conveyor-content {
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 800px;
            margin-bottom: 40px;
        }

        .conveyor-content h2 {
            color: #1a2a3a;
            margin-bottom: 30px;
            text-align: center;
            font-weight: 800;
            font-size: 28px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .sensor-data-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .sensor-data-card {
            background-color: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .sensor-data-card h3 {
            margin-top: 0;
            color: #5a6a7a;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .sensor-data-card p {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            line-height: 1.4;
        }

        #conveyorStatus { color: #2ecc71; }
        #lastDetectionTime { color: #3498db; }
        #detectionValue { color: #e74c3c; }
        #detectionDescription { 
            font-size: 18px;
            font-weight: 400;
            color: #e74c3c;
        }

        .conveyor-history {
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 800px;
        }

        .conveyor-history h3 {
            color: #1a2a3a;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 700;
            font-size: 24px;
        }

        .history-list {
            list-style-type: none;
            padding: 0;
        }

        .history-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .history-item:last-child {
            border-bottom: none;
        }

        .status-on {
            color: #2ecc71;
            font-weight: 600;
        }

        .history-details {
            display: flex;
            flex-direction: column;
        }

        .history-time, .history-duration {
            font-size: 0.9em;
            color: #666;
        }

        .footer {
            text-align: center;
            padding: 20px;
            background-color: #f1f1f1;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
        }

        @media (max-width: 768px) {
            .sensor-data-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="header-content">
            <div class="logo">SPS</div>
        </div>
    </header>

    @include('tools.navbar')

    <div class="sidebar">
        @include('tools.sidebar')
    </div>

    <main class="main">
        <div class="conveyor-content">
            <h2>Status Konveyor</h2>
            <div class="sensor-data-container">
                <div class="sensor-data-card">
                    <h3>Status</h3>
                    <p id="conveyorStatus">{{ $conveyorStatus }}</p>
                </div>
                <div class="sensor-data-card">
                    <h3>Waktu Deteksi Terakhir</h3>
                    <p id="lastDetectionTime">{{ $latestDetection->created_at }}</p>
                </div>
                <div class="sensor-data-card">
                    <h3>Ketinggian Air</h3>
                    <p id="detectionValue">{{ $realTimeWaterLevel }}</p>
                </div>
                <div class="sensor-data-card">
                    <h3>Tempat Sampah</h3>
                    <p id="detectionDescription">{{ $realTimeTempatSampah }}</p>
                </div>
            </div>
        </div>

        <div class="conveyor-history">
            <h3>Riwayat Status Konveyor</h3>
            <ul class="history-list">
                @foreach ($conveyorHistory as $item)
                    <li class="history-item">
                        <span class="status-{{ $item['status'] }}">{{ ucfirst($item['status']) }}</span>
                        <div class="history-details">
                            <span class="history-time">Mulai: {{ $item['start_time']->format('d M Y H:i:s') }}</span>
                            <span class="history-time">Selesai: {{ $item['end_time'] ? $item['end_time']->format('d M Y H:i:s') : 'Masih berjalan' }}</span>
                            <span class="history-duration">Durasi: {{ $item['duration'] }}</span>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; Copyright NiceAdmin. All Rights Reserved</p>
    </footer>

    @include('tools.script')
    <script>
        function updateStatus() {
            fetch('/hasil')
                .then(response => response.text())
                .then(html => {
                    document.body.innerHTML = html;
                });
        }
        setInterval(updateStatus, 000); // Update every 10 seconds
    </script>
</body>
</html>
