<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            //Head
            include "_Partial/Head.php";
        ?>
    </head>
    <body>
        <main class="landing_background">
            <div class="container">
                <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                                <img src="assets/img/Logo/logo.png?v=<?php echo $version_code; ?>" alt="Logo" width="100px">
                                <div class="d-flex justify-content-center py-2">
                                    <p>
                                        <a href="" class="logo d-flex align-items-center w-auto">
                                            <span class="d-none d-lg-block text-light">Admin Panel</span>
                                        </a>
                                    </p>
                                </div>
                                <div class="card mb-3">
                                    <?php
                                        include "_Page/Login/Login.php";
                                    ?>
                                </div>
                                <div class="credits text-center">
                                    <small>
                                        <div class="copyright text-white">
                                            &copy; Copyright <strong><span>AdminPanel</span></strong>. All Rights Reserved 2025
                                        </div>
                                        <div class="credits text-white">
                                            Designed by <span class="text text-decoration-underline">Solihul Hadi</span>
                                        </div>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
    </main>
        <?php
            include "_Partial/FooterJs.php";
        ?>
        <script>
            //Kondisi saat tampilkan password
            $('#TampilkanPassword2').click(function(){
                if($(this).is(':checked')){
                    $('#password').attr('type','text');
                }else{
                    $('#password').attr('type','password');
                }
            });

            //Submit Login
            $('#ProsesLogin').submit(function(){
                var ProsesLogin = $('#ProsesLogin').serialize();
                var Loading='<div class="spinner-border text-info" role="status"><span class="visually-hidden">Loading...</span></div>';
                $('#NotifikasiLogin').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Login/ProsesLogin.php',
                    data 	    :  ProsesLogin,
                    success     : function(data){
                        $('#NotifikasiLogin').html(data);
                        var NotifikasiProsesLoginBerhasil=$('#NotifikasiProsesLoginBerhasil').html();
                        if(NotifikasiProsesLoginBerhasil=="Success"){
                            window.location.href = "index.php";
                        }
                    }
                });
            });

            //Proses Kirim Tautan Lupa Password
            $('#ProsesLupaPassword').submit(function(){
                var ProsesLupaPassword = $('#ProsesLupaPassword').serialize();
                var Loading='<div class="spinner-border text-info" role="status"><span class="visually-hidden">Loading...</span></div>';
                $('#NotifikasiLupaPassword').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/ResetPassword/ProsesLupaPassword.php',
                    data 	    :  ProsesLupaPassword,
                    success     : function(data){
                        $('#NotifikasiLupaPassword').html(data);
                        var NotifikasiLupaPasswordBerhasil=$('#NotifikasiLupaPasswordBerhasil').html();
                        if(NotifikasiLupaPasswordBerhasil=="Success"){
                            //Tampilkan Swal Bahwa Proses Berhasil
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Kami telah mengirim tautan ke email anda',
                                icon: 'success',
                                confirmButtonText: 'Tutup'
                            }).then((result) => {
                                if (result.isConfirmed || result.dismiss === Swal.DismissReason.close) {
                                    window.location.href = 'Login.php';
                                }
                            });
                        }
                    }
                });
            });

            //Kondisi saat tampilkan password
            $('.form-check-input').click(function(){
                if($(this).is(':checked')){
                    $('#PasswordBaru1').attr('type','text');
                    $('#PasswordBaru2').attr('type','text');
                }else{
                    $('#PasswordBaru1').attr('type','password');
                    $('#PasswordBaru2').attr('type','password');
                }
            });
            $('#ProsesResetPassword').submit(function(){
                var ProsesResetPassword = $('#ProsesResetPassword').serialize();
                var Loading='<div class="spinner-border text-info" role="status"><span class="visually-hidden">Loading...</span></div>';
                $('#NotifikasiResetPassword').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/ResetPassword/ProsesResetPassword.php',
                    data 	    :  ProsesResetPassword,
                    success     : function(data){
                        $('#NotifikasiResetPassword').html(data);
                        var NotifikasiResetPasswordBerhasil=$('#NotifikasiResetPasswordBerhasil').html();
                        if(NotifikasiResetPasswordBerhasil=="Success"){
                            //Tampilkan Swal Bahwa Proses Berhasil
                            Swal.fire({
                                title: 'Ubah Password Berhasil',
                                text: 'Silahkan Login Menggunakan Password Baru Anda',
                                icon: 'success',
                                confirmButtonText: 'Tutup'
                            }).then((result) => {
                                if (result.isConfirmed || result.dismiss === Swal.DismissReason.close) {
                                    window.location.href = 'Login.php';
                                }
                            });
                        }
                    }
                });
            });
        </script>
    </body>
</html>