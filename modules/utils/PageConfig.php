<?php
class PageConfig
{
    private array $cssPaths;
    private array $jsPaths;


    public function __construct(?array $jsFilesNames = null, ?array $cssFilesNames = null) {
        $cssFilesNames = $cssFilesNames ?? [];
        $jsFilesNames = $jsFilesNames ?? [];

        $cssFilesPaths = [];
        $jsFilesPaths = [];

        // Par défaut, on ajoute defaultcss dans toutes les pages
        $defaultCssFilesNames = ['style', 'output'];
        $defaultJsFilesNames = ['index'];

        if (APP_ENV === 'production') {
            // Default files
            forEach($defaultCssFilesNames as $defaultCssFilesName) {
                array_push($cssFilesPaths, 'assets/minified/' . $defaultCssFilesName . '.min.css');
            }

            forEach($defaultJsFilesNames as $defaultJsFilesName) {
                array_push($jsFilesPaths, 'scripts/' . $defaultJsFilesName . '.min.js');
            }
            //
            forEach($cssFilesNames as $cssFileName) {
                array_push($cssFilesPaths, 'assets/minified/' . $cssFileName . '.min.css');
            }
            forEach($jsFilesNames as $jsFileName) {
                array_push($jsFilesPaths, 'assets/minified/' . $jsFileName . '.min.js');
            }

        } else {
            // Default files
            forEach($defaultCssFilesNames as $defaultCssFilesName) {
                array_push($cssFilesPaths, 'style/' . $defaultCssFilesName . '.css');
            }

            forEach($defaultJsFilesNames as $defaultJsFilesName) {
                array_push($jsFilesPaths, 'scripts/' . $defaultJsFilesName . '.js');
            }

            //
            forEach($cssFilesNames as $cssFileName) {
                array_push($cssFilesPaths, 'style/' . $cssFileName . '.css');
            }
            forEach($jsFilesNames as $jsFileName) {
                array_push($jsFilesPaths, 'scripts/' . $jsFileName . '.js');
            }
        }

        $this->cssPaths = $cssFilesPaths;
        $this->jsPaths = $jsFilesPaths;
    }

    public function getCssPaths()
    {
        return $this->cssPaths;
    }

    public function getJsPaths()
    {
        return $this->jsPaths;
    }
}
