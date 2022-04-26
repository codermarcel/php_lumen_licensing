<?php

namespace App\Http\Controllers;

use App\Exceptions\ClientException\ValidationException;
use App\Http\Controllers\Controller;
use App\Policies\BasePolicy;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Http\Request;

class AbstractController extends Controller
{
    /**
     * Validate the given request with the given rules.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @throws ValidationException
     * @return void
     */
    public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {
        $validator = $this->getValidationFactory()->make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) 
        {
            throw new ValidationException($validator->errors()->first());
        }
    }
}
