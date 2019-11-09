<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="emai.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>email</title>
</head>

<body>
   <!-- css-->
   <style>
   body{
    font-family: sans-serif;
    background: #f4f4f4;
}
.card {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    max-width: 600px;
    height: 70vh;
    margin: 100px auto;
    border: 4px solid #0ABAB5;
    padding-left: 50px;
    padding-right:15px;
    background: white;
}
  
.content{
    padding-top: 70px;
}
.logo{
    color: #3A3768;
    text-align: right;
    margin-right:60px;
}
span{
    color:#00F9FF;
}
p{
   font-size: 20px;
   color: rgb(78, 78, 78);
}
h1{
    font-weight: bold;
    text-align: left;
    font-size: 24px;
    color: #3A3768;
}
.button{
    background-color: #0ABAB5;
    font-size: 16px;
    padding: 13px 24px;
    color:white;
    border-radius: 5px;
    border:none;
    text-align: center;
    margin-left: 220px;
    cursor: pointer;
}
 
.button:hover {
    background-color: rgb(13, 212, 206); /* Green */
    color: white;
  }
   
   </style>
  
    
   
    
    
   
   
<div class="container">
<div class="card">
    <div class="logo">
            <h2>Lan<span>c</span>ers</h2>
    </div>
    <div class="content">
  <h1>Hi,</h1>

  <p>{{ $invite->user->name }} invited you to collaborate on a Lancer project.</p>
  <a href="{{ url('register') }}/{{ $invite->token }}"><button type="submit" class="button"> Click here</button></a> <br/> to register and start collaborating!
  <p>Thanks, <br>{{ config('app.name') }}</p> 
</div>
</div>

</div>

</body>


</html> 

