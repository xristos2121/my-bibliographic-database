<x-front-layout>
    <x-list-entities :entities="$publishers" title="Publishers" urlPrefix="/browse/publishers" :titleFields="['name']" urlField="id" :total="$totalPublishers" />
</x-front-layout>
