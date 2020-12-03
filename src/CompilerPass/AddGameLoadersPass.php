<?php

namespace App\CompilerPass;

use App\Game\WordList;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AddGameLoadersPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container): void
    {
        $definition = $container->getDefinition(WordList::class);

        $loaders = $container->findTaggedServiceIds('app.game_loader');

        foreach ($loaders as $loader => $attrs) {
            $definition->addMethodCall('addLoader', [new Reference($loader)]);
        }
    }
}

