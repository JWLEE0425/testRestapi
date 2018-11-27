<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
include 'config.php';
require '/usr/share/nginx/html/bin/vendor/autoload.php';
$app = new \Slim\App;
$app->get('/', function($request, $response, $args) {
    return $response->withStatus(200)->write('Hello worlddd!');
});
$app->get('/test', function($request, $response, $args){
    return $response->withStatus(200)->write('Hello world!');
});
$app->get('/product/name={name}', function($request, $response){
    $name=$request->getAttribute('name');
    $price = get_price($name);
    if(empty($price)) {
	$json = response(200, "Product Not Found", NULL);
    } else {
	$json = response(200, "Product Found", $price);
    }
    $response->getbody()->write("JSON : ".$json);
    return $response;
});
function get_price($name) {
    $con = db_con();
    $sql = 'select * from product';
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    
    foreach($products as $row['name']=>$row['price']) {
        if($row['name']==$name) {
            return $row['price'];
	       break;
	   }
    }
}
function response($status, $status_message, $data) {
    header("HTTP/1.1".$status);
    $response['status']=$status;
    $response['status message']=$status_message;
    $response['data']=$data;
    $json_response = json_encode($response);
    return $json_response;
}
$app->run();

?>
