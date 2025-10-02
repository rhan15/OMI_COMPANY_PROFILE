<!DOCTYPE html>
<html lang="en">

<head>
    @include('web-omi.template.head')

    <link rel="stylesheet" href=" {{ asset('css/web-omi/tentang-kami.css') }}">
</head>

<body>
    <!-- Header -->
    @include('web-omi.template.header')
    <!-- /Header -->

    <!-- About-Content -->
    <div class="container py-4 content">
        {{-- sejarah content --}}
        <div class="section">
            <div class="section-header">
                <h2>Sejarah OMI</h2>
            </div>
        </div>
        <div class="my-3">
            <ul class="timeline timeline-centered">
                {{-- @foreach ($History as $Histories)
                    <li class="timeline-item">
                        <div class="timeline-info">
                            <span>{{$Histories['years']}}</span>
                        </div>
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h4 class="timeline-title">{{$Histories['title']}}</h4>
                            <h4><img class="image" src="{{ asset('images/dummy')}}/{{ $Histories['path_image'] }}" alt=""></h4>
                            <p>{{$Histories['description']}}</p>
                        </div>
                    </li>
                @endforeach --}}
                <li class="timeline-item">
                    <div class="timeline-info">
                        <span>2001</span>
                    </div>
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h4><img class="image" src="{{ asset('images/sejarah_1.jpg')}}" alt=""></h4>
                        <p class="deskripsi_history">
                            Di Tahun 2001, Indogrosir memulai membina dan membentuk toko-toko tradisional menjadi minimarket modern dengan pola mekanisme kerjasama kemitraan, maka diberi nama Outlet Mitra Indogrosir (OMI).
                        </p>
                    </div>
                </li>
                <li class="timeline-item">
                    <div class="timeline-info">
                        <span>2003</span>
                    </div>
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h4><img class="image" src="{{ asset('images/sejarah_2.jpg')}}" alt=""></h4>
                        <p class="deskripsi_history">
                            Sejak tahun 2003, Indogrosir menyempurnakan konsep kerjasama pembinaan Mini Market Modern dalam bentuk Waralaba. Penyempurnaan konsep ini pun berkembang selain membantu toko tradisional juga membantu pengembangan penjualan di koperasi baik di perusahaan maupun instansi.
                        </p>
                    </div>
                </li>
                <li class="timeline-item">
                    <div class="timeline-info">
                        <span>Sekarang</span>
                    </div>
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h4><img class="image" src="{{ asset('images/sejarah_3.jpg')}}" alt=""></h4>
                        <p class="deskripsi_history">
                            Saat ini Indogrosir sudah melayani lebih dari 150 kota besar di Indonesia dengan 600 outlet baik koperasi maupun perseorangan di rumah sakit, Apartemen, Hotel, Instansi Swasta dan Pemerintah, SPBU, Pabrik. Saat ini berada di 11 Cabang Indogrosir secara nasional seperti Jabodetabek, Bandung, Semarang, Solo, Surabaya, Medan, Palembang, Pekanbaru serta Makasar dan akan di memperluas area layanan keseluruh Indonesia.
                        </p>
                    </div>
                </li>
            </ul>
        </div>
        {{-- /sejarah content --}}
        <div><span class="line"></span></div>
        {{-- Visi Misi Contect --}}
        <div id="VisiMisi" class="container">
            <div class="section">
                <div class="section-header">
                    <h2> Visi dan Misi</h2>
                </div>
            </div>
            <div class="row">

                <div class="col-lg-6 my-3 d-flex align-items-stretch">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-text">“MENJADI ASET NASIONAL DALAM JARINGAN DISTRIBUSI MODERN YANG UNGGUL DALAM PERSAINGAN GLOBAL”</p>
                        </div>
                        <div class="card-lines"></div>
                        <div class="card-footer bg-transparent border-0">Visi</div>
                    </div>
                </div>
                <div class="col-lg-6 my-3 d-flex align-items-stretch">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-text">“MENGEMBANGKAN MITRA USAHA MENJADI TANGGUH MELALUI BISNIS RETAIL”</p>
                        </div>
                        <div class="card-lines"></div>
                        <div class="card-footer bg-transparent border-0">Misi</div>
                    </div>
                </div>
            </div>
        </div>
    {{-- /Visi Misi Content --}}
    </div>
    <!-- /About-Content -->

    <!-- Footer -->
    @include('web-omi.template.footer')
    <!-- /Footer -->

    <!-- Js -->
    <script>
        $( document ).ready(function() {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const menu = urlParams.get('menu');

            if (menu == "visi") {
                var elmnt = document.getElementById("VisiMisi");
                elmnt.scrollIntoView();
            }
        });
    </script>
    <!-- /Js -->

</body>

</html>
