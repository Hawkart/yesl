<?php
namespace App\Http\Controllers;

use CountryState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cache;

class CountryController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $countries = Cache::remember('country_list', 36000, function () {
            $countries = CountryState::getCountries();
            return $countries;
        });

        if ($request->expectsJson() && $request->ajax())
            return response()->json($countries);
        else
            abort(404);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($slug, Request $request)
    {
        $countries = Cache::remember('country_list', 36000, function () {
            $countries = CountryState::getCountries();
            return $countries;
        });

        $country = $countries[$slug];

        if ($request->expectsJson() && $request->ajax())
            return response()->json($country);
        else
            abort(404);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function states($slug, Request $request)
    {
        $states = Cache::remember('country_states'.$slug, 36000, function () {
            return CountryState::getStates('US');
        });

        if ($request->expectsJson() && $request->ajax())
            return response()->json($states);
        else
            abort(404);
    }
}
