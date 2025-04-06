<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Services\ContactService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    private $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function index(Request $request): JsonResponse
    {
        $contacts = $this->contactService->all($request);
        return response()->json($contacts);
    }

    public function show($id): JsonResponse
    {
        $contact = $this->contactService->find($id);
        return response()->json($contact);
    }

    public function store(StoreContactRequest $request): JsonResponse
    {
        $contact = $this->contactService->create($request->all());
        return response()->json($contact, 201);
    }

    public function update(UpdateContactRequest $request, $id): JsonResponse
    {
        $contact = $this->contactService->update($id, $request->all());
        return response()->json($contact);
    }

    public function destroy($id): JsonResponse
    {
        $this->contactService->delete($id);
        return response()->json(['message' => 'Contato removido com sucesso.']);
    }
}
