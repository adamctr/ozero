<?php

class BackUserView extends View
{

    public function show($userList, $rolesList)
    {


        ob_start();
?>
        <!-- Main Content -->
        <div class="flex flex-col gap-4 justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Gestion des utilisateurs</h1>
            <label for="add-user-modal" class="btn btn-primary gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter un utilisateur
            </label>
        </div>

        <!-- Tableau des utilisateurs -->
        <div class="overflow-x-auto rounded-lg border border-base-200">
            <table class="table table-zebra w-full">
                <thead class="bg-base-200">
                    <tr>
                        <th class="text-sm font-bold">ID</th>
                        <th class="text-sm font-bold">Nom complet</th>
                        <th class="text-sm font-bold">Email</th>
                        <th class="text-sm font-bold">Rôle</th>
                        <th class="text-sm font-bold">Vérifié</th>
                        <th class="text-sm font-bold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($userList as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user->getUserId()) ?></td>
                            <td>
                                <div class="flex items-center space-x-3">
                                    <div>
                                        <div class="font-bold"><?= htmlspecialchars($user->getNickName()) ?></div>
                                        <div class="text-sm opacity-50">
                                            <?= htmlspecialchars($user->getFirstName() . ' ' . $user->getLastName()) ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($user->getMail()) ?></td>
                            <td>
                                <?php foreach ($rolesList as $role): ?>
                                    <?php if ($role->getRoleId() === $user->getRoleId()): ?>
                                        <span class="badge badge-primary"><?= htmlspecialchars($role->getRole()) ?></span>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                            </td>
                            <td>
                                <?php if ($user->isVerified()): ?>
                                    <span class="badge badge-success">Oui</span>
                                <?php else: ?>
                                    <span class="badge badge-error">Non</span>
                                <?php endif; ?>
                            </td>
                            <td class="flex gap-2">
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
                                    Modifier
                                </label>
                                <button class="btn btn-sm btn-error"
                                    onclick="confirmDelete(<?= $user->getUserId() ?>)">
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
        <?php $this->renderEditModal($rolesList); ?>
        <?php $this->renderDeleteModal(); ?>

        <script>
            function confirmDelete(userId) {
                document.getElementById('delete-user-id').value = userId;
                document.getElementById('delete-modal').checked = true;
            }

            function populateEditForm(button) {
                const dataset = button.dataset;
                document.getElementById('edit-user-id').value = dataset.userId;
                document.getElementById('edit-firstName').value = dataset.firstName;
                document.getElementById('edit-lastName').value = dataset.lastName;
                document.getElementById('edit-nickName').value = dataset.nickName;
                document.getElementById('edit-mail').value = dataset.mail;
                document.getElementById('edit-roleId').value = dataset.roleId;
                document.getElementById('edit-verified').checked = dataset.verified === 'true';
            }
        </script>

    <?php
        $contentPage = ob_get_clean();
        (new BackOfficePageView($contentPage, 'Utilisateurs Admin', "Ceci est la page de gestion des utilisateurs.", ['backoffice']))->show();
    }
    private function renderAddModal()
    {
    ?>
        <input type="checkbox" id="add-user-modal" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box w-11/12 max-w-5xl">
                <h3 class="font-bold text-lg mb-6">Nouvel utilisateur</h3>
                <form method="POST" action="/admin/users/create">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Prénom</span>
                            </label>
                            <input type="text" name="firstName" class="input input-bordered" required>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Nom de famille</span>
                            </label>
                            <input type="text" name="lastName" class="input input-bordered" required>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Pseudo</span>
                            </label>
                            <input type="text" name="nickName" class="input input-bordered" required>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Email</span>
                            </label>
                            <input type="email" name="mail" class="input input-bordered" required>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Mot de passe</span>
                            </label>
                            <input type="password" name="password" class="input input-bordered" required>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Rôle</span>
                            </label>
                            <select name="roleId" class="select select-bordered">
                                <option value="1">Admin</option>
                                <option value="2">Éditeur</option>
                                <option value="3" selected>Utilisateur</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-control mt-4">
                        <label class="label cursor-pointer justify-start gap-2">
                            <input type="checkbox" name="verified" class="checkbox checkbox-primary">
                            <span class="label-text">Compte vérifié</span>
                        </label>
                    </div>

                    <div class="modal-action">
                        <button type="submit" class="btn btn-primary">Créer l'utilisateur</button>
                        <label for="add-user-modal" class="btn">Annuler</label>
                    </div>
                </form>
            </div>
        </div>
    <?php
    }

    private function renderEditModal($rolesList)
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

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Rôle</span>
                            </label>
                            <select name="roleId" id="edit-roleId" class="select select-bordered">
                                <?php foreach ($rolesList as $role): ?>
                                    <option value=<?= $role->getRoleId() ?>><?= $role->getRole() ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-control mt-4">
                        <label class="label cursor-pointer justify-start gap-2">
                            <input type="checkbox" name="verified" id="edit-verified" class="checkbox checkbox-primary">
                            <span class="label-text">Compte vérifié</span>
                        </label>
                    </div>

                    <div class="modal-action">
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                        <label for="edit-user-modal" class="btn">Annuler</label>
                    </div>
                </form>
            </div>
        </div>
    <?php
    }

    private function renderDeleteModal()
    {
    ?>
        <input type="checkbox" id="delete-modal" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box">
                <h3 class="font-bold text-lg">Confirmer la suppression</h3>
                <p class="py-4">Êtes-vous sûr de vouloir supprimer définitivement cet utilisateur ?</p>
                <form method="POST" action="/admin/users/delete" id="delete-form">
                    <input type="hidden" name="userId" id="delete-user-id">
                    <div class="modal-action">
                        <button type="submit" class="btn btn-error">Supprimer</button>
                        <label for="delete-modal" class="btn">Annuler</label>
                    </div>
                </form>
            </div>
        </div>
<?php
    }
}
?>