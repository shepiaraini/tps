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
<tbody role="alert" aria-live="polite" aria-relevant="all"><tr class="odd">
                    <form action="{{url ('update-input', $peg->id_input_data) }}" method="post">
                        {{csrf_field()}}
                                    <div class="box-body">
                                        <div class="form-group">
                                         
                                            <input type="date" class="form-control" name="tanggal" placeholder="Tanggal" value="{{ $peg->tanggal }}">
                                        </div>
                                        <div class="form-group">
                                        <input type="text" class="form-control" name="ketinggian_air" placeholder="Tanggal" value="{{ $peg->ketinggian_air }}">
                                        </div>
                                        <div class="form-group">
                                    </div><!-- /.box-body -->
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">Edit</button>
                                    </div>
                        
                                </form>
                            </div>
                        </tbody></table>
        <!-- Tombol Cetak -->
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

</body>
</html>



