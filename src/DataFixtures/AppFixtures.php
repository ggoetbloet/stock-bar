<?php

namespace App\DataFixtures;


use Faker\Factory;
use App\Entity\User;
use App\Entity\Company;
use App\Entity\Product;
use App\Entity\Storage;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("FR-fr");

        for ($i=0; $i < 1; $i++) { 
            $company = new Company();
            $company->setName('entreprise n°'.$i)
                    ;
                    
                $users =[];
                $genres = ['male', 'female'];

                for ($u=0; $u < 40; $u++) { 
                    $user = new User();
                    $genre = $faker->randomElement($genres);
                
                    $picture = 'https://randomuser.me/api/portraits/';
                    $pictureId = $faker->numberBetween(1, 99).'.jpg';
                    if ($genre == "male") { $picture = $picture.'men/'. $pictureId; }
                    else { $picture = $picture."women/".$pictureId; }
                
                    $hash = $this->encoder->encodePassword($user, 'password');
                
                    $user->setFirstname($faker->firstName($genres))
                        ->setLastname($faker->lastName($genres))
                        ->setEmail($faker->email)
                        ->setHash($hash)
                        ->setPicture($picture)
                        ;
                
                    $manager->persist($user);
                    $users[] = $user;
                }
                
            for ($s=0; $s < mt_rand(1,3); $s++) { 
                $storage = new Storage();
                $storage->setName('stockage '.$s)
                        ->setCompany($company)
                        ;

                $manager->persist($storage);
            }

            for ($c=0; $c < mt_rand(1, 10); $c++) { 
                $category = new Category();
                $category->setName('Categorie n°'.$c)
                        ->setCompany($company)
                        ;
                        
                    for ($p=0; $p < mt_rand(5, 100); $p++) { 
                        $user = $users[mt_rand(0, \count($users) - 1)];

                        $product = new Product();
                        $product->setName('produit C'.$c.' n°'.$p)
                                ->setCompany($company)
                                ->setCategory($category)
                                ->setAuthor($user)
                                ;

                        $manager->persist($product);
                    }

                $manager->persist($category);
            }

            $manager->persist($company);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
