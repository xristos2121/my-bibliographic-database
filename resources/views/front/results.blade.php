<x-front-layout>
    <div class="container">
        <h1>Advanced Publication Search</h1>
        <form id="advanced-search-form" action="{{ url('/advanced-search/results') }}" method="GET" class="col-sm-8">
            <div id="filters-container">
                @if(isset($searchParameters['type']) && isset($searchParameters['lookfor']))
                    @foreach($searchParameters['type'] as $index => $type)
                        <div class="form-group filter-group d-flex align-items-center">
                            <select name="type[]" class="form-control mr-2">
                                <option value="entire_document" {{ $type === 'entire_document' ? 'selected' : '' }}>
                                    Entire Document
                                </option>
                                <option value="title" {{ $type === 'title' ? 'selected' : '' }}>Title</option>
                                <option value="author" {{ $type === 'author' ? 'selected' : '' }}>Author</option>
                                <option value="abstract" {{ $type === 'abstract' ? 'selected' : '' }}>Abstract</option>
                                <option value="keyword" {{ $type === 'keyword' ? 'selected' : '' }}>Keyword</option>
                                <option value="publisher" {{ $type === 'publisher' ? 'selected' : '' }}>Publisher
                                </option>
                            </select>
                            <input type="text" name="lookfor[]" class="form-control mr-2"
                                   value="{{ $searchParameters['lookfor'][$index] ?? '' }}">
                            @if($index > 0)
                                <div type="button" onclick="removeFilter(this)">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="20" height="20" viewBox="0 0 256 256" xml:space="preserve">
                                        <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                            <path d="M 11 90 c -2.815 0 -5.63 -1.074 -7.778 -3.222 c -4.295 -4.296 -4.295 -11.261 0 -15.557 l 68 -68 c 4.297 -4.296 11.26 -4.296 15.557 0 c 4.296 4.296 4.296 11.261 0 15.557 l -68 68 C 16.63 88.926 13.815 90 11 90 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(214,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                            <path d="M 79 90 c -2.815 0 -5.63 -1.074 -7.778 -3.222 l -68 -68 c -4.295 -4.296 -4.295 -11.261 0 -15.557 c 4.296 -4.296 11.261 -4.296 15.557 0 l 68 68 c 4.296 4.296 4.296 11.261 0 15.557 C 84.63 88.926 81.815 90 79 90 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(214,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                        </g>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
            <button type="button" class="addFilterBtn" onclick="addFilter()">Add Filter</button>
            <div class="form-group">
                <label for="fromMonthYear">From</label>
                <input type="month" id="fromMonthYear" name="fromMonthYear" class="form-control"
                       value="{{ $searchParameters['fromMonthYear'] ?? '' }}">
            </div>
            <div class="form-group">
                <label for="untilMonthYear">Until</label>
                <input type="month" id="untilMonthYear" name="untilMonthYear" class="form-control"
                       value="{{ $searchParameters['untilMonthYear'] ?? '' }}">
            </div>
            <div class="form-group">
                <label for="hits_per_page">Hits per page</label>
                <select name="hits_per_page" class="form-control">
                    <option value="10" {{ ($searchParameters['hits_per_page'] ?? '') == '10' ? 'selected' : '' }}>10
                    </option>
                    <option value="20" {{ ($searchParameters['hits_per_page'] ?? '') == '20' ? 'selected' : '' }}>20
                    </option>
                    <option value="50" {{ ($searchParameters['hits_per_page'] ?? '') == '50' ? 'selected' : '' }}>50
                    </option>
                    <option value="100" {{ ($searchParameters['hits_per_page'] ?? '') == '100' ? 'selected' : '' }}>
                        100
                    </option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
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
    </div>

    <script>
        function addFilter() {
            const filterContainer = document.getElementById('filters-container');
            const newFilter = document.createElement('div');
            newFilter.className = 'form-group filter-group d-flex align-items-center';
            newFilter.innerHTML = `
                <select name="type[]" class="form-control mr-2">
                    <option value="entire_document">Entire Document</option>
                    <option value="title">Title</option>
                    <option value="author">Author</option>
                    <option value="abstract">Abstract</option>
                    <option value="keyword">Keyword</option>
                    <option value="publisher">Publisher</option>
                </select>
                <input type="text" name="lookfor[]" class="form-control mr-2">
                <div onclick="removeFilter(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                     version="1.1" width="20" height="20" viewBox="0 0 256 256" xml:space="preserve">
                                    <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;"
                                       transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                        <path
                                            d="M 11 90 c -2.815 0 -5.63 -1.074 -7.778 -3.222 c -4.295 -4.296 -4.295 -11.261 0 -15.557 l 68 -68 c 4.297 -4.296 11.26 -4.296 15.557 0 c 4.296 4.296 4.296 11.261 0 15.557 l -68 68 C 16.63 88.926 13.815 90 11 90 z"
                                            style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(214,0,0); fill-rule: nonzero; opacity: 1;"
                                            transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                        <path
                                            d="M 79 90 c -2.815 0 -5.63 -1.074 -7.778 -3.222 l -68 -68 c -4.295 -4.296 -4.295 -11.261 0 -15.557 c 4.296 -4.296 11.261 -4.296 15.557 0 l 68 68 c 4.296 4.296 4.296 11.261 0 15.557 C 84.63 88.926 81.815 90 79 90 z"
                                            style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(214,0,0); fill-rule: nonzero; opacity: 1;"
                                            transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                    </g>
                                </svg>
                </div>
            `;
            filterContainer.appendChild(newFilter);
        }

        function removeFilter(button) {
            const filterGroup = button.closest('.filter-group');
            filterGroup.remove();
        }
    </script>
</x-front-layout>
