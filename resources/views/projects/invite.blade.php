@extends('layouts.auth')
@section('style-ext')
    <link type="text/css" rel="stylesheet" href="{{ asset('css/tasks.css') }}" />
@endsection


@section('main-content')
    <section class="">
        <div class="container-fluid">
            <div class="">
                <h1 style="margin-top: 15px;">Tasks </h1>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('errors'))
                    <div class="alert alert-danger">
                        {{ session('errors') }}
                    </div>
                @endif
                <!-- @if (!empty($errors))
                <span class='help-block'>
                    <strong>{{ "Some input field is not properly filled" }}</strong>
                </span>
                @endif -->
                <div style=" background-color: #091429;">
                    <ul class="navi-ul">
                        <!-- <li class="navi-links"><a href="#">Overview</a></li> -->
                        <li class="navi-links"><a href="{{url('project/collaborators')}}">Collaborators</a></li>
                        <li class="navi-links"><a href="{{url('project/tasks')}}">Task</a></li>
                        <li class="navi-links navi-active"><a href="javascript:void(0)">Invite</a></li>
                        <!-- <li class="navi-links"><a href="#">Documents</a></li> -->
                    </ul>
                </div>
                <div class="table-responsive">
                <form action="{{ url('project/invite') }}" 
                    method="post">{{ csrf_field() }}
                    <input type="email" name="email" />
                    <button type="submit">Invite</button>
                </form>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('script')
    <script>
        // $(document).ready(function () {
        //     $('#sidebarCollapse').on('click', function () {
        //         $('#sidebar').toggleClass('active');
        //         $(this).toggleClass('active');
        //     });

        //     $('#myModal').on('shown.bs.modal', function () {
        //         $('#myInput').trigger('focus')
        //     });
        //     $('.table-responsive').on('show.bs.dropdown', function () {
        //         $('.table-responsive').css( "overflow", "inherit" );
        //     });

        //     $('.table-responsive').on('hide.bs.dropdown', function () {
        //         $('.table-responsive').css( "overflow", "auto" );
        //     })
                    
        // });


        let selectStatus = document.querySelector('#select-filter');
        selectStatus.addEventListener('change', function(){
            // this.form.action = "/projects?status="+selectStatus.value;
            // this.form.submit();
            if(selectStatus.value == 'all') window.location.href="/project/invite";
            else window.location.href="/project/invite?filter="+selectStatus.value;
        }, false)
    </script>
@endsection