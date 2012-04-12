<?php

namespace AlphaLemon\ElFinderBundle\Composer;

use Composer\Script\Event;
use Symfony\Component\Process\Process;

class ScriptHandler
{
    public static function setupDatabase($event)
    {
        
        $options = self::getOptions($event);
        $appDir = $options['symfony-app-dir'];

        if (!is_dir($appDir)) {
            echo 'The symfony-app-dir ('.$appDir.') specified in composer.json was not found in '.getcwd().', can not clear the cache.'.PHP_EOL;
            return;
        }

        static::executeCommand($appDir, 'propel:build-model');
        
        /*
        $connection = new \PropelPDO($input->getArgument('dsn'), $input->getOption('user'), $input->getOption('password'));
        
        $queries = array('TRUNCATE al_block;',
                        );
        
        foreach($queries as $query)
        {
            $statement = $connection->prepare($query);
            $statement->execute();
        }*/
    }
    
    protected static function executeCommand($appDir, $cmd)
    {
        $phpFinder = new PhpExecutableFinder;
        $php = escapeshellarg($phpFinder->find());
        $console = escapeshellarg($appDir.'/console');

        $process = new Process($php.' '.$console.' '.$cmd);
        $process->run(function ($type, $buffer) { echo $buffer; });
    }
}
