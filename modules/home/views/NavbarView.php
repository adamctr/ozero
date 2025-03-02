<?php

class NavbarView extends View
{

    public function show()
    {
        $user = new SessionController();
        $subtotal = 0;
        $products = 0;
        if (isset($_SESSION['cart'])) {
            $products = count($_SESSION['cart']);
            foreach ($_SESSION['cart'] as $product) {
                $subtotal += $product['price'] * $product['quantity'];
            };
        }

        ob_start(); // Commence la mise en mémoire tampon du contenu
?>

        <div class="navbar bg-base-100">
            <div class="navbar-start">

                <div class="dropdown">
                    <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h8m-8 6h16" />
                        </svg>
                    </div>
                    <ul
                        tabindex="0"
                        class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
                        <li><a>Item 1</a></li>
                        <li>
                            <a>Parent</a>
                            <ul class="p-2">
                                <li><a>Submenu 1</a></li>
                                <li><a>Submenu 2</a></li>
                            </ul>
                        </li>
                        <li><a>Item 3</a></li>
                    </ul>
                </div>
                <a href="/" class="btn btn-ghost text-xl">Ozero</a>
            </div>

            <div class="navbar-center hidden lg:flex">
                <ul class="menu menu-horizontal px-1">
                    <li><a>Item 1</a></li>
                    <li>
                        <details>
                            <summary>Parent</summary>
                            <ul class="p-2">
                                <li><a>Submenu 1</a></li>
                                <li><a>Submenu 2</a></li>
                            </ul>
                        </details>
                    </li>
                    <li><a href="/blog">BLOG</a></li>
                    <li><a href="/diy">DIY</a></li>
                </ul>
            </div>
            <div class="navbar-end">
                <div class="flex-none">
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                            <div class="indicator">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span class="badge badge-sm indicator-item"><?= $products ?></span>
                            </div>
                        </div>
                        <div
                            tabindex="0"
                            class="card card-compact dropdown-content bg-base-100 z-[1] mt-3 w-52 shadow">
                            <div class="card-body">
                                <span class="text-lg font-bold"><?= $products ?></span>
                                <span class="text-info">Sous-total: <?= $subtotal ?> €</span>
                                <div class="card-actions">
                                    <a href="/panier" class="btn btn-primary btn-block">Voir le panier</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ($user->isLoggedIn()): ?>
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                            <div class="w-10 rounded-full relative">
                                <svg width="24px" height="24px" class="absolute top-1/2 -translate-y-1/2 left-1/2 -translate-x-1/2" viewBox="0 0 24 24" fill="black" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 21C5 17.134 8.13401 14 12 14C15.866 14 19 17.134 19 21M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </div>
                        </div>
                        <ul
                            tabindex="0"
                            class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
                            <li>
                                <h4>Bonjour, <span class="font-bold"><?= ucfirst($user->getFirstName()) ?></span></h4>
                            </li>
                            <li><a href="/profile">Profile</a></li>
                            <li><a href="/commandes">Commandes</a></li>
                            <li><a href="/admin/users">Liste Utilisateurs</a></li>
                            <li>
                                <form id="logoutForm" action="/logout" method="POST" style="display: inline;">
                                    <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0; color: inherit;">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="/login" class="btn btn-ghost">Se connecter</a>
                <?php endif; ?>
            </div>
        </div>

<?php
        return ob_get_clean();
    }
}
