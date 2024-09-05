<x-front-layout>
    <div class="container">
        <div class="generic-container-border">
            <h1>{{ $result->title }}</h1>
            <div class="record-details">
                <div class="record-section">
                    <h2>{{ __('messages.record.details') }}</h2>
                    <div class="record-data-wrapper">
                        <div class="record-data-row">
                            <span class="record-data-label">{{ __('messages.results.author') }}</span>
                            <span class="record-data-value">
                                @foreach ($result->authors as $author)
                                    {{ $author->first_name }} {{ $author->last_name }}{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </span>
                        </div>
                        <div class="record-data-row">
                            <span class="record-data-label">{{ __('messages.results.date') }}</span>
                            <span class="record-data-value">
                                @php
                                    $date = new DateTime($result->publication_date);
                                    $formattedDate = $date->format('d F Y');
                                @endphp
                                <span>{{ $formattedDate }}</span>
                            </span>
                        </div>
                        <div class="record-data-row">
                            <span class="record-data-label">{{ __('messages.results.document_type') }}</span>
                            <span class="record-data-value">
                                @if($result->types)
                                    <span>{{ $result->types->name }}</span>
                                @else
                                    <span>N/A</span>
                                @endif
                            </span>
                        </div>
                        @if ($result->hasPublisher())
                            <div class="record-data-row">
                                <span class="record-data-label">{{ __('messages.results.publisher') }}</span>
                                <span class="record-data-value">
                                    {{ $result->publisher->name }}
                                </span>
                            </div>
                        @endif
                        @if ($result->hasKeywords())
                            <div class="record-data-row">
                                <span class="record-data-label">{{ __('messages.results.keywords') }}</span>
                                <span class="record-data-value">
                                    @foreach ($result->keywords as $keyword)
                                        {{ $keyword->keyword }}{{ !$loop->last ? ', ' : '' }}
                                    @endforeach
                                </span>
                            </div>
                        @endif
                        @if ($result->hasCollections())
                            <div class="record-data-row">
                                <span class="record-data-label">{{ __('messages.record.categories') }}</span>
                                <span class="record-data-value">
                                    @foreach ($result->collections as $collection)
                                        {{ $collection->name }}{{ !$loop->last ? ', ' : '' }}
                                    @endforeach
                                </span>
                            </div>
                        @endif
                        @if ($result->customFields->isNotEmpty())
                            @foreach ($result->customFields as $customField)
                                <div class="record-data-row">
                                    <span class="record-data-label">{{ $customField->definition->name }}</span>
                                    <span class="record-data-value">{{ $customField->value }}</span>
                                </div>
                            @endforeach
                        @endif
                        @if ($result->file || $result->link)
                            <div class="record-data-row">
                                <span class="record-data-label">{{ __('messages.results.related_files') }}</span>
                                <span class="record-data-value">
                                    @if ($result->file)
                                        <a href="{{ Storage::url($result->file) }}" class="preview-publication" target="_blank">
                                            {{ __('messages.results.preview_publication') }}
                                        </a>
                                    @endif
                                    @if ($result->file && $result->link)
                                        <span> | </span>
                                    @endif
                                    @if ($result->link)
                                        <a href="{{ $result->link }}" class="preview-publication" target="_blank">
                                            {{ __('messages.results.preview_publication') }}
                                        </a>
                                    @endif
                                </span>
                            </div>
                        @endif
                        @if ($result->uris->isNotEmpty())
                            <div class="record-data-row">
                                <span class="record-data-label">URI</span>
                                <span class="record-data-value">
                                    @foreach ($result->uris as $uri)
                                        <a href="{{ $uri->uri }}" class="preview-publication" target="_blank">
                                            {{ __('messages.results.preview') }}
                                        </a>
                                        @if(!$loop->last)
                                            <span>, </span>
                                        @endif
                                    @endforeach
                                </span>
                            </div>
                        @endif
                        <div class="record-data-row">
                            <span class="record-data-label">{{ __('messages.results.bibtex') }}</span>
                            <span class="record-data-value">
                                 <a href="javascript:void(0);" onclick="openBibtexWindow('{{ route('record.bibtex', $result->slug) }}')">
                                    View in BibTeX Format
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="record-abstract">
                    <h2>{{ __('messages.record.abstract') }}</h2>
                    <p>{{ $result->abstract }}</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openBibtexWindow(url) {
            window.open(url, 'BibTeX', 'width=800,height=600,resizable,scrollbars');
        }
    </script>
</x-front-layout>
