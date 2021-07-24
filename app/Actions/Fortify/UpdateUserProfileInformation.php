<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Carbon\Carbon;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'name' => [
                'required',
                'string',
                'max:100',
            ],
            'username' => [
                'required',
                'string',
                'alpha_dash',
                Rule::unique('App\Models\User', 'username')->ignore($user->id)->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
                'max:100',
            ],
            'email'    => [
                'required',
                'string',
                'email:rfc,dns',
                Rule::unique('App\Models\User', 'email')->ignore($user->id)->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
                'max:100',
            ],
            'phone'    => [
                'required',
                'numeric',
                Rule::unique('App\Models\User', 'phone')->ignore($user->id)->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
                'digits_between:1,20',
            ],
            'date_of_birth' => [
                'nullable',
                'date',
                'date_format:Y-m-d',
            ],
            'address' => [
                'nullable',
                'string',
                'max:200',
            ],
            'photo' => [
                'nullable',
                'mimes:jpg,jpeg,png',
                'max:1024'
            ],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email && $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'username' => $input['username'],
                'email' => $input['email'],
                'phone' => $input['phone'],
                'date_of_birth' => $input['date_of_birth'],
                'address' => $input['address'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
