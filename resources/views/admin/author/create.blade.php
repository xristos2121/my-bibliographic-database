<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Add Author') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto border-b border-gray-200 bg-white p-6">
                    <form action="{{ route('author.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mt-4">
                            <x-form.label for="first_name" value="First Name" />
                            <x-form.input id="first_name" name="first_name" value="{{ old('first_name') }}" type="text" class="block mt-1 w-full" />
                            <x-form.error :messages="$errors->get('first_name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-form.label for="last_name" value="Last Name" />
                            <x-form.input id="last_name" name="last_name" value="{{ old('last_name') }}" type="text" class="block mt-1 w-full" />
                            <x-form.error :messages="$errors->get('last_name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-form.label for="email" value="Email" />
                            <x-form.input id="email" name="email" value="{{ old('email') }}" type="email" class="block mt-1 w-full" required/>
                            <x-form.error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-form.label for="affiliation" value="Affiliation" />
                            <x-form.input id="affiliation" name="affiliation" value="{{ old('affiliation') }}" type="text" class="block mt-1 w-full" />
                            <x-form.error :messages="$errors->get('affiliation')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-form.label for="department" value="Department" />
                            <x-form.input id="department" name="department" value="{{ old('department') }}" type="text" class="block mt-1 w-full" />
                            <x-form.error :messages="$errors->get('department')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-form.label for="position" value="Position" />
                            <x-form.input id="position" name="position" value="{{ old('position') }}" type="text" class="block mt-1 w-full" />
                            <x-form.error :messages="$errors->get('position')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-form.label for="orcid_id" value="ORCID ID" />
                            <x-form.input id="orcid_id" name="orcid_id" value="{{ old('orcid_id') }}" type="text" class="block mt-1 w-full" />
                            <x-form.error :messages="$errors->get('orcid_id')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-form.label for="profile_picture" value="Profile Picture" />
                            <x-form.input id="profile_picture" name="profile_picture" value="{{ old('profile_picture') }}" type="file" class="block mt-1 w-full" />
                            <x-form.error :messages="$errors->get('profile_picture')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-form.label for="biography" value="Biography" />
                            <textarea id="biography" name="biography" class="block mt-1 w-full">{{ old('biography') }}</textarea>
                            <x-form.error :messages="$errors->get('biography')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-form.label for="research_interests" value="Research Interests" />
                            <textarea id="research_interests" name="research_interests" class="block mt-1 w-full">{{ old('research_interests') }}</textarea>
                            <x-form.error :messages="$errors->get('research_interests')" class="mt-2" />
                        </div>

                        <div class="flex flex-wrap justify-end mt-4">
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
