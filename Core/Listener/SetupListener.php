<?php

namespace AlphaLemon\Block\BusinessCarouselBundle\Core\Listener; 

use AlphaLemon\BootstrapBundle\Core\Event\PackageInstalledEvent;
use AlphaLemon\BootstrapBundle\Core\Event\PackageUninstalledEvent;
use AlphaLemon\PageTreeBundle\Core\Tools\AlToolkit;
use AlphaLemon\AlphaLemonCmsBundle\Core\Model\AlBlockQuery;

/**
 * Executes some actions when a package is installed or uninstalled
 */
class SetupListener 
{
    private $queries = array('DROP TABLE al_app_business_carousel;',);
    
    /**
     * The action performed when the BusinessCarousel package is installed
     * 
     * @param PackageInstalledEvent $event 
     */
    public function onPackageInstalled(PackageInstalledEvent $event)
    {
        $container = $event->getContainer();
        if ($container->has('propel.configuration')) {
            ob_start();
            $connection = $this->getPropelConnection($container);

            // Sets phing include path
            set_include_path($container->getParameter('kernel.root_dir').'/..'.PATH_SEPARATOR.$container->getParameter('propel.phing_path').'/classes'.PATH_SEPARATOR.get_include_path());

            // Builds the sql
            AlToolkit::executeCommand($container->get('kernel'), 'propel:build-sql');        

            // Retrieves the CREATE TABLE for the al_app_business_carousel table
            $sqlFile = $container->getParameter('kernel.root_dir') . DIRECTORY_SEPARATOR . 'propel' . DIRECTORY_SEPARATOR . 'sql' . DIRECTORY_SEPARATOR . $this->connectionName . '.sql';
            $sql = file_get_contents($sqlFile);
            preg_match('/CREATE TABLE `al_app_business_carousel[^;]+/s', $sql, $match);
            if (!empty($match)) {
                $this->queries[] = $match[0];
            } else {
                $this->queries[] =  'CREATE TABLE IF NOT EXISTS `al_app_business_carousel` (
                                      `id` int(11) NOT NULL AUTO_INCREMENT,
                                      `block_id` int(11) NOT NULL,
                                      `name` varchar(128) DEFAULT NULL,
                                      `surname` varchar(128) DEFAULT NULL,
                                      `role` varchar(128) DEFAULT NULL,
                                      `content` text NOT NULL,
                                      PRIMARY KEY (`id`),
                                      KEY `I_BLOCK` (`block_id`)
                                    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;';
            }

            $this->executeQueries($connection, $this->queries);

            // Builds the model
            AlToolkit::executeCommand($container->get('kernel'), 'propel:build-model');
            
            // Executes silently its job
            ob_end_clean();
            
            $event->setSuccess(true);
        }
        
        return $event;
    }

    /**
     * The action performed when the BusinessCarousel package is uninstalled
     * 
     * @param PackageUninstalledEvent $event 
     */
    public function onPackageUninstalled(PackageUninstalledEvent $event)
    {
        // Removes the BusinessCarousel blocks
        AlBlockQuery::create()->filterByClassName('BusinessCarousel')->delete();
        
        // Removes the al_app_business_carousel table
        $container = $event->getContainer();
        $connection = $this->getPropelConnection($container);
        $this->executeQueries($connection, $this->queries);
    }
    
    private function getPropelConnection($container)
    {
        $propelConfiguration = $container->get('propel.configuration');
        $this->connectionName = $container->getParameter('propel.dbal.default_connection');
        if (isset($propelConfiguration['datasources'][$this->connectionName])) {
            $defaultConfig = $propelConfiguration['datasources'][$this->connectionName];
        } else {
            throw new \InvalidArgumentException(sprintf('Connection named %s doesn\'t exist', $this->connectionName));
        }
        
        $connectionParams = $defaultConfig['connection'];
        return new \PropelPDO($connectionParams['dsn'], $connectionParams['user'], $connectionParams['password']);
    }
    
    private function executeQueries(\PropelPDO $connection, array $queries)
    {
        // Excecutes the queries
        foreach($queries as $query)
        {
            $statement = $connection->prepare($query);
            $statement->execute();
        }
    }
}