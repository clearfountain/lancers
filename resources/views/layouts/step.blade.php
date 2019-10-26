@extends('layouts.app')

@section('styles')
  <style>
      /*navbar css*/
     #containere {
                display: grid;
                grid-template-columns: 1fr 8fr 2fr;
            }
            /*changed this*/
            #containere div {
                box-shadow: 0px 4px 2px rgba(0, 0, 0, 0.1);
                outline: none;
                height: 60px;
            }
            #containere p {
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
            
            /*changed this from clear to close*/
            div>.close {
                outline: none;
            }
            .close {
                color: #C4C4C4;
                width: 100%;
            }
    /*end of nav bar*/
  </style>

@stack('styles')
@endsection


@section('content')
<div id="containere">
        <div>
            <button class="close navM" ><a href="{{ url('/') }}"><span>
                    <i class="fa fa-times"></i>
                  </span></a></button>
        </div>
        <div>
            <p class="nav cEstimate" id="cre">Create Estimate</p>
        </div>
        <div>

            <input class="next disabled" id="ext" type="button"  value="NEXT" onclick="manage" id="btne" disabled>

        </div>
</div>
@endsection
