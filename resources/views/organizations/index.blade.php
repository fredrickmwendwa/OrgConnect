@extends('layouts.app')
@section('title','Organizations')
@section('content')
<div class="flex justify-between items-center mb-4">
  <h1 class="text-2xl font-semibold">Organizations</h1>
  <div>
    <a href="{{ route('organizations.create') }}" class="px-3 py-2 bg-blue-600 text-white rounded">New Organization</a>
  </div>
</div>

<form class="mb-4" method="GET" action="{{ route('organizations.index') }}">
  <div class="flex gap-2">
    <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Search organizations..." class="rounded border p-2 w-full">
    <button class="px-3 py-2 bg-gray-800 text-white rounded">Search</button>
  </div>
</form>

<div class="bg-white shadow rounded overflow-hidden">
  <table class="min-w-full">
    <thead class="bg-gray-50">
      <tr>
        <th class="px-4 py-2 text-left">Name</th>
        <th class="px-4 py-2 text-left">Industry</th>
        <th class="px-4 py-2 text-left">Active</th>
        <th class="px-4 py-2 text-left">Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($organizations as $org)
      <tr class="border-t">
        <td class="px-4 py-2"><a class="text-blue-600" href="{{ route('organizations.show', $org) }}">{{ $org->name }}</a></td>
        <td class="px-4 py-2">{{ $org->industry }}</td>
        <td class="px-4 py-2">{{ $org->is_active ? 'Yes' : 'No' }}</td>
        <td class="px-4 py-2 space-x-2">
          <a href="{{ route('organizations.edit', $org) }}" class="text-sm px-2 py-1 bg-yellow-200 rounded">Edit</a>
          <form action="{{ route('organizations.destroy', $org) }}" method="POST" class="inline" onsubmit="return confirm('Delete this organization?');">
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
  {{ $organizations->withQueryString()->links() }}
</div>
@endsection
