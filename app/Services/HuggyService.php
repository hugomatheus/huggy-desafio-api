<?php

namespace App\Services;

use App\Http\Requests\ValidateHuggyWebhookRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class HuggyService
{
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function redirectProvider(): RedirectResponse
    {
        return Socialite::driver(driver: 'huggy')->redirect();
    }

    public function callbackProvider(): RedirectResponse
    {
        $userByHuggy = Socialite::driver('huggy')->stateless()->user();
        $user = $this->userRepository->findByEmail(email: $userByHuggy->email);
        if (!$user) {
            $user = $this->userRepository->create(data: [
                'name' => $userByHuggy->name,
                'email' => $userByHuggy->email,
                'password' => bcrypt(value: Str::random(length: 16)),
            ]);
        }

        $token = $user->createToken(name: 'huggy_auth_token')->plainTextToken;
        return redirect(env('APP_FRONTEND') . "/huggy-callback?token=$token");
    }

    public function validateWebHooks(ValidateHuggyWebhookRequest $request): string
    {
        return $request->input(key: 'token');
    }
}
