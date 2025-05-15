<section class="container home-info">
    @if($obj)
        <h2>{{$obj->_name}}</h2>
        <?= $obj->_description?>
    @endif
</section>