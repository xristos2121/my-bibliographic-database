<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Collection') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="flex-1 min-w-0">
                            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">Create Collection</h2>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('collections.store') }}">
                        @csrf

                        <!-- Name -->
                        <div>
                            <x-form.label for="name" :value="__('Name')" />
                            <x-form.input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            <x-form.error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Parent Collection -->
                        <div class="mt-4">
                            <x-form.label for="parent_id" :value="__('Parent Collection')" />
                            <select id="parent_id" name="parent_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
                                <option value="">{{ __('None') }}</option>
                                @foreach($collectionsWithPath as $parentCollection)
                                    <option value="{{ $parentCollection->id }}" {{ old('parent_id') == $parentCollection->id ? 'selected' : '' }}>
                                        {{ $parentCollection->full_path }}
                                    </option>
                                @endforeach
                            </select>
                            <x-form.error :messages="$errors->get('parent_id')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Save') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
