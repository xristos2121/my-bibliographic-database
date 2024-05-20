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
                <input type="text" name="lookfor" class="form-control" style="flex: 1; border: none; outline: none;">
            </div>
                <div class="search-button">
                    <button type="submit" style="background: none; border: none; padding: 0 10px; cursor: pointer;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-front-layout>
