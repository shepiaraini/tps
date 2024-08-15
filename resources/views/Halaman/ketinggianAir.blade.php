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

        .print-button {
            text-align: center;
            margin-top: 20px;
        }

        .print-button button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .print-button button:hover {
            background-color: #0056b3;
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
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-center w-100">Ketinggian Air</h1> <!-- Center-aligned title -->
    </div>
    <div class="sensor-data-container">
        <table class="sensor-data-table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Date</th>
                    <th>Ketinggian Air</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody id="sensor-data">
                <!-- Data will be loaded here by AJAX -->
            </tbody>
        </table>
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
    function fetchData() {
        $.ajax({
            url: '/api/ketinggian-air',
            method: 'GET',
            success: function(data) {
                let tableBody = $('#sensor-data');
                tableBody.empty();

                data.forEach((item, index) => {
                    // Convert UTC date to local date (same time zone as server)
                    let utcDate = new Date(item.created_at);
                    let localDate = new Date(utcDate.getTime() + (utcDate.getTimezoneOffset() * 60000));

                    // Format the date to DD-MM-YYYY HH:mm:ss
                    let formattedDate = ('0' + localDate.getDate()).slice(-2) + '-' +
                                        ('0' + (localDate.getMonth() + 1)).slice(-2) + '-' +
                                        localDate.getFullYear() + ' ' +
                                        ('0' + localDate.getHours()).slice(-2) + ':' +
                                        ('0' + localDate.getMinutes()).slice(-2) + ':' +
                                        ('0' + localDate.getSeconds()).slice(-2);

                    let row = `<tr>
                        <td>${index + 1}</td>
                        <td>${formattedDate}</td>
                        <td>${item.nilai_tinggi_air} Cm</td>
                        <td>${item.keterangan}</td>
                    </tr>`;
                    tableBody.append(row);
                });
            }
        });
    }

    // Fetch data initially and then every 5 seconds
    fetchData();
    setInterval(fetchData, 000);
</script>

</body>
</html>
