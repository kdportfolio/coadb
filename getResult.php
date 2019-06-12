<?php
ini_set('zlib.output_compression', 1);
require 'config.php';
$_SESSION['finished'] = 1;
$sid=session_id();
$photo = $_POST['photo'];
switch ($_POST['gender']) {
  case 'male':
    $faceset_token = '852f03e1159fd67527620f3d08a448b3';
    break;
  case 'female':
    $faceset_token = '4214a418ba67aeeedc5e2d87fbe960c0';
    break;
}



$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $photo);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
curl_close($ch);


$ext = explode( '?', $photo );
$ext = pathinfo( $ext[0], PATHINFO_EXTENSION );
$save_image_path = $sid . '.' . $ext;
$files_path = getcwd() . '/user/'.$save_image_path;

file_put_contents($files_path, $output);

$host = $_SERVER['HTTP_HOST'];
$main_path = 'https://'.$host.'/lookalike/user/'.$save_image_path;



$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api-us.faceplusplus.com/facepp/v3/search');
curl_setopt($ch, CURLOPT_FAILONERROR, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "api_key=".$api['key']."&api_secret=".$api['secret']."&image_url=".$main_path."&faceset_token=".$faceset_token."&return_result_count=5");


$headers = array();
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$json = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);

$result = json_decode($json, 1);

if(isset($_POST['skip']))
{
  if($_POST['skip']<5)
  {
    if(!isset($result['results'][$_POST['skip']]))
    {
      echo '0';
      
    }

    $q = $pdo->prepare("SELECT * FROM `faces` WHERE `face_token`=? LIMIT 1");
    $q->execute(array($result['results'][$_POST['skip']]['face_token']));
  }
  else
  {
    $q = $pdo->prepare("SELECT * FROM `faces` WHERE `gender`=? ORDER BY rand(); LIMIT 1");
    $q->execute(array(ucwords($_POST['gender'])));
  }
}
else
{
  if(!isset($result['results'][0]))
  {
    echo '0';
    
  }

  $q = $pdo->prepare("SELECT * FROM `faces` WHERE `face_token`=? LIMIT 1");
  $q->execute(array($result['results'][0]['face_token']));
}

$template = $q->fetch(PDO::FETCH_ASSOC);

$data = json_decode($template['data'], 1);

$position = $data['faces'][0]['face_rectangle'];

$face_rectangle = $position['top'].','.$position['left'].','.$position['width'].','.$position['height'];



$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://us.faceplusplus.com/imagepp/v1/mergeface');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "api_key=".$api['key']."&api_secret=".$api['secret']."&template_url=".$template['image_url']."&template_rectangle=".$face_rectangle."&merge_url=".$main_path."&merge_rate=67");
curl_setopt($ch, CURLOPT_POST, 1);

$headers = array();
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);

$data = json_decode($result, 1);

$merged_image_base64 = $data['result'];
echo '<h4>You are: '.$template['name'].' <small>'.$template['born_died'].'</small></h4>';

$chiu = curl_init();
curl_setopt($chiu, CURLOPT_URL, $template['image_url']);
curl_setopt($chiu, CURLOPT_RETURNTRANSFER, 1);
$output_iu = curl_exec($chiu);
curl_close($chiu);

?>

<div class="row" id="resultData">
  <div class="col s4" style="padding-right: 0 !important;">
    <img src="<?php echo $main_path; ?>" style="width: 100%;"/>
  </div>
    
  <div class="col s4" style="padding-right: 0 !important;">
    <img src="data:image/png;base64, <?php echo $merged_image_base64; ?>"/>
  </div>
  <div class="col s4" style="padding-right: 0 !important;">
    <img src="data:image/png;base64, <?php echo base64_encode($output_iu); ?>"/>
  </div>
</div>

<p>
<?php
echo $template['bio'];
?>
</p>

<h5>Click the below buttons to share your results with family and friends of social media:</h5>
<a href="#" id="try_again" class="waves-effect  waves-light btn-large white black-text">Try again</a>

<a href="javascript:void(0);" id="fb_share_btn" class="fb_share_btn  waves-effect waves-light btn-large indigo darken-1">Share on Facebook</a>

<a id="twitter_share" href="javascript:void(0);" class="waves-effect  waves-light btn-large blue">Share on Twitter</a>

<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/html2canvas.min.js"></script>
<script type="text/javascript">
  (function($) {

        var imgURL = '';
        $(".load_message").hide();
        $('#twitter_share').on('click', function(event){

        	$('#resultData').css({'width':'1200px', 'height':'627px'});
        	$(this).addClass('disabled');
        	html2canvas(document.querySelector("#resultData")).then(canvas => {
        	  var image = canvas.toDataURL();
        	  $.post('thumb.php', { data: image } )
        	  .done(function(data){
        	    $('#resultData').css({'width':'auto', 'height':'auto'});
        	    $('#twitter_share').removeClass('disabled');
        	    event.preventDefault();
        	    event.stopImmediatePropagation();

        	        var TWTitle     = "Which noble person are you? I\'m <?php echo $template['name']; ?>!";
        	        var TWLink      = 'https://coadb.com/lookalike';
        	        var TWPic       = data;

        	        window.open('http://twitter.com/share?text=Which noble person are you? I got <?php echo $template['name']; ?>!&url='+TWLink+'&image='+TWPic);

        	  });
        	});
        });

          $('.fb_share_btn').on('click', function (event) {
            $('#resultData').css({'width':'1200px', 'height':'627px'});
            $(this).addClass('disabled');
            html2canvas(document.querySelector("#resultData")).then(canvas => {
              var image = canvas.toDataURL();
              $.post('thumb.php', { data: image } )
              .done(function(data){
                $('#resultData').css({'width':'auto', 'height':'auto'});
                $('.fb_share_btn').removeClass('disabled');
                event.preventDefault();
                event.stopImmediatePropagation();

                    // Dynamically gather and set the FB share data. 
                    var FBDesc      = "<?php echo $template['bio']; ?>";
                    var FBTitle     = "Which noble person are you? I\'m <?php echo $template['name']; ?>!";
                    var FBLink      = 'https://coadb.com/lookalike';
                    var FBPic       = data;

                    // Open FB share popup
                    FB.ui({
                        method: 'share',
                        display: 'popup',
                        href: 'https://coadb.com/lookalike/share.php?url='+FBLink+'&title='+FBTitle+'&image='+FBPic+'&description='+FBDesc,
                        //action_properties: JSON.stringify({
                        //    object: {
                        //        'og:url': FBLink,
                        //        'og:title': FBTitle,
                        //        'og:description': FBDesc,
                        //        'og:image': FBPic
                        //    }
                        //})
                    },
                    function (response) {
                    // Action after response
                    })
              });
            });

          })

      })( jQuery );
</script>

<br/>
<br/>
