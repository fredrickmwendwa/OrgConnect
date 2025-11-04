@extends('layouts.app')
@section('title','Contacts')
@section('content')
<div class="flex justify-between items-center mb-4">
  <h1 class="text-2xl font-semibold">Contacts</h1>
  <div class="space-x-2">
    <a href="{{ route('contacts.create') }}" class="px-3 py-2 bg-blue-600 text-white rounded">New Contact</a>
    <a href="{{ route('contacts.export', 'csv') }}" class="px-3 py-2 bg-gray-200 rounded">Export CSV</a>
    <a href="{{ route('contacts.export', 'xls') }}" class="px-3 py-2 bg-gray-200 rounded">Export XLS</a>
  </div>
</div>

<form class="mb-4" method="GET" action="{{ route('contacts.index') }}">
  <div class="flex gap-2">
    <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Search contacts..." class="rounded border p-2 w-full">
    <button class="px-3 py-2 bg-gray-800 text-white rounded">Search</button>
  </div>
</form>

<div class="bg-white shadow rounded overflow-hidden">
  <table class="min-w-full">
    <thead class="bg-gray-50">
      <tr>
        <th class="px-4 py-2 text-left">Organization</th>
        <th class="px-4 py-2 text-left">Type</th>
        <th class="px-4 py-2 text-left">Value</th>
        <th class="px-4 py-2 text-left">Active</th>
        <th class="px-4 py-2 text-left">Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($contacts as $c)
      <tr class="border-t">
        <td class="px-4 py-2">{{ $c->organization ? $c->organization->name : '' }}</td>
        <td class="px-4 py-2">{{ $c->contact_type }}</td>
        <td class="px-4 py-2">{{ $c->contact_value }}</td>
        <td class="px-4 py-2">{{ $c->is_active ? 'Yes' : 'No' }}</td>
        <td class="px-4 py-2 space-x-2">
          <a href="{{ route('contacts.edit', $c) }}" class="text-sm px-2 py-1 bg-yellow-200 rounded">Edit</a>
          <form action="{{ route('contacts.destroy', $c) }}" method="POST" class="inline" onsubmit="return confirm('Delete this contact?');">
            @csrf @method('DELETE')
            <button class="text-sm px-2 py-1 bg-red-200 rounded">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="mt-4">
  {{ $contacts->withQueryString()->links() }}
</div>
@endsection
