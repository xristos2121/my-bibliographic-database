<x-front-layout>
    <x-publications-list :results="$results" entityName="Author" entityTitle="{{ $author->first_name }} {{ $author->last_name }}" />
</x-front-layout>
