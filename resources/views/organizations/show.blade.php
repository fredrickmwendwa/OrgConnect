@extends('layouts.app')
@section('title',$organization->name)
@section('content')
<div class="flex justify-between items-start mb-4">
  <div>
    <h1 class="text-2xl font-semibold">{{ $organization->name }}</h1>
    <p class="text-sm text-gray-600">{{ $organization->industry }}</p>
  </div>
  <div>
    <a href="{{ route('organizations.edit', $organization) }}" class="px-3 py-2 bg-yellow-200 rounded">Edit</a>
  </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
  <div class="bg-white p-4 rounded shadow">
    <h2 class="font-semibold mb-2">Contacts</h2>
    <a href="{{ route('contacts.create') }}" class="text-sm text-blue-600">Add contact</a>
    <ul class="mt-2">
      @forelse($organization->contacts as $c)
        <li class="border-b py-2">
          <div class="text-sm font-medium">{{ $c->contact_type }}: {{ $c->contact_value }}</div>
          <div class="text-xs text-gray-600">{{ $c->description }}</div>
        </li>
      @empty
        <li class="text-sm text-gray-500">No contacts</li>
      @endforelse
    </ul>
  </div>

  <div class="bg-white p-4 rounded shadow">
    <h2 class="font-semibold mb-2">Addresses</h2>
    <ul class="mt-2">
      @forelse($organization->addresses as $a)
        <li class="border-b py-2">
          <div class="text-sm font-medium">{{ $a->building_name }}, {{ $a->street_name }}</div>
          <div class="text-xs text-gray-600">{{ $a->city }}, {{ $a->country }}</div>
        </li>
      @empty
        <li class="text-sm text-gray-500">No addresses</li>
      @endforelse
    </ul>
  </div>
</div>
@endsection
