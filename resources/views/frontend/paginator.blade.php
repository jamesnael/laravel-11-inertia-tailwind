@if ($paginator->lastPage() > 1)
    <nav aria-label="Page navigation example">
        <ul class="pagination gap-3 justify-content-center mt-5">
            <li class="page-item page-arrow me-5 {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
                <a class="page-link" href="{{ $paginator->url($paginator->currentPage()-1) }}" aria-label="Previous">
                    <i class="ico ico-prev">
                        <svg width="32" height="32" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.6 10h-15m9.9-5.5L17 10l-5.5 5.5" stroke="{{($paginator->currentPage() == 1) ? 'white' : '#EF6C4F'}}" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </i>
                </a>
            </li>
            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                <li class="page-item {{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                    <a class="page-link nav-link-custom" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            <li class="page-item page-arrow ms-5 {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
                <a class="page-link" href="{{ $paginator->url($paginator->currentPage()+1) }}" aria-label="Next">
                    <i class="ico ico-next">
                        <svg width="32" height="32" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.6 10h-15m9.9-5.5L17 10l-5.5 5.5" stroke="{{($paginator->currentPage() == $paginator->lastPage()) ? 'white' : '#EF6C4F'}}" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </i>
                </a>
            </li>
        </ul>
    </nav>
@endif