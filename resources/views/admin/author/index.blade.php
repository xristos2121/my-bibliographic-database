<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 flex justify-between">
                    <span class="text-2xl font-bold">Authors</span>
                    <a href="{{ route('author.create') }}" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 text-white disabled:opacity-25 transition ease-in-out duration-150">Add New Author</a>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Search Form -->
                    <form action="{{ route('author.index') }}" method="GET" class="mb-4">
                        <div class="mx-auto">
                            <div class="flex flex-wrap gap-4">
                                <div class="flex-1">
                                    <x-form.label for="search" class="block text-sm font-medium text-gray-700">Search</x-form.label>
                                    <x-form.input type="text" id="search" name="search" value="{{ request()->get('search', '') }}" placeholder="Search by ID, First Name, Last Name, or Email" class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm" />
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-4 mt-4">
                                <div class="flex-1">
                                    <x-form.label for="affiliation" class="block text-sm font-medium text-gray-700">Affiliation</x-form.label>
                                    <x-form.input type="text" id="affiliation" name="affiliation" value="{{ request()->get('affiliation', '') }}" placeholder="Affiliation" class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm" />
                                </div>
                                <div class="flex-1">
                                    <x-form.label for="position" class="block text-sm font-medium text-gray-700">Position</x-form.label>
                                    <x-form.input type="text" id="position" name="position" value="{{ request()->get('position', '') }}" placeholder="Position" class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm" />
                                </div>
                                <div class="flex-1">
                                    <x-form.label for="orcid_id" class="block text-sm font-medium text-gray-700">Orcid ID</x-form.label>
                                    <x-form.input type="text" id="orcid_id" name="orcid_id" value="{{ request()->get('orcid_id', '') }}" placeholder="Orcid ID" class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm" />
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-4 mt-4 justify-end">
                                <a href="{{ route('author.index') }}" class="mt-6 px-4 py-2 bg-gray-500 text-white rounded-md shadow hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">Clear All</a>
                                <button type="submit" class="mt-6 px-4 py-2 bg-blue-500 text-white rounded-md shadow hover:bg-blue-500 focus:outline-none focus:ring-2 focus:bg-blue-500 focus:ring-opacity-50">Search</button>
                            </div>
                        </div>
                    </form>
                    <!-- End Search Form -->
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
                    @if(isset($totalResults))
                        <div class="mt-4 text-gray-600 font-bold text-lg">
                            {{ __('Total Results:') }} {{ $totalResults }}
                        </div>
                    @endif
                    <table class="table-auto w-full">
                        <thead>
                        <tr>
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($authors as $author)
                            <tr>
                                <td class="border px-4 py-2">{{ $author->id }}</td>
                                <td class="border px-4 py-2">{{ $author->first_name }} {{ $author->last_name }}</td>
                                <td class="border px-4 py-2">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('author.edit', $author->id) }}" class="inline-flex items-center px-3 py-1 bg-blue-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-600 focus:outline-none focus:border-blue-700 focus:ring ring-blue-200 transition ease-in-out duration-150">Edit</a>
                                        <form action="{{ route('author.destroy', $author->id) }}" method="POST" class="inline-flex">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 active:bg-red-700 focus:outline-none focus:border-red-800 focus:ring ring-red-300 transition ease-in-out duration-150" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4">No authors found</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $authors->appends(request()->except('page'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
