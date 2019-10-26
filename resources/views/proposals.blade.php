@extends('layouts.auth')

@section('main-content')
  <style>
    .proposal{
      width: 13rem;
      height: 3.5rem;
      background: #0ABAB5;
      color: white;
      border: none;
      font-size: 16px;
      text-align: center;
      margin-left: 0px;
      margin-top: 40px;
      margin-bottom: 20px
    }
  </style>
  <main class="container-fluid">
    <div class="main-container">  
        <div class="content">
          <button class='btn proposal'>Proposal</button>
          <h3>Proposals will be shown on this page</h3>
          <p>Proposal dummy page as requested, Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga illo perferendis enim non quia vel, quisquam magni illum? Aspernatur consectetur iusto quisquam, ipsa nostrum autem. Illum nihil magnam cumque autem?</p>
        </div>
    </div>
  </main>
@endsection