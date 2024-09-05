<x-front-layout>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <x-browse-sidebar />
            </div>
            <div class="col-lg-9">
                <div class="generic-container-border browse-main-wrapper">
                    <div class="browse-results-section">
                        <h2 class="browse-results-title">Years</h2>
                        @if($years->count() > 0)
                            <div class="list-group">
                                @foreach ($years as $year)
                                    <a href="{{ url('/browse/years/' . $year->year) }}" class="list-group-item list-group-item-action">
                                        <h5 class="mb-1">{{ $year->year }}</h5>
                                    </a>
                                @endforeach
                            </div>
                            <!-- Pagination links -->
                            <div class="mt-3">
                                {{ $years->links('vendor.pagination.default') }}
                            </div>
                        @else
                            <div class="alert alert-info" role="alert">
                                No years found. Please check back later.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-front-layout>
