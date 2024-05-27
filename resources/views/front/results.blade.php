<x-front-layout>
    <div class="container">
        <h1>Advanced Publication Search</h1>
        <form id="advanced-search-form" action="{{ url('/advanced-search/results') }}" method="GET" class="col-sm-8">
            <div class="search-results-input-search">
                <div class="search-results-input-search-wrapper">
                    <div class="search-results-input-search-select-wrapper">
                        <select name="type" style="border: none; background: none; margin-right: 10px;">
                            <option value="entire_document" selected>Entire Document</option>
                            <option value="title">Title</option>
                            <option value="author">Author</option>
                            <option value="abstract">Abstract</option>
                            <option value="keyword">Keyword</option>
                            <option value="publisher">Publisher</option>
                        </select>
                    </div>
                    <input type="text" name="lookfor" class="form-control"
                           style="flex: 1; border: none; outline: none;">
                </div>
                <div class="search-button">
                    <button type="submit" style="background: none; border: none; padding: 0 10px; cursor: pointer;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-search">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </button>
                </div>
            </div>
        </form>

        <div class="search-results-section">
            <div class="search-results-wrapper">
                <h2>Search Results</h2>
                @if ($results->count() > 0)
                    <div class="search-results">
                        @foreach ($results as $result)
                            <div class="search-results-item">
                                <a href="{{ url('/publication/' . $result->id) }}">
                                    <h3>{{ $result->title }}</h3>
                                </a>
                                <div class="publication-data-wrapper">
                                    <div class="publication-data-row">
                                        <span class="publication-data-label">Author:</span>
                                        <span class="publication-data-value">
                                            @foreach ($result->authors as $author)
                                                {{ $author->first_name }} {{ $author->last_name }}{{ !$loop->last ? ', ' : '' }}
                                            @endforeach
                                        </span>
                                    </div>
                                    <div class="publication-data-row">
                                        <span class="publication-data-label">Date:</span>
                                        <span class="publication-data-value">
                                             @php
                                                 $date = new DateTime($result->publication_date);
                                                 $formattedDate = $date->format('d F Y');
                                             @endphp
                                            <span>{{ $formattedDate }}</span>
                                        </span>
                                    </div>
                                    <div class="publication-data-row">
                                        <span class="publication-data-label">Document Type:</span>
                                        <span class="publication-data-value">
                                            @if($result->types)
                                                <span>{{ $result->types->name }}</span>
                                            @else
                                                <span>N/A</span>
                                            @endif
                                        </span>
                                    </div>
                                    @if ($result->hasPublisher())
                                        <div class="publication-data-row">
                                            <span class="publication-data-label">Publisher:</span>
                                            <span class="publication-data-value">
                                                {{ $result->publisher->name }}
                                        </span>
                                        </div>
                                    @endif
                                    @if ($result->hasKeywords())
                                        <div class="publication-data-row">
                                            <span class="publication-data-label">Keywords:</span>
                                            <span class="publication-data-value">
                                                @foreach ($result->keywords as $keyword)
                                                    {{ $keyword->keyword }}{{ !$loop->last ? ', ' : '' }}
                                                @endforeach
                                            </span>
                                        </div>
                                    @endif
                                    @if ($result->file)
                                        <div class="publication-data-row">
                                            <span class="publication-data-label">File:</span>
                                            <span class="publication-data-value">
                                          <a href="{{ Storage::url($result->file) }}" class="preview-publication"
                                             target="_blank">
                                                Preview Publication
                                            </a>
                                            </span>
                                        </div>
                                    @endif
                                    <p>{{ $result->abstract }}</p>
                                    <div>
                                        <a href="{{ url('/publication/' . $result->id) }}">View Publication</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>No results found.</p>
                @endif
            </div>
        </div>
</x-front-layout>
