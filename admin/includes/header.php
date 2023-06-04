


<div class="navbar navbar-inverse set-radius-zero" >
        <div class="container">
            <div class="navbar-header">

                <a class="navbar-brand" >

                    <img src="assets/img/logo.png" />
                </a>

            </div>
<?php if($_SESSION['alogin']!='')
{?> 
            <div class="right-div">
            <p> Bine ai venit, <?php echo $_SESSION['nume']; ?>  &nbsp <a href="logout.php" class="btn btn-danger pull-right btn-sm">LOG OUT</a></p>
            </div>
            <?php }?>
        </div>
    </div>
    <!-- LOGO HEADER END-->
<?php if($_SESSION['alogin']!='')
{?>    
<section class="menu-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                            <li><a href="dashboard.php" class="menu-top-active"><i class="fa-solid fa-house"></i> DASHBOARD</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="firma.php"><i class="fa-solid fa-briefcase"></i> Date firma</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="lista-camere.php"><i class="fa-solid fa-door-closed"></i> Camere</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="lista-rezervari.php"><i class="fa-solid fa-calendar-days"></i> Rezervari</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="lista-facturi.php"><i class="fa-solid fa-file-invoice"></i> Facturi</a></li>
                            <li><a href="lista-utilizatori.php" class="menu-top-active"><i class="fa-solid fa-users"></i> Utilizatori</a></li>



                          

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
                          
                            <li><a href="about.php">Despre noi</a></li>
                            <li><a href="signup.php">User Signup</a></li>
                             <li><a href="index.php">User Login</a></li>
                          

                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <?php } ?>