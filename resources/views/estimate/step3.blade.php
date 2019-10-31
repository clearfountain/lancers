@extends('layouts.app')
<!-- Select Project -->

@section('styles')
    <link rel="stylesheet" href="{{asset('css/step2.css')}}"/>
    <style>
    

    .select-project {
      width: 90%;
      padding: 1em;
      border: 1px solid #919191;
    }

    a:hover{cursor: pointer;}

    .cli-box{
        height: 200px; 
        width: 80%;
        margin: 0px auto;
        vertical-align: middle; 
        padding: 12%; 
        border: 1px solid gray; 
        text-align: center;
        margin-top: 20px;
    }
    .new-client{
        padding-top: 15%;
    }

    .cli-box:hover {
      border: 3px solid gray;
    }
</style>
@endsection


@section('content')
<form method="post" action="/estimate/create/step4" id="form">
    @csrf
    <div id="container">

        <div class=" text-center">
            <span><i class="fa fa-times"></i></span>
        </div>

        <div class="text-center">
            <span><i class="fa fa-chevron-left"></i></span>
        </div>

        <div class="text-center">
            <p class="">Create Estimate</p>
        </div>

        <div class="">
            <input class="text-center cnc" value="NEXT" type="button">
        </div>

    </div>

        <div class="container-fluid main-section">
            <div class="row">
                <div class='col-12 text-center'>
                    <h2 class="what-cli">What Client is it for?</h2>
                </div>
            </div>
            <div class="row" style="color: #919191">
                    <div class="col-md-6">
                        <div class="cli-box" style="color: #919191">
                            <div class="sub-box">
                                <p class="txt">An already existing Client</p>
                                <select name="client" class="select-project" style="color: #919191">
                                    <option value="new" selected>Select Client</option>
                                    @foreach($clients as $client)
                                    <option value="{{$client->id}}">{{$client->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6" >
                        <a class="" onClick="next(event)">
                            <div class="cli-box" style="color: #919191">
                                <div class="sub-box new-client">    
                                    
                                        <p class="">A new Client</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <button class="btn">NEXT</button>
        </div>

    </div>
</form>
@endsection

@section('script')
  <script>
    function verifyPath(){
        let createProject = document.getElementById('createProject').value;

        if ( createProject !== "" ){
            document.querySelector('.btn').style.background = '#0ABAB5';
            document.querySelector('.next').style.background = '#0ABAB5';

            document.querySelector('.btn').classList.remove('disabled');
            document.querySelector('.next').classList.remove('disabled');
        } else {
            //console.log('here works');
            document.querySelector('.next').style.background = 'rgba(207, 204, 204, 0.4)';
            document.querySelector('.next').classList.add('disabled');
            document.querySelector('.btn').style.background = 'rgba(207, 204, 204, 0.4)';
            document.querySelector('.btn').classList.add('disabled');
        }

    }
  </script>
@endsection
