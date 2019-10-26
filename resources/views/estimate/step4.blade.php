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
<div class="container-fluid">


    <header style="border-bottom: 2px solid rgb(223, 223, 223);">
        <nav style="display: flex; ">
            <a href="#"  @click.prevent="$router.push('/estimate')" class="column-1">
                <img
                    src="https://res.cloudinary.com/mide358/image/upload/v1570621469/clear_24px_rasbwc.png"
                    alt="navIcon"
                    />
            </a>
            <a href="#" @click.prevent="previous" class="column-1">
                <img
                    src="https://res.cloudinary.com/mide358/image/upload/c_scale,h_27,w_13/v1570621434/Vector_ag4hnv.png"
                    alt="navIcon"
                    />
            </a>
            <div class="column-2">client</div>
            <a href="#" @click.prevent="next" id="upperNext" class="column-3 float-right" style="border: 1px solid gray;
               background: #0ABAB5 !important;">NEXT</a>
        </nav>
    </header>

    <!--@Ezeko -->
    <div class="container">
        <div class="clearrfix"></div>
        <br/> <br/>
        <div class="card-title">
            <h2 class="">Client Information</h2>
        </div>
        <style>
            .my-hr-line {
                position: relative;
                left: -20px;
                width: calc(100% + 40px);
                border: 1px solid #ddd;
            }

        </style>
        <div class="clearrfix"></div>
        <div class="container ">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 mx-auto">
                    <div id="pay-invoice" class="card">
                        <div class="card-body">

                            <div class="clearrfix"></div>


                            <form method="post" action="/estimate/create/step5" id="form">
                                @csrf


                                @if(session('success'))<br> <div class="alert alert-success">{{session('success')}}</div>
                                @elseif(session('error'))<br> <div class="">{{session('error')}}</div> @endif
                                @if(session()->has('message.alert'))
                                <div class="text-center">
                                    <button class=" alert alert-{{ session('message.alert') }}"> 
                                        {!! session('message.content') !!}
                                    </button>
                                </div>
                                @endif
                                <div class="">
                                    <label>  <h5>Business Information</h5></label>
                                </div>
                                <div class="clearfix"></div>
                                <br/>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="cc-exp" class="control-label">Company name</label>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="input-group">
                                            <input type="text" class="form-control col-md-12 col-sm-10" name="name" required id="Cname" placeholder="e.g Sunshine Studio">
                                        </div>
                                    </div>
                                </div>



                                <div class="">
                                    <label>  <h5>Business Address</h5></label>
                                </div>
                                <div class="clearfix"></div>
                                <br/>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="cc-exp" class="control-label">Street & Number</label>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="input-group">
                                            <input required type="text" class="form-control col-md-6 col-sm-6" name="street" id="street" placeholder="Street">
                                            &nbsp; &nbsp;<input required type="number" class="form-control col-md-6 col-sm-6" name="street_number" id="number" placeholder="Number">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="cc-exp" class="control-label">City & Zip Code</label>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="input-group">
                                            <input required type="text" class="form-control col-md-6 col-sm-6" name="city" id="city" placeholder="City">
                                            &nbsp; &nbsp;  <input required type="number" class="form-control col-md-6 col-sm-6" name="zipcode" id="Zcode" placeholder="Zip code">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="cc-exp" class="control-label">Country & State</label>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="input-group">
                                            <select required name="country_id" class="form-control col-md-6 col-sm-6">
                                                <option value="" selected>Country</option>

                                                @foreach($countries as $country)
                                                <option value="{{$country->id}}">{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                            &nbsp; &nbsp;
                                            <select required name="state_id" class="form-control col-md-6 col-sm-6">
                                                <option value="" selected>Select State</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <br/>
                                <div class="">
                                    <label>  <h5>Contact Information</h5></label>
                                </div>

                                <div class="row">

                                    <div class="col-8">

                                        <span id="contacts"></span>
                                        <h5><a onClick="addContact()">Add other contacts &nbsp; +</a></h5>     
                                    </div>
                                </div>


                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <br/>
                    <div>
                        <div class="text-center">
                            <button  type="submit" class="btn" style="border: 1px solid gray;
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

        @section('script')
        <script type="text/javascript">
            let count = 1;
			window.addEventListener('load', function() {
				addContact();
			})
            function addContact() {
                let element = document.querySelector('#contacts')
                let newElement = document.createElement('div');
                newElement.classList.add('form-group');
                newElement.innerHTML = `
                    <label for="company_name_${count}">Contact name</label>
                  <input class="form-control col-md-6 col-sm-6" type="text" name="contact[${count}]['name']" id="contact_name${count}" placeholder="e.g Ben Davies">
                         <div class="clearfix"></div>
                              <br/>
                    <label for="company_email">Contact email</label>
                    <input class="form-control col-md-6 col-sm-6" type="email" name="contact[${count}]['email']" id="email_${count}" placeholder="e.g email@domain.com">
                        </div>
                `;
                element.appendChild(newElement);
                count += 1;
            }

            $(document).ready(function () {
                $('select[name="country_id"]').on('change', function () {
                    let countryID = $(this).val();
                    if (countryID) {
                        $.ajax({
                            url: '/states/' + encodeURI(countryID),
                            type: "GET",
                            dataType: "json"
                            ,
                            success: function (data) {
                                $('select[name="state_id"]').empty();
                                $('select[name="state_id"]').append('<option selected value="">Select State</option>');
                                $.each(data.data, function (key, value) {
                                    $('select[name="state_id"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                                });
                            }
                        });
                    } else {
                        $('select[name="state"]').empty();
                    }
                });
            });
        </script>
        @endsection
