<?php

require_once '../models/Clientes.php';
$cliente = new Cliente();
if(isset($_GET['operacion'])){
  switch($_GET['operacion']){  

    case 'registrarn':
      $parametros = [
        "apellidos" => $_GET['apellidos'],
        "nombres"   => $_GET['nombres'],
        "dni"       => $_GET['dni'],
        "claveAcceso" => password_hash($_GET['claveAcceso'],PASSWORD_BCRYPT)
      ];
      $cliente->registrar($parametros);
      break;
  }
}
if(isset($_POST['operacion'])){
  switch($_POST['operacion']){
    case 'registrar':
      $parametros = [
        "apellidos" => $_POST['apellidos'],
        "nombres"   => $_POST['nombres'],
        "dni"       => $_POST['dni'],
        "claveAcceso" => password_hash($_POST['claveAcceso'],PASSWORD_BCRYPT)
      ];
      $cliente->registrar($parametros);
      break;
    case 'inicioSesion':
      $password =  password_hash($_POST['claveAcceso'],PASSWORD_BCRYPT);
      $acceso = [
        "sesion" => false,
        "mensaje" => "",
        "idcliente" => 0
      ];
      $respuesta = $cliente->inicioSesion($_POST['dni'],$password);
      // var_dump($respuesta);die;
      if($respuesta){
        $claveIngresada = $_POST['claveAcceso'];
        // if(password_verify($claveIngresada, $respuesta['claveacceso'])){
          $acceso["sesion"] = true;
          $acceso["idcliente"] = $respuesta["idcliente"];
        // }else{
        //   $acceso["mensaje"] = "La contraseña no es correcta";
        // }
      }else{
        $acceso["mensaje"] = "El usuario no existe";
      }
      echo json_encode($acceso);
      break;
  }
}
