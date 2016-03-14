<?php

//require_once('../../../../Class/Admin.php');

    

    $oper           = isset($_REQUEST['oper'])          && $_REQUEST['oper']!=''            ? $_REQUEST['oper'] : '';

    //$oper           = isset($_POST[''])          && $_POST['boton-enviar']!=''            ? $_POST['boton-enviar'] : '';



        

        

    switch($oper){

        case 'Archivo'              : echo doArchivo(); break;        



    }

    



    function doArchivo(){

        

        //$tmp_name = $_FILES['file']['tmp_name'];

        //$name = $_FILES['file']['name'];

        echo $estructura ='Archivos/';

        echo mkdir($estructura, 0777, true);

        echo move_uploaded_file($_FILES['boton-enviar']['tmp_name'],'Archivos/'.$FILES['boton-enviar']['name']);        

        //move_uploaded_file($tmp_name, $estructura);

        

    }











    

?>