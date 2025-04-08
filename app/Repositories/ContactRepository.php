<?php

namespace App\Repositories;

use App\Models\Contact;
use App\Models\ViewContactByCity;
use App\Models\ViewContactByState;
use Illuminate\Http\Request;

class ContactRepository
{
    private $contact;
    private $viewContactByCity;
    private $viewContactByState;

    public function __construct(Contact $contact, ViewContactByCity $viewContactByCity, ViewContactByState $viewContactByState)
    {
        $this->contact = $contact;
        $this->viewContactByCity = $viewContactByCity;
        $this->viewContactByState = $viewContactByState;
    }

    public function findAll(Request $request)
    {
        $allowedSorts = ['name', 'email', 'created_at'];
        $allowedDirections = ['asc', 'desc'];
        $filters = ['name', 'email'];

        $sort = in_array($request->input('sort'), $allowedSorts) ? $request->input('sort') : 'name';
        $direction = in_array($request->input('direction'), $allowedDirections) ? $request->input('direction') : 'asc';
        $perPage = $request->input('per_page', 50);
        $search = $request->input('search', null);

        $query = $this->contact->with('address');

        if ($search) {
            $query->where(function ($q) use ($search, $filters) {
                foreach ($filters as $field) {
                    $q->orWhere($field, 'like', "%{$search}%");
                }
            });
        }

        return $query->orderBy($sort, $direction)
            ->paginate($perPage);
    }

    public function findById($id)
    {
        return $this->contact->with('address')->findOrFail($id);
    }

    public function create(array $data): Contact
    {
        $addressData = $data['address'] ?? null;

        $contact = $this->contact->create($data);

        if ($addressData) {
            $contact->address()->create($addressData);
        }

        return $contact->load('address');
    }

    public function edit($id, array $data)
    {
        $addressData = $data['address'] ?? null;

        $contact = $this->contact->with('address')->findOrFail($id);
        $contact->update($data);

        if ($addressData) {
            if ($contact->address) {
                $contact->address()->update($addressData);
            } else {
                $contact->address()->create($addressData);
            }
        }

        return $contact->load('address');
    }

    public function delete($id)
    {
        $contact = $this->contact->findOrFail($id);
        return $contact->delete();
    }

    public function upateOrCreate(array $data): Contact
    {
        return $this->contact->updateOrCreate(
            ['email' => $data['email']],
            $data
        );
    }

    public function getByCity()
    {
        return $this->viewContactByCity->get();
    }

    public function getByState()
    {
        return $this->viewContactByState->get();
    }
}
