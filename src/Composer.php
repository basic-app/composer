<?php
declare(strict_types=1);
/**
 * @author Basic App Dev Team
 * @license MIT
 */
namespace BasicApp\Composer;

use Composer\Installer\LibraryInstaller;

class Composer extends LibraryInstaller
{
    public static function postCreateProject($event)
    {        
        static::runCommands($event, __METHOD__);
    }

    public static function postInstall($event)
    {
        static::runCommands($event, __METHOD__);
    }

    public static function postUpdate($event)
    {
        static::runCommands($event, __METHOD__);
    }

    protected static function runCommands($event, $extraKey)
    {
        $params = $event->getComposer()->getPackage()->getExtra();
  
        if (isset($params[$extraKey]) && is_array($params[$extraKey]))
        {
            foreach ($params[$extraKey] as $method => $args)
            {
                call_user_func_array([__CLASS__, $method], (array) $args);
            }
        }
    }

    protected static function copy($files)
    {
        foreach($files as $source => $target)
        {
            copy($source, $target);

            echo '  - Copy ' . $source . ' to ' . $target . "\n";
        }
    }

    protected static function setPermissions($files)
    {
        foreach($files as $file => $permissions)
        {
            chmod($file, octdec($permissions));  
            
            echo '  - Set ' . $permissions . ' permissions to ' . $file . "\n";
        }
    }
}