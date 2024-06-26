<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Create Publisher') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto border-b border-gray-200 bg-white p-6">
                    <form action="{{ route('publisher.store') }}" method="POST">
                        @csrf

                        <div class="mt-4">
                            <x-form.label for="name" value="Name" />
                            <x-form.input id="name" name="name" value="{{ old('name') }}" type="text" class="block mt-1 w-full" />
                            <x-form.error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-form.label for="site_url" value="Site Url" />
                            <x-form.input id="site_url" name="site_url" value="{{ old('site_url') }}" type="text" class="block mt-1 w-full" />
                            <x-form.error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-button>
                                Save
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
