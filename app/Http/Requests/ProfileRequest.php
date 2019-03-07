<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ProfileRequest extends FormRequest {
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
                    $game_id = $request->get('game_id');

                    return [
                        'game_id' => [
                            'required',
                            Rule::unique('profiles')->where(function ($query) use($game_id, $user) {
                                return $query->where('game_id', $game_id)
                                    ->where('user_id', $user->id);
                            }),
                        ],

                        'nickname'  => 'required|string|max:255',
                        'link'      => 'required|url',
                        'rank'   => 'required',
                        'have_banned' => 'required'
                    ];
                }
            case 'PUT':
            case 'PATCH':
                {
                    $game_id = $request->get('game_id');

                    return [
                        'game_id' => [
                            'required',
                            Rule::unique('profiles')->where('id', '<>', $this->id)->where(function ($query) use($game_id, $user) {
                                return $query->where('game_id', $game_id)
                                    ->where('user_id', $user->id);
                            }),
                        ],
                        'nickname'  => 'required|string|max:255',
                        'link'      => 'required|url',
                        'rank'   => 'required',
                        'have_banned' => 'required'
                    ];
                }
            default:break;
        }
    }


    public function messages()
    {
        return [
            'game_id.unique' => 'You are already have gamer profile with selected game.',
        ];
    }
}
