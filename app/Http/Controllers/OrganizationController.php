<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\IndustryType;
use App\Models\ActivityLog;

class OrganizationController extends Controller
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
        $organizations = Organization::when($q, function($query) use ($q) {
            $query->where('name', 'like', "%{$q}%")
                  ->orWhere('industry', 'like', "%{$q}%")
                  ->orWhere('description', 'like', "%{$q}%");
        })->orderBy('name')->paginate(25);

        return view('organizations.index', compact('organizations', 'q'));
    }

    public function create()
    {
        $industries = IndustryType::where('is_active', true)->pluck('type');
        return view('organizations.create', compact('industries'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:200',
            'industry' => 'nullable|string|max:150',
            'description' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $data['is_active'] = $request->has('is_active');

        $org = Organization::create($data);

        $this->log('system', 'created_organization', "Created organization {$org->name}", ['organization_id' => $org->id]);

        return redirect()->route('organizations.index')->with('success', 'Organization created.');
    }

    public function show(Organization $organization)
    {
        $organization->load('contacts', 'addresses');
        return view('organizations.show', compact('organization'));
    }

    public function edit(Organization $organization)
    {
        $industries = IndustryType::where('is_active', true)->pluck('type');
        return view('organizations.edit', compact('organization','industries'));
    }

    public function update(Request $request, Organization $organization)
    {
        $data = $request->validate([
            'name' => 'required|string|max:200',
            'industry' => 'nullable|string|max:150',
            'description' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);
        $data['is_active'] = $request->has('is_active');

        $organization->update($data);

        $this->log('system', 'updated_organization', "Updated organization {$organization->name}", ['organization_id' => $organization->id]);

        return redirect()->route('organizations.index')->with('success', 'Organization updated.');
    }

    public function destroy(Organization $organization)
    {
        $name = $organization->name;
        $organization->delete();

        $this->log('system', 'deleted_organization', "Deleted organization {$name}", ['organization_name' => $name]);

        return redirect()->route('organizations.index')->with('success', 'Organization deleted.');
    }
}
