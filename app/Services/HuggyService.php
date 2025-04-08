<?php

namespace App\Services;

use App\Repositories\ContactRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class HuggyService
{
    private $userRepository;
    private $contactRepository;
    public function __construct(UserRepository $userRepository, ContactRepository $contactRepository)
    {
        $this->userRepository = $userRepository;
        $this->contactRepository = $contactRepository;
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

    public function webhooks(Request $request): string
    {
        $data = $request->all();
        if (
            isset($data['messages']) &&
            isset($data['messages']['createdCustomer']) &&
            is_array($data['messages']['createdCustomer']) &&
            count($data['messages']['createdCustomer']) > 0
        ) {
            $contact = $data['messages']['createdCustomer'][0];
            $this->contactRepository->upateOrCreate($contact);
        }
        return $request->input(key: 'token');
    }
}
