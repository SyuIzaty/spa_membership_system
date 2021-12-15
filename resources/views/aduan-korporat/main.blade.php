@extends('layouts.public')

@section('content')
<script src="https://kit.fontawesome.com/5c6c94b6d7.js" crossorigin="anonymous"></script>

<style>
    /* @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@600&display=swap'); */
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@700&display=swap');

    .title{
        font-family: 'Sora', sans-serif;
        font-size: 30px;
        
    }

/* .container {
  width: 800px;
  height: 250px;
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  margin: auto;
  box-sizing: border-box;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  grid-template-rows: 1fr;
  grid-gap: 15px;
} */

.items {
  border-radius: 20px;
  display: grid;
  grid-template-rows: 2fr 1fr;
  grid-gap: 10px;
  cursor: pointer;
  border: 3px dotted black;
  transition: all 0.6s;
  margin: 5px;
  background-color: white;
}

.icon-wrapper, .project-name {
  display: flex;
  align-items: center;
  justify-content: center;
}

.icon-wrapper i {
  font-size: 50px;
  color: #ff0000;
  transform: translateY(0px);
  transition: all 0.6s;
}

.icon-wrapper {
  align-self: end;
}

.project-name {
  align-self: start;
}

.project-name p {
  font-size: 15px;
  font-weight: bold;
  letter-spacing: 2px;
  color: #030303;
  transform: translateY(0px);
  transition: all 0.5s;
}

.items:hover {
  border: 3px solid #E5E6F1;
}
.items:hover .project-name p {
  transform: translateY(-10px);
}
.items:hover .icon-wrapper i {
  transform: translateY(5px);
}
    
</style>
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg4.jpg')}}); background-size: cover">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background-size: cover">
                    <div class="d-flex justify-content-center" style="color: black">
                        <div class="p-2">
                            <center><img src="{{ asset('img/intec_logo_new.png') }}" style="height: 120px; width: 320px;" class="responsive"/></center><br>
                            <h1 style="text-align: center" class="title">
                                i-Complaint
                            </h1>
                        </div>
                    </div>
                </div>
                
                <div class="card-body" style="background-color: #d3d3d366;">
                    <div style="margin-bottom: 100px;"></div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-6" style="padding: 0 80px">
                                        <div>
                                            <a href="/form">
                                                <div class="items">
                                                    <div class="icon-wrapper">
                                                        <span><i class="fas fa-plus-square"></i></span>                                           
                                                    </div>
                                                    <div class="project-name">
                                                        <p>CREATE NEW</p>
                                                    </div>
                                                </div>
                                            </a> 
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6" style="padding: 0 80px">
                                        <a href="/lists">
                                            <div class="items">
                                                <div class="icon-wrapper">
                                                    <span><i class="fas fa-search"></i></span>                                           
                                                </div>
                                                <div class="project-name">
                                                    <p>CHECK</p>
                                                </div>
                                            </div>
                                        </a> 
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div style="margin-bottom: 100px;"></div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('script')
    <script>

    </script>
@endsection
