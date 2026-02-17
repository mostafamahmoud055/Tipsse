<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Services\MerchantService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function __construct(
        protected MerchantService $merchantService
    ) {}

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'min:3', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
            ],
            'password' => $this->passwordRules(),
            'national_id' => 'required|regex:/^\+?\d{7,17}$/',
            'phone' => 'required|regex:/^\+?\d{7,15}$/',
        ])->validate();

        return $this->merchantService->createNewMerchant($input);
    }
}
