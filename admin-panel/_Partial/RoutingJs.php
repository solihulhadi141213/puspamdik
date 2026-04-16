<?php 
    
    if(empty($_GET['Page'])){
        //Dafault Javascript Diarahkan Ke Dashboard
        echo '<script type="text/javascript" src="_Page/Dashboard/Dashboard.js?V='.$version_code.'"></script>';
    }else{
        $Page=$_GET['Page'];
        // Routing Javascript Berdasarkan Halaman
        $scripts = [
            "MyProfile"      => "_Page/MyProfile/MyProfile.js",
            "AksesFitur"     => "_Page/AksesFitur/AksesFitur.js",
            "AksesEntitas"   => "_Page/AksesEntitas/AksesEntitas.js",
            "Akses"          => "_Page/Akses/Akses.js",
            "SettingGeneral" => "_Page/SettingGeneral/SettingGeneral.js",
            "SettingEmail"   => "_Page/SettingEmail/SettingEmail.js",
            "Hero"           => "_Page/Hero/Hero.js",
            "Opening"        => "_Page/Opening/Opening.js",
            "Galeri"         => "_Page/Galeri/Galeri.js",
        ];

        // Cek apakah halaman ada dalam daftar dan sertakan file JS yang sesuai
        if (!empty($_GET['Page']) && isset($scripts[$_GET['Page']])) {
            echo '<script type="text/javascript" src="' . $scripts[$_GET['Page']] . '?V='.$version_code.'"></script>';
        }
    }
    echo '<script type="text/javascript" src="_Partial/Universal.js?V='.$version_code.'"></script>';
?>