@extends('layouts.auth')
@section('style-ext')
    <link type="text/css" rel="stylesheet" href="{{ asset('css/tasks.css') }}" />
@endsection


@section('main-content')
    <section class="">
        <div class="container-fluid">
            <div class="">
                <h1 style="margin-top: 15px;">Edit Task </h1>
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

            
                
                <form method="post" action="{{url('task/update')}}/{{ $task->id }}">
                    @csrf
                    <div class="modal-body">                       
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Select Project:</label>
                                    <select required class="form-control" name="project_id" id="selectProject">
                                        <option>Select Project</option>
                                        @foreach($projects as $project)
                                        <option required value="{{$project->id}}" {{($task->project_id == $project->id) ? 'selected' : ''}}>{{$project->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Add Collaborator: </label>
                                    <select required class="form-control" name="user_id" id="selectProject">
                                        <option> Select Collaborator </option>
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}" {{($task->user_id == $user->id) ? 'selected' : ''}}>{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                         <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">

                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Task:</label>
                            <input required type="text" value="{{ $task->title }}" name="title" class="form-control" id="message-text">
                        </div>

                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">

                        <div class="form-group">
                                    <label for="Status" class="col-form-label">Select Status </label>
                                    <select name="status" class="form-control">
                                        @foreach($statuses as $key => $value)
                                    <option value="{{$key}}" {{($task->status == $key) ? 'selected' : ''}}>{{$value}}</option>
                                        @endforeach
                                    </select>
                        </div>

                        </div>
                        
                        </div>
                        <div class="form-group">
                            <label for="desc" class="col-form-label">Desciption:</label>
                            <textarea required name="description" class="form-control" id="desc">{{ $task->title }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                        <label for="start" class="col-form-label">Start Date:</label>
                                        <input required type="date" value="{{ $task->start_date }}" name="start_date" class="form-control" id="start">
                                    
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                        <label for="end" class="col-form-label">End Date:</label>
                                        <input required type="date" value="{{ $task->due_date }}" name="due_date" class="form-control" id="end">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary modal-save">Save changes</button>
                        <a href="{{ url('/') }}/project/tasks" class="btn btn-primary" >Back</a>
                    </div>
                </form>

                    </div>

                </div>
                
            </div>
        </div>
    </section>
@endsection


@section('others')

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