<?php
    // Menentukan Mode Web
    if($mode_web=="Development"){
        $version_code = date('Ymdhis');
    }else{
        $version_code = "Production";
    }
?>

<!-- METADATA -->
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<title>AdminPanel</title>
<meta content="Aplikasi Pengelolaan Konten Website" name="description">
<meta content="Website, Konten, CMS" name="keywords">

<!-- Favicons -->
<link rel="apple-touch-icon" sizes="57x57" href="assets/img/Icon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="assets/img/Icon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="assets/img/Icon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="assets/img/Icon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="assets/img/Icon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="assets/img/Icon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="assets/img/Icon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="assets/img/Icon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="assets/img/Icon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="assets/img/Icon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="assets/img/Icon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="assets/img/Icon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="assets/img/Icon/favicon-16x16.png">
<link rel="manifest" href="assets/img/Icon/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">

<!-- Google Fonts -->
<link href="assets/fonts/fonts.css?v=<?php echo $version_code; ?>" rel="stylesheet">

<!-- BOOTSTRAP -->
<link href="node_modules\bootstrap\dist\css\bootstrap.min.css" rel="stylesheet">

<!-- BOOTSTRAP ICON -->
<link href="node_modules\bootstrap-icons\font\bootstrap-icons.min.css" rel="stylesheet">

<!-- QUILL -->
<link href="node_modules\quill\dist\quill.snow.css" rel="stylesheet">
<link href="node_modules\quill\dist\quill.bubble.css" rel="stylesheet">

<!-- MAIN CSS -->
<link href="assets/css/style.css?v=<?php echo $version_code; ?>" rel="stylesheet">

<!-- MDB UI KIT -->
<link href="node_modules/mdb-ui-kit/css/mdb.min.css" rel="stylesheet">
