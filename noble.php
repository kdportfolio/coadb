<?php
require 'config.php';
if(!isset($_SESSION['accessToken']))
{
	header('Location: index.php');
	exit();
}
?><!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <title>Which noble person from history do you look like?</title>
            <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
            <script type="text/javascript" src="js/custom.js"></script>

      <style type="text/css">
      *
      {
        text-transform: none !important;
      }
      img
      {
        max-width: 100% !important;
      }
      </style>
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            appId            : '323788071575702',
            autoLogAppEvents : true,
            xfbml            : true,
            version          : 'v3.2'
          });
        };

        (function(d, s, id){
           var js, fjs = d.getElementsByTagName(s)[0];
           if (d.getElementById(id)) {return;}
           js = d.createElement(s); js.id = id;
           js.src = "https://connect.facebook.net/en_US/sdk.js";
           fjs.parentNode.insertBefore(js, fjs);
         }(document, 'script', 'facebook-jssdk'));
      </script>
    </head>

    <body>
        
      <div class="container" style="padding: 20px; margin: 0 auto; text-align: center;">
          
          
            <a href="index.php">
                <a href="https://coadb.com/"><img src="img/logo.png" style="max-width: 250px !important;"></a>
            </a>
            
      </div>

      <div class="container center" id="step_1">
        <h4>Which noble person from history do you look like?</h4>
        <h5>Select your gender</h5>
        <a class="waves-effect waves-light btn-large blue" attr-gender="male">Male</a>
        <a class="waves-effect waves-light btn-large blue" attr-gender="female">Female</a>
      </div>

      <div class="container center" id="step_2" style="display: none;">
        <h4>Select a photo of you (<span style="color: #555;">preferably a front facing photo with your face</span>)</h4>
        <?php
        $images_limit = 100;
        $response = $fb->get('/me/photos?fields=images{source},id&limit='.$images_limit.'&type=uploaded', $_SESSION['accessToken']);
        $results = $response->getGraphEdge();
        ?>
        
        <div class="img_data" style="max-height: 750px; overflow-y: scroll; overflow-x: hidden;">
          <?php
          foreach ($results as $result) {
            echo '
            <img src="'.$result['images'][0]['source'].'" style="max-height: 200px;" attr-photo="'.$result['images'][0]['source'].'"/>
            ';
          }
          ?>
              
        </div>
        <br>
         
        
        </div>
        
        

      <div class="container center myclass" id="step_3" style="display: none; padding: 25px 10px;">
        <h4>Please wait while we search history for your noble twin!</h4>
        <div style="padding: 25px;">
          <div class="preloader-wrapper big active">
            <div class="spinner-layer spinner-blue-only">
              <div class="circle-clipper left">
                <div class="circle"></div>
              </div><div class="gap-patch">
                <div class="circle"></div>
              </div><div class="circle-clipper right">
                <div class="circle"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
        <div  class="load_message" style="display:none; padding-bottom: 0;"><p class="load_mess" style="text-align: center; font-weight: bold; padding: 10px 15px; display: table; margin: 0 auto; background-color: #345a9c; box-shadow: 0 0 10px #232323; color: #fff;">Wow! You are so good looking it is taking us a few extra seconds to find your noble twin!</p></div>
      <footer class="page-footer white">
        <div class="container">
          <div class="row">
            <div class="col l6 s12">
              <h5 class="black-text">COADB.com</h5>
              <p class="black-text">
                The world’s premier research and retail website for coats of arms
              </p>
            </div>
            <div class="col l4 offset-l2 s12">
              <h5 class="black-text">Links</h5>
              <ul>
                <li><a class="black-text" href="https://coadb.com">Home</a></li>
                <li><a class="black-text" href="https://coadb.com/lookalike">Lookalike</a></li>
                <li><a class="black-text" href="https://coadb.com/privacy-policy">Privacy Policy</a></li>
                <li><a href="index.php?restart=1" class="btn red" style="margin-top: 10px;">Logout</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="footer-copyright">
          <div class="container black-text">
          Created by COADB.com - &copy; <?php echo date('Y'); ?>
          </div>
        </div>
      </footer>

      <!--JavaScript at end of body for optimized loading-->
      <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
      <script type="text/javascript" src="js/materialize.min.js"></script>
      <script type="text/javascript">
        $(document).ready(function(){

          var gender = '';
          var photo = '';
          var skip = 0;

          $('body').on('click', '#try_again', function() {

          	$('#step_3').html('\
          		<h4>Please wait while we search history again!</h4>\
          		<div style="padding: 25px;">\
          		  <div class="preloader-wrapper big active">\
          		    <div class="spinner-layer spinner-blue-only">\
          		      <div class="circle-clipper left">\
          		        <div class="circle"></div>\
          		      </div><div class="gap-patch">\
          		        <div class="circle"></div>\
          		      </div><div class="circle-clipper right">\
          		        <div class="circle"></div>\
          		      </div>\
          		    </div>\
          		  </div>\
          		</div>\
          		');

              skip = skip+1;
              $.post('getResult.php', { gender: gender, photo: photo, skip: skip })
              .done(function(data){
                if(data == 0)
                {
                  alert('No face detected in this picture.');
                  window.location.reload();
                }
                else
                {
                  $('#step_3').html(data);
                }
             });

          });

          $('[attr-gender]').click(function(){
            gender = $(this).attr('attr-gender');
            $(".load_message").hide();
            $('#step_1').hide();
            $('#step_2').fadeIn();
          });

          $('[attr-photo]').click(function(){
              
            photo = $(this).attr('attr-photo');
            $(".load_message").show();
            $('#step_2').hide();
            $('#step_3').fadeIn();
            $.post('getResult.php', { gender: gender, photo: photo })
            .done(function(data){
              if(data == 0)
              {
                alert('No face detected in this picture.');
                window.location.reload();
              }
              else
              {
                $('#step_3').html(data);
                $('#share').fadeIn();
              }
            });
          });

        });
      </script>
	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-73713303-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-73713303-1');
</script>
    
</body>
  </html>
  
