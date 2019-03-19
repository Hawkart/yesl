<chat-dialog-form></chat-dialog-form>
<popup-google-map></popup-google-map>
<repost-popup></repost-popup>

@if(!Auth::user()->isCoach())
    @php
        $countProfiles = Auth::user()->profiles()->count();
    @endphp

    @if($countProfiles==0)
        <div class="modal fade" id="warning-profile" tabindex="-1" role="dialog" aria-labelledby="chat-dialog-form" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="title">Warning</h6>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" role="alert">
                            You need to create at least one <a href="/settings/profiles" class="alert-link">Gamer Profile</a>.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($countProfiles==0 || empty(Auth::user()->description))
        <div class="modal fade" id="warning-resume-profile" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="title">Warning</h6>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" role="alert">
                            You need

                            @if($countProfiles==0)
                                to create at least one <a href="/settings/profiles" class="alert-link">Gamer Profile</a>
                            @endif

                            @if(empty(Auth::user()->description))
                                @if($countProfiles==0) and @endif

                                fill <a href="/settings" class="alert-link">Resume</a>.
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif

<a class="back-to-top" href="#">
    <img src="/svg-icons/back-to-top.svg" alt="arrow" class="back-icon">
</a>

