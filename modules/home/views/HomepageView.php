<?php

class HomepageView extends View
{

    public function show()
    {
        ob_start();
?>

        <!-- Hero Section -->
        <div class="max-w-5xl mx-auto my-8 md:my-16 px-4 hero min-h-lg">
            <div class="hero-content flex-col lg:flex-row">
                <img
                    src="https://img.daisyui.com/images/stock/photo-1635805737707-575885ab0820.webp"
                    class="max-w-sm rounded-lg shadow-2xl" />
                <div>
                    <h1 class="text-5xl font-bold">Box Office News!</h1>
                    <p class="py-6">
                        Provident cupiditate voluptatem et in. Quaerat fugiat ut assumenda excepturi exercitationem
                        quasi. In deleniti eaque aut repudiandae et a id nisi.
                    </p>
                    <button class="btn btn-primary">Get Started</button>
                </div>
            </div>
        </div>

        <!-- Section : Nos Produits -->
        <div class="max-w-5xl mx-auto my-8 md:my-16 px-4">
            <h2 class="text-4xl font-bold text-center mb-8">Nos Produits</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Produit 1 -->
                <div class="card bg-base-100 shadow-lg p-4">
                    <figure>
                        <img src="https://source.unsplash.com/300x200/?furniture" alt="Produit 1" class="rounded-lg">
                    </figure>
                    <div class="card-body text-center">
                        <h3 class="text-xl font-semibold">Produit 1</h3>
                        <p class="text-gray-600">Description rapide du produit.</p>
                        <button class="btn btn-primary">Voir plus</button>
                    </div>
                </div>
                <!-- Produit 2 -->
                <div class="card bg-base-100 shadow-lg p-4">
                    <figure>
                        <img src="https://source.unsplash.com/300x200/?chair" alt="Produit 2" class="rounded-lg">
                    </figure>
                    <div class="card-body text-center">
                        <h3 class="text-xl font-semibold">Produit 2</h3>
                        <p class="text-gray-600">Description rapide du produit.</p>
                        <button class="btn btn-primary">Voir plus</button>
                    </div>
                </div>
                <!-- Produit 3 -->
                <div class="card bg-base-100 shadow-lg p-4">
                    <figure>
                        <img src="https://source.unsplash.com/300x200/?table" alt="Produit 3" class="rounded-lg">
                    </figure>
                    <div class="card-body text-center">
                        <h3 class="text-xl font-semibold">Produit 3</h3>
                        <p class="text-gray-600">Description rapide du produit.</p>
                        <button class="btn btn-primary">Voir plus</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section : Pourquoi acheter chez nous -->
        <div class="max-w-5xl mx-auto my-8 md:my-16 px-4">
            <h2 class="text-4xl font-bold text-center mb-8">Why shop from us ?</h2>
            <p class="text-center text-gray-600 mb-8">
                At our furniture emporium, we offer an unrivaled blend of quality, style, and
                convenience, making us the ultimate destination for your home furnishing needs.
            </p>

            <div class="grid md:grid-cols-4 gap-6">
                <!-- Card 1 -->
                <div class="card border p-6 shadow-md">
                    <div class="flex items-center justify-center mb-4">
                        <div class="rounded-full bg-purple-100 p-3">
                            <span class="text-purple-500 text-2xl">⚡</span>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-center">Premium Quality Furniture</h3>
                    <p class="text-gray-600 text-center text-sm">
                        Indulge in the luxury of premium quality furniture that transforms your
                        living spaces into havens of comfort and style.
                    </p>
                    <a href="#" class="text-purple-500 font-bold text-center block mt-4">Learn more</a>
                </div>
                <!-- Card 2 -->
                <div class="card border p-6 shadow-md">
                    <div class="flex items-center justify-center mb-4">
                        <div class="rounded-full bg-purple-100 p-3">
                            <span class="text-purple-500 text-2xl">⚡</span>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-center">Hassle-Free Shopping Experience</h3>
                    <p class="text-gray-600 text-center text-sm">
                        Enjoy a hassle-free shopping experience that puts you at the center of convenience.
                    </p>
                    <a href="#" class="text-purple-500 font-bold text-center block mt-4">Learn more</a>
                </div>
                <!-- Card 3 -->
                <div class="card border p-6 shadow-md">
                    <div class="flex items-center justify-center mb-4">
                        <div class="rounded-full bg-purple-100 p-3">
                            <span class="text-purple-500 text-2xl">⚡</span>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-center">Affordable Best Prices</h3>
                    <p class="text-gray-600 text-center text-sm">
                        Discover affordability without compromise when you shop with us.
                    </p>
                    <a href="#" class="text-purple-500 font-bold text-center block mt-4">Learn more</a>
                </div>
                <!-- Card 4 -->
                <div class="card border p-6 shadow-md">
                    <div class="flex items-center justify-center mb-4">
                        <div class="rounded-full bg-purple-100 p-3">
                            <span class="text-purple-500 text-2xl">⚡</span>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-center">Personalized Customer Support</h3>
                    <p class="text-gray-600 text-center text-sm">
                        Experience the difference of personalized customer support when you choose us.
                    </p>
                    <a href="#" class="text-purple-500 font-bold text-center block mt-4">Learn more</a>
                </div>
            </div>
        </div>



<?php
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'Accueil', "Ceci est la page d'accueil", ['debug']))->show();
    }
}
?>