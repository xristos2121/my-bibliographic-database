<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="flex-1 min-w-0">
                            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">Edit Category</h2>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('categories.update', $category->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div>
                            <x-form.label for="name" :value="__('Name')" />
                            <x-form.input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $category->name)" required autofocus />
                            <x-form.error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Slug -->
                        <div class="mt-4">
                            <x-form.label for="slug" :value="__('Slug')" />
                            <x-form.input id="slug" class="block mt-1 w-full" type="text" name="slug" :value="old('slug', $category->slug)" />
                            <x-form.error :messages="$errors->get('slug')" class="mt-2" />
                        </div>

                        <!-- Parent Category -->
                        <div class="mt-4">
                            <x-form.label for="parent_id" :value="__('Parent Category')" />
                            <select id="parent_id" name="parent_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
                                <option value="">{{ __('None') }}</option>
                                @foreach($categoriesWithPath as $parentCategory)
                                    <option value="{{ $parentCategory->id }}" {{ old('parent_id', $category->parent_id) == $parentCategory->id ? 'selected' : '' }}>
                                        {{ $parentCategory->full_path }}
                                    </option>
                                @endforeach
                            </select>
                            <x-form.error :messages="$errors->get('parent_id')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Update') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#parent_id').select2({tags: true, tokenSeparators: [',', ' '], allowClear: true});
            });
    </script>
</x-app-layout>
