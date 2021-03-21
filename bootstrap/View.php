<?php


namespace Bootstrap;


class View
{
    const FOLDER = __DIR__ . "/../resources/views";
    const DS = DIRECTORY_SEPARATOR;
    const FILE_EXTENSION = ".php";

    public function render(string $view, array $data)
    {
        $view = self::FOLDER . self::DS . $view . self::FILE_EXTENSION;
        if (file_exists($view)) {
            echo $this->getView($view, $data);
        } else {
            echo 'mavjud emas';
        }
    }

    private function getView(string $view, $data)
    {
        ob_start();
        extract($data);
        include_once $view;
        return ob_get_clean();
    }

//    private function getLayout()
//    {
//        //
//    }
}