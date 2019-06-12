<?php
require 'config.php';
if(!isset($_SESSION['accessToken']))
{
	header('Location: index.php');
	exit();
}
        
        // Page 2 (next 50 results)
        $images_limit = 10;
        $response = $fb->get('/me/photos?fields=images{source},id&limit='.$images_limit.'&type=uploaded', $_SESSION['accessToken']);
        $results = $response->getGraphEdge();
        $nextFeed = $fb->next( $results );

        foreach ( $nextFeed as $status ) {
            $data = $status->asArray();
            echo '
            <img src="'.$status['images'][0]['source'].'" style="max-height: 200px;" attr-photo="'.$status['images'][0]['source'].'"/>
            ';
       }

 ?>


        

