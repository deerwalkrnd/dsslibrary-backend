<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <a href="{{ route('auth.google.redirect') }}" class="btn bg-blue-100 p-3 shadow-sm border rounded-md text-blue-900">
        Login with Google 
    </a>
</html>
