<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ApplicationRequest extends FormRequest {
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
                    $uid = $request->get('user_id');
                    $pid = $request->get('profile_id');
                    $tid = $request->get('team_id');

                    return [
                        'team_id' => [
                            'required',
                            'exists:teams,id',
                            Rule::unique('applications')->where(function ($query) use($uid, $pid, $tid) {
                                return $query->where('user_id', $uid)
                                    ->where('profile_id', $pid)
                                    ->where('team_id', $tid);
                            })
                        ],
                        'user_id'  => 'required|exists:users,id',
                        'profile_id' => 'required|exists:profiles,id'
                    ];
                }
            case 'PUT':
            case 'PATCH':
                {

                }
            default:break;
        }
    }


    public function messages()
    {
        return [
            'team_id.unique' => 'You are already applied with this application.',
        ];
    }
}
