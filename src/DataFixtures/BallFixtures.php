<?php

namespace App\DataFixtures;

use App\Entity\Ball;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BallFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $time = new \DateTimeImmutable();
        $balls = [
            'Poké Ball' => 'images/ball/poke.png',
            'Super Ball' => 'images/ball/great.png',
            'Hyper Ball' => 'images/ball/ultra.png',
            'Master Ball' => 'images/ball/master.png',
            'Honor Ball' => 'images/ball/premier.png',
            'Safari Ball' => 'images/ball/safari.png',
            'Appât Ball' => 'images/ball/lure.png',
            'Compét\'Ball' => 'images/ball/poke.png',
            'Copain Ball' => 'images/ball/sport.png',
            'Love Ball' => 'images/ball/love.png',
            'Lune Ball' => 'images/ball/moon.png',
            'Masse Ball' => 'images/ball/heavy.png',
            'Niveau Ball' => 'images/ball/level.png',
            'Speed Ball' => 'images/ball/fast.png',
            'Bis Ball' => 'images/ball/repeat.png',
            'Chrono Ball' => 'images/ball/timer.png',
            'Faiblo Ball' => 'images/ball/nest.png',
            'Filet Ball' => 'images/ball/net.png',
            'Luxe Ball' => 'images/ball/luxury.png',
            'Scuba Ball' => 'images/ball/dive.png',
            'Mémoire Ball' => 'images/ball/cherish.png',
            'Rapide Ball' => 'images/ball/quick.png',
            'Soin Ball' => 'images/ball/heal.png',
            'Sombre Ball' => 'images/ball/dusk.png',
            'Rêve Ball' => 'images/ball/dream.png',
            'Ultra Ball' => 'images/ball/beast.png',
            'Étrange Ball' => 'images/ball/strange.png',
        ];

        foreach ($balls as $name => $image) {
            $ball = (new Ball())
                ->setName($name)
                ->setImage($image)
                ->setIsOnline(true)
                ->setCreatedAt($time)
                ->setUpdatedAt($time)
            ;
            $manager->persist($ball);
        }

        $hisui = [
            'Poké Ball' => 'images/ball/hisuian-poke.png',
            'Super Ball' => 'images/ball/hisuian-great.png',
            'Hyper Ball' => 'images/ball/hisuian-ultra.png',
            'Masse Ball' => 'images/ball/hisuian-heavy.png',
            'Mégamasse Ball' => 'images/ball/leaden.png',
            'Gigamasse Ball' => 'images/ball/gigaton.png',
            'Plume Ball' => 'images/ball/feather.png',
            'Envol Ball' => 'images/ball/wing.png',
            'Propulse Ball' => 'images/ball/jet.png',
            'Origine Ball' => 'images/ball/origin.png',
        ];

        foreach ($hisui as $name => $image) {
            $ball = (new Ball())
                ->setName($name)
                ->setImage($image)
                ->setIsOnline(true)
                ->setCreatedAt($time)
                ->setUpdatedAt($time)
            ;
            $manager->persist($ball);
        }

        $manager->flush();
    }
}
