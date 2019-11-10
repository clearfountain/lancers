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
<br/><br/>  <br/><br/>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col offset-md-4">
            <div class="card">
               
                <div class="card-header">Payment for {{$data['name']}}</div>
                <div class="card-body">                   
                    @if($data['amount'] == 0)
                    {{ "No payment needed"}}
                    @else
                                            
                        @if($data['type'] == 'sub')
                           @php
                            $array = array(array('metaname' => 'action', 'metavalue' => 'sub'),
                            array('metaname' => 'plan_id', 'metavalue' => $data['id']));
                            @endphp
                            <form method="POST" action="{{ route('pay') }}" id="paymentForm">
                                {{ csrf_field() }} 
                                <div class="row form-group">   
                                
                        <label for="password" class="col-md-4 col-form-label text-md-right">Enter number of months</label>
                        <div class="col-md-6">
                            
                            <input name="paymentplan" min="1" type="number" class="form-control" value="1" autofocus>
                        </div>

                        <div class="col-md-6 offset-md-4">
                            <br>
                          
                          
                                <input type="hidden" name="amount" value="{{$data['amount']}}" /> <!-- Replace the value with your transaction amount -->
                                <input type="hidden" name="payment_method" value="both" /> <!-- Can be card, account, both -->
                                <input type="hidden" name="country" value="NG" /> <!-- Replace the value with your transaction country -->
                                <input type="hidden" name="currency" value="NGN" /> <!-- Replace the value with your transaction currency -->
                                <input type="hidden" name="email" value="{{Auth::user()->email}}" /> <!-- Replace the value with your customer email -->

                                <input type="hidden" name="metadata" value="{{ json_encode($array) }}" > <!-- Meta data that might be needed to be passed to the Rave Payment Gateway -->
                                <input type="hidden" name="ref" value="{{$data['ref']}}" />
                                <button type="submit" class="btn  btn-block" style="background-color:#0ABAB5;color: #fff">Pay NGN{{number_format((float)$data['amount'], 2)}}</button>
                        </div>
                        </form>

                        </div>
                        @else
                        <div class="col-md-6 offset-md-3">

                            <br>
                            @php
                            $array = array(array('metaname' => 'action', 'metavalue' => 'invoice'),
                            array('metaname' => 'invoice_id', 'metavalue' => $data['id']));
                            @endphp
                            <form method="POST" action="{{ route('pay') }}" id="paymentForm">
                                {{ csrf_field() }}
                                <input type="hidden" name="amount" value="{{$data['amount']}}" /> <!-- Replace the value with your transaction amount -->
                                <input type="hidden" name="payment_method" value="both" /> <!-- Can be card, account, both -->
                                <input type="hidden" name="country" value="NG" /> <!-- Replace the value with your transaction country -->
                                <input type="hidden" name="currency" value="NGN" /> <!-- Replace the value with your transaction currency -->
                                <input type="hidden" name="email" value="{{Auth::user()->email}}" /> <!-- Replace the value with your customer email -->

                                <input type="hidden" name="metadata" value="{{ json_encode($array) }}" > <!-- Meta data that might be needed to be passed to the Rave Payment Gateway -->
                                <input type="hidden" name="ref" value="{{$data['ref']}}" />
                                <button type="submit" class="btn  btn-block" style="background-color:#0ABAB5;color: #fff">Pay NGN{{number_format((float)$data['amount'], 2)}}</button>
                        </div>
                        </form>




                        @endif
                    </div>
                    @endif
                </div>


            </div>
        </div>
    </div>
</div>
@endsection
