<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>package</title>

   <!-- swiper css link  -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <!-- custom css file link  -->
   <style>
      @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600&display=swap');

:root{
   --main-color:#8e44ad;
   --black:#222;
   --white:#fff;
   --light-black:#777;
   --light-white:#fff9;
   --dark-bg:rgba(0,0,0,.7);
   --light-bg:#eee;
   --border:.1rem solid var(--black);
   --box-shadow:0 .5rem 1rem rgba(0,0,0,.1);
   --text-shadow:0 1.5rem 3rem rgba(0,0,0,.3);
}

*{
   font-family: 'Poppins', sans-serif;
   margin:0; padding:0;
   box-sizing: border-box;
   outline: none; border:none;
   text-decoration: none;
   text-transform: capitalize;
}

html{
   font-size: 62.5%;
   overflow-x: hidden;
}

html::-webkit-scrollbar{
   width: 1rem;
}

html::-webkit-scrollbar-track{
   background-color: var(--white);
}

html::-webkit-scrollbar-thumb{
   background-color: var(--main-color);
}

section{
   padding:5rem 10%;
}

@keyframes fadeIn {
   0%{
      transform: scale(0);
      opacity: 0;
   }
}

.heading{
   background-size: cover !important;
   background-position: center !important;
   padding-top: 10rem;
   padding-bottom:15rem;
   display: flex;
   align-items: center;
   justify-content: center;
}

.heading h1{
   font-size: 10rem;
   text-transform: uppercase;
   color:var(--white);
   text-shadow: var(--text-shadow);
}

.btn{
   display: inline-block;
   background: var(--black);
   margin-top: 1rem;
   color:var(--white);
   font-size: 1.7rem;
   padding:1rem 3rem;
   cursor: pointer;
}

.btn:hover{
   background: var(--main-color);
}

.heading-title{
   text-align: center;
   margin-bottom: 3rem;
   font-size: 6rem;
   text-transform: uppercase;
   color:var(--black);
}

.header{
   position: sticky;
   top:0; left:0; right:0;
   z-index: 1000;
   background-color: var(--white);
   display: flex;
   padding-top: 2rem;
   padding-bottom: 2rem;
   box-shadow: var(--box-shadow);
   align-items: center;
   justify-content: space-between;
}

.header .logo{
   font-size: 2.5rem;
   color:var(--black);
}

.header .navbar a{
   font-size: 2rem;
   margin-left: 2rem;
   color:var(--black);
}

.header .navbar a:hover{
   color:var(--main-color);
}

#menu-btn{
   font-size: 2.5rem;
   cursor: pointer;
   color:var(--black);
   display: none;
}

.home{
   padding:0;
}

.home .slide{
   text-align: center;
   padding:2rem;
   display: flex;
   align-items: center;
   justify-content: center;
   background-size: cover !important;
   background-position: center !important;
   min-height: 60rem;
}

.home .slide .content{
   width: 85rem;
   display: none;
}

.home .swiper-slide-active .content{
   display: inline-block;
}

.home .slide .content span{
   display: block;
   font-size: 2.2rem;
   color: var(--light-white);
   padding-bottom: 1rem;
   animation:fadeIn .2s linear backwards .2s;
}

.home .slide .content h3{
   font-size: 6vw;
   color:var(--white);
   text-transform: uppercase;
   line-height: 1;
   text-shadow: var(--text-shadow);
   padding:1rem 0;
   animation:fadeIn .2s linear backwards .4s;
}

.home .slide .content .btn{
   animation:fadeIn .2s linear backwards .6s;
}

.home .swiper-button-next,
.home .swiper-button-prev{
   top:inherit;
   left: inherit;
   bottom: 0;
   right: 0;
   height: 7rem;
   width: 7rem;
   background: var(--white);
   color:var(--black);
}

.home .swiper-button-next:hover,
.home .swiper-button-prev:hover{
   background: var(--main-color);
   color:var(--white);
}

.home .swiper-button-next::after,
.home .swiper-button-prev::after{
   font-size: 2rem;
}

.home .swiper-button-prev{
   right: 7rem;
}

.services .box-container{
   display: grid;
   grid-template-columns: repeat(auto-fit, minmax(16rem, 1fr));
   gap: 1.5rem;
}

.services .box-container .box{
   padding:3rem 2rem;
   text-align: center;
   background: var(--main-color);
   cursor: pointer;
}

.services .box-container .box:hover{
   background: var(--black);
}

.services .box-container .box img{
   height: 7rem;
}

.services .box-container .box h3{
   color:var(--white);
   font-size: 1.7rem;
   padding-top: 1rem;
}

.home-about{
   display: flex;
   align-items: center;
   flex-wrap: wrap;
}

.home-about .image{
   flex:1 1 41rem;
}

.home-about .image img{
   width: 100%;
}

.home-about .content{
   flex:1 1 41rem;
   padding:3rem;
   background: var(--light-bg);
}

.home-about .content h3{
   font-size: 3rem;
   color:var(--black);
}

.home-about .content p{
   font-size: 1.5rem;
   padding:1rem 0;
   line-height: 2;
   color:var(--black);
}

.home-packages{
   background: var(--light-bg);
}

.home-packages .box-container{
   display: grid;
   grid-template-columns: repeat(auto-fit, minmax(30rem, 1fr));
   gap: 2rem;
}

.home-packages .box-container .box{
   border:var(--border);
   box-shadow: var(--box-shadow);
   background: var(--white);
}

.home-packages .box-container .box:hover .image img{
   transform: scale(1.1);
}

.home-packages .box-container .box .image{
   height: 25rem;
   overflow: hidden;
}

.home-packages .box-container .box .image img{
   height: 100%;
   width: 100%;
   object-fit: cover;
   transition: .2s linear;
}

.home-packages .box-container .box .content{
   padding:2rem;
   text-align: center;
}

.home-packages .box-container .box .content h3{
   font-size: 2.5rem;
   color:var(--black);
}

.home-packages .box-container .box .content p{
   font-size: 1.5rem;
   color:var(--light-black);
   line-height: 2;
   padding:1rem 0;
}

.home-packages .load-more{
   text-align: center;
   margin-top: 2rem;
}

.home-offer{
   text-align: center;
}

.home-offer .content{
   max-width:70rem;
   margin:0 auto;
}

.home-offer .content h3{
   font-size: 3.5rem;
   text-transform: uppercase;
   color:var(--black);
}

.home-offer .content p{
   font-size: 1.5rem;
   color:var(--light-black);
   line-height: 2;
   padding:1rem 0;
}

.about{
   display: flex;
   align-items: center;
   flex-wrap: wrap;
   gap:3rem;
}

.about .image{
   flex:1 1 41rem;
}

.about .image img{
   width: 100%;
}

.about .content{
   flex:1 1 41rem;
   text-align: center;
}

.about .content h3{
   font-size: 3rem;
   color:var(--black);
}

.about .content p{
   font-size: 1.5rem;
   color:var(--light-black);
   line-height: 2;
   padding:1rem 0;
}

.about .content .icons-container{
   margin-top: 2rem;
   display: flex;
   flex-wrap: wrap;
   gap:1.5rem;
   align-items: flex-end;
}

.about .content .icons-container .icons{
   background: var(--light-bg);
   padding:2rem;
   flex:1 1 16rem;
}

.about .content .icons-container .icons i{
   font-size: 4rem;
   margin-bottom: 2rem;
   color:var(--main-color);
}

.about .content .icons-container .icons span{
   font-size: 1.5rem;
   color:var(--light-black);
   display:block;
}

.reviews{
   background: var(--light-bg);
}

.reviews .slide{
   padding:2rem;
   border:var(--border);
   background: var(--white);
   text-align: center;
   box-shadow: var(--box-shadow);
   user-select: none;
}

.reviews .slide .stars{
   padding-bottom: .5rem;
}

.reviews .slide .stars i{
   font-size: 1.7rem;
   color:var(--main-color);
}

.reviews .slide p{
   font-size: 1.5rem;
   color:var(--light-black);
   line-height: 2;
   padding:1rem 0;
}

.reviews .slide h3{
   font-size: 2rem;
   color:var(--black);
}

.reviews .slide span{
   font-size: 1.5rem;
   color:var(--main-color);
   display: block;
}

.reviews .slide img{
   height: 7rem;
   width: 7rem;
   border-radius: 50%;
   margin-top: 1rem;
}

.packages .box-container{
   display: grid;
   grid-template-columns: repeat(auto-fit, minmax(30rem, 1fr));
   gap: 2rem;
}

.packages .box-container .box{
   border:var(--border);
   box-shadow: var(--box-shadow);
   background: var(--white);
   display: none;
}

.packages .box-container .box:nth-child(1),
.packages .box-container .box:nth-child(2),
.packages .box-container .box:nth-child(3),
.packages .box-container .box:nth-child(4),
.packages .box-container .box:nth-child(5),
.packages .box-container .box:nth-child(6){
   display: inline-block;
}

.packages .box-container .box:hover .image img{
   transform: scale(1.1);
}

.packages .box-container .box .image{
   height: 25rem;
   overflow: hidden;
}

.packages .box-container .box .image img{
   height: 100%;
   width: 100%;
   object-fit: cover;
   transition: .2s linear;
}

.packages .box-container .box .content{
   padding:2rem;
   text-align: center;
}

.packages .box-container .box .content h3{
   font-size: 2.5rem;
   color:var(--black);
}

.packages .box-container .box .content p{
   font-size: 1.5rem;
   color:var(--light-black);
   line-height: 2;
   padding:1rem 0;
}

.packages .load-more{
   text-align: center;
   margin-top: 2rem;
}

.booking .book-form{
   padding:2rem;
   background: var(--light-bg);
}

.booking .book-form .flex{
   display: flex;
   flex-wrap: wrap;
   gap:2rem;
}

.booking .book-form .flex .inputBox{
   flex:1 1 41rem;
}

.booking .book-form .flex .inputBox input{
   width: 100%;
   padding:1.2rem 1.4rem;
   font-size: 1.6rem;
   color:var(--light-black);
   text-transform: none;
   margin-top: 1.5rem;
   border:var(--border);
}

.booking .book-form .flex .inputBox input:focus{
   background: var(--black);
   color:var(--white);
}

.booking .book-form .flex .inputBox input:focus::placeholder{
   color:var(--light-white);
}

.booking .book-form .flex .inputBox span{
   font-size: 1.5rem;
   color:var(--light-black);
}

.booking .book-form .btn{
   margin-top: 2rem;
}
.bold-label {
   font-weight: bold;
}
.bold-text {
   font-weight: bold;
}
.box .image img {
   width: 626px;
   height: 417px;
   object-fit: cover; /* Ensures images fit without distortion */
   border-radius: 10px; /* Optional for rounded corners */
}










.footer{
   background: url(../images/footer-bg.jpg) no-repeat;
   background-size: cover;
   background-position: center;
}

.footer .box-container{
   display: grid;
   grid-template-columns: repeat(auto-fit, minmax(25rem, 1fr));
   gap: 3rem;
}

.footer .box-container .box h3{
   color:var(--white);
   font-size: 2.5rem;
   padding-bottom: 2rem;
}

.footer .box-container .box a{
   color:var(--light-white);
   font-size: 1.5rem;
   padding-bottom: 1.5rem;
   display: block;
}

.footer .box-container .box a i{
   color:var(--main-color);
   padding-right: .5rem;
   transition: .2s linear;
}

.footer .box-container .box a:hover i{
   padding-right: 2rem;
}

.footer .credit{
   text-align: center;
   padding-top: 3rem;
   margin-top: 3rem;
   border-top: .1rem solid var(--light-white);
   font-size: 2rem;
   color:var(--white);
}

.footer .credit span{
   color:var(--main-color);
}
















/* media queries  */

@media (max-width:1200px){

   section{
      padding:3rem 5%;
   }

}

@media (max-width:991px){

   html{
      font-size: 55%;
   }

   section{
      padding:3rem 2rem;
   }

   .home .slide .content h3{
      font-size: 10vw;
   }

}

@media (max-width:768px){

   .heading h1{
      font-size: 4rem;
   }

   #menu-btn{
      display: inline-block;
      transition: .2s linear;
   }

   #menu-btn.fa-times{
      transform: rotate(180deg);
   }

   .header .navbar{
      position: absolute;
      top:99%; left:0; right:0;
      background-color: var(--white);
      border-top: var(--border);
      padding:2rem;
      transition: .2s linear;
      clip-path: polygon(0 0, 100% 0, 100% 0, 0 0);
   }

   .header .navbar.active{
      clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
   }

   .header .navbar a{
      display: block;
      margin:2rem;
      text-align: center;
   }

}

@media (max-width:450px){

   html{
      font-size: 50%;
   }

   .heading-title{
      font-size: 3.5rem;
   }

}


 
</style>

</head>
<body>
   
<!-- header section starts  -->
<section class="header">
   <a href="home.php" class="logo">travel.</a>
   <nav class="navbar">
      <a href="home.php">home</a>
      <a href="about.php">about</a>
      <a href="package.php">package</a>
      
      <a href="bookinghistory.php">Booking History</a>
      <a href="login.php"><i class="fas fa-user"></i></a>
   </nav>
   <div id="menu-btn" class="fas fa-bars"></div>
</section>
<!-- header section ends -->

<div class="heading" style="background:url(images/header-bg-2.png) no-repeat">
   <h1>packages</h1>
</div>

<!-- packages section starts -->
<section class="packages">
<section class="home-packages">
    <h1 class="heading-title">Our Travel Packages</h1>

    <div class="box-container">
        <?php
        $sql = "SELECT * FROM package ORDER BY created_at DESC"; // Ensure 'pakage' is correct
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $imagePath = !empty($row['image_path']) ? $row['image_path'] : 'image/default.png'; // Default image
        ?>
        <div class="box">
            <div class="image">
                <img src="<?php echo $imagePath; ?>" alt="Package Image" onerror="this.onerror=null; this.src='image/default.png';">
            </div>
            <div class="content">
                <h3><?php echo htmlspecialchars($row['type']); ?> Tour</h3>
                <p><span style="font-weight: bold; color: black;"><?php echo htmlspecialchars($row['location']); ?></span></p>
                <p><?php echo nl2br(htmlspecialchars(wordwrap($row['details'], 100, true))); ?></p>

                <p><strong>Price:</strong> ₹<?php echo number_format($row['price'], 2); ?></p>
                <a href="book.php?package_id=<?php echo $row['id']; ?>&type=<?php echo urlencode($row['type']); ?>&price=<?php echo $row['price']; ?>&location=<?php echo urlencode($row['location']); ?>" class="btn">Book Now</a>


            </div>
        </div>
        <?php
            }
        } else {
            echo "<p>No packages available.</p>";
        }
        ?>
    </div>
</section>
<!-- packages section ends -->



<!-- swiper js link -->
<script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

<!-- custom js file link -->
<script src="js/script.js"></script>

</body>
</html>