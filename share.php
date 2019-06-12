<!DOCTYPE html>
<html>
    <head>

        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width,initial-scale=1.0"/>

        <?php //$img = "https://coadb.com/lookalike/thumbs/27f401111d659095fc1de22a7895585f.png"; ?>
        <?php $img = $_GET['image']; ?>

        <meta property="og:type" content="website"/>
        <meta property="og:title" content="<?php echo $_GET['title']; ?>">
        <meta property="og:image" content="https://coadb.com/lookalike/thumbs/<?php echo $img; ?>">
        <meta name="description" content="<?php echo $_GET['description']; ?>">
        <meta property="og:image:width" content="1200" >
        <meta property="og:image:height" content="300" >
        <meta property="og:site_name" content="coadb.com"/>

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <style type="text/css">
            img
            {
                max-width: 100% !important;
            }
            *
            {
                text-transform: none !important;
            }
        </style>
    </head>
    <body>

        <div class="container" style="padding: 5px 20px; margin: 0 auto; text-align: center;">
            <a href="https://coadb.com"><img src="img/logo.png" style="max-width: 250px !important;"></a>
        </div>
        <div class="container" style="padding: 0 40px;">
            <form class="searches" role="search" action="https://coadb.com" method="get">
                <div class="row">
                    <div class="col m8">
                        <label>Find your Coat of Arms</label>
                        <div class="search-table">
                            <div class="search-fields"><input class="s" name="s" type="text" value="" placeholder="Type your surname here..."></div>
                        </div>
                        <button type="submit" class="btn blue waves-effect">Search</button>
                    </div>
                    <div class="col m4">
                        <a href="https://coadb.com/lookalike" class="btn blue btn-large waves-effect" style="margin-top: 20px;">Play Lookalike Game</a>
                    </div>
                </div>
            </form>
        </div>

        <div style="margin: 0 auto; text-align: center;">
            <h4><?php echo $_GET['title']; ?></h4>
            <a href="index.php">
                <img src="https://coadb.com/lookalike/thumbs/<?php echo $img; ?>">
                <p><?php echo $_GET['description']; ?></p>
            </a>
        </div>

        <script type="text/javascript">
            document.body.scrollLeft = (document.body.scrollWidth - document.body.clientWidth) / 2;
        </script>
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
