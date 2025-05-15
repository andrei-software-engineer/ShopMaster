@if(count($_socialMedia))
    @foreach($_socialMedia as $v)
        @include('BaseSite.SocialMedia.socialMediaItem', ['obj' => $v])
    @endforeach
@endif