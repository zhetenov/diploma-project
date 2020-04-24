<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CRM Box</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="front/css/animate.css">
    <!-- Icomoon Icon Fonts-->
    <link rel="stylesheet" href="front/css/icomoon.css">
    <!-- Bootstrap  -->
    <link rel="stylesheet" href="front/css/bootstrap.css">

    <!-- Magnific Popup -->
    <link rel="stylesheet" href="front/css/magnific-popup.css">

    <!-- Owl Carousel -->
    <link rel="stylesheet" href="front/css/owl.carousel.min.css">
    <link rel="stylesheet" href="front/css/owl.theme.default.min.css">

    <!-- Theme style  -->
    <link rel="stylesheet" href="front/css/style.css">

    <!-- Modernizr JS -->
    <script src="front/js/modernizr-2.6.2.min.js"></script>
    <!-- FOR IE9 below -->
    <!--[if lt IE 9]>
    <script src="front/js/respond.min.js"></script>
    <![endif]-->

</head>
<body>

<div class="colorlib-loader"></div>

<div id="page">
    <nav class="colorlib-nav" role="navigation">
        <div class="top-menu">
            <div class="container">
                <div class="row">
                    <div class="col-md-2">
                        <div id="colorlib-logo"><a href="#">CRM Box</a></div>
                    </div>
                    <div class="col-md-10 text-right menu-1">
                        <ul>
                            <li class="active"><a href="#">Home</a></li>
                            @if (Route::has('login'))
                                @auth
                                    <li><a href="admin/users">CRM</a></li>
                                @else
                                    <li>
                                        <a href="{{ route('login') }}">Login</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('register') }}">Register</a>
                                    </li>

                                @endauth

                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <section id="home" class="video-hero"
             style="height: 700px; background-image: url(front/images/cover_img_1.jpg);  background-size:cover; background-position: center center;background-attachment:fixed;"
             data-section="home">
        <div class="overlay"></div>
        <a class="player"
           data-property="{videoURL:'https://www.youtube.com/watch?v=vqqt5p0q-eU',containment:'#home', showControls:false, autoPlay:true, loop:true, mute:true, startAt:0, opacity:1, quality:'default'}"></a>
        <div class="display-t text-center">
            <div class="display-tc">
                <div class="container">
                    <div class="col-md-12 col-md-offset-0">
                        <div class="animate-box">
                            <h2>CRM Targetting Platform</h2>
                            <p>We help grow profits, make marketing useful, and make customers happy</p>
                            <p><a href="#start" class="btn btn-primary btn-lg btn-custom">Get Started</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="start">
        <div class="colorlib-featured">
            <div class="row animate-box">
                <div class="featured-wrap">
                    <div class="owl-carousel">
                        <div class="item">
                            <div class="col-md-8 col-md-offset-2">
                                <div class="featured-entry">
                                    <img class="img-responsive" src="front/images/dashboard_full_1.jpg" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-md-8 col-md-offset-2">
                                <div class="featured-entry">
                                    <img class="img-responsive" src="front/images/dashboard_full_2.jpg" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-md-8 col-md-offset-2">
                                <div class="featured-entry">
                                    <img class="img-responsive" src="front/images/dashboard_full_3.jpg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="colorlib-services colorlib-bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-4 text-center animate-box">
                    <div class="services">
							<span class="icon">
								<i class="icon-browser"></i>
							</span>
                        <div class="desc">
                            <h3>Create your targetting list</h3>
                            <p>Simply upload your data and get it segmented. Segmented data will be your automated
                                purchase funnel. This is your targetting list.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-center animate-box">
                    <div class="services">
							<span class="icon">
								<i class="icon-download"></i>
							</span>
                        <div class="desc">
                            <h3>Automatic Backup Data</h3>
                            <p>Your data is stored in our servers with autobuckup mode. Large data is no problem.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-center animate-box">
                    <div class="services">
							<span class="icon">
								<i class="icon-layers"></i>
							</span>
                        <div class="desc">
                            <h3>Mailing</h3>
                            <p>Perform mailing right through service. Segmented customers list will leave you just to
                                use right words on right time!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="colorlib-work-featured colorlib-bg-white">
        <div class="container">
            <div class="row mobile-wrap">
                <div class="col-md-5 animate-box">
                    <div class="mobile-img" style="background-image: url(front/images/mobile-2.jpg);"></div>
                </div>
                <div class="col-md-7 animate-box">
                    <div class="desc">
                        <h2>RFM Analyze</h2>
                        <div class="features">
                            <span class="icon"><i class="icon-lightbulb"></i></span>
                            <div class="f-desc">
                                <p>The more <strong>recently</strong> a customer has made a purchase with a company, the
                                    more likely he
                                    or she will continue to keep the business and brand in mind for subsequent
                                    purchases. Compared with customers who have not bought from the business in months
                                    or even longer periods, the likelihood of engaging in future transactions with
                                    recent customers is arguably higher.</p>
                            </div>
                        </div>
                        <div class="features">
                            <span class="icon"><i class="icon-circle-compass"></i></span>
                            <div class="f-desc">
                                <p>The <strong>frequency</strong> of a customer’s transactions may be affected by
                                    factors such as the
                                    type of product, the price point for the purchase, and the need for replenishment or
                                    replacement. If the purchase cycle can be predicted, for example when a customer
                                    needs to buy new groceries, marketing efforts could be directed towards reminding
                                    them to visit the business when items such as eggs or milk have been depleted.</p>
                            </div>
                        </div>
                        <div class="features">
                            <span class="icon"><i class="icon-beaker"></i></span>
                            <div class="f-desc">
                                <p><strong>Monetary</strong> value stems from the lucrativeness of expenditures the
                                    customer makes with
                                    the business during their transactions. A natural inclination is to put more
                                    emphasis on encouraging customers who spend the most money to continue to do so.
                                    While this can produce a better return on investment in marketing and customer
                                    service, it also runs the risk of alienating customers who have been consistent but
                                    have not spent as much with each transaction.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="colorlib-subscribe" class="colorlib-subscribe"
                 style="background-image: url(front/images/cover_img_1.jpg);"
                 data-stellar-background-ratio="0.5">
                <div class="overlay"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 text-center colorlib-heading animate-box">
                            <h2>CRM Box mailing</h2>
                            <p>If you don't have your own domain. We also provide you with our mailing system. This one
                                is dedicated to work with large amount of data.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mobile-wrap">
                <div class="col-md-5 col-md-push-7 animate-box">
                    <div class="mobile-img" style="background-image: url(front/images/mobile-1.jpg);"></div>
                </div>
                <div class="col-md-7 col-md-pull-5 animate-box">
                    <div class="desc">
                        <h2>Analytics </h2>
                        <div class="features">
                            <span class="icon"><i class="icon-lightbulb"></i></span>
                            <div class="f-desc">
                                <p>Access to statistical analysis of your customers activity data.You may get familiar
                                    with each of your customer and give them individual opportunities. As well as
                                    creating the group of most loyal clients for special awards.</p>
                            </div>
                        </div>
                        <div class="features">
                            <span class="icon"><i class="icon-circle-compass"></i></span>
                            <div class="f-desc">
                                <p>Personalized automatic mailings do not spam, but inform the client about the prices
                                    and bonuses relevant to them for those goods and at the moment when it is
                                    relevant</p>
                            </div>
                        </div>
                        <div class="features">
                            <span class="icon"><i class="icon-beaker"></i></span>
                            <div class="f-desc">
                                <p>You may get familiar with each of your customer and give them individual
                                    opportunities. As well as creating the group of most loyal clients for special
                                    awards.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="colorlib-counter" class="colorlib-counters" style="background-image: url(front/images/cover_img_1.jpg);"
         data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-4 col-sm-4 text-center animate-box">
                        <div class="counter-entry">
                            <span class="icon"><i class="flaticon-ribbon"></i></span>
                            <div class="desc">
                                <span class="colorlib-counter js-counter" data-from="0" data-to="1" data-speed="5000"
                                      data-refresh-interval="50"></span>
                                <span class="colorlib-counter-label">Of customers are satisfied with our professional support</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 text-center animate-box">
                        <div class="counter-entry">
                            <span class="icon"><i class="flaticon-church"></i></span>
                            <div class="desc">
                                <span class="colorlib-counter js-counter" data-from="0" data-to="1" data-speed="5000"
                                      data-refresh-interval="50"></span>
                                <span class="colorlib-counter-label">Amazing preset options to be mixed and combined</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 text-center animate-box">
                        <div class="counter-entry">
                            <span class="icon"><i class="flaticon-dove"></i></span>
                            <div class="desc">
                                <span class="colorlib-counter js-counter" data-from="0" data-to="1" data-speed="5000"
                                      data-refresh-interval="50"></span>
                                <span class="colorlib-counter-label">Average response time on live chat support channel</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="colorlib-blog">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 text-center colorlib-heading animate-box">
                    <h2>News from our Blog</h2>
                    <p>Even the all-powerful Pointing has no control about the blind texts it is an almost
                        unorthographic life One day however a small line of blind text by the name of Lorem Ipsum
                        decided to leave for the far World of Grammar.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 animate-box">
                    <article>
                        <h2>Building the Mention Sales Application on Unapp</h2>
                        <p class="admin"><span>May 12, 2018</span></p>
                        <p>Even the all-powerful Pointing has no control about the blind texts it is an almost
                            unorthographic life</p>
                        <p class="author-wrap"><a href="#" class="author-img"
                                                  style="background-image: url(front/images/person1.jpg);"></a> <a href="#"
                                                                                                             class="author">by
                                Dave Miller</a></p>
                    </article>
                </div>
                <div class="col-md-4 animate-box">
                    <article>
                        <h2>Building the Mention Sales Application on Unapp</h2>
                        <p class="admin"><span>May 12, 2018</span></p>
                        <p>Even the all-powerful Pointing has no control about the blind texts it is an almost
                            unorthographic life</p>
                        <p class="author-wrap"><a href="#" class="author-img"
                                                  style="background-image: url(front/images/person2.jpg);"></a> <a href="#"
                                                                                                             class="author">by
                                Dave Miller</a></p>
                    </article>
                </div>
                <div class="col-md-4 animate-box">
                    <article>
                        <h2>Building the Mention Sales Application on Unapp</h2>
                        <p class="admin"><span>May 12, 2018</span></p>
                        <p>Even the all-powerful Pointing has no control about the blind texts it is an almost
                            unorthographic life</p>
                        <p class="author-wrap"><a href="#" class="author-img"
                                                  style="background-image: url(front/images/person3.jpg);"></a> <a href="#"
                                                                                                             class="author">by
                                Dave Miller</a></p>
                    </article>
                </div>
            </div>
        </div>
    </div>


    <footer id="colorlib-footer">
        <div class="container">
            <div class="row row-pb-md">
                <div class="col-md-3 colorlib-widget">
                    <h4>About CRM Box</h4>
                    <p>СRM-box will help you to improve your customer relations. And adjust your sales statistics. You
                        can also use our mailig system to deliver special offer to all of your customers</p>
                    <p>
                    <ul class="colorlib-social-icons">
                        <li><a href="#"><i class="icon-linkedin"></i></a></li>
                        <li><a href="#"><i class="icon-instagram"></i></a></li>
                        <li><a href="#"><i class="icon-twitter"></i></a></li>
                    </ul>
                    </p>
                </div>
                <div class="col-md-3 colorlib-widget">
                    <h4>Information</h4>
                    <p>
                    <ul class="colorlib-footer-links">
                        <li><a href="#"><i class="icon-check"></i> Login</a></li>
                        <li><a href="#"><i class="icon-check"></i> Registration</a></li>
                    </ul>
                    </p>
                </div>

                <div class="col-md-3 colorlib-widget">
                    <h4>Contact Info</h4>
                    <ul class="colorlib-footer-links">
                        <li>Abylaykhana Street 1, <br> Qarasay, Kaskelen</li>
                        <li><a href="tel://1234567920"><i class="icon-phone"></i> +7 778 728 42 34 </a></li>
                        <li><a href="mailto:info@yoursite.com"><i class="icon-envelope"></i> crm@info.com</a></li>
                        <li><a href="#"><i class="icon-location4"></i> crmbox.com</a></li>
                    </ul>
                </div>
            </div>
        </div>

    </footer>
</div>

<div class="gototop js-top">
    <a href="#" class="js-gotop"><i class="icon-arrow-up2"></i></a>
</div>

<!-- jQuery -->
<script src="front/js/jquery.min.js"></script>
<!-- jQuery Easing -->
<script src="front/js/jquery.easing.1.3.js"></script>
<!-- Bootstrap -->
<script src="front/js/bootstrap.min.js"></script>
<!-- Waypoints -->
<script src="front/js/jquery.waypoints.min.js"></script>
<!-- Stellar Parallax -->
<script src="front/js/jquery.stellar.min.js"></script>
<!-- YTPlayer -->
<script src="front/js/jquery.mb.YTPlayer.min.js"></script>
<!-- Owl carousel -->
<script src="front/js/owl.carousel.min.js"></script>
<!-- Magnific Popup -->
<script src="front/js/jquery.magnific-popup.min.js"></script>
<script src="front/js/magnific-popup-options.js"></script>
<!-- Counters -->
<script src="front/js/jquery.countTo.js"></script>
<!-- Main -->
<script src="front/js/main.js"></script>

</body>
</html>

