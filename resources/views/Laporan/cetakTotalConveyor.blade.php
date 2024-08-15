<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Total On/Off Conveyor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @page {
            size: A4 ;
            margin: 10mm;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 100%;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        @media print {
            .no-print {
                display: none;
            }

            body, .container {
                width: 100%;
                height: 100%;
                font-size: 12px;
            }
        }

        .small-text {
            font-size: 12px;
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <h2 class="text-center">Laporan Total On/Off Conveyor</h2>
        <p class="text-center">Periode: {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</p>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jumlah On</th>
                    <th>Jumlah Off</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dailySummary as $summary)
                <tr>
                    <td>{{ $summary['date'] }}</td>
                    <td>{{ $summary['onCount'] }}</td>
                    <td>{{ $summary['offCount'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
