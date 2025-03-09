<?php

class ProfileView extends View
{
    public function show($user, $role, $addresse)
    {
        ob_start();
?>

        <div class="flex flex-col text-center items-center justify-center">
            <h1 class="text-5xl font-bold">Profil</h1>
            <div>
                <p>Prénom : <?= htmlspecialchars($user->getFirstName()) ?></p>
                <p>Nom : <?= htmlspecialchars($user->getLastName()) ?></p>
                <p>Pseudo : <?= htmlspecialchars($user->getNickName()) ?></p>
                <p>Email : <?= htmlspecialchars($user->getMail()) ?></p>
                <p>Rôle : <?= htmlspecialchars($role) ?></p>
            </div>
            <div>
                <p>Adresse : <?= $addresse instanceof AddressesEntity ? htmlspecialchars($addresse->getStreet() ?? '') : '' ?></p>
                <p>Code postal : <?= $addresse instanceof AddressesEntity ? htmlspecialchars($addresse->getZipCode() ?? '') : '' ?></p>
                <p>Ville : <?= $addresse instanceof AddressesEntity ? htmlspecialchars($addresse->getCity() ?? '') : '' ?></p>
                <p>Pays : <?= $addresse instanceof AddressesEntity ? htmlspecialchars($addresse->getCountry() ?? '') : '' ?></p>
                <p>Numéro de téléphone : <?= $addresse instanceof AddressesEntity ? htmlspecialchars($addresse->getPhone() ?? '') : '' ?></p>
                </p>
            </div>
            <div class="flex gap-2">
                <label for="edit-user-modal"
                    class="btn btn-sm btn-info"
                    data-user-id="<?= $user->getUserId() ?>"
                    data-first-name="<?= htmlspecialchars($user->getFirstName()) ?>"
                    data-last-name="<?= htmlspecialchars($user->getLastName()) ?>"
                    data-nick-name="<?= htmlspecialchars($user->getNickName()) ?>"
                    data-mail="<?= htmlspecialchars($user->getMail()) ?>"
                    data-role-id="<?= $user->getRoleId() ?>"
                    data-verified="<?= $user->isVerified() ? 'true' : 'false' ?>"
                    onclick="populateEditForm(this)">
                    Modifier Informations personnelles
                </label>
            </div>
            <div class="flex gap-2">
                <label for="edit-address-modal"
                    class="btn btn-sm btn-info"
                    data-user-id="<?= $user->getUserId() ?>"
                    data-street="<?= $addresse ? htmlspecialchars($addresse->getStreet()) ?? '' : '' ?>"
                    data-zipCode="<?= $addresse ? htmlspecialchars($addresse->getZipCode()) ?? '' : '' ?>"
                    data-city="<?= $addresse ? htmlspecialchars($addresse->getCity()) ?? '' : '' ?>"
                    data-country="<?= $addresse ? htmlspecialchars($addresse->getCountry()) ?? '' : '' ?>"
                    data-phone="<?= $addresse ? $addresse->getPhone() ?? '' : '' ?>"
                    data-role-id="<?= $user->getRoleId() ?>"
                    onclick="populateAddressForm(this)">
                    Modifier addresse
                </label>
            </div>
        </div>


    <?php
        $this->renderEditModal();
        $this->renderEditModalAdress();
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'Profil', "Page de profil", ['debug', 'updateUsers']))->show();
    }

    private function renderEditModal()
    {
    ?>
        <input type="checkbox" id="edit-user-modal" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box w-11/12 max-w-5xl">
                <h3 class="font-bold text-lg mb-6">Modifier l'utilisateur</h3>
                <form method="POST" action="/admin/users/update">
                    <input type="hidden" name="userId" id="edit-user-id">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Prénom</span>
                            </label>
                            <input type="text" name="firstName" id="edit-firstName" class="input input-bordered" required>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Nom de famille</span>
                            </label>
                            <input type="text" name="lastName" id="edit-lastName" class="input input-bordered" required>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Pseudo</span>
                            </label>
                            <input type="text" name="nickName" id="edit-nickName" class="input input-bordered" required>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Email</span>
                            </label>
                            <input type="email" name="mail" id="edit-mail" class="input input-bordered" required>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Nouveau mot de passe</span>
                            </label>
                            <input type="password" name="password" class="input input-bordered">
                        </div>

                        <div class="form-control hidden">
                            <label class="label">
                                <span class="label-text">Rôle</span>
                            </label>
                            <input type="text" name="roleId" id="edit-roleId" class="input input-bordered" list="roles" required>
                        </div>

                        <div class="form-control mt-4 hidden">
                            <label class="label cursor-pointer justify-start gap-2">
                                <input type="checkbox" name="verified" id="edit-verified" class="checkbox checkbox-primary">
                                <span class="label-text">Compte vérifié</span>
                            </label>
                        </div>

                        <div class="modal-action">
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                            <label for="edit-user-modal" class="btn">Annuler</label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php
    }

    private function renderEditModalAdress()
    {
    ?>
        <input type="checkbox" id="edit-address-modal" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box w-11/12 max-w-5xl">
                <h3 class="font-bold text-lg mb-6">Modifier l'adresse</h3>
                <form method="POST" action="/admin/users/updateAddresse">
                    <input type="hidden" name="userId" id="edit-address-user-id">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Adresse</span>
                            </label>
                            <input type="text" name="street" id="edit-street" class="input input-bordered" required>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Code postal</span>
                            </label>
                            <input type="text" name="zipCode" id="edit-zipCode" class="input input-bordered" required>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Ville</span>
                            </label>
                            <input type="text" name="city" id="edit-city" class="input input-bordered" required>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Pays</span>
                            </label>
                            <input type="text" name="country" id="edit-country" class="input input-bordered" required>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">N° de téléphone</span>
                            </label>
                            <input type="text" name="phone" id="edit-phone" class="input input-bordered">
                        </div>

                        <div class="form-control hidden">
                            <label class="label">
                                <span class="label-text">Rôle</span>
                            </label>
                            <input type="text" name="roleId" id="edit-addresse-roleId" class="input input-bordered" list="roles" required>
                        </div>

                        <div class="modal-action">
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                            <label for="edit-address-modal" class="btn">Annuler</label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
<?php
    }
}
