<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Tinggi Air Berbahaya</title>
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
            font-size: 24px;
            margin: 0;
            color: red;
        }

        h3 {
            font-size: 18px;
            font-weight: normal;
            margin-top: -2px;
        }
        h4 {
            font-size: 18px;
            font-weight: normal;
            margin-top: -8px;
        }

        .card {
            border: 1px solid #000;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
            page-break-inside: avoid;
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

    @foreach($dataBerbahaya->chunk(5) as $chunk)
        <section class="sheet padding-10mm">
            <div class="text-center">
                <h1>SISTEM PENGOLAHAN DATA SAMPAH</h1>
                <h3>SUNGAI SIMPANG TANGGA</h3>
                <h4>Alamat: Jl. Simpang Tangga Banjarmasin Utara</h4>
            </div>
            <hr style="border-top: 2px solid black;">
            <hr style="border-top: 0.5px solid black; margin-top: -14px;">
            <h1 class="text-center">Laporan Tinggi Air Berbahaya</h1>
            <p class="text-center">Periode: {{ formatTanggalIndonesia($start_date) }} s/d {{ formatTanggalIndonesia($end_date) }}</p>

            @foreach($chunk as $date => $group)
                <div class="card">
                    <div class="card-title">{{ formatTanggalIndonesia($date) }}</div>
                    <div class="card-text">
                        <strong>Total Berbahaya:</strong> {{ $group->count() }} kali
                    </div>
                    <div class="card-text">
                        Pastikan warga sekitar waspada dan segera melakukan tindakan pencegahan jika terjadi peningkatan ketinggian air. Batas normal ketinggian air adalah di bawah 2 cm, sementara antara 2 dan 5 cm dianggap normal, dan di atas 5 cm dianggap berbahaya.
                    </div>
                </div>
            @endforeach
        </section>
        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>
</html>
