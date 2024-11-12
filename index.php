<?php
include "connection/connection.php";
$date = date("Y-m-d");
$l = "SELECT * From events";
$ll = mysqli_query($conn,$l);
while($row = mysqli_fetch_assoc($ll)){
  $eventdate = $row['date'];
  $eventId = $row['id'];
  if($eventdate < $date){
    $up = "UPDATE `events` SET `status`='finished' WHERE `id` = $eventId";
    $res = mysqli_query($conn,$up);
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="out/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>
    
<style>
  .logo img{
    height: 80px;
    width:80px;
  }
</style>

<header class="header">
    <div class="b">
    </div>
    <br><br>
  <div class="container">
    <div class="logo">
      <img src="logo.png" alt="SkillLink Logo">
    </div>
    <nav>
      <ul class="menu">
        <li><a href="#home">Home</a></li>
        <li><a href="#about">About Us</a></li>
        <li><a href="#benefit">Benefits</a></li>
        <li><a href="#event">Events</a></li>
        <li><a href="#reviews">Reviews</a></li>
      </ul>
    </nav>
    <div class="buttons">
      <a href="log/login.php" class="login-button">Login</a>
      <a href="log/register.php" class="get-started-button">Get Started</a>
    </div>
  </div>
</header>

<section class="home" id="home">
  <div class="container">
    <div class="home-content">
      <div class="home-left">
        <h2 class="home-title">Unleash Your <span>Skills</span>,<br> <span>Find</span> Your Future<br> Dream <span>Job</span></h2>
        <p class="home-description">Our goal is to provide a space where individuals can<br> monetize their skills and connect with employers<br> seeking skilled professionals.</p>
        <a href="#" class="learn-more-button">Learn More</a>
      </div>
      <div class="home-right">
        <img src="out/images/image1.jpg" alt="Rounded Image" class="rounded-image">
      </div>
    </div>
  </div>
 
  <section class="about" id="about">
  <div class="container">
    <div class="about-content">
      <div class="about-left">
        <h2 class="about-title"><span>About </span>Us and Our <span> Motivation</span><br> for this Website</h2>
        <p class="about-description">- At SkillLink, our motivation is to bridge this gap and <br>create a platform that recognizes and empowers <br> people's unique skills.</p>
        <p class="about-description">- We believe that everyone should have equal <br>opportunities to showcase their talents and find <br>meaningful work, regardless of formal certifications <br>or degrees.</p>
      </div>
      <div class="about-right">
        <img src="out/images/image2.jpg" alt="About Us Image" class="rounded-image">
      </div>
    </div>
  </div>
</section>

<section class="benefits" id="benefit">
  <div class="container">
    <h2 class="benefits-title">The Benefits You Get When <br> You Work at SkillLink</h2>
    <div class="benefits-grid">
      <div class="benefit" style="background-color: #FF9B26;">
        <h3 class="benefit-title">Showcase Skills & <br> Get Hired</h3>
        <p class="benefit-description">Stand out from the crowd and <br>showcase your unique talents to a <br>network of potential employers <br>seeking skilled individuals</p>
      </div>
      <div class="benefit" style="background-color: #0166FF;">
        <h3 class="benefit-title">Affordable Rates & <br>Flexible Work</h3>
        <p class="benefit-description">Set your desired rates, find flexible<br> work arrangements, and gain control <br>over your career path
</p>
      </div>
      <div class="benefit" style="background-color: #FF9B26;">
        <h3 class="benefit-title">Inclusive Platform <br>No Degree Required</h3>
        <p class="benefit-description">Skill-Link values your skills and <br>experience, regardless of traditional<br> qualifications. Find opportunities that<br> match your worthy abilities</p>
      </div>
    </div>
  </div>
</section>

<section class="events" id="event">
  <div class="event">
    <center>
    <h2 class="event-title">Upcoming Events</h2>
    </center>
  </div>
  <div class="event-container">
   
  <?php
session_start();
include "connection/connection.php";

$r = "SELECT * FROM events Where `status` like  'up%' and `type` like 'pu%'";
$s = mysqli_query($conn, $r);
if($s){

while ($row = mysqli_fetch_assoc($s)) {
    $id = $row['id'];
    $name = $row['eventCreator'];
    $title = $row['eventName'];
    $desc = $row['description'];
    $date = $row['date'];
    $location = $row['location'];
    $seats = $row['seats'];
    $type = $row['type'];
    $status = $row['status'];

    echo "<div class='rectangle-active'>";
    echo "<h3 class='event-name'>$title</h3>";
    echo "<p class='event-descriptionn'>$desc</p>";
    echo "<p class='event-location' style=color:red;>$location</p>";
    echo "<p class='event-date'>$date</p>";
    echo"<br><br><br><br><br>";
    echo "<div class='creator-profile'>";
    echo "<p class='creator-name'>$name</p>";
    echo "</div>";
    echo "</div>";
    }
    echo "</div>";
}else{
  echo"<center><h1>There is no upcoming events Now</h1></center>";
}
?>
    
  </div>
</section>
<section class="reviews" id="reviews">
  <div class="container">
    <h2 class="reviews-title">What Our Users Say</h2>
    <div class="reviews-grid">

  <?php
  $s = "SELECT * FROM skilllink_reviews ORDER BY `date` DESC";
  $res = mysqli_query($conn, $s);
  
  if ($res) { 
    while ($row = mysqli_fetch_assoc($res)) {
      $name = $row['username'];
      $review = $row['review'];
      $date = $row['date'];
      $t = "SELECT * FROM cats c, user u WHERE u.cat = c.id and u.username = '$name'";
      $result = mysqli_query($conn, $t);
      
      if ($result) { 
        while ($roww = mysqli_fetch_assoc($result)) {
          $catname = $roww['name'];
          echo "<div class='review'>";
          echo "<h3 class='review-name'>$name</h3>";
          echo "<h4 class='category'>$catname</h4>";
          echo "<p class='review-description'>$review</p>";
          echo "<p>$date</p>";
          echo "</div>";
        }
      } else {
        echo "Error in inner query: " . mysqli_error($conn);
      }
    }
  } else {
    echo "Error in outer query: " . mysqli_error($conn);
  }
  ?>
</div>
  </div>
</section>

<section class="footer">
                    <div class="social">
                        <a href="https://www.facebook.com/baraa.marchoud" class="fab fa-facebook"></a>
                        <a href="https://x.com/BaraaMarchoudd" class="fab fa-twitter"></a>
                        <a href="https://www.instagram.com/baraa_marchoud/?hl=en" class="fab fa-instagram"></a>
                        <a href="https://wa.me/+96176152249" class="fab fa-whatsapp"></a>


                    </div>

                    <div class="links">
                    <a href="#home">Home</a>
                    <a href="#about">About Us</a>
                    <a href="#benefit">Benefits</a>
                    <a href="#event">Events</a>
                    <a href="#reviews">Reviews</a>
                    </div>

                    <div class="projectmanagers"><span>Created by</span> | Baraa Marchoud</div>


                </section>


<style>
  </style>

<script src="out/script.js"></script>
</body>
</html>