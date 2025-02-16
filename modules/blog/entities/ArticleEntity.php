<?php

class ArticleEntity {
    // Propriétés correspondant aux colonnes de la table `articles`
    private ?int $articleId;
    private ?string $title;
    private ?DateTime $articleDate;
    private ?string $content;
    private ?string $img;
    private ?int $authorId;
    private ?string $authorName;


    // Constructeur
    public function __construct(
        ?int $articleId = null,
        ?string $title = null,
        null|string|DateTime $articleDate = null,
        ?string $content = null,
        ?string $img = null,
        ?int $authorId = null,
        ?string $authorName = null,

    ) {
        $this->articleId = $articleId;
        $this->title = $title;
        $this->setArticleDate($articleDate);
        $this->content = $content;
        $this->img = $img;
        $this->authorId = $authorId;
        $this->authorName = $authorName;

    }

    // Getters
    public function getArticleId(): ?int {
        return $this->articleId;
    }

    public function getTitle(): ?string {
        return $this->title;
    }

    public function getArticleDate(): ?DateTime {
        return $this->articleDate;
    }

    public function getContent(): ?string {
        return $this->content;
    }

    public function getImg(): ?string {
        return $this->img;
    }

    public function getAuthorId(): ?int {
        return $this->authorId;
    }

    public function setAuthorName(string $authorName): self
    {
        $this->authorName = $authorName;
        return $this;
    }

    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    // Setters avec return $this pour le chaînage
    public function setArticleId(?int $articleId): self {
        $this->articleId = $articleId;
        return $this;
    }

    public function setTitle(?string $title): self {
        $this->title = $title;
        return $this;
    }

    public function setArticleDate(null|string|DateTime $articleDate): self {
        if (is_string($articleDate)) {
            $this->articleDate = new DateTime($articleDate);
        } else {
            $this->articleDate = $articleDate;
        }
        return $this;
    }

    public function setContent(?string $content): self {
        $this->content = $content;
        return $this;
    }

    public function setImg(?string $img): self {
        $this->img = $img;
        return $this;
    }

    public function setAuthorId(?int $authorId): self {
        $this->authorId = $authorId;
        return $this;
    }

    // Méthode pour convertir l'objet en tableau
    public function toArray(): array {
        return [
            'articleId'   => $this->articleId,
            'title'       => $this->title,
            'articleDate' => $this->articleDate ? $this->articleDate->format('Y-m-d') : null,
            'content'     => $this->content,
            'img'         => $this->img,
            'authorId'    => $this->authorId,
            'authorName'    => $this->authorName

        ];
    }
}
?>
