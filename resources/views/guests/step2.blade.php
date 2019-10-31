@extends('layouts.app')
<!-- Select Project -->

@section('styles')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>
    body {
        font-family: 'Roboto', sans-serif;
        overflow: auto;
    }

    h1 {
        margin-top: 5%;
        margin-left: 18%;
        color: #262626;
    }

    h5 {
        font-weight: bold;
        color: #262626;
    }

    p {
        padding-bottom: 40px;
    }

    .box {
        margin-top: 5%;

    }

    .card-body:hover {
        border: 2px solid #0ABAB5;
        box-sizing: border-box;
    }

    .btn-on {
        width: 100%;
        background: gray;
        border: 1px solid rgba(145, 145, 145, 0.4);
        box-sizing: border-box;

        text-align: left;
        color: #091429;
        height: 50px;
    }

    .btn-on:hover {
        color: #E4E4E4;
        background: #0ABAB5 !important;
    }

    .dark {
        margin-top: 40px;
        margin-left: 40%;
        width: 20%;
        height: 60px;
        border: 1px solid gray;
        background: #0ABAB5 !important;
        color: white;

    }

    .dark:hover {

        background: #0ABAB5!important;
        color: white;
    }

    #name {
        padding: 10px;
        width: 100%;
        height: 50px;
        font-size: 20px;
        border: 1px solid rgba(145, 145, 145, 0.4);
    }

    #container {
        display: grid;
        grid-template-columns: 1fr 5fr 1fr;

    }

    #container div {
        border: 1px solid black;
        height: 50px;
    }

    #container p {
        justify-content: center;
        margin-top: 15px;
        font-style: normal;
        font-weight: bold;


        color: #323A43;
    }

    #ext {
        justify-content: center;
        border: none;
        background: gray !important;
        color: white;
        width: 100%;
        height: 50px;
    }


    #ext:hover {

        background:  #091429 !important;

    }

    #cnc {
        cursor: pointer;
    }

    .dropbtn, .project {
        /* margin-top: 37px; */
        width: 100%;
        height: 50px;
        padding: 10px;
        border: 1px solid rgba(145, 145, 145, 0.4);
        /* box-sizing: border-box; */
    }
    option, select {
        font-size: 20px;
        background: rgba(207, 204, 204, 0.4);
    }

    a:hover{cursor: pointer;}





    body {
        box-sizing: border-box;
        margin: 0px;
        font-family: ubuntu !important;
    }

    .con-div {
        background-color: #FFFFFF;
        width: 100%;
        margin: auto;
    }

    .top-divs {
        display: flex;
        margin: 0 auto;
        width: 100%;
        background-color: #FFFFFF;
        font-family: Roboto;
    }

    .ctrl-div {
        width: 8%;
        text-align: center;
        border: 1px solid #919191;
    }

    .ctrl-btn {
        width: 100%;
        background-color: #FFFFFF;
        border: none;
    }

    .inv-div {
        width: 60%;
        text-align: center;
        border: 1px solid #919191;
    }

    #inv-btn {
        width: 100%;
        border: none;
        padding: 0.5em;
        font-weight: 500;
        font-size: 28px;
        background-color: #FFFFFF;
    }

    .send-div {
        width: 32%;
        text-align: center;
        border: 1px solid #919191;
    }

    #send-btn {
        width: 100%;
        border: none;
        padding: 0.5em;
        color: #FFF;
        font-size: 28px;
        background-color:  rgba(196, 196, 196, 0.4);
    }

    .cli-info {
        width:75%;
        height:80vh;
        background-color:#FFFFFF;
        margin: auto
    }

    .cli-box {
        display: flex;
        justify-content:space-around;
    }

    .sub-box {
        width: 30%;
        padding: 2em 1em;
        margin: 2em;
        background-color:#FFF;
        text-align:center;
        border: 1px solid #919191;
        border-radius: 2px
    }

    .sub-box:hover {
        border: 3px solid gray;
    }

    .select-project {
        width: 90%;
        padding: 1em;
        border: 1px solid #919191;
    }

    .cli-text {
        padding-top: 1.5em;
    }

    .my-icon {
        width: 100%;
        margin: 0.6em 0;
        color: #c4c4c4;
        background-color: #FFFFFF;
    }

    .what-cli {
        padding: 1.5em 1em !important;
        margin: 0;
        font-size: 42px !important;
        font-weight: bold !important;
        color: #323232;
    }

    .txt {
        margin: 2em 0;
    }
    .column-1 {
        width: 5%;
        border-right: 2px solid rgb(223, 223, 223);
        padding: 1em;
        text-align: center;
        color: black;
        text-decoration: none;
    }
    .column-2 {
        width: 75%;
        text-align: center;
        align-items: center;
        padding: 0.8em;
        color: black;
        text-decoration: none;
        font-size: 1.5em;
        font-weight: bold;
    }
    .column-3 {
        width: 15%;
        border-left: 2px solid rgb(223, 223, 223);
        padding: 0.8em;
        text-align: center;
        background-color: rgba(196, 196, 196, 0.4);
        color: white;
        text-decoration: none;
        font-size: 1.5em;
        font-weight: bold;
    }

    @media screen and (max-width: 500px) {
        .cli-box {
            display: block;
        }

        .sub-box {
            width: 90%;
            margin: 2em 0em;
        }

        option {
            width: 80%;
        }

        .what-cli {
            font-size: 1.3em;
        }
    }
    @media (max-width: 575.98px) {
        .column-1 {
            width: 15%;
            padding: 0;
        }
        .column-2 {
            width: 75%;
            padding-top: 0.6em;
            font-size: 0.9em;
        }
        .column-3 {
            width: 25%;
            padding-top: 0.7em;
            font-size: 0.8em;
        }
        img {
            height: 20px;
            width: 10px;
            padding-top: 0.6em;
        }
    }

    @media (min-width: 576px) and (max-width: 767px) {
        .column-1 {
            width: 10%;
        }
        img {
            height: 15px;
            width: 10px;
        }
    }
    @media (min-width: 768px) and (max-width: 991.98px) {
        .column-1 {
            width: 9%;
        }
    }




</style>

@endsection


@section('content')
<div class="contaner">

    <header style="border-bottom: 2px solid rgb(223, 223, 223);">
        <nav style="display: flex; ">
            <a href="#"  @click.prevent="$router.push('/estimate')" id="closeForm" class="column-1">
                <img
                    src="https://res.cloudinary.com/mide358/image/upload/v1570621469/clear_24px_rasbwc.png"
                    alt="navIcon"
                    />
            </a>
            <a href="{{ redirect()->getUrlGenerator()->previous() }}" @click.prevent="previous" class="column-1">
                <img
                    src="https://res.cloudinary.com/mide358/image/upload/c_scale,h_27,w_13/v1570621434/Vector_ag4hnv.png"
                    alt="navIcon"
                    />
            </a>
            <div class="column-2">Create Estimate</div>
            <a href="#" @click.prevent="next" id="step2UpperButton" class="column-3 float-right" style="border: 1px solid gray;
               background: #0ABAB5 !important;">NEXT</a>
        </nav>
    </header>

    <!--@Ezeko -->
    <div class="container">
        <div class="clearrfix"></div>
        <br/> <br/>
        <div class="card-title">
            <h2 class="">Evaluation</h2>
            <h6>Please Input the required fields in the form below</h6>
        </div>
        <style>
            .my-hr-line {
                position: relative;
                left: -20px;
                width: calc(100% + 40px);
                border: 1px solid #ddd;
            }
            .hiddeinput {
                color: grey!important;
                background: linear-gradient(to right, #808080, #808080) 5px calc(100% - 5px)/calc(100% - 10px) 2px no-repeat;
                /* <5px calc(100% - 5px)> : position of the gradient [5px from left and 5px from bottom  */
                /* <calc(100% - 10px) 2px> : size of the gradient [width:100%-10px height:2px] */
                background-color: #fcfcfc;
                border: hidden;
                padding: 3px;
            }
            .icon {
                color: grey!important;
                padding: 3px;
            }
            .hiddeselect {
                color: #000!important;
                background: linear-gradient(to right, #000, #000) 5px calc(100% - 5px)/calc(100% - 10px) 2px no-repeat;
                /* <5px calc(100% - 5px)> : position of the gradient [5px from left and 5px from bottom  */
                /* <calc(100% - 10px) 2px> : size of the gradient [width:100%-10px height:2px] */
                background-color: #fcfcfc;
                border: hidden;
                padding: 3px;
            }
        </style>
        <div class="clearrfix"></div>
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 mx-auto">
                    <div id="pay-invoice" class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h2 class="pull-left">{{ $project['project_name'] }}</h2>
                            </div>
                            <hr>
                            <div class="clearrfix"></div>
                            <br/>

                            <hr class="my-hr-line">
                            <form method="post" action="/guest/save/step2">
                                @csrf

                                <div class="">
                                    <label>  <h3>Billing</h3></label>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="cc-exp" class="control-label">How long (in hours) will it take you to complete this project?</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group">
                                            <input type="number" class="form-control col-md-4 col-sm-10" required name="time" placeholder="Hours" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="cc-exp" class="control-label">How much  do you charge per hour?</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group">
                                            <input type="number" class="form-control col-md-4 col-sm-10" required name="cost_per_hour" placeholder="NGN 0.00" />
                                        </div>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="cc-exp" class="control-label">Project starts/ends</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group">
                                            <i class="icon fa fa-calendar"></i>&nbsp;
                                            <input class="hiddeinput col-md-4 col-sm-3" type="text" required onfocus="(this.type = 'date'); (this.name = 'start')" name="start" placeholder=" Set start date" />
                                            <i class="icon fa fa-calendar"></i>
                                            <input type="text" class="hiddeinput col-md-4 col-sm-3"  required onfocus="(this.type = 'date'); (this.name = 'end')" name="end" placeholder="Set end date" />
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-hr-line">
                                <div class="">
                                    <label>  <h3>Expenses</h3></label>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="cc-exp" class="control-label"> How much would it cost you to power your devices or equipment for this project?</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group">
                                            <input type="number" class="form-control col-md-4 col-sm-10" required name="equipment_cost" id="est1" placeholder="NGN 0.00" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="cc-exp" class="control-label">Are you subcontracting to anyone?</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group">
                                            <input type="text"  class="form-control col-md-6 col-sm-10" required name="sub_contractors" id="est2" placeholder="E.g. Illustrator, Consulting..." />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="cc-exp" class="control-label">How much would they be paid?</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group">
                                            <input type="number" class="form-control col-md-4 col-sm-10" required name="sub_contractors_cost" id="est3" placeholder="NGN 0.00" />
                                        </div>
                                    </div>
                                </div>


                                <div class="">
                                    <label>  <h3>Expertise</h3></label>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="cc-exp" class="control-label"> How many similar projects have you done before?</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group">
                                            <input type="number" class="form-control col-md-4 col-sm-10" required name="similar_projects" id="exp1">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="cc-exp" class="control-label">Out of 5 how would you rate your experience level in executing this project?</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group">
                                            <input class="form-control col-md-6 col-sm-10" type="number" required name="rating" id="exp2"> /5
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-hr-line">
                                <div class="">
                                    <label>  <h3>Currency:

                                            <select class="hiddeselect" name="currency_id" required>
                                                <option value="">Select Currency</option>
                                                @foreach($currencies as $currency)
                                                <option value="{{$currency->id}}">{{$currency->code}}</option>
                                                @endforeach
                                            </select>

                                        </h3></label>
                                </div>



                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <br/>
                    <div>
                        <div class="text-center">
                        <button  type="submit" class="btn" id="step2LowerButton" style="border: 1px solid gray;
                                 background: #0ABAB5 !important; height: 70px; width: 200px;color:#fff!important">NEXT

                        </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>



        @endsection

        @section('script')

<script>
//use jquery to handle next buttons
        $("#step2UpperButton").on("click", function() {
        $("#step2LowerButton").trigger("click");
      });

      $("#moveBack").on("click", function() {
    window.history.back();

    });

//handle form close
$("#closeForm").on("click", function() {
    let path = "@php echo session("path") @endphp";
    window.location = path;

});



    let createProject = document.getElementById('createProject');


     function manage(createProject) {
        let bt = document.getElementById('btne');
        if (createProject.value != '') {
            bt.disabled = false;
        }
        else {
            bt.disabled = true;
             bt.preventDefault();
        }
    }
    </script>

        @endsection
