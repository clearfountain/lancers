@extends('layouts.auth')

@section('title', 'Contact Support')

@section('styles')
<link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">
<style>
  body {
    padding: 0;
    margin: 0;
  }

  a {
    text-decoration: none;
    color: inherit;
  }

  .main-cont {
    font-family: 'Ubuntu', sans-serif;
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    grid-template-rows: 85px auto;
    height: 100vh;
  }

  /*sidebar*/
  .sidebar {
    grid-column: 1 / 2;
    grid-row: 1 / -1;
    background-color: #091429;
    color: #ffffff;
    height: 100%;
  }

  .sidebar-content {
    margin: 55px 22px;
  }

  .logo-img {
    height: 30px;
  }

  .nav-table {
    margin: 50px 0px;
  }

  .icon {
    height: 25px;
    margin-right: 10px;
  }

  .nav-txt {
    font-size: 0.9rem;
    font-weight: 600;
  }

  /*header*/
  .header {
    grid-column: 2 / -1;
    display: flex;
    flex-flow: row nowrap;
    align-items: center;
    justify-content: space-between;
    background-color: #ffffff;
    box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.25);
  }

  .header>h3 {
    margin: 0px 40px;
    font-size: 1.4rem;
  }

  .header p {
    margin: 0 7px;
    align-self: center;
    font-weight: bold;
    font-size: 15px;
  }

  .header-items {
    display: flex;
    flex-flow: row nowrap;
    align-items: center;
  }

  .header-items>div {
    margin: 0 13px;
    display: flex;
    flex-flow: row nowrap;
    align-items: center;
  }

  .header-icon {
    height: 25px;
  }

  .avatar-sm {
    border-radius: 50%;
    height: 45px;
  }

  .dropdown {
    display: block;
    position: relative;
  }

  .dropdown-menu {
    opacity: 0;
    visibility: hidden;
    position: absolute;
    z-index: 1;
    width: auto;
    background-color: #091429;
    border-radius: 5px;
    color: #ffffff;
    margin-top: 100px;
    transition: opacity ease-in 500ms;
  }

  .dropdown-menu.active {
    visibility: visible;
    opacity: 1;
  }

  .menu-item {
    margin: 10px;
    display: block;
    text-align: center;
    border: none;
    border-bottom: 2px solid #091429;
    transition: border-bottom ease-in 400ms;
  }

  .menu-item:hover {
    border: none;
    border-bottom: 2px solid #ffffff;
  }

  .caret-down {
    align-self: center;
    cursor: pointer;
  }

  /* ---------------------------------------------------
    SIDEBAR STYLE
----------------------------------------------------- */
  .wrapper {
    display: flex;
    width: 100%;
    align-items: stretch;
    perspective: 1500px;
  }

  #sidebar {
    min-width: 250px;
    max-width: 250px;
    background: var(--primary-color);
    color: #fff;
    transition: all 0.6s cubic-bezier(0.945, 0.020, 0.270, 0.665);
    transform-origin: bottom left;
  }

  #sidebar.active {
    margin-left: -250px;
    transform: rotateY(100deg);
  }

  #sidebar .sidebar-header {
    padding: 20px;
    background: var(--primary-color);
  }

  #sidebar ul.components {
    padding: 20px 0;
    border-bottom: 1px solid var(--primary-color);
  }

  #sidebar ul p {
    color: #fff;
    padding: 10px;
  }

  #sidebar ul li a {
    padding: 10px;
    font-size: 1em;
    font-weight: 600;
    display: block;
    transition: 0.4;
  }

  #sidebar ul li a:hover {
    color: #ffffff;
    background: rgba(19, 41, 82, 1);
  }

  #sidebar ul li a img {
    margin-top: -4px !important;
    margin-left: 4px;
    margin-right: 4px;
  }

  #sidebar.active ul li a span {
    vertical-align: text-bottom !important;
  }

  #sidebar ul li.active>a,
  a[aria-expanded="true"] {
    color: #fff;
    background: rgba(19, 41, 82, 1);
  }

  a[data-toggle="collapse"] {
    position: relative;
  }

  .dropdown-toggle::after {
    display: block;
    position: absolute;
    top: 50%;
    right: 20px;
    transform: translateY(-50%);
  }

  ul ul a {
    font-size: 0.9em !important;
    padding-left: 30px !important;
    background: rgba(19, 41, 82, 1);
    ;
  }

  ul.CTAs {
    padding: 20px;
  }

  ul.CTAs a {
    text-align: center;
    font-size: 0.9em !important;
    display: block;
    border-radius: 5px;
    margin-bottom: 5px;
  }

  a.download {
    background: #fff;
    color: #7386D5;
  }

  a.article,
  a.article:hover {
    background: rgba(19, 41, 82, 1) !important;
    color: #fff !important;
  }

  /*main body content*/
  .content {
    grid-column: 2 / -1;
    text-align: center;
  }

  .hero-img {
    height: 60vh;
    width: 45vw;
    align-self: center;
  }

  .content>h4 {
    font-weight: 700;
    font-size: 1.2rem;
  }

  .contact-form {
    display: flex;
    flex-flow: column nowrap;
    margin: 60px 15vw;
    font-family: inherit;
  }

  .form-label {
    font-size: 0.8rem;
    align-self: flex-start;
    font-weight: bold;
    color: #575757;
  }

  .inpt {
    height: 30px;
    margin: 10px 0 40px 0;
    font-size: 1rem;
    border: 1px solid #000000;
  }

  .txt-area {
    margin: 10px 0 40px 0;
    font-size: 1rem;
    font-family: 'Ubuntu', sans-serif;
    border: 1px solid #000000;
  }

  .contact-form-btn {
    width: 155px;
    padding: 10px 20px;
    font-size: 18px;
    align-self: center;
    color: #ffffff;
    background-color: #091429;
    border: 1px solid #091429;
    font-family: inherit;
  }

  .contact-form-btn:hover {
    background-color: #032566;
    border: 1px solid #032566;
    cursor: pointer;
    font-family: inherit;
  }

  /*media query*/
  @media(max-width: 600px) {
    .main-cont {
      grid-template-columns: repeat(4, 1fr);
    }

    .header {
      grid-column: auto;
    }

    .header>h4 {
      margin: 0 10px;
    }

    .hero-img {
      width: 80vw;
    }

    .inpt,
    .txt-area {
      margin: 10px 0 40px 0;
    }
  }
</style>
@endsection

@section('content')

<body>
  <div class="main-cont">

    <div class="header">

      <h3>Contact Support</h3>
      <div class="header-items">
        <div>
          <a href="contact"><img src="https://res.cloudinary.com/slarin/image/upload/v1570685957/contact-support/help_pvv3ie.svg" class="header-icon"></a>
          <a href="contact">
            <p>Support</p>
          </a>
        </div>

      </div>
    </div>

    <div class="sidebar">
      <div class="sidebar-content">

        <!-- <div class="wrapper"> -->
        <!-- Side Nav -->
        <nav id="sidebar">
          <div class="sidebar-header">

            <a href="{{ url('dashboard') }}"><img src="https://lancer-app.000webhostapp.com/images/svg/Lancers.svg" height="35" width="auto" class="img img-responsive"></a>

          </div>
          <ul class="list-unstyled components">
            <li class=" @if(request()->path() == 'dashboard') active @endif">
              <a href="{{url('dashboard')}}">
                <img src="https://lancer-app.000webhostapp.com/images/svg/home.svg" height="20" width="auto"> <span> Dashboard</span></a>
            </li>
            <li class=" @if(request()->path() == 'client' || request()->routeIs('viewClient') ) active @endif">
              <a href="{{url('clients')}}">
                <img src="https://lancer-app.000webhostapp.com/images/svg/customer.svg" height="20" width="auto"> <span> Client</span>
              </a>
            </li>
            <li class="@if(request()->path() == 'projects/status') active @endif">
              <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><img src="https://lancer-app.000webhostapp.com/images/svg/lightbulb.svg" height="20" width="auto"> <span> Projects</span></a>
              <ul class="collapse list-unstyled " id="homeSubmenu">
                <li>
                  <a href="{{url('project/status')}}" class="pl-4"><i class="fas fa-dot-circle"></i> Status</a>
                </li>
                <!-- <li>
                        <a href="{{url('project/overview')}}" class="pl-4"><i class="fas fa-dot-circle"></i> Overview</a>
                    </li> -->
                <li>
                  <a href="{{url('project/collaborators')}}" class="pl-4 "><i class="fas fa-dot-circle"></i> Collabrators</a>
                </li>
                <li>
                  <a href="{{url('project/tasks')}}" class="pl-4"><i class="fas fa-dot-circle"></i> Task</a>
                </li>
                <!-- <li>
                        <a href="{{url('project/documents')}}" class="pl-4"><i class="fas fa-dot-circle"></i> Documents</a>
                    </li> -->

              </ul>
            </li>
            <li class="@if(request()->path() == 'invoices') active @endif">
              <a href="{{url('invoices')}}">
                <img src="https://lancer-app.000webhostapp.com/images/svg/approve-invoice.svg" height="20" width="auto"> <span> Invoice</span>
              </a>
            </li>
            <!-- <li>
                <a href="{{url('contracts')}}">
                    <img src="https://lancer-app.000webhostapp.com/images/svg/policy.svg" height="20" width="auto"> <span> Contract</span>
                </a>
            </li>
            <li>
                <a href="{{url('proposals')}}">
                    <img src="https://lancer-app.000webhostapp.com/images/svg/approval.svg" height="20" width="auto"> <span> Proposals</span>
                </a>
            </li> -->
            <li class="@if(request()->path() == url('/dashboard/profile/settings')) active @endif">
              <a href="{{ url('/dashboard/profile/settings') }}">
                <img src="https://lancer-app.000webhostapp.com/images/svg/approval.svg" height="20" width="auto"> <span> Settings</span>
              </a>
            </li>
          </ul>

        </nav>

        <!-- <img class="logo-img" src="https://res.cloudinary.com/slarin/image/upload/v1570685957/contact-support/lancers_zump2v.svg">
          <table class="nav-table">
            <tr>
              <td><img src="https://res.cloudinary.com/slarin/image/upload/v1570685957/contact-support/home_ytnlm7.svg" class="icon"></td><td class="nav-txt"><a href="#">Dashboard</a></td>
            </tr>
            <tr>
              <td><img src="https://res.cloudinary.com/slarin/image/upload/v1570685955/contact-support/customer_bpnu4k.svg" class="icon"></td><td class="nav-txt"><a href="#">Clients</a></td>
            </tr>
            <tr>
              <td><img src="https://res.cloudinary.com/slarin/image/upload/v1570685955/contact-support/budget_1_bosmd2.svg" class="icon"></td><td class="nav-txt"><a href="#">Estimates</a></td>
            </tr>
            <tr>
              <td><img src="https://res.cloudinary.com/slarin/image/upload/v1570685955/contact-support/Group_khqbxt.svg" class="icon"></td><td class="nav-txt"><a href="#">Projects</a></td>
            </tr>
            <tr>
              <td><img src="https://res.cloudinary.com/slarin/image/upload/v1570685955/contact-support/Group-invoices_i80pqb.svg" class="icon"></td><td class="nav-txt"><a href="#">Invoices</a></td>
            </tr>
            <tr>
              <td><img src="https://res.cloudinary.com/slarin/image/upload/v1570685957/contact-support/policy_jn93r8.svg" class="icon"></td><td class="nav-txt"><a href="#">Contracts</a></td>
            </tr>
            <tr>
              <td><img src="https://res.cloudinary.com/slarin/image/upload/v1570685958/contact-support/approval_ylo1xp.svg" class="icon"></td><td class="nav-txt"><a href="#">Proposals</a></td>
            </tr>
          </table> -->
      </div>
    </div>

    <div class="content">
      <img src="https://res.cloudinary.com/slarin/image/upload/v1570685956/contact-support/Contact_us_1_rm3q98.png" alt="contact help" class="hero-img" width="150" height="100">
      <h4>Read the <br><a href="faq"><br>
          <p>frequently asked questions</p></a><br>or send us a message</h4>
      <br>


      @if ($errors->any())
      <div class="alert alert-danger" style="color:red;max-width: 60%;">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
      <span style='color:green;'> {{empty(Session::get('success')) ? "":Session::get('success')}}</span>

      <form class="contact-form" action="/process_contact_form" method="post">
        @csrf
        <!-- {{ csrf_field() }} -->

        <label for="subject" class="form-label">Subject</label>
        <input name="subject" type="text" class="inpt">

        <label for="message" class="form-label">Message</label>
        <textarea name="contents" rows="15" class="txt-area"></textarea>
        <button class="contact-form-btn">Send</button>
      </form>
    </div>

  </div>

  <script>
    function drop() {
      let x = document.getElementById('dd-menu');
      x.classList.toggle('active');
    }
  </script>
  <!--Start of Tawk.to Script-->
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
</body>
@endsection