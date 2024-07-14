<x-front-layout>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <x-browse-sidebar />
            </div>
            <div class="col-lg-9">
                <div class="generic-container-border browse-main-wrapper">
                    <div class="browse-results-section">
                        <h2 class="browse-results-title">Categories</h2>
                        @if($categories->count() > 0)
                            <div class="list-group">
                                @foreach ($categories as $category)
                                    <a href="{{ url('/browse/categories/' . $category->slug) }}" class="list-group-item list-group-item-action">
                                        <h5 class="mb-1">{{ $category->name }}</h5>
                                        <p class="mb-1">{{ $category->description }}</p>
                                    </a>
                                @endforeach
                            </div>
                            <!-- Pagination links -->
                            <div class="mt-3">
                                {{ $categories->links('vendor.pagination.default') }}
                            </div>
                        @else
                            <div class="alert alert-info" role="alert">
                                No categories found. Please check back later.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-front-layout>
