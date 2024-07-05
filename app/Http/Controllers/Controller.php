<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    protected const string ALERT_SUCCESS = 'success';

    protected const string ALERT_WARNING = 'warning';

    protected const string ALERT_ERROR = 'error';

    protected const string ALERT_INFO = 'info';

    protected function withMessage(string $type, string $message): void
    {
        request()->session()->flash('alert', [
            'type' => $type,
            'header' => trans('messages.' . ucfirst($type)),
            'message' => trans($message),
        ]);
    }

    protected function getUser(): User
    {
        $user = Auth::user();
        if (! $user instanceof User) {
            abort(403);
        }

        return $user;
    }
}
