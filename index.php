<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '/usr/share/nginx/html/bin/vendor/autoload.php';

$app = new \Slim\App;
$app->get('/', function($request, $response, $args) {
    return $response->withStatus(200)->write('Hello worlddd!');
});
$app->get('/test', function($request, $response, $args){
    return $response->withStatus(200)->write('Hello world!');
});
$app->get('/product/{name}', function(Request $request, Response $response){
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
    $products = [
	"book"=>20,
	"pen"=>10,
	"pencil"=>5
    ];
    foreach($products as $product=>$price) {
	if($product==$name) {
	    return $price;
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
