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

    <div class="main-cont">
      <div class="header">
        <div class="mobile-nav-btn" onclick="bars()" id="nav-btn">
          <span class="nav-span"></span>
          <span class="nav-span"></span>
          <span class="nav-span"></span>
        </div>
        <a href="#"><h4 class="header-nav-item header-nav-item-left">Project Info</h4></a>
        <a href="#"><h4 class="header-nav-item">Documents</h4></a>
      </div>

      <div class="content">

        <div class="lanclient-buttons">
          <div class="left">
            <button type="button">Print</button> <button type="button">Download as PDF</button>
          </div>
            <div class="right">
            <a href="/payment/invoice/{{strtotime($invoice->created_at)}}" class="btn btn-secondary" type="button">Make Payment</a>
          </div>
        </div>

        <div class="invoice-cont">
          <div class="lanclient-invoice-logo">
            <div class="right-invy">
              <h3 class="invoice-banner-txt">Invoice</h3>
              <p><strong>Project:&nbsp;</strong> {{$invoice->title}}</p>
              <p><strong>Lancer:&nbsp;</strong> {{auth()->user()->name}}</p>
              <p><strong>Email:&nbsp;</strong> {{auth()->user()->email}}</p>
              {{-- <p><strong>Address:&nbsp;</strong>Accra, Ghana</p> --}}
            </div>
            <div class="left-invy-logo">
              <img src="https://res.cloudinary.com/abisalde/image/upload/v1570566026/My_Logo_-_Black.png" alt="Lancer-Logo">
            </div>
          </div>

          <div class="lanclient-billing">
              <div> <p class="billing-clhead">Bill to</p>
                     <div class="bills-descrip"> <p class="bills-description">{{$invoice->estimate->project->client->name}}</p> <p class="bills-description">{{$invoice->estimate->project->client->email}}</p>
                             <p>{{$invoice->estimate->project->client->state->name}},  {{$invoice->estimate->project->client->country->name}}</p>
                     </div>
              </div>
                        <div>
                              <div class="top-mid-bill-details"> <p class="billing-clhead">Issue Date</p>
                               <p class="bills-description">{{strtotime($invoice->issue_date ?? $invoice->created_at)}}</p>
                              </div>
                                     <div class="bottom-mid-bill-details">
                               <p class="billing-clhead">Due Date</p>
                               <p class="bills-description">Upon completion</p>
                                    </div>
                          </div>

             <div class="last-child-billing">
                     <div class="top-last-bill-details"> <p class="billing-clhead">Hourly Rate</p> <p class="bills-description" id = "hourly-rateN">N/A</p>
                     </div>
                          <div class="bottom-last-bill-details"> <p class="billing-clhead">Amount Due</p> <p class="bills-description">NGN {{number_format($invoice->amount)}}</p>
                           </div>
            </div>
          </div>

          <section class="billing-data-table">
            <table>
              <thead class="bg-primary">
                <tr>
                  <th class="remove-borders">Description</th>
                  <th class="remove-borders">Quantity</th>
                  <th class="remove-borders">Rate</th>
                  <th class="remove-borders">Amount</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Man Hours</td>
                  <td>{{$invoice->time}}</td>
                  <td>NGN{{number_format((float)$invoice->estimate->price_per_hour, 2)}}</td>
                  <td>NGN{{number_format((float)($invoice->estimate->price_per_hour * $invoice->estimate->time), 2)}}</td>
                </tr>
                <tr>
                  <td>Equipment Cost</td>
                  <td>1</td>
                  <td>NGN{{number_format((float)$invoice->estimate->equipment_cost, 2)}}</td>
                  <td>NGN{{number_format((float)$invoice->estimate->equipment_cost, 2)}}</td>
                </tr>
                <tr>
                  <td>{{$invoice->estimate->sub_contractors}}</td>
                  <td>1</td>
                  <td>NGN{{number_format((float)$invoice->estimate->sub_contractors_cost, 2)}}</td> 
                  <td>NGN{{number_format((float)$invoice->estimate->sub_contractors_cost, 2)}}</td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="2" class= "no-border-table"></td>
                  <td class= "no-border-table" >Total</td>
                  <td class= "no-border-table" >NGN {{number_format((float)$invoice->amount, 2)}}</td>
                </tr>
                <tr>
                  <td colspan="2" class= "no-border-table"></td>
                  <td class ="light-head dbl-border">Discount</td>
                  <td class = "dbl-border" >N/A</td> </tr>
                <tr>
                  <td colspan="2" class= "no-border-table"></td>
                  <td class= "no-border-table">Amount Due</td>
                  <td class= "no-border-table">NGN{{number_format((float)$invoice->amount, 2)}}</td>
                </tr>
              </tfoot>
            </table>

              
          </section>

        </div>
      </div>
        @endsection