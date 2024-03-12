<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Publications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 flex justify-between">
                    <span>{{ __('All Publications') }}</span>
                    <a href="{{ route('publications.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs  uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                        {{ __('Add Publication') }}
                    </a>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Publications Table -->
                    <table class="table-auto w-full">
                        <thead>
                        <tr>
                            <th class="px-4 py-2">Title</th>
                            <th class="px-4 py-2">Abstract</th>
                            <th class="px-4 py-2">Publication Date</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($publications as $publication)
                            <tr>
                                <td class="border px-4 py-2">{{ $publication->title }}</td>
                                <td class="border px-4 py-2">{{ $publication->abstract }}</td>
                                <td class="border px-4 py-2">{{ $publication->publication_date ? $publication->publication_date->toFormattedDateString() : 'N/A' }}</td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('publications.edit', $publication) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!-- End of Publications Table -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
