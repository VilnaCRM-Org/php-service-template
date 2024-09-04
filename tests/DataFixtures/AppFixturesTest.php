<?php

declare(strict_types=1);

namespace App\Tests\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use PHPUnit\Framework\TestCase;

final class AppFixturesTest extends TestCase
{
    public function load(ObjectManager $manager): void
    {
        $manager->flush();
    }

    public function testLoad(): void
    {
        $managerMock = $this->getMockBuilder(
            ObjectManager::class
        )->disableOriginalConstructor()->getMock();
        $managerMock
            ->expects($this->once())
            ->method('flush');
        $fixture = new AppFixtures();
        $fixture->load($managerMock);
    }
}
