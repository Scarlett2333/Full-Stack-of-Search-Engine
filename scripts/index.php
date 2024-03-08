<!DOCTYPE html>
<html lang="en">
<head>


<meta charset="UTF-8">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>SearchTool</title>

<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/tooplate-style.css">
<style>

div{
    text-align: center;
}

input::-webkit-input-placeholder
{
    font-size:13px;
}
* {
    box-sizing: border-box;
}

body {
    margin: 0;
    padding: 0;
    font-weight: 500;
    font-family: "Microsoft YaHei","宋体","Segoe UI", "Lucida Grande", Helvetica, Arial,sans-serif, FreeSans, Arimo;
}


video{
    position:fixed;
    top:0;
    right:0;
    bottom:0;
    min-width:100%;
    min_height:100%;
    width:auto;
    height:auto;
    z-index:-9999;
    -webkit-filter: grayscale(100%)
    filter: blur(100px); //背景模糊
    filter:grayscale(100%); //背景灰度设置
}

container
{
    width: 500px;
    height: 820px;
    margin: 0 auto;
}

div.search {padding: 30px 0;}

form {
    position: relative;
    width: 300px;
    margin: 0 auto;
}

input, button {
    border: none;
    outline: none;
}

input {
    width: 400px;
    height: 52px;
    padding-left: 18px;
}

button {
    height: 52px;
    width: 52px;
    cursor: pointer;
    position: relative;
    text-align: center;
}

.text1{
    padding-left:100px;
    padding-right:500px;
    padding-up:100px;
    margin-left:0px;
    margin-right:0px;
    position:relative;
    text-indent:0px/em;
    line_height:20px;
    font-size:45pt;
    color=#FFFFFF;
}

.text2{
    padding-left:0px;
    padding-right:500px;
    margin-left:0px;
    margin-right:0px;
    position:relative;
    text-indent:0px/em;
    line_height:20px;
    font-size:45pt;
    color=#FFFFFF;
}

.text3{
    padding-left:20px;
    padding-right:500px;
    margin-left:0px;
    margin-right:0px;
    position:relative;
    text-indent:0px/em;
    line_height:20px;
    font-size:45pt;
    color=#FFFFFF;
}


.bar1 {}
.bar1 input {
    border: 2px solid #eaa00a;
    border-radius: 42px;
    background: #FFFFFF;
    top: 0;
    right: 0;
    margin-left:60px;
        }

.bar1 button {
    background: #eaa00a;
    border-radius: 10px 10px 10px 10px;    //设置圆角弧度
    width: 100px;
    top: 0;
    right: 0;
    margin-left:180px;
    }

.bar1 button:before {
    content: "search";
    font-family: FontAwesome;
    font-size: 18px;
    color: #F9F0DA;
    }


</style>
</head>
    <body>

    <!-- PRE LOADER -->
        <div class="preloader">
            <div class="spinner">
                <span class="sk-inner-circle"></span>
            </div>
        </div>


    <!-- HOME -->
    <section id="home" class="parallax-section">

    <div class="search bar1">
        <form action="search.php" method="get" >
        <strong style="background:#eaa00a"><font size = "4.5pt" color = "white">Paper Title</font></strong>
        <input type="text" name="paper_title" placeholder="Please enter Paper Title..." size="4pt" >
        <br>

        <br>
        <strong style="background:#eaa00a"><font size = "4.5pt" color = "white">Author Name</font></strong>
        <input type="text" name="author_name" placeholder="Please enter author name...">
        <br>
        <br>
        <strong style="background:#eaa00a"><font size = "4.5pt" color = "white">Conference Name</font></strong>
        <input type="text" name="conference_name" placeholder="Please enter conference name...">
        <br>

        <br>
        <button type="submit" value = "Submit" style="width:90px;"></button>
        </form>
    </div>


    <br>
    <br>
    <div class="text1">
        <font color="white">Welcome to our SearchTool! </font>
        <br>
    <dic class ="text2">
        <font color = "white" size = "5pt">This is a search platform.You can research the paper </font>
        <br>
    <dic class ="text3">
        <font color = "white" size = "5pt"> and the relevant information in this website. </font>


    <!-- Video -->
    <video autoplay="" loop=""   height="auto" z-index="-999" style = "width:100%;">

    <source src="video1.mp4" type="video/mp4">
    Your browser does not support the video tag
    </video>

    </div>
    </section>

    <!-- MENU -->
    <div class="navbar custom-navbar navbar-fixed-top" role="navigation">
    <div class="container">

    <!-- NAVBAR HEADER -->
    <div class="navbar-header">
        <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon icon-bar"></span>
        <span class="icon icon-bar"></span>
        <span class="icon icon-bar"></span>
        </button>

    <!-- lOGO -->
    <a href="index.php" class="navbar-brand">SearchTool</a>
    </div>

    <!-- MENU LINKS -->
    <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
        <li><a href="#home" class="smoothScroll">Homepage</a></li>
        <li><a href="#contact" class="smoothScroll">Contact us</a></li>
        </ul>
    </div>

    </div>
</div>


    <!-- CONTACT -->
    <section id="contact" class="parallax-section">
    <div class="container">
    <div class="row">

    <div class="col-md-offset-3 col-md-6 col-sm-12">
    <div class="section-title">

    <h1>Contact us!</h1>
    </div>
    </div>

    <div class="clearfix"></div>

    <div class="col-md-offset-2 col-md-8 col-sm-12">
    <!-- CONTACT FORM HERE -->
    <form id="contact-form" action="#" method="get" role="form">

    <div class="col-md-6 col-sm-6">
        <input type="text" class="form-control" id="cf-name" name="cf-name" placeholder="Name">
    </div>

    <div class="col-md-6 col-sm-6">
        <input type="email" class="form-control" id="cf-email" name="cf-email" placeholder="Email Address">
    </div>

    <div class="col-md-12 col-sm-12">
        <input type="text" class="form-control" id="cf-telephone" name="telephone" placeholder="Telephone number">
        <textarea class="form-control" rows="5" id="cf-idea" name="cf-idea" placeholder="Idea"></textarea>
    </div>

    <div class="col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4">
    <div class="section-btn">
        <button type="submit" class="form-control" id="cf-submit" name="submit"><span data-hover="Submit">Submit</span></button>
    </div>
    </div>
    </form>
    </div>

    </div>
    </div>
    </section>






<!-- SCRIPTS -->

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/smoothscroll.js"></script>
<script src="js/custom.js"></script>
<script src="js/modernizr.custom.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>

<script>
var video= document.getElementById('v1');
video.playbackRate = 0.2;

</body>
</script>
</html>
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
