@extends('emails.layout')

@section('content')
@php
    $title = 'Reset Your Password';
    $icon = '🔑';
    $heading = 'Password Reset';
    $greeting = 'Hello ' . $user->firstname;
    $message = 'We received a request to reset your password. Use the code below to verify your identity. This code will expire in ' . (gs('otp_expiration') ?? 5) . ' minutes.';
    $code = $code;
    $footer = 'If you did not request this, you can safely ignore this email. Your password will remain unchanged.';
@endphp
@endsection
