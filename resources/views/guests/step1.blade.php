@extends('layouts.app')
<!-- Select Project -->

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('css/step1.css')}}"/>
@endsection

@section('content')
@include('partials.header_stage1')

<div class="contaner">
    <div class="clearfix"></div>
    <br/>  <br/>

    <h3 class="text-center"><strong>What project are you estimating?</strong></h3>
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
                        <h5 class="card-title"><strong>A new project</strong></h5>
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
                <!-- <input class="disabled" id="ext" type="submit" value="NEXT"> -->
                <button type="submit" class="btn" id="extL" name="next_btn">NEXT</button>
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
        if(!falsy(old_project) && !falsy(new_project)) {
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

