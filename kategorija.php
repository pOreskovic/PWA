<!DOCTYPE html>
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
                    <img src="images/icon-white.png" alt="ikona">
                </div>
                <div class="col-xl-2 col-lg-7 col-md-7 col-sm-8">
                    <h1>Karate</h1>
                </div>
                <div class="col-xl-8 col-lg-3 col-md-12 col-sm-12">
                    <nav>
                        <ul>
                            <li><a href="index.php" >Home</a></li>
                            <li><a href="about.html">About</a></li>
                            <li ><a href="kategorija.php?id=World News">World News</a></li>
                            <li><a href="kategorija.php?id=Upcoming Competitions">Competitions</a></li>
                            <li><a href="admin.html">Admin</a></li>
                            <li><a href="unos.html">New Page</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!--MAIN-->
    <main>
        <img width="100%" height="500px" src="images/header.jpg" alt="wide slika karatea"><br>
        
        <?php 
            include 'connect.php';
        ?>

        <section><br>
        <?php
        $kategorija = $_GET['id'];


        echo '<h1>' . $kategorija . '</h1><br>';
            
            $q = "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija='$kategorija'";
            $qres = mysqli_query($dbc, $q);

                $i = 0;
                while($row = mysqli_fetch_array($qres)){
                    echo '<article>';
                    echo '<h3><a href="clanak.php?id='.$row['id'].'">';
                    echo $row["naslov"];
                    echo '</a></h4>';
                    echo '<div class="wnIMG">';
                    echo '<img src="images/' . $row['slika'] . '">';
                    echo '</div>';
                    echo '<br><p>' . $row['sazetak'] . '</p>';
                    echo '</article>';
                }?>
        </section>

    </main>
    <!--FOOTER-->
    <footer>
        Autor ~ Petar Orešković
        <br />
        Kontakt ~ petar.oreskovic@tvz.hr
        <br/>
        2022.
    </footer>
</body>
</html>