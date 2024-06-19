<x-front-layout>
    <div class="advanced-search-section">
        <h1>Advanced Publication Search</h1>
        <form id="advanced-search-form" action="{{ url('/advanced-search/results') }}" method="GET">
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
                <input type="text" name="lookfor[]" class="form-control">
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
                <input type="text" name="lookfor[]" class="form-control">
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
                <input type="text" name="lookfor[]" class="form-control">
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
                <input type="text" name="lookfor[]" class="form-control">
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
                <input type="text" name="lookfor[]" class="form-control">
            </div>
            <div class="form-group">
                <label for="date">{{__('messages.search.type')}}</label>
                <select name="document_type" class="form-control">
                    <option value="all">{{__('messages.search.all')}}</option> <!-- Add the 'All' option -->
                    @foreach($types as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="fromYear">From</label>
                <input type="text" name="fromYear" id="fromYear" class="form-control">
            </div>
            <div class="form-group">
                <label for="toYear">Until</label>
                <input type="text" name="untilYear" id="untilYear" class="form-control">
            </div>

            <div class="form-group">
                <label for="date">Hits per page</label>
                <select name="hits_per_page" class="form-control">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Search</button>
        </form>
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
                    (element.tagName === 'SELECT' && element.name.startsWith('type') && element.nextElementSibling.value) ||
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
            newForm.submit();
        });
    </script>
</x-front-layout>
