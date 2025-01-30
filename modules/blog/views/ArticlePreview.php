<?php

class ArticlePreview extends View {

    // Propriétés de la classe
    public $id;
    public $title;
    public $content;
    public $author;
    public $image;
    public $date;

    // Constructeur de la classe
    public function __construct($id, $title, $content, $author, $image, $date)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->author = $author;
        $this->image = $image;
        $this->date = $date;
    }

    public function show() {
        ob_start();
        ?>

        <div class="card bg-base-100 shadow-lg p-4">
            <figure>
                <img src="https://source.unsplash.com/300x200/?blog,eco" alt="Éco-conseils" class="rounded-lg">
            </figure>
            <div class="card-body text-center">
                <h3 class="text-xl font-semibold">10 Conseils pour un Mode de Vie Écologique</h3>
                <p class="text-gray-600">Découvrez des astuces simples pour réduire votre empreinte écologique au quotidien.</p>
                <button class="btn btn-primary">Lire plus</button>
            </div>
        </div>

        <?php
        $contentPage = ob_get_clean();
        (new FrontPageView($contentPage, 'DIY Écologiques', "Découvrez des astuces pour créer vos propres objets écologiques", ['diy']))->show();
    }
}
?>
