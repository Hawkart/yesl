<div class="footer footer-full-width" id="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

                <!-- Widget About -->

                <div class="widget w-about">

                    <a href="{{url('/')}}" class="logo">
                        <div class="img-wrap">
                            <img src="/img/logo.png" alt="CampusTeam">
                        </div>
                        <div class="title-block">
                            <h6 class="logo-title">Campus</h6>
                            <div class="logo-title">TEAM</div>
                        </div>
                    </a>

                    <p>CampusTeam is a social media around varsity Esports.</p>
                    <p>
                        220 East 23rd Street, New York, NY 10010
                    </p>
                    <p>
                        (315) 636-5354
                    </p>
                    <ul class="socials">
                        <li>
                            <a href="https://www.facebook.com/CampusTeam-371327433464027" target="_blank">
                                <i class="fab fa-facebook-square" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://twitter.com/campusteam1" target="_blank">
                                <i class="fab fa-twitter" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.youtube.com/watch?v=SW8w3IPaQlU" target="_blank">
                                <i class="fab fa-youtube" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.linkedin.com/company/campusteam/" target="_blank">
                                <i class="fab fa-linkedin" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                <div class="widget w-list">
                    <h6 class="title">Let’s get started</h6>
                    <ul>
                        <li>
                            <a href="/">Home</a>
                        </li>
                        <li>
                            <a href="/login">Login</a>
                        </li>
                        <li>
                            <a href="/register">Register as an Athlete</a>
                        </li>
                        <li>
                            <a href="/register-coach">Register as a Coach</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                <div class="widget w-list">
                    <h6 class="title">What’s next</h6>
                    <ul>
                        <li>
                            <a href="/universities">Select a college/university</a>
                        </li>
                        <li>
                            <a href="/write-to-coach">Write message to a coach</a>
                        </li>
                        <li>
                            <a href="/apply-to-team">Apply to a team</a>
                        </li>
                        <li>
                            <a href="/feeds">Read the newsfeed</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                <div class="widget w-list">
                    <h6 class="title">&nbsp;</h6>
                    <ul>
                        <li>
                            <a href="/">Make a post</a>
                        </li>
                        <li>
                            <a href="/friends">Find friends</a>
                        </li>
                        <li>
                            <a href="/im">Exchange messages</a>
                        </li>
                        <li>
                            <a href="/games">Explore Games</a>
                        </li>
                    </ul>
                </div>

            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">

                <div class="widget w-list">
                    <h6 class="title">CampusTeam</h6>
                    <ul>
                        <li>
                            <a href="/about">About</a>
                        </li>
                        <li>
                            <a href="/contacts">Contact us</a>
                        </li>
                        <li>
                            <a href="/legal/confidential">Privacy Policy</a>
                        </li>
                        <!--<li>
                            <a href="/legal/term-and-conditions">Terms and Conditions</a>
                        </li>-->
                        <li>
                            <a href="/legal/term-of-service">Terms of Service</a>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sub-footer-copyright">
					<span>
                        <a href="#" data-toggle="modal" data-target="#youtubeModal" class="btn btn-md btn-blue c-white">
                            Look inside without registration
                        </a><br>
						Copyright CampusTeam All Rights Reserved 2018<br>
                        info@campusteam.tv
					</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="a2a_kit a2a_kit_size_32 a2a_floating_style a2a_vertical_style">
    <a class="a2a_button_facebook"></a>
    <a class="a2a_button_twitter"></a>
    <a class="a2a_button_linkedin"></a>
    <a class="a2a_button_reddit"></a>
    <a class="a2a_button_telegram"></a>
</div>

<script async src="https://static.addtoany.com/menu/page.js"></script>

<div class="modal fade" id="youtubeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog w-100" role="document">
        <div class="modal-content w-100">
            <div class="modal-body">
                <div class="videoWrapper">
                    <div id="play"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="//www.youtube.com/player_api"></script>
<script>
    function onYouTubePlayerAPIReady() {
        play = new YT.Player('play', {videoId: 'SW8w3IPaQlU'});
        $('#youtubeModal').on('hidden.bs.modal', function () {
            play.pauseVideo();
        });
    }
</script>
