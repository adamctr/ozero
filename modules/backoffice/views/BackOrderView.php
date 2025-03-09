<?php

class BackOrderView extends View
{

    public function showAllOrders($purchasesList, $enumsStatus)
    {
        ob_start();
?>
        <h1 class="text-5xl font-bold text-center">Commandes</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>N° de commande</th>
                    <th>Date de commande</th>
                    <th>Montant total</th>
                    <th>Statut</th>
                </tr
                    </thead>
            <tbody>
                <?php foreach ($purchasesList as $purchase) { ?>
                    <tr class=" hover:bg-gray-500" id=<?= $purchase->getPurchaseId() ?>>
                        <td class="rows"><?= $purchase->getPurchaseId() ?></td>
                        <td class="rows"><?= $purchase->getPurchaseDate() ?></td>
                        <td class="rows"><?= $purchase->getTotalAmount() ?> €</td>
                        <td>
                            <select name="orderStatus" id="orderStatus_<?= $purchase->getPurchaseId() ?>">
                                <?php foreach ($enumsStatus as $status) {
                                    var_dump($status, $purchase->getStatus());
                                    if ($status == $purchase->getStatus()) { ?>
                                        <option value="<?= $status ?>" selected><?= $status ?></option>
                                    <?php
                                    } else {
                                    ?>
                                        <option value="<?= $status ?>"><?= $status ?></option>
                                        }
                                <?php }
                                } ?>
                            </select>
                            <?= $purchase->getStatus() ?>
                        </td>
                    </tr>
                <?php } ?>
        </table>
<?php
        $content = ob_get_clean();
        (new BackOfficePageView($content, 'Commandes', "Commandes", ['debug', 'order']))->show();
    }
}
