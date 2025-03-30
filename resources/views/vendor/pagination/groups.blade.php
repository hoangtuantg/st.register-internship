@if ($paginator->hasPages('groupsPage'))
    <ul class="pagination pagination-flat d-flex justify-content-center">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage('groupsPage'))
            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <span class="rounded page-link" aria-hidden="true">&lsaquo;</span>
            </li>
        @else
            <li class="page-item">
                <a class="rounded page-link" href="javascript:void(0)" wire:click="previousPage('groupsPage')" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled" aria-disabled="true"><span class="rounded page-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage('groupsPage'))
                        <li class="page-item active" aria-current="page"><span class="rounded page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="rounded page-link" href="javascript:void(0)" wire:click="gotoPage({{ $page }}, 'groupsPage')">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages('groupsPage'))
            <li class="page-item">
                <a class="rounded page-link" href="javascript:void(0)" wire:click="nextPage('groupsPage')" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
            </li>
        @else
            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                <span class="rounded page-link" aria-hidden="true">&rsaquo;</span>
            </li>
        @endif
    </ul>
@endif
<?php
