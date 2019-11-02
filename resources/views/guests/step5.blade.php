@extends('layouts.app')
<!-- Preview Invoice -->

@section('styles')
<link rel="stylesheet" href="{{asset('css/step5.css')}}"/>
    <style> 
        
    </style>
@endsection


@section('content')
<div class="pageBackground">
    <!-- This is the navbar for small screens -->
    <header class="container-a menuForSmallScreens">
            <div class="box-1" style="max-width: 50px">
                <a class="icon-btn" id="icon-close">
                    <span><i class="icon-btn fa fa-times" aria-hidden="true"></i></span>
                </a>
            </div>
            <div class="box-2" style="max-width: 50px">
                <a class="icon-btn" id="icon-back">
                    <span><i class="icon-btn fa fa-chevron-left" aria-hidden="true"></i></span>
                </a>
            </div>
    
            <div class="box-3">
                Save
            </div>
            <div class="box-4">
                Invoice
            </div>
            <div class="box-5">
                <form method="post" id="form">
                @csrf
                </form>
                <a href="#"><button  onClick="sendInvoice( {{$data['invoice_no']}} )" class="sendInvoice">SEND</button></a>
            </div>
    </header>

    <!-- This is the navbar for large screens -->
    <header class="container-a menuForLargeScreens">
            <!-- <header> -->
            <div class="box-1" style="max-width: 50px">
                <a class="icon-btn" id="icon-close">
                    <span><i class="icon-btn fa fa-times" aria-hidden="true"></i></span>
                </a>
            </div>
            <div class="box-2" style="max-width: 50px">
                <a class="icon-btn" id="icon-back">
                    <span><i class="icon-btn fa fa-chevron-left" aria-hidden="true"></i></span>
                </a>
            </div>
            
            <div class="box-3" style="max-width: 150px">
                Save and Close
            </div>
            <div class="box-4">
                Invoice
            </div>
            <div class="box-5" style="max-width: 150px">
                <a href="#" onClick="sendInvoice( {{$data['invoice_no']}} )"><button class="sendInvoice">SEND INVOICE</button></a>
            </div>
    </header>
    <main>
    <div class=" container mainContent">
            <section>
                <div class="row topMenu">
                    <button type="button" class="btn btn-sm editInvoice "><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;EDIT INVOICE</button>
                    <div class="ml-auto">
                        <a class="invoiceSettings" href=""></a>
                            <p>
                                <i class="fas fa-cog"></i> Invoice Settings
                            </p>
                    </div>
                </div>
            </section>

            <section class="mainContentBelowLogo">
                <section>
                
                <div class="addressAndPayment row">
                    <div class="card addressCard" style="font-weight: normal">
                        <div style="font-weight: bold">{{$data['company']}}</div>
                        {{$data['company_address']}}<br>
                        {{$data['company_country']}}
                    </div>

                    <div class="card payment ml-auto">
                        <div style="font-size: 0.8em; color: #B1B1B1">Amount Due</div>

                        <div class="Amount" style="font-size: 2em; font-weight: bold">{{$data['currency_symbol']}}{{$data['total']}} <span style="font-size: 0.5em">{{$data['currency']}}</span></div>

                        <div>
                            <div class="issueDate float-left">
                                <div style="font-size: 0.8em; color: #B1B1B1">Issued <p style="font-size: 1.2em; color: black">{{$data['issued_date']}}</p></div>
                            </div>

                            <div class="dueDate float-left">
                                <div style="font-size: 0.8em; color: #B1B1B1">Due<p style="font-size: 1.2em; color: black">{{$data['due']}}</p></div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary paymentButton">Pay with Flutterwave</button>
                    </div>
                </div>
                
                </section>

            <section class="invoiceDetails row">
                <div class=" table-card" style="margin-top: 10px">
                    <div class="">
                        Invoice <span style="font-weight: bold; font-size: 0.6em; color: #B1B1B1">No. {{$data['invoice_no']}}</span> <p class="serviceRendered" style="margin-top: 10px">Lancers</p>
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
                                <td style="font-weight:normal">Workmanship</td>
                                <td style="font-weight:normal">1</td>
                                <td style="font-weight:normal">{{$data['currency_symbol']}}{{$data['workmanship']}}</td>
                                <td style="font-weight:normal">{{$data['currency_symbol']}}{{$data['workmanship']}}</td>
                            </tr>
                            <tr scope="row">
                                <td style="font-weight:normal">Equipment</td>
                                <td style="font-weight:normal">1</td>
                                <td style="font-weight:normal">{{$data['currency_symbol']}}{{$data['equipment_cost']}}</td>
                                <td style="font-weight:normal">{{$data['currency_symbol']}}{{$data['equipment_cost']}}</td>
                            </tr>
                            <tr scope="row">
                                <td style="font-weight:normal">Sub Contractor</td>
                                <td style="font-weight:normal">1</td>
                                <td style="font-weight:normal">{{$data['currency_symbol']}}{{$data['sub_contractors_cost']}}</td>
                                <td style="font-weight:normal">{{$data['currency_symbol']}}{{$data['sub_contractors_cost']}}</td>
                            </tr>
                            <tr scope="row">
                                <td></td>
                                <td></td>
                                <td style="font-weight:bold">Subtotal<br>Amount Due
                                </td>
                                <td style="font-weight:normal">{{$data['currency_symbol']}}{{$data['total']}}
                                <br>{{$data['currency_symbol']}}{{$data['total']}}</td>
                            </tr>
                            </tbody>
                        </table>
                        <div style="min-height: 50px"></div>
                    </div>
                    <hr>
                    <span style="font-size: 0.8em;">{{$data['lancer_name']}}</span>
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
    <script>
        function sendInvoice(invoice){
            let form = document.querySelector('#form');
            form.action = "/invoice/send/"+invoice;
            form.submit();
        }
    </script>
@endsection