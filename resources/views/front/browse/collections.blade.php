<x-front-layout>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <x-browse-sidebar />
            </div>
            <div class="col-lg-9">
                <div class="generic-container-border browse-main-wrapper">
                    <div class="browse-results-section">
                        <h2 class="browse-results-title">Collections</h2>
                        @if($collections->count() > 0)
                            <div class="list-group">
                                @foreach ($collections as $collection)
                                    <a href="{{ url('/browse/collections/' . $collection->slug) }}" class="list-group-item list-group-item-action">
                                        <h5 class="mb-1">{{ $collection->name }}</h5>
                                        <p class="mb-1">{{ $collection->description }}</p>
                                    </a>
                                @endforeach
                            </div>
                            <!-- Pagination links -->
                            <div class="mt-3">
                                {{ $collections->links('vendor.pagination.default') }}
                            </div>
                        @else
                            <div class="alert alert-info" role="alert">
                                No collections found.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-front-layout>
