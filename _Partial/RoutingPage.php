<?php
    if(empty($_GET['Page'])){
        include "_Page/Home/Home.php";
    }else{
        $Page=$_GET['Page'];
        //Index Halaman
        $page_arry=[
            "MyProfile"         => "_Page/MyProfile/MyProfile.php",
            "pengurus"          => "_Page/Pengurus/Pengurus.php",
            "alamat-dan-kontak" => "_Page/Contact/Contact.php",
            "visi-dan-misi" => "_Page/VisiMisi/VisiMisi.php",
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