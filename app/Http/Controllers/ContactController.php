<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Organization;
use App\Models\ContactType;
use App\Models\ActivityLog;

class ContactController extends Controller
{
    protected function log($actor, $action, $description = null, $meta = null)
    {
        ActivityLog::create([
            'actor' => $actor,
            'action' => $action,
            'description' => $description,
            'meta' => $meta,
        ]);
    }

    public function index(Request $request)
    {
        $q = $request->query('q');
        $contacts = Contact::with('organization')
            ->when($q, function($query) use ($q) {
                $query->where('contact_value', 'like', "%{$q}%")
                      ->orWhere('contact_type', 'like', "%{$q}%")
                      ->orWhereHas('organization', function($q2) use ($q) {
                          $q2->where('name', 'like', "%{$q}%");
                      });
            })
            ->orderBy('contact_type')
            ->paginate(25);

        return view('contacts.index', compact('contacts','q'));
    }

    public function create()
    {
        $organizations = Organization::orderBy('name')->pluck('name','id');
        $contact_types = ContactType::where('is_active', true)->pluck('type');
        return view('contacts.create', compact('organizations','contact_types'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'contact_type' => 'required|string|max:150',
            'contact_value' => 'required|string|max:250',
            'description' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);
        $data['is_active'] = $request->has('is_active');

        $contact = Contact::create($data);

        $this->log('system', 'created_contact', "Created contact {$contact->contact_value}", ['contact_id' => $contact->id, 'organization_id' => $contact->organization_id]);

        return redirect()->route('contacts.index')->with('success', 'Contact created.');
    }

    public function show(Contact $contact)
    {
        $contact->load('organization');
        return view('contacts.show', compact('contact'));
    }

    public function edit(Contact $contact)
    {
        $organizations = Organization::orderBy('name')->pluck('name','id');
        $contact_types = ContactType::where('is_active', true)->pluck('type');
        return view('contacts.edit', compact('contact','organizations','contact_types'));
    }

    public function update(Request $request, Contact $contact)
    {
        $data = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'contact_type' => 'required|string|max:150',
            'contact_value' => 'required|string|max:250',
            'description' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);
        $data['is_active'] = $request->has('is_active');

        $contact->update($data);

        $this->log('system', 'updated_contact', "Updated contact {$contact->contact_value}", ['contact_id' => $contact->id]);

        return redirect()->route('contacts.index')->with('success', 'Contact updated.');
    }

    public function destroy(Contact $contact)
    {
        $value = $contact->contact_value;
        $contact->delete();

        $this->log('system', 'deleted_contact', "Deleted contact {$value}", ['contact_value' => $value]);

        return redirect()->route('contacts.index')->with('success', 'Contact deleted.');
    }

    // Export contacts to csv or xls (xls is an HTML table compatible with Excel)
    public function export($format = 'csv')
    {
        $format = strtolower($format);
        $contacts = Contact::with('organization')->orderBy('id')->get();

        if ($format === 'csv') {
            $filename = 'contacts_' . now()->format('Ymd_His') . '.csv';
            $columns = ['ID','Organization','Contact Type','Contact Value','Description','Is Active','Created At','Updated At'];

            $callback = function() use ($contacts, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
                foreach ($contacts as $c) {
                    fputcsv($file, [
                        $c->id,
                        $c->organization ? $c->organization->name : '',
                        $c->contact_type,
                        $c->contact_value,
                        $c->description,
                        $c->is_active ? '1' : '0',
                        $c->created_at,
                        $c->updated_at,
                    ]);
                }
                fclose($file);
            };

            return response()->streamDownload($callback, $filename, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename={$filename}",
            ]);
        } elseif ($format === 'xls') {
            $filename = 'contacts_' . now()->format('Ymd_His') . '.xls';
            $html = '<table border="1"><thead><tr><th>ID</th><th>Organization</th><th>Contact Type</th><th>Contact Value</th><th>Description</th><th>Is Active</th><th>Created At</th><th>Updated At</th></tr></thead><tbody>';
            foreach ($contacts as $c) {
                $html .= '<tr>';
                $html .= '<td>'.htmlspecialchars($c->id).'</td>';
                $html .= '<td>'.htmlspecialchars($c->organization ? $c->organization->name : '').'</td>';
                $html .= '<td>'.htmlspecialchars($c->contact_type).'</td>';
                $html .= '<td>'.htmlspecialchars($c->contact_value).'</td>';
                $html .= '<td>'.htmlspecialchars($c->description).'</td>';
                $html .= '<td>'.($c->is_active ? '1' : '0').'</td>';
                $html .= '<td>'.htmlspecialchars($c->created_at).'</td>';
                $html .= '<td>'.htmlspecialchars($c->updated_at).'</td>';
                $html .= '</tr>';
            }
            $html .= '</tbody></table>';

            return response($html, 200, [
                'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
                'Content-Disposition' => "attachment; filename={$filename}",
            ]);
        } else {
            return redirect()->back()->with('error', 'Unsupported export format.');
        }
    }
}
