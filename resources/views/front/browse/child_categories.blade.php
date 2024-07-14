<x-front-layout>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <x-browse-sidebar />
            </div>
            <div class="col-lg-9">
                <div class="generic-container-border browse-main-wrapper">
                    <div class="browse-results-section">
                        <h2 class="browse-results-title">{{ $category->name }}</h2>
                        <p>{{ $category->description }}</p>
                        <p class="text-muted">You are viewing the subcategories of <strong>{{ $category->name }}</strong></p>
                        @if($subcategories->count() > 0)
                            <div class="list-group">
                                @foreach ($subcategories as $child)
                                    <a href="{{ url('/browse/categories/' . $child->slug) }}" class="list-group-item list-group-item-action">
                                        <h5 class="mb-1">{{ $child->name }}</h5>
                                        <p class="mb-1">{{ $child->description }}</p>
                                    </a>
                                @endforeach
                            </div>
                            <!-- Pagination links -->
                            <div class="mt-3">
                                {{ $subcategories->links('vendor.pagination.default') }}
                            </div>
                        @else
                            <div class="alert alert-info" role="alert">
                                No subcategories found. Showing publications for this category instead.
                            </div>
                            <div class="list-group">
                                @foreach ($publications as $publication)
                                    <a href="{{ url('/publications/' . $publication->id) }}" class="list-group-item list-group-item-action">
                                        <h5 class="mb-1">{{ $publication->title }}</h5>
                                        <p class="mb-1">{{ Str::limit($publication->abstract, 150) }}</p>
                                    </a>
                                @endforeach
                            </div>
                            <!-- Pagination links -->
                            <div class="mt-3">
                                {{ $publications->links('vendor.pagination.default') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-front-layout>
