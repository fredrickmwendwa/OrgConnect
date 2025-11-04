@extends('layouts.app')
@section('title','Create Contact')
@section('content')
<h1 class="text-xl font-semibold mb-4">Create Contact</h1>

<form action="{{ route('contacts.store') }}" method="POST" class="bg-white p-4 rounded shadow">
  @csrf

  <div class="mb-3">
    <label class="block mb-1">Organization</label>
    <select name="organization_id" required class="w-full border p-2 rounded">
      <option value="">-- select organization --</option>
      @foreach($organizations as $id => $name)
        <option value="{{ $id }}" @if(old('organization_id') == $id) selected @endif>{{ $name }}</option>
      @endforeach
    </select>
    @error('organization_id')<div class="text-red-600">{{ $message }}</div>@enderror
  </div>

  <div class="mb-3">
    <label class="block mb-1">Contact Type</label>
    <select name="contact_type" required class="w-full border p-2 rounded">
      <option value="">-- select type --</option>
      @foreach($contact_types as $t)
        <option value="{{ $t }}" @if(old('contact_type') == $t) selected @endif>{{ $t }}</option>
      @endforeach
    </select>
  </div>

  <div class="mb-3">
    <label class="block mb-1">Contact Value</label>
    <input name="contact_value" required class="w-full border p-2 rounded" value="{{ old('contact_value') }}">
  </div>

  <div class="mb-3">
    <label class="block mb-1">Description</label>
    <input name="description" class="w-full border p-2 rounded" value="{{ old('description') }}">
  </div>

  <div class="mb-3">
    <label class="inline-flex items-center">
      <input type="checkbox" name="is_active" class="mr-2" @if(old('is_active')) checked @endif> Active
    </label>
  </div>

  <div>
    <button class="px-4 py-2 bg-green-600 text-white rounded">Save</button>
    <a href="{{ route('contacts.index') }}" class="ml-2 px-4 py-2 bg-gray-200 rounded">Cancel</a>
  </div>
</form>
@endsection
