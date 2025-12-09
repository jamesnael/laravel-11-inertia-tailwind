<?php

namespace App\Actions\Fortify;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

class AuthenticateLoginAttempt
{
    /**
     * Override default login logic.
     *
     * @return \App\Model\User
     */
    public function __invoke(Request $request)
    {
        $user = User::where(function ($subquery) use ($request) {
            $subquery->where('email', $request->email)
                ->orWhere('username', $request->email);
        })
            ->where('status', true)
            ->whereHas('role', function (Builder $subquery) {
                $subquery->whereIn('tipe_user', ['Backend User']);
            })
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            return $user;
        }
    }
}
