<x-front-layout>
    <div class="advanced-search-section">
        <div class="container">
            <h1>Advanced Publication Search</h1>
            <form action="{{ url('/search/results') }}" method="GET">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Search by title">
                </div>
                <div class="form-group">
                    <label for="abstract">Abstract:</label>
                    <input type="text" id="abstract" name="abstract" class="form-control" placeholder="Search by abstract">
                </div>
                <div class="form-group">
                    <label for="publication_date">Publication Date:</label>
                    <input type="date" id="publication_date" name="publication_date" class="form-control">
                </div>
                <div class="form-group">
                    <label for="keywords">Keywords:</label>
                    <select id="keywords" name="keyword_id" class="form-control">
                        <!-- Your options here -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="authors">Authors:</label>
                    <select id="authors" multiple name="author_ids[]" class="form-control">
                        <!-- Your options here -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="categories">Categories:</label>
                    <select id="categories" name="category_ids[]" class="form-control">
                        <!-- Your options here -->
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>
</x-front-layout>
