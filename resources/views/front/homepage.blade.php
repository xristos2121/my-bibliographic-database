<x-front-layout>
    <div class="search-container">
        <form action="{{ url('/search') }}" method="GET">
            <input type="text" placeholder="Enter search terms..." name="search">
            <input type="submit" value="Search">
        </form>
    </div>
</x-front-layout>
