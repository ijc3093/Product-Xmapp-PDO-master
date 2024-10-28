<?php
    include('Controller.php');
    $db = new Controller();
?>


<!-- Head -->
<?php 
    include('../includes/header-detail.php');
?>

<div id="main-content" class="blog-page">
        <div class="container">
            <div class="row clearfix">
                <div class="col-lg-8 col-md-12 left-box">
                    <div class="card single_post">
                        <div class="body">
                            <div class="img-post">
                                <!-- <img class="d-block img-fluid" src="https://via.placeholder.com/800x280/87CEFA/000000" alt="First slide"> -->
                                <!-- <iframe src="https://player.vimeo.com/video/656300853" width="640" height="360" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe> -->
                                <?php
                                    $video = $db->get_products($_GET['id'])[0];
                                    $location = $video["location_video"];
                                    echo "<div >"; 
                                    //echo "<iframe class='d-block img-fluid' src='https://www.youtube.com/embed/".$location."' controls width='800' height='450'></iframe>";
                                    echo "<iframe class='d-block img-fluid' src='https://player.vimeo.com/video/".$location."' controls width='800' height='500'></iframe>";
                                    echo "</div>";
                                ?>
                            </div>
                            <h3>
                                <?php
                                    $yesterday = $db->get_products($_GET['id'])[0];
                                    $title = $yesterday["name"];
                                    echo "<div >";
                                    echo "<h3>".$title."</h3>";
                                    echo "</div>";
                                ?>
                            </h3>
                            <p>
                                <?php
                                    $yesterday = $db->get_products($_GET['id'])[0];
                                    $title = $yesterday["description"];
                                    echo "<div >";
                                    echo "<p>".$title."</p>";
                                    echo "</div>";
                                ?>
                            </p>
                        </div>                   
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 right-box">
                    <div class="card">
                        <div class="header">
                            <h1>shopping</h1>                        
                        </div>
                        <div class="body widget popular-post">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="single_post">
                                        <p class="m-b-0">Product Introduces Search Ads Basic</p>
                                            <span>
                                                <?php
                                                    $yesterday = $db->get_products($_GET['id'])[0];
                                                    $title = $yesterday["datepost"];
                                                    $time = $yesterday["time"];
                                                    echo "<span>".$title.", ".$time."</span>";
                                                ?>
                                            </span>
                                        <div class="img-post">
                                            <?php

                                                $yesterday = $db->get_products($_GET['id'])[0];
                                                $qrCodeurl = 'https://museai.azurewebsites.net/Museai/Admin/detail.php?id='.$yesterday['idproduct'];
                                                //echo "<p>".$qrCodeurl."</p>";

                                                include('phpqrcode/qrlib.php');
                                                $text = $qrCodeurl;
                                                $path = 'qrCodeImg/';
                                                $file = $path.uniqid().".png";

                                                $ecc = 'L';
                                                $pixel_Size = 10;
                                                $frame_Size = 10;

                                                QRcode::png($text, $file, $ecc, $pixel_Size, $frame_Size);
                                                echo "<div>";
                                                echo "<img src='".$file."' controls width='280' height='280' >";
                                                echo "</div>";
                                            ?>                                        
                                        </div>                                            
                                    </div>
                                    <div class="single_post">
                                        <!-- <p class="m-b-0">new things, more pictures, more information</p> -->
                                        <div class="img-post"> 
                                            <?php
                                                $image = $db->get_products($_GET['id'])[0];
                                                $location_image = $image["location_image"];
                                                echo "<div>";
                                                echo "<img src='".$location_image."' controls width='280' height='280' >";
                                                echo "</div>";
                                            ?>                                         
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="share-btn-container">
                            <a href="#" color="gplus" class="social-share-url gmail">
                            <i class="fab fa-google-plus"></i>
                            </a>

                            <a href="#" class="social-share-url facebook">
                            <i class="fab fa-facebook"></i>
                            </a>

                            <a href="#" class="social-share-url twitter">
                            <i class="fab fa-twitter"></i>
                            </a>

                            <a href="#" class="social-share-url twitter">
                            <i class="fab fa-pinterest"></i>
                            </a>

                            <a href="#" class="social-share-url linkedin">
                            <i class="fab fa-linkedin"></i>
                            </a>

                            <a href="#" class="social-share-url whatsapp">
                            <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                        <script src="share.js"></script>
                    </div>
                    <div class="card">
                        <div class="header">
                            <h2>There are more pictures basic</h2>
                        </div>
                        <div class="body widget">
                            <ul class="list-unstyled instagram-plugin m-b-0">
                                <li><a href="javascript:void(0);"><img src="https://via.placeholder.com/100x100/87CEFA/000000" alt="image description"></a></li>
                                <li><a href="javascript:void(0);"><img src="https://via.placeholder.com/100x100/87CEFA/000000" alt="image description"></a></li>
                                <li><a href="javascript:void(0);"><img src="https://via.placeholder.com/100x100/87CEFA/000000" alt="image description"></a></li>
                                <li><a href="javascript:void(0);"><img src="https://via.placeholder.com/100x100/87CEFA/000000" alt="image description"></a></li>
                                <li><a href="javascript:void(0);"><img src="https://via.placeholder.com/100x100/87CEFA/000000" alt="image description"></a></li>
                                <li><a href="javascript:void(0);"><img src="https://via.placeholder.com/100x100/87CEFA/000000" alt="image description"></a></li>
                                <li><a href="javascript:void(0);"><img src="https://via.placeholder.com/100x100/87CEFA/000000" alt="image description"></a></li>
                                <li><a href="javascript:void(0);"><img src="https://via.placeholder.com/100x100/87CEFA/000000" alt="image description"></a></li>
                                <li><a href="javascript:void(0);"><img src="https://via.placeholder.com/100x100/87CEFA/000000" alt="image description"></a></li>
                            </ul>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
