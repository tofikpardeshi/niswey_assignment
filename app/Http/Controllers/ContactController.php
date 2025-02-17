<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index()
    {
        $getContacts = Contact::get();
        return view('home', compact('getContacts'));
    }

    public function createContactsPage( Request $request )
    {
        return view('add-contact');
    }

    public function add(Request $request)
    {
        $request->validate([
            'first_name' => ['required','string','max:255'],
            'last_name' => ['required','string','max:255'],
            'phone' => ['required','string','max:255'],
        ]);

         $getContact = Contact::get();

         foreach ($getContact as $contact) {
            $normalizedPhone = str_replace(' ', '', $contact->phone);
            $requestPhone = str_replace(' ', '', $request->phone);
            if ($requestPhone == $normalizedPhone) {
                return redirect()->route('add.contact.page')->with('status', 'Phone Number already exists');
            }
        }

        $contact = new Contact();
        $contact->first_name = $request->first_name;
        $contact->last_name = $request->last_name;
        $contact->phone = $request->phone;
        $contact->user_id = Auth::user()->id;
        $contact->updated_by = null;
        $contact->save();
        return redirect()->route('home')->with('status', 'Contact added successfully');
    }

    public function edit($id)
    {
        $contactDetail = Contact::find($id);
        return view('edit-contact', compact('contactDetail'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required','string','max:255'],
            'phone' => ['required','string','max:255'],
        ]);

        $contact = Contact::find($id);
        if($contact->first_name !== $request->first_name || $contact->last_name !== $request->last_name || $contact->phone !== $request->phone)
        {
            $contact->updated_by = Auth::user()->id;
        }
        if ($contact->first_name == $request->first_name && $contact->last_name == $request->last_name && $contact->phone == $request->phone)
        {
            return redirect()->route('home')->with('status', 'Data Not Updated');
        }
        $contact->first_name = $request->first_name;
        $contact->last_name = $request->last_name;
        $contact->phone = str_replace(' ', '', $request->phone);

        $contact->save();

        return redirect()->route('home')->with('status', 'Contact updated successfully');
    }

    public function importXml(Request $request)
    {

        $request->validate([
            'xml_file' => 'required|mimes:xml',
        ]);


        if ($request->hasFile('xml_file')) {
            $xmlFile = $request->file('xml_file');

            $xmlData = simplexml_load_file($xmlFile);
            $insertedCount = 0;
            $skippedCount = 0;


            foreach ($xmlData->contact as $contact) {
                $newContact = new Contact;
                $newContact->first_name = (string) $contact->name;
                $newContact->last_name = (string) $contact->lastName;
                $newContact->phone = (string) $contact->phone;
                $newContact->user_id = Auth::user()->id ?? 1;
                $newContact->updated_by = Auth::user()->id?? null;

                // Check if contact already exists
                $exists = Contact::where('phone', $contact->phone)
                ->exists();

                if(!$exists)
                {
                    $newContact->save();
                    $insertedCount++;
                }
                else
                {
                    $skippedCount++;
                }
            }
            return back()->with('status', "Import completed! Inserted: $insertedCount, Skipped: $skippedCount (duplicates)");
        } else {
            session()->flash('status', 'No file selected.');
        }

        return redirect()->route('home');
    }

    public function delete($id)
    {
        $contact = Contact::find($id);
        $contact->delete();
        return redirect()->route('home')->with('status', 'Contact deleted successfully');
    }
}
