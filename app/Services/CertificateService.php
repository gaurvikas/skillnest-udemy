<?php

namespace App\Services;

use App\Models\Certificate;
use Exception;

class CertificateService
{
    /**
     * Create a new class instance.
     */
    public function create($request, $data)
    {
        try {

            unset($data['certificate_number']);

            $certificate = Certificate::create($data);

            if ($request->hasFile('file_path') && $request->file('file_path')->isValid()) {
                $certificate->addMediaFromRequest('file_path')->toMediaCollection('file_path');
            }

            return $certificate;

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function update($request, $certificate, $data)
    {
        unset($data['certificate_number']);
        try {
            $certificate->update($data);

            if ($request->hasFile('file_path') && $request->file('file_path')->isValid()) {
                $certificate->addMediaFromRequest('file_path')->toMediaCollection('file_path');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
