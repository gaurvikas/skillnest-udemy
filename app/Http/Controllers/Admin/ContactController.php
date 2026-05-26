<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use App\Notifications\ContactReplyNotification;
use App\Services\ContactService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ContactController extends Controller
{
    public function __construct(protected readonly ContactService $contactService) {}

    public function index()
    {
        $contacts = Contact::latest()->paginate(20);

        return view('admin.contacts.index', compact('contacts'));
    }

    public function create()
    {
        return view('admin.contacts.create');
    }

    public function store(StoreContactRequest $request)
    {
        $data = $request->validated();
        $this->contactService->create($data, $request->ip());

        return to_route('admin.contacts.index');
    }

    public function show(Contact $contact)
    {
        return view('admin.contacts.show', compact('contact'));
    }

    public function edit(Contact $contact) {}

    public function update($request) {}

    public function reply(Request $request, Contact $contact)
    {
        $request->validate([
            'subject' => ['nullable', 'string', 'max:255'],
            'reply' => ['required', 'string', 'max:5000'],
        ]);

        Notification::route('mail', [
            $contact->email => $contact->name,
        ])->notify(new ContactReplyNotification($contact, $request->reply));

        $contact->update(['status' => 'replied']);

        return back()->with('status', 'Replied is successfully!');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return back();
    }
}
