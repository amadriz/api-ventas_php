<?php

    //add cors
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: X-API-KEY, Access-Control-Request-Method, Content-Type, Authorization, X-Requested-With");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Allow: GET, POST, OPTIONS, PUT, DELETE");
    
    require_once("Config/Config.php");
    require_once("Helpers/Helpers.php");

    //funcion para cargar las vistas, controladores y modelos automaticamente
    $url = !empty($_GET['url']) ? $_GET['url'] : "home/home" ;
    $arrUrl = explode("/",$url);
    $controller = $arrUrl[0];
    $method =  $arrUrl[0];
    $params = "";
    
    //add comments
    if(!empty($arrUrl[1])){
        if($arrUrl[1] != ""){
            $method = $arrUrl[1]; 
        }
    }

    if(!empty($arrUrl[2]) && $arrUrl[2] != "")
    {
        for ($i=2; $i < count($arrUrl); $i++) { 
            $params .= $arrUrl[$i].',';
        }
        $params = trim($params,",");
    }

    require_once("Libraries/Core/Autoload.php");
    require_once("Libraries/Core/Load.php");

?>