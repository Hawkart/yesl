<div class="container">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="ui-block">

                <div class="top-header top-header-favorit">
                    <div class="top-header-thumb">

                        @if($group->owner_id==Auth::user()->id)
                            <overlay-upload uimg="{{ $group->cover ? Storage::disk('public')->url($group->cover) : '/img/university-overlay-default.jpg' }}" uploadapi="/groups/{{$group->id}}/cover" dataname="cover"></overlay-upload>
                        @else
                            <div class="top-header-overlay">
                                <img src="{{ $group->cover ? Storage::disk('public')->url($group->cover) : '/img/university-overlay-default.jpg' }}" alt="{{$group->title}}">
                            </div>
                        @endif

                        <div class="top-header-author" @if($group->owner_id==Auth::user()->id) style="z-index: 22;" @endif>

                            @if($group->owner_id==Auth::user()->id)
                                <avatar-upload dataname="image" uimg="{{ $group->image ? Storage::disk('public')->url($group->image) : '/img/university-logo-default.jpg' }}" uploadapi="/groups/{{$group->id}}/logo"></avatar-upload>
                            @else
                                <div class="author-thumb">
                                    <img src="{{ $group->image ? Storage::disk('public')->url($group->image) : '/img/university-logo-default.jpg' }}" alt="{{$group->title}}">
                                </div>
                            @endif

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
                            <div class="col-xl-3 m-auto col-lg-3 col-xs-12">
                            </div>
                            <div class="col-xl-6 m-auto col-lg-6 col-xs-12">
                                <ul class="profile-menu">
                                    <li>
                                        <a href="/universities/{{$group->slug}}">Posts</a>
                                    </li>
                                    @php
                                    $show = false;
                                    if(strpos($group->owner->email, '@campusteam.tv')===false)
                                        $show = true;
                                    @endphp
                                    <li>
                                        @if(!$show) <span class="isDisabled">  @endif
                                            <a href="/universities/{{$group->slug}}/teams" @if(!$show) class="disabled-link" @endif>Players Needed</a>
                                        @if(!$show) </span>  @endif
                                    </li>
                                </ul>
                            </div>
                            <div class="col-xl-3 m-auto col-lg-3 col-xs-12">
                                <group-subscribe :group_id = "{{$group->id}}" :user_id="{{Auth::id()}}"></group-subscribe>
                            </div>
                        </div>

                        <div class="control-block-button">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
