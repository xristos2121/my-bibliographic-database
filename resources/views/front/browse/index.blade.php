<x-front-layout>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="generic-container-border side-navigation-wrapper">
                    <h3 class="side-navigation-title">Browse By</h3>
                    <ul class="list-group">
                        <li class="list-group-item"><a href="{{ url('/browse/categories') }}">Browse by Categories</a></li>
                        <li class="list-group-item"><a href="{{ url('/browse/keywords') }}">Browse by Keywords</a></li>
                        <li class="list-group-item"><a href="{{ url('/browse/authors') }}">Browse by Authors</a></li>
                        <li class="list-group-item"><a href="{{ url('/browse/publishers') }}">Browse by Publishers</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="generic-container-border browse-main-wrapper">
                    <div class="browse-results-section">
                        <span class="browse-results-title">Browse</span>
                        @if($results->count() > 0)
                            <p><b>Total publications found: {{ $totalResults }}</b></p>
                            <p><i>Publications are ordered by the latest entries.</i></p>
                            <div class="browse-results">
                                @foreach ($results as $result)
                                    <div class="browse-results-item">
                                        <a href="{{ url('/record/' . $result->slug) }}">
                                            <h1>{{ $result->title }}</h1>
                                        </a>
                                        <div class="publication-data-wrapper">
                                            <div class="publication-data-row">
                                                <span class="publication-data-label">Author</span>
                                                <span class="publication-data-value">
                                                    @foreach ($result->authors as $author)
                                                        {{ $author->first_name }} {{ $author->last_name }}{{ !$loop->last ? ', ' : '' }}
                                                    @endforeach
                                                </span>
                                            </div>
                                            <div class="publication-data-row">
                                                <span class="publication-data-label">Date</span>
                                                <span class="publication-data-value">{{ $result->publication_date }}</span>
                                            </div>
                                            <div class="publication-data-row">
                                                <span class="publication-data-label">Document Type</span>
                                                <span class="publication-data-value">
                                                    @if($result->types)
                                                        {{ $result->types->name }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </span>
                                            </div>
                                            @if ($result->hasPublisher())
                                                <div class="publication-data-row">
                                                    <span class="publication-data-label">Publisher</span>
                                                    <span class="publication-data-value">{{ $result->publisher->name }}</span>
                                                </div>
                                            @endif
                                            @if ($result->hasKeywords())
                                                <div class="publication-data-row">
                                                    <span class="publication-data-label">Keywords</span>
                                                    <span class="publication-data-value">
                                                        @foreach ($result->keywords as $keyword)
                                                            {{ $keyword->keyword }}{{ !$loop->last ? ', ' : '' }}
                                                        @endforeach
                                                    </span>
                                                </div>
                                            @endif
                                            @if ($result->file)
                                                <div class="publication-data-row">
                                                    <span class="publication-data-label">File</span>
                                                    <span class="publication-data-value">
                                                        <a href="{{ Storage::url($result->file) }}" class="preview-publication" target="_blank">Preview Publication</a>
                                                    </span>
                                                </div>
                                            @endif
                                            <p class="abstract">{{ $result->abstract }}</p>
                                            @if ($result->highlighted_text)
                                                <p><b>Excerpt:</b> {!! $result->highlighted_text !!}</p>
                                            @endif
                                            <div>
                                                <a href="{{ url('/record/' . $result->slug) }}">View More</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- Pagination links -->
                            {{ $results->appends(request()->input())->links('vendor.pagination.default') }}
                        @else
                            <p>No publications found. Please check back later or browse other categories.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-front-layout>
