<?php

class DIYView extends View {

    public function show() {
        ob_start();
        ?>

        <!-- Hero Section -->
        <div class="max-w-5xl mx-auto my-8 md:my-16 px-4 hero min-h-lg">
            <div class="hero-content flex-col lg:flex-row">
                <img
                    src="https://source.unsplash.com/600x400/?eco,nature"
                    class="max-w-sm rounded-lg shadow-2xl" />
                <div>
                    <h1 class="text-5xl font-bold">DIY Écologiques</h1>
                    <p class="py-6">
                        Découvrez nos guides pour fabriquer vous-même des objets écologiques et réduire votre impact environnemental !
                    </p>
                    <button class="btn btn-primary">Explorer</button>
                </div>
            </div>
        </div>

        <!-- Section : Articles DIY -->
        <div class="max-w-5xl mx-auto my-8 md:my-16 px-4">
            <h2 class="text-4xl font-bold text-center mb-8">Articles DIY</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Article 1 -->
                <div class="card bg-base-100 shadow-lg p-4">
                    <figure>
                        <img src="https://source.unsplash.com/300x200/?handmade,soap" alt="Savon maison" class="rounded-lg">
                    </figure>
                    <div class="card-body text-center">
                        <h3 class="text-xl font-semibold">Fabriquer son savon naturel</h3>
                        <p class="text-gray-600">Une recette simple et naturelle pour créer votre propre savon bio.</p>
                        <button class="btn btn-primary">Lire plus</button>
                    </div>
                </div>
                <!-- Article 2 -->
                <div class="card bg-base-100 shadow-lg p-4">
                    <figure>
                        <img src="https://source.unsplash.com/300x200/?recycle,wood" alt="Meubles recyclés" class="rounded-lg">
                    </figure>
                    <div class="card-body text-center">
                        <h3 class="text-xl font-semibold">Recycler du bois pour des meubles</h3>
                        <p class="text-gray-600">Apprenez à donner une seconde vie au bois pour créer vos meubles uniques.</p>
                        <button class="btn btn-primary">Lire plus</button>
                    </div>
                </div>
                <!-- Article 3 -->
                <div class="card bg-base-100 shadow-lg p-4">
                    <figure>
                        <img src="https://source.unsplash.com/300x200/?homemade,cleaning" alt="Produits ménagers" class="rounded-lg">
                    </figure>
                    <div class="card-body text-center">
                        <h3 class="text-xl font-semibold">Faire ses produits ménagers écologiques</h3>
                        <p class="text-gray-600">Des alternatives naturelles pour un nettoyage écologique et efficace.</p>
                        <button class="btn btn-primary">Lire plus</button>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'DIY Écologiques', "Découvrez des astuces pour créer vos propres objets écologiques", ['diy']))->show();
    }
}
?>
