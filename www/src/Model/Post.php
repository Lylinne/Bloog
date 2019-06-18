<?php
namespace App\Model;

use App\Helpers\Text;

class Post
{
    private $id;

    private $name;

    private $slug;

    private $content;

    private $created_at;

    private $categories = [];

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Get the value of content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Get the value of created_at
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return new \DateTime($this->created_at);
    }

    public function getExcerpt(int $lenght): string
    {
        return nl2br(htmlentities(TEXT::excerpt($this->getContent(), $lenght)));
    }
    
    public function getCategories(): array
    {
        return $this->categories;
    }

    public function setCategories(Category $category): void
    {
        $this->categories[] = $category;
    }

    public function getUrl(): string
    {
        return \App\App::getInstance()
            ->getRouter()
            ->url('post', [
                "slug" => $this->getSlug(),
                "id"=> $this->getId()
                ]);
    }
}
