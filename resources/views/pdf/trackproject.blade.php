@extends('layouts.app')

@section('styles')
  <style> 
      
      #page-container {
        position: relative;
        min-height: 100vh;
      }

      #content-wrap {
        padding-bottom: 2.5rem;    /* Footer height */
      }

      #footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 2.5rem;            /* Footer height */
      }
      
      
      .top-left {left: -20px; top: 50px; position: fixed; font-size: 15px !important;}
      .top-right {right: 0px; left: 550px; top:-10px; position: fixed;}
      
      .bill-left {right: 0px; left: 0px; top: 250px; position: fixed; width: 30%; overflow-wrap: break-word;}
      .bill-mid {right: 0px; left: 300px; top: 240px; position: fixed; font-size: 15px !important; width: 30%; overflow-wrap: break-word;}
      .bill-right {right: 0px; left: 400px; top: 240px; position: fixed; width: 30%; overflow-wrap: break-word;}
      
      a {
          text-decoration : none !important;
      }
      
      .main-color {
          color: #0ABAB5;
      }
      
      .main-color:hover {
          text-decoration:none;
          color: #FFF;
      }

    .content {
      grid-column: 2 / -1;
      margin-left: 65px;
    }
    .lanclient-buttons {
      margin-top: 2em;
      display: flex;
      justify-content: space-between;
    }
    .lanclient-buttons>.left>button {
      border: 2px solid #0ABAB5; border-radius: 5px; padding: 10px; margin-right: 1.5em; background: #fff; font-size: 15px; font-weight: bold; color: #0ABAB5;
    }
    .lanclient-buttons>.left>button:hover {
      background-color: #000000;
      color: #ffffff;
      cursor: pointer;
    }
    .lanclient-buttons>.right>button {
    background-color: #0ABAB5; border: thin; color: #fff; font-family: 'Ubuntu', 'san-serif'; padding: 10px; border-radius: 5px; font-size: 13px; font-weight: bold; margin-right: 2em; width: 170px; border: 2px solid #0ABAB5;
    }
    .lanclient-buttons>.right>button:hover {
      background-color: #0ABAB5;
      border-color: #0ABAB5;
      cursor: pointer;
    }
    .invoice-cont {
      border: 1px solid #ffffff;
      border-radius: 3px;
      box-shadow: 0px 4px 50px rgba(0, 0, 0, 0.03);
      margin: 35px 27px 20px 0;
      padding: 20px;
    }
    .invoice-banner-txt {
      color: #546067;
      right : 100px !important;
      left: -20px !important;
        top: -10px !important;
        bottom: 10px !important;
        position: fixed !important;
        font-size: 25px !important;
    }

    .lanclient-invoice-logo { margin-top: 0; display: flex; justify-content: space-between;
    }
    .right-invy>p { margin-top: 1em; padding: 2px 0;
    }
    .lanclient-invoice-logo>.left-invy-logo { margin-right: 1.5em;
    }

    img.left-invy-logo { height: 50px; }

    .lanclient-billing { margin: 20px 0 0 10px; display: flex; justify-content: space-between;
    }

    p.billing-clhead { color: #a6a6a6 !important; font-size: 15px !important;
    }

    div.bills-descrip { color: #000; margin-top: 10px;
    }

    div.bills-descrip>p { padding-bottom: 7px; font-size: 15px;
    }

    div.last-child-billing { margin-right: 2em; text-align: right;
    }

    .top-mid-bill-details>p:nth-child(2), .top-last-bill-details>p:nth-child(2) { padding-top: 10px; color: #000; font-size: 15px;
    }

    .bottom-mid-bill-details, .bottom-last-bill-details { margin-top: 2.0em;
    }

    .bottom-mid-bill-details>p:nth-child(2), .bottom-last-bill-details>p:nth-child(2) { color: #000; padding-top: 10px; font-size: 15px;
    }

    .bottom-last-bill-details>p:nth-child(2) { font-weight: 600;
    }

    section { top: 500px !important; bottom: -500px !important; left:0px !important; right:0px !important;
        position: absolute !important;
        bottom: 0 !important;
        width: 100% !important;
        height: 2.5rem !important; 
    }

    .billing-data-table>table { width: 100%; margin: auto; border-collapse: separate; border-spacing: 0;
    }

    .invoice-cont td {
      text-align: center;
      padding: 15px;
      font-weight: 500;
      font-style: normal;
      opacity: 0.8;
      font-size: 15px;
      border-bottom: 1px solid #a6a6a6;
      font-family: 'Ubuntu', sans-serif;
    }

    tfoot>tr { text-align: left;
    }
      
    tbody {
        text-align: left;
    }

    thead { background-color: #0ABAB5; color: #fff; font-size: 14px; text-align : left;
    }
      
      .bg-primary{
          background-color : #0ABAB5 !important;
      }

    th:nth-child(1), td:nth-child(1) { text-align: start; padding: 10px;
    }

    #hourly-rateN { text-align: right;
    }

    .light-head { color: #a6a6a6;
    }

    td.no-border-table { border-bottom: none;
    }

    .dbl-border { border-bottom: 2px solid #000;
    }

    .Move{  padding-left: 230px;
    }

    /*media queries for responsiveness*/
    @media(min-width: 1400px){
      .sidebar-content {
        margin-left: 60px;
      }
    }
    @media(max-width: 800px){
      .sidebar-content {
        margin-left: 10px;
      }
    }
    @media(max-width: 500px){
      .main-cont {
        grid-template-columns: 1fr;
      }
      .sidebar {
        display: none;
      }
      .sidebar-content {
        margin-left: 5px;
      }
      .nav-txt {
        font-size: 0.7rem;
      }
      .logo-img {
        height: 20px;
        margin-left: 15px;
      }
      .dropdown-menu {
        width: auto;
      }
      .header {
        padding-left: 0;
        grid-column: 1 / -1;
      }
      .header-nav-item {
        margin: 0 30px;
        font-size: 0.8rem;
      }
      .content {
        margin-left: 10px;
        grid-column: 1 / -1;
      }
      .invoice-cont {
        margin: 30px 20px 10px 0;
      }
      .lanclient-buttons {
        flex-flow: row wrap;
      }
      .lanclient-buttons button {
        margin-top: 10px;
      }
      .left-invy-logo img {
        height: 100px;
        margin-top: 10px;
      }
      .lanclient-billing {
        margin: 10px 0;
      }
      .billing-clhead { font-size: 10px; }
      .bills-description { font-size: 15px !important;}

      .mobile-sidebar {
        position: absolute;
        display: flex;
        height: auto;
        top: 85px;
        left: -60vw;
        z-index: 1;
        transition: left ease-in 500ms;
      }
      .mobile-sidebar.active {
        left: 0;
      }
      .mobile-nav-btn {
        width: 40px;
      }
      .nav-span {
        display: block;
        height: 5px;
        margin: 4px;
        border-radius: 10px;
        background-color: #091429;
      }
      .mobile-nav-btn.active {
        transform: rotate(90deg);
      }
    }
  </style>
@endsection

@section('content')
      <div class="content"> 
        <div class="invoice-cont">
          <h5 class="invoice-banner-txt"><b>Invoice</b></h5>
          <div class="lanclient-invoice-logo">
            <div class="right-invy top-left">
              <p><strong>Project:&nbsp;</strong>{{ $projectName }}</p>
              <p><strong>Lancer:&nbsp;</strong>{{ $lancerName }}</p>
              <p><strong>Email:&nbsp;</strong>{{ $lancerMail }}</p>
                <p>
                  @if(isset($lancerAddress))
                    @php echo "<strong>Address:&nbsp;</strong>"; @endphp
                    {{ $lancerAddress }}
                  @else
                     @if(isset($lancerStreetNum))
                        @php echo "<strong>Address:&nbsp;</strong>"; @endphp
                        {{ $lancerStreetNum.", " }}
                     @endif
                     @if(isset($lancerStreet))
                        {{ $lancerStreet." Street, "}}
                     @endif
                     @if(isset($lancerCity))
                        {{ $lancerCity.", " }}
                     @endif
                     @if(isset($lancerState))
                        {{ $lancerState.", " }}
                     @endif
                     @if(isset($lancerCountry))
                        {{ $lancerCountry.", " }}
                     @endif
                  @endif
                </p>
            </div>
            <span class="left-invy-logo top-right">
              <img src="https://res.cloudinary.com/abisalde/image/upload/v1570566026/My_Logo_-_Black.png" alt="Lancer-Logo">
            </span>
          </div>

          <div class="lanclient-billing">
              <div class="bill-left"> 
                    <p class="billing-clhead">Bill to</p>
                     <div class="bills-descrip"> <p class="bills-description">{{ $clientName }}</p> <p class="bills-description">{{ $clientMail }}</p>
                            <p>
                                    @if(isset($clientStreetNum))
                                        {{ $clientStreetNum }}
                                    @endif
                                    @if(isset($clientStreet))
                                        {{ $clientStreet." Street, " }}
                                    @endif
                                    @if(isset($clientCity))
                                        {{ $clientCity.", " }}
                                    @endif
                                    @if(isset($clientState))
                                        {{ $clientState.", " }}
                                    @endif
                                    @if(isset($clientCountry))
                                        {{ $clientCountry." " }}
                                    @endif
                            </p>
                     </div>
              </div>
                        <div class="bill-mid">
                              <div class="top-mid-bill-details"> <p class="billing-clhead">Issue Date</p>
                               <p class="bills-description">
                                   @php
                                    $issuetime = strtotime($issueDate);
                                    $issuetime = date("jS M Y", $issuetime);
                                    echo htmlspecialchars($issuetime);
                                   @endphp
                                </p>
                              </div>
                                     <div class="bottom-mid-bill-details">
                               <p class="billing-clhead">Due Date</p>
                               <p class="bills-description">
                                   @php
                                    $duetime = strtotime($dueDate);
                                    $duetime = date("jS M Y", $duetime);
                                    echo htmlspecialchars($duetime);
                                   @endphp
                               </p>
                                    </div>
                          </div>

             <div class="last-child-billing bill-right">
                     <div class="top-last-bill-details"> <p class="billing-clhead">Hourly Rate</p> <p class="bills-description" id = "hourly-rateN">N/A</p>
                     </div>
                          <div class="bottom-last-bill-details"> <p class="billing-clhead">Amount Due</p> <p class="bills-description">{{ $currencySymbol }}{{ $amount }}</p>
                           </div>
            </div>
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
                  <td>Base Charge</td>
                  <td>{{ $time }}</td>
                  <td>{{ $pricePerHour }}</td>
                  <td>
                      @php
                        echo ((int)$time * (int)$pricePerHour);
                      @endphp
                  </td>
                </tr>
                <tr>
                  <td>Equipment Cost</td>
                  <td>1</td>
                  <td>{{ $equipmentCost }}</td>
                  <td>{{ $equipmentCost }}</td>
                </tr>
                @if(null !== $subContractorCost)  
                <tr>
                        <td>Sub-contractors</td>
                        <td>1</td>
                        <td>{{ $subContractorCost }}</td>    
                        <td>{{ $subContractorCost }}</td>
                    </tr>
                @endif
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="2" class= "no-border-table"></td>
                  <td class= "no-border-table" >Total</td>
                  <td class= "no-border-table" >{{ $currencySymbol }} {{ $amount }}</td>
                </tr>
                <tr>
                  <td colspan="2" class= "no-border-table"></td>
                  <td class ="light-head dbl-border">Discount</td>
                  <td class = "dbl-border" >N/A</td> </tr>
                <tr>
                  <td colspan="2" class= "no-border-table"></td>
                  <td class= "no-border-table">Amount Due</td>
                  <td class= "no-border-table">{{ $currencySymbol }} {{ $amount }}</td>
                </tr>
              </tfoot>
            </table>


          <div class="lanclient-footer-tab">
            <p class ="light-head"><strong>Notes</strong></p>
            <p>
                @if(isset($projectDescription))
                    {{ $projectDescription }}
                @else
                <i>No notes</i>
                @endif
            </p>
          </div>
          </section>
@endsection