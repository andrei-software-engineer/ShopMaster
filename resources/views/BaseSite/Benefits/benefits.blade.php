<div class="content bennefits">
    <h3>{{_GL('Our advantages')}}</h3>
    <div class="row">
        @if(($objs))
            @foreach($objs as $item)
                <div class="col-sm-6">
                    @include('BaseSite.Benefits.benefitsItem', ['obj' => $item])
                </div>
            @endforeach
        @endif
    </div>
</div>
