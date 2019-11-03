@extends('layouts.app')

@section('title', 'Client Active')

@section('content')

<div id="container">
        <div>
            <button class="close navM" @click.prevent="$router.push('/estimate')"> <span>
                    <i class="fa fa-times navM"></i>
                </span></button>
        </div>
        <div>
            <button class="close " @click.prevent="previous"> <span>
                    <i class="fa fa-chevron-left navM"></i>
                </span> </button>
        </div>
        <div>
            <p class=" nav cEstimate" id="cre">Client</p>
        </div>
        <div>
            <input class="disabled" id="ext" type="button" value="CREATE INVOICE" @click.prevent="next">
        </div>
    </div>
@endsection

@section('style')
<style>
        body {
            font-family: 'Roboto', sans-serif;
            overflow: auto;
        }
        h1 {
            margin-top: 5%;
            margin-left: 18%;
            color: #262626;
        }
        h5 {
            font-weight: bold;
            color: #262626;
        }
        /*navbar css*/
        #container {
            display: grid;
            grid-template-columns: 1fr 1fr 8fr 2fr;
        }
        /*changed this*/
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
            background:  #0ABAB5;
            font-size: 17px;
            font-weight: bold;
            justify-content: center;
            border: none;
            color: white;
            width: 100%;
            height: 60px;
            outline: none;
            /*added outline none*/
        }
        /* div>#ext:hover {
            background: rgb(9, 206, 199);
        } */
        /*changed this from clear to close*/
        div>.close {
            outline: none;
        }
        .close {
            color: #C4C4C4;
            width: 100%;
        }
        .navM {
            padding-top: 15px;
        }
        /*end of nav bar*/
        @media (max-width: 976px) {
            div>#ext{
                font-size: 15px;
            }
        }
     
        
    </style>
@endsection