<?php

namespace App\Service;

use App\Entity\Author;
use App\Repository\AuthorRepository;

class AuthorService
{
    // declare DI repository
    private $authorRepository;

    public function __construct(AuthorRepository $authorRepository)
    {
        // set repository
        $this->authorRepository = $authorRepository;
    }

    public function getRandomAuthor(): Author
    {
        // get all authors
        $authors = $this->authorRepository->findAll();
        
        // return random author
        return $authors[array_rand($authors)];
    }
}
