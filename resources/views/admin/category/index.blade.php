<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="flex-1 min-w-0">
                            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">Categories</h2>
                        </div>
                        <a href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">Add New Category</a>
                    </div>
                </div>
                <div class="px-6 py-4 bg-white border-b border-gray-200">
                    <form action="{{ route('categories.index') }}" method="GET" class="flex items-center">
                        <input type="text" name="search" value="{{ $search ?? '' }}"
                               placeholder="Search categories..."
                               class="flex-1 px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"/>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">Search
                        </button>
                        <a href="{{ route('categories.index') }}"
                           class="ml-2 px-4 py-2 bg-white text-black rounded-md shadow hover:bg-gray-200">Clear
                            all</a>
                    </form>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('status'))
                        <div class="p-4 mb-4 text-sm text-dark-600 rounded-lg bg-green-400 dark:bg-gray-800 dark:text-green-500" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        @if(session('error'))
                            <div class="p-4 mb-4 text-sm text-red-500 rounded-lg bg-red-50 dark:bg-gray-600 dark:text-red-500" role="alert">
                                {{ session('error') }}
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
                        @foreach($categories as $category)
                            <tr>
                                <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="border px-4 py-2">{{ $category->name }}</td>
                                <td class="border px-4 py-2">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('categories.children', $category->id) }}" class="inline-flex items-center px-3 py-1 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 active:bg-green-600 focus:outline-none focus:border-green-700 focus:ring ring-green-200 transition ease-in-out duration-150">View Children</a>
                                        <a href="{{ route('categories.edit', $category->id) }}" class="inline-flex items-center px-3 py-1 bg-blue-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-600 focus:outline-none focus:border-blue-700 focus:ring ring-blue-200 transition ease-in-out duration-150">Edit</a>
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline-flex">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 active:bg-red-700 focus:outline-none focus:border-red-800 focus:ring ring-red-300 transition ease-in-out duration-150" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!-- Pagination Links -->
                    <div class="mt-4">
                        {{ $categories->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
