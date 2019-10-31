@extends('layouts.auth')
@section('style-ext')
    <link type="text/css" rel="stylesheet" href="{{ asset('css/tasks.css') }}" />
@endsection


@section('main-content')
    <section class="">
        <div class="container-fluid">
            <div class="">
                <h1 style="margin-top: 15px;">Edit Collaborator </h1>
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

                <div class="row justify-content-center">
                    <div class="col-md-8">

                     <form method="post" action="  {{ url('/')}}/project/collaborator/update/{{ $collabo->id }}">
                {!! csrf_field() !!}
                    <div class="modal-body">                       
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Select Project:</label>
                                    <select required class="form-control" name="project_id" id="selectProject">
                                        <option>Select Project</option>
                                        @foreach($projects as $project)
                                        <option value="{{$project->id}}" {{($collabo->project_id == $project->id) ? 'selected' : ''}}>{{$project->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Select Collaborator: </label>
                                    <select required class="form-control" name="user_id" id="selectProject">
                                        <option> Add Collaborator </option>
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}"  {{($collabo->user_id == $user->id) ? 'selected' : ''}} >{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Specify Role:</label>
                            <input type="text" value="{{ $collabo->role }}" required name="role" maxlength="20" class="form-control" id="message-text">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary modal-save">Save changes</button>
                    </div>
                </form>

                    </div>

                </div>
                
            </div>
        </div>
    </section>
@endsection


@section('others')
    {{--  <button class="btn btn-secondary text-white rounded-circle" id="add-something">
        <i class="fas fa-plus"></i>
    </button>
    
    <button class="btn btn-secondary text-white rounded-circle" id="add-something" data-toggle="modal"
        data-target="#myModal">
        <i class="fas fa-plus"></i>
    </button>  --}}
    <div class="modal" tabindex="-1" role="dialog" id="myModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Add New Collaborator</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="{{url('project/collaborator/create')}}">
                {!! csrf_field() !!}
                    <div class="modal-body">                       
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Select Project:</label>
                                    <select required class="form-control" name="project_id" id="selectProject">
                                        <option>Select Project</option>
                                        @foreach($projects as $project)
                                        <option value="{{$project->id}}">{{$project->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Select Collaborator: </label>
                                    <select required class="form-control" name="user_id" id="selectProject">
                                        <option> Add Collaborator </option>
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Specify Role:</label>
                            <input type="text" required name="role" maxlength="20" class="form-control" id="message-text">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary modal-save">Save changes</button>
                        <button type="submit" class="btn btn-primary modal-close" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
            if(selectStatus.value == 'all') window.location.href="/project/collaborators";
            else window.location.href="/project/collaborators?filter="+selectStatus.value;
        }, false)
    </script>
@endsection