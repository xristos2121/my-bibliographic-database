<x-front-layout>
    <div class="container">
        <div class="generic-container-border search-results-main-wrapper">
            <div class="advanced-search-section-wrapper">
                <span class="advanced-search-section-title">{{ __('messages.advanced_search.title') }}</span>
                <form id="advanced-search-form" action="{{ url('/advanced-search/results') }}" method="GET" class="col-lg-8">
                    <div id="filters-container">
                        @if(isset($searchParameters['type']) && isset($searchParameters['lookfor']))
                            @foreach($searchParameters['type'] as $index => $type)
                                <div class="form-group filter-group d-flex align-items-center">
                                    <select name="type[]" class="mr-2">
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
                                        <option value="context" {{ $type === 'context' ? 'selected' : '' }}>
                                            {{ __('messages.filters.context') }}
                                        </option>
                                    </select>
                                    <input type="text" name="lookfor[]" class="form-control mr-2" value="{{ $searchParameters['lookfor'][$index] ?? '' }}">
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
                        @else
                            <div class="form-group filter-group d-flex align-items-center">
                                <select name="type[]" class="mr-2">
                                    <option value="entire_document">
                                        {{ __('messages.filters.entire_document') }}
                                    </option>
                                    <option value="title">
                                        {{ __('messages.filters.title') }}
                                    </option>
                                    <option value="author">
                                        {{ __('messages.filters.author') }}
                                    </option>
                                    <option value="abstract">
                                        {{ __('messages.filters.abstract') }}
                                    </option>
                                    <option value="keyword">
                                        {{ __('messages.filters.keyword') }}
                                    </option>
                                    <option value="publisher">
                                        {{ __('messages.filters.publisher') }}
                                    </option>
                                    <option value="context">
                                        {{ __('messages.filters.context') }}
                                    </option>
                                </select>
                                <input type="text" name="lookfor[]" class="mr-2" value="">
                            </div>
                        @endif
                    </div>

                    <button type="button" class="addFilterBtn" onclick="addFilter()">{{ __('messages.filters.add') }}</button>
                    <div class="search-results-options-section">
                        <div class="form-group">
                            <label for="document_type">{{ __('messages.search.type') }}</label>
                            <select name="document_type">
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
                            <label for="fromYear">{{ __('messages.form.from') }}</label>
                            <input type="text" id="fromYear" name="fromYear" value="{{ $searchParameters['fromYear'] ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label for="untilYear">{{ __('messages.form.until') }}</label>
                            <input type="text" id="untilYear" name="untilYear" value="{{ $searchParameters['untilYear'] ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label for="hits_per_page">{{ __('messages.form.hits_per_page') }}</label>
                            <select name="hits_per_page">
                                <option value="10" {{ ($searchParameters['hits_per_page'] ?? '') == '10' ? 'selected' : '' }}>10</option>
                                <option value="20" {{ ($searchParameters['hits_per_page'] ?? '') == '20' ? 'selected' : '' }}>20</option>
                                <option value="50" {{ ($searchParameters['hits_per_page'] ?? '') == '50' ? 'selected' : '' }}>50</option>
                                <option value="100" {{ ($searchParameters['hits_per_page'] ?? '') == '100' ? 'selected' : '' }}>100</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('messages.form.search') }}</button>
                </form>
            </div>

            <div class="search-results-section">
                <div class="search-results-wrapper">
                    <span class="search-results-title">{{ __('messages.results.title') }}</span>
                    <x-publications :results="$results"/>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addFilter() {
            const filterContainer = document.getElementById('filters-container');
            const newFilter = document.createElement('div');
            newFilter.className = 'form-group filter-group d-flex align-items-center';
            newFilter.innerHTML = `
                <select name="type[]" class="mr-2">
                    <option value="entire_document">{{ __('messages.filters.entire_document') }}</option>
                    <option value="title">{{ __('messages.filters.title') }}</option>
                    <option value="author">{{ __('messages.filters.author') }}</option>
                    <option value="abstract">{{ __('messages.filters.abstract') }}</option>
                    <option value="keyword">{{ __('messages.filters.keyword') }}</option>
                    <option value="publisher">{{ __('messages.filters.publisher') }}</option>
                    <option value="context">{{ __('messages.filters.context') }}</option>
                </select>
                <input type="text" name="lookfor[]" class="form-control mr-2">
                <div onclick="removeFilter(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="20" height="20" viewBox="0 0 256 256" xml:space="preserve">
                        <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                            <path d="M 11 90 c -2.815 0 -5.63 -1.074 -7.778 -3.222 c -4.295 -4.296 -4.295 -11.261 0 -15.557 l 68 -68 c 4.297 -4.296 11.26 -4.296 15.557 0 c 4.296 4.296 4.296 11.261 0 15.557 l -68 68 C 16.63 88.926 13.815 90 11 90 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(214,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                            <path d="M 79 90 c -2.815 0 -5.63 -1.074 -7.778 -3.222 l -68 -68 c -4.295 -4.296 -4.295 -11.261 0 -15.557 c 4.296 -4.296 11.261 -4.296 15.557 0 l 68 68 c 4.296 4.296 4.296 11.261 0 15.557 C 84.63 88.926 81.815 90 79 90 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(214,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
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
