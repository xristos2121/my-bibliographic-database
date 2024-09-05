<x-front-layout>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <x-browse-sidebar />
            </div>
            <div class="col-lg-9">
                <div class="generic-container-border browse-main-wrapper">
                    <div class="browse-results-section">
                        <h2 class="browse-results-title">Browse by Types</h2>
                        @if($types->count() > 0)
                            <div class="list-group">
                                @foreach ($types as $type)
                                    <a href="{{ route('browse.publicationsByType', $type->id) }}" class="list-group-item list-group-item-action">
                                        <h5 class="mb-1">{{ $type->name }}</h5>
                                        <p class="mb-1">{{ $type->description }}</p>
                                    </a>
                                @endforeach
                            </div>
                            <!-- Pagination links -->
                            <div class="mt-3">
                                {{ $types->links('vendor.pagination.default') }}
                            </div>
                        @else
                            <div class="alert alert-info" role="alert">
                                No types found. Please check back later.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-front-layout>
