<div class="col-xl-3 order-xl-1 col-lg-6 order-lg-2 order-md-2 order-sm-2 order-2 col-md-12 col-sm-12 col-12">
    <div class="ui-block">
        <div class="ui-block-title"><h6 class="title">Info about college</h6></div>
        <div class="ui-block-content">
            <ul class="widget w-personal-info item-block">
                @if(!empty($group->groupable->admission_rate_overall))
                    <li>
                        <span class="text">Admission rate: <strong>{{$group->groupable->admission_rate_overall*100}}%</strong></span>
                    </li>
                @endif

                @if(!empty($group->groupable->sat_scores_average_overall))
                    <li>
                        <span class="text">Average SAT equivalent score: <strong>{{$group->groupable->sat_scores_average_overall}}</strong></span>
                    </li>
                @endif

                @if(!empty($group->groupable->demographics_female_share))
                    <li>
                        <span class="text">Female/Male students: <strong>{{$group->groupable->demographics_female_share*100}}%/{{100-$group->groupable->demographics_female_share*100}}%</strong></span>
                    </li>
                @endif

                @if(!empty($group->groupable->demographics_married))
                    <li>
                        <span class="text">Married students: <strong>{{$group->groupable->demographics_married*100}}%</strong></span>
                    </li>
                @endif

                @if(!empty($group->groupable->cost_tuition_in_state))
                    <li>
                        <span class="text">In-state/ Out-of-state tuition and fees:
                            <strong>${{number_format($group->groupable->cost_tuition_in_state)}}/${{number_format($group->groupable->cost_tuition_out_of_state)}}</strong>
                        </span>
                    </li>
                @endif

                @if(!empty($group->groupable->price_calculator_url))
                    <li>
                        <span class="text">
                            <a href="//{{ str_replace(['https:', "http:", "//", "www."], '', $group->groupable->price_calculator_url)}}" target="_blank" class="btn btn-primary btn-sm full-width">Net Price Calculator</a>
                        </span>
                    </li>
                @endif

                @if(!empty($group->groupable->aid_pell_grant_rate))
                    <li>
                        <span class="text"><strong>{{$group->groupable->aid_pell_grant_rate*100}}%</strong> receive a Pell Grant</span>
                    </li>
                @endif

                @if(!empty($group->groupable->aid_federal_loan_rate))
                    <li>
                        <span class="text"><strong>{{$group->groupable->aid_federal_loan_rate*100}}%</strong> receiving a student loan</span>
                    </li>
                @endif

                @if($group->groupable->ownership)
                    <li>
                        <span class="text">
                            <strong>
                            @if($group->groupable->ownership==1)
                                    Public
                                @elseif($group->groupable->ownership==2)
                                    Private nonprofit
                                @elseif($group->groupable->ownership==3)
                                    Private for-profit
                                @endif
                            </strong>
                                institution
                        </span>
                    </li>
                @endif

                @if(!empty($group->groupable->demographics_age_entry))
                    <li>
                        <span class="text">Average age of entry: <strong>{{$group->groupable->demographics_age_entry}}</strong></span>
                    </li>
                @endif

                @if(!empty($group->groupable->url))
                <!--<li>
                                    <a href="//{{$group->groupable->url}}" target="_blank" class="btn btn-success btn-sm full-width mb-0">Website</a>
                                </li>-->
                @endif

                @if($group->groupable->majors->count()>0)
                    @php
                        $majors = $group->groupable->majors->sortBy(function($major){
                            return $major->title;
                        })->pluck('title');
                    @endphp
                    <li>
                        <hr/>
                        <span class="text"><strong>Majors: </strong></span>
                        <ol>
                            @foreach($majors as $key=>$major)
                                <li class="major-item"@if($key>9) style="display: none;" @endif>{{$major}}</li>
                            @endforeach
                        </ol>
                    </li>
                    <li>
                        <a href="javascript:void(0);" onclick="mshow('.major-item'); this.style.display='none'" class="btn btn-success btn-sm full-width mb-0 mt-0">show more</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
<script>
    function mshow(which){
        var elems = document.querySelectorAll(which);

        [].slice.call(elems).forEach(function(el) {
            el.style.display = 'block';
        });
    }
</script>
