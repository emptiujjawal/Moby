<!DOCTYPE html>
<html lang="en">
<?php 
include("header_home.php");

?>
<body>
<div class="container col-sm-10 col-sm-offset-1">
<?php
  include("navbar_home.php");
?>
  <div class="container-fluid text-center" id="main_content">    
    <div class="row content">
      <div class="col-sm-8">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
          
          <center>
          <!-- Wrapper for slides -->
          <div class="carousel-inner ">
            <div class="item active">
              <img src="images/slider/img1.png" alt="IMG_1" style="width:300px; border: 5px solid #ddd;">
            </div>
            <div class="item">
              <img src="images/slider/img2.png" alt="IMG_2" style="width:300px; border: 5px solid #ddd;">
            </div>
            <div class="item">
              <img src="images/slider/img3.png" alt="IMG_3" style="width:300px; border: 5px solid #ddd;">
            </div>
            <div class="item">
              <img src="images/slider/img4.png" alt="IMG_4" style="width:300px; border: 5px solid #ddd;">
            </div>
            <div class="item">
              <img src="images/slider/img5.png" alt="IMG_5" style="width:300px; border: 5px solid #ddd;">
            </div>
          </div>
          </center>
          <!-- Left and right controls -->
          <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
      <div class="col-sm-4 text-info">
        <div class="well text-info">
          <h4>To Create Ad </h4>
          <a href="?LOGIN" class="btn btn-danger">Login</a>
        </div>
        <div class="well text-info">
          <h4>Download</h4>
          <a href="app/android/moby4.apk" target="_blank"><img src="images/misc/android.png" style="width: 100%;"></a>
        </div>
        <div class="well text-info">
          <h4>How It Work</h4>
        </div>
      </div>
    </div>
  </div>

  <?php
  include("footer_home.php")
  ?>

</div>

</body>
</html>