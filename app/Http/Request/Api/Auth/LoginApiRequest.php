<?php


namespace App\Http\Request\Api\Auth;


use App\Http\Request\ApiBaseRequest;

class LoginApiRequest extends ApiBaseRequest
{
    public function injectedRules()
    {
        return [
            'email' => ['required'],
            'password' => ['required'],
        ];
    }
}
