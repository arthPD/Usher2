<?php  
  require('rb.php');
  R::setup( 'mysql:host=localhost;dbname=db_ch2', 'root', '' );
  session_start();
?>
<!DOCTYPE html>
<html>
  <title><?php echo $_SESSION['page'] ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="css/datepicker3.css">
  <link rel="stylesheet" type="text/css" href="css/inputmask.css">
  <script type="text/javascript" src="js/jquery-3.1.1.js"></script>
  <script type="text/javascript" src="js/angular.min.js"></script>
  <style>
    body {
        font-family: "Lato", sans-serif;
        transition: background-color .5s;
    }
    .active {
      background-color: #212121;
    }
    .sidenav {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        background-color: #111;
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 60px;
    }

    .sidenav a {
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        font-size: 25px;
        color: #818181;
        display: block;
        transition: 0.3s
    }

    .sidenav a:hover, .offcanvas a:focus{
        color: #f1f1f1;
    }

    .sidenav .closebtn {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
        margin-left: 50px;
    }

    #main {
        transition: margin-left .5s;
        padding: 16px;
    }

    @media screen and (max-height: 450px) {
      .sidenav {padding-top: 15px;}
      .sidenav a {font-size: 18px;}
    }
  </style>

  <body>
    <div id="mySidenav" class="sidenav">
      <!-- <img src="ag.png" class="img-responsive" height="150px" width="180px" style="margin-left:35px; margin-bottom: 2%"> -->
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <?php  
        if(isset($_SESSION['page']) && $_SESSION['page'] == 'Home'){
          echo "<a href='index.php' class='active'>Home</a>";
        }else{
          echo "<a href='index.php'>Home</a>";
        }
        if(isset($_SESSION['page']) && $_SESSION['page'] == 'Members'){
          echo "<a href='members.php' class='active'>Members</a>";
        }else{
          echo "<a href='members.php'>Members</a>";
        }
        if(isset($_SESSION['page']) && $_SESSION['page'] == 'Services'){
          echo "<a href='services.php' class='active'>Services</a>";
        }else{
          echo "<a href='services.php'>Services</a>";
        }
        if(isset($_SESSION['page']) && $_SESSION['page'] == 'Reports'){
          echo "<a href='reports.php' class='active'>Reports</a>";
        }else{
          echo "<a href='reports.php'>Reports</a>";
        }
        if(isset($_SESSION['page']) && $_SESSION['page'] == 'Account'){
          echo "<a href='account.php' class='active'>Account</a>";
        }else{
          echo "<a href='account.php'>Account</a>";
        }
      ?>
    </div>

    <div id="main">
      <span style="font-size:25px;cursor:pointer" onclick="openNav()"><i class="fa fa-bars"></i> Menu</span>

