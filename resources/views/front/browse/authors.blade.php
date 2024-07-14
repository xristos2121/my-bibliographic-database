<x-front-layout>
    <x-list-entities :entities="$authors" title="Authors" urlPrefix="/browse/authors" :titleFields="['first_name', 'last_name']" urlField="id" :total="$totalAuthors" />
</x-front-layout>
