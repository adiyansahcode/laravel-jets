<?php

declare(strict_types=1);

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Validation\Rule;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => [
                'required',
                'string',
                'max:100'
            ],
            'username' => [
                'required',
                'string',
                'alpha_dash',
                Rule::unique('App\Models\User', 'username')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
                'max:100',
            ],
            'email' => [
                'required',
                'string',
                'email:rfc,dns',
                Rule::unique('App\Models\User', 'email')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
                'max:100',
            ],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        return DB::transaction(function () use ($input) {
            return User::create([
                'username' => $input['username'],
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);
        });
    }
}
