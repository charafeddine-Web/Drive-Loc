<?php
require_once '../../autoload.php'; 
use Classes\DatabaseConnection;
class Article {
    private ?int $idArticle;
    private ?string $title;
    private ?string $content;
    private ?string $imageArt; 
    private ?string $video;  
    private ?string $createdAt;
    private ?int $themeId;
    private ?int $auteurId;
    private ?int $tagsId;

    public function __construct(
        ?int $idArticle = null,
        ?string $title = null,
        ?string $content = null,
        ?string $imageArt = null,
        ?string $video = null,
        ?string $createdAt = null,
        ?int $themeId = null,
        ?int $auteurId = null,
        ?int $tagsId = null
    ) {
        $this->idArticle = $idArticle;
        $this->title = $title;
        $this->content = $content;
        $this->imageArt = $imageArt;
        $this->video = $video;
        $this->createdAt = $createdAt;
        $this->themeId = $themeId;
        $this->auteurId = $auteurId;
        $this->tagsId = $tagsId;
    }


    public function ShowArticles(){
        $pdo = DatabaseConnection::getInstance()->getConnection();
        try{
            $sql = "
            SELECT 
                articles.idArticle,
                articles.title,
                articles.content,
                articles.imageArt,
                articles.video,
                articles.created_at,
                themes.name AS theme_name,
                Users.fullname AS author_name,
                tags.name AS tag_name
            FROM articles
            LEFT JOIN themes ON articles.theme_id = themes.idTheme
            LEFT JOIN Users ON articles.auteur_id = Users.id_user
            LEFT JOIN tags ON articles.tags_id = tags.idTag
            ORDER BY articles.created_at DESC
        ";            $stmt=$pdo->prepare($sql);
            $stmt->execute();
            return  $stmt->fetchAll(\PDO::FETCH_ASSOC) ;
        }catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Getters and Setters
    public function getIdArticle(): int {
        return $this->idArticle;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function getContent(): string {
        return $this->content;
    }

    public function setContent(string $content): void {
        $this->content = $content;
    }

    public function getImageArt(): ?string {
        return $this->imageArt;
    }

    public function setImageArt(?string $imageArt): void {
        $this->imageArt = $imageArt;
    }

    public function getVideo(): ?string {
        return $this->video;
    }

    public function setVideo(?string $video): void {
        $this->video = $video;
    }

    public function getCreatedAt(): DateTime {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void {
        $this->createdAt = $createdAt;
    }

    public function getThemeId(): int {
        return $this->themeId;
    }

    public function setThemeId(int $themeId): void {
        $this->themeId = $themeId;
    }

    public function getAuteurId(): int {
        return $this->auteurId;
    }

    public function setAuteurId(int $auteurId): void {
        $this->auteurId = $auteurId;
    }

    public function getTagsId(): int {
        return $this->tagsId;
    }

    public function setTagsId(int $tagsId): void {
        $this->tagsId = $tagsId;
    }
}

?>
