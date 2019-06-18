<?php
namespace App\Controller;

use App\Model \ {
    Category,
    Post
};
use App\Connection;
use App\PaginatedQuery;

class CategoryController extends Controller{

    public function all()
    {

        $paginatedQuery = new PaginatedQuery(
            "SELECT count(id) FROM category",
            "SELECT * FROM category 
            ORDER BY id",
            Category::class,
            $this->getRouter()
                ->url('categories'),
            10
        );
        $categories = $paginatedQuery->getItems();
        $title = "Catégories";

        $this->render(
            "category/all",
            [
            "title" => $title,
            "categories" => $categories,
            "paginate" => $paginatedQuery->getNavHTML()
            ]);
        
    }

    public function show(array $params)
    {
        $id = (int)$params['id'];
        $slug = $params['slug'];

                
        $pdo = Connection::getPDO();

        $statement = $pdo->prepare("SELECT * FROM category WHERE id=?");
        $statement->execute([$id]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, Category::class);
        /** @var Category|false */
        $category = $statement->fetch();

        if (!$category) {
            throw new Exception('Aucune categorie ne correspond à cet ID');
        }

        if ($category->getSlug() !== $slug) {
            $url = $this->getRouter()->url(
                'category',
                [
                    'id' => $id,
                    'slug' => $category->getSlug()
                ]
            );
            http_response_code(301);
            header('Location: ' . $url);
            exit();
        }

        $title = 'categorie : ' . $category->getName();

        $uri = $this->getRouter()->url("category", ["id" => $category->getId(), "slug" => $category->getSlug()]);
        $paginatedQuery = new PaginatedQuery(
            "SELECT count(category_id) FROM post_category WHERE category_id = {$category->getId()}",
            "SELECT p.*
            FROM post p
            JOIN post_category pc ON pc.post_id = p.id
            WHERE pc.category_id = {$category->getId()}
            ORDER BY created_at DESC",
            Post::class,
            $uri
        );
        $posts = $paginatedQuery->getItems();

        $ids = array_map(function (Post $post) {
            return $post->getId();
        }, $posts);

        $categories = Connection::getPDO()
        ->query("SELECT c.*, pc.post_id
                FROM post_category pc 
                LEFT JOIN category c on pc.category_id = c.id
                WHERE post_id IN (" . implode(', ', $ids) . ")")
        ->fetchAll(\PDO::FETCH_CLASS, \App\Model\Category::class);

        $postById = [];
        foreach ($posts as $post) {
            $postById[$post->getId()] = $post;
        }
        foreach ($categories as $category) {
            $postById[$category->post_id]->setCategories($category);
        }

        $this->render(
            "category/show",
            [
                "title" => $title,
                "posts" => $postById,
                "paginate" => $paginatedQuery->getNavHTML()
            ]);
    }
}