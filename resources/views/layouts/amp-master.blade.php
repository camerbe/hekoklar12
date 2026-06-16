<!doctype html>
<html ⚡ lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">

    <x-meta
        :title="$title ?? ''"
        :description="$description ?? ''"
        :image="$image ?? 'https://images.unsplash.com/photo-1492724441997-5dc865305da7'"
        :image_width="$image_width?? '400'"
        :image_height="$image_height?? '282'"
        :keyword="$keyword?? ''"
        :modified_time="$modified_time?? ''"
        :published_time="$published_time?? ''"
        :section="$section?? ''"
        :author="$author?? ''"
        :source="$source?? ''"
        :publisher="$publisher?? ''"
        :canonical="$canonical?? ''"
    />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="index,follow">
    <link rel="icon" type="image/x-icon" href=" {{asset('assets/logo/hekok.ico')}}" />
    <!-- AMP -->
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script>
    <script async custom-element="amp-accordion" src="https://cdn.ampproject.org/v0/amp-accordion-0.1.js"></script>
    <script async custom-element="amp-next-page" src="https://cdn.ampproject.org/v0/amp-next-page-1.0.js"></script>
    <script async custom-element="amp-social-share" src="https://cdn.ampproject.org/v0/amp-social-share-0.1.js"></script>
    <script async custom-element="amp-ad" src="https://cdn.ampproject.org/v0/amp-ad-0.1.js"></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style amp-custom>
        :root{
            --ocre:#C8651A;
            --or:#E8A020;
            --nuit:#1A0F05;
            --sable:#F5E6C8;
            --creme:#FDF6E3;
            --blanc:#ffffff;
        }

        *{box-sizing:border-box}

        body{
            margin:0;
            font-family:'Poppins',sans-serif;
            background:var(--creme);
            color:var(--nuit);
            line-height:1.6;
        }

        header{
            position:fixed;
            top:0;
            left:0;
            width:100%;
            z-index:1000;
            background:rgba(26,15,5,.96);
            color:var(--or);
            padding:15px 20px;
            text-align:center;
            font-weight:700;
            letter-spacing:.3px;
        }

        .menu-btn{
            position:absolute;
            left:15px;
            top:10px;
            font-size:22px;
            background:none;
            border:none;
            color:var(--or);
            cursor:pointer;
            padding:6px 10px;
        }

        amp-sidebar{
            background:var(--nuit);
            color:var(--sable);
            width:260px;
            padding:20px;
        }

        amp-sidebar .sidebar-title{
            font-size:20px;
            font-weight:700;
            color:var(--or);
            margin-bottom:14px;
        }

        amp-sidebar a{
            display:block;
            color:var(--sable);
            text-decoration:none;
            padding:12px 0;
            border-bottom:1px solid rgba(255,255,255,.08);
        }

        .hero{
            min-height:100vh;
            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;
            text-align:center;
            background:linear-gradient(160deg,#1A0F05,#3D1A08);
            color:var(--sable);
            padding:110px 20px 40px;
        }

        .hero h1{
            font-size:42px;
            line-height:1.12;
            margin:0 0 14px;
        }

        .hero h1 span{
            color:var(--or);
        }

        .hero p{
            max-width:760px;
            margin:0 auto 24px;
            font-size:17px;
        }

        .hero-actions{
            margin-bottom:20px;
        }
        .hero-content a{
            min-height:5vh;
            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;
            text-align:center;
            padding:5px ;
        }
        .btn{
            display:inline-block;
            padding:14px 26px;
            border-radius:999px;
            margin:6px;
            text-decoration:none;
            font-weight:600;
            transition:none;
        }

        .btn-primary{
            background:linear-gradient(135deg,#C8651A,#E8A020);
            color:#fff;
        }

        .btn-outline{
            border:2px solid var(--or);
            color:var(--or);
            background:transparent;
        }

        section{
            padding:80px 20px;
            max-width:1100px;
            margin:0 auto;
        }

        h2{
            font-size:32px;
            margin-top:0;
            margin-bottom:25px;
            color:var(--nuit);
        }

        .intro{
            max-width:820px;
            margin:0 auto;
            text-align:center;
        }

        .grid{
            display:grid;
            gap:20px;
        }

        .card{
            background:#fff;
            border-radius:18px;
            padding:22px;
            box-shadow:0 10px 30px rgba(0,0,0,.08);
        }

        .card h3{
            margin-top:0;
            margin-bottom:10px;
            color:var(--ocre);
        }

        .section-alt{
            background:rgba(232,160,32,.08);
            border-top:1px solid rgba(0,0,0,.04);
            border-bottom:1px solid rgba(0,0,0,.04);
        }

        amp-accordion section{
            padding:0;
            margin:0 0 14px;
            background:#fff;
            border-radius:16px;
            overflow:hidden;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
        }

        amp-accordion h4{
            margin:0;
            padding:18px 20px;
            font-size:18px;
            color:var(--ocre);
            background:#fff;
        }

        amp-accordion p{
            margin:0;
            padding:0 20px 20px;
        }

        .pagination{
            display:flex;
            justify-content:center;
            align-items:center;
            gap:10px;
            flex-wrap:wrap;
            margin-top:32px;
        }

        .pagination a,
        .pagination span{
            display:inline-block;
            padding:10px 16px;
            border-radius:999px;
            text-decoration:none;
            font-weight:600;
            border:2px solid var(--or);
            color:var(--ocre);
            background:#fff;
            min-width:46px;
            text-align:center;
        }

        .pagination .is-active{
            background:linear-gradient(135deg,#C8651A,#E8A020);
            color:#fff;
            border-color:transparent;
        }
        .content{text-align: justify; display:block;}
        .contact-box{
            background:#fff;
            border-radius:18px;
            padding:24px;
            box-shadow:0 10px 30px rgba(0,0,0,.08);
            text-align:center;
        }

        .separator-next{
            max-width:1100px;
            margin:0 auto 30px;
            padding:16px 20px;
            text-align:center;
            font-weight:600;
            color:var(--ocre);
            border-top:2px solid rgba(200,101,26,.18);
            border-bottom:2px solid rgba(200,101,26,.18);
            background:rgba(255,255,255,.7);
        }

        .footer{
            background:var(--nuit);
            color:#c8c8c8;
            text-align:center;
            padding:40px 20px;
        }

        @media (min-width:768px){
            .hero h1{font-size:60px}
            .grid{grid-template-columns:repeat(3,1fr)}
        }
    </style>

    <style amp-boilerplate>
        body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}
        @keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}
    </style>
    <noscript>
        <style amp-boilerplate>
            body{animation:none}
        </style>
    </noscript>


</head>

<body>

<header>
    <button class="menu-btn" on="tap:sidebar.toggle" aria-label="Ouvrir le menu">☰</button>
    Banen du Benelux
    <amp-img
        title="{{$title}}"
        alt="Hekok"
        src="{{asset('assets/logo/logo-hekok-trans.png')}}"
        width="86"
        height="60"
        layout="responsive">
    </amp-img>
</header>

<amp-sidebar id="sidebar" layout="nodisplay">
    <a href="{{env('AMP_URL')}}/accueil">Accueil</a>
    <a href="#histoire">Histoire</a>
    <a href="#equipe">Équipe</a>
    <a href="#contact">Contact</a>
</amp-sidebar>

<section id="accueil" class="hero">
    <p>Hekok — « Je suis parce que nous sommes »</p>
    @include('partials.amp-adsense')
</section>

@yield('content')
@yield('scripts')
<footer class="footer">
    <p>© Hekok - Banen du Benelux</p>
</footer>

</body>
</html>
