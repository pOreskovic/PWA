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
                            <li><a href="index.php" >Home</a></li>
                            <li><a href="about.html">About</a></li>
                            <li><a href="kategorija.php?id=World News">World News</a></li>
                            <li><a href="kategorija.php?id=Upcoming Competitions">Competitions</a></li>
                            <li><a href="" style="border: 3px solid #f44336;">Admin</a></li>
                            <li><a href="unos.html" >New Page</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!--MAIN-->
    <main class="register" style="min-height: 650px;">
        <form method="POST">
            <h1>egistracija</h1>

            <label>Ime</label><br>
            <input type="text" name="ime" id="unosIme"/><br><span id="errorIme" class="error"></span>

            <label>Prezime</label><br>
            <input type="text" name="prezime" id="unosPrezime"/><br><span id="errorPrezime" class="error"></span>

            <label>Korisnicko ime</label><br>
            <input type="text" name="username" id="unosUsername"/><br><span id="" class="error"></span>

            <label>Lozinka</label><br>
            <input type="password" name="password" id="unosPass"/><br><span id="" class="error"></span>

            <label>Ponovljena lozinka</label><br>
            <input type="password" name="password1" id="unosPass1"/><br><span id="" class="error"></span>

            <input class="regButton" type="submit" name="regButton" id="regButton" value="Registriraj se"/>
            
                    <?php              
                        include 'connect.php';
                        if(isset($_POST["regButton"])){
                            $ime = $_POST["ime"];
                            $prezime = $_POST["prezime"];
                            $username = $_POST["username"];
                            $password = $_POST["password"];
                            $password1 = $_POST["password1"];
                            $hashPASS = password_hash($password, CRYPT_BLOWFISH);
                            $razina = 0;
                            $registriranKorisnik = '';
                            $q = "SELECT korisnickoIme FROM korisnik WHERE korisnickoIme = ?";
                            $stmt = mysqli_stmt_init($dbc);
                            if(mysqli_stmt_prepare($stmt,$q)){
                                mysqli_stmt_bind_param($stmt, 's', $username);
                                mysqli_stmt_execute($stmt);
                                mysqli_stmt_store_result($stmt);
                             }

                            if(mysqli_stmt_num_rows($stmt)>0){
                                    echo "Korisnicko ime vec postoji ili je prazno!";
                            }else{
                                if($password == $password1){
                                    $q2 = "INSERT INTO korisnik(ime, prezime, korisnickoIme,lozinka,administrator)
                                    VALUES(?,?,?,?,?)";
                                    $stmt = mysqli_stmt_init($dbc);
                                    if(mysqli_stmt_prepare($stmt,$q2)){
                                        mysqli_stmt_bind_param($stmt,'ssssb',$ime,$prezime,$username,$hashPASS,$razina);
                                        mysqli_stmt_execute($stmt);
                                        $registriranKorisnik = true;
                                    } 
                                }else{
                                    echo "Lozinke se ne poklapaju!";
                                }
                                
                            }
                            if($registriranKorisnik == true){
                                echo "Korisnik je uspjesno registriran!";
                            }  
                        }
                            
                    ?>
            
        </form>
        
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