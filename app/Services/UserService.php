<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserService
{
    public function create($request, $data)
    {
        try {
            $user = User::create($data);

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $user->addMediaFromRequest('image')->toMediaCollection('image');
            }

            $user->assignRole($data['role']);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function update(Request $request, $user, $data)
    {
        try {
            if (empty($data['password'])) {
                unset($data['password']);
            }
            if ($request->hasFile('image') && $request->file('image')->isValid()) {

                $user->clearMediaCollection('image');

                $user->addMediaFromRequest('image')
                    ->toMediaCollection('image');
            }

            $user->update($data);
            $user->assignRole($data['role']);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
