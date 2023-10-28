<?php

$data = array(1,2,3,4,5,6,7,8,9,10);

header('Access-Control-Allow-Origin: http://localhost:5173');
header('Content-Type: application/json');
echo json_encode($data);