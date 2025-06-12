<header class="header">
    <div class="header-desktop">
        <div class="header-first">
            <div class="header-container">
                <div class="row align-items-center">
                    <div class="col-5">
                        <div class="d-flex align-items-center gap-3">
                            <div>
                                <a href="{{route('frontend.home.index')}}"><img src="{{ asset('frontend/images/rkcmpd-logo.svg') }}" alt=""></a>
                            </div>
                            <div class="vr"></div>
                            <div>
                                <img src="{{asset('frontend/images/ERIA-HD.svg')}}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-7">
                        <ul class="nav justify-content-end align-items-center">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle header-menu" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    About
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item header-submenu" href="{{ route('frontend.about-us') }}">About Us</a></li>
                                    <li><a class="dropdown-item header-submenu" href="{{ route('frontend.about-the-platform') }}">About The Platform</a></li>
                                    <li><a class="dropdown-item header-submenu" href="{{ route('frontend.our-projects') }}">Our Projects</a></li>
                                    <li><a class="dropdown-item header-submenu" href="{{ route('frontend.our-team') }}">Our Teams</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link header-menu" href="{{ route('frontend.news') }}">News</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link header-menu" href="{{ route('frontend.events') }}">Events</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link header-menu" href="{{ route('frontend.contact-us') }}">Contact</a>
                            </li>
                            <li class="nav-item" style="width: 12%;">
                                {{-- <a class="nav-link pe-0 nav-link-search search-page-input" href="#" style="color:#A6A6A6;font-weight:600;font-size:14px;line-height:16.8px">
                                    <svg style="margin-right: 6px" width="18" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.942 15.557l-3.912-3.91a6.884 6.884 0 1 0-.883.883l3.91 3.912a.626.626 0 0 0 .885-.885zM2.125 7.25a5.625 5.625 0 1 1 5.625 5.625A5.631 5.631 0 0 1 2.125 7.25z" fill="#A6A6A6"/></svg>
                                    Search
                                </a> --}}

                                <div class="input-inline">
                                    <i class="ico ico-search"></i>
                                    <input type="text" class="form-control nav-link pe-0 nav-link-search search-page-input" placeholder="Search" class="searchbar">
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-second">
            <div class="header-container">
                <ul class="nav align-items-center">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle ps-0 header-custom" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Government Actions
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('frontend.laws-regulation') }}">Laws & Regulations</a></li>
                            <li><a class="dropdown-item dropdown-item-spacing" href="{{ route('frontend.international-agreements') }}">International Agreements</a></li>
                            <li><a class="dropdown-item dropdown-item-spacing" href="{{ route('frontend.practical-measures')}}">Practical Measures</a></li>
                            <li><a class="dropdown-item dropdown-item-spacing" href="{{ route('frontend.extended-producer-responsibility') }}">EPR</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle header-custom" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Non-Government Actors
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('frontend.non-gov-actors') }}">Actors</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle header-custom" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Private Sector
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('frontend.private-sector-platform') }}">Private Sector Platform</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle header-custom" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Scientific Information
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('frontend.plastic-waste-and-mangrove') }}">Plastic & Mangrove</a></li>
                            <li><a class="dropdown-item" href="{{ route('frontend.assessment-methods') }}">Assessment Methods</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle header-custom" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Knowledge Products
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('frontend.reports-publications') }}">Reports & Publications</a></li>
                            <li><a class="dropdown-item dropdown-item-spacing" href="{{ route('frontend.zero-in-on-plastic') }}">Zero-in On Plastic</a></li>
                            <li><a class="dropdown-item dropdown-item-spacing" href="{{ route('frontend.multimedia') }}">Multimedia</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Mobile Header --}}
    <div class="header-mobile">
        <div class="row align-items-center">
            <div class="col-7">
                <div class="d-flex align-items-center gap-2">
                    <div>
                        <a href="{{ route('frontend.home.index') }}"><img src="{{asset('frontend/images/rkcmpd-logo.svg')}}" width="113" alt=""></a>
                    </div>
                    <div class="vr"></div>
                    <div>
                        <a href="{{ route('frontend.home.index') }}">
                            <img src="{{asset('frontend/images/ERIA-HD.svg')}}" width="40" alt="">
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-5">
                <div class="nav align-items-center justify-content-end">
                    {{-- <a href="#" class="nav-link px-1"><i class="ico ico-search"></i></a> --}}
                    <div class="d-inline" style="width: 60%;">
                        <form action="#" class="m-0 p-0 form-search-page">
                            <div class="d-flex align-items-center gap-0">
                                <i class="ico ico-search"></i>
                                <input type="text" class="form-control nav-link ps-1 pe-0 nav-link-search page-search" placeholder="Search">
                            </div>
                        </form>
                    </div>
                    <a href="#" class="nav-link ps-2 menu-mobile pe-0">
                        <i class="ico icon-humnurger ico-menu"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="menu-popup">
            <ul class="nav main-mobile-menu" style="margin-top: 44px">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Government Actions
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('frontend.laws-regulation') }}">Laws & Regulations</a></li>
                        <li><a class="dropdown-item" href="{{ route('frontend.international-agreements') }}">International Agreements</a></li>
                        <li><a class="dropdown-item" href="{{ route('frontend.practical-measures')}}">Practical Measures</a></li>
                        <li><a class="dropdown-item" href="{{ route('frontend.extended-producer-responsibility') }}">EPR</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Non-Government Actors
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('frontend.non-gov-actors') }}">Actors</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Private Sector
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('frontend.private-sector-platform') }}">Private Sector Platform</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Scientific Information
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('frontend.plastic-waste-and-mangrove') }}">Plastic & Mangrove</a></li>
                        <li><a class="dropdown-item" href="{{ route('frontend.assessment-methods') }}">Assessment Methods</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Knowledge Products
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('frontend.reports-publications') }}">Reports & Publications</a></li>
                        <li><a class="dropdown-item" href="{{ route('frontend.zero-in-on-plastic') }}">Zero-in On Plastic</a></li>
                        <li><a class="dropdown-item" href="{{ route('frontend.multimedia') }}">Multimedia</a></li>
                    </ul>
                </li>
            </ul>

            <hr>

            <ul class="nav secondary-mobile-menu">
                <li class="nav-item dropdown">
                    <a class="nav-link header-menu dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        About
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item header-submenu" href="{{ route('frontend.about-us') }}">About Us</a></li>
                        <li><a class="dropdown-item header-submenu" href="{{ route('frontend.about-the-platform') }}">About The Platform</a></li>
                        <li><a class="dropdown-item header-submenu" href="{{ route('frontend.our-projects') }}">Our Projects</a></li>
                        <li><a class="dropdown-item header-submenu" href="{{ route('frontend.our-team') }}">Our Teams</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link header-menu" href="{{ route('frontend.news') }}">News</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link header-menu" href="{{ route('frontend.events') }}">Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link header-menu" href="{{ route('frontend.contact-us') }}">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</header>