<?php

namespace App\Http\Controllers;

use App\Services\HuggyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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

    public function webhooks(Request $request): string 
    {
        return $this->huggyService->webhooks(request: $request);
    }

}
