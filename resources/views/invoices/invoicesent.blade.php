@extends('layouts.auth')





@section('main-content')
                 <style>
     .create-estimate {
            font-family: Ubuntu;
            width: 13rem;
            height: 3.5rem;
            background: #0ABAB5;
            color: white;
            border: none;
            font-size: 20px;
            text-align: center;
            margin-left: 15px;
            margin-top: 40px;
            margin-bottom: 20px;
        }
        .content h3 {
            font-family: Ubuntu;
            font-style: normal;
            font-weight: 500;
            font-size: 22px;
            line-height: 32px;
            color: #262626;
            margin-left: 15px;
            margin-bottom: 20px;
        }
        .content p {
            font-weight: normal;
            font-size: 14px;
            line-height: 20px;
            color: #091429;
            margin-left: 15px;
        }

    @media(max-width: 850px) {
        main {
                margin-left: 0 !important;
                margin-top: 2.5rem;
            }
        }

     @media(max-width: 750px) {
            .main-container {
                width: auto !important;
            }
     }


 </style>



<!-- <div class="jumbotron jumbotron-fluid"> -->
<div class="clearfix"></div>
<br/><br/><br/><br/>
                <div class="container mt-20 text-center col offset-md-3">
                    <i class="fa fa-check-circle fa-2x" aria-hidden="true" style="color:#0ABAB5"></i>
                    <!-- <input id = "tick" type="button" value="✓" /> -->
                    <p><strong>Invoice Sent</strong></p>

                    <p>You would receive a notification once payment has been made</p>

                  
    <div class="side">  
        <a class="invBtn btn btn-success" href="/invoices" style="background-color:#0ABAB5">VIEW INVOICES</a>
    </div>

                </div>


@endsection