<div class="share-btn">
    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ url()->current() }}" target="_blank">
        <img src="{{ asset('frontend/images/icons/in.svg') }}" alt="LinkedIn">
    </a>
    <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}" target="_blank">
        <img src="{{ asset('frontend/images/icons/x.svg') }}" alt="X">
    </a>
    <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank">
        <img src="{{ asset('frontend/images/icons/facebook.svg') }}" alt="Facebook">
    </a>
    <a href="{{ url()->current() }}" class="copy-link">
        <img src="{{ asset('frontend/images/icons/link-alt.svg') }}" alt="Copy">
    </a>
</div>