<x-front-layout>
    <div class="container">
        <h1>{{ __('messages.advanced_search.title') }}</h1>
        <form id="advanced-search-form" action="{{ url('/advanced-search/results') }}" method="GET" class="col-sm-8">
            <div id="filters-container">
                @if(isset($searchParameters['type']) && isset($searchParameters['lookfor']))
                    @foreach($searchParameters['type'] as $index => $type)
                        <div class="form-group filter-group d-flex align-items-center">
                            <select name="type[]" class="form-control mr-2">
                                <option value="entire_document" {{ $type === 'entire_document' ? 'selected' : '' }}>
                                    {{ __('messages.filters.entire_document') }}
                                </option>
                                <option value="title" {{ $type === 'title' ? 'selected' : '' }}>
                                    {{ __('messages.filters.title') }}
                                </option>
                                <option value="author" {{ $type === 'author' ? 'selected' : '' }}>
                                    {{ __('messages.filters.author') }}
                                </option>
                                <option value="abstract" {{ $type === 'abstract' ? 'selected' : '' }}>
                                    {{ __('messages.filters.abstract') }}
                                </option>
                                <option value="keyword" {{ $type === 'keyword' ? 'selected' : '' }}>
                                    {{ __('messages.filters.keyword') }}
                                </option>
                                <option value="publisher" {{ $type === 'publisher' ? 'selected' : '' }}>
                                    {{ __('messages.filters.publisher') }}
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
            <button type="button" class="addFilterBtn" onclick="addFilter()">{{ __('messages.filters.add') }}</button>
            <div class="form-group">
                <label for="hits_per_page">{{ __('messages.search.type') }}</label>
                <select name="document_type" class="form-control">
                    <option value="all" {{ ($searchParameters['document_type'] ?? '') == 'all' ? 'selected' : '' }}>
                        {{ __('All') }}
                    </option>
                    @foreach($types as $type)
                        <option value="{{ $type->id }}" {{ ($searchParameters['document_type'] ?? '') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="fromMonthYear">{{ __('messages.form.from') }}</label>
                <input type="month" id="fromMonthYear" name="fromMonthYear" class="form-control"
                       value="{{ $searchParameters['fromMonthYear'] ?? '' }}">
            </div>
            <div class="form-group">
                <label for="untilMonthYear">{{ __('messages.form.until') }}</label>
                <input type="month" id="untilMonthYear" name="untilMonthYear" class="form-control"
                       value="{{ $searchParameters['untilMonthYear'] ?? '' }}">
            </div>
            <div class="form-group">
                <label for="hits_per_page">{{ __('messages.form.hits_per_page') }}</label>
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
            <button type="submit" class="btn btn-primary">{{ __('messages.form.search') }}</button>
        </form>

        <div class="search-results-section">
            <div class="search-results-wrapper">
                <h2>{{ __('messages.results.title') }}</h2>
                @if ($results->count() > 0)
                    <div class="search-results">
                        @foreach ($results as $result)
                            <div class="search-results-item">
                                <a href="{{ url('/record/' . $result->slug) }}">
                                    <h3>{{ $result->title }}</h3>
                                </a>
                                <div class="publication-data-wrapper">
                                    <div class="publication-data-row">
                                        <span class="publication-data-label">{{ __('messages.results.author') }}</span>
                                        <span class="publication-data-value">
                                            @foreach ($result->authors as $author)
                                                {{ $author->first_name }} {{ $author->last_name }}{{ !$loop->last ? ', ' : '' }}
                                            @endforeach
                                        </span>
                                    </div>
                                    <div class="publication-data-row">
                                        <span class="publication-data-label">{{ __('messages.results.date') }}</span>
                                        <span class="publication-data-value">
                                             @php
                                                 $date = new DateTime($result->publication_date);
                                                 $formattedDate = $date->format('d F Y');
                                             @endphp
                                            <span>{{ $formattedDate }}</span>
                                        </span>
                                    </div>
                                    <div class="publication-data-row">
                                        <span class="publication-data-label">{{ __('messages.results.document_type') }}</span>
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
                                            <span class="publication-data-label">{{ __('messages.results.publisher') }}</span>
                                            <span class="publication-data-value">
                                                {{ $result->publisher->name }}
                                        </span>
                                        </div>
                                    @endif
                                    @if ($result->hasKeywords())
                                        <div class="publication-data-row">
                                            <span class="publication-data-label">{{ __('messages.results.keywords') }}</span>
                                            <span class="publication-data-value">
                                                @foreach ($result->keywords as $keyword)
                                                    {{ $keyword->keyword }}{{ !$loop->last ? ', ' : '' }}
                                                @endforeach
                                            </span>
                                        </div>
                                    @endif
                                    @if ($result->file)
                                        <div class="publication-data-row">
                                            <span class="publication-data-label">{{ __('messages.results.file') }}</span>
                                            <span class="publication-data-value">
                                                <a href="{{ Storage::url($result->file) }}" class="preview-publication"
                                                   target="_blank">
                                                    {{ __('messages.results.preview_publication') }}
                                                </a>
                                            </span>
                                        </div>
                                    @endif
                                    <p>{{ $result->abstract }}</p>
                                    <div>
                                        <a href="{{ url('/record/' . $result->slug) }}">{{ __('messages.results.view_more') }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>{{ __('messages.results.no_results') }}</p>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.getElementById('advanced-search-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const originalForm = event.target;
            const newForm = document.createElement('form');
            newForm.action = originalForm.action;
            newForm.method = originalForm.method;

            Array.from(originalForm.elements).forEach(element => {
                if ((element.tagName === 'INPUT' && element.type === 'text' && element.value) ||
                    (element.tagName === 'SELECT' && element.name.startsWith('type') && element.nextElementSibling && element.nextElementSibling.value) ||
                    (element.tagName === 'INPUT' && element.type === 'month' && element.value) ||
                    (element.tagName === 'SELECT' && (element.name === 'hits_per_page' || element.name === 'document_type'))) {

                    const newElement = element.cloneNode(true);
                    newElement.value = element.value;
                    newForm.appendChild(newElement);

                    if (element.name.startsWith('type')) {
                        const newInput = element.nextElementSibling.cloneNode(true);
                        newInput.value = element.nextElementSibling.value;
                        newForm.appendChild(newInput);
                    }
                }
            });

            newForm.style.display = 'none';
            document.body.appendChild(newForm);
            console.log(newForm);
            newForm.submit();
        });
        function addFilter() {
            const filterContainer = document.getElementById('filters-container');
            const newFilter = document.createElement('div');
            newFilter.className = 'form-group filter-group d-flex align-items-center';
            newFilter.innerHTML = `
                <select name="type[]" class="form-control mr-2">
                    <option value="entire_document">{{ __('messages.filters.entire_document') }}</option>
                    <option value="title">{{ __('messages.filters.title') }}</option>
                    <option value="author">{{ __('messages.filters.author') }}</option>
                    <option value="abstract">{{ __('messages.filters.abstract') }}</option>
                    <option value="keyword">{{ __('messages.filters.keyword') }}</option>
                    <option value="publisher">{{ __('messages.filters.publisher') }}</option>
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
