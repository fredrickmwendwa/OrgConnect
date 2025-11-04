@extends('layouts.app')
@section('title','Activity Logs')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Activity Logs</h1>

<div class="bg-white shadow rounded overflow-hidden">
  <table class="min-w-full">
    <thead class="bg-gray-50">
      <tr>
        <th class="px-4 py-2 text-left">Time</th>
        <th class="px-4 py-2 text-left">Actor</th>
        <th class="px-4 py-2 text-left">Action</th>
        <th class="px-4 py-2 text-left">Description</th>
        <th class="px-4 py-2 text-left">Details</th>
      </tr>
    </thead>
    <tbody>
      @foreach($logs as $log)
      <tr class="border-t">
        <td class="px-4 py-2 text-sm">{{ $log->created_at }}</td>
        <td class="px-4 py-2">{{ $log->actor }}</td>
        <td class="px-4 py-2">{{ $log->action }}</td>
        <td class="px-4 py-2">{{ $log->description }}</td>
        <td class="px-4 py-2 text-sm">{{ json_encode($log->meta) }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="mt-4">
  {{ $logs->links() }}
</div>
@endsection
