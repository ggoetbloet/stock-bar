<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Company;
use App\Entity\Product;
use App\Entity\Storage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i < 5; $i++) { 
            $company = new Company();
            $company->setName('entreprise n°'.$i)
                    ;
            
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
                        $product = new Product();
                        $product->setName('produit C'.$c.' n°'.$p)
                                ->setCompany($company)
                                ->setCategory($category)
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
