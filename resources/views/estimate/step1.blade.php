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
        }


        @media (max-width: 992px) {


            #container p {
                font-size: 19.5px;
                margin-top: 9px;
            }

            div>#ext {
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


        }


        @media (max-width: 576px) {
            #container p {
                font-size: 16px;
                margin-top: 12px;
            }

            div>#ext {
                font-size: 15px;
            }

        }
        .card:hover{border: 1px solid black;}
    </style>

<!-- <link rel="stylesheet" href="{{asset('css/step1.css')}}"/> -->

@endsection


@section('content')
<div id="container">
    <div>
        <a href="{{url('/dashboard')}}"><button class="close navM"><span>
                <i class="fa fa-times"></i>
            </span></button></a>
    </div>
    <div>
        <p class="nav cEstimate" id="cre">Create Estimate</p>
    </div>
    
    <div>
        <input class="disabled" id="ext" type="submit" value="NEXT">
    </div>    
</div>


<div class="contaner">
    <div class="clearfix"></div>
    <br/>  <br/>
    <div class="row ml-auto box justify-content-center">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h2>What project are you estimating for?</h2>
            <br>
            <p style="color:red;">@if(null !== session('error')) {{session('error')}} @endif</p>
        </div>
    </div>
    <!-- <h3 class="text-center">What project are you estimating?</h3> -->
    @if(session()->has('message.alert'))
    <div class="text-center">
        <button class=" alert alert-{{ session('message.alert') }}"> 
            {!! session('message.content') !!}
        </button>
    </div>
    @endif
    
    <form method="post" action="/estimate/create/step2">
        @csrf
        <div class="row ml-auto box justify-content-center">
        <!-- <div class="row ml-auto mr-auto box justify-content-center"> -->
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">A previously created project</h5>
                        <p style="padding-bottom: 10px;" class="card-text">Find estimate for a previously created project, by doing so the
                            estimate
                            gets populated with some of the data.
                        </p>
                        <div class="contents dropdown">
                            <select class="dropbtn form-control" name="old_project" id="projectSelect">
                                <option selected value="">Select</option>
                                @foreach($projects as $project)
                                <option value="{{$project->id}}">{{$project->title}}</option>
                                @endforeach
                            </select>
                            <!-- <i class="fa fa-caret-down"></i> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">A new project</h5>
                        <p style="margin-bottom: 3em;" class="card-text">Create a new estimate and set up a new project based on the
                            information.
                        </p>
                        <input type="text" class="form-control" name="new_project" id="name" placeholder="Project Name">           
                    </div>
                </div>
            </div>
            
        </div>
        <div class="row ml-auto box justify-content-center mt-20" style="margin-top: 20px;">
            <div class="col-sm-4">
                <input class="disabled" id="ext" type="submit" value="NEXT">
            </div>
        </div>
    </form>
</div>

@endsection

@section('script')
    
<script>
        
   function verifyPath() {
        let a_next =  document.querySelectorAll('#ext');
        let newProjectName = document.querySelectorAll('.form-control')[1].value;
        let oldProjectName = document.querySelectorAll('.form-control')[0].value;

        console.log('here:' + newProjectName);
        
        if (newProjectName != "" && newProjectName.length >= 4 ) {
            console.log('here:' + newProjectName);

document.querySelectorAll('#ext')[0].style.background = '#0ABAB5';

            document.querySelectorAll('#ext')[1].style.background = '#0ABAB5';
           
        } else {

            //console.log('here works');
            document.querySelectorAll('#ext')[0].style.background = '';
            document.querySelectorAll('#ext')[1].style.background = '';
   
             
        }
    }
    

    let buttonOne = document.querySelectorAll('.form-control')[0];
    let buttonTwo = document.querySelectorAll('.form-control')[1];
    document.querySelectorAll('.form-control')[1].addEventListener('click', function(){
        console.log('yuyu');
    });
    
    
    window.onload = function(){
        console.log('ok');
     
        buttonOne.addEventListener('keyup', verifyPath);
         buttonTwo.addEventListener('keyup', verifyPath);
    };
    </script>
@endsection

