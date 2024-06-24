<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Keyword') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('keywords.update', $keyword) }}">
                        @csrf
                        @method('PUT')

                        <div class="mt-4">
                            <x-form.label for="name" :value="__('Keyword')"/>

                            <x-form.input id="name" class="block mt-1 w-full" type="text" name="keyword"
                                          value="{{ old('name', $keyword->keyword) }}" required autofocus/>
                        </div>

                        <div class="mt-4">
                            <label for="active" class="inline-flex items-center">
                                <input type="checkbox" id="active" name="active" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ old('active', $keyword->active ?? true) ? 'checked' : '' }}>
                                <span class="ml-2">Active</span>
                            </label>
                            <x-form.error :messages="$errors->get('active')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Update') }}
                            </x-button>
                        </div>

                        @if ($errors->any())
                            <div class="mt-6">
                                <div class="font-medium text-red-600">
                                    {{ __('Whoops! Something went wrong.') }}
                                </div>

                                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
