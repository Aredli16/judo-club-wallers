<?php

namespace App\DataFixtures;

use App\Entity\Article;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AppFixtures extends Fixture
{
    protected $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i=0; $i < 10; $i++) { 
            $article = new Article();
            $article->setId(rand(1,100));
            $article->setContent($faker->text() . "'s Article");
            $article->setAuthor($faker->firstName() . $faker->lastName());
            $article->setTitle($faker->firstName(). " " . $article->getAuthor());
            $article->setImage("imgTest");
            $article->setCreatedAt(new DateTimeImmutable($faker->date()));
            $article->setSlug(strtolower($this->slugger->slug($article->getTitle())) . "-");
            $article->setSlug(strtolower($this->slugger->slug($article->getTitle())) . "-" . $article->getId());
            $manager->persist($article);
        }
        $manager->flush();
    }
}
