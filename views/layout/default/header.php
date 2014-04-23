<?php
/**
 * Created by PhpStorm.
 * User: Cesar Luis Rosagel
 * Date: 15/04/14
 * Time: 08:30 PM
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php if(isset($this->titulo)) echo $this->titulo; ?></title>
    <link href="<?php echo $_layoutParams['ruta_css']; ?>estilos.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $_layoutParams['ruta_css']; ?>formulario.css" rel="stylesheet" type="text/css">
    <script src="<?php echo $_layoutParams['ruta_js_public']; ?>"></script>

    <?php
            if(isset($_layoutParams['js']) && count($_layoutParams['js'])):
            foreach($_layoutParams['js'] as $item):
    ?>
            <script src="<?php echo $item; ?>" type="text/javascript"></script>
    <?php
            endforeach;
            endif;
    ?>
</head>
<body>
    <header>
        <h1><?php echo APP_NAME; ?></h1>
    </header>