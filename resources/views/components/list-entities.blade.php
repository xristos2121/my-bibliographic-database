<div class="container">
    <div class="row">
        <div class="col-lg-3">
        <x-browse-sidebar />
        </div>
        <div class="col-lg-9">
            <div class="generic-container-border browse-main-wrapper">
                <div class="browse-results-section">
                    <h2 class="browse-results-title">{{ $title }}</h2>
                    <p class="text-muted">Total {{ strtolower($title) }} found: <strong>{{ $total }}</strong></p>
                    @if($entities->count() > 0)
                        <div class="list-group">
                            @foreach ($entities as $entity)
                                <a href="{{ url($urlPrefix . '/' . $entity->$urlField) }}" class="list-group-item list-group-item-action">
                                    <h5 class="mb-1">
                                        @foreach ($titleFields as $field)
                                            {{ $entity->$field }}
                                        @endforeach
                                    </h5>
                                </a>
                            @endforeach
                        </div>
                        <!-- Pagination links -->
                        <div class="mt-3">
                            {{ $entities->links('vendor.pagination.default') }}
                        </div>
                    @else
                        <div class="alert alert-info" role="alert">
                            No {{ strtolower($title) }} found. Please check back later.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
