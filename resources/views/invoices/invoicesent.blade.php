<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Lancers Invoice send</title>

    <!-- Bootstrap core JavaScript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />

    <!-- Google imported font for pacifico & open sans -->
    <link href="https://fonts.googleapis.com/css?family=Pacifico&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <!-- Font awesome icon -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles/collaborator.css">


    <!-- <div class="d-flex" id="wrapper">
        
        <div class="bg-dark border-right bar" id="sidebar-wrapper">
            <div class="sidebar-heading">Lan<span style="color:#00F9FF">c</span>ers</div>
            <ul class="sideMenu">
                <li><a href="#" class="list-group-item list-group-item-action bg-light"> <i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
                <li><a href="#" class="list-group-item list-group-item-action bg-light"> <i class="fa fa-users" aria-hidden="true"> </i> Clients</a></li>
                <li><a href="#" class="list-group-item list-group-item-action bg-light"> <i class="fa fa-calculator" aria-hidden="true"> </i> Estimates</a></li>

                <li>
                    <a href="#subMenu" data-toggle="collapse" aria-expanded="false" class="list-group-item list-group-item-action bg-light dropdown-toggle"><i class="fa fa-lightbulb-o" aria-hidden="true"></i> Projects</a>
                    <ul class="collapse list-unstyled" id="subMenu">
                        <li>
                            <a class="dropdown-item" style="color: azure;" href="#">Status</a>
                        </li>
                        <li>
                            <a class="dropdown-item" style="color: azure;" href="#">Overview</a>
                        </li>
                        <li>
                            <a class="dropdown-item" style="color: azure;" href="#">Collaborators</a>
                        </li>
                        <li>
                            <a class="dropdown-item" style="color: azure;" href="#">Task</a>
                        </li>
                        <li>
                            <a class="dropdown-item" style="color: azure;" href="#">Documents</a>
                        </li>
                    </ul>
                </li>

                <li><a href="#invoice-toggle" class="list-group-item list-group-item-action bg-light"><i class="fa fa-file-text-o" aria-hidden="true"></i></i> Invoice</a></li>
                <li><a href="#" class="list-group-item list-group-item-action bg-light"><i class="fa fa-handshake-o"></i> Contract</a></li>
                <li><a href="#" class="list-group-item list-group-item-action bg-light"> <i class="fa fa-area-chart" aria-hidden="true"></i> Proposals</a></li>
            </ul>
        </div>-->
    <!-- <div id="page-content-wrapper" class="mb-5">
     <nav class="navbar navbar-expand-lg navbar-light navbar-fixed-top border-bottom">
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">

             <div class="searchDiv">
                 <i class="fa fa-search"></i>
                 <input class="form-control" type="search" placeholder="Search">
             </div>

             <ul class="nav navbar-nav ml-auto mt-2 mt-lg-0">
                 <li class="nav-item nav br"><a class="nav-link" href="#"> <i class="fa fa-comments nav-fa" aria-hidden="true"></i></a></li>
                 <li class="nav-item nav br"><img class="nav-link img-responsive" src="https://res.cloudinary.com/laplace/image/upload/v1570738202/s1zgdvui4w4h6dnfeyk9.svg"></li>
                 <li class="nav-item nav br"><a class="nav-link" href="#"> <i class="fa fa-bell nav-fa" aria-hidden="true"></i></a></li>
                 <li class="nav-item nav"><a class="nav-link" href="#"><i class="circle"><strong style="color: #000; font-style: normal;">AU</strong></i></a></li>
             </ul>
         </div>
     </nav>-->







    <style>
        @import url('https://fonts.googleapis.com/cle>ss?family=Ubuntu&display=swap');

        * {
            font-family: 'Ubuntu', sans-serif;
            font-weight: bold;
            margin: 0;
        }

        body {
            background-color: #F2F3F3;
            ;
        }

        .container-a {
            display: flex;
            background: white;
            font-size: 0.8em !important;
            max-height: 60px;
        }

        .container-a>div {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
            font-size: 1rem;
        }

        .box-1 {
            color: #C4C4C4;
            flex-flow: column wrap;
            flex-grow: 1;
            color: #C4C4C4;
        }

        .container-a>.box-2 {
            flex: 1;
            color: #C4C4C4;

        }

        .container-a>.box-3 {
            flex: 2;
            cursor: pointer;

        }

        .container-a>.box-4 {
            flex: 4;

        }

        .box-1:hover,
        .box-2:hover,
        .box-3:hover {
            background: #0ABAB5;
            transition: all 0.3s ease 0s;
            border-color: #0ABAB5;
            color: white;
            cursor: pointer;

        }

        .container-a>.box-5 {
            flex: 2;
            background: #0ABAB5;
            cursor: pointer;
            border: none;
        }

        .container-a>.box-5:hover {
            background: rgb(5, 128, 123);
            transition: all 0.3s ease 0s;
        }

        .sendInvoice {
            color: white;
            border: none;
            background: none;
            height: 100%;
            cursor: pointer;
        }

        img:hover {
            color: white;
        }

        .card {
            border: 0px
        }

        .mainContent {
            margin-left: 20px;
            margin-right: 20px;
            margin: auto;
            margin-top: 100px;
            max-width: 550px;
            position: relative;
            background: #FFFFFF;
            /* Secondary blue */

            border: 5px solid #0ABAB5;
            box-sizing: border-box;
        }

        .mainContentBelowLogo {
            margin-left: 20px;
            margin-right: 20px;
            margin-top: 200px;
        }

        .topMenu {
            margin-left: auto;
            margin-right: auto;
            margin-top: 15px
        }

        .editInvoice {
            background-color: #00FFA3;
            color: #333333;
            font-weight: 700;
            border: none;
            border-radius: 0%;
            font-size: 0.8rem;
            padding-top: 10px;
            padding-bottom: 10px;
            max-width: 200px;
        }

        .editInvoice:hover {
            background-color: #03E493;
            color: #333333;
        }

        .invoiceSettings {
            color: #B1B1B1;
            font-size: 0.8em;
        }

        .invoiceSettings p {
            margin-top: auto;
            margin-bottom: auto;
        }

        .addressAndPayment {
            margin: auto;
            font-size: 0.8em;
            margin-top: 30px;
        }

        .address {
            width: 99px;
            height: 77px;
            margin: auto;

        }

        .payment {
            max-width: 300px;
            font-weight: bold;
        }

        .issueDate {
            margin-right: 30px;
        }

        .paymentButton {
            font-style: normal;
            font-weight: bold;
            font-size: 1em;
            border: 0px;
            border-radius: 0px;
            line-height: 32px;
            text-align: center;
            background-color: #0ABAB5;
            color: #FFFFFF;
            padding: 2px;
        }

        .invoiceDetails {
            margin-left: auto;
            margin-right: auto;
        }


        th,
        td {
            padding-left: 0px !important;
            padding-right: 28px !important;
        }

        .table-card {
            width: 100%;
        }

        .card-body {
            margin: 0px;
            padding: 0px !important;
            width: 100%
        }

        .bottomSpace {
            margin-bottom: 50px;
        }

        .address {
            margin-right: 30px;
        }

        .menuForSmallScreens {
            display: none;
        }

        /* Media Queries to make things look better on mobile devices including switching the navbar to a more mobile friendly version */
        @media only screen and (max-width: 600px) {
            .mainContent {
                margin-top: 50px;
            }

            .addressCard {
                display: none;
            }

            .addressAndPayment.row {
                padding: 0% !important;
            }

            .payment {
                margin-left: auto !important;
                margin-right: auto !important;
                margin-bottom: 20px !important;
                width: 100% !important;
                max-width: 100% !important;

            }

            .menuForLargeScreens {
                display: none;
            }

            .menuForSmallScreens {
                display: flex;
            }
        }
    </style>

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

</head>

<div class="wrapper">
    <!-- Sidebar Holder -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <img src="https://lancer-app.000webhostapp.com/images/svg/Lancers.svg" height="35" width="auto" class="img img-responsive">
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

    <!-- Page Content Holder -->
    <div id="content">
        <nav class="navbar navbar-expand-lg navbar-light shadow-sm">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="navbar-btn">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-align-justify"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <form class="form-inline my-2 my-sm-0 ml-4 ">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text border-right-0 bg-white" id="basic-addon1"><i class="fas fa-search"></i></span>
                            </div>
                            <input class="form-control mr-sm-2 border border-left-0 searchBox" type="text" width:2% placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
                        </div>
                    </form>

                        <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link p-3" href="{{ url('/contact') }}"><img src="https://lancer-app.000webhostapp.com/images/svg/help.svg" height="25" width="auto"> <span class="d-lg-none d-xl-none"> You need help?</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link border-left p-3" href="/notifications"><img src="https://lancer-app.000webhostapp.com/images/svg/alarm-clock.svg" height="25" width="auto"> <span class="d-lg-none d-xl-none"> Reminder</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link border-left p-3" href="/notifications"><img src="https://lancer-app.000webhostapp.com/images/svg/notification.svg" height="25" width="auto"> <span class="d-lg-none d-xl-none"> Notification</span></a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link border-left p-3" href="/dashboard/profile">
                            @if(Auth::user()->profile_picture !== 'user-default.png')
                            <img  src="{{ asset(Auth::user()->profile_picture) }}" style="width: 30px; height: 30px; border-radius: 10%; pointer: finger;" alt="Profile Image">
                            @endif
                            @if(Auth::user()->profile_picture == 'user-default.png')
                            <!--<img  src="{{ asset('images/user-default.jpg') }}" style="width: 30px; height: 30px; border-radius: 10%; pointer: finger;" alt="Profile Image">-->
                            <div name="no-img" style="width: 30px; height: 30px; line-height: 30px; border-radius: 50%; pointer: finger; background-color: #ff9000; color: #fff; text-align: center; vertical-align: middle; " alt="Profile Image">
                                @php
                                    $count = 0;
                                    $name = auth()->user()->name;
                                    $nameArr = explode(' ',$name);
                                    if(strlen($nameArr[0]) > 1){
                                        $initials = strtoupper($nameArr[0][0]).strtolower($nameArr[0][1]);
                                    }
                                    else{
                                        $initials = strtoupper($nameArr[0][0]);
                                    }
                                    echo htmlspecialchars($initials);
                                @endphp
                            </div>
                            @endif
                            </a>
                            <!-- <a class="nav-link border-left p-3" href="/dashboard/profile/settings"><span class="border rounded-circle p-1 font-weight-bold">
                                {{strtoupper(explode(" ", auth()->user()->name)[0][0])}}
                            </span> <span class="d-lg-none d-xl-none"> Hello {{explode(" ", auth()->user()->name)[0]}}</span></a> -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link p-3" href="{{url('/logout')}}" ><i class="fas fa-sign-out-alt"></i> <span class="d-lg-none d-xl-none"> Logout</span></a>
                        </li>
                    </ul>
                </div>

            </div>
        </nav>










        <body class="bodying col-xs-6">

            <body class="bodying col-xs-6">
                <!-- <div class="jumbotron jumbotron-fluid"> -->
                <div class="container mt-20">
                    <i class="fa fa-check-circle fa-2x" aria-hidden="true"></i>
                    <!-- <input id = "tick" type="button" value="✓" /> -->
                    <p><strong>Invoice Sent</strong></p>

                    <p>You would receive a notification once payment has been made</p>

                  
    <div class="side">  
        <a class="invBtn btn btn-success" href="/invoices" style="background-color:#0ABAB5">VIEW INVOICES</a>
    </div>

                </div>



                <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>


                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

                <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>


                <script type="text/javascript">
                    $(document).ready(function() {
                        $('#sidebarCollapse').on('click', function() {
                            $('#sidebar').toggleClass('active');
                            $(this).toggleClass('active');
                        });
                    });

                </script>







                <!-- </div> -->
            </body>


</html>
