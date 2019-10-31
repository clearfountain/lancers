@extends('layouts.app')
<!-- Select Project -->

@section('styles')
    <style>
        * {
            margin-right: 0px;
            margin-left: 0px;
            font-family: Ubuntu;
        }


        /*navbar css*/
        #container {
            display: grid;
            grid-template-columns: 1fr 8fr 2fr;
        }


        #container div {
            box-shadow: 0px 4px 2px rgba(0, 0, 0, 0.1);
            outline: none;
            height: 60px;

        }

        #container p {
            justify-content: center;
            margin-top: 15px;
            font-style: normal;
            font-weight: bold;
            font-size: 1.3em;
            color: #323A43;
        }


        div>#ext {
            background: rgba(207, 204, 204, 0.4);
            font-size: 24px;
            font-weight: bold;
            justify-content: center;
            border: none;
            color: white;
            width: 100%;
            height: 60px;
            outline: none;
            /*added outline none*/
        }

        div>#ext:hover {
            background: #0ABAB5;
        }

        div>#extL {
            background: rgba(207, 204, 204, 0.4);
            font-size: 24px;
            font-weight: bold;
            justify-content: center;
            border: none;
            color: white;
            width: 100%;
            height: 60px;
            outline: none;
            /*added outline none*/
        }

        div>#extL:hover {
            background: #0ABAB5;
        }

        div>.close {
            outline: none;
        }

        .close {

            color: #C4C4C4;
            width: 100%;

        }

        .navM i {
            padding-top: 15px;
        }

        /*end of nav bar*/

        @media (max-width: 976px) {

            div>#ext {
                font-size: 15px;
            }
            div>#extL {
                font-size: 15px;
            }
        }


        @media (max-width: 992px) {


            #container p {
                font-size: 19.5px;
                margin-top: 9px;
            }

            div>#ext {
                font-size: 20px;
            }
            div>#extL {
                font-size: 20px;
            }
        }



        @media (max-width: 767px) {

            #container p {
                margin-top: 5px;
           }
            #container p {
                font-size: 17.5px;
                margin-top: 12px;
            }

            div>#ext {
                font-size: 18px;
            }
            div>#extL {
                font-size: 18px;
            }

        }


        @media (max-width: 576px) {
            #container p {
                font-size: 16px;
                margin-top: 12px;
            }

            div>#ext {
                font-size: 15px;
            }
            div>#extL {
                font-size: 15px;
            }

        }
    </style>

<!-- <link rel="stylesheet" href="{{asset('css/step1.css')}}"/> -->

@endsection


@section('content')
<div id="container">
    <div>
        <button class="close navM" id="closeForm"><span>
                <i class="fa fa-times" ></i>
            </span></button>
    </div>
    <div>
        <p class="nav cEstimate" id="cre">Create Estimate</p>
    </div>
    <div>
        <input class="disabled" id="ext" type="button" value="NEXT">
    </div>
</div>


<div class="contaner">
    <div class="clearfix"></div>
    <br/>  <br/>

    <h3 class="text-center">What project are you estimating?</h3>
    @if(session()->has('message.alert'))
    <div class="text-center">
        <button class=" alert alert-{{ session('message.alert') }}">
            {!! session('message.content') !!}
        </button>
    </div>
    @endif
    <form id="create-project" method="post"action="/guest/save/step1" >
        @csrf
        <div class="row ml-auto box justify-content-center">

            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">A new project</h5>
                        <p class="card-text">Create a new estimate and set up a new project based on the
                            information.
                        </p>
                        <input type="text" class="form-control" id="name_of_project" name="project_name" type="text" placeholder="Project Name">
                    </div>
                </div>
            </div>

        </div>
        <div class="row ml-auto box justify-content-center mt-20" style="margin-top: 20px;">
            <div class="col-sm-4">
                <input class="disabled" id="extL" type="submit" value="NEXT">
            </div>
        </div>
    </form>
</div>

@endsection

@section('script')


<script>
//use jquery to handle next buttons
        $("#ext").on("click", function() {
        $("#extL").trigger("click");
      });

      $("#name_of_project").on("input", function() {
       $("#extL").css( "background-color", "#0ABAB5");
       $("#ext").css( "background-color", "#0ABAB5");
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

