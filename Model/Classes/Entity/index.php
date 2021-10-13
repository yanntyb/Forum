<?php

require dirname(__FILE__) . '/../../../vendor/autoload.php';

use Djordje\Filebrowser\Repositories\LocalFilesystem;
use Symfony\Component\Filesystem\Filesystem;
use Djordje\Filebrowser\Entity\File;
use Symfony\Component\VarDumper\Dumper;

$repository = new LocalFilesystem(new Filesystem());
$repository->configure(array(
    'location' => dirname(__FILE__)
));

$collection = $repository->ls();

foreach ($collection as $item) {
    /* @var Djordje\Filebrowser\Entity\File $item */
    if(!$item->isDir() && $item->getName() !== 'index.php') {
        $class = str_replace(".php", '', $item->getName());
        echo "<h2>$class</h2>";
        try {
            $reflexion = new ReflectionClass("Yanntyb\App\Model\Classes\Entity\\$class");
        }
        catch (ReflectionException $e) {
            echo $e->getMessage();
        }

        $properties = $reflexion->getProperties();
        foreach($properties as $property) {
            /* @var ReflectionProperty $property */
            echo "Nom: {$property->getName()} - Type: " . ($property->getType()->isBuiltin() ? 'NON fk' : 'fk') . "<br>";
        }
    }
}
