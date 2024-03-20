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

    <x-sidebar.dropdown
        title="Buttons"
        :active="Str::startsWith(request()->route()->uri(), 'buttons')"
    >
        <x-slot name="icon">
            <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>

        <x-sidebar.sublink
            title="Text button"
            href="{{ route('buttons.text') }}"
            :active="request()->routeIs('buttons.text')"
        />
        <x-sidebar.sublink
            title="Icon button"
            href="{{ route('buttons.icon') }}"
            :active="request()->routeIs('buttons.icon')"
        />
        <x-sidebar.sublink
            title="Text with icon"
            href="{{ route('buttons.text-icon') }}"
            :active="request()->routeIs('buttons.text-icon')"
        />
    </x-sidebar.dropdown>

    <div
        x-transition
        x-show="isSidebarOpen || isSidebarHovered"
        class="text-sm text-gray-500"
    >
        Dummy Links
    </div>
    <x-sidebar.link title="Keywords" href="{{ route('keywords.index') }}"  :isActive="request()->routeIs('keywords.*')"/>
    <x-sidebar.link title="Categories" href="{{ route('category.index') }}"  :isActive="request()->routeIs('categories.*')"/>
    <x-sidebar.link title="Publications" href="{{ route('publications.index') }}"  :isActive="request()->routeIs('publications.*')"/>
    <x-sidebar.link title="Publications Types" href="{{ route('publications_types.index') }}"  :isActive="request()->routeIs('publications_types.*')"/>
    <x-sidebar.link title="Tags" href="{{ route('tags.index') }}"  :isActive="request()->routeIs('tags.*')"/>
    <x-sidebar.link title="Authors" href="{{ route('author.index') }}"  :isActive="request()->routeIs('author.*')"/>
</x-perfect-scrollbar>
