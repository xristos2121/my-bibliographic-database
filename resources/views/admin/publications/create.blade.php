<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Publication') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Whoops! Something went wrong.</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('publications.store') }}">
                        @csrf

                        <!-- Title -->
                        <div>
                            <x-form.label for="title" :value="__('Title')" />
                            <x-form.input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                            <x-form.error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Abstract -->
                        <div class="mt-4">
                            <x-form.label for="abstract" :value="__('Abstract')" />
                            <textarea id="abstract" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" name="abstract">{{ old('abstract') }}</textarea>
                            <x-form.error :messages="$errors->get('abstract')" class="mt-2" />
                        </div>

                        <!-- Publication Date -->
                        <div class="mt-4">
                            <x-form.label for="publication_date" :value="__('Publication Date')" />
                            <x-form.input id="publication_date" class="block mt-1 w-full" type="date" name="publication_date" :value="old('publication_date')" />
                            <x-form.error :messages="$errors->get('publication_date')" class="mt-2" />

                        </div>


                        <div class="mt-4">
                            <x-form.label for="type" :value="__('Type')" />

                            <x-form.select name="type_id">
                                @foreach($types as $type)
                                <option value="{{$type->id}}">{{$type->name}}</option>
                                @endforeach
                            </x-form.select>
                            <x-form.error :messages="$errors->get('type_id')" class="mt-2" />

                        </div>
                        <div class="mt-4">
                            <x-form.label for="keywords" :value="__('Authors')" />

                            <select id="keywords" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" name="keywords[]" multiple="multiple">
                                @foreach($keywords as $keyword)
                                    <option value="{{ $keyword->id }}">{{ $keyword->keyword }}</option>
                                @endforeach
                            </select>
                            <x-form.error :messages="$errors->get('keywords')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-form.label for="authors" :value="__('Authors')" />

                            <select id="authors" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" name="authors[]" multiple="multiple">
                                @foreach($authors as $author)
                                    <option value="{{ $author->id }}">{{ $author->first_name }} {{ $author->last_name }}</option>
                                @endforeach
                            </select>
                            <x-form.error :messages="$errors->get('authors')" class="mt-2" />
                        </div>


                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Save') }}
                            </x-button >
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#authors').select2({
            placeholder: "Select authors",
            tags: true, // Enable the tagging system
            tokenSeparators: [',', ' '], // Defines characters that automatically separate tags
            allowClear: true
        });
        $('#keywords').select2({
            placeholder: "Select keywords",
            tags: true, // Enable the tagging system
            tokenSeparators: [',', ' '], // Defines characters that automatically separate tags
            allowClear: true
        });
    });

</script>
