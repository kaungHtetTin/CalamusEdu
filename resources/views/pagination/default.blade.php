@php
    // Check if elements are provided (for paginate) or build them manually
    if (isset($elements) && is_array($elements)) {
        // Use provided elements from Laravel
        $pageElements = $elements;
    } else {
        // Build elements manually for simplePaginate or when elements not provided
        $currentPage = $paginator->currentPage();
        $lastPage = method_exists($paginator, 'lastPage') ? $paginator->lastPage() : null;
        
        if ($lastPage && $lastPage > 1) {
            $onEachSide = 2;
            $start = max(1, $currentPage - $onEachSide);
            $end = min($lastPage, $currentPage + $onEachSide);
            
            $pages = [];
            if ($start > 1) {
                $pages[1] = $paginator->url(1);
                if ($start > 2) {
                    $pages['...'] = '...';
                }
            }
            for ($i = $start; $i <= $end; $i++) {
                $pages[$i] = $paginator->url($i);
            }
            if ($end < $lastPage) {
                if ($end < $lastPage - 1) {
                    $pages['...'] = '...';
                }
                $pages[$lastPage] = $paginator->url($lastPage);
            }
            $pageElements = [$pages];
        } else {
            $pageElements = [];
        }
    }
@endphp

@if ($paginator->hasPages())
    <nav class="custom-pagination" role="navigation" aria-label="Pagination Navigation">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">
                        <i class="fas fa-chevron-left"></i> Previous
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                        <i class="fas fa-chevron-left"></i> Previous
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @if (!empty($pageElements))
                @foreach ($pageElements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item disabled dots" aria-disabled="true">
                            <span class="page-link">{{ $element }}</span>
                        </li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page === '...')
                                <li class="page-item disabled dots" aria-disabled="true">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @elseif ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                        Next <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">
                        Next <i class="fas fa-chevron-right"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif

