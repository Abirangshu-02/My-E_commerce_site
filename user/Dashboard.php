<!DOCTYPE html>
<html lang="en">
<?php
    include('../admin/CRUD.php');
?>
    <head>
        <meta charset="utf-8">
        <title>Fruitables - Dashboard</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet"> 

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


        <!-- Customized Bootstrap Stylesheet -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
    </head>

    <body>

        <!-- Spinner Start -->
        <!-- <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" role="status"></div>
        </div> -->
        <!-- Spinner End -->

        <?php
            session_start();
            if(!isset($_SESSION['umail']))
            {
                header('location:signin.php');
            }
            else
            {
                $rsp = userinfo($_SESSION['umail']);
                $dta = mysqli_fetch_assoc($rsp);
            }
        ?>
        <!-- Navbar start -->
        <div class="container-fluid fixed-top">
            <div class="container topbar bg-primary d-none d-lg-block">
                <div class="d-flex justify-content-between">
                    <div class="top-info ps-2">
                        <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white">123 Street, New York</a></small>
                        <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white">Email@Example.com</a></small>
                    </div>
                    <div class="top-link pe-2">
                        <a href="#" class="text-white"><small class="text-white mx-2">Privacy Policy</small>/</a>
                        <a href="#" class="text-white"><small class="text-white mx-2">Terms of Use</small>/</a>
                        <a href="#" class="text-white"><small class="text-white ms-2">Sales and Refunds</small></a>
                    </div>
                </div>
            </div>
            <div class="container px-0">
                <nav class="navbar navbar-light bg-white navbar-expand-xl">
                    <a href="index.html" class="navbar-brand"><h1 class="text-primary display-6">Fruitables</h1></a>
                    <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars text-primary"></span>
                    </button>
                    <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                        <div class="navbar-nav mx-auto">
                            <a href="index.php" class="nav-item nav-link">Home</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Pages</a>
                                <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                    <a href="cart.php" class="dropdown-item">Cart</a>
                                </div>
                            </div>
                            <a href="#" class="nav-item nav-link">Contact</a>
                        </div>
                        <?php
                            if(isset($_SESSION['umail']))
                            {
                                $cart = cartitems($_SESSION['umail']);
                                $items = mysqli_num_rows($cart);
                            }
                            else
                                $items = 0;
                        ?>
                        <div class="d-flex m-3 me-0">
                            <a class="btn border-secondary rounded-pill me-4" href="logout.php">LOGOUT</a>
                            <a href="cart.php" class="position-relative me-4 my-auto">
                                <i class="fa fa-shopping-bag fa-2x"></i>
                                <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;"><?php echo $items ;?></span>
                            </a>
                            <a href="Dashboard.php" class="my-auto">
                                <i class="fas fa-user fa-2x"></i>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Navbar End -->


        <!-- Modal Search Start -->
        <div class="modal fade" id="updateinfo" tabindex="-1" data-bs-backdrop="static" aria-labelledby="updateModalLabel" aria-hidden="true"> <!--aria changed ?? -->
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateModalLabel">Update Info</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="updateName" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="updateName" name="uname" placeholder="Username" required>
                                </div>
                                <div class="mb-3">
                                    <label for="updatePhone" class="form-label">Contact</label>
                                    <input type="number" class="form-control" id="updatePhone" name="ucontact" placeholder="Phone number" min="0" required>
                                </div>
                                <div class="mb-3">
                                    <label for="uemail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="uemail" name="uemail" placeholder="Your email" min="0" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="upassword" class="form-label">Password</label>
                                    <input type="text" class="form-control" id="upassword" name="upkey" placeholder="New password" min="0" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Dob" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" id="Dob" name="Dob" min="0">
                                </div>
                                <div class="mb-3">
                                    <label for="location" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="location" name="location" placeholder="Your address" min="0">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="updateU" class="btn btn-success">Update</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <!-- Modal Search End -->
        <?php
            if(isset($_POST['updateU']))
            {
                $rsp = update_user_info($_POST);
                if($rsp == 1)
                    echo "<meta http-equiv='refresh' content='0;url=".$_SERVER['HTTP_REFERER']."'>";
                else
                {
                    ?>
                    <script>alert("Updation Failed")</script>
                    <?php
                }
            }
        ?>

        <!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6"><?php echo $dta["uname"]; ?></h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active text-white">Your Account</li>
            </ol>
        </div>
        <!-- Single Page Header End -->


        <!-- 404 Start -->
        <div class="container-fluid py-5">
            <div class="container py-5 text-center">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12 mb-4 mb-sm-5">
                                <div class="card card-style1 border-0">
                                    <div class="card-body p-1-9 p-sm-2-3 p-md-6 p-lg-7">
                                        <div class="row align-items-center">
                                            <div class="col-lg-6 mb-4 mb-lg-0">
                                                <img src="img/usersvg.jpg" alt="..." height="350">
                                            </div>
                                            <div class="col-lg-6 px-xl-10">
                                                <div class="d-lg-inline-block py-1-9  px-sm-6 mb-1-9 rounded mb-4">
                                                    <button class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white me-4" data-bs-toggle="modal" data-bs-target="#updateinfo" onclick="editinfo('<?php echo $_SESSION['umail']; ?>')"><i class="fas fa-search text-primary"></i></button>
                                                </div>
                                                <table>
                                                    <tr class="py-4">
                                                        <td class="pe-5"><h5>Name: </h5></td>
                                                        <td><span class="text-secondary"><?php echo $dta["uname"]; ?></td>
                                                    </tr>
                                                    <tr class="pt-4 ">
                                                        <td class="pe-5"><h5>Contact: </h5></td>
                                                        <td><span class="text-secondary"><?php echo $dta["contact"]; ?></td>
                                                    </tr>
                                                    <tr class="pt-4 ">
                                                        <td class="pe-5"><h5>Email: </h5></td>
                                                        <td><span class="text-secondary"><?php echo $dta["email"]; ?></td>
                                                    </tr>
                                                    <tr class="pt-4 ">
                                                        <td class="pe-5"><h5>Password: </h5></td>
                                                        <td><span class="text-secondary"><?php echo $dta["password"]; ?></td>
                                                    </tr>
                                                    <tr class="pt-4 ">
                                                        <td class="pe-5"><h5>Date of Birth: </h5></td>
                                                        <td><span class="text-secondary"><?php echo $dta["DoB"]; ?></td>
                                                    </tr>
                                                    <tr class="pt-4 ">
                                                        <td class="pe-5"><h5>Address: </h5></td>
                                                        <td><span class="text-secondary"><?php echo $dta["address_zip"]; ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- <a class="btn border-secondary rounded-pill py-3 px-5" href="logout.php">LOGOUT</a> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- 404 End -->


        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
            <div class="container py-5">
                <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
                    <div class="row g-4">
                        <div class="col-lg-3">
                            <a href="#">
                                <h1 class="text-primary mb-0">Fruitables</h1>
                                <p class="text-secondary mb-0">Fresh products</p>
                            </a>
                        </div>
                        <div class="col-lg-6">
                            <div class="position-relative mx-auto">
                                <input class="form-control border-0 w-100 py-3 px-4 rounded-pill" type="number" placeholder="Your Email">
                                <button type="submit" class="btn btn-primary border-0 border-secondary py-3 px-4 position-absolute rounded-pill text-white" style="top: 0; right: 0;">Subscribe Now</button>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="d-flex justify-content-end pt-3">
                                <a class="btn  btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-youtube"></i></a>
                                <a class="btn btn-outline-secondary btn-md-square rounded-circle" href=""><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-5">
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-item">
                            <h4 class="text-light mb-3">Why People Like us!</h4>
                            <p class="mb-4">typesetting, remaining essentially unchanged. It was 
                                popularised in the 1960s with the like Aldus PageMaker including of Lorem Ipsum.</p>
                            <a href="" class="btn border-secondary py-2 px-4 rounded-pill text-primary">Read More</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="d-flex flex-column text-start footer-item">
                            <h4 class="text-light mb-3">Shop Info</h4>
                            <a class="btn-link" href="">About Us</a>
                            <a class="btn-link" href="">Contact Us</a>
                            <a class="btn-link" href="">Privacy Policy</a>
                            <a class="btn-link" href="">Terms & Condition</a>
                            <a class="btn-link" href="">Return Policy</a>
                            <a class="btn-link" href="">FAQs & Help</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="d-flex flex-column text-start footer-item">
                            <h4 class="text-light mb-3">Account</h4>
                            <a class="btn-link" href="">My Account</a>
                            <a class="btn-link" href="">Shop</a>
                            <a class="btn-link" href="">Shopping Cart</a>
                            <a class="btn-link" href="">Wishlist</a>
                            <a class="btn-link" href="">Order History</a>
                            <a class="btn-link" href="">International Orders</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-item">
                            <h4 class="text-light mb-3">Contact</h4>
                            <p>Address: 1429 Netus Rd, NY 48247</p>
                            <p>Email: Example@gmail.com</p>
                            <p>Phone: +0123 4567 8910</p>
                            <p>Payment Accepted</p>
                            <img src="img/payment.png" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->

        <!-- Copyright Start -->
        <div class="container-fluid copyright bg-dark py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>Your Site Name</a>, All right reserved.</span>
                    </div>
                    <div class="col-md-6 my-auto text-center text-md-end text-white">
                        <!--/*** This template is free as long as you keep the below author’s credit link/attribution link/backlink. ***/-->
                        <!--/*** If you'd like to use the template without the below author’s credit link/attribution link/backlink, ***/-->
                        <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
                        Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a> Distributed By <a class="border-bottom" href="https://themewagon.com">ThemeWagon</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Copyright End -->



        <!-- Back to Top -->
        <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>   

        
    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script>
        function editinfo(user)
        {
            // alert(user);
            $.ajax({
                url: "userinfoCT.php",
                method: "post",
                data: {"usermail": user},
                success: function(response)
                {
                    // alert(response)
                    var info = JSON.parse(response)
                    document.getElementById("updateName").value = info.uname
                    document.getElementById("updatePhone").value = info.contact
                    document.getElementById("uemail").value = info.email
                    document.getElementById("upassword").value = info.password
                    document.getElementById("Dob").value = info.DoB
                    document.getElementById("location").value = info.address_zip
                    $("#updateinfo").modal('show')
                }
            })
        }
    </script>
    </body>

</html>