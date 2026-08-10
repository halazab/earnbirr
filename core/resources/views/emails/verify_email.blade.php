@extends('emails.layout')

@section('content')
@php
    $title = 'Verify Your Email';
    $icon = '✉️';
    $heading = 'Email Verification';
    $greeting = 'Hello ' . $user->firstname;
    $message = 'Welcome to EarnBirr! Please verify your email address using the code below to activate your account.';
    $code = $code;
    $footer = 'If you did not create an account on EarnBirr, you can safely ignore this email.';
@endphp
@endsection
