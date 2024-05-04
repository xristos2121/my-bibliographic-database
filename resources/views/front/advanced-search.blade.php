<x-front-layout>
    <div class="advanced-search-section">
            <h1>Advanced Publication Search</h1>
            <form action="{{ url('/advanced-search/results') }}" method="GET">
                <div class="form-group">
                    <select name="type[]">
                        <option value="entire_document" selected>Entire Document</option>
                        <option value="title">Title</option>
                        <option value="author">Author</option>
                        <option value="abstract">Abstract</option>
                        <option value="keyword">Keyword</option>
                        <option value="publisher">Publisher</option>
                    </select>
                    <input type="text" name="lookfor[]" class="form-control">
                </div>
                <div class="form-group">
                    <select name="type[]">
                        <option value="entire_document">Entire Document</option>
                        <option value="title" selected>Title</option>
                        <option value="author">Author</option>
                        <option value="abstract">Abstract</option>
                        <option value="keyword">Keyword</option>
                        <option value="publisher">Publisher</option>
                    </select>
                    <input type="text" id="abstract" name="lookfor[]" class="form-control">
                </div>
                <div class="form-group">
                    <select name="type[]">
                        <option value="entire_document">Entire Document</option>
                        <option value="title">Title</option>
                        <option value="author" selected>Author</option>
                        <option value="abstract">Abstract</option>
                        <option value="keyword">Keyword</option>
                        <option value="publisher">Publisher</option>
                    </select>
                    <input type="text" id="abstract" name="lookfor[]" class="form-control">
                </div>
                <div class="form-group">
                    <select name="type[]">
                        <option value="entire_document">Entire Document</option>
                        <option value="title">Title</option>
                        <option value="author">Author</option>
                        <option value="abstract" selected>Abstract</option>
                        <option value="keyword">Keyword</option>
                        <option value="publisher">Publisher</option>
                    </select>
                    <input type="text" id="abstract" name="lookfor[]" class="form-control">
                </div>
                <div class="form-group">
                    <select name="type[]">
                        <option value="entire_document">Entire Document</option>
                        <option value="title">Title</option>
                        <option value="author">Author</option>
                        <option value="abstract">Abstract</option>
                        <option value="keyword" selected>Keyword</option>
                        <option value="publisher">Publisher</option>
                    </select>
                    <input type="text" id="abstract" name="lookfor[]" class="form-control">
                </div>
                <div class="form-group">
                    <select name="type[]">
                        <option value="entire_document">Entire Document</option>
                        <option value="title">Title</option>
                        <option value="author">Author</option>
                        <option value="abstract">Abstract</option>
                        <option value="keyword">Keyword</option>
                        <option value="publisher" selected>Publisher</option>
                    </select>
                    <input type="text" id="abstract" name="lookfor[]" class="form-control">
                </div>
                <div class="form-group">
                   <label for="date">From</label>
                    <input type="month" id="monthYear" name="fromMonthYear" class="form-control">
                </div>
                <div class="form-group">
                    <label for="date">Until</label>
                    <input type="month" id="monthYear" name="untilMonthYear" class="form-control">
                </div>
                <div class="form-group">
                    <label for="date">Hits per page</label>
                    <select>
                        <option value="hits_10">10</option>
                        <option value="hits_20">20</option>
                        <option value="hits_50">50</option>
                        <option value="hits_100">100</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
    </div>
</x-front-layout>
