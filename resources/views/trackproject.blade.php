@extends('layouts.app')

@section('styles')

<style>
    .validated {
        background: #0ABAB5 !important;
        color: white;
    }

    .icon-btn:hover {
        cursor: pointer;
        color: rgb(10, 186, 181) !important;
        /* background: red; */
    }
</style>

<style type="text/css">
    /*Main page style by message*/
    @import url(http://fonts.googleapis.com/css?family=Open+Sans);

    :root {
        --primary-color: #091429;
        --secondary-color: #0ABAB5;
        --dark-color: #262626;
        --light-color: #B1B1B1;
    }

    /****************************/
    /*------- main styles ------*/
    /****************************/
    html {
        scroll-behavior: smooth;
    }

    body {
        font-family: 'Open Sans', sans-serif !important;
        font-size: calc(14px + (26 - 14) * ((100vw - 300px) / (1600 - 300))) !important;
    }

    .sub-msg {
        text-align: center !important;
        color: #fff !important;
    }

    h1,
    .h1 {
        font-weight: 600 !important;
        font-size: 3.5rem;
        font-size: calc(38px + 4 * (100vw - 767px) / 700);
        line-height: 120% !important;
        vertical-align: top !important;
    }

    h2,
    .h2 {
        font-size: 3.2rem;
        font-size: calc(28px + 4 * (100vw - 767px) / 700);
        font-weight: 700;
    }

    h3,
    .h3 {
        font-size: 2rem !important;
        font-size: calc(24px + 4 * (100vw - 767px) / 700) !important;
        font-weight: 600 !important;
        line-height: 150% !important;
    }

    h4,
    .h4 {
        font-size: 1.6rem;
    }

    h5,
    .h5 {
        font-size: 1.2rem;
        font-weight: 700 !important;
        line-height: 150% !important;
    }

    h6,
    .h6 {
        font-size: 1.4rem;
    }

    p {
        font-size: 16px !important;
        font-weight: normal;
        line-height: 32px;
    }

    p.bold {
        font-size: 18px !important;
        font-weight: 700;
        line-height: 32px;
    }

    .text-primary {
        color: var(--primary-color) !important;
    }

    .text-secondary {
        color: var(--secondary-color) !important;
    }

    .text-dark {
        color: var(--dark-color) !important;
    }

    .text-light {
        color: var(--light-color) !important;
    }

    .bg-primary {
        background-color: var(--primary-color) !important;
    }

    .bg-secondary {
        background-color: var(--secondary-color) !important;
    }

    .bg-light {
        background-color: var(--light-color) !important;
    }

    .bg-dark {
        background-color: var(--dark-color) !important;
    }

    .btn {
        border: none !important;
        display: inline-block;
        position: relative;
        overflow: hidden;
        transition: all ease-in-out .5s;
    }

    .btn::after {
        content: "";
        display: block;
        position: absolute;
        top: 0;
        left: 25%;
        height: 100%;
        width: 40%;
        background-color: #000;
        border-radius: 50%;
        opacity: 0;
        pointer-events: none;
        transition: all ease-in-out 1s;
        transform: scale(5, 5);
    }

    .btn:active::after {
        padding: 0;
        margin: 0;
        opacity: .2;
        transition: 0s;
        transform: scale(0, 0);
    }

    .btn-primary {
        background-color: var(--primary-color) !important;
    }

    .btn-secondary {
        background-color: var(--secondary-color) !important;
    }

    .btn-primary-outline {
        background-color: transparent !important;
        color: var(--primary-color) !important;
        border: 1px solid var(--primary-color) !important;
    }

    .btn-secondary-outline {
        background-color: transparent !important;
        color: var(--secondary-color) !important;
        border: 2px solid var(--secondary-color) !important;
    }

    .btn-primary:hover,
    .btn-secondary:hover,
    .btn-primary-outline:hover,
    .btn-secondary-secondary:hover {
        border-color: inherit !important;
        opacity: 0.8 !important;
    }

    .fas {
        font-size: xx-large;
        color: var(--secondary-color) !important;
    }

    /****************************/
    /*-----Landing Page---------*/
    /****************************/

    /*------Navbar------------*/

    .navbar-main {
        background-color: var(--primary-color);
    }

    .navbar-main .navbar-brand,
    .navbar-main .navbar-text {
        color: rgba(255, 255, 255, 0.9);
    }

    .navbar-main .navbar-nav .nav-link {
        font-size: 1rem;
        color: rgba(255, 255, 255, 0.8);
    }

    .navbar-main .nav-item.active .nav-link,
    .navbar-main .nav-item:hover .nav-link {
        color: #ffffff;
    }

    /* for navbar toggler design */
    .icon-bar {
        width: 22px;
        height: 2px;
        background-color: #B6B6B6;
        display: block;
        transition: all 0.2s;
        margin-top: 4px
    }

    .navbar-toggler {
        border: none;
        background: transparent !important;
    }

    .navbar-toggler:focus {
        outline: none !important;
    }

    /* navbar toggler animation*/

    .navbar-toggler .top-bar {
        transform: rotate(45deg);
        transform-origin: 10% 10%;
    }

    .navbar-toggler .middle-bar {
        opacity: 0;
    }

    .navbar-toggler .bottom-bar {
        transform: rotate(-45deg);
        transform-origin: 10% 90%;
    }

    .navbar-toggler.collapsed .top-bar {
        transform: rotate(0);
    }

    .navbar-toggler.collapsed .middle-bar {
        opacity: 1;
    }

    .navbar-toggler.collapsed .bottom-bar {
        transform: rotate(0);
    }


    .validated {
        background: #0ABAB5 !important;
        color: white;
    }

    .icon-btn:hover {
        cursor: pointer;
        color: rgb(10, 186, 181) !important;
        /* background: red; */
    }

    body {
        background-color: #ffffff;
        width: 100%;
        height: 100%;
        overflow-x: hidden;
        font-family: 'ubuntu'
    }

    /* .logo {
        font-size: 36px;
        font-family: 'pacifico', Ubuntu;
        display: block;
        text-align: left;
        padding-left: 40px;
        margin-top: 20px;
    }

    .logo a {
        text-decoration: none;
        color: #000;
    }

    .logo span {
        color: #0abab5;
    } */

    .box2 {
        padding: 30px;
        max-width: 580px;
        margin: auto;
        background-color: #ffffff;
        border: 2px solid #000000;
        border-radius: 6px;
    }

    .box2 h2 {
        color: #000000;
        text-align: center;
        font-size: 32px;
        font-family: 'Ubuntu';
        margin-bottom: 13px;
        margin-top: 18px;
        padding-top: 8px;
        line-height: 37px;

    }

    .box2 h4 {
        color: #262626;
        text-align: left;
        font-size: 18px;
        line-height: 21px;
        font-family: ubuntu;
        margin-bottom: 13px;
        margin-top: 18px;
        padding-top: 8px;
        margin-left: 38px;
    }

    form {
        /*display: flex;*/
        justify-content: center;
        align-items: center;
        position: relative;
        top: 30px;
        max-width: 500px;
        margin: auto;
        padding-bottom: 30px;
        /*display: grid;*/
        grid-template-areas:
            'input1'
            'View Project';
    }

    /* form input {
        display: block;
        width: 100%;
        margin-top: 10px;
        height: 40px;
        border: 6px solid #eaebed;
        border-radius: 6px;
        padding: 0 10px;
    } */

    input[type=text],
    select {
        width: 100%;
        padding: 0 10px;
        border: 1px solid #eaebed;
        border-radius: 4px;
        height: 45px;
        margin-top: 10px;
        /*box-sizing: border-box;*/
    }

    label {
        font-family: 'Lato';
    }

    .viewproject {
        width: 100%;
        background-color: #0ABAB5;
        color: #ffffff;
        padding: 10px;
        outline: none;
        font-size: 18px;
        font-weight: bold;
        border: none;
        font-family: 'open sans';
        cursor: pointer;
        border-radius: 5px;
        box-sizing: border-box;
    }


    .viewproject:active {
        opacity: 0.6;
    }

    /* p {
        color: #262626;
        font-size: 16px;
        font-family: 'ubuntu'
            font-weight: normal;
        margin-left: 20%;
        margin-top: 30px;
    } */

    a {
        color: #0ABAB5;
        text-decoration: none;
    }

    a:hover {
        text-decoration: none;
    }

    .sr-only {
        margin-right: 300px;
    }

    /*-----------footer list--------*/

    .list-unstyled li a {
        font-size: 17px !important;
        transition: 0.25s !important;
        font-style: normal;
        font-weight: normal;
    }

    .list-unstyled li a:hover {
        color: gray !important;
        text-decoration: none;
    }
</style>
<!--Internal CSS Ends -->

@endsection

@section('header')
<header>
    <nav class="navbar navbar-expand-lg navbar-main">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/svg/logo-white.svg') }}" class="img img-responsive" height="30" width="auto">
            </a>
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="icon-bar top-bar"></span>
                <span class="icon-bar middle-bar"></span>
                <span class="icon-bar bottom-bar"></span>
                <!-- <span class="navbar-toggler-icon"><i class="fa fa-bars fa-lg py-1 text-white"></i></span> -->
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ url('/') }}">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/pricing') }}">Pricing</a>
                    </li>
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('guest/track') }}">Track a Project</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Sign in</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Sign up</a>
                    </li>
                    @endauth
                    @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
</header>
<div class="sub-msg">
</div>
@stop

@section('sidebar')

@endsection

@section('content')
<!-- 
<div class="logo"> <a href="/"> <img src="https://res.cloudinary.com/nxcloud/image/upload/v1570984909/Lancer/Lancers_c40ozr.svg"> </a></div><br> -->
<br>

<div class="container">

    <div class="row">

        <div class="col-sm-3"></div>
        <div class="col-sm-6">

            <div class="box">
                <div class="box2">
                    <h2 style="font-size: 30px;"> Track your Project</h2>
                    <h4 class="text-center">Input your project code to continue</h4>
                    <form method="post" action="/guest/track/project">
                        @csrf
                        <div class="box3">
                            <label for="" style=" font-size: 15px">Project Code</label><br>
                            <input type="text" name="projectid" id="projectid"><br><br>
                        </div>

                        <input type="submit" class="viewproject" value="View Project" style="height: 40px;" />
                        <br><br>
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Or <b><a href="{{ route('login') }}">sign in</a></b> to view your projects</p>
                    </form>
                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>
    </div>
</div>
@section('footer')
<footer class="bg-white pt-4" data-aos="fade-down">
    <div class="container" style="margin-top: 80px;">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-2">
                <img src="https://res.cloudinary.com/nxcloud/image/upload/v1570984909/Lancer/Lancers_c40ozr.svg" alt="" class="img img-responsive mb-2" height="30" width="auto">
                <ul class="list-unstyled">
                    <li><a class="text-dark" href="{{ url('/pricing') }}">Pricing</a></li>
                    <li><a class="text-dark" href="{{ url('/login') }}">Sign in</a></li>
                    <li><a class="text-dark" href="{{ url('/register') }}">Sign up</a></li>
                </ul>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-2">
                <h5>Features</h5>
                <ul class="list-unstyled">
                    <li><a class="text-dark" href="{{ url('/dashboard') }}">Dashboard</a></li>
                    <li><a class="text-dark" href="{{ url('/projects') }}">Projects</a></li>
                    <li><a class="text-dark" href="{{ url('/invoices') }}">Invoices</a></li>
                    <li><a class="text-dark" href="{{ url('/guest/create/step1') }}">Create a Project</a></li>
                </ul>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <h5>Reach us</h5>

                <p class="text-dark small">
                    17 Akinsanya St, Ojodu 100213, Ikeja,
                    Lagos State,
                    Nigeria.
                </p>



                <a href="http://facebook.com/lancers.NG" class="text-dark mr-2"><i class="fab fa-facebook-square"></i></a>
                <a href="http://twitter.com/lancersNG" class="text-dark"><i class="fab fa-twitter-square"></i></a>

            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <h5>Stay up to date</h5>

                <p class="text-dark small">
                    Get emails about our newest features and events you can visit. We promise not to spam.
                </p>

                <form class="form-inline" method="post" action="/submailinglist" style="margin-left: -35px;">
                    @csrf

                    <div class="form-group mb-2 mr-2">
                        <label for="subEmail" class="sr-only">Email</label>
                        <input type="email" class="form-control" id="subEmail" name="subEmail" placeholder="Email Address" required>
                    </div>

                    <input type="submit" class="btn btn-secondary mb-2" id="btn-sub" name="btn-sub" value="Subscribe" />

                </form>
            </div>
        </div>
    </div>
    <div class="bg-white text-left py-2 mt-0">
        <div class="container">
            <h5>
                <p class="float-right">
                    {{-- <a href="#">Back to top</a> --}}
                    <a href="javascript:void(0)" onClick="window.scrollTo(0, 0)" class="btn btn-secondary mb-2" id="btn-sub">
                        <span>&#8593;</span></a>
                </p>

                <p>&copy; Lancers 2019.</p>


        </div>
    </div>
</footer>
<script type="text/javascript">
    var Tawk_API = Tawk_API || {},
        Tawk_LoadStart = new Date();
    (function() {
        var s1 = document.createElement("script"),
            s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/5dc11896e4c2fa4b6bda03bf/default';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
</script>
<!--End of Tawk.to Script-->
@stop
@endsection