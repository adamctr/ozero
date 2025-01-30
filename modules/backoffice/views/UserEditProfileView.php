<?php

class UserEditProfileView extends View {

    private $userId;

    public function __construct(int $userId) {
        $this->userId = $userId;
    }

    public function show() {
        ob_start();

        // Récupérer l'utilisateur à partir de l'ID
        $userModel = new UserModel();
        $user = $userModel->getUserById($this->userId);

        if (!$user) {
            echo "<p class='text-red-500'>Utilisateur non trouvé.</p>";
            return;
        }

        ?>
        <!-- Main Content -->
        <main class="flex-1 p-6">
            <h1 class="text-3xl font-bold mb-4">Modification du profil utilisateur</h1>

            <!-- Form to Edit User Profile -->
            <div class="max-w-2xl w-full">
                <form action="/update-user/<?= $user->getUserId() ?>" method="POST" class="space-y-4">
                    <div class="form-control">
                        <label for="firstName" class="label">Prénom</label>
                        <input type="text" name="firstName" id="firstName" value="<?= $user->getFirstName() ?>" class="input input-bordered w-full" required />
                    </div>
                    <div class="form-control">
                        <label for="lastName" class="label">Nom</label>
                        <input type="text" name="lastName" id="lastName" value="<?= $user->getLastName() ?>" class="input input-bordered w-full" required />
                    </div>
                    <div class="form-control">
                        <label for="email" class="label">Email</label>
                        <input type="email" name="email" id="email" value="<?= $user->getMail() ?>" class="input input-bordered w-full" required />
                    </div>
                    <div class="form-control">
                        <label for="password" class="label">Nouveau mot de passe</label>
                        <input type="password" name="password" id="password" class="input input-bordered w-full" placeholder="Laissez vide pour ne pas modifier" />
                    </div>
                    <div class="form-control">
                        <label for="roleId" class="label">Rôle</label>
                        <select name="roleId" id="roleId" class="select select-bordered w-full">
                            <option value="1" <?= $user->getRoleId() == 1 ? 'selected' : '' ?>>Admin</option>
                            <option value="2" <?= $user->getRoleId() == 2 ? 'selected' : '' ?>>Utilisateur</option>
                        </select>
                    </div>
                    <div class="form-control">
                        <label class="cursor-pointer label">
                            <span class="label-text">Utilisateur vérifié</span>
                            <input type="checkbox" name="verified" id="verified" class="checkbox" <?= $user->isVerified() ? 'checked' : '' ?>>
                        </label>
                    </div>
                    <div class="form-control">
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </main>
        <?php
        $contentPage = ob_get_clean();
        (new BackOfficePageView($contentPage, 'Modifier Profil Utilisateur', "Modifiez les informations de l'utilisateur.", ['backoffice']))->show();
    }
}
?>
