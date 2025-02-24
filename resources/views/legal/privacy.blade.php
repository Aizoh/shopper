@extends('layouts.app')
 
@section('body')
 
    <x-legal-layout>
        <x-slot name="title">
            <h2 class="text-2xl font-bold uppercase text-dark tracking-wider font-heading sm:text-3xl">
                {{ __('Privacy Policy') }}
            </h2>
            <span class="text-sm leading-5 text-gray-500">{{ __('Last update: :date', ['date' => $legal->created_at->format('d, F Y')]) }}</span>
        </x-slot>
 
        {!! $legal->content  !!}
 
    </x-legal-layout>
 
@endsection