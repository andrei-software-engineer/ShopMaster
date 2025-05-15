<div class="content" >
    @if ($order)
        <div class="row">

            <?= $orderTable ?>

            <?= $orderDetailsTable ?> 

        </div> 

        <?= $orderProductsTable ?>

        <?= $orderJournalTable ?>


        <?= $orderMessageTable  ?> 

    @endif 
</div> 
