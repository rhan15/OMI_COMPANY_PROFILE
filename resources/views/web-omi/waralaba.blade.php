<!DOCTYPE html>
<html lang="en">

<head>
    @include('web-omi.template.head')

    <link rel="stylesheet" href=" {{ asset('css/web-omi/template/sidenav.css') }}">
    <link rel="stylesheet" href=" {{ asset('css/web-omi/waralaba.css') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>


<body>
    <!-- Header -->
    @include('web-omi.template.header')
    <!-- /Header -->

    <!-- Waralaba content -->
    <div class="container content">
        <div class="wrapper py-5">
            <!-- Nav Menu -->
            <aside>
                <div id="mask-overlay" class="mask-overlay"></div>
                <div id="Nav-Left" class="left-navigation promosi-navigation sticky-top sticky-offset">
                    <div class="nav flex-column nav-pills" id="nav-tab" role="tablist" aria-orientation="vertical">
                        <?php
                            $active = 'active';
                        ?>
                        @foreach ($Menu as $menus)
                        <?php
                            $menu2 = str_replace('&', '_', $menus);
                        ?>
                            <div id="menu-{{ str_replace(' ', '_', $menu2) }}" class="menu-title menu-item {{$active}}" data-toggle="pill" role="tab" href="#{{ str_replace(' ', '_', $menu2) }}" aria-selected="true">
                                {{ $menus }}
                            </div>
                            <?php
                                $active = '';
                            ?>
                        @endforeach
                    </div>
                </div>
            </aside>
            <!-- /Nav Menu -->

            <!-- Main Content -->
            <main>
                <div class="tab-content" id="v-pills-tabContent">
                <!-- mengapa-omi -->
                <div class="tab-pane fade show active" id="Mengapa_OMI" role="tabpanel">
                    <div class="banner">
                        <img src="{{ asset('images/waralaba_mengapa_omi.jpg') }}" alt="">
                        <div class="row">
                            <div class="banner-title">OMI dalam Angka</div>
                            <div class="row col justify-content-around mb-4">
                                <div class="">
                                    <div class="banner-angka">10</div>
                                    <div class="banner-ket">Provisi</div>
                                </div>
                                <div class="">
                                    <div class="banner-angka">152</div>
                                    <div class="banner-ket">Kota</div>
                                </div>
                                <div class="">
                                    <div class="banner-angka">600+</div>
                                    <div class="banner-ket">Toko</div>
                                </div>
                                <div class="">
                                    <div class="banner-angka">250+</div>
                                    <div class="banner-ket">Koperasi</div>
                                </div>
                            </div>
                        </div>
                        {{-- Pendahuluan --}}
                        <div>
                            <div class="banner-title">Pendahuluan</div>
                            <p>
                                Suatu hal yang tak dapat disangkal bahwa bisnis yang masih akan tetap hidup bahkan semakin kokoh di saat terjadinya “Krisis Ekonomi” adalah “RETAIL MINIMARKET”, karena jenis barang dan jasa yang ditransaksikan adalah berupa barang dagangan yang dikonsumsi sehari-hari, hal ini seiring dengan perkembangan zaman dan memasuki era globalisasi, dimana kebutuhan harian pelanggan ingin dipenuhi secara “cepat, praktis dan hemat”.
                            </p>
                            <p>
                                <dl>
                                    <dt class="mb-2">Kendala utama yang dihadapi di dalam menjalankan bisnis retail minimarket adalah :</dt>
                                    <dd>- Pasokan barang tidak dari sumber yang tepat.</dd>
                                    <dd>- Perolehan harga beli yang kurang tepat ( sudah dari tangan ke-3 dan seterusnya ).</dd>
                                    <dd>- Pemilihan item kurang tepat sehingga banyak yang tidak produktif.</dd>
                                    <dd>- Persediaan barang yang tidak efisien ( harus dalam jumlah minimal tertentu ).</dd>
                                    <dd>- Tidak adanya dukungan sistem yang modern ( masih manual ).</dd>
                                    <dd>- Sistem pemesanan barang masih manual ( tidak otomatis ).</dd>
                                </dl>
                            <p>
                                Untuk menjawab semua kendala utama di atas, maka solusinya adalah bergabung dengan OMI.
                            </p>
                        </div>
                        {{-- Keutungan --}}
                        <div>
                            <div class="banner-title">Keuntungan</div>
                            <p>
                                <dl>
                                    <dd>- Nama toko menggunakan nama sendiri yang ditentukan pemilik.</dd>
                                    <dd>- Jaminan pasokan barang dagangan.</dd>
                                    <dd>- Penataan toko dan pemajangan/display barang dagangan yang teratur rapi sesuai planogram.</dd>
                                    <dd>- Program promosi yang berkesinambungan.</dd>
                                    <dd>- Mendapatkan pelatihan dan pengawasan, sehingga terwaralaba bisa mengelola bisnisnya secara mandiri.</dd>
                                    <dd>- Pengelolaan karyawan dan keuangan dilakukan pemilik.</dd>
                                    <dd>- Boleh menjual item barang diluar yang bisa disupply Indogrosir.</dd>
                                    <dd>- Transaksi penjualan bisa dilakukan secara kredit.</dd>
                                    <dd>- Tergabung dengan jaringan usaha besar dan modern.</dd>
                                    <dd>- Memperoleh peminjaman software yang terintegrasi dengan sistem operasional minimarket meliputi: penjualan, pemesanan barang, serta penetapan harga jual.</dd>
                                    <dd>- Dukungan sistem pembayaran PPOB meliputi penjualan pulsa, pembayaran listrik, pembayaran air dan pembayaran lainnya.</dd>
                                </dl>
                            </p>
                        </div>
                        <div class="my-5">
                            <a href="{{url('/registrasi')}}"><button class="btn-daftar">Daftar Sekarang!</button> </a>
                        </div>
                    </div>
                </div>
                <!-- /mengapa-omi -->

                <!-- syarat-ketentuan -->
                <div class="tab-pane fade show" id="Syarat___Ketentuan" role="tabpanel">
                    <div class="title">Berikut ini adalah syarat mudah yang harus dipenuhi untuk bergabung dengan Kami</div>
                    <div class="my-4 ml-1 row">
                        <div class="icon"><img src="{{ asset('images/icon/check.png') }}" alt=""></div>
                        <div class="col syarat">Warga Negara Indonesia.</div>
                    </div>
                    <div class="my-4 ml-1 row">
                        <div class="icon"><img src="{{ asset('images/icon/check.png') }}" alt=""></div>
                        <div class="col syarat">Memiliki bangunan untuk toko dan gudang di lokasi yang strategis.</div>
                    </div>
                    <div class="my-4 ml-1 row">
                        <div class="icon"><img src="{{ asset('images/icon/check.png') }}" alt=""></div>
                        <div class="col syarat">Memiliki modal kerja yang cukup sesuai dengan standar waralaba OMI.</div>
                    </div>
                    <div class="my-4 ml-1 row">
                        <div class="icon"><img src="{{ asset('images/icon/check.png') }}" alt=""></div>
                        <div class="col syarat">Bersedia merubah tampilan toko baik di dalam maupun di luar toko sesuai dengan standar OMI.</div>
                    </div>
                    <div class="my-4 ml-1 row">
                        <div class="icon"><img src="{{ asset('images/icon/check.png') }}" alt=""></div>
                        <div class="col syarat">Mempunyai minat dan keinginan dalam bisnis minimarket.</div>
                    </div>
                    <div class="my-4 ml-1 row">
                        <div class="icon"><img src="{{ asset('images/icon/check.png') }}" alt=""></div>
                        <div class="col syarat">Mempunyai karyawan sendiri.</div>
                    </div>
                    <div class="my-4 ml-1 row">
                        <div class="icon"><img src="{{ asset('images/icon/check.png') }}" alt=""></div>
                        <div class="col syarat">Bersedia terikat dalam persyaratan dan perjanjian waralaba.</div>
                    </div>
                    <div class="title">Tertarik Mendaftar OMI? Tunggu apalagi, Yuk gabung bersama jaringan waralaba Kami!</div>
                    <div class="my-3">
                        <a href="{{url('/registrasi')}}"><button class="btn-daftar">Daftar Sekarang!</button> </a>
                    </div>
                </div>
                <!-- /syarat-ketentuan -->

                <!-- jenis-investasi -->
                <div class="tab-pane fade show" id="Jenis_Investasi" role="tabpanel">
                    <div class="title">Nilai Investasi</div>
                    <div class="invest-table">
                        <table>
                            <tr>
                                <th rowspan="2">TYPE<br> TOKO</th>
                                <th rowspan="2">SELLING<br> SPACE<br> MINIMAL<br> (M2)</th>
                                <th rowspan="2">SASARAN<br> SPD<br> ( Ribuan )</th>
                                <th rowspan="2">GROSS<br> MARGIN<br> %</th>
                                <th rowspan="2">ITEM<br> PRODUCT</th>
                                <th rowspan="2">FEE WARALABA<br> /5 TAHUN</th>
                                <th colspan="3">INVESTASI</th>
                                <th>PAY BACK</th>
                            </tr>
                            <tr>
                                <th>PERALATAN<br> (Rp.)</th>
                                <th>BARANG<br> DAGANGAN<br> (Rp.)</th>
                                <th>TOTAL*<br> (INC. PPN)<br> (Rp.)</th>
                                <th>PERIODE<br> ( Bulan )</th>
                            </tr>
                            <tr>
                                <td>R-8</td>
                                <td>30-40</td>
                                <td>3500</td>
                                <td>16-18</td>
                                <td>800</td>
                                <td rowspan="3">33 Juta</td>
                                <td>77 Juta</td>
                                <td>80 Juta</td>
                                <td>190 Juta</td>
                                <td>36</td>
                            </tr>
                            <tr>
                                <td>R-15</td>
                                <td>40-50</td>
                                <td>5000</td>
                                <td>15 - 16.5</td>
                                <td>1300</td>
                                <td>117 Juta</td>
                                <td>100 Juta</td>
                                <td>250 Juta</td>
                                <td>36</td>
                            </tr>
                            <tr>
                                <td>R-29</td>
                                <td>> 50</td>
                                <td>6000</td>
                                <td>15 - 16.5</td>
                                <td>2000</td>
                                <td>147 Juta</td>
                                <td>120 Juta</td>
                                <td>300 Juta</td>
                                <td>36</td>
                            </tr>
                        </table>
                    </div>
                    <div class="keterangan-invest">
                        <dl>
                            <dt> Keterangan:</dt>
                            <dd> * Total Investasi tergantung Luas Toko & Potensi Penjualan</dd>
                        </dl>
                        <dl>
                            <dt>PERKIRAAN NILAI INVESTASI SUDAH MENCAKUP :</dt>
                            <dd>- Peralatan dan barang dagangan (termasuk papan nama toko).</dd>
                            <dd>- Peminjaman software dan support selama masa waralaba.</dd>
                            <dd>- Training personil sesuai dengan SOP OMI.</dd>
                            <dd>- Support promosi belanja hemat selama masa waralaba.</dd>
                            <dd>- Supervisi atas operasional toko selama masa waralaba.</dd>
                            <dd>- Promosi dan pembukaan toko.</dd>
                        </dl>
                    </div>
                    <div class="title">Niali Royalti</div>
                    <div class="invest-table">
                        <table>
                            <tr>
                                <th rowspan="2">TYPE TOKO</th>
                                <th colspan="2">KEWAJIBAN INVESTOR</th>
                                {{-- <th colspan="3">JUMLAH KARYAWAN</th> --}}
                                {{-- <th rowspan="2">TOTAL<br> KARYAWAN</th> --}}
                            </tr>
                            <tr>
                                <th>ROYALTY / BLN <br> SALES / BLN</th>
                                <th>FREE DISTRIBUSI / NILAI STRUK (EXC. PPN)</th>
                                {{-- <th>KEPALA TOKO	</th>
                                <th>KASIR</th>
                                <th>PRAMUNIAGA</th> --}}
                            </tr>
                            <tr>
                                <td>R - 8</td>
                                <td rowspan="3">2 %</td>
                                <td rowspan="3">3 %</td>
                                {{-- <td>2</td>
                                <td>1</td>
                                <td>1</td>
                                <td>4</td> --}}
                            </tr>
                            <tr>
                                <td>R - 15</td>
                                {{-- <td>2</td>
                                <td>2</td>
                                <td>1</td>
                                <td>5</td> --}}
                            </tr>
                            <tr>
                                <td>R - 29</td>
                                {{-- <td>2</td>
                                <td>2</td>
                                <td>2</td>
                                <td>6</td> --}}
                            </tr>
                        </table>
                        <div class="keterangan-invest">
                            <dl>
                                <dd>* Biaya Administrasi : Diambil dari Omset Total</dd>
                                <dd>* Biaya Pengiriman : Diambil dari HPP barang kirim</dd>
                                <dd>* Jumlah Karyawan tergantung dengan Potensi dan Jam Operasional Toko</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <!-- /jenis-investasi -->

                <!-- kisah-sukses -->
                <div class="tab-pane fade show" id="Kisah_Sukses" role="tabpanel">
                    @foreach ($Testimonials as $Testimoni)
                    <div class="row mb-4">
                        <div class="row col-lg align-self-center">
                            <div class=" col-12">
                                @if ($Testimoni['is_video']==1)
                                    <iframe class="item-video" width="100%" height="100%" src="{{$Testimoni['url']}}"></iframe>
                                @else
                                    <img class="item-video" src="{{$Testimoni['url']}}" alt="">
                                @endif
                            </div>
                        </div>
                        <div class="col align-self-start">
                            <p class="text-title col-12">{{$Testimoni['title']}}</p>
                            <p class="text-date col-12">
                                <?php
                                setlocale(LC_ALL, 'IND');
                                echo strftime('%d %B %Y', strtotime($Testimoni['created_at']))
                                ?>
                            </p>
                            <div class="text-detail col-12">
                                <?php echo $Testimoni['description']; ?>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- /kisah-sukses -->

                <!-- tanya-jawab -->
                <div class="tab-pane fade show" id="Tanya_Jawab" role="tabpanel">
                    @foreach ($FaqCategory as $FaqCategorys)
                    <div class="card card-body my-4">
                        <button class="btn btn-light collapsed" type="button" data-toggle="collapse" data-target="#category-{{$FaqCategorys['id']}}" aria-expanded="false" aria-controls="#category-{{$FaqCategorys['id']}}">
                            {{$FaqCategorys['title']}}
                            <span class="float-right">
                                <i class="fas fa-angle-up"></i>
                            </span>
                        </button>
                        <div class="collapse multi-collapse faq-info" id="category-{{$FaqCategorys['id']}}">
                            @foreach ($Faq as $Faqs)
                                @if ($FaqCategorys['id'] == $Faqs['faq_group_id'] )
                                <b>Tanya : </b> <?php echo $Faqs['question'] ?><br>
                                <b>Jawab : </b> <?php echo $Faqs['answer'] ?>
                                <p></p>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- /tanya-jawab -->

                <!-- persebaran-omi -->
                <div class="tab-pane fade show" id="Persebaran_OMI" role="tabpanel">
                    <div>
                        @include('web-omi.template.lokasi')
                    </div>
                </div>
                <!-- /persebaran-omi -->

                <div id="menu-button" class="sticky-open-button shadow-lg">
                    Menu
                </div>

                </div>
            </main>
            <!-- /Main Content -->

        </div>
    </div>

    <!-- /Waralaba content -->

    <!-- Footer -->
    @include('web-omi.template.footer')
    <!-- /Footer -->

    <!-- Script -->
    <!-- /Script -->
</body>

</html>

<script>
    function pesebaranOMI(){
        document.getElementById('lokasiomi').style.visibility = 'visible';
        document.getElementsByClassName('banner')[0].innerHTML = '';
    }
</script>
