<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $user = Auth::user();

        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
                {
                    return [];
                }
            case 'POST':
                {
                    return [
                        'first_name' => 'required|string|max:255',
                        'last_name' => 'required|string|max:255',
                        'email' => 'required|string|email|max:255',//|unique:users',
                        'password' => 'required|string|min:6',
                        'terms' => 'required|accepted',
                        'gender' => 'required'//,
                        //'date_birth' => 'required|date_format:Y-m-d|before:today'
                    ];
                }
            case 'PUT':
            case 'PATCH':
                {
                    if($user->isCoach())
                    {
                        $validator = [
                            'first_name' => 'required|string|max:255',
                            'last_name' => 'required|string|max:255',
                            'description' => 'required'
                        ];
                    }else{
                        $validator = [
                            'first_name' => 'required|string|max:255',
                            'last_name' => 'required|string|max:255',
                            'description' => 'required',
                            'apply_as' => 'required',
                            'gpa' => 'required|numeric|min:1',
                            'country' => 'required',
                            'street' => 'required',
                            'city' => 'required',
                            'postal_code' => 'required'
                        ];

                        if($request->get('is_foreign'))
                            $validator['toefl_paper'] = 'required_without_all:toefl_computer,toefl_internet';

                        if($request->get('apply_as')==0)
                            $validator['act_scored'] = 'required_without:sat_scored';
                        else
                            $validator['transfer_hours'] = 'required|numeric|min:1';

                        return $validator;
                    }
                }
            default:break;
        }
    }


    public function messages()
    {
        return [

        ];
    }
}
