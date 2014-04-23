<?php
/**
 * Created by PhpStorm.
 * User: Cesar Luis Rosagel
 * Date: 19/04/14
 * Time: 07:51 PM
 */
require_once("class.phpmailer.php");

class Mail extends PHPMailer{
    public function __construct(){

    }

    public function sendMail(){
        //Definir que vamos a usar SMTP
        $this->IsSMTP();
        //Esto es para activar el modo depuración. En entorno de pruebas lo mejor es 2, en producción siempre 0
        // 0 = off (producción)
        // 1 = client messages
        // 2 = client and server messages
        $this->SMTPDebug  = 0;
        //Ahora definimos gmail como servidor que aloja nuestro SMTP
        $this->Host       = 'smtp.gmail.com';
        //El puerto será el 587 ya que usamos encriptación TLS
        $this->Port       = 465;
        //Definmos la seguridad como TLS
        $this->SMTPSecure = 'tls';
        //Tenemos que usar gmail autenticados, así que esto a TRUE
        $this->SMTPAuth   = true;
        //Definimos la cuenta que vamos a usar. Dirección completa de la misma
        $this->Username   = "cluis.ryusoul@gmail.com";
        //Introducimos nuestra contraseña de gmail
        $this->Password   = "3l1z4b3t1986";
        //Definimos el remitente (dirección y, opcionalmente, nombre)
        $this->From= 'cluis.ryusoul@gmail.com';
        $this->FromName='CESAR LUIS ROSAGEL';
        //Esta línea es por si queréis enviar copia a alguien (dirección y, opcionalmente, nombre)
        //$mail->AddReplyTo('replyto@correoquesea.com','El de la réplica');
        //Y, ahora sí, definimos el destinatario (dirección y, opcionalmente, nombre)
        $this->AddAddress('chicharo_el_sexy@hotmail.com', 'El Destinatario');
        //Definimos el tema del email
        $this->Subject = 'Esto es un correo de prueba';
        //Para enviar un correo formateado en HTML lo cargamos con la siguiente función. Si no, puedes meterle directamente una cadena de texto.
        $body=$this->getFile(ROOT.'libs'.DS.'phpmailer'.DS.'contents.html');
        $this->MsgHTML($body);
        //Y por si nos bloquean el contenido HTML (algunos correos lo hacen por seguridad) una versión alternativa en texto plano (también será válida para lectores de pantalla)
        $this->AltBody = 'This is a plain-text message body';
        //Enviamos el correo
        if(!$this->Send()) {
            echo "Error: " . $this->ErrorInfo;
        } else {
            echo "Enviado!";
        }
    }
}
