<x-app-layout>
    <div class="py-12">
        <div class="max-w-screen-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Custom Header -->
                <div class="p-6 bg-white border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">Publications</h2>
                    <a href="{{ route('publications.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                        {{ __('Add Publication') }}
                    </a>
                </div>

                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Search Form -->
                    <form action="{{ route('publications.index') }}" method="GET" class="mb-4" id="search-form">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- ID and Title -->
                            <div>
                                <x-form.label for="search" :value="__('ID or Title')" />
                                <x-form.input id="search" class="block mt-1 w-full" type="text" name="search" :value="request('search')" placeholder="Search by ID or Title" />
                            </div>

                            <!-- Publication Date From -->
                            <div>
                                <x-form.label for="publication_date_from" :value="__('Publication Date From')" />
                                <x-form.input id="publication_date_from" class="block mt-1 w-full" type="text" name="publication_date_from" :value="request('publication_date_from')" />
                            </div>

                            <!-- Publication Date To -->
                            <div>
                                <x-form.label for="publication_date_to" :value="__('Publication Date To')" />
                                <x-form.input id="publication_date_to" class="block mt-1 w-full" type="text" name="publication_date_to" :value="request('publication_date_to')" />
                            </div>

                            <!-- Publisher -->
                            <div>
                                <x-form.label for="publisher_id" :value="__('Publisher')" />
                                <select id="publisher_id" name="publisher_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
                                    <option value="">{{ __('Select Publisher') }}</option>
                                    @foreach($publishers as $publisher)
                                        <option value="{{ $publisher->id }}" {{ request('publisher_id') == $publisher->id ? 'selected' : '' }}>{{ $publisher->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Type -->
                            <div>
                                <x-form.label for="type_id" :value="__('Type')" />
                                <select id="type_id" name="type_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
                                    <option value="">{{ __('Select Type') }}</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}" {{ request('type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Categories -->
                            <div>
                                <x-form.label for="categories" :value="__('Categories')" />
                                <select id="categories" name="categories[]" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" multiple>
                                    @foreach($categoriesWithPath as $category)
                                        <option value="{{ $category->id }}" {{ collect(request('categories'))->contains($category->id) ? 'selected' : '' }}>{{ $category->full_path }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Authors -->
                            <div>
                                <x-form.label for="authors" :value="__('Authors')" />
                                <select id="authors" name="authors[]" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" multiple>
                                    @foreach($authors as $author)
                                        <option value="{{ $author->id }}" {{ collect(request('authors'))->contains($author->id) ? 'selected' : '' }}>
                                            {{ $author->first_name }} {{ $author->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Keywords -->
                            <div>
                                <x-form.label for="keywords" :value="__('Keywords')" />
                                <select id="keywords" name="keywords[]" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" multiple>
                                    @foreach($keywords as $keyword)
                                        <option value="{{ $keyword->id }}" {{ collect(request('keywords'))->contains($keyword->id) ? 'selected' : '' }}>
                                            {{ $keyword->keyword }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Active Status -->
                            <div>
                                <x-form.label for="active" :value="__('Active')" />
                                <select id="active" name="active" class="block w-full rounded-md shadow-sm border-gray-300">
                                    <option value="">{{ __('Select Status') }}</option>
                                    <option value="1" {{ request('active') == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ request('active') == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end gap-2">
                            <x-button>{{ __('Search') }}</x-button>
                            <a href="{{ route('publications.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Clear') }}
                            </a>
                        </div>
                    </form>

                    <!-- Display Total Results -->
                    @if(session('success'))
                        <div class="p-4 mb-4 text-sm text-white rounded-lg bg-green-400 dark:bg-gray-800 dark:text-green-500" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="p-4 mb-4 text-sm text-red-500 rounded-lg bg-red-50 dark:bg-gray-600 dark:text-red-500" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(isset($totalPublications))
                        <div class="mt-4 text-gray-600 font-bold text-lg">
                            {{ __('Total Publications Found:') }} {{ $totalPublications }}
                        </div>
                    @endif

                    <!-- Publications Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                            <tr>
                                <th class="px-4 py-2">ID</th>
                                <th class="px-4 py-2">Title</th>
                                <th class="px-4 py-2 hidden md:table-cell">Publication Date</th>
                                <th class="px-4 py-2 ">Type</th>
                                <th class="px-4 py-2 hidden md:table-cell">Active</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($publications as $publication)
                                <tr>
                                    <td class="border px-2 py-2">{{ $publication->id }}</td>
                                    <td class="border px-2 py-2">{{ $publication->title }}</td>
                                    <td class="border px-2 py-2 hidden md:table-cell">{{ $publication->publication_date ?: 'N/A' }}</td>
                                    <td class="border px-2 py-2">{{ $publication->types->name ?: 'N/A' }}</td>
                                    <td class="border px-2 py-2 hidden md:table-cell">{{ $publication->active ? 'Yes' : 'No' }}</td>
                                    <td class="border px-2 py-2">
                                        <a href="{{ route('publications.edit', $publication) }}" class="inline-flex items-center px-3 py-1 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 transition ease-in-out duration-150">{{ __('Edit') }}</a>
                                        <form action="{{ route('publications.destroy', $publication->id) }}" method="POST" class="inline-flex">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 active:bg-red-700 focus:outline-none focus:border-red-800 focus:ring ring-red-300 transition ease-in-out duration-150" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="border px-4 py-2 text-center">No publications found</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    <div class="mt-4">
                        {{ $publications->appends(request()->query())->links() }}
                    </div>
                    <!-- End of Publications Table -->
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#authors, #keywords, #categories, #type_id, #publisher_id').select2({tags: true, tokenSeparators: [',', ' '], allowClear: true, width: '100%'});
        });
    </script>
</x-app-layout>
