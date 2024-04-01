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
                    <form method="POST" action="{{ route('publications.update', $publication) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!-- Title -->
                        <div>
                            <x-form.label for="title" :value="__('Title')" />
                            <x-form.input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $publication->title)" required autofocus />
                            <x-form.error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Abstract -->
                        <div class="mt-4">
                            <x-form.label for="abstract" :value="__('Abstract')" />
                            <textarea id="abstract" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" name="abstract">{{ old('abstract', $publication->abstract) }}</textarea>
                            <x-form.error :messages="$errors->get('abstract')" class="mt-2" />
                        </div>

                        <!-- Publication Date -->
                        <div class="mt-4">
                            <x-form.label for="publication_date" :value="__('Publication Date')" />
                            <x-form.input id="publication_date" class="block mt-1 w-full" type="date" name="publication_date" :value="old('publication_date', optional($publication->publication_date)->format('Y-m-d'))" />
                            <x-form.error :messages="$errors->get('publication_date')" class="mt-2" />

                        </div>

                        <div class="mt-4">
                            <x-form.label for="file" :value="__('Upload File')" />

                            <input id="file" class="block mt-1 w-full" type="file" name="file" accept="application/pdf">
                            <x-form.error :messages="$errors->get('file')" class="mt-2" />
                            @if($publication->file)
                                <div>
                                    <a href="{{ Storage::url($publication->file) }}" target="_blank">View file</a>
                                </div>
                            @endif

                        </div>


                        <div class="mt-4">
                            <label for="enable_publisher" class="inline-flex items-center">
                                <input type="checkbox" id="enable_publisher" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ $publication->publisher_id != null ? 'checked' : '' }}>
                                <span class="ml-2">Publication Has Publisher</span>
                            </label>
                        </div>

                        <div class="mt-4">
                            <x-form.label for="publisher" :value="__('Publisher')" />
                            <input type="hidden" name="publisher_id" value="" id="hidden_publisher_id">

                            <select id="publisher_select" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" disabled>
                                @foreach($publishers as $publisher)
                                    <option value="{{ $publisher->id }}" {{ old('publisher_id', $publication->publisher_id) == $publisher->id ? 'selected' : '' }}>{{ $publisher->name }}</option>
                                @endforeach
                            </select>
                            <x-form.error :messages="$errors->get('publisher_id')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-form.label for="type" :value="__('Type')" />

                            <x-form.select name="type_id">
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}" {{ old('type_id', $publication->type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </x-form.select>
                            <x-form.error :messages="$errors->get('type_id')" class="mt-2" />

                        </div>

                        <div class="mt-4">
                            <x-form.label for="categories" :value="__('Categories')" />

                            <select id="categories" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" name="categories[]" multiple="multiple">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $publication->categories->contains($category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <x-form.error :messages="$errors->get('categories')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-form.label for="authors" :value="__('Authors')" />

                            <select id="authors" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" name="authors[]" multiple="multiple">
                                @foreach($authors as $author)
                                    <option value="{{ $author->id }}"
                                        {{ $publication->authors->contains($author->id) ? 'selected' : '' }}>
                                        {{ $author->first_name }} {{ $author->last_name }}
                                    </option>
                                @endforeach
                            </select>

                            <x-form.error :messages="$errors->get('authors')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-form.label for="keywords" :value="__('Keywords')" />

                            <select id="keywords" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" name="keywords[]" multiple="multiple">
                                @foreach($keywords as $keyword)
                                    <option value="{{ $keyword->id }}"
                                        {{ $publication->keywords->contains($keyword->id) ? 'selected' : '' }}>
                                        {{ $keyword->keyword }}
                                    </option>
                                @endforeach
                            </select>

                            <x-form.error :messages="$errors->get('keywords')" class="mt-2" />
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
        // Initialize Select2 and other elements
        $('#authors, #keywords, #categories').select2({tags: true, tokenSeparators: [',', ' '], allowClear: true});

        const enablePublisherCheckbox = document.getElementById('enable_publisher');
        const publisherSelect = document.getElementById('publisher_select');
        const hiddenPublisherId = document.getElementById('hidden_publisher_id');

        function togglePublisherSelect() {
            publisherSelect.disabled = !enablePublisherCheckbox.checked;

            if (enablePublisherCheckbox.checked) {
                publisherSelect.name = 'publisher_id'; // Add the name attribute when checked
                hiddenPublisherId.disabled = true; // Disable hidden input to prevent it from being submitted
            } else {
                publisherSelect.name = ''; // Remove the name attribute when unchecked
                hiddenPublisherId.disabled = false; // Enable hidden input to submit null value
            }
        }

        enablePublisherCheckbox.addEventListener('change', togglePublisherSelect);

        $('#publisher_select').select2({
            placeholder: "Select Publisher",
            allowClear: true
        });

        togglePublisherSelect(); // Call on load to set the initial state
    });


</script>
