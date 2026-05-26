<?php

namespace App\Services;

use App\Models\Contact;
use Exception;

class ContactService
{
    /**
     * Create a new class instance.
     */
    public function create($data, $ipAddress)
    {
        try {
            $data['ip_address'] = $ipAddress;

            Contact::create($data);
        } catch (Exception $e) {

            $e->getMessage();
        }
    }

    public function update($data, $ipAddress, Contact $contact)
    {
        try {
            $data['ip_address'] = $ipAddress;

            $contact->update($data);

            return $contact;
        } catch (Exception $e) {

            $e->getMessage();
        }
    }
}
