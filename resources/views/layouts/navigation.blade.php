@extends('layouts.app')

@section('content')

<div class="bg-gray-100 min-h-screen">

{{-- Hero Section --}}
<div class="max-w-7xl mx-auto px-6 py-16 text-center">

<h1 class="text-4xl font-bold text-gray-800 mb-4">
Security Incident Response Management System
</h1>

<p class="text-gray-600 text-lg max-w-2xl mx-auto mb-8">
A centralized platform designed to manage cybersecurity incidents,
allowing users to report, investigate, and resolve incidents efficiently.
</p>

<div class="flex justify-center gap-4">

<a href="{{ route('login') }}"
class="bg-blue-600 text-white px-8 py-3 rounded-lg shadow hover:bg-blue-700 transition">

Login to System

</a>

<a href="{{ route('register') }}"
class="bg-gray-700 text-white px-8 py-3 rounded-lg shadow hover:bg-gray-800 transition">

Create Account

</a>

</div>

</div>



{{-- System Features --}}
<div class="max-w-7xl mx-auto px-6 pb-20">

<div class="grid md:grid-cols-3 gap-8">

{{-- Feature 1 --}}
<div class="bg-white shadow rounded-lg p-6 text-center">

<h3 class="text-xl font-semibold mb-2">
Report Incidents
</h3>

<p class="text-gray-600">
Users can submit cybersecurity incidents such as system failures,
network attacks, or suspicious activities.
</p>

</div>


{{-- Feature 2 --}}
<div class="bg-white shadow rounded-lg p-6 text-center">

<h3 class="text-xl font-semibold mb-2">
Incident Investigation
</h3>

<p class="text-gray-600">
Security officers analyze incidents, update status, and
add investigation notes.
</p>

</div>


{{-- Feature 3 --}}
<div class="bg-white shadow rounded-lg p-6 text-center">

<h3 class="text-xl font-semibold mb-2">
Administrative Control
</h3>

<p class="text-gray-600">
Administrators monitor all incidents, assign officers,
and manage the response workflow.
</p>

</div>

</div>

</div>



{{-- Footer --}}
<div class="border-t bg-white py-6 text-center text-sm text-gray-500">

Security Incident Response Management System (SIRMS)  
© {{ date('Y') }}

</div>

</div>

@endsection