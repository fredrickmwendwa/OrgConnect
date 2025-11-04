@extends('layouts.app')
@section('title','Create Organization')
@section('content')
<h1 class="text-xl font-semibold mb-4">Create Organization</h1>

<form action="{{ route('organizations.store') }}" method="POST" class="bg-white p-4 rounded shadow">
  @csrf
  <div class="mb-3">
    <label class="block mb-1">Name</label>
    <input name="name" required class="w-full border p-2 rounded" value="{{ old('name') }}">
    @error('name')<div class="text-red-600">{{ $message }}</div>@enderror
  </div>

  <div class="mb-3">
    <label class="block mb-1">Industry</label>
    <select name="industry" class="w-full border p-2 rounded">
      <option value="">-- Select industry --</option>
      @foreach($industries as $i)
        <option value="{{ $i }}" @if(old('industry') == $i) selected @endif>{{ $i }}</option>
      @endforeach
    </select>
    @error('industry')<div class="text-red-600">{{ $message }}</div>@enderror
  </div>

  <div class="mb-3">
    <label class="block mb-1">Description</label>
    <textarea name="description" class="w-full border p-2 rounded">{{ old('description') }}</textarea>
  </div>

  <div class="mb-3">
    <label class="inline-flex items-center">
      <input type="checkbox" name="is_active" class="mr-2" @if(old('is_active')) checked @endif> Active
    </label>
  </div>

  <div>
    <button class="px-4 py-2 bg-green-600 text-white rounded">Save</button>
    <a href="{{ route('organizations.index') }}" class="ml-2 px-4 py-2 bg-gray-200 rounded">Cancel</a>
  </div>
</form>
@endsection
