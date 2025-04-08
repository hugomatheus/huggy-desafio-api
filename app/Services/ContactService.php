<?php

namespace App\Services;

use App\Jobs\SendNewContactMailJob;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Repositories\ContactRepository;

class ContactService
{
    private $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function all(Request $request)
    {
        return $this->contactRepository->findAll($request);
    }

    public function find($id)
    {
        return $this->contactRepository->findById($id);
    }

    public function create(array $data): Contact
    {
        $contact = $this->contactRepository->create($data);
        $dispatchData = [
            'mail_to' => $contact->email,
            'subject' => 'Novo Contato',
            'name_contact' => $contact->name,
            'message_contact' => 'Novo contato adicionado',
        ];

        SendNewContactMailJob::dispatch($dispatchData)->delay(now()->addMinutes(30));
        return $contact;
    }

    public function update($id, array $data)
    {
        return $this->contactRepository->edit($id, $data);
    }

    public function delete($id)
    {
        return $this->contactRepository->delete($id);
    }

    public function getCharts()
    {
        $chartCity = $this->contactRepository->getByCity();
        $chartState = $this->contactRepository->getByState();
        return ['chart_city' => $chartCity, 'chart_state' => $chartState];
    }
}
