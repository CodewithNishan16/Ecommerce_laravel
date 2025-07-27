@extends('layouts.master')
@section('content')
 <form action="{{ route('login') }}" method="POST" class="max-w-sm mx-auto mt-10 bg-gray-200 p-8 rounded-lg shadow space-y-6">
    @csrf
    <h2 class="text-2xl font-bold text-center text-indigo-700 mb-4">Login</h2>
    <div>
        <label for="email" class="block text-gray-700 font-semibold mb-1">Email</label>
        <input type="email" id="email" name="email" required autofocus
            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500" />
    </div>
    <div>
        <label for="password" class="block text-gray-700 font-semibold mb-1">Password</label>
        <input type="password" id="password" name="password" required
            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:underline">Forgot your password?</a>
    </div>
    <div class="flex items-center">
        <input type="checkbox" id="remember_me" name="remember" class="mr-2">
        <label for="remember_me" class="text-gray-700">Remember me</label>
    </div>
    <div>
        <button type="submit"
            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition">Log in</button>
    </div>
</form>
@endsection