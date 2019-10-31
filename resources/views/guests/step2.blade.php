@extends('layouts.app')
<!-- Select Project -->

@section('styles')
    <link rel="stylesheet" href="{{asset('css/step2.css')}}"/>
@endsection


@section('content')
<form id="form" onsubmit="submitEvent(event)" method="post" action="/guest/save/step2">
    @csrf
    
    @include('partials.header_stage2')

    <div class="container-fluid main-section">

        <div id="word">
            <h1>Evaluation</h1>
            <h5>Please Input the required fields in the form below</h5>
            <br>
        </div>

        <div class="section1">

            <div id="glac">
                <h1>Glacier Fintech App</h1>
                <hr />
            </div>
            <hr />

            <div id="bill">
                <h3>Billing</h3>

                <div class="hour">
                    <p>How long (in hours) will it take you to complete this project <i class="fa fa-question-circle" aria-hidden="true"></i></p>
                    <input type="number" required maxlength="10000" name="time" placeholder="Hours" style="width: 83% !important;" />
                </div>
                <div class="hour" style="display: none;">
                    <p>How much do you charge per hour <i class="fa fa-question-circle" aria-hidden="true"></i></p>
                    <input type="number" maxlength="10000000" value="5000" name="cost_per_hour" placeholder="NGN 0.00" style="width: 83% !important;" />
                </div>

                <div class="hours">
                    <p>Project starts/ends</p>
                    <i class="fa fa-calendar start"><input required type="text" onfocus="(this.type='date')" name="start" placeholder=" Set start date" /></i>
                    <i class="fa fa-calendar end"><input required type="text" onfocus="(this.type='date')" name="end" placeholder="Set end date" /></i>
                </div>

            </div>

            <hr />
            <div>
                <h3>Expenses</h3>
                <div class="hour">
                    <p id="cost">
                        How much would it cost you to power your devices or equipment for this project <i class="fa fa-question-circle" aria-hidden="true"></i>
                    </p>
                    <input type="number" required name="equipment_cost" id="equipment_cost" placeholder="NGN 0.00" style="width: 83% !important;" />
                </div>

                <div class="hour">
                    <p id="sub">Sub contractors (If any)</p>
                    <input type="text" required name="sub_contractors" id="sub_contractors" style="width: 83% !important;" placeholder="E.g. Illustrator, Consulting..." class="sub" />
                </div>
                <br />

                <div class="hour">
                    <p id="pay">How much would they be paid <i class="fa fa-question-circle" aria-hidden="true"></i></p>
                    <input type="number" required name="sub_contractors_cost" id="sub_contractors_cost" placeholder="NGN 0.00" style="width: 83% !important;" />
                </div>
            </div>
            <br>
            <div>
                <h3>Expertise</h3>

                <div class="hour">
                    <p id="proj">How many similar projects have you done before <i class="fa fa-question-circle" aria-hidden="true"></i></p>
                    <input type="number" required name="similar_projects" id="similar_projects" placeholder="0" style="width: 30% !important;">
                </div>

                <div class="hour">
                    <p id="rate">How would you rate your experience level in executing this project <i class="fa fa-question-circle" aria-hidden="true"></i><p>
                    <input required type="number" maxlength="5" name="rating" id="rating" placeholder="0" style="width: 30% !important;"> /5
                </div>

            </div>
            <hr />

            <div id="currency">
                Currency:
                <select class="hiddeselect" name="currency_id" required>
                    <option value="">Select Currency</option>
                    @foreach($currencies as $currency)
                    <option {{$currency->code == 'NGN' ? 'selected' : ''}} value="{{$currency->id}}">{{$currency->code}}</option>
                    @endforeach
                </select>

            </div>

        </div class="nex">

        <!-- <button class="btn">NEXT</button> -->
        <div class="row ml-auto box justify-content-center mt-20" style="margin-top: 20px;">
            <div class="col-sm-6">
                <button class="btn">NEXT</button>
                <!-- <input class="disabled" id="ext" type="submit" value="NEXT"> -->
            </div>
        </div>
    </div>

    </div>
</form>
@endsection

@section('script')
<script>
    function submitEvent(e){
        let form = document.querySelector('#form');
        let time = document.querySelector('[name="time"]');
        let start = document.querySelector('[name="start"]');
        let end = document.querySelector('[name="end"]');
        let rating = document.querySelector('[name="rating"]');
        let cost_per_hour = document.querySelector('[name="cost_per_hour"]');
        let currency_id = document.querySelector('[name="currency_id"]');
        let similar_projects = document.querySelector('[name="similar_projects"]');
        let sub_contractors_cost = document.querySelector('[name="sub_contractors_cost"]');
        let sub_contractors = document.querySelector('[name="sub_contractors"]');
        let equipment_cost = document.querySelector('[name="equipment_cost"]');

        if(1 == 2){
           e.preventDefault(); 
        }
        
    }
    

</script>
@endsection
