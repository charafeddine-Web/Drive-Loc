<?php
require_once '../../autoload.php'; 
use Classes\DatabaseConnection;


class Comment{
    private $idComments;
    private $content;
    private $create_at;
    private $article_id;
    private $user_id;
    
    public function __construct($idComments,$content,$create_at,$article_id,$user_id){
        $this->idComments=$idComments;
        $this->content=$content;
        $this->create_at=$create_at;
        $this->article_id=$article_id;
        $this->user_id=$user_id;
    }

    public function addComment() {
        try {
            $db = DatabaseConnection::getInstance()->getConnection();
            $query = "INSERT INTO comments (content, article_id, user_id) VALUES (:content, :article_id, :user_id)";
            if (!$query) {
                die("Error preparing statement: " . $db->error);
            }
            $stmt = $db->prepare($query);
            $stmt->bindParam(':content', $this->content);
            $stmt->bindParam(':article_id', $this->article_id);
            $stmt->bindParam(':user_id', $this->user_id);
            
            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Failed to add comment");
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    public static function getAllComments() {
        $db = DatabaseConnection::getInstance()->getConnection();
        $sql="
            SELECT 
                comments.idComments,
                comments.content,
                comments.created_at,
                articles.title AS title,
                articles.content AS content,
                articles.imageArt AS imageArt,
                articles.video AS video,
                articles.created_at AS created_article,
                users.fullname AS user_name
            FROM 
                comments
            JOIN 
                articles ON comments.article_id = articles.idArticle
            JOIN 
                users ON comments.user_id = users.id_user
            ORDER BY 
                comments.created_at DESC
        ";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    public static function getCommentsByArticle($articleId) {
        $db = DatabaseConnection::getInstance()->getConnection();
        $query = "
            SELECT 
                comments.content AS comment_content,
                comments.created_at AS comment_date,
                articles.title AS article_title,
                articles.content AS article_content,
                articles.created_at AS created_article,
                articles.imageArt AS article_image,
                users.fullname AS user_name
            FROM 
                comments
            JOIN 
                articles ON comments.article_id = articles.idArticle
            JOIN 
                users ON comments.user_id = users.id_user
            WHERE 
                articles.idArticle = :articleId
            ORDER BY 
                comments.created_at DESC
        ";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':articleId', $articleId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // public static function getCommentsByArticle($article_id) {
    //     $db = DatabaseConnection::getInstance()->getConnection();
    //     $stmt = $db->prepare("SELECT * FROM comments WHERE article_id = ? ORDER BY create_at DESC");
    //     $stmt->execute([$article_id]);
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    public static function getCommentById($id) {
        $db = DatabaseConnection::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM comments WHERE idComments = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }
    public function updateComment() {
        $db = DatabaseConnection::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE comments SET content = ?, create_at = NOW() WHERE idComments = ?");
        $stmt->execute([$this->content, $this->idComments]);
        return $stmt->rowCount() > 0; 
    }
    
    // public static function countCommentsByArticle($article_id) {
    //     $db = DatabaseConnection::getInstance()->getConnection();
    //     $stmt = $db->prepare("SELECT COUNT(*) as comment_count FROM comments WHERE article_id = ?");
    //     $stmt->execute([$article_id]);
    //     $result = $stmt->fetch(PDO::FETCH_ASSOC);
    //     return $result['comment_count']; 
    // }

    public function DeleteComment(){
        $db=DatabaseConnection::getInstance()->getConnection();
        try{
            $sql="DELETE FROM comments where idComments= ?";
            $stmt=$db->prepare($sql);
            $stmt->bindParam(1, $this->idComments, PDO::PARAM_INT);  
            return $stmt->execute();
        }catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    
    
    
}