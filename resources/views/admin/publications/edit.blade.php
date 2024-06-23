<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Publication') }}
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
                            <x-form.input id="publication_date" class="block mt-1 w-full" type="text" name="publication_date" :value="old('publication_date', $publication->publication_date)" />
                            <x-form.error :messages="$errors->get('publication_date')" class="mt-2" />
                        </div>

                        <!-- File Upload -->
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

                        <!-- Publisher -->
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

                        <!-- Type -->
                        <div class="mt-4">
                            <x-form.label for="type" :value="__('Type')" />
                            <x-form.select name="type_id">
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}" {{ old('type_id', $publication->type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </x-form.select>
                            <x-form.error :messages="$errors->get('type_id')" class="mt-2" />
                        </div>

                        <!-- Categories -->
                        <div class="mt-4">
                            <x-form.label for="categories" :value="__('Categories')" />
                            <select id="categories" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" name="categories[]" multiple="multiple">
                                @foreach($categoriesWithPath as $category)
                                    <option value="{{ $category->id }}" {{ $publication->categories->contains($category->id) ? 'selected' : '' }}>
                                        {{ $category->full_path }}
                                    </option>
                                @endforeach
                            </select>
                            <x-form.error :messages="$errors->get('categories')" class="mt-2" />
                        </div>

                        <!-- Authors -->
                        <div class="mt-4">
                            <x-form.label for="authors" :value="__('Authors')" />
                            <select id="authors" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" name="authors[]" multiple="multiple">
                                @foreach($authors as $author)
                                    <option value="{{ $author->id }}" {{ $publication->authors->contains($author->id) ? 'selected' : '' }}>
                                        {{ $author->first_name }} {{ $author->last_name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-form.error :messages="$errors->get('authors')" class="mt-2" />
                        </div>

                        <!-- Keywords -->
                        <div class="mt-4">
                            <x-form.label for="keywords" :value="__('Keywords')" />
                            <select id="keywords" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" name="keywords[]" multiple="multiple">
                                @foreach($keywords as $keyword)
                                    <option value="{{ $keyword->id }}" {{ $publication->keywords->contains($keyword->id) ? 'selected' : '' }}>
                                        {{ $keyword->keyword }}
                                    </option>
                                @endforeach
                            </select>
                            <x-form.error :messages="$errors->get('keywords')" class="mt-2" />
                        </div>

                        <!-- URIs -->
                        <div class="mt-4">
                            <x-form.label for="uris" :value="__('URIs')" />
                            <div id="uris-container">
                                @foreach ($uris as $uri)
                                    <div class="uri-field">
                                        <x-form.input class="block mt-1 w-full" type="text" name="uris[]" value="{{ $uri->uri }}" placeholder="Enter URI" />
                                        <button type="button" class="remove-uri mt-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Remove</button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" id="add-uri" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">+ Add URI</button>
                            <x-form.error :messages="$errors->get('uris')" class="mt-2" />
                        </div>

                        <!-- Custom Fields -->
                        <div class="mt-6">
                            <x-form.label :value="__('Custom Fields')" />
                            <div id="custom-fields-container" class="space-y-4">
                                @foreach($publicationCustomFields as $customField)
                                    <div class="custom-field-wrapper p-4 bg-gray-100 rounded-md shadow-sm">
                                        <label class="block font-medium text-sm text-gray-700">{{ $customField->definition->name }} ({{ $customField->definition->type }})</label>
                                        <input type="hidden" name="custom_fields[{{ $customField->definition->id }}][field_definition_id]" value="{{ $customField->definition->id }}">
                                        <input type="{{ $customField->definition->type }}" name="custom_fields[{{ $customField->definition->id }}][value]" value="{{ $customField->value }}" class="block w-full mt-1 rounded-md shadow-sm border-gray-300">
                                        <button type="button" class="remove-custom-field mt-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Remove</button>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4 flex items-center space-x-4">
                                <select id="custom-field-select" class="block w-full rounded-md shadow-sm border-gray-300">
                                    <option value="" disabled selected>Select Custom Field</option>
                                    @foreach($customFields as $customField)
                                        <option value="{{ $customField->id }}" data-type="{{ $customField->type }}">{{ $customField->name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" id="add-custom-field" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">+ Add Custom Field</button>
                                <a href="{{ route('custom_fields.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Create Custom Field</a>
                            </div>
                        </div>

                        <!-- Save Button -->
                        <div class="flex items-center justify-end mt-6">
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
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

        // Handle dynamic custom fields
        const customFieldsContainer = document.getElementById('custom-fields-container');
        const customFieldSelect = document.getElementById('custom-field-select');

        // Disable already selected custom fields in the dropdown
        const selectedCustomFields = document.querySelectorAll('#custom-fields-container input[type="hidden"]');
        selectedCustomFields.forEach(field => {
            const fieldId = field.value;
            const optionToDisable = customFieldSelect.querySelector(`option[value="${fieldId}"]`);
            if (optionToDisable) {
                optionToDisable.disabled = true;
            }
        });

        document.getElementById('add-custom-field').addEventListener('click', function () {
            const selectedOption = customFieldSelect.options[customFieldSelect.selectedIndex];
            if (selectedOption && selectedOption.value) {
                const fieldName = selectedOption.text;
                const fieldId = selectedOption.value;
                const fieldType = selectedOption.getAttribute('data-type');

                const fieldWrapper = document.createElement('div');
                fieldWrapper.classList.add('custom-field-wrapper', 'p-4', 'bg-gray-100', 'rounded-md', 'shadow-sm');
                fieldWrapper.innerHTML = `
                    <label class="block font-medium text-sm text-gray-700">${fieldName} (${fieldType})</label>
                    <input type="hidden" name="custom_fields[${fieldId}][field_definition_id]" value="${fieldId}">
                    <input type="${fieldType}" name="custom_fields[${fieldId}][value]" placeholder="Enter ${fieldName}" class="block w-full mt-1 rounded-md shadow-sm border-gray-300">
                    <button type="button" class="remove-custom-field mt-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Remove</button>
                `;
                customFieldsContainer.appendChild(fieldWrapper);

                // Disable the selected option
                selectedOption.disabled = true;

                // Reset the custom field select
                customFieldSelect.selectedIndex = 0;
            }
        });

        // Event delegation for dynamically added remove buttons
        customFieldsContainer.addEventListener('click', function (event) {
            if (event.target.classList.contains('remove-custom-field')) {
                const fieldWrapper = event.target.closest('.custom-field-wrapper');
                const fieldId = fieldWrapper.querySelector('input[type="hidden"]').value;
                fieldWrapper.remove();

                // Re-enable the option in the select
                const optionToEnable = customFieldSelect.querySelector(`option[value="${fieldId}"]`);
                if (optionToEnable) {
                    optionToEnable.disabled = false;
                }
            }
        });

        // Handle dynamic URI fields
        const urisContainer = document.getElementById('uris-container');
        document.getElementById('add-uri').addEventListener('click', function () {
            const uriFieldWrapper = document.createElement('div');
            uriFieldWrapper.classList.add('uri-field', 'mt-2');
            uriFieldWrapper.innerHTML = `
                <input class="block mt-1 w-full" type="text" name="uris[]" placeholder="Enter URI" />
                <button type="button" class="remove-uri mt-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Remove</button>
            `;
            urisContainer.appendChild(uriFieldWrapper);

            // Handle removal of URI fields
            uriFieldWrapper.querySelector('.remove-uri').addEventListener('click', function () {
                uriFieldWrapper.remove();
            });
        });

        // Event delegation for dynamically added remove buttons
        urisContainer.addEventListener('click', function (event) {
            if (event.target.classList.contains('remove-uri')) {
                event.target.closest('.uri-field').remove();
            }
        });
    });
</script>
