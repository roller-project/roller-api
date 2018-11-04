<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');


//pass some simple sanity checks
if ( $_REQUEST['wallet'] == "" ) {echo "url should be in format http://api.roller.today/?wallet=0xasdfjasdlkjasdflkj"; exit;}
if ( strlen($_REQUEST['wallet']) != "42" ) { echo "wallet should be 42 char, including the 0x beginning"; exit;}

//include ethereum php library
require 'ethereum-php/ethereum.php';
//create object
//pirls official rpc server, made for things like this
//$ethc = new Ethereum('https://node.roller.today/', '80');

//use this if your running a local pirl node (be sure to start it up with --rpc after the command)
$ethc = new Ethereum('http://127.0.0.1', 8545);

//if passed, capture wallet id
$addr = $_REQUEST['wallet'];

//get balance
$dec = $ethc->eth_getBalance($addr, "latest");

//convert from hex to dev, then to human type numbers
// 10 decimal spots, with a period, no thousands separator  = 1119.8800567580

$roller = number_format((hexdec($dec)/1000000000000000000), 10, ".", "");

//setup array for json encoding
$assocArray = array();
$assocArray['wallet'] = ''.$addr.'';
$assocArray['balance'] = ''.$roller.'';

//print_r($assocArray);

//encode in json format
$jsondata = json_encode($assocArray);

//finally, echo result of the work.
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json;charset=utf-8');
echo $jsondata;
?>
