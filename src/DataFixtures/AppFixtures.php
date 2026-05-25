<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $electronics = new Category();
        $electronics->setName('Electronics');
        $electronics->setDescription('Headphones, speakers, gadgets and more');
        $manager->persist($electronics);

        $fashion = new Category();
        $fashion->setName('Fashion');
        $fashion->setDescription('Clothing, accessories and footwear');
        $manager->persist($fashion);

        $garden = new Category();
        $garden->setName('Home & Garden');
        $garden->setDescription('Furniture, decor and gardening tools');
        $manager->persist($garden);

        $p1 = new Product();
        $p1->setTitle('Wireless Headphones');
        $p1->setSellPrice(79.99);
        $p1->setCategory($electronics);
        $p1->setImage('airbod.png');
        $manager->persist($p1);

        $p2 = new Product();
        $p2->setTitle('Bluetooth Speaker');
        $p2->setSellPrice(59.99);
        $p2->setCategory($electronics);
        $p2->setImage('thumbnail.png');
        $manager->persist($p2);

        $p3 = new Product();
        $p3->setTitle('Classic Leather Jacket');
        $p3->setSellPrice(149.99);
        $p3->setCategory($fashion);
        $p3->setImage('item.png');
        $manager->persist($p3);

        $p4 = new Product();
        $p4->setTitle('Smart Plant Sensor');
        $p4->setSellPrice(34.99);
        $p4->setCategory($garden);
        $p4->setImage('item.png');
        $manager->persist($p4);

        $p5 = new Product();
        $p5->setTitle('Yoga Mat Premium');
        $p5->setSellPrice(29.99);
        $p5->setCategory($garden);
        $p5->setImage('item.png');
        $manager->persist($p5);

        $p6 = new Product();
        $p6->setTitle('Mechanical Keyboard');
        $p6->setSellPrice(89.99);
        $p6->setCategory($electronics);
        $p6->setImage('mouse.png');
        $manager->persist($p6);

        $manager->flush();
    }
}