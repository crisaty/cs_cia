<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Deshabilitar proteccion CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title Page-->
    <title>CS & CIA</title>
    <meta name="theme-color" content="#343A40">

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">

    <!-- BOOTSTRAP + VueJS -->
    <link type="text/css" rel="stylesheet" href="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.css"/>

</head>

<body>
    
    <div id="app" class="animsition" data-animsition-in-class="fade-in" data-animsition-in-duration="1000">

        <ui-principal></ui-principal>

    </div>

    <!-- Vue Js Components --> <!-- Jquery JS--> <!-- Bootstrap JS-->
    <script src="js/app.js"></script>

    <script src="vendor/slick/slick.min.js"></script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>

    <!-- Main JS-->
    <script src="js/main.js"></script>

    <!-- SWEET ALERT 2 -->
    <script src="js/sweetalert2.js"></script>

</body>

</html>

