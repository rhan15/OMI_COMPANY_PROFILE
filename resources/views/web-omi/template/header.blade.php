<!DOCTYPE html>
<html lang="en">
<body>
    <div class="header-nav sticky-top">
        <div class="container">
            <!-- Navbar -->
            <nav id="navbar-webigr" class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand" href="{{url('/')}}">
                    <!-- <svg width="153" height="57" viewBox="0 0 153 57" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="153" height="57" fill="#BDBDBD"/>
                    </svg> -->

                    <img src="{{ asset('/images/icon/logo_omi_baru.png') }}" alt="" style="max-height: 50px;">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('/')}}/">Beranda <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('/tentang-kami')}}">Tentang Kami</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('/waralaba')}}">Waralaba</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('/berita')}}">Berita</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('/hubungi-kami')}}">Hubungi Kami</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- /Navbar -->
        </div>
    </div>

    <!-- Script -->
    <script>
        $(document).ready(function () {
            let url ="{{url('/')}}";

            // hover menu nav-item
            $('.nav-item').hover(function(){
                $(this).toggleClass("focus");
            });
            // /hover menu nav-item

            // set active nav-item
            //non dropdown
            $(function(){
                var current = location.href;
                console.log(current);
                $('.nav-item a').each(function(){
                    var $this = $(this);
                    // if the current path is like this link, make it active
                    // console.log($this.attr('href'));
                    if($this.attr('href') == current){
                        $this.parent('li').addClass('active');
                        // console.log(current);
                    }
                })
            })

            //dropdown
            $(function(){
                var current = url+location.href;
                $('.nav-item .dropdown-menu a').each(function(){
                    var $this = $(this);
                    // if the current path is like this link, make it active
                    if($this.attr('href') == current){
                        $this.parent('div').parent('li').addClass('active');
                    }
                })
            })
            // /set active nav-item

        });
    </script>
    <!-- /Script -->

</body>

</html>
