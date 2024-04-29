<x-front-layout>
    <div class="advanced-search-section">
            <h1>Advanced Publication Search</h1>
            <form action="{{ url('/search/results') }}" method="GET">
                <div class="form-group">
                    <select>
                        <option value="contains">Contains</option>
                        <option value="starts_with">Starts with</option>
                        <option value="ends_with">Ends with</option>
                    </select>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Search by title">
                </div>
                <div class="form-group">
                    <select>
                        <option value="contains">Contains</option>
                        <option value="starts_with">Starts with</option>
                        <option value="ends_with">Ends with</option>
                    </select>
                    <input type="text" id="abstract" name="abstract" class="form-control" placeholder="Search by abstract">
                </div>
                <div class="form-group">
                    <select>
                        <option value="contains">Contains</option>
                        <option value="starts_with">Starts with</option>
                        <option value="ends_with">Ends with</option>
                    </select>
                    <input type="text" id="abstract" name="abstract" class="form-control" placeholder="Search by abstract">
                </div>
                <div class="form-group">
                    <select>
                        <option value="contains">Contains</option>
                        <option value="starts_with">Starts with</option>
                        <option value="ends_with">Ends with</option>
                    </select>
                    <input type="text" id="abstract" name="abstract" class="form-control" placeholder="Search by abstract">
                </div>
                <div class="form-group">
                    <select>
                        <option value="contains">Contains</option>
                        <option value="starts_with">Starts with</option>
                        <option value="ends_with">Ends with</option>
                    </select>
                    <input type="text" id="abstract" name="abstract" class="form-control" placeholder="Search by abstract">
                </div>
                <div class="form-group">
                    <select>
                        <option value="contains">Contains</option>
                        <option value="starts_with">Starts with</option>
                        <option value="ends_with">Ends with</option>
                    </select>
                    <input type="text" id="abstract" name="abstract" class="form-control" placeholder="Search by abstract">
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
    </div>
</x-front-layout>
