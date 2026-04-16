<?php
    include "_Page/Logout/ModalLogout.php";
    include "_Page/Dashboard/ModalDashboard.php";
    if(!empty($_GET['Page'])){
        $Page=$_GET['Page'];
        
        // Daftar halaman dan modal yang terkait
        $modals = [
            "MyProfile"      => "_Page/MyProfile/ModalMyProfile.php",
            "AksesFitur"     => "_Page/AksesFitur/ModalAksesFitur.php",
            "AksesEntitas"   => "_Page/AksesEntitas/ModalAksesEntitas.php",
            "Akses"          => "_Page/Akses/ModalAkses.php",
            "SettingGeneral" => "_Page/SettingGeneral/ModalSettingGeneral.php",
            "SettingEmail"   => "_Page/SettingEmail/ModalSettingEmail.php",
            "Hero"           => "_Page/Hero/ModalHero.php",
            "Opening"        => "_Page/Opening/ModalOpening.php",
            "Galeri"         => "_Page/Galeri/ModalGaleri.php",
            "Pengurus"       => "_Page/Pengurus/ModalPengurus.php",
        ];

        // Cek apakah halaman memiliki modal terkait dan sertakan file modalnya
        if (!empty($_GET['Page']) && isset($modals[$_GET['Page']])) {
            include $modals[$_GET['Page']];
        }
    }
?>