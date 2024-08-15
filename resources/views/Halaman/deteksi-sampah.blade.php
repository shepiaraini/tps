<!DOCTYPE html>
<html lang="en">
<head>
    @include('tools.header')
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

        .sensor-data-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .sensor-data-table th,
        .sensor-data-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center; /* Center-align text */
        }

        .sensor-data-table th {
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center; /* Center-align title */
            margin-top: 30px;
            font-family: 'Book Antiqua', serif;
        }

        #combinedChart {
            margin-top: 20px;
            width: 80%;
            max-width: 800px; /* Set the max-width to make the chart narrower */
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
        <h1>Deteksi Sampah</h1> <!-- Center-aligned title -->
        <div class="sensor-data-container">
            <table class="sensor-data-table">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Waktu Deteksi Sampah</th>
                        <!--<th>Hasil Deteksi Sampah</th>-->
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $maxRows = count($deteks);
                    @endphp
                    @for ($i = 0; $i < $maxRows; $i++)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $deteks[$i]->created_at ?? '' }}</td>
                        <!--<td>{{ $deteks[$i]->nilai_deteksi ?? '' }}</td>-->
                        <td>{{ $deteks[$i]->keterangan ?? '' }}</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>

    <!-- Grafik Gabungan -->
    <canvas id="combinedChart"></canvas>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function updateTable(data) {
            var tbody = $('table.sensor-data-table tbody');
            tbody.empty();
            data.forEach(function(deteksi, index) {
                var row = '<tr>' +
                    '<td>' + (index + 1) + '</td>' +
                    '<td>' + deteksi.created_at + '</td>' +
                    //'<td>' + deteksi.nilai_deteksi + '</td>' +
                    '<td>' + deteksi.keterangan + '</td>' +
                    '</tr>';
                tbody.append(row);
            });
        }

        function pollData() {
            $.ajax({
                url: '/poll-deteksi-sampah',
                method: 'GET',
                success: function(response) {
                    updateTable(response);
                }
            });
        }

        // Polling interval set to 5 seconds (5000 milliseconds)
        setInterval(pollData, 000);

        // Initial poll
        pollData();
    });
</script>


</body>
</html>
