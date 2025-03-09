<?php

class OrderView extends View
{
    public function showOrders($purchasesList)
    {
        ob_start();
        $count = count($purchasesList);
?>
        <input type="hidden" name="count" id="rows" value="<?= $count ?>">
        <h1 class="text-5xl font-bold text-center">Commandes</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>N° de commande</th>
                    <th>Date de commande</th>
                    <th>Montant total</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($purchasesList as $purchase) { ?>
                    <tr class="rows hover:bg-gray-500" id=<?= $purchase->getPurchaseId() ?>>
                        <td><?= $purchase->getPurchaseId() ?></td>
                        <td><?= $purchase->getPurchaseDate() ?></td>
                        <td><?= $purchase->getTotalAmount() ?> €</td>
                        <td><?= $purchase->getStatus() ?></td>
                    </tr>
                <?php } ?>
        </table>



    <?php
        $content = ob_get_clean();
        (new FrontPageView($content, 'Commandes', "Commandes", ['debug', 'order']))->show();
    }

    public function Order($purchaseId, $purchaseDate, $totalAmount, $status)
    {
        ob_start();
    ?>
        <h1 class="text-5xl font-bold text-center">Commande</h1>
        <div class="flex flex-col text-center items-center justify-center">
            <div>
                <p>N° de commande : <?= $purchaseId ?></p>
                <p>Date de commande : <?= $purchaseDate ?></p>
                <p>Montant total : <?= $totalAmount ?> €</p>
                <p>Statut : <?= $status ?></p>
            </div>
        </div>
    <?php
        $content = ob_get_clean();
        (new FrontPageView($content, 'Commande', "Commande", ['debug', 'order']))->show();
    }

    public function showOrderDetails($purchase, $purchaseDetails)
    {
        ob_start();
        var_dump($purchaseDetails);
    ?>
        <h1 class="text-5xl font-bold text-center bg-black">Commande</h1>
        <div class="flex flex-col text-center items-center justify-center">
            <div>
                <p>N° de commande : <?= $purchase->getPurchaseId() ?></p>
                <p>Date de commande : <?= $purchase->getPurchaseDate() ?></p>
                <p>Montant total : <?= $purchase->getTotalAmount() ?> €</p>
                <p>Statut : <?= $purchase->getStatus() ?></p>

            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($purchaseDetails as $product) { ?>
                        <tr class="rows hover:bg-gray-500" id="<?= $product['productId'] ?>">
                            <td><?= $product['product'] ?></td>
                            <td><?= $product['price'] ?> €</td>
                            <td><?= $product['quantity'] ?></td>
                            <td><?= $product['total'] ?> €</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
<?php
        $content = ob_get_clean();
        (new FrontPageView($content, 'Commande', "Commande", ['debug', 'orderDetails']))->show();
    }
}
