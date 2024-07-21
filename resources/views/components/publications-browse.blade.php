@if($results->count() > 0)
    <p><b>Total found: {{ $results->total() }}</b></p>
    <div class="browse-results">
        @foreach ($results as $result)
            <div class="browse-results-item">
                <a href="{{ url('/record/' . $result->slug) }}">
                    <h1>{{ $result->title }}</h1>
                </a>
                <div class="publication-data-wrapper">
                    @if ($result->hasAuthors())
                        <div class="publication-data-row">
                            <span class="publication-data-label">Author</span>
                            <span class="publication-data-value">
                                                    @foreach ($result->authors as $author)
                                    <a href="{{ url('/browse/authors/' . $author->id) }}">{{ $author->first_name }} {{ $author->last_name }}</a>{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                                                </span>
                        </div>
                    @endif
                    <div class="publication-data-row">
                        <span class="publication-data-label">Date</span>
                        <span class="publication-data-value">{{ $result->publication_date }}</span>
                    </div>
                    <div class="publication-data-row">
                        <span class="publication-data-label">Document Type</span>
                        <span class="publication-data-value">
                                                @if($result->types)
                                <a href="{{ url('/browse/types/' . $result->types->id) }}">{{ $result->types->name }}</a>
                            @else
                                N/A
                            @endif
                                            </span>
                    </div>
                    @if ($result->hasPublisher())
                        <div class="publication-data-row">
                            <span class="publication-data-label">Publisher</span>
                            <span class="publication-data-value">
                                                    <a href="{{ url('/browse/publishers/' . $result->publisher->id) }}">{{ $result->publisher->name }}</a>
                                                </span>
                        </div>
                    @endif
                    @if ($result->hasKeywords())
                        <div class="publication-data-row">
                            <span class="publication-data-label">Keywords</span>
                            <span class="publication-data-value">
                                                    @foreach ($result->keywords as $keyword)
                                    <a href="{{ url('/browse/keywords/' . $keyword->slug) }}">{{ $keyword->keyword }}</a>{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                                                </span>
                        </div>
                    @endif
                    @if ($result->hasCategories())
                        <div class="publication-data-row">
                            <span class="publication-data-label">Categories</span>
                            <span class="publication-data-value">
                                                    @foreach ($result->categories as $category)
                                    <a href="{{ url('/browse/categories/' . $category->slug) }}">{{ $category->name }}</a>{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                                                </span>
                        </div>
                    @endif
                    @if ($result->file)
                        <div class="publication-data-row">
                            <span class="publication-data-label">File</span>
                            <span class="publication-data-value">
                                                    <a href="{{ Storage::url($result->file) }}" class="preview-publication-btn" target="_blank">Preview Publication</a>
                                                </span>
                        </div>
                    @endif
                    @if ($result->abstract)
                        <p class="abstract">{{ \Illuminate\Support\Str::limit($result->abstract, 200) }}</p>
                    @endif
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
    <p>No publications found for this {{ strtolower($entityName) }}. Please try a different {{ strtolower($entityName) }} or browse other categories.</p>
@endif
