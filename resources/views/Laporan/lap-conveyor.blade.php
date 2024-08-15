<!DOCTYPE html>
<html lang="en">

<head>
    @include('tools.header')
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    <style>
        /* ... (CSS styles Anda yang lain) ... */

        /* Sesuaikan container riwayat conveyor */
        .conveyor-history {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 30px; /* Atur padding sesuai kebutuhan */
            width: 80%;  /* Sesuaikan lebar sesuai kebutuhan */
            max-width: 800px; 
            margin: 20px auto;
        }

        /* Tampilan item riwayat */
        .history-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        /* Tampilan status */
        .status-on {
            color: #2ecc71; /* Hijau untuk status ON */
            font-weight: bold;
        }

        .status-off {
            color: #e74c3c; /* Merah untuk status OFF */
            font-weight: bold;
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
    @include('tools.sidebar')

    <main class="main">
        <div class="print-button">
            <a href="{{ url('/cetak-conveyor') }}" class="btn btn-primary">Cetak</a>
        </div>

        <div class="conveyor-history">
            <h3>Riwayat Status Conveyor</h3>
            @if ($conveyorHistory->isEmpty())
                <p>Tidak ada riwayat conveyor.</p>
            @else
                <ul class="history-list">
                    @foreach ($conveyorHistory->sortByDesc('start_time') as $item) 
                        <li class="history-item">
                            <span class="status-{{ $item['status'] }}">{{ ucfirst($item['status']) }}</span>
                            <div class="history-details">
                                <span class="history-time">Mulai: {{ $item['start_time']->format('d M Y H:i:s') }}</span>
                                @if ($item['end_time'])
                                    <span class="history-time">Selesai: {{ $item['end_time']->format('d M Y H:i:s') }}</span>
                                @else
                                    <span class="history-time">Masih berjalan</span>
                                @endif
                                <span class="history-duration">Durasi: {{ $item['duration'] }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </main>

    <footer class="footer">
        <p>&copy; Copyright NiceAdmin. All Rights Reserved</p>
    </footer>

    @include('tools.script')
</body>

</html>
