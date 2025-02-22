<?php

class TestAddBasketView extends View
{
    public function show()
    {
?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Test d'ajout au panier</h1>
                    <form id="add-basket-form" method="post" action="/panier/add">
                        <div>
                            <div class="item">
                                <div class="form-group">
                                    <label for=" product">Produit</label>
                                    <input type="text" class="form-control" name="product[]" required>
                                </div>
                                <div class="form-group">
                                    <label for="price">Prix</label>
                                    <input type="number" class="form-control" id="price" name="price[]" required>
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity[]" required>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="item">
                                <div class="form-group">
                                    <label for=" product">Produit</label>
                                    <input type="text" class="form-control" name="product[]" required>
                                </div>
                                <div class="form-group">
                                    <label for="price">Prix</label>
                                    <input type="number" class="form-control" name="price[]" required>
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" class="form-control" name="quantity[]" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Ajouter au panier</button>
                    </form>
                </div>
            </div>
        </div>
<?php
    }
}
