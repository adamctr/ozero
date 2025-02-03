<?php

class ProductBackView extends View {

    public function show() {
        $productModel = new ProductModel();
        $products = $productModel->getAllProducts();

        ob_start();
        ?>
        <!-- Main Content -->
        <div class="flex flex-col gap-4 justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Gestion des produits</h1>
            <label for="add-product-modal" class="btn btn-primary gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter un produit
            </label>
        </div>

        <!-- Tableau des produits -->
        <div class="overflow-x-auto rounded-lg border border-base-200">
            <table class="table table-zebra w-full">
                <thead class="bg-base-200">
                <tr>
                    <th class="text-sm font-bold">ID</th>
                    <th class="text-sm font-bold">Nom</th>
                    <th class="text-sm font-bold">Description</th>
                    <th class="text-sm font-bold">Prix</th>
                    <th class="text-sm font-bold">Stock</th>
                    <th class="text-sm font-bold">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product->getProductId()) ?></td>
                        <td><?= htmlspecialchars($product->getProduct()) ?></td>
                        <td><?= htmlspecialchars($product->getDescription()) ?></td>
                        <td><?= htmlspecialchars($product->getPrice()) ?></td>
                        <td><?= htmlspecialchars($product->getStock()) ?></td>
                        <td class="flex gap-2">
                            <label for="edit-product-modal"
                                   class="btn btn-sm btn-info"
                                   data-product-id="<?= $product->getProductId() ?>"
                                   data-product="<?= htmlspecialchars($product->getProduct()) ?>"
                                   data-description="<?= htmlspecialchars($product->getDescription()) ?>"
                                   data-price="<?= htmlspecialchars($product->getPrice()) ?>"
                                   data-stock="<?= htmlspecialchars($product->getStock()) ?>">
                                Modifier
                            </label>

                            <button class="btn btn-sm btn-error"
                                    data-product-id="<?= $product->getProductId() ?>">
                                Supprimer
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Modals -->
        <?php $this->renderAddModal(); ?>
        <?php $this->renderEditModal(); ?>
        <?php $this->renderDeleteModal(); ?>

        <?php
        $contentPage = ob_get_clean();
        (new BackOfficePageView($contentPage, 'Gestion des Produits', "Ceci est la page de gestion des produits.", ['backoffice', 'productsback']))->show();
    }

    private function renderAddModal() {
        ?>
        <input type="checkbox" id="add-product-modal" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box w-11/12 max-w-5xl">
                <h3 class="font-bold text-lg mb-6">Nouveau produit</h3>
                <form method="POST" action="/admin/products/create" enctype="multipart/form-data">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Nom du produit</span>
                        </label>
                        <input type="text" name="product" class="input input-bordered" required>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Description</span>
                        </label>
                        <textarea name="description" class="textarea textarea-bordered" required></textarea>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Prix</span>
                        </label>
                        <input type="number" name="price" class="input input-bordered" step="0.01" required>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Stock</span>
                        </label>
                        <input type="number" name="stock" class="input input-bordered" required>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Image</span>
                        </label>
                        <input type="file" name="img" class="input input-bordered" accept="image/*">
                    </div>

                    <div class="modal-action">
                        <button type="submit" class="btn btn-primary">Créer le produit</button>
                        <label for="add-product-modal" class="btn">Annuler</label>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }

    private function renderEditModal() {
        ?>
        <input type="checkbox" id="edit-product-modal" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box w-11/12 max-w-5xl">
                <h3 class="font-bold text-lg mb-6">Modifier le produit</h3>
                <form method="POST" action="/admin/products/update" enctype="multipart/form-data">
                    <input type="hidden" name="productId" id="edit-product-id">

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Nom du produit</span>
                        </label>
                        <input type="text" name="product" id="edit-product" class="input input-bordered" required>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Description</span>
                        </label>
                        <textarea name="description" id="edit-description" class="textarea textarea-bordered" required></textarea>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Prix</span>
                        </label>
                        <input type="number" name="price" id="edit-price" class="input input-bordered" step="0.01" required>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Stock</span>
                        </label>
                        <input type="number" name="stock" id="edit-stock" class="input input-bordered" required>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Image</span>
                        </label>
                        <input type="file" name="img" class="input input-bordered" accept="image/*">
                    </div>

                    <div class="modal-action">
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                        <label for="edit-product-modal" class="btn">Annuler</label>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }


    private function renderDeleteModal() {
        ?>
        <input type="checkbox" id="delete-product-modal" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box">
                <h3 class="font-bold text-lg">Confirmer la suppression</h3>
                <p class="py-4">Êtes-vous sûr de vouloir supprimer définitivement ce produit ?</p>
                <form method="POST" action="/admin/products/delete" id="delete-form">
                    <input type="hidden" name="productId" id="delete-product-id">
                    <div class="modal-action">
                        <button type="submit" class="btn btn-error">Supprimer</button>
                        <label for="delete-product-modal" class="btn">Annuler</label>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }
}
?>
