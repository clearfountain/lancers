@extends('layouts.app')
<!-- Select Project -->

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('css/step1.css')}}"/>
@endsection


@section('content')
<form method="post" action="/estimate/create/step2" id="stage1">
@include('partials.header_stage1')

<div class="contaner">
    <div class="clearfix"></div>
    <br/>  <br/>
    <div class="row ml-auto box justify-content-center">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h2><strong>What project are you estimating for?</strong></h2>
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
    
        @csrf
        <div class="row ml-auto box justify-content-center">
        <!-- <div class="row ml-auto mr-auto box justify-content-center"> -->
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><strong>A previously created project</strong></h5>
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
                        <h5 class="card-title"><strong>A new project</strong></h5>
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
                <!-- <input class="disabled" id="ext" type="submit" value="NEXT"> -->
                <button type="submit" class="btn" name="next_btn">NEXT</button>
            </div>
        </div>
</div>

</form>
@endsection

@section('script')
    
<script>
    let form = document.querySelector('#stage1');
    let form_children = {};
    ['old_project', 'new_project', 'previous_page', 'create_estimate', 'next_page', 'next_btn']
    .forEach(e=>form_children[e] = document.querySelector(`[name="${e}"]`));
    let {old_project, new_project, previous_page, create_estimate, next_page, next_btn} = form_children;

    window.onload=function(){
        ['keyup', 'click']
        .forEach(e=>form.addEventListener(e, validate));
    }

    function validate(){
        if(!falsy(old_project) || !falsy(new_project)) {
            next_page.disabled = false;
            next_btn.disabled = false;
            next_page.classList.add('validated');
            next_btn.classList.add('validated');
        }else{
            next_page.disabled = true;
            next_btn.disabled = true;
        }       
    }
    
    function falsy(el){
        if(typeof el.selected !== 'undefined'){
            if(el.selected != '' && el.selected !== 0 && el.selected == null) return false;
        }else if(typeof el.value !== 'undefined'){
            if(el.value !== '' && el.value !== 0 && el.value !== null) return false;
        }
        return true;
    }
    
    function verifyPath() {
        let a_next =  document.querySelector('.a-next');
        let next = document.querySelector('.next');
        let bt = document.getElementById('btne');


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
    
    </script>
@endsection

