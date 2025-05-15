
    @if ($data['order'])

    <div class="row">
        <div class="col-sm-9">
            <div class="layout">
                <div class="d-flex justify-content-end">                    

                        <a href="{{ route('platform.order.edit', ['id' => $data['order']->id, 'backUrl' => $data['backUrl']]) }}">
                            <button class="btn btn-default me-2" type="submit"><x-orchid-icon path="pencil" class="me-2"/>{{ _GL('Edit') }}</button>
                        </a>

                        <a href="{{ route('web.printOrderDetailsPDF', ['id' => $data['order']->id]) }}">
                            <button class="btn btn-default" type="button">
                            <x-orchid-icon path="printer" class="me-2"/>{{ _GL('Print') }}</button>
                        </a>

                </div>
                
                <div class="row">
                    <div class="col-sm-6">
                        <h5>{{ _GL('Order') }}</h5>
                        <hr>
                        <?= $data['orderTable'] ?>
                    </div>
                    <div class="col-sm-6">
                        <h5>{{ _GL('Detail Order') }}</h5>
                        <hr>
                        <?= $data['orderDetailsTable'] ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <?= $data['orderActionsTable'] ?>
        </div>
    </div>
    
    <div class="layout"><?= $data['orderProductsTable'] ?></div>
    
    <div class="layout"><?= $data['orderJournalTable'] ?></div>

    <div class="layout"><?= $data['orderMessageTable'] ?> </div>

    @endif
