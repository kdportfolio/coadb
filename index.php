<?php
require 'config.php';
if (isset($_SESSION['finished'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}
if (isset($_GET['restart'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}
if (isset($_SESSION['accessToken'])) {
    header('Location: noble.php');
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
        <style type="text/css">
            *
            {
                text-transform: none !important;
            }
            img
            {
                max-width: 100% !important;
            }
            .container:after {
                content: "";
                display: block;
                clear: both;
            }
            .container .img_left, .container .img_right {
                width: 23%;
            }
            .container .img_left img, .container .img_right img {
                max-height: 100%;
                width: auto;
                height: auto;
            }
            .logo img {
                max-width: 250px !important;
            }
            @media only screen and (max-width: 1024px) {
                .container {
                    max-width: 100% !important;
                }
            }
            @media only screen and (max-width: 767px) {
                .logo img {
                    max-width: 100px !important;
                }
            }
        </style>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    </head>

    <body>

        <div class="container" style="max-width: 65%; padding: 20px; margin: 0 auto; text-align: center;">
            <div class="img_left" style="float: left;">
                <img alt="noble female person" src="img/image_left.jpg"></img>
            </div>
            <a class="logo" href="https://coadb.com/"><img src="img/logo.png" style="max-width: 250px;"></a>
            <div class="img_right" style="float: right;">
                <img alt="noble male person" src="img/image_right.jpg"></img>
            </div> 
        </div>

        <div class="container center">

            <h4>Which noble person from history do you look like?</h4>
            <?php
            if (isset($_GET['code'])) {
                $helper = $fb->getRedirectLoginHelper();
                $accessToken = $helper->getAccessToken();
                $_SESSION['accessToken'] = $accessToken->getValue();
                header('Location: noble.php');
                exit();
            } else {
                $helper = $fb->getRedirectLoginHelper();
                $loginUrl = $helper->getLoginUrl($facebook_callback, array(
                    'user_photos',
                    'public_profile'
                ));

                echo '<a style="background: #4267B2;" href="' . $loginUrl . '" class="waves-effect waves-light btn-large"><i class="fab fa-facebook-f left"></i> Continue with Facebook</a>';
            }
            ?>
        </div>

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
        <script type="text/javascript" src="js/custom.js"></script>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-73713303-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'UA-73713303-1');
        </script>

    </body>
</html>
