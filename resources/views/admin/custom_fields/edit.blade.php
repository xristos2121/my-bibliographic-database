<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Custom Field') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto border-b border-gray-200 bg-white p-6">
                    <form action="{{ route('custom_fields.update', $fieldDefinition->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mt-4">
                            <x-form.label for="name" value="Name" />
                            <x-form.input id="name" name="name" value="{{ old('name', $fieldDefinition->name) }}" type="text" class="block mt-1 w-full" required/>
                            <x-form.error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-form.label for="type" value="Type" />
                            <x-form.select name="type" id="type" class="block mt-1 w-full" >
                                <option value="text" {{ $fieldDefinition->type == 'text' ? 'selected' : '' }}>Text</option>
                                <option value="textarea" {{ $fieldDefinition->type == 'textarea' ? 'selected' : '' }}>Textarea</option>
                                <option value="number" {{ $fieldDefinition->type == 'number' ? 'selected' : '' }}>Number</option>
                            </x-form.select>
                            <x-form.error :messages="$errors->get('type')" class="mt-2" />
                        </div>
                        <div class="flex flex-wrap justify-end mt-4">
                            <x-button>
                                Update
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
