<!DOCTYPE html>
<html lang="en">

<head>
    <link href="{{ asset('template/img/logo1.png') }}" rel="icon">
    <link href="{{ asset('template/img/logo1.png') }}" rel="apple-touch-icon">
    <title>Sistem Pengarsipan Surat Masuk & Keluar</title>
    <style type="text/css">
        /* ... (CSS styles Anda) ... */
    </style>
</head>

<body>
    <div class="rangkasurat">
        <table class="center">
            <tr>
                <th class="center">
                    <h3>SISTEM PENGOLAHAN DATA SAMPAH</h3>
                    <h2>SUNGAI SIMPANG TANGGA</h2>
                    <p>Alamat: Jl. Simpang Tangga Banjarmasin Utara</p>
                </th>
            </tr>
        </table>
        <br>
        <table class="table1 center">
            <tr>
                <td>No</td>
                <td>Status</td>
                <td>Waktu Mulai</td>
                <td>Waktu Berakhir</td>
                <td>Durasi</td>
            </tr>
            @php $no = 1; @endphp
            @foreach ($conveyorHistory as $item)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $item['status'] }}</td>
                <td>{{ $item['start_time']->format('d M Y H:i:s') }}</td>
                <td>{{ $item['end_time'] ? $item['end_time']->format('d M Y H:i:s') : 'Masih berjalan' }}</td>
                <td>{{ $item['duration'] }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    <script>
        window.print();
    </script>
</body>

</html>
