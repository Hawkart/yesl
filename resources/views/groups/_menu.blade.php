<div class="col-xl-3 order-xl-1 col-lg-3 order-lg-1 col-md-12 order-md-2 col-sm-12 responsive-display-none">
    <div class="ui-block">
        <div class="your-profile">
            <div class="ui-block-title ui-block-title-small">
                <h6 class="title">MENU</h6>
            </div>

            <div id="accordion" role="tablist" aria-multiselectable="true">
                <div class="card">
                    <div class="card-header" role="tab" id="headingOne">
                        <h6 class="mb-0">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Groups
                                <svg class="olymp-dropdown-arrow-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-dropdown-arrow-icon"></use></svg>
                            </a>
                        </h6>
                    </div>

                    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                        <ul class="your-profile-menu">
                            <li>
                                <a href="{{route('my.groups')}}">My groups</a>
                            </li>
                            <li>
                                <a href="{{route('groups')}}">Search groups</a>
                            </li>
                            <!--<li>
                                <a href="{{route('groups.popular')}}">Popular groups</a>
                            </li>-->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--<div class="ui-block">
        <div class="your-profile">
            <div class="ui-block-title ui-block-title-small">
                <h6 class="title">Recommendations</h6>
            </div>
        </div>
    </div>-->
</div>
