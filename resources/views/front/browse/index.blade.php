<x-front-layout>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="generic-container-border side-navigation-wrapper">
                    <h3 class="side-navigation-title">Browse</h3>
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
                        <div class="browse-results-wrapper">
                            <span class="browse-results-title">Results</span>
                            <p><b>Total results found: 10</b></p>
                            <div class="browse-results">
                                <div class="browse-results-item">
                                    <a href="#">
                                        <h1>Dummy Title 1</h1>
                                    </a>
                                    <div class="publication-data-wrapper">
                                        <div class="publication-data-row">
                                            <span class="publication-data-label">Author</span>
                                            <span class="publication-data-value">Author 1</span>
                                        </div>
                                        <div class="publication-data-row">
                                            <span class="publication-data-label">Date</span>
                                            <span class="publication-data-value">2023-07-01</span>
                                        </div>
                                        <div class="publication-data-row">
                                            <span class="publication-data-label">Document Type</span>
                                            <span class="publication-data-value">Type 1</span>
                                        </div>
                                        <div class="publication-data-row">
                                            <span class="publication-data-label">Publisher</span>
                                            <span class="publication-data-value">Publisher 1</span>
                                        </div>
                                        <div class="publication-data-row">
                                            <span class="publication-data-label">Keywords</span>
                                            <span class="publication-data-value">Keyword1, Keyword2</span>
                                        </div>
                                        <div class="publication-data-row">
                                            <span class="publication-data-label">File</span>
                                            <span class="publication-data-value">
                                                <a href="#" class="preview-publication" target="_blank">Preview Publication</a>
                                            </span>
                                        </div>
                                        <p class="abstract">This is a dummy abstract for the first dummy title.</p>
                                        <div>
                                            <a href="#">View More</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="browse-results-item">
                                    <a href="#">
                                        <h1>Dummy Title 2</h1>
                                    </a>
                                    <div class="publication-data-wrapper">
                                        <div class="publication-data-row">
                                            <span class="publication-data-label">Author</span>
                                            <span class="publication-data-value">Author 2</span>
                                        </div>
                                        <div class="publication-data-row">
                                            <span class="publication-data-label">Date</span>
                                            <span class="publication-data-value">2023-06-01</span>
                                        </div>
                                        <div class="publication-data-row">
                                            <span class="publication-data-label">Document Type</span>
                                            <span class="publication-data-value">Type 2</span>
                                        </div>
                                        <div class="publication-data-row">
                                            <span class="publication-data-label">Publisher</span>
                                            <span class="publication-data-value">Publisher 2</span>
                                        </div>
                                        <div class="publication-data-row">
                                            <span class="publication-data-label">Keywords</span>
                                            <span class="publication-data-value">Keyword3, Keyword4</span>
                                        </div>
                                        <div class="publication-data-row">
                                            <span class="publication-data-label">File</span>
                                            <span class="publication-data-value">
                                                <a href="#" class="preview-publication" target="_blank">Preview Publication</a>
                                            </span>
                                        </div>
                                        <p class="abstract">This is a dummy abstract for the second dummy title.</p>
                                        <div>
                                            <a href="#">View More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Pagination links -->
                            <nav>
                                <ul class="pagination">
                                    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-front-layout>
