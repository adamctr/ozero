<?php

class Autoloader {

    /**
     * Enregistre l'autoloader
     * @return void
     */
    static function register() {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    /**
     * Charge automatiquement une classe
     * @param string $class
     * @return void
     */
    static function autoload($class) {
        // Remplacer les namespaces par des slashes pour le chemin
        $classPath = str_replace('\\', '/', $class);

        // Chemins globaux où chercher les fichiers
        $baseDirs = [
            __DIR__ . '/../routes/',
            __DIR__ . '/../src/',
            __DIR__ . '/../migrations/',
        ];

        // Ajout des chemins dynamiques pour chaque module
        $modulesDir = __DIR__ . '/../modules/';
        $moduleSubDirs = ['controllers', 'views', 'entities', 'models', 'validators'];

        foreach ($baseDirs as $dir) {
            $file = $dir . $classPath . '.php';
            if (file_exists($file)) {
                require $file;
                return;
            }
        }

        // Parcourir les modules
        if (is_dir($modulesDir)) {
            foreach (glob($modulesDir . '*', GLOB_ONLYDIR) as $module) {
                // Vérifier les sous-dossiers du module
                foreach ($moduleSubDirs as $subDir) {
                    $file = $module . '/' . $subDir . '/' . $classPath . '.php';
                    if (file_exists($file)) {
                        require $file;
                        return;
                    }
                }

                // Vérifier les fichiers directement dans le dossier du module
                $moduleRootFile = $module . '/' . $classPath . '.php';
                if (file_exists($moduleRootFile)) {
                    require $moduleRootFile;
                    return;
                }
            }
        }
    }
}
