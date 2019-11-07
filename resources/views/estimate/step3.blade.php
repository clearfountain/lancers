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
            <a class="icon-btn" id="icon-close">
                <span><i class="icon-btn fa fa-times"></i></span>
            </a>
        </div>

        <div class="text-center">
            <a class="icon-btn" id="icon-back">
                <span><i class="icon-btn fa fa-chevron-left"></i></span>
            </a>
        </div>

        <div class="text-center">
            <p class="">Create Estimate</p>
        </div>

        <div class="">
            <input class="text-center cnc" id="next_page" value="NEXT" type="button">
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
                                <select name="client" id="client" class="select-project" style="color: #919191">
                                    <option value="new" selected>Select Client</option>
                                    @foreach($clients as $client)
                                    <option value="{{$client->id}}">{{$client->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="next_checker" value="">
                    <div class="col-md-6" >
                        <a class="" id="clientClick">
                            <div class="cli-box" style="color: #919191">
                                <div class="sub-box new-client">

                                        <p class="">A new Client</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <button class="btn" id="next_btn">NEXT</button>
        </div>

    </div>
</form>
@endsection

@section('script')
  <script>
  /**
  * Jquery code to handle next buttons and form submission
  * */
      $("#client").on("onChange", function() {
       $("#next_btn").css( "background-color", "#0ABAB5");
       $("#next_page").css( "background-color", "#0ABAB5");
       $("#next_checker").val("checked");
      });

      $("#clientClick").on("click", function() {
       $("#next_btn").css( "background-color", "#0ABAB5");
       $("#next_page").css( "background-color", "#0ABAB5");
       $("#next_checker").val("checked");
      });


      $("#next_btn").on("click", function() {

      let checkerValue = $("#next_checker").val();

      if(checkerValue == "checked")
      {
        submitForm();
      }
      else
      {
        alert("Select a new or existing Client before proceeding to submit form");

        $('#form').submit(function(e)
        {
             e.preventDefault();
        });
        }

      });


      $("#next_page").on("click", function() {

       let checkerValue = $("#next_checker").val();
       let selectValue = $("#client").val();
       

       if(checkerValue == "checked" || allowNext)
       {
         submitForm();
       }
       else
       {
        alert("Select a new or existing Client before proceeding to submit form");

        $('#form').submit(function(e)
        {
            e.preventDefault();

        });
       }

       });

    let client = document.querySelector('#client');
    console.log(client)
    let next_page = document.querySelector('#next_page');
    let next_btn = document.querySelector('#next_btn');
    window.onload=function(){
        client.addEventListener('change', validate);
    }


    function validate(){
        if(client.value == 'new' || falsy(client)) {
            // console.log(form_children[i])
            next_page.disabled = true;
            next_btn.disabled = true;
            next_page.classList.remove('validated');
            next_btn.classList.remove('validated');
            return; // remove the validated toggle
        }
        next_page.disabled = false;
        next_btn.disabled = false;
        next_page.classList.add('validated');
        next_btn.classList.add('validated');
    }

    function falsy(el){
        if(typeof el.selected !== 'undefined'){
            if(el.selected != '' && el.selected !== 0 && el.selected == null) return false;
        }else if(typeof el.value !== 'undefined'){
            if(el.value !== '' && el.value !== 0 && el.value !== null) return false;
        }
        return true;
    }

    function submitForm(){
        let form = document.querySelector('#form');
        form.submit();
    }

    function next(e){
        let form = document.querySelector('#form');
        form.submit();
    }

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
