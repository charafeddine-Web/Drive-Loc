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
    private $tags;
    private ?string $status;
    public function __construct(
        ?int $idArticle = null,
        ?string $title = null,
        ?string $content = null,
        ?string $imageArt = null,
        ?string $video = null,
        ?string $createdAt = null,
        ?int $themeId = null,
        int $auteurId = null,
        ?string $status,
        ?array  $tags,
    ) {
        $this->idArticle = $idArticle;
        $this->title = $title;
        $this->content = $content;
        $this->imageArt = $imageArt;
        $this->video = $video;
        $this->createdAt = $createdAt;
        $this->themeId = $themeId;
        $this->auteurId = $auteurId;
        $this->status = $status;
        $this->tags = $tags;
    }
    public function getFilteredArticles($themeId = null) {
        $pdo = DatabaseConnection::getInstance()->getConnection();
        $query = "SELECT * FROM articles";
        if ($themeId) {
            $query .= " WHERE theme_id = :theme_id";
        }
        $stmt = $pdo->prepare($query);
        if ($themeId) {
            $stmt->bindParam(':theme_id', $themeId);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addArticle() {
        try {
            $pdo = DatabaseConnection::getInstance()->getConnection();
            $sql = "INSERT INTO articles (title, content, imageArt, video, theme_id, auteur_id, status) 
                    VALUES (:title, :content, :imageArt, :video, :theme_id, :auteur_id, :status)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':content', $this->content);
            $stmt->bindParam(':imageArt', $this->imageArt);
            $stmt->bindParam(':video', $this->video);
            $stmt->bindParam(':theme_id', $this->themeId);
            $stmt->bindParam(':auteur_id', $this->auteurId);
            $stmt->bindParam(':status', $this->status);
            $stmt->execute();
            $articleId = $pdo->lastInsertId();
            $this->addTags($articleId);

            return "Article and tags added successfully.";
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
    private function addTags($articleId) {
        if (!empty($this->tags)) {
            try {
                $pdo = DatabaseConnection::getInstance()->getConnection();
                foreach ($this->tags as $tagName) {
                    $sql = "SELECT idTag FROM tags WHERE name = :name";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':name', $tagName);
                    $stmt->execute();
                    $tag = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($tag) {
                        $tagId = $tag['idTag'];
                    } else {
                        $sql = "INSERT INTO tags (name) VALUES (:name)";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':name', $tagName);
                        $stmt->execute();
                        $tagId = $pdo->lastInsertId(); 
                    }
                    $sql = "INSERT INTO article_tags (article_id, tag_id) VALUES (:article_id, :tag_id)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':article_id', $articleId);
                    $stmt->bindParam(':tag_id', $tagId);
                    $stmt->execute();
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
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
                articles.status,
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
        ";
            $stmt=$pdo->prepare($sql);
            $stmt->execute();
            return  $stmt->fetchAll(\PDO::FETCH_ASSOC) ;
        }catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function ShowArticles_Client(){
        $pdo = DatabaseConnection::getInstance()->getConnection();
        try {
            if (empty($this->auteurId)) {
                echo "No author ID set.";
                return;
            }
                $sql = "
                SELECT a.idArticle, a.title, a.content, a.imageArt, a.video, a.status, a.created_at, GROUP_CONCAT(t.name) AS tags
                FROM articles a
                LEFT JOIN article_tags at ON a.idArticle = at.article_id
                LEFT JOIN tags t ON at.tag_id = t.idTag
                WHERE a.auteur_id = ?
                GROUP BY a.idArticle
            ";
    
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $this->auteurId, PDO::PARAM_INT);
            $stmt->execute();
    
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    
            if (empty($result)) {
                return "No articles found for this user.";
            }
    
            return $result;
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    public function DeleteArticle($idArticle) {
        $pdo = DatabaseConnection::getInstance()->getConnection();
        try {
            $sql1 = "DELETE FROM article_tags WHERE article_id = :idArticle";
            $stmt1 = $pdo->prepare($sql1);
            $stmt1->bindParam(":idArticle", $idArticle, PDO::PARAM_INT);
            $stmt1->execute();
            $sql2 = "DELETE FROM articles WHERE idArticle = :idArticle";
            $stmt2 = $pdo->prepare($sql2);
            $stmt2->bindParam(":idArticle", $idArticle, PDO::PARAM_INT);
            return $stmt2->execute();
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
    
    // Getters and Setters
    public function getIdArticle(): int {
        return $this->idArticle;
    }
    public function getStatus(): string {
        return $this->status;
    }
    public function setStatus(string $status): void {
        $this->status = $status;
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
