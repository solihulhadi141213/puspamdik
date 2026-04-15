<!DOCTYPE html>
<html lang="en">
    <?php
        // Include Head
        include "_Partial/Head.php";
    ?>
    <body class="index-page" data-aos-easing="ease-in-out" data-aos-duration="600" data-aos-delay="0">
        <?php
            // Include Header
            include "_Partial/Header.php";
        ?>
        <main class="main">
            <?php
                // Include Header
                include "_Partial/RoutingPage.php";
            ?>
        </main>
        <footer id="footer" class="footer accent-background">
            <?php
                // Include footer
                include "_Partial/Footer.php";
            ?>
            

            <?php
                // Copyright
                include "_Partial/Copyright.php";
            ?>

        </footer>
        <?php
            // Include Header
            include "_Partial/FooterJs.php";
        ?>
        
    </body>
</html>