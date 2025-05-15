@if ($obj)
    <div>
        <p>{{ $obj->_name }} </p>
        <p>{{ $obj->_author }}</p>
        <p>{{ $obj->_title }}</p>
        <?= $obj->_description ?>
    </div>

    @include('BaseSite.Faq.faqResponses', ['objects' => $obj->_childrens, 'obj' => $obj])
    <HR>
@endif