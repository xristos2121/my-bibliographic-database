<x-front-layout>
    <x-list-entities :entities="$keywords" title="Keywords" urlPrefix="/browse/keywords" :titleFields="['keyword']" urlField="slug" :total="$totalKeywords" />
</x-front-layout>
