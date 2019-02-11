<div class="container">
    <div class="row">
        <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="ui-block">

                <div class="top-header top-header-favorit">
                    <div class="top-header-thumb">
                        <div class="top-header-overlay">
                            <img src="{{ $group->cover ? Storage::disk('public')->url($group->cover) : '/img/university-overlay-default.jpg' }}" alt="{{$group->title}}">
                        </div>
                        <div class="top-header-author">

                            <div class="author-thumb">
                                <img src="{{ $group->image ? Storage::disk('public')->url($group->image) : '/img/university-logo-default.jpg' }}" alt="{{$group->title}}">
                            </div>

                            <div class="author-content">
                                <a href="#" class="h3 author-name">{{$group->title}} <span class="verified"><i class="fa fa-check" aria-hidden="true" title="Verified"></i></span></a>
                                <div class="country">
                                    <span class="title">Address:</span>
                                    <span class="text">{{$group->groupable->address}}
                                        @if(!empty($group->groupable->location_lat))
                                            <pin-popup-google-map :university="{{json_encode($group->groupable->toArray())}}"></pin-popup-google-map>
                                        @endif
                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-section">
                        <div class="row">
                            <div class="col col-xl-8 m-auto col-lg-8 col-md-12">
                                <ul class="profile-menu">
                                    <li>
                                        <a href="/universities/{{$group->slug}}">Posts</a>
                                    </li>
                                    <li>
                                        <a href="/universities/{{$group->slug}}/teams">Teams</a>
                                    </li>
                                    <li>
                                        <a href="/universities/{{$group->slug}}/vacancies">Vacancies</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="control-block-button">

                        </div>
                    </div>
                </div>

            <!--
                    <div class="top-header top-header-favorit university-overlay" style="background-image: url({{ $group->cover ? Storage::disk('public')->url($group->cover) : '/img/top-header1.jpg' }})"></div>
                    -->
            </div>
        </div>
    </div>
</div>
