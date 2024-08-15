<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Total Sampah Per Hari</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <style>
        @page {
            size: A4;
            margin: 10mm;
        }

        body {
            background-color: #fff;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            margin: 0;
            padding: 0;
        }

        * {
            font-family: "Arial";
        }

        .text-center {
            text-align: center;
        }

        h1 {
            font-size: 26px;
            color: red;
            margin: 0;
        }

        h3 {
            font-size: 14px;
            font-weight: normal;
            margin-top: -2px;
        }
        h4 {
            font-size: 12px;
            font-weight: normal;
            margin-top: -8px;
        }

        .card {
            border: 1px solid #000;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
            page-break-inside: avoid;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }

        .card-text {
            margin: 5px 0;
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

        #printButtonContainer {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 1000;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .col-md-6 {
            flex: 0 0 48%;
            margin-bottom: 20px;
        }

        .col-md-6.centered {
            margin-left: auto;
            margin-right: auto;
        }

        @media print {
            .sheet {
                margin: 0;
                box-shadow: 0;
            }

            .page-break {
                page-break-before: always;
            }

            #printButtonContainer {
                display: none;
            }

            .badge {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                color-adjust: exact;
            }
        }
    </style>
</head>

<body class="A4 potrait">
    <div id="printButtonContainer">
        <button id="printButton" class="btn btn-primary" onclick="window.print()">Print</button>
    </div>

    @php
        function formatTanggalIndonesia($date)
        {
            setlocale(LC_TIME, 'id_ID');
            \Carbon\Carbon::setLocale('id');
            return \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y');
        }
    @endphp

    @php
        $previousVolume = null;
    @endphp

    @foreach($dailySummary->chunk(4) as $chunk)
    <section class="sheet padding-10mm">
        <div class="text-center">
            <h1>SISTEM PENGOLAHAN DATA SAMPAH</h1>
            <h3>SUNGAI SIMPANG TANGGA</h3>
            <h4>Alamat: Jl. Simpang Tangga Banjarmasin Utara</h4>
        </div>
        <hr style="border-top: 2px solid black;">
        <hr style="border-top: 0.5px solid black; margin-top: -14px;">
        <h1 class="text-center">Laporan Total Sampah Per Hari</h1>
        <p class="text-center">Periode: {{ formatTanggalIndonesia($startDate) }} s/d {{ formatTanggalIndonesia($endDate) }}</p>

        <div class="row">
            @foreach($chunk as $date => $totalVolume)
            <div class="col-md-6 {{ $loop->remaining == 0 && $loop->count % 2 == 1 ? 'centered' : '' }}">
                <div class="card">
                    <div class="card-title">{{ formatTanggalIndonesia($date) }}</div>
                    <div class="card-text"><strong>Total Volume Sampah:</strong> {{ $totalVolume }} cm³</div>
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
    </section>

    @if (!$loop->last)
    <div class="page-break"></div>
    @endif
    @endforeach
</body>
</html>
