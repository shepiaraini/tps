<!DOCTYPE html>
<html lang="en">
<head>
    @include('tools.header')
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Book Antiqua', serif;
            background-image: linear-gradient(45deg, #61E44C, #E2EAF4, #EFC3CA, #E2EAF4);
            background-size: 400% 400%;
            animation: gradientAnimation 10s ease infinite;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            justify-content: center;
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

        .container {
            width: 100%;
            max-width: 1200px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: auto;
        }

        h1 {
            font-family: 'Book Antiqua', serif;
            font-size: 28px;
            margin-bottom: 20px;
            text-align: center;
        }

        .sensor-info {
            text-align: center;
            margin-bottom: 20px;
        }

        .sensor-info h2 {
            background-image: linear-gradient(135deg, #4BC0C0, #7F7FFF);
            color: white;
            padding: 10px 0;
            font-size: 20px;
            border-radius: 15px;
            font-family: 'League Spartan', sans-serif;
        }

        .badge {
            display: inline-block;
            padding: 0.5em 1em;
            font-size: 14px;
            font-weight: bold;
            color: #fff;
            border-radius: 0.25rem;
        }

        .badge-normal {
            background-color: #28a745; /* Green */
        }

        .badge-warning {
            background-color: #ffc107; /* Yellow */
            color: #212529;
        }

        .badge-danger {
            background-color: #dc3545; /* Red */
        }

        .badge-left {
            margin-right: 10px;
        }

        .peringatan, .saran {
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-family: 'Book Antiqua', serif;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .peringatan {
            background: linear-gradient(135deg, #ffcccc, #ff6666);
            color: #800000;
            border: 1px solid #ff3333;
        }

        .saran {
            background: linear-gradient(135deg, #ffffe0, #ffff99);
            color: #666600;
            border: 1px solid #cccc00;
        }

        .login-logout {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 16px;
        }

        .login-logout a {
            text-decoration: none;
            color: #007bff;
            padding: 10px;
            border-radius: 5px;
            background-color: #f8f9fa;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .login-logout a.logout {
            color: #ffffff;
            background-color: #dc3545; /* Red */
        }
    </style>
</head>

<body>
  <div class="login-logout">
        @if (Auth::check())
            <a href="{{ route('logout') }}" class="logout">Logout</a>
        @else
            <a href="{{ route('login') }}">Login</a>
        @endif
  </div>
  
  <main class="main">
    <div class="container">
        <h1>Informasi</h1>
        <div class="sensor-info">
            <h2 id="waktu">Waktu: {{ $formattedDate }}</h2>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Ketinggian Air dan Keterangan</div>
                    <div class="card-body">
                        <p class="mt-4">
                            <span class="badge badge-left badge-normal" id="tinggi-air">{{ $tair->nilai_tinggi_air ?? '' }} cm</span>
                            <span class="badge badge-right bg-dark" id="keterangan-air">{{ $tair->keterangan ?? 'N/A' }}</span>
                        </p>
                        <p>Apa artinya ini?</p>
                        <ul>
                            <li>Tinggi air saat ini adalah {{ $tair->nilai_tinggi_air ?? '' }} centimeter. Bayangkan tinggi ini kira-kira setinggi jari telunjuk orang dewasa.</li>
                            <li>Kondisi "{{ $tair->keterangan ?? 'N/A' }}" berarti tinggi air ini masih aman dan tidak perlu khawatir akan banjir untuk saat ini.</li>
                        </ul>
                        <p>Mengapa ini penting?</p>
                        <ul>
                            <li>Informasi ini membantu kita mengetahui risiko banjir di daerah kita.</li>
                            <li>Dengan memantau tinggi air secara rutin, kita bisa bersiap-siap lebih awal jika ada tanda-tanda banjir.</li>
                        </ul>
                        <p>Apa yang perlu kita lakukan?</p>
                        <ol>
                            <li>Tetap perhatikan informasi tinggi air secara rutin, terutama saat musim hujan.</li>
                            <li>Jika tinggi air naik dan kondisinya berubah (misalnya menjadi "WASPADA" atau "SIAGA"), ikuti petunjuk dari pihak berwenang.</li>
                            <li>Selalu siapkan tas siaga bencana yang berisi barang-barang penting jika sewaktu-waktu harus mengungsi.</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Volume dan Keterangan Sampah</div>
                    <div class="card-body">
                        <p class="mt-4">
                            <span class="badge badge-left badge-normal" id="volume-sampah">{{ $tempatsampah->volume ?? '' }} cm³</span>
                            <span class="badge badge-right bg-dark" id="keterangan-sampah">{{ $tempatsampah->keterangan ?? 'N/A' }}</span>
                        </p>
                        <p>Tempat sampah yang penuh dapat menyebabkan lingkungan yang tidak sehat. Pastikan untuk segera mengosongkan tempat sampah yang penuh untuk menjaga kebersihan dan kesehatan lingkungan.</p>
                    </div>
                </div>
            </div>
        </div>
        <div id="peringatan-saran">
            @if ($tair && $tair->nilai_tinggi_air >= 5)
                        <div class="peringatan">
                <h3><strong>PERHATIAN WARGA:</strong> Air Mulai Naik!</h3>
                <p>Tinggi air sudah lebih dari 5 cm. Ini bisa menjadi tanda awal banjir.</p>
                
                <h4>Apa yang harus kita lakukan sekarang?</h4>
                <ol>
                    <li>Tetap tenang, tapi mulai bersiap-siap.</li>
                    <li>Pindahkan barang-barang penting ke tempat yang lebih tinggi, seperti:
                        <ul>
                            <li>Dokumen penting (KTP, ijazah, surat-surat berharga)</li>
                            <li>Alat elektronik (HP, laptop)</li>
                            <li>Obat-obatan penting</li>
                        </ul>
                    </li>
                    <li>Siapkan tas darurat berisi:
                        <ul>
                            <li>Makanan tahan lama dan air minum</li>
                            <li>Pakaian ganti</li>
                            <li>Obat-obatan</li>
                            <li>Senter dan baterai cadangan</li>
                        </ul>
                    </li>
                    <li>Pantau terus informasi dari:
                        <ul>
                            <li>Petugas setempat (RT/RW)</li>
                            <li>Radio atau TV lokal</li>
                            <li>Akun media sosial resmi pemerintah daerah</li>
                        </ul>
                    </li>
                </ol>
                
                <p><strong>Ingat:</strong> Keselamatan adalah yang utama. Jika diminta mengungsi, ikuti petunjuk petugas.</p>
                
                <p>Mari kita saling membantu dan menjaga keluarga serta tetangga kita!</p>
            </div>
            @else
                <div class="saran">
                    <p>Ketinggian air masih dalam batas aman. Tetap pantau perubahan ketinggian air secara berkala.</p>
                </div>
            @endif
        </div>
    </div>
  </main><!-- End Main -->

  @include('tools.script')

  <script>
    function fetchData() {
        fetch('/api/sensor-data')
            .then(response => response.json())
            .then(data => {
                document.getElementById('waktu').innerText = 'Waktu: ' + data.formattedDate;
                
                const tinggiAirElement = document.getElementById('tinggi-air');
                const keteranganAirElement = document.getElementById('keterangan-air');
                const volumeSampahElement = document.getElementById('volume-sampah');
                const keteranganSampahElement = document.getElementById('keterangan-sampah');

                tinggiAirElement.innerText = data.tair.nilai_tinggi_air + ' cm';
                keteranganAirElement.innerText = data.tair.keterangan;
                volumeSampahElement.innerText = (data.tempatsampah.nilai_tinggi_sampah * 17 * 12) + ' cm³';
                keteranganSampahElement.innerText = data.tempatsampah.keterangan;

                // Update badge colors based on conditions
                if (data.tair.nilai_tinggi_air >= 5) {
                    tinggiAirElement.classList.remove('badge-normal');
                    tinggiAirElement.classList.add('badge-danger');
                } else {
                    tinggiAirElement.classList.remove('badge-danger');
                    tinggiAirElement.classList.add('badge-normal');
                }

                if (data.tempatsampah.keterangan === 'TEMPAT SAMPAH PENUH') {
                    volumeSampahElement.classList.remove('badge-normal');
                    volumeSampahElement.classList.add('badge-danger');
                } else {
                    volumeSampahElement.classList.remove('badge-danger');
                    volumeSampahElement.classList.add('badge-normal');
                }

                let peringatanSaranDiv = document.getElementById('peringatan-saran');
                if (data.tair.nilai_tinggi_air >= 5) {
                    peringatanSaranDiv.innerHTML = `
                        <div class="peringatan">
                            <p><strong>PERINGATAN: </strong>Ketinggian air di atas 5 cm. Waspada potensi banjir!</p>
                            <p>Saran: Amankan barang berharga ke tempat yang lebih tinggi dan pantau informasi terbaru dari pihak berwenang.</p>
                        </div>
                    `;
                } else {
                    peringatanSaranDiv.innerHTML = `
                        <div class="saran">
                            <p>Ketinggian air masih dalam batas aman. Tetap pantau perubahan ketinggian air secara berkala.</p>
                        </div>
                    `;
                }
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    setInterval(fetchData, 000);
  </script>
</body>
</html>
