<div class="navbar navbar-inverse set-radius-zero" >
        <div class="container">
            <div class="navbar-header">

                <a class="navbar-brand" >

                    <img src="assets/img/logo.png" />
                </a>

            </div>
<?php if($_SESSION['login']!='')
{?> 
            <div class="right-div">
            <p> Bine ai venit, <?php echo $_SESSION['nume']; ?>  &nbsp <a href="logout.php" class="btn btn-danger pull-right btn-sm">LOG OUT</a></p>
            </div>
            <?php }?>
        </div>
    </div>
    
    <!-- LOGO HEADER END-->
<?php if($_SESSION['login']!='')
{?>    
<section class="menu-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                            <li><a href="index.php" class="menu-top-active"><i class="fa-solid fa-house"></i> HOME</a></li>
                            <li><a href="lista-rezervari.php" class="menu-top-active"><i class="fa-solid fa-calendar-days"></i> Rezervarile mele</a></li>
                            <li><a href="my-profile.php" class="menu-top-active"><i class="fa-solid fa-user"></i> Contul meu</a></li>
                            <li><a href="contact.php" class="menu-top-active"><i class="fa-solid fa-phone"></i> Contact</a></li>

                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <?php } else { ?>
        <section class="menu-section">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">                        
                            <li><a href="index.php" "><i class="fa-solid fa-house"></i> HOME</a></li>
                            <li><a href="about.php">Despre noi</a></li>
                            <li><a href="signup.php"><i class="fa-solid fa-user-plus"></i> Inregistreaza-te</a></li>
                             <li><a href="login.php"><i class="fa-solid fa-right-to-bracket"></i> Autentificare</a></li>
                             <li><a href="contact.php" "><i class="fa-solid fa-phone"></i> Contact</a></li>
                          

                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <?php } ?>