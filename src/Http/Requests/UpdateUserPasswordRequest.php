<?php namespace Tukecx\Base\Users\Http\Requests;

use Tukecx\Base\Core\Http\Requests\Request;

class UpdateUserPasswordRequest extends Request
{
    public $rules = [
        'password' => 'required|max:60|confirmed|min:5|string'
    ];
}
