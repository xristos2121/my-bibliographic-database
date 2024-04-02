<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="flex-1 min-w-0">
                            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">Publication Tags</h2>
                        </div>
                        <div class="flex gap-4">
                            <form action="{{ route('tags.index') }}" method="GET" class="flex items-center">
                                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search publication tags..." class="px-4 py-2 border rounded-md" />
                                <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">Search</button>
                            </form>
                            <a href="{{ route('tags.index') }}" class="inline-flex items-center px-4 py-2 bg-white text-black rounded-md  shadow">Clear all</a>
                            <a href="{{ route('tags.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">Add New Tag</a>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('success') }}
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
                        @forelse($tags as $tag)
                            <tr>
                                <td class="border px-4 py-2">{{ $tag->id }}</td>
                                <td class="border px-4 py-2">{{ $tag->name }}</td>
                                <td class="border px-4 py-2">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('tags.edit', $tag->id) }}" class="inline-flex items-center px-3 py-1 bg-blue-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-600 focus:outline-none focus:border-blue-700 focus:ring ring-blue-200 transition ease-in-out duration-150">Edit</a>
                                        <form action="{{ route('tags.destroy', $tag->id) }}" method="POST" class="inline-flex">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 active:bg-red-700 focus:outline-none focus:border-red-800 focus:ring ring-red-300 transition ease-in-out duration-150" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            @if($search)
                                <tr>
                                    <td class="px-4 py-2" colspan="3">Nothing found for "{{ $search }}".</td>
                                </tr>
                            @else
                                <tr>
                                    <td class="px-4 py-2" colspan="3">No tags available.</td>
                                </tr>
                            @endif
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
