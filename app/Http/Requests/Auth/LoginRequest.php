<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Authenticate the user for the given request.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     */
    public function authenticate(Validator $validator): void
    {
        $this->ensureIsNotRateLimited($validator);

        // Attempt to authenticate the user
        if (! Auth::attempt($this->only('email', 'password'))) {
            // If authentication fails, add the error to the validator
            RateLimiter::hit($this->throttleKey());
            $validator->errors()->add('email', __('auth.failed'));
            return;
        }

        // If the user is authenticated, clear the rate limiter
        RateLimiter::clear($this->throttleKey());
    }


    /**
     * Check if the user is rate limited, and if so, trigger a lockout event and add
     * a throttle error message to the validator.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     */
    protected function ensureIsNotRateLimited(Validator $validator): void
    {
        // Check if the user has made too many attempts
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        // Trigger lockout event
        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        $validator->errors()->add('throttle', trans('auth.throttle', [
            'seconds' => $seconds,
            'minutes' => ceil($seconds / 60),
        ]));
    }

    /**
     * Generate a throttle key for the login request.
     *
     * @return string The throttle key
     */
    public function throttleKey(): string
    {
        return Str::transliterate(
            Str::lower($this->input('email')) . '|' . $this->ip()
        );
    }

    /**
     * Define actions to be taken after validation.
     *
     * @return array A list of callbacks to execute after validation.
     */
    protected function after()
    {
        return [
            function (Validator $validator) {
                $this->authenticate($validator);
            }
        ];
    }
}
