<!DOCTYPE html>
<html>
<head>
	<title> Registration </title>
  <link rel="stylesheet" type="text/css" href="assets/css/registration style.css ">

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
</head>

<body style="background-color: #0BE881">


	<div class="registration"> REGISTRATION </div><br>
	<a class="button" href="{{ ('/home') }}"> Go Back </a>
	<br>
<form method="POST" action="{{ url('register') }}">>
{{ csrf_field() }}
  <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-2">
          <div class="card-body">
            <img src="assets/img/school logo.png" class="schoollogo">

<center><b style="color: red; "></center>
                @if(!empty($message))
                  {{ $message }}
                @endif
              </b>

    <hr>

  <label for="name"><b>Full Name</b></label>
    <input type="text" placeholder="Enter Full Name" name="name" required>


    <label for="email"><b>ID Number</b></label>
    <input type="text" placeholder="Enter ID Number" name="id" required>

    <label for="email"><b>Username</b></label>
    <input type="text" placeholder="Username" name="email" required>


    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>


    <hr>

    <button type="submit" class="registerbtn">Register</button>


  </div>
</form>

</body>
</html>
