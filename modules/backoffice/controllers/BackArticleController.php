<?php

class BackArticleController {

    private ?ArticleEntity $article;
    private int $articleId;

    public function __construct($articleId = null) {
        if ($articleId !== null) {
            $articleModel = new ArticleModel();
            $this->article = $articleModel->getArticleById($articleId);
            $this->articleId = $articleId;
        }
    }

    /**
     * Affiche la vue principale du backoffice.
     *
     * @return void
     */
    public function execute() {
        $view = new BackArticleView();
        $view->show();
    }

    /**
     * Affiche la vue de création d'article.
     *
     * @return void
     */
    public function create() {
        $view = new BackCreateEditArticleView($this->article);
        $view->show();
    }
}
?>
