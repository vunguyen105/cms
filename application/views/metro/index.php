<? $this->load->view(CURRENT_THEME . '/includes/header_tags'); ?>
</head>
<body class="metrouicss" onload="prettyPrint()">
<? $this->load->view(CURRENT_THEME . '/includes/menu_navigation'); ?>
<div class="page" id="page-index">
<div class="page-region">
<div class="page-region-content">
<div class="grid">
    <div class="row">
        <div class="span8">
            <div class="hero-unit">
                <div id="carousel1" class="carousel" data-role="carousel" data-param-duration="300">
                    <div class="slides">

                        <div class="slide" id="slide1">
                            <h2>Create site in Windows 8 style now!</h2>

                            <p class="bg-color-blueDark padding20 fg-color-white">Metro UI CSS allows to create a Web
                                site in the style of
                                Windows 8 quickly and without distractions
                                on routine tasks.</p>

                            <h3>To start: include <strong>modern.css</strong> in head of page</h3>

                            <p class="tertiary-info-text">
                                &lt;link href="modern.css" rel="stylesheet"&gt; and add to metro container <strong>metrouicss</strong>
                                class. Example: &lt;body class="metrouicss"&gt;...&lt;/body&gt;
                            </p>
                        </div>

                        <div class="slide" id="slide2">
                            <h2 class="fg-color-darken">Metro UI CSS</h2>

                            <p class="bg-color-pink padding20 fg-color-white">
                                Developed with the advice of Microsoft to build the user interface and
                                <strong>include:</strong>
                            </p>

                            <div class="span3 place-left">
                                <ul class="unstyled sprite-details">
                                    <li><i class="icon-checkmark"></i> General styles</li>
                                    <li><i class="icon-checkmark"></i> Grid with Responsive</li>
                                    <li><i class="icon-checkmark"></i> Layouts</li>
                                </ul>
                            </div>
                            <div class="span3 place-left">
                                <ul class="unstyled sprite-details">
                                    <li><i class="icon-checkmark"></i> Typography</li>
                                    <li><i class="icon-checkmark"></i> Many components</li>
                                    <li><i class="icon-checkmark"></i> 300+ built in icons</li>
                                </ul>
                            </div>
                        </div>

                        <div class="slide" id="slide3">
                            <h2>Metro UI CSS is a BizSpark Startup</h2>

                            <p class="bg-color-red fg-color-white padding20">
                                Microsoft® BizSpark® is a global program that helps software startups succeed by giving
                                them access to software development tools, connecting them with key industry players,
                                and providing marketing visibility.
                            </p>

                            <p><a href="http://bizspark.com">Join</a> the BizSpark Program now.</p>
                        </div>
                    </div>

                    <span class="control left"><i class="icon-arrow-left-3"></i></span>
                    <span class="control right"><i class="icon-arrow-right-3"></i></span>

                </div>
            </div>
        </div>
        <div class="span4">
            <div class="span4 padding30 text-center place-left bg-color-blueLight" id="sponsorBlock">
                <br/>
                <br/>

                <h2 class="fg-color-red">project is looking for a sponsor</h2>

                <p class="">2000+ <a class="" href="http://hit.ua/site_view/19154">users</a> every day</p>
                <br/>
                <a href="sponsoring.php"><h1><i class="icon-arrow-right-3 fg-color-red"></i></h1></a>
            </div>
        </div>
    </div>
</div>

<div class="grid">
    <div class="row">
        <div class="span4 bg-color-blue">
            <img src="<?=base_url('asset/themes/'.CURRENT_THEME)?>/images/simple.png" class="place-right" style="margin: 10px;"/>

            <h2 class="fg-color-white">&nbsp;Attendance</h2>
        </div>

        <div class="span4 bg-color-green">
            <img src="<?=base_url('asset/themes/'.CURRENT_THEME)?>/images/grid.png" class="place-right" style="margin: 10px;"/>

            <h2 class="fg-color-white">&nbsp;Staff</h2>
        </div>

        <div class="span4 bg-color-yellow">
            <img src="<?=base_url('asset/themes/'.CURRENT_THEME)?>/images/responsive.png" class="place-right" style="margin: 10px;"/>

            <h2 class="fg-color-white">&nbsp;Gallery</h2>
        </div>
    </div>
</div>

<div class="grid">
    <div class="row">
        <div class="span8">
            <h2>Welcome</h2>

            <p>
                Metro UI CSS a set of styles to create a site with an interface similar to Windows 8 Metro UI. This set
                of styles was developed as a self-contained solution.
            </p>

            <p class="bg-color-blueLight padding20 tertiary-text1">
                Metro UI CSS is made with <a href="http://lesscss.org" class="fg-color-blue"><abbr
                title="LESS a dynamic stylesheet language created by one good man Alexis Sellier">LESS</abbr></a>. It
                makes developing systems-based CSS faster, easier, and more fun.
            </p>

            <p>
                <strong>Metro UI CSS is free if you placed back link to Metro UI CSS site.</strong>
                <br/>
                Example:
                <br/>
            </p>
            <blockquote class="tertiary-text">
                Styled with &lt;a href="http://metroui.org.ua"&gt;Metro UI CSS&lt;/a&gt;
            </blockquote>


            <h2>Browsers</h2>

            <div class="browsers-icons clearfix">
                <h2 class="place-left" title="Internet Explorer 9+"><i class="icon-IE"></i></h2>

                <h2 class="place-left" title="Chrome"><i class="icon-chrome"></i></h2>

                <h2 class="place-left" title="Firefox"><i class="icon-firefox"></i></h2>

                <h2 class="place-left" title="Opera"><i class="icon-opera"></i></h2>

                <h2 class="place-left" title="Safari"><i class="icon-safari"></i></h2>
            </div>

            <blockquote class="tertiary-text">
                Internet explorer supported from 9 version.
            </blockquote>
        </div>
        <div class="span4">
            <h2>GitHub Info:</h2>
            <table class="github-info" data-repo="olton/Metro-UI-CSS">
                <tbody>
                <tr>
                    <td><i class="icon-star-4"></i> Starred:</td>
                    <td class="right"><span class="github-watchers">1000</span></td>
                </tr>
                <tr>
                    <td><i class="icon-share-2"></i> Forks:</td>
                    <td class="right bg"><span class="github-forks">220</span></td>
                </tr>
                <tr>
                    <td colspan="2" style="padding: 20px 0 0; border: 0;" class="right">
                        <button class="image-button bg-color-pink fg-color-white"
                                onclick="document.location.href='https://github.com/olton/Metro-UI-CSS'">View on
                            Github<img class="bg-color-pinkDark" src="images/github.png"/></button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
</div>
</div>
<? $this->load->view(CURRENT_THEME . '/includes/footer'); ?>
