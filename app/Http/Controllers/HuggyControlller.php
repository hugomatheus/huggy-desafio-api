<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateHuggyWebhookRequest;
use App\Services\HuggyService;
use Illuminate\Http\RedirectResponse;

class HuggyControlller extends Controller
{
    private $huggyService;
    public function __construct(HuggyService $huggyService)
    {
        $this->huggyService = $huggyService;
    }
    public function redirect(): RedirectResponse 
    {
        return $this->huggyService->redirectProvider();
    }

    public function callback(): RedirectResponse
    {
        return $this->huggyService->callbackProvider();
    }

    public function validateWebHooks(ValidateHuggyWebhookRequest $request): string 
    {
        return $this->huggyService->validateWebHooks(request: $request);
    }
}
