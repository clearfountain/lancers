@extends('layouts.app')

@section('title', 'Review Invoice')

@section('content')

{{-- {{dd($invoice)}} --}}

      <div class="pageBackground">
        <!-- This is the navbar for small screens -->
        <header class="container-a menuForSmallScreens">
            <div class="box-1 save-close" style="max-width: 50px">
                <i class="fa fa-times" aria-hidden="true"></i>
            </div>
            <div class="box-2 go-back" style="max-width: 50px">
                <i class="fa fa-chevron-left" aria-hidden="true"></i>
            </div>

            <div class="box-3 save-close">
                Save
            </div>
            <div class="box-4">
                Invoice
            </div>
            <div class="box-5">
                <form method="POST" action="/invoice/send">
                    @csrf
                    <input type="text" style="display: none;" name="invoice" value="{{$invoice->id}}">
                    <button type="submit" class="sendInvoice">SEND</button>
                </form>
            </div>
        </header>

        <!-- This is the navbar for large screens -->
        <header class="container-a menuForLargeScreens">
            <!-- <header> -->
            <div class="box-1 save-close" style="max-width: 50px">
                <i class="fa fa-times" aria-hidden="true"></i>
            </div>
            <div class="box-2 go-back" style="max-width: 50px">
                <i class="fa fa-chevron-left" aria-hidden="true"></i>
            </div>

            <div class="box-3 save-close" style="max-width: 150px">
                Save and Close
            </div>
            <div class="box-4">
                Invoice
            </div>
            <div class="box-5 contentBgColor" style="max-width: 150px">
            <form method="POST" action="/invoice/send" id="finalInvoiceForm" enctype="multipart/form-data">
                    @csrf
                    <input type="text" id="invoiceCheckerInput" style="display: none;" name="invoiceChecker" value="sendInvoice">
                    <input type="text" style="display: none;" name="invoice" value="{{$invoice->id}}">
                    <input id="invoice_picture" name="profileimage" type="file" style="display: none;"  onchange="invoiceImage(this);" />
                    <input type="hidden" id="invoiceClr" name="invoiceClr" value="#0ABAB5">
                    <button type="submit" class="sendInvoice">SEND INVOICE</button>
                </form>
            </div>
        </header>
        <main>
            <div class=" container mainContent">
{{--                 <section>
                    <div class="row topMenu">
                        <button type="button" class="btn btn-sm editInvoice "><i class="fa fa-pencil"
                                aria-hidden="true"></i>&nbsp;EDIT INVOICE</button>
                        <div class="ml-auto">
                            <a class="invoiceSettings" href=""></a>
                            <p>
                                <i class="fas fa-cog"></i> Invoice Settings
                            </p>
                        </div>
                    </div>
                </section> --}}

                @if(session()->has('message.alert'))
                <div class="text-center">
                    <button class=" alert alert-{{ session('message.alert') }}">
                        {!! session('message.content') !!}
                    </button>
                </div>
                @endif
                <section class="mainContentBelowLogo">
                    <section>
                        <div class="invoice-logo">
                        <i>Click Image to upload client logo</i>
                        @if(null !== $invoice->estimate->project->client->profile_picture)
                        <img id="invoice_image_selecter" src="{{ asset($invoice->estimate->project->client->profile_picture) }}" style="width: 100px; height: 100px; border-radius: 2%; pointer: finger;" alt="Client Image">
                        @endif
                        @if(null == $invoice->estimate->project->client->profile_picture)
                        <img id="invoice_image_selecter" src="{{ asset('images/ClientImages/user-default.jpg') }}" style="width: 100px; height: 100px; border-radius: 2%; pointer: finger;" alt="Client Image">
                        @endif
                        </div>

<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#settingsModal" style="background-color: #00FF00; border-color: #00FF00">Edit Color</button>

<div class="modal fade" id="settingsModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-body {{--settings-modal--}}">
              <form class="settings-form" action="settings" method="POST" action="#">
                    <div class="modal-header">
                        <h4 class="modal-title">Branding Options</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="brand-color">
                            <div class="text-bc">Select Brand Color</div>
                            <div class="colors-box">
                                <div class="color-text" id="color-value">
                                    <!--#0ABAB5-->
                                    <select id="clrs">
                                        <option class="clrOption" value="#0ABAB5" selected>Default</option>
                                        <option class="clrOption" value="#000000">Black</option>
                                        <option class="clrOption" value="#FF0000">Red</option>
                                        <option class="clrOption" value="#013220">Green</option>
                                        <option class="clrOption" value="#0000FF">Blue</option>
                                        <option class="clrOption" value="#FFFF00">Yellow</option>
                                    </select>
                                </div> <input class="colors modal-input" type="color" name="favcolor" id="clrBox" value="#0ABAB5">
                            </div>
                        </div>
                        <div class="samples">
                            <p class="title-text dynamicColor">Sample Title</p>
                            <button disabled class="button_1 dynamicBgColor" style="margin-right:5%;">Sample Button</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="button_2 dynamicBgColor" id="saveClrBtn" data-dismiss="modal">SAVE SETTINGS</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

                        <div class="addressAndPayment row">
                            <div class="card addressCard" style="font-weight: normal">
                                <div style="font-weight: bold">{{$invoice->estimate->project->client->name}}</div>
                                {{$invoice->estimate->project->client->city}}, {{$invoice->estimate->project->client->state->name}}<br>
                               {{$invoice->estimate->project->client->country->name}}
                            </div>

                            <div class="card payment ml-auto">
                                <div style="font-size: 0.8em; color: #B1B1B1">Amount Due</div>

                                <div class="Amount" style="font-size: 2em; font-weight: bold">₦{{number_format((float)$invoice->amount, 2)}}<span
                                        style="font-size: 0.5em">NGN</span></div>

                                <div>
                                    <div class="issueDate float-left">
                                        <div style="font-size: 0.8em; color: #B1B1B1">Issued <p
                                                style="font-size: 1.2em; color: black">{{strtotime($invoice->created_at)}}</p>
                                        </div>
                                    </div>

                                    <div class="dueDate float-left">
                                        <div style="font-size: 0.8em; color: #B1B1B1">Due<p
                                                style="font-size: 1.2em; color: black">Upon completion</p>
                                        </div>
                                    </div>
                                </div>

                                {{--<button type="button" class="btn btn-primary paymentButton contentBgColor" style="background: #0ABAB5;" disabled>Pay with
                                    Paystack</button>--}}
                                <button type="button" class="btn btn-primary paymentButton" style="background: #0ABAB5;" disabled>Pay with
                                    Flutterwave</button>
                            </div>
                        </div>

                    </section>

                    <section class="invoiceDetails row">
                        <div class=" table-card" style="margin-top: 10px">
                            <div class="">
                                Invoice <span style="font-weight: bold; font-size: 0.6em; color: #B1B1B1">No. {{strtotime($invoice->created_at)}}</span>
                                <p class="serviceRendered" style="margin-top: 10px">{{$invoice->estimate->project->title}}</p>
                            </div>
                            <div class="tableSection" style="font-size: 0.8em; width: 100%; overflow-x: scroll">
                                <table class="table">
                                    <thead>
                                        <tr style="border-top-style: hidden">
                                            <th style="width: 70%">Description</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr scope="row">
                                            <td style="font-weight:normal">Man Hours</td>
                                            <td style="font-weight:normal">{{$invoice->estimate->time}}</td>
                                            <td style="font-weight:normal">₦{{number_format((float)$invoice->estimate->price_per_hour, 2)}}</td>
                                            <td style="font-weight:normal">₦{{number_format((float)($invoice->estimate->price_per_hour * $invoice->estimate->time), 2)}}</td>
                                        </tr>
                                        @if($invoice->estimate->equipment_cost !== null)
                                            <tr scope="row">
                                                <td style="font-weight:normal">Equipment cost</td>
                                                <td style="font-weight:normal">1</td>
                                                <td style="font-weight:normal">₦{{number_format((float)$invoice->estimate->equipment_cost, 2)}}</td>
                                                <td style="font-weight:normal">₦{{number_format((float)$invoice->estimate->equipment_cost, 2)}}</td>
                                            </tr>
                                        @endif

                                        @if($invoice->estimate->sub_contractors_cost !== null)
                                            <tr scope="row">
                                                <td style="font-weight:normal; text-transform: capitalize;" >{{$invoice->estimate->sub_contractors}}</td>
                                                <td style="font-weight:normal">1</td>
                                                <td style="font-weight:normal">₦{{number_format((float)$invoice->estimate->sub_contractors_cost, 2)}}</td>
                                                <td style="font-weight:normal">₦{{number_format((float)$invoice->estimate->sub_contractors_cost, 2)}}</td>
                                            </tr>
                                        @endif

                                        <tr scope="row">
                                            <td></td>
                                            <td></td>
                                            <td style="font-weight:bold">Total
                                            </td>
                                            <td style="font-weight:normal">₦{{number_format((float)$invoice->amount, 2)}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div style="min-height: 50px"></div>
                            </div>
                            <hr>
                            <span style="font-size: 0.8em;">{{auth()->user()->name}}</span>
                            <div style="margin-bottom: 40px"></div>
                        </div>
                    </section>

                    <section class="footer"></section>
                </section>
            </div>
        </main>

        <footer>
            <div class="bottomSpace"></div>
        </footer>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
         $(".save-close").click(() => {
            //change checker value to saveInvoice
            $("#invoiceCheckerInput").val("saveInvoice");

            $("#finalInvoiceForm").submit();

        });

        $(".sendInvoice").click((e) => {
            e.preventDefault();
            //change checker value to sendInvoice
        $("#invoiceCheckerInput").val("sendInvoice");

           $("#finalInvoiceForm").submit();

        });

        $(".go-back").click(() => {
            window.history.back();
        });

        //jquery code for handling client image upload
        $("#invoice_image_selecter").on("click", function() {
        $("#invoice_picture").trigger("click");
      });



      function invoiceImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#invoice_image_selecter')
                    .attr('src', e.target.result)
                    .width(100)
                    .height(100);
            };

            reader.readAsDataURL(input.files[0]);
        }

    }

    $("#clrs").on("change", function() {
        var color = $(this).val();
        $("#clrBox").val(color);
        $(".dynamicBgColor").css("background-color", color);
        $(".dynamicColor").css("color", color);

    });

    $("#saveClrBtn").on("click", function() {
        var color = $("#clrs").val();
        $(".contentBgColor").css("background-color", color);
        $(".mainContent").css("border-color", color);
        $("#invoiceClr").val(color);
    });
    </script>
@endsection

@section('styles')
    <style>
        @import url('https://fonts.googleapis.com/css?family=Ubuntu&display=swap');
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
            margin-top: 30px;
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
        .add-logo{
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: dashed 2px #ccc;
            cursor: pointer;
        }
        .logo-text{
            display: inline-block;
            padding: 45px;
        }
        .invoice-logo{
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        #logo_image_file{
            display: none;
        }
        .logo-image{
            width: 150px;
            height: 150px;
            border-radius: 10px;
            overflow: hidden;
        }

        .show-logo{
            display: none;
            flex-direction: column;
            align-items: center;
        }
        .logo-image img{
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        #save-logo{
            margin: 7px 0;
            padding: 3px 10px;
            border-radius: 3px;
        }
        .change-logo{
            font-size: 14px;
            cursor: pointer;
        }

        /* Modal's style */
        .modal-body {
            font-family: 'Ubuntu', sans-serif;
            font-style: 20px;
            line-height: 1.5;
            font-weight: bold;
            width: 100%;
            height: 100%;
        }

        .settings-modal {
            /*display: none;*/
            position: fixed;
            z-index: 2;
            left: 0;
            top: 0;
            height: 50%;
            width: 50%;
            overflow: auto;
            background: #ccc;
           /* background: #F2F3F3;*/
            background-size: 100%;
        }



        .settings-form{
            background: #ffffff;
            width: 100%;
            {{--margin: 40px auto; --}}
            height: auto;
            overflow: auto;
            border-top: 5px solid #0ABAB5;
            padding: 38px 50px 86px 50px; 
        }

        .closebtn {
            color: #ccc;
            float: right;
            font-size: 30px;
        }

        .closebtn:hover,
        .closebtn:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .upload-area {
            width: 100%;
            height: 106px;
            border: 1px dashed #ccc;
        }

        .text-grey {
            color: #ccc;
            text-align: center;
            padding: 5%;
            font-weight: normal;
            clear: both;

        }

        .brand-color {
            display: grid;
            grid-template-columns: 1fr 1fr;
            margin-top: 40px;
        }

        .text-bc {
            font-size: 1.5em;
            font-weight: 300;
        }

        .colors-box {
            background-color: white;
            width: auto;
            height: 35px;
            padding: 0;
            margin-bottom: 40px;
            display: flex;
            flex-direction: row-reverse;

        }

        .colors {
            background-color: #ffffff;
            height: 100%;
            width: 30px;
            border: none;
            padding: 0;
            margin: 0;
            float: left;
            /*offset: none;*/
            outline: none;
        }

        .color-text {
            border: 0px solid red;
            border: 1px solid #ccc;
            font-family: Ubuntu;
            font-style: normal;
            font-weight: normal;
            font-size: 16px;
            line-height: 21px;
            float: left;
            margin-top: 4px;
            margin-left: -3px;
            padding: 0.2rem;
            height: 27px;
        }

        .samples {
            display: flex;
            background-color: #F7F6F6;
            margin: auto;
            width: 100%;
            height: 154px;
        }


        .btn-text {
            background-color: #0ABAB5 !important;
            color: #ffffff;
            font-size: 20px;
            width: 50%;
            margin-right: 10%;
            margin-top: 9%;
            height: 50px;
            text-align: center;
        }

        .title-text {
            color: #0ABAB5;
            font-size: 20px;
            margin: 60px 55px;
            width: 50%;
        }

        .save-set {
            background-color: #0ABAB5;
            text-align: center;
            padding-top: 2%;
            padding-bottom: 2%;
            font-size: 24px;
            color: #ffffff;
        }

        .button_1 {
            width: 30%;
            height: 50%;
            background-color: #0ABAB5;
            color: #ffffff;
            font-size: 24px;
            margin-top: 55px;
            border: none;
        }

        .button_2 {
            width: 100%;
            height: 50px;
            background-color: #0ABAB5;
            color: #ffffff;
            border: none;
            font-size: 24px;
            font-weight: bold;
            margin-top: 15px;
        }

        .button_1:hover {
            background-color: rgb(15, 207, 201);
            transition-delay: .3s;
            transition-timing-function: linear;
            transition-delay: .1s;
        }

        .button_2:hover {
            background-color: rgb(15, 207, 201);
            transition-delay: .3s;
            transition-timing-function: linear;
            transition-delay: .1s;
        }

        @media screen and (max-width:1125px) {
            .button_1 {
                font-size: 20px;
            }
        }

        @media screen and (max-width:980px) {
            .button_1 {
                font-size: 15px;
                font-weight: bold;
            }

            .title-text {
                font-size: 20px;
            }
        }

        @media screen and (max-width:900px) {
            .button_1 {
                font-size: 15px;
                font-weight: bold;
            }

            .title-text {
                font-size: 20px;
            }

            .samples {
                height: 130px;
            }
        }

        @media screen and (max-width:810px) {
            .button_1 {
                font-size: 10px;
                font-weight: normal;
                width: 135px;
                height: 50%;
                {{--margin-right: 40px;--}}
            }

            .sample {
                height: 100px;
            }

            .title-text {
                font-size: 15px;
                margin-left: 20px;
                margin-top: 60px;
            }
        }

        @media screen and (max-width:630px) {
            .title-text {
                width: 160px;
            }
        }

        @media screen and (max-width:430px) {
            .modal-body {
                font-size: 15px;
            }

            .title-text {
                width: 160px;
            }

            .samples {
                height: 100px;
            }

            .button_2 {
                height: 50px;
                font-size: 12px;
            }

            .colors-box {
                width: 100px;
                height: 22px;
                margin-left: -10%;
            }

            .colors {
                min-height: 22px;
                width: 30px;
            }

            .color-text {
                font-size: 12px;
                width: 100px;
                margin-top: 0%;
            }
        }

        @media only screen and (max-width: 431px) {
            .modal-body{
                margin-left: 0 !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            .upload-area {
                font-size: 1px larger;
            }

            .brand-color {
                font-weight: normal;
            }

            .text-bc {
                width: 60px;
                font-size: 11px;
                text-align: center;
                margin-right: 40px;
            }

            .modal-input {
                margin-right: 270px;
            }

            .modal-content {
                {{-- padding: 36px 60px 70px 60px;--}}
                width: 100%;
            }

            .button_1 {
                margin-right: 15px;
                margin-top: 30px;
            }

            .button_2 {
                font-size: 12px;
            }

            .title-text {
                font-size: 12px;
                margin-top: 30px;
                margin-left: 5px;
                margin-bottom: 80px;
            }

            .colors-box {
                width: 100px;
                height: 22px;
                margin-right: 80% !important;
            }

            .colors {
                min-height: 22px;
                width: 20px;
            }

            .color-text {
                font-size: 12px;
                width: 100px;
            }
        }


        {{--@media only screen and (max-width: 360px) {
            .upload-area {
                font-size: 1px larger;
            }

            .brand-color {
                font-weight: normal;
            }

            .text-bc {
                font-size: 11px;
                text-align: center;
                margin-right: 40px;
            }

            .modal-input {
                margin-left: 10px;
            }

            .modal-content { --}}
                {{--padding: 36px 60px 70px 60px;--}}
                {{--    width: 80%;
            }

            .button_1 {
                margin-right: 15px;
                margin-top: 30px;
            }

            .button_2 {
                font-size: 12px;
            }

            .title-text {
                font-size: 12px;
                margin-top: 30px;
                margin-left: 5px;
                margin-bottom: 80px;
            }

            .colors-box {
                width: 100px;
                height: 22px;
            }

            .colors {
                min-height: 22px;
                width: 30px;
            }

            .color-text {
                font-size: 12px;
                width: 100px;
            }

            @media only screen and (max-width: 320px) {
                .upload-area {
                font-size: 1px larger;
            }
            .settings-form{
                width: 90%;--}}
                {{--padding: 30px 30px 78px 30px;--}}
            }
            {{--.brand-color {
                font-weight: normal;

            }

            .text-bc {
                font-size: 10px;
                text-align: center;
                margin-right: 40px;
            }

            .modal-input {
                margin-left: 8px;
            }

                .modal-content { --}}
                {{--padding: 30px 54px 54px 54px;--}}
                {{--width: 80%;
            }

            .button_1 {
                margin-right: 15px;
                margin-top: 30px;
            }

            .button_2 {
                font-size: 12px;
            }

            .title-text {
                font-size: 12px;
                margin-top: 30px;
                margin-left: 5px;
                margin-bottom: 80px;
            }

            .colors-box {
                width: 75px;
                height: 22px;
            }

            .colors {

                height: 34px;
                width: 30%;
                margin-right:;
                margin-top:-4px ;
                border:none;
            }
            .text-bc{
                font-size: 13px;
            }
            .color-text {
                font-size: 14px;
                width: 100px;
                margin-right: -40px;
            }

            select.colors-dropdown option {
                color: red;
                background-color: green;
                    }--}}
        }

    </style>
@endsection
