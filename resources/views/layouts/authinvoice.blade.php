@extends('layouts.auth')

@section('styles')
<style>
/*Main page style by message*/

@import url(http://fonts.googleapis.com/css?family=Open+Sans);

:root{
    --primary-color: #091429;
    --secondary-color: #0ABAB5;
    --dark-color: #262626;
    --light-color: #B1B1B1;
}


   /****************************/
  /*------- main styles ------*/
 /****************************/


.text-primary{
    color: var(--primary-color) !important;
}
.text-secondary{
    color: var(--secondary-color) !important;
}
.text-dark{
    color: var(--dark-color) !important;
}
.text-light{
    color: var(--light-color) !important;
}
.bg-primary{
    background-color: var(--primary-color) !important;
}
.bg-secondary{
    background-color: var(--secondary-color) !important;
}
.bg-light{
    background-color: var(--light-color) !important;
}
.bg-dark{
    background-color: var(--dark-color) !important;
}
.btn{
    border: none !important;
    display: inline-block;
    position: relative;
    overflow: hidden;
    transition: all ease-in-out .5s;
}
.btn::after {
    content: "";
    display: block;
    position: absolute;
    top: 0;
    left: 25%;
    height: 100%;
    width: 40%;
    background-color: #000;
    border-radius: 50%;
    opacity: 0;
    pointer-events: none;
    transition: all ease-in-out 1s;
    transform: scale(5, 5);
}
.btn:active::after {
    padding: 0;
    margin: 0;
    opacity: .2;
    transition: 0s;
    transform: scale(0, 0);
}
.btn-primary{
    background-color: var(--primary-color) !important;
}
.btn-secondary{
    background-color: var(--secondary-color) !important;
}
.btn-primary-outline{
    background-color: transparent !important;
    color: var(--primary-color)  !important;
    border: 1px solid var(--primary-color)  !important;
}
.btn-secondary-outline{
    background-color: transparent !important;
    color: var(--secondary-color)  !important;
    border: 2px solid var(--secondary-color)  !important;
}
.btn-primary:hover, .btn-secondary:hover, .btn-primary-outline:hover, .btn-secondary-secondary:hover{
    border-color: inherit !important;
    opacity: 0.8 !important;
}

/*------Nav bar---------*/
a,
a:hover,
a:focus {
  color: inherit;
  text-decoration: none;
  transition: all 0.3s;
}
.navbar {
  padding-top: 0px;
  padding-bottom: 0px;
  background-color: #fff;
  border: none;
  border-radius: 0;
  margin-bottom: 10px;
  box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
}
.navbar-btn {
  box-shadow: none;
  outline: none !important;
  border: none;
}
.navbar-nav .nav-item .nav-link:hover{
  transition: 0.25s;
  background-color: #ecf3ff;
}
.line {
  width: 100%;
  height: 1px;
  border-bottom: 1px dashed #ddd;
  margin: 40px 0;
}

.wrapper #content{

}
/* ---------------------------------------------------
    SIDEBAR STYLE
----------------------------------------------------- */
.wrapper {
  display: flex;
  width: 100%;
  align-items: stretch;
  perspective: 1500px;
}
#sidebar {
  min-width: 250px;
  max-width: 250px;
  background: var(--primary-color);
  color: #fff;
  transition: all 0.6s cubic-bezier(0.945, 0.020, 0.270, 0.665);
  transform-origin: bottom left;
}
#sidebar.active {
  margin-left: -250px;
  transform: rotateY(100deg);
}
#sidebar .sidebar-header {
  padding: 20px;
  background: var(--primary-color);
}
#sidebar ul.components {
  padding: 20px 0;
  border-bottom: 1px solid var(--primary-color);
}
#sidebar ul p {
  color: #fff;
  padding: 10px;
}
#sidebar ul li a {
  padding: 10px;
  font-size: 1em;
  font-weight: 600;
  display: block;
  transition: 0.4;
}
#sidebar ul li a:hover {
  color: #ffffff;
  background: rgba(19, 41, 82, 1);
}
#sidebar ul li a img {
    margin-top: -4px !important;
    margin-left: 4px;
    margin-right: 4px;
}
#sidebar.active ul li a span {
    vertical-align: text-bottom !important;
}
#sidebar ul li.active > a,
a[aria-expanded="true"] {
  color: #fff;
  background: rgba(19, 41, 82, 1);
}
a[data-toggle="collapse"] {
  position: relative;
}
.dropdown-toggle::after {
  display: block;
  position: absolute;
  top: 50%;
  right: 20px;
  transform: translateY(-50%);
}
ul ul a {
  font-size: 0.9em !important;
  padding-left: 30px !important;
  background: rgba(19, 41, 82, 1);;
}
ul.CTAs {
  padding: 20px;
}
ul.CTAs a {
  text-align: center;
  font-size: 0.9em !important;
  display: block;
  border-radius: 5px;
  margin-bottom: 5px;
}
a.download {
  background: #fff;
  color: #7386D5;
}
a.article,
a.article:hover {
  background: rgba(19, 41, 82, 1) !important;
  color: #fff !important;
}
/* ---------------------------------------------------
    CONTENT STYLE
----------------------------------------------------- */
#content {
  width: 100%;
  min-height: 100vh;
  transition: all 0.3s;
}
#sidebarCollapse {
  width: 40px;
  height: 40px;
  background: #f5f5f5;
  cursor: pointer;
}
#sidebarCollapse span {
  width: 80%;
  height: 2px;
  margin: 0 auto;
  display: block;
  background: #555;
  transition: all 0.8s cubic-bezier(0.810, -0.330, 0.345, 1.375);
  transition-delay: 0.2s;
}
#sidebarCollapse span:first-of-type {
  transform: rotate(45deg) translate(2px, 2px);
}
#sidebarCollapse span:nth-of-type(2) {
  opacity: 0;
}
#sidebarCollapse span:last-of-type {
  transform: rotate(-45deg) translate(1px, -1px);
}
#sidebarCollapse.active span {
  transform: none;
  opacity: 1;
  margin: 5px auto;
}
/* ---------------------------------------------------
    MEDIAQUERIES
----------------------------------------------------- */
@media (max-width: 768px) {
  #sidebar {
    margin-left: -250px;
    transform: rotateY(90deg);
  }
  #sidebar.active {
    margin-left: 0;
    transform: none;
  }
  #sidebarCollapse span:first-of-type,
  #sidebarCollapse span:nth-of-type(2),
  #sidebarCollapse span:last-of-type {
    transform: none;
    opacity: 1;
    margin: 5px auto;
  }
  #sidebarCollapse.active span {
    margin: 0 auto;
  }
  #sidebarCollapse.active span:first-of-type {
    transform: rotate(45deg) translate(2px, 2px);
  }
  #sidebarCollapse.active span:nth-of-type(2) {
    opacity: 0;
  }
  #sidebarCollapse.active span:last-of-type {
    transform: rotate(-45deg) translate(1px, -1px);
  }
}

/* ---------------------------------------------------
    Table
----------------------------------------------------- */
table.project-table{
  border-collapse:separate; 
  border-spacing: 0 1em;
}

table.project-table tbody tr{
  padding-bottom: 10px !important;
}

table.project-table tbody tr td span.text-small{
  font-size: 8px;
} 

table.project-table tbody tr td, table.project-table thead tr th {
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.dropleft .dropdown-toggle::before{
  display: none;
}

/*------------floating button---------*/
#add-something{
  position: fixed;
  bottom: 20px;
  right: 20px;
  z-index: 12;
}
.create-invoice {
    width: 13rem;
    height: 3.5rem;
    background: #0ABAB5;
    color: white;
    border: none;
    font-size: 16px;
    text-align: center;
    margin-left: 0px;
    margin-top: 40px;
    margin-bottom: 20px;
}

.container {
    width: 100%;
    padding-right: 20px;
    padding-left: 20px;
    margin: 0px;
}
</style>
@endsection


@section('content')
    
<div class="wrapper">
     <!-- Side Nav -->
    <nav id="sidebar">
        <div class="sidebar-header">

        <a href="{{ url('dashboard') }}"><img src="https://lancer-app.000webhostapp.com/images/svg/Lancers.svg" height="35" width="auto" class="img img-responsive"></a>

        </div>
        <ul class="list-unstyled components">
            <li class=" @if(request()->path() == 'dashboard') active @endif">
                <a href="{{url('dashboard')}}">
                    <img src="https://lancer-app.000webhostapp.com/images/svg/home.svg" height="20" width="auto"> <span> Dashboard</span></a>
            </li>
            <li class=" @if(request()->path() == 'clients') active @endif">
                <a href="{{url('clients')}}">
                    <img src="https://lancer-app.000webhostapp.com/images/svg/customer.svg" height="20" width="auto"> <span> Client</span>
                </a>
            </li>
            <li class="@if(request()->path() == 'project/status') active @endif">
                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><img src="https://lancer-app.000webhostapp.com/images/svg/lightbulb.svg" height="20" width="auto"> <span> Projects</span></a>
                <ul class="collapse list-unstyled " id="homeSubmenu">
                    <li>
                        <a href="{{url('project/status')}}" class="pl-4"><i class="fas fa-dot-circle"></i> Status</a>
                    </li>
                    <li>
                        <a href="{{url('project/overview')}}" class="pl-4"><i class="fas fa-dot-circle"></i> Overview</a>
                    </li>
                    <li>
                        <a href="{{url('project/collabrators')}}" class="pl-4 "><i class="fas fa-dot-circle"></i> Collabrators</a>
                    </li>
                    <li>
                        <a href="{{url('project/task')}}" class="pl-4"><i class="fas fa-dot-circle"></i> Task</a>
                    </li>
                    <li>
                        <a href="{{url('project/documents')}}" class="pl-4"><i class="fas fa-dot-circle"></i> Documents</a>
                    </li>
                    
                </ul>
            </li>
            <li class="@if(request()->path() == 'invoice') active @endif">
                <a href="{{url('invoice')}}">
                    <img src="https://lancer-app.000webhostapp.com/images/svg/approve-invoice.svg" height="20" width="auto"> <span> Invoice</span>
                </a>
            </li>
            <li>
                <a href="{{url('contract')}}">
                    <img src="https://lancer-app.000webhostapp.com/images/svg/policy.svg" height="20" width="auto"> <span> Contract</span>
                </a>
            </li>
            <li>
                <a href="{{url('proposals')}}">
                    <img src="https://lancer-app.000webhostapp.com/images/svg/approval.svg" height="20" width="auto"> <span> Proposals</span>
                </a>
            </li>
        </ul>
    </nav>




    <!-- Page Content Holder -->
    <div id="content">
        <!-- <Topnav /> -->
         <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-left mt-2 mt-lg-0 ">
            <li class="nav-item ml-3 @if(request()->path() == 'invoice') active @endif">
              <a class="nav-link " href="{{url('invoice')}}">Project Info <span class="sr-only">(current)</span></a>
            </li>
          
            <li class="nav-item @if(request()->path() == 'client-info') active @endif">
              <a class="nav-link" href="{{url('client-info')}}">Client Info </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Settings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Tools & Resources</a>
            </li>
          </ul>
        </div>
      </nav> 
        @yield('main-content')
    </div>

</div> 
@endsection