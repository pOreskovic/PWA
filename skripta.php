<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Karate</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" href="images/icon.png" type="image/png">
    <meta name="keywords" content="Karate, borba, vještine, samoobrana, povijest, japan, kihon, kate, kumite">
    <meta name="description" content="Informacije o sportu Karate">
    <meta name="author" content="Petar Orešković">
    <link rel="stylesheet" href="css-bootstrap/bootstrap.min.css"/>
    <script src="https://kit.fontawesome.com/eff7ce4bd1.js" crossorigin="anonymous"></script>
</head>


<body>
    <!--HEADER-->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-xl-2 col-lg-2 col-md-5 col-sm-4">
                    <img src="images/icon-white.png">
                </div>
                <div class="col-xl-2 col-lg-7 col-md-7 col-sm-8">
                    <h1>Karate</h1>
                </div>
                <div class="col-xl-8 col-lg-3 col-md-12 col-sm-12">
                    <nav>
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li><a href="about.html">About</a></li>
                            <li><a href="kategorija.php?id=World News">World News</a></li>
                            <li><a href="kategorija2.php?id=Upcoming Competitions">Competitions</a></li>
                            <li><a href="admin.html">Admin</a></li>
                            <li><a href="unos.html">New Page</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!--MAIN-->
    <main >
        <img width="100%" height="500px" src="images/header.jpg" alt="wide slika karatea">
        
        <?php
        include 'connect.php';
        if(isset($_POST["send"])){
            $po = $_POST;

            $naslov = $po["naslov"];
            $sazetak = $po["sazetak"];
            $sadrzaj = $po["sadrzaj"];
            $image = $_FILES["Nphoto"] ["name"];
            $target = 'images/' . $image;
            move_uploaded_file($_FILES['Nphoto']["tmp_name"],$target);
            $kat = $po["kategorija"];
            $datum = date("d.m.Y");

            if(isset($po["arhiviraj"])){
                $arhiva = TRUE;
            } else{
                $arhiva = FALSE;
            }


            $q = "INSERT INTO vijesti(naslov,sazetak,sadrzaj,slika,kategorija,arhiva,datum) 
                  VALUES('$naslov','$sazetak','$sadrzaj','$image','$kat','$arhiva','$datum')";
            $qres = mysqli_query($dbc, $q) or die('Error Querying Database');

            mysqli_close($dbc);
        }
            
        ?>

        <div class="vijest">
            <h1><?php echo $kat; ?><h1>
            <h2><?php echo $naslov; ?></h2>
            <?php 
                echo '<img  style="width: 50%; border-radius: 5px; margin: 20px 0;" src="images/' . $image . '">'
            ?>
            <p><?php echo $sadrzaj; ?></p>
        </div>
    </main>
    <!--FOOTER-->
    <footer style="margin-top: 0px; padding: 50px 0; min-height: 100px;">
        Autor ~ Petar Orešković
        <br />
        Kontakt ~ petar.oreskovic@tvz.hr
        <br/>
        2022.
    </footer>
</body>
</html>