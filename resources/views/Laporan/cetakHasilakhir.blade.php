<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil Akhir</title>
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
            font-size: 16px;
            font-weight: normal;
            margin-top: -8px;
        }

        .card {
            border: 1px solid #000;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
            page-break-inside: avoid;
            text-align: center;
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
            padding: 5px;
            border-radius: 5px;
            font-size: 14px;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }

        .badge-warning {
            background-color: #ffc107;
            color: black;
        }

        .badge-danger {
            background-color: #dc3545;
            color: white;
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
<body class="A4 portrait">
    <div id="printButtonContainer">
        <button id="printButton" class="btn btn-primary" onclick="window.print()">Print</button>
    </div>

    <section class="sheet padding-10mm">
        <div class="text-center">
            <h1>SISTEM PENGOLAHAN DATA SAMPAH</h1>
            <h3>SUNGAI SIMPANG TANGGA</h3>
            <h3>Alamat: Jl. Simpang Tangga Banjarmasin Utara</h3>
        </div>
        <hr style="border-top: 2px solid black;">
        <hr style="border-top: 0.5px solid black; margin-top: -14px;">
        <h1 class="text-center">Laporan Hasil Akhir</h1>
        <p class="text-center">Periode: {{ $start_date }} - {{ $end_date }}</p>

        @php
            function formatTanggalIndonesia($date)
            {
                setlocale(LC_TIME, 'id_ID');
                \Carbon\Carbon::setLocale('id');
                return \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y');
            }
        @endphp

        @foreach($hasilakhir->chunk(4) as $chunk)
            <div class="row">
                @foreach($chunk as $history)
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-title">{{ formatTanggalIndonesia($history->created_at) }}</div>
                        <div class="card-text"><strong>Deteksi Sampah:</strong> {{ $history->deteksisampah }} (0: Tidak Terdeteksi, 1: Terdeteksi)</div>
                        <div class="card-text"><strong>Tinggi Air:</strong> {{ $history->tinggiair }} cm</div>
                        <div class="card-text"><strong>Tempat Sampah:</strong> {{ $history->tempatsampah }}</div>
                        <div class="card-text"><strong>Status:</strong> <span class="badge 
                            @if($history->output_kondisi == 'Aman (A)')
                                badge-success
                            @elseif($history->output_kondisi == 'Warning (W)')
                                badge-warning
                            @elseif($history->output_kondisi == 'Berbahaya (B)')
                                badge-danger
                            @endif
                        ">{{ $history->output_kondisi }}</span></div>
                        <div class="card-text"><strong>Tindakan:</strong> {{ $history->tindakan }}</div>
                        <div class="additional-info">
                            @if($history->output_kondisi == 'Aman (A)')
                                <p>Kondisi saat ini aman. Tidak diperlukan tindakan khusus, namun tetap waspada dan pantau secara berkala.</p>
                            @elseif($history->output_kondisi == 'Warning (W)')
                                <p>Perhatian! Ketinggian air mendekati batas berbahaya. Warga sekitar diimbau untuk waspada dan siap siaga.</p>
                            @elseif($history->output_kondisi == 'Berbahaya (B)')
                                <p>Kondisi berbahaya! Segera lakukan tindakan pencegahan seperti evakuasi ke tempat yang lebih tinggi dan amankan barang berharga.</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @if (!$loop->last)
                <div class="page-break"></div>
            @endif
        @endforeach
    </section>
</body>
</html>
