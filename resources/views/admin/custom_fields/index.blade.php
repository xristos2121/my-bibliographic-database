<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="flex-1 min-w-0">
                            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">Custom Fields</h2>
                        </div>
                        <a href="{{ route('custom_fields.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">Add New Custom Field</a>
                    </div>
                </div>
                <div class="px-6 py-4 bg-white border-b border-gray-200">
                    <form action="{{ route('custom_fields.index') }}" method="GET" class="flex items-center">
                        <input type="text" name="search" value="{{ $search ?? '' }}"
                               placeholder="Search custom fields..."
                               class="flex-1 px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"/>
                        <select name="type" class="w-fit py-2 mr-1 border rounded-md ml-2">
                            <option value="">{{ __('All') }}</option>
                            <option value="text" {{ request('type') === 'text' ? 'selected' : '' }}>{{ __('Text') }}</option>
                            <option value="textarea" {{ request('type') === 'textarea' ? 'selected' : '' }}>{{ __('TextArea') }}</option>
                            <option value="number" {{ request('type') === 'number' ? 'selected' : '' }}>{{ __('Number') }}</option>
                        </select>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">Search
                        </button>
                        <a href="{{ route('custom_fields.index') }}"
                           class="ml-2 px-4 py-2 bg-white text-black rounded-md shadow hover:bg-gray-200">Clear
                            all</a>
                    </form>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                        @if(session('success'))
                            <div class="p-4 mb-4 text-sm text-dark-600 rounded-lg bg-green-400 dark:bg-gray-800 dark:text-green-500" role="alert">
                                {{ session('success') }}
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
                            <th class="px-4 py-2">Type</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($fieldDefinitions as $field)
                            <tr>
                                <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="border px-4 py-2">{{ $field->name }}</td>
                                <td class="border px-4 py-2">{{ $field->type }}</td>
                                <td class="border px-4 py-2">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('custom_fields.edit', $field->id) }}" class="inline-flex items-center px-3 py-1 bg-blue-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-600 focus:outline-none focus:border-blue-700 focus:ring ring-blue-200 transition ease-in-out duration-150">Edit</a>
                                        <form action="{{ route('custom_fields.destroy', $field->id) }}" method="POST" class="inline-flex">
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
                        {{ $fieldDefinitions->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
