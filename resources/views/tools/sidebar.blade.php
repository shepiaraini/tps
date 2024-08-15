<ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('dashboard') }}">
            <i class="bi bi-grid"></i>
            <span>HOME</span>
        </a>
    </li><!-- End Dashboard Nav -->

    @if (auth()->user()->level == 'admin')
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#data-sensor-dropdown">
                <i class="bi bi-menu-button-wide"></i><span>Data Sensor</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="data-sensor-dropdown" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li><a href="{{ url('deteksi-sampah') }}"><i class="fa fa-angle-double-right"></i> Deteksi Sampah</a>
                </li>
                <li><a href="{{ url('ketinggianAir') }}"><i class="fa fa-angle-double-right"></i> Ketinggian Air</a>
                </li>
                <li><a href="{{ url('ketinggianSampah') }}"><i class="fa fa-angle-double-right"></i> Ketinggian
                        Sampah</a></li>
            </ul>
        </li><!-- End Components Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#data-sensor-dropdownn">
                <i class="bi bi-menu-button-wide"></i><span>  Hasil</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="data-sensor-dropdownn" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li><a href="{{ url('hasil') }}"><i class="fa fa-angle-double-right"></i> Status Conveyor </a>
                </li>
                <li><a href="{{ url('pengambilansampah') }}"><i class="fa fa-angle-double-right"></i> Hasil</a>
                </li>
            </ul>
        </li><!-- End Components Nav -->
        <!-- <li class="nav-item">
            <a class="nav-link" href="{{ url('hasil') }}">
                <i class="bi bi-journal-text"></i><span>Hasil</span>
            </a>
        </li>End Forms Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#input-data-dropdown">
                <i class="bi bi-menu-button-wide"></i><span>Input Data</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="input-data-dropdown" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li><a href="{{ url('input') }}"><i class="fa fa-angle-double-right"></i> Data Ketinggian Air</a></li>
                <li><a href="{{ url('input-sampah') }}"><i class="fa fa-angle-double-right"></i> Data Ketinggian
                        Sampah</a></li>
            </ul>
        </li><!-- End Components Nav -->


        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#data-informasi-dropdown">
                <i class="bi bi-menu-button-wide"></i><span>Laporan Data Informasi</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="data-informasi-dropdown" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <!-- <li><a href="{{ url('laptinggiair') }}"><i class="fa fa-angle-double-right"></i> Informasi Air</a></li>
                <li><a href="{{ url('laptempatsampah') }}"><i class="fa fa-angle-double-right"></i> Informasi Tempat
                        Sampah</a></li>
                <li><a href="{{ url('lapdeteksi') }}"><i class="fa fa-angle-double-right"></i> Informasi Deteksi
                        Sampah</a></li>
                <li><a href="{{ url('laporanTotalConveyor') }}"><i class="fa fa-angle-double-right"></i> Laporan Total On/Off Conveyor</a></li> -->
                <li><a href="{{ url('laporanTotalSampah') }}"><i class="fa fa-angle-double-right"></i> Laporan Total Sampah perhari</a></li>
                <li><a href="{{ url('LaporanHasilAir') }}"><i class="fa fa-angle-double-right"></i> Laporan  Ketinggian Air Berbahaya</a></li>
                <li><a href="{{ url('laporanHasilakhir') }}"><i class="fa fa-angle-double-right"></i> Laporan  Hasil Akhir</a></li>


            </ul>
        </li><!-- End Components Nav -->
    @endif

    @if (auth()->user()->level == 'petugas')
        <li class="nav-item">
            <a class="nav-link" href="{{ url('tempat-sampah') }}">
                <i class="bi bi-bar-chart"></i><span>Status Tempat Sampah</span>
            </a>
        </li><!-- End Charts Nav -->
    @endif


</ul>
