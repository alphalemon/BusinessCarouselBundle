<?php

namespace AlphaLemon\Block\BusinessCarouselBundle\Core\ActionManager;

use AlphaLemon\BootstrapBundle\Core\Event\PackageInstalledEvent;
use AlphaLemon\BootstrapBundle\Core\Event\PackageUninstalledEvent;
use AlphaLemon\PageTreeBundle\Core\Tools\AlToolkit;
use AlphaLemon\AlphaLemonCmsBundle\Core\Model\AlBlockQuery;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AlphaLemon\BootstrapBundle\Core\ActionManager\ActionManager;
use Symfony\Component\Filesystem\Filesystem;
use AlphaLemon\AlphaLemonCmsBundle\Core\CommandsProcessor\AlCommandsProcessor;
use AlphaLemon\Block\BusinessCarouselBundle\Core\Repository\AlBusinessCarouselRepositoryPropel;
use AlphaLemon\AlphaLemonCmsBundle\Core\Repository\Propel\AlBlockRepositoryPropel;

/**
 * Executes some actions when a package is installed or uninstalled
 */
class ActionManagerBusinessCarousel extends ActionManager
{
    /**
     * {@inheritdoc]
     */
    public function packageInstalledPostBoot(ContainerInterface $container)
    {
        try
        {
            $sqlFolder = $container->getParameter('kernel.root_dir') . DIRECTORY_SEPARATOR . 'propel' . DIRECTORY_SEPARATOR . 'sql';
            $fs = new Filesystem();
            $fs->remove($sqlFolder);

            $commandProcessor = new AlCommandsProcessor($container->getParameter('kernel.root_dir'));
            $commands = array('propel:model:build --env=alcms_dev' => null, 'propel:sql:build --env=alcms_dev' => null);
            $commandProcessor->executeCommands($commands);

            // Retrieves the CREATE TABLE for the al_app_business_carousel table
            $sqlFile = $sqlFolder . DIRECTORY_SEPARATOR .  'default.sql';           
            if (is_file($sqlFile)) {
                $sql = file_get_contents($sqlFile);
                $query =
                    'CREATE TABLE IF NOT EXISTS `al_app_business_carousel` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `block_id` int(11) NOT NULL,
                        `name` varchar(128) DEFAULT NULL,
                        `surname` varchar(128) DEFAULT NULL,
                        `role` varchar(128) DEFAULT NULL,
                        `content` text NOT NULL,
                        PRIMARY KEY (`id`),
                        KEY `I_BLOCK` (`block_id`)
                    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;';
                preg_match('/CREATE TABLE `al_app_business_carousel[^;]+/s', $sql, $match);
                if (!empty($match)) $query = $match[0];

                $this->executeQuery($query);
            }
        }
        catch(\Exception $ex) {
            throw $ex;
        }
    }

    public function packagUniInstalledPostBoot(ContainerInterface $container)
    {
        // Removes the BusinessCarousel blocks
        $blockRepository = new AlBlockRepositoryPropel();
        $blockRepository->fromClassName('BusinessCarousel', 'delete');

        // Removes the al_app_business_carousel table
        $this->executeQuery('DROP TABLE `al_app_business_carousel`;');
    }

    private function executeQuery($query)
    {
        $orm = new AlBusinessCarouselRepositoryPropel();
        $res = $orm->executeQuery($query);
        if ($res != 1) {
            throw new \RuntimeException('An error occoured when adding the database table for the BusinessCarouselBundle app');
        }
    }
}