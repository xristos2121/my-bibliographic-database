<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="flex-1 min-w-0">
                            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">Publication
                                Types</h2>
                        </div>
                        <a href="{{ route('publications_types.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-700">Add
                            New Publication Type</a>
                    </div>
                </div>
                <div class="px-6 py-4 bg-white border-b border-gray-200">
                    <form action="{{ route('publications_types.index') }}" method="GET" class="flex items-center">
                        <input type="text" name="search" value="{{ $search ?? '' }}"
                               placeholder="Search publication types..."
                               class="flex-1 px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"/>
                        <button type="submit"
                                class="px-4 ml-2 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">Search
                        </button>
                        <a href="{{ route('publications_types.index') }}"
                           class="ml-2 px-4 py-2 bg-white text-black rounded-md shadow hover:bg-gray-200">Clear
                            all</a>
                    </form>
                </div>

                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div
                            class="p-4 mb-4 text-sm text-white rounded-lg bg-green-400 dark:bg-gray-800 dark:text-green-500"
                            role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div
                            class="p-4 mb-4 text-sm text-red-500 rounded-lg bg-red-50 dark:bg-gray-600 dark:text-red-500"
                            role="alert">
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
                        @foreach($types as $type)
                            <tr>
                                <td class="border px-4 py-2">{{ $type->id }}</td>
                                <td class="border px-4 py-2">{{ $type->name }}</td>
                                <td class="border px-4 py-2">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('publications_types.edit', $type->id) }}"
                                           class="inline-flex items-center px-3 py-1 bg-blue-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-600 focus:outline-none focus:border-blue-700 focus:ring ring-blue-200 transition ease-in-out duration-150">Edit</a>
                                        <form action="{{ route('publications_types.destroy', $type->id) }}"
                                              method="POST" class="inline-flex">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-1 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 active:bg-red-700 focus:outline-none focus:border-red-800 focus:ring ring-red-300 transition ease-in-out duration-150"
                                                    onclick="return confirm('Are you sure?')">Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $types->appends(request()->except('page'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
