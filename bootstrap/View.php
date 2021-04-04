<?php

namespace Bootstrap;

use Exception;

class View
{
    const FOLDER = __DIR__ . "/../resources";
    const LAYOUT_FOLDER = self::FOLDER . self::DS . 'layouts';
    const DS = DIRECTORY_SEPARATOR;
    const FILE_EXTENSION = ".php";

    public $layout = 'app';

    /**
     * @param string $view
     * @param array $data
     * @throws Exception
     */
    public function render(string $view, array $data)
    {
        $view = self::FOLDER . self::DS . 'views' . self::DS . $view . self::FILE_EXTENSION;
        $layout = self::LAYOUT_FOLDER . self::DS . $this->layout . self::FILE_EXTENSION;

        if (!file_exists($layout))
            throw new Exception("%s layout was not found on the server", $layout);

        if (file_exists($view))
            echo $this->getLayout($layout, $view, $data);
        else
            throw new Exception(
                sprintf("%s view was not found on the server", $view)
            );
    }

    /**
     * @param string $view
     * @param $data
     * @return false|string
     */
    private function getView(string $view, $data)
    {
        ob_start();
        extract($data);
        include_once $view;
        return ob_get_clean();
    }

    /**
     * @param $view
     * @param $data
     * @return false|string
     */
    public function getLayout($layout, $view, $data)
    {
        ob_start();
        $content = $this->getView($view, $data);
        include_once $layout;
        return ob_get_clean();
    }
}
