<div class="">
    @if ($data['order'])

    <div class="row">
        <div class="col-sm-9">
            <div class="layout">
                <div class="row">
                    <div class="col-sm-6">
                        <h5>{{ _GL('Order') }}</h5>
                        <?= $data['orderTable'] ?>
                    </div>
                    <div class="col-sm-6">
                        <h5>{{ _GL('Detail Order') }}</h5>
                        <?= $data['orderDetailsTable'] ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
        </div>
    </div>

        <?= $data['orderProductsTable'] ?>

        <?= $data['orderJournalTable'] ?>

        <?= $data['orderMessageTable'] ?> 

    @endif
</div>