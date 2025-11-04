<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'OrgConnect') }} - @yield('title')</title>
  <!-- Tailwind CDN for quick setup -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
  <nav class="bg-white shadow">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
      <div>
        <a href="{{ route('organizations.index') }}" class="text-lg font-bold">{{ config('app.name', 'OrgConnect') }}</a>
      </div>
      <div class="space-x-4 text-sm">
        <a href="{{ route('organizations.index') }}" class="hover:underline">Organizations</a>
        <a href="{{ route('contacts.index') }}" class="hover:underline">Contacts</a>
        <a href="{{ route('activity-logs.index') }}" class="hover:underline">Activity Log</a>
      </div>
    </div>
  </nav>

  <main class="container mx-auto px-4 py-6">
    @if(session('success'))
      <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
    @endif

    @yield('content')
  </main>
</body>
</html>
