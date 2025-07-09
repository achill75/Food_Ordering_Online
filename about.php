<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
error_reporting(0);
session_start();
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>About | Nusantara</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="..." crossorigin="anonymous" />
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/footer.css" rel="stylesheet">
</head>

<body>
    <!-- Header -->
    <?php include("includes/navbar.php") ?>
    <!-- End Header -->
     
        <!-- start inner page hero -->
        <div class="inner-page-hero bg-image" data-image-src="images/nusantara.jpg" style="background-position: bottom; height: 500px;">
            <div class="container"> </div>
            <!-- end:Container -->
        </div>

    <!-- Main Content -->
    <div class="container py-3">
        <h1 class="mb-3 text-center">Sejarah Restoran Nusantara</h1>
        <p class="lead text-justify">
            Di balik kelezatan dan keunikan nama-nama restoran seperti <strong>Lara Djonggrang</strong>, <strong>Bunga Rampai</strong>, <strong>Harum Manis</strong>, dan <strong>Kembang Goela</strong>, berdiri satu perusahaan yang memiliki visi besar: melestarikan dan memperkenalkan kekayaan kuliner dan budaya Indonesia dalam balutan cita rasa yang berkelas.
        </p>
        <p class="text-justify">
            Perjalanan ini dimulai pada awal tahun 2000-an, saat para pendiri yang merupakan pecinta kuliner tradisional Indonesia menyadari bahwa banyak warisan kuliner nusantara mulai terlupakan atau terpinggirkan oleh tren makanan modern. Dari semangat itulah lahir sebuah perusahaan kuliner yang kemudian melahirkan restoran-restoran tematik dengan nama dan konsep yang berbeda, namun memiliki satu benang merah: makanan Indonesia autentik yang disajikan dalam atmosfer budaya yang elegan dan berkelas.
        </p>

        <div class="mt-5">
        <h3><i class="fas fa-angle-right" style="font-size: 20px; margin-right: 8px;"></i>Lara Djonggrang</h3>
            <p class="text-justify">
                Terinspirasi dari kisah legenda Jawa, restoran ini mengusung nuansa kerajaan klasik dengan dekorasi megah dan menu-menu eksotis dari berbagai daerah di Indonesia. Pengalaman bersantap di sini seperti menyelami dongeng sejarah nusantara.
            </p>

            <h3><i class="fas fa-angle-right" style="font-size: 20px; margin-right: 8px;"></i>Bunga Rampai</h3>
            <p class="text-justify">
                Berlokasi di sebuah bangunan kolonial, Bunga Rampai menghadirkan keanggunan tempo dulu dengan sajian masakan Indonesia yang ditata modern. Cocok untuk fine dining maupun acara istimewa.
            </p>

            <h3><i class="fas fa-angle-right" style="font-size: 20px; margin-right: 8px;"></i>Harum Manis</h3>
            <p class="text-justify">
                Dengan suasana yang hangat dan elegan, Harum Manis menghadirkan rasa nostalgia akan masakan ibu di rumah, namun dalam presentasi yang premium. Di sini, setiap hidangan adalah cerita rasa dari berbagai pelosok negeri.
            </p>

            <h3><i class="fas fa-angle-right" style="font-size: 20px; margin-right: 8px;"></i>Kembang Goela</h3>
            <p class="text-justify">
                Memadukan gaya arsitektur kolonial dengan sentuhan tradisional, Kembang Goela menyajikan beragam menu klasik Indonesia dengan teknik penyajian yang halus dan modern. Tempat ini menjadi pilihan banyak tokoh nasional dan tamu-tamu asing yang ingin menikmati kuliner otentik Indonesia dalam suasana yang mewah.
            </p>
        </div>

        <p class="mt-4 text-justify">
            Meski mengusung konsep dan nama yang berbeda-beda, keempat restoran ini tetap berada di bawah satu naungan manajemen yang solid dan memiliki nilai inti yang sama: kualitas, budaya, dan kecintaan terhadap kuliner Indonesia. Perusahaan ini percaya bahwa makanan adalah bagian dari identitas bangsa, dan melalui sajian-sajian mereka, budaya Indonesia bisa terus hidup dan dikenal di kancah dunia.
        </p>

        <p class="text-justify">
            Kini, Restoran Nusantara melalui merek-mereknya telah menjadi ikon kuliner Indonesia yang menginspirasi dan membanggakan.
        </p>
    </div>
    <!-- End Main Content -->

    <!-- Footer -->
    <?php include("includes/footer.php") ?>
    <!-- End Footer -->

    <!-- Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animsition.min.js"></script>
    <script src="js/bootstrap-slider.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/headroom.js"></script>
    <script src="js/foodpicky.min.js"></script>
</body>

</html>
