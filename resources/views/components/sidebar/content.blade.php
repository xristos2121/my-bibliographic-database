<x-perfect-scrollbar
    as="nav"
    aria-label="main"
    class="flex flex-col flex-1 gap-4 px-3"
>

    <x-sidebar.link
        title="Dashboard"
        href="{{ route('dashboard') }}"
        :isActive="request()->routeIs('dashboard')"
    >
        <x-slot name="icon">
            <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>



    <x-sidebar.link title="Keywords" href="{{ route('keywords.index') }}"  :isActive="request()->routeIs('keywords.*')"/>
    <x-sidebar.link title="Categories" href="{{ route('categories.index') }}"  :isActive="request()->routeIs('categories.*')"/>
    <x-sidebar.link title="Publications" href="{{ route('publications.index') }}"  :isActive="request()->routeIs('publications.*')"/>
    <x-sidebar.link title="Publications Types" href="{{ route('publications_types.index') }}"  :isActive="request()->routeIs('publications_types.*')"/>
    <x-sidebar.link title="Custom Fields" href="{{ route('custom_fields.index') }}"  :isActive="request()->routeIs('custom_fields.*')"/>
    <x-sidebar.link title="Authors" href="{{ route('author.index') }}"  :isActive="request()->routeIs('author.*')"/>
    <x-sidebar.link title="Publisher" href="{{ route('publisher.index') }}"  :isActive="request()->routeIs('publisher.*')"/>
</x-perfect-scrollbar>
