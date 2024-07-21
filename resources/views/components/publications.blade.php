@if ($results->count() > 0)
    <p><b>Total found: {{ $results->total() }}</b></p>
    <div class="search-results">
        @foreach ($results as $result)
            <div class="search-results-item">
                <a href="{{ url('/record/' . $result->slug) }}">
                    <h1>{{ $result->title }}</h1>
                </a>
                <div class="publication-data-wrapper">
                    @if ($result->hasAuthors())
                        <div class="publication-data-row">
                            <span class="publication-data-label">{{ __('messages.results.author') }}</span>
                            <span class="publication-data-value">
                                @foreach ($result->authors as $author)
                                    <a href="{{ url('/browse/authors/' . $author->id) }}">{{ $author->first_name }} {{ $author->last_name }}</a>{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </span>
                        </div>
                    @endif
                    <div class="publication-data-row">
                        <span class="publication-data-label">{{ __('messages.results.date') }}</span>
                        <span class="publication-data-value">{{ $result->publication_date }}</span>
                    </div>
                    <div class="publication-data-row">
                        <span class="publication-data-label">{{ __('messages.results.document_type') }}</span>
                        <span class="publication-data-value">
                            @if($result->types)
                                <a href="{{ url('/browse/types/' . $result->types->id) }}">{{ $result->types->name }}</a>
                            @else
                                <span>N/A</span>
                            @endif
                        </span>
                    </div>
                    @if ($result->hasPublisher())
                        <div class="publication-data-row">
                            <span class="publication-data-label">{{ __('messages.results.publisher') }}</span>
                            <span class="publication-data-value">
                                <a href="{{ url('/browse/publishers/' . $result->publisher->id) }}">{{ $result->publisher->name }}</a>
                            </span>
                        </div>
                    @endif
                    @if ($result->hasKeywords())
                        <div class="publication-data-row">
                            <span class="publication-data-label">{{ __('messages.results.keywords') }}</span>
                            <span class="publication-data-value">
                                @foreach ($result->keywords as $keyword)
                                    <a href="{{ url('/browse/keywords/' . $keyword->slug) }}">{{ $keyword->keyword }}</a>{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </span>
                        </div>
                    @endif
                    @if ($result->hasCollections())
                        <div class="publication-data-row">
                            <span class="publication-data-label">{{ __('messages.results.categories') }}</span>
                            <span class="publication-data-value">
                                @foreach ($result->collections as $collection)
                                    <a href="{{ url('/browse/categories/' . $collection->slug) }}">{{ $collection->name }}</a>{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </span>
                        </div>
                    @endif
                    @if ($result->file)
                        <div class="publication-data-row">
                            <span class="publication-data-label">{{ __('messages.results.file') }}</span>
                            <span class="publication-data-value">
                                <a href="{{ Storage::url($result->file) }}" class="preview-publication-btn" target="_blank">
                                    {{ __('messages.results.preview_publication') }}
                                </a>
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
                        <a href="{{ url('/record/' . $result->slug) }}">{{ __('messages.results.view_more') }}</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- Pagination links -->
    {{ $results->appends(request()->input())->links('vendor.pagination.default') }}
@else
    <p>{{ __('messages.results.no_results') }}</p>
@endif
