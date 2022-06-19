<?php
session_start();
?>
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
                            <li><a href="kategorija.php?id=World News">World News</a></li>
                            <li><a href="kategorija.php?id=Upcoming Competitions">Competitions</a></li>
                            <li><a style="border: 3px solid #f44336;">Admin</a></li>
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

            if(isset($_POST["loginButton"])){
                $loginUser = $_POST["loginUser"];
                $pass = $_POST["loginPass"];

               $q = "SELECT korisnickoIme, lozinka, administrator FROM korisnik WHERE korisnickoIme = ?";
               $stmt = mysqli_stmt_init($dbc);
               if (mysqli_stmt_prepare($stmt,$q)){
                    mysqli_stmt_bind_param($stmt,'s',$loginUser);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
               }
               mysqli_stmt_bind_result($stmt,$imeKorisnika,$lozinkaKorisnika,$levelKorisnika);
               mysqli_stmt_fetch($stmt);

               if(password_verify($pass, $lozinkaKorisnika) && mysqli_stmt_num_rows($stmt) > 0){
                $uspjesnaPrijava = true;

                if($levelKorisnika ==1){
                    $admin = true;
                }else{
                    $admin = false;
                }
                $_SESSION['$username'] = $imeKorisnika;
                $_SESSION['$level'] = $levelKorisnika;
               }else{
                $uspjesnaPrijava = false;
               }
            }

            if($uspjesnaPrijava == true && $admin == true){
                $q = "SELECT * FROM vijesti";
                $qres = mysqli_query($dbc, $q);
            }

            

        ?>

        <section class="admini"><br>
        <h1>dministracija</h1><br>
            <?php
            if($uspjesnaPrijava == true && $admin == true){
                echo "<p style='flex-basis: 100%;'>Prijavljeni ste kao " . $_SESSION['$username'] . "<br>Imate administratorska prava! <br></p>";
                while($row = mysqli_fetch_array($qres)){
                    $comp = "";
                    $WN = "";
                    if ($row["kategorija"] == "Upcoming Competitions"){
                        $comp = "selected";
                    }else{
                        $WN = "selected";
                    }
                    echo '<div class="editVijest">';
                    echo '  
                                <form enctype="multipart/form-data" action="" method="POST">

                                    <div class="form-item">
                                        <label for="title">Naslov vjesti:</label>
                                        <div class="form-field">
                                            <input type="text" name="title" class="form-field-textual" value="'.$row['naslov'].'">
                                        </div>
                                    </div>

                                    <div class="form-item">
                                        <label for="about">Kratki sadržaj vijesti (do 50 znakova):</label>
                                        <div class="form-field">
                                            <textarea name="about" id="" cols="30" rows="5" class="form-field-textual">'.$row['sazetak'].'</textarea>
                                        </div>
                                    </div>

                                    <div class="form-item">
                                        <label for="content">Sadržaj vijesti:</label>
                                        <div class="form-field">
                                            <textarea name="content" id="" cols="30" rows="20" class="form-field-textual">'.$row['sadrzaj'].'</textarea>
                                        </div>
                                    </div>

                                    <div class="slika">
                                        <div class="form-field">
                                        <label for="img" class="imgButton">Izaberi sliku</label><br/>
                                        <input type="file" id="img" accept="image/jpg" name="Nphoto" style="display:none;"> <br><img src="images/' . $row['slika'] . '" width=80%>
                                        </div>
                                    </div>

                                    <div class="form-item">
                                        <label for="category">Kategorija vijesti:</label>
                                        <div class="form-field">
                                            <select value="'.$row['kategorija'].'" name="category" id="" class="form-field-textual" >
                                                <option value="World News"' . $WN . '>World News</option>
                                                <option value="Upcoming Competitions"' . $comp . '>Upcoming Competitions</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-item">
                                        <label>Spremiti u arhivu: </label>
                                        <div class="form-field">';
                                            if($row['arhiva'] == 0) {
                                            echo '<input type="checkbox" name="archive" id="archive"/> ';
                                        
                                            } else {
                                                echo '<input type="checkbox" name="archive" id="archive" 
                                                checked/> ';
                                            }
                                        echo '</div>
                                        
                                    </div>
                                    
                                    <div class="form-item">
                                    <input type="hidden" name="id" class="form-field-textual" value="'.$row['id'].'">
                                    <button type="reset" value="Poništi" class="imgButton">Poništi</button><br>
                                    <button type="submit" name="promjeni" value="Prihvati" class="imgButton">Izmjeni</button><br>
                                    <button type="submit" name="izbrisi" value="Izbriši" class="imgButton">Izbrisi</button>
                                    
                                    </div>
                                </form>';
                            echo '</div>';
                }
            }else if($uspjesnaPrijava == true && $admin == false){
                echo '<div class="poruka">
                        <p>Pozdrav ' . $_SESSION['$username'] . '!</p>
                        <h3>Upozorenje!</h3>
                        Nazalost nemate administracijska prava za pristup ovoj stranici!' . 
                      '</div>';
            }else{
                echo '<h3 style="flex-basis: 100%;">Profil nije pronaden!</h3><br>';
                echo '<p style="flex-basis: 100%;">Ukoliko nemate profil mozete ga napraviti klikom na gumb ispod!</p>';
                echo '<a class="vodime" href="registracija.php">Registracija</a>';
            }
            ?>
        </section>

        <?php 
            
            if(isset($_POST["promjeni"])){

                $picture = $_FILES['Nphoto']['name'];
                $title=$_POST['title'];
                $about=$_POST['about'];
                $content=$_POST['content'];
                $category=$_POST['category'];

                if(isset($_POST['archive'])){
                    $archive=1;
                }else{
                    $archive=0;
                }

                $target_dir = 'images/'.$picture;
                move_uploaded_file($_FILES["Nphoto"]["tmp_name"], $target_dir);

                $id=$_POST['id'];
                $q = "UPDATE vijesti SET naslov='$title', sazetak='$about', sadrzaj='$content', 
                slika='$picture', kategorija='$category', arhiva='$archive' WHERE id=$id ";
                $qres = mysqli_query($dbc, $q);
                
            } 

            if(isset($_POST["izbrisi"])){
                $id = $_POST["id"];
                $q = "DELETE FROM vijesti WHERE id=$id";
                $qres = mysqli_query($dbc, $q);

            }
        
        
        ?>

    </main>
    <!--FOOTER-->
    <footer style="margin-top: 0;">
        Autor ~ Petar Orešković
        <br />
        Kontakt ~ petar.oreskovic@tvz.hr
        <br/>
        2022.
    </footer>
</body>
</html>