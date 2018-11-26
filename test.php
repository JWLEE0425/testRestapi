<?php
$app = new \Slim\Slim();
$app->get('/foo', function(){
    echo "foo";
});
$app->run();
?>
