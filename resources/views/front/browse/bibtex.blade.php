<!DOCTYPE html>
<html>
<head>
    <title>BibTeX Format</title>
</head>
<body>
    <pre>
@php
    $type = strtolower(class_basename($result->types->name));
@endphp
        {{ '@article'  }}{{ '{' . $result->id . ',' }}
  title        = {{ '{' . $result->title . '}' }},
  author       = {{ '{' . $result->authors->map(fn($author) => $author->first_name . ' ' . $author->last_name)->implode(' and ') . '}' }},
  year         = {{ '{' . (new DateTime($result->publication_date))->format('Y') . '}' }},

            publisher    = {{ '{' . $result->publisher->name . '}' }},
        @if ($result->hasKeywords())
            keywords     = {{ '{' . $result->keywords->pluck('keyword')->implode(', ') . '}' }},
        @endif
        @if ($result->hasCollections())
            school  = {{ '{' . $result->collections->pluck('name')->implode(', ') . '}' }},
        @endif
        @if ($result->customFields->isNotEmpty())
            @foreach ($result->customFields as $customField)
                {{ $customField->definition->name }} = {{ '{' . $customField->value . '}' }},
            @endforeach
        @endif
            url          = {{ '{' . url('/record/' . $result->slug) . '}' }}
        {{ '}' }}
    </pre>
</body>
</html>
