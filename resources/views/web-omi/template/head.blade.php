
<meta charset="UTF-8">

<!-- <link rel="icon" href="{{ asset('images/logo/igr_200 1.png') }}"> -->

<!-- Font -->
<link href="https://fonts.googleapis.com/css?family=PT Sans&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Markazi Text" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Mulish" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Nerko One" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('admin-lte/plugins/fontawesome-free/css/all.min.css') }}">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}" crossorigin="anonymous">
<!-- other css -->
<link rel="stylesheet" href="{{ asset('css/web-omi/template/header.css') }}" crossorigin="anonymous">

<!-- Js Jquery -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"  crossorigin="anonymous"></script>

<!-- Js Sweeet Alert  -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!-- Google Analitycs -->
<script>
    window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
    ga('create', 'UA-180084376-2', 'auto');

    var page = "{{$page ?? ''}}";

    if (document.location.pathname.indexOf('berita/'+page) > -1) {
        ga('set', 'page', document.location.pathname.replace('berita/' + page, 'berita'));
        ga('send', 'pageview');
    } else {
        ga('set', 'page', document.location.pathname);
        ga('send', 'pageview');
    }
</script>
<script async src='https://www.google-analytics.com/analytics.js'></script>

<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1"/>
<title>OMI Franchise</title>
<link rel="icon" href="{{ asset('images/logo/omi_square.png') }}">


