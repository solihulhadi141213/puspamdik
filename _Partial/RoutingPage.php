<?php
    if(empty($_GET['Page'])){
        include "_Page/Home/Home.php";
    }else{
        $Page=$_GET['Page'];
        //Index Halaman
        $page_arry=[
            "faq"                         => "_Page/Faq/Faq.php",
            "tos"                         => "_Page/Tos/Tos.php",
            "privacy-policy"              => "_Page/privacy-policy/privacy-policy.php",
            "pengurus"                    => "_Page/Pengurus/Pengurus.php",
            "alamat-dan-kontak"           => "_Page/Contact/Contact.php",
            "visi-dan-misi"               => "_Page/VisiMisi/VisiMisi.php",
            "metodologi-penelitian"       => "_Page/MetodePenelitian/MetodePenelitian.php",
            "penulisan-ilmiah"            => "_Page/PenulisanIlmiah/PenulisanIlmiah.php",
            "leadership"                  => "_Page/Leadership/Leadership.php",
            "pendampingan-pelatihan"      => "_Page/pendampingan-pelatihan/pendampingan-pelatihan.php",
            "pendapingan-artikel"         => "_Page/pendapingan-artikel/pendapingan-artikel.php",
            "layanan-naskah-akademik"     => "_Page/layanan-naskah-akademik/layanan-naskah-akademik.php",
            "evaluasi-program-pemerintah" => "_Page/evaluasi-program-pemerintah/evaluasi-program-pemerintah.php",
            "evaluasi-lembaga-pendidikan" => "_Page/evaluasi-lembaga-pendidikan/evaluasi-lembaga-pendidikan.php",
            "penerbitan-buku-isbn"        => "_Page/penerbitan-buku-isbn/penerbitan-buku-isbn.php",
            "penerbitan-haki"             => "_Page/penerbitan-haki/penerbitan-haki.php",
            "artikel"                     => "_Page/artikel/artikel.php",
            "detail-artikel"              => "_Page/artikel/detail-artikel.php",
            "Buku"                        => "_Page/Buku/Buku.php",
            "event"                       => "_Page/Event/Event.php",
            "testimoni"                   => "_Page/Testimoni/Testimoni.php",
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