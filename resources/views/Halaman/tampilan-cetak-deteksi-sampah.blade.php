<html>

<head>
    <link href="{{ asset('template/img/logo1.png') }}" rel="icon">
    <link href="{{ asset('template/img/logo1.png') }}" rel="apple-touch-icon">
    <title>Sistem Pengendalian Sampah</title>
    <style type="text/css">
        body {
            background-color: #ccc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .rangkasurat {
            width: 930px;
            background-color: #fff;
            padding: 20px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-bottom: 5px solid #000;
            padding: 2px;
            margin: 0 auto;
            text-align: center;
        }

        .tengah {
            text-align: center;
            line-height: 1.5;
        }

        .table1 {
            color: #232323;
            border-collapse: collapse;
            width: 100%;
            margin: 0 auto;
            text-align: center;
        }

        h3, h2, p {
            margin: 0;
        }

        .table1, td {
            border: 2px solid #050505;
            padding: 5px 20px;
        }

        @media print {
            body {
                display: block;
                margin: 0;
                padding: 0;
            }

            .rangkasurat {
                box-shadow: none;
                margin: auto;
                page-break-inside: avoid;
            }

            h3, h2, p {
                margin: 0;
            }
        }
    </style>
</head>

<body>
    <div class="rangkasurat">
        <table>
            <tr>
                <th class="tengah">
                    <h3>SISTEM PENGOLAHAN DATA SAMPAH</h3>
                    <h2>SUNGAI SIMPANG TANGGA</h2>
                    <p>Alamat: Jl. Simpang Tangga Banjarmasin Utara</p>
                </th>
            </tr>
        </table>
        <br>
        <table class="table1">
            <tr>
                <td>No</td>
                <td>Date</td>
                <td>Deteksi Sampah</td>
                <td>Keterangan</td>
            </tr>
            <?php $no = 1; ?>
            @foreach($cetak as $item)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $item->created_at }}</td>
                <td>{{ $item->nilai_deteksi }}</td>
                <td>{{ $item->keterangan }}</td>
            </tr>
            @endforeach
        </table>
        <br>
        <h2>Jumlah: {{ $jumlah }}</h2>
    </div>
    <script>
        window.print();
    </script>
</body>

</html>
