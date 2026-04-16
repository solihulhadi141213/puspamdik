<?php
    if(empty($_GET['Page'])){
        include "_Page/Dashboard/Dashboard.php";
    }else{
        $Page=$_GET['Page'];
        //Index Halaman
        $page_arry=[
            "MyProfile"      => "_Page/MyProfile/MyProfile.php",
            "AksesFitur"     => "_Page/AksesFitur/AksesFitur.php",
            "AksesEntitas"   => "_Page/AksesEntitas/AksesEntitas.php",
            "Akses"          => "_Page/Akses/Akses.php",
            "SettingGeneral" => "_Page/SettingGeneral/SettingGeneral.php",
            "SettingEmail"   => "_Page/SettingEmail/SettingEmail.php",
            "Hero"           => "_Page/Hero/Hero.php",
            "Opening"        => "_Page/Opening/Opening.php",
            "Galeri"         => "_Page/Galeri/Galeri.php",
            "VisiMisi"       => "_Page/VisiMisi/VisiMisi.php",
            "Pengurus"       => "_Page/Pengurus/Pengurus.php",
            "Laman"          => "_Page/Laman/Laman.php",
            "Blog"           => "_Page/Blog/Blog.php",
            "Buku"           => "_Page/Buku/Buku.php",
            "Event"          => "_Page/Event/Event.php",
            "Testimoni"      => "_Page/Testimoni/Testimoni.php",
            "Error"          => "_Page/Error/Error.php"
        ];

        //Tangkap 'Page'
        $Page = !empty($_GET['Page']) ? $_GET['Page'] : "";

        //Kondisi Pada masing-masing Page
        if (array_key_exists($Page, $page_arry)) { 
            include $page_arry[$Page]; 
        } else { 
            include "_Page/Error/PageNotFound.php";
        }
    }
?>