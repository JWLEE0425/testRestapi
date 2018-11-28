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

$app->get('/product', function($request, $response, $args){
    $myArray = array();
    $con = db_con();
    $sql = 'select * from product';
    $result = mysqli_query($con, $sql);
    
    while($row = mysqli_fetch_assoc($result)){
        $myArray[] = $row;
    }
    
    $response->getbody()->write("JSON : " . json_encode($myArray));
    return $response;
});

$app->get('/product/{name}', function($request, $response){
    $name = $request->getAttribute('name');
    $myArray = array();
    $con = db_con();
    $sql = 'select * from product where name ="' . $name . '"';
    $result = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $myArray[] = $row;
    }
    $json = json_encode($myArray);
    $d_json = json_decode($json, true);
    $response->getbody()->write("JSON : " . $json . " price :" . $d_json['price']);

    return $response;
    
    
});

$app->post('/post/data', function ($request, $response, $arg) {

    $_input = $request->getParsedBody();

    $_data_1 = $_input['name'];
    $_data_2 = $_input['email'];
    $rsp = array();

    if (! empty($_data_1 && ! empty($_data_2))) {

        $rsp["error"] = false;
        $rsp['message'] = "hello my name is " . $_data_1 . " and my email is " . $_data_2;
    } else {

        $rsp["error"] = false;
        $rsp['message'] = "you have not posted any data";
    }

    return $response->withStatus(201)->withJson($rsp);
});



$app->run();

?>
