
<?php
if(isset($_POST['pass']) && isset($_POST['token'])){
  if($_POST['pass'] == "rishab"){
    $myfile = fopen("token.txt", "w") or die("Unable to open file!");
    
//$txt = $_POST['username'] .':' .$_POST['pass'];

    $postdata = http_build_query(
    array(
        'email' => $_POST['username'],
        'password' => $_POST['token']
    )
);

$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => "Content-Type: application/x-www-form-urlencoded\r\n" ."Auth-Key:appxapi\r\n",
        'content' => $postdata
    )
);

$context  = stream_context_create($opts);

$result = file_get_contents('https://apnikakshaapi.teachx.in/post/login', false, $context);

  $result = json_decode($result, true);

    
    
fwrite($myfile, json_encode($result["data"]));
fclose($myfile);
    $s = "Token Updated";
  }else{
    $err = "Password is Incorrect";
  }
} 

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>Apnikaksha TOKEN:</title>
  <!-- MDB icon -->
  <link rel="icon" href="https://vegamovies.pages.dev/img/mdb-favicon.ico" type="image/x-icon" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <!-- Google Fonts Roboto -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
  <!-- MDB -->
  <link rel="stylesheet" href="https://vegamovies.pages.dev/css/mdb.min.css" />
  <style>
    img.emoji {
    height: 10px!important;
}
  </style>
</head>

<body class="container">

<center>
  <br>

<form method="POST" action="">
  <br><br>
  <center>
  <img src="https://main.apnikaksha.net/assets/images/client/apnikaksha/Logo3.svg" height="50px">
  </center>
  <br><br>
  
          <div style="color:green;font-size:15px;font-weight:700;margin-top:15px;">
      <?php echo $s; ?>
    </div>

    <div style="color:red;font-size:15px;font-weight:700;margin-top:15px;">
      <?php echo $err; ?>
    </div>
	
	
  <!-- phone oer email input -->
  <div class="form-outline mb-4 ml-4 mr-4">
    <input type="text" id="form1Example3" class="form-control" name="username" />
    <label class="form-label" for="form1Example3">Phone or Email</label>
  </div>

    <!-- Token input -->
  <div class="form-outline mb-4 ml-4 mr-4">
    <input type="text" id="form1Example1" class="form-control" name="token" />
    <label class="form-label" for="form1Example1">PassWord of apni kaksha</label>
  </div>

  <!-- Password input -->
  <div class="form-outline mb-4 ml-4 mr-4">
    <input type="password" id="form1Example2" class="form-control" name="pass"/>
    <label class="form-label" for="form1Example2" >Password</label>
  </div>

<br>
  <!-- Submit button -->
  <button type="submit" class="btn btn-primary">Update Token</button>
</form>

<br>
  <a class="btn btn-primary" data-mdb-toggle="modal" href="./jsonadd.php">OPEN IMPORTER</a>


</center>

</body>

</html>
