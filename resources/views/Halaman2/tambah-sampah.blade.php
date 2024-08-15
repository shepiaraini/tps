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
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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

        h1 {
            text-align: center;
            margin-top: 30px;
        }

        .form-control {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .custom-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .custom-button:hover {
            background-color: #0056b3;
        }

        #combinedChart {
            margin-top: 20px;
            width: 80%;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            display: block;
        }

        footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
        }

        .credits a {
            color: #007bff;
            text-decoration: none;
        }

        .credits a:hover {
            text-decoration: underline;
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
        <h1>Ketinggian Sampah</h1>
        <form action="{{ url('Simpan-sampah') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <input type="date" class="form-control" name="tanggal" placeholder="Tanggal">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="ketinggian_sampah" placeholder="Ketinggian Sampah">
                </div>
            </div>
            <div class="text-right">
                <button type="submit" class="custom-button">Simpan</button>
            </div>
        </form>

        <!-- Grafik Gabungan -->
        <canvas id="combinedChart"></canvas>
    </div>
</main>

<footer id="footer" class="footer">
    <div class="credits">
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
</footer>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

@include('tools.script')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>
</html>
