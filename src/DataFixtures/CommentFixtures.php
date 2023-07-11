<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture 
{

    public function load(ObjectManager $manager): void
    {
        for($i=0 ; $i <= 10 ; $i++ ){
            $comment = (new Comment())
            ->setText('le commentaire n° ' . $i)
            ->setScore(strval(rand(1, 5)))
            ->setReleasedAt(new DateTimeImmutable());

            $manager->persist($comment);
            
        }

        $manager->flush();
    }
}
