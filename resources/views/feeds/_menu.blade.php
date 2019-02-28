<div class="col-xl-3 order-xl-1 col-lg-6 order-lg-2 col-md-6 col-sm-12 col-12">
    <div class="ui-block">
        <div class="your-profile">
            <div id="accordion" role="tablist" aria-multiselectable="true">
                <div class="card">
                    <div class="card-header" role="tab" id="headingOne">
                        <h6 class="mb-0">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                News
                                <svg class="olymp-dropdown-arrow-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-dropdown-arrow-icon"></use></svg>
                            </a>
                        </h6>
                    </div>

                    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                        <ul class="your-profile-menu">
                            <li>
                                <a href="{{route('my.groups')}}">Images</a>
                            </li>
                            <li>
                                <a href="{{route('my.groups')}}">Links</a>
                            </li>
                            <li>
                                <a href="{{route('groups')}}">Friends</a>
                            </li>
                            <li>
                                <a href="{{route('groups')}}">Groups</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!--<div id="accordion-2" role="tablist" aria-multiselectable="true">
                <div class="card">
                    <div class="card-header" role="tab" id="headingTwo">
                        <h6 class="mb-0">
                            <a data-toggle="collapse" data-parent="#accordion-2" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                Recommended
                                <svg class="olymp-dropdown-arrow-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-dropdown-arrow-icon"></use></svg>
                            </a>
                        </h6>
                    </div>

                    <div id="collapseTwo" class="collapse show" role="tabpanel" aria-labelledby="headingTwo">
                        <ul class="your-profile-menu">
                            <li>
                                <a href="{{route('my.groups')}}">Groups</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>-->
        </div>
    </div>
</div>
