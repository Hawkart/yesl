
@if(Route::currentRouteName()!='application')
    <div class="modal fade dialog-vertical-center" id="myDialog" tabindex="-1" role="dialog"
         aria-labelledby="chat-dialog-form" aria-hidden="true" data-keyboard="false" data-backdrop="static"
    >
        <div class="modal-dialog  window-popup choose-from-my-photo" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="title">Welcome!</h6>
                </div>
                <div class="modal-body">
                    @if(Auth::user()->isCoach())
                        <p>Dear {{Auth::user()->university->title}} coach!<br>
                            Thank you for joining CampusTeam community.<br>
                        </p><p>
                            @if(Auth::user()->university->group()->count()>0)
                                In order to make communication with prospective students more efficient,
                                we suggest you go to the Teams section on the university page:<br>
                                <u><a href="/universities/{{Auth::user()->university->group->slug}}/teams"  class="text-danger">
                                        {{url('/universities/'.Auth::user()->university->group->slug.'/teams')}}
                                    </a></u> select existing and future teams and mark those of them which you are currently recruiting players in.<br>
                            @endif
                        </p><p>
                            You can change the logo and overlay on the university page if you need it.<br>
                            To change Esports team logo, please send the new logo to support@campusteam.tv
                        </p>
                    @else
                        <p>Dear, <strong>{{Auth::user()->name}}</strong>!<br>
                            Thank you for joining CampusTeam community.<br>
                        </p><p>To make communication with varsity Esports coaches more efficient, we suggest that you fill out your <u><a href="/settings/profiles" class="text-danger">Gamer profile</a></u> and <u><a href="/settings" class="text-danger">Resume</a></u> before you start chatting with coaches.<br>
                        </p><p>To send message to the coach, select the university and click the button “Message to the Coach” on the university page.<br>
                        </p><p>When applying to university Esports teams, a completed Gamer profile and Resume are required.<br>
                            We recommend you to upload the foto and overlay on <u><a href="/users/{{Auth::user()->nickname}}"  class="text-danger">you page</a></u> to make it easier for your friends to find you in CampusTeam community.
                        </p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary mb-0" data-dismiss="modal" onclick="confirmWelcome()">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <div class="alert text-center cookiealert" role="alert">
        <p>
            Our website uses first-party and third-party cookies to improve our services and show you content and advertising according to your preferences through the analysis of your browsing habits.<br>
            By continuing to browse this website you accept this use of cookies. For more information about cookies, please visit our <a href="/cookies-policy" class="text-white">сookies policy</a>.
            <button type="button" class="btn btn-primary btn-sm acceptcookies mb-0" aria-label="Close">
                I agree
            </button>
        </p>
    </div>

    <script src="{{ asset('js/cookie.js') }}"></script>

    <script>
        if (localStorage.getItem('confirm_welcome') === null)
            $('#myDialog').modal({backdrop: 'static', keyboard: false, show: true});

        function confirmWelcome() {
            localStorage.setItem('confirm_welcome', true);
        }
    </script>

    <div class="a2a_kit a2a_kit_size_32 a2a_floating_style a2a_vertical_style">
        <a class="a2a_button_facebook"></a>
        <a class="a2a_button_twitter"></a>
        <a class="a2a_button_linkedin"></a>
        <a class="a2a_button_reddit"></a>
        <a class="a2a_button_telegram"></a>
    </div>

    <script async src="https://static.addtoany.com/menu/page.js"></script>
@endif
