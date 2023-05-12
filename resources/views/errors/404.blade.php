@extends('errors::minimal')
@section('title', __('Not Found'))
@section('code', '404')
@section('message', __($exception->getMessage() ?: 'The page you are looking for does not exist. How you got here is a mystery. But you can click the
button below to go back to the homepage.'))

