<?php
session_start();
if ( !isset($_SESSION['userlogged']) || $_SESSION['userlogged'] != 1)
{
  header("Location: index.php");
}
 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title></title>
    <link rel="stylesheet" href= "styledashboardsidebar.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans&display=swap" rel="stylesheet">
  </head>
  <body>
    <!-- topbar-->
    <ul class="topnav" id= "main">
      <li class="right"><a href="index.php">Logout</a></li>
    </ul>

    <!-- sidebar-->
  <div class="sidenav">
    <img src = "uitm.jpg"/>
    <a href="dashboard.php" class = "btn"> Dashboard</a>
    <a href="clubs.php" class = "btn">Clubs</a>
    <a href="studentinfo.php" class = "btn">Student Info</a>
    <a class= "dropdown-btn btn active" style = "font-size: 25px;">Events
      <i class = "fa fa-caret-down"></i>
    </a>
    <div class = "dropdown-container" >
      <a href= "viewevent.php" style= "text-align: left;font-size: 18px;">Upcoming events</a>
      <a href= "pendingevent.php" style= "text-align: left;font-size: 18px;">Pending events</a>
      <a class = "btn" href= "historyevent.php" style= "text-align: left;font-size: 18px;">History events</a>
    </div>
    <a href="report.php" class = "btn">Report</a>
  </div>

  <!-- content -->
  <div class = "content">
    <form action = "pendingevent.php">
      <button type="submit" class="button"> Back</button>
    </form>
    <p style = "font-size: 30px;"><b>Event Details</b></p>
  </div>
    <!-- content -->
    <?php
      include ("connection.php");
      if ($_SESSION['norepeat']==0)
      {
          $eventcode =  $_POST['eventcode'];
          $_SESSION['eventcode'] = $eventcode;
          $_SESSION['norepeat'] = 1;
      }
      $sql = "SELECT * from events e JOIN clubs c ON c.clubCode = e.clubCode WHERE eventcode = '".$_SESSION['eventcode']."'";
      $result = mysqli_query($conn, $sql);
        if ($row = mysqli_fetch_assoc($result))
        {
            echo "<div style=width:100%;>
              <table class='table table-bordered table-striped' id= tablemeow>
                <tbody>
                  <tr>
                    <td style=width:15%;>Event name </td>
                    <td>".$row["eventname"]."</td>
                  </tr>
                  <tr>
                    <td style=width:15%;>Event venue </td>
                    <td>".$row["eventvenue"]."</td>
                  </tr>
                  <tr>
                    <td style=width:15%;>Event date </td>
                    <td>".date("jS M Y",strtotime($row["eventdate"]))."</td>
                  </tr>
                  <tr>
                    <td style=width:15%;>Event time start </td>
                    <td>".date("H:i",strtotime($row["timestart"]))."</td>
                  </tr>
                  <tr>
                    <td style=width:15%;>Event time end</td>
                    <td>".date("H:i",strtotime($row["timeend"]))."</td>
                  </tr>
                  <tr>
                    <td style=width:15%;>Merit</td>
                    <td>".$row["merit"]."</td>
                  </tr>
                  <tr>
                    <td style=width:15%;>Coupon quantity </td>
                    <td>".$row["couponq"]."</td>
                  </tr>
                  <tr>
                    <td style=width:15%;>Organizer</td>
                    <td>".$row["clubName"]."</td>
                  </tr>
                </tbody>
              </table>
            </div>";
            $_SESSION['eventcode'] = $row["eventcode"];
        }
      ?>

      <?php
      if (array_key_exists('approve', $_POST))
      {
        approved();
      }

      if (array_key_exists('reject', $_POST))
      {
        rejected();
      }

      function approved()
      {
          include ("connection.php");
          //$eventcode = $_SESSION['eventcode'];
          //$sql = "UPDATE events SET eventstatus = '2' WHERE eventcode = '".$eventcode."'";
          //$result = mysqli_query($conn, $sql);
          //mysqli_query($conn,$sql);
          echo "<script language = 'javascript'>alert('Event Accepted!');window.location='accEvent.php';</script>";
      }
      function rejected()
      {
          include ("connection.php");
        //$eventcode = $_SESSION['eventcode'];
        //$sql = "UPDATE events SET eventstatus = '3' WHERE eventcode = '".$eventcode."'";
        //$result = mysqli_query($conn, $sql);
        //mysqli_query($conn,$sqlupdate);
        echo "<script language = 'javascript'>alert('Event rejected!');window.location='rejected.php';</script>";
      }
       ?>

      <form method = "post" id = "btnrejectapprove">
        <button type= "submit" name ="approve" id = "approve" class = "btn btn-default" style = "background-color: #4CAF50;">Accept</button>
        <button type= "submit" name = "reject" id = "reject" class = "btn btn-default" style = "background-color: #f44336;" >Reject</button>
      </form>

  <!-- script -->
<script>
  /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
  var dropdown = document.getElementsByClassName("dropdown-btn");
  var i;

  for (i = 0; i < dropdown.length; i++)
  {
    dropdown[i].addEventListener("click", function()
    {
      this.classList.toggle("active");
      var dropdownContent = this.nextElementSibling;
      if (dropdownContent.style.display === "block")
      {
        dropdownContent.style.display = "none";
      }
      else
      {
        dropdownContent.style.display = "block";
      }
      });
  }

    $("button").click(function() {
      var fired_button = $(this).val();
      alert(fired_button);
  });
</script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js" integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7" crossorigin="anonymous"></script>
  </body>
</html>
