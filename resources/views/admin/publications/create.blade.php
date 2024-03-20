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
                    <form method="POST" action="{{ route('publications.store') }}">
                        @csrf

                        <!-- Title -->
                        <div>
                            <x-form.label for="title" :value="__('Title')" />

                            <x-form.input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                        </div>

                        <!-- Abstract -->
                        <div class="mt-4">
                            <x-form.label for="abstract" :value="__('Abstract')" />

                            <textarea id="abstract" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" name="abstract">{{ old('abstract') }}</textarea>
                        </div>

                        <!-- Publication Date -->
                        <div class="mt-4">
                            <x-form.label for="publication_date" :value="__('Publication Date')" />

                            <x-form.input id="publication_date" class="block mt-1 w-full" type="date" name="publication_date" :value="old('publication_date')" />
                        </div>

                        <!-- Keywords -->
                        <div class="mt-4">
                            <x-form.label for="keywords" :value="__('Keywords')" />

                            <x-form.input id="keywords" class="block mt-1 w-full" type="text" name="keywords" :value="old('keywords')" />
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
