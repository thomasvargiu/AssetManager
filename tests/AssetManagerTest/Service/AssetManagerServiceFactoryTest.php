<?php

namespace AssetManagerTest\Service;

use AssetManager\Resolver\AggregateResolver;
use AssetManager\Resolver\ResolverInterface;
use AssetManager\Service\AssetCacheManager;
use AssetManager\Service\AssetFilterManager;
use AssetManager\Service\AssetManager;
use AssetManager\Service\AssetManagerServiceFactory;
use PHPUnit\Framework\TestCase;
use Laminas\ServiceManager\ServiceManager;

class AssetManagerServiceFactoryTest extends TestCase
{
    public function testCreateService()
    {
        $assetFilterManager = new AssetFilterManager();
        $assetCacheManager = $this->getMockBuilder(AssetCacheManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $serviceManager = new ServiceManager();
        $serviceManager->setService(
            AggregateResolver::class,
            $this->createMock(ResolverInterface::class)
        );

        $serviceManager->setService(
            AssetFilterManager::class,
            $assetFilterManager
        );

        $serviceManager->setService(
            AssetCacheManager::class,
            $assetCacheManager
        );

        $serviceManager->setService('config', array(
                'asset_manager' => array(
                    'Dummy data',
                    'Bacon',
                ),
            ));

        $factory = new AssetManagerServiceFactory();
        $this->assertInstanceOf(AssetManager::class, $factory->createService($serviceManager));
    }
}
