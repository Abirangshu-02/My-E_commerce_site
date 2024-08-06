<!DOCTYPE html>
<html lang="en">
<?php
    include('CRUD.php');
?>
<head>
    <meta charset="utf-8">
    <title>Admin Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <style>
        .cstmg{
            margin-top: 15%;
        }
    </style>
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <!-- <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div> -->
        <!-- Spinner End -->
        <?php
            session_start();
            if(!isset($_SESSION['admail']))
                header('location:adminlog.php');
            $info = infock($_SESSION['admail']);
            $assinfo = mysqli_fetch_assoc($info);
        ?>

        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>ADMIN</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0"><?php  echo $assinfo['name']; ?></h6>
                        <span>Admin</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="index.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="products.php" class="nav-item nav-link active"><i class="fa fa-laptop me-2"></i>Products</a>
                    <a href="orders.php" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Orders</a>
                    <a href="users.php" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Users</a>
                    <a href="logout.php" class="nav-item nav-link"><i class="fa fa-times text-danger"></i>Logout</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <form class="d-none d-md-flex ms-4">
                    <button type="button" class="btn btn-primary rounded-pill m-2" data-bs-toggle="modal" data-bs-target="#addModal">Add Product</button>
                </form>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="btn-group" role="group">
                        <a href="products.php" class="btn btn-outline-secondary">All</a>
                        <a href="products.php?cat=Fruit" class="btn btn-outline-secondary">Fruits</a>
                        <a href="products.php?cat=Vegetable" class="btn btn-outline-secondary">Vegetables</a>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="index.php" class="nav-link">
                            <img class="rounded-circle me-lg-2" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex"><?php  echo $assinfo['name']; ?></span>
                        </a>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->


            <!-- table -->
            <div class="container-fluid pt-4 px-4">
                <div class="col-12">
                    <div class="bg-light rounded h-100 p-4">
                        <h6 class="mb-4">Products Table</h6>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Price/kg</th>
                                        <th scope="col">Stock</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">__Action__</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(isset($_GET['cat']))
                                        {
                                            $sn=1;
                                            $cat=$_GET['cat'];
                                            $rcv = display_by_type($cat);
                                            $rcd = mysqli_num_rows($rcv);
                                            if($rcd > 0)
                                            {
                                                while($dta = mysqli_fetch_assoc($rcv))
                                                {
                                                    echo '
                                                    <tr>
                                                        <th scope="row">'.$sn++.'</th>
                                                        <td>'.$dta["category"].'</td>
                                                        <td>'.$dta["name"].'</td>
                                                        <td>'.$dta["price"].'</td>
                                                        <td>'.$dta["stock"].'</td>
                                                        <td>
                                                            <img src="'.$dta["image"].'" width="58px">
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-outline-secondary m-2" onclick="editP('.$dta["id"].')">Edit</button>
                                                            <button type="button" class="btn btn-sm btn-outline-danger m-2" onclick="delP('.$dta["id"].')">Delete</button>
                                                        </td>
                                                    </tr>';
                                                }
                                            }
                                        }
                                        else
                                        {
                                            $sn=1;
                                            $rcv = displayProduct();
                                            while($dta = mysqli_fetch_assoc($rcv))
                                            {
                                                echo '
                                                <tr>
                                                    <th scope="row">'.$sn++.'</th>
                                                    <td>'.$dta["category"].'</td>
                                                    <td>'.$dta["name"].'</td>
                                                    <td>'.$dta["price"].'</td>
                                                    <td>'.$dta["stock"].'</td>
                                                    <td>
                                                        <img src="'.$dta["image"].'" width="58px">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary m-2" onclick="editP('.$dta["id"].')">Edit</button>
                                                        <button type="button" class="btn btn-sm btn-outline-danger m-2" onclick="delP('.$dta["id"].')">Delete</button>
                                                    </td>
                                                </tr>';
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- table -->

            <!-- Add Product Modal -->
            <div class="modal fade" id="addModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="addModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addModalLabel">Add Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="category" class="form-label">Item Category</label>
                                    <select id="category" name="type" class="form-select" required>
                                        <option value="">Select a Category</option>
                                        <option value="Fruit">Fruit</option>
                                        <option value="Vegetable">Vegetable</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="itemName" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="itemName" name="iname" placeholder="Item Name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="itemPrice" class="form-label">Price</label>
                                    <input type="number" class="form-control" id="itemPrice" name="iprice" placeholder="Price for each" min="0" required>
                                </div>
                                <div class="mb-3">
                                    <label for="itemStock" class="form-label">Stock</label>
                                    <input type="number" class="form-control" id="itemStock" name="istock" placeholder="Stocks available" min="0" required>
                                </div>
                                <div class="mb-3">
                                    <label for="itemImage" class="form-label">Image/s</label>
                                    <input type="file" class="form-control" id="itemImage" name="ipic" required>
                                    <!-- <img src="" alt="" id="view" srcset=""> -->
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="addp" class="btn btn-success">Insert</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- add product modal -->
            <?php
                if(isset($_POST['addp']))
                {
                    $sc = addProduct($_POST);
                    if($sc==1)
                        echo "<meta http-equiv='refresh' content='0;url=products.php'>";
                    else
                        echo $sc;
                }
            ?>

            <!-- Update Product Modal -->
            <div class="modal fade" id="updateModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="updateModalLabel" aria-hidden="true"> <!--aria changed ?? -->
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateModalLabel">Update Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <input type="hidden" class="form-control" id="updatepid" name="iname">
                                <div class="mb-3">
                                    <label for="updateCategory" class="form-label">Item Category</label>
                                    <select id="updateCategory" name="utype" class="form-select" required>
                                        <option value="">Select a Category</option>
                                        <option value="Fruit">Fruit</option>
                                        <option value="Vegetable">Vegetable</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="updateName" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="updateName" name="uname" placeholder="Item Name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="updatePrice" class="form-label">Price</label>
                                    <input type="number" class="form-control" id="updatePrice" name="uprice" placeholder="Price for each" min="0" required>
                                </div>
                                <div class="mb-3">
                                    <label for="updateStock" class="form-label">Stock</label>
                                    <input type="number" class="form-control" id="updateStock" name="ustock" placeholder="Stocks available" min="0" required>
                                </div>
                                <div class="mb-3">
                                    <label for="updateImage" class="form-label">Image/s</label>
                                    <input type="file" class="form-control" id="updateImage" name="upic" onchange="displayview(event)">
                                </div>
                                <div class="mb-3" style="margin-left: 40%;">
                                    <img src="" alt="" id="viewshow" srcset="" width="100" height="80">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="updatep" class="btn btn-success">Update</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- update box -->
            <?php
                if(isset($_POST['updatep']))
                {
                    $sc = PDupdate($_POST);
                    if($sc==1)
                        echo "<meta http-equiv='refresh' content='0;url=".$_SERVER['HTTP_REFERER']."'>";
                    else
                        echo $sc;
                }
            ?>

            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4 cstmg">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">Shopping</a>, All Right Reserved. 
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            <!--/* This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. */-->
                            Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                        </br>
                        Distributed By <a class="border-bottom" href="https://themewagon.com" target="_blank">ThemeWagon</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/bootstrap5.js"></script>
    <!-- <script src="js/jquery.js"></script> -->
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script src="js/jquery.js"></script>
    <script>
        function editP(pid)
        {
            // $("#updateModal").modal('show')
            $.ajax({
                url: "populatepd.php",
                method: "post",
                data: {"pid": pid},
                success: function(response)
                {
                    // alert(response)
                    var info = JSON.parse(response)
                    document.getElementById("updatepid").value = info.id
                    document.getElementById("updateCategory").value = info.category
                    document.getElementById("updateName").value = info.name
                    document.getElementById("updatePrice").value = info.price
                    document.getElementById("updateStock").value = info.stock
                    document.getElementById("viewshow").src = info.image
                    $("#updateModal").modal('show')
                }
            })
        }
        function displayview(event)
        {
            tg = event.target
            if(tg.files)
            {
                let ob = new FileReader
                ob.onload = function(fnc){
                    document.getElementById("viewshow").src = fnc.target.result
                }
                ob.readAsDataURL(tg.files[0])
            }
        }
        function delP(pid)
        {
            if(confirm("Are you sure to DELETE this product ?"))
            {
                $.ajax({
                    url: "pdDelCt.php",
                    method: "post",
                    data: {"pid": pid},
                    success: function($response){
                        alert("Item Deleted")
                        window.location.href=""
                    }
                })
            }
        }
    </script>
</body>

</html>