<?php

class BasketView extends View
{
    public function show()
    {
        ob_start();
?>
        <h1 class="text-5xl font-bold text-center">Panier</h1>
        <form action="/panier/checkoutsession" method="get">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Produit</th>
                            <th>Prix</th>
                            <th>Quantité</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($_SESSION['cart'] as $cart) { ?>
                            <tr>
                                <th>
                                    <label>
                                        <?= $cart['image'] ?>
                                        <input type="hidden" name="product" value=<?= $cart['image'] ?>>
                                    </label>
                                </th>
                                <th>
                                    <label>
                                        <?= $cart['product'] ?>
                                        <input type="hidden" name="product" value=<?= $cart['product'] ?>>
                                    </label>
                                </th>
                                <th>
                                    <label>
                                        <?= $cart['price'] ?> €
                                        <input type="hidden" name="price" value=<?= $cart['price'] ?>>
                                    </label>
                                </th>
                                <th>
                                    <label>
                                        <div class="flex">
                                            <img src="/assets/png/plus.png" width="20" height="15" alt="ajouter un produit">
                                            <?= $cart['quantity'] ?>
                                            <input type="hidden" name="quantity" value=<?= $cart['quantity'] ?>>
                                            <img src="/assets/png/moins.png" width="20" height="15" alt="retirer un produit">
                                        </div>
                                    </label>
                                </th>
                            </tr>
                        <?php } ?>
                </table>
            </div>
            <div class="text-center">
                <button type="submit" class="my-5 btn btn-accent">Commander</button>
            </div>
        </form>
        </div>
<?php
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'Panier', "Votre panier", ['debug']))->show();
    }
}
