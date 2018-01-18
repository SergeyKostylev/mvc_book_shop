<?php
namespace Framework;



abstract class BaseController
{
    protected $conteiner;

    public function setConteiner(Conteiner $conteiner)
    {
        $this->conteiner =$conteiner;
        return $this;
    }
    public function getRepository($forName)
    {
        return $this->conteiner->get('repositoryFactory')->createRepository($forName);
    }
    public function getRouter()
    {
        return $this
            ->conteiner
            ->get('router');
    }

    protected function render($template, $params=[])
    {


        $twig=$this->conteiner->get('twig');
//        extract($params);

        $path = str_replace('Controller', '', get_class($this));
        $path = trim($path, '\\');
        $path = str_replace('\\', DS, $path);

        $template = $path . DS . $template;
        if (!file_exists(VIEW_DIR . $template)){
            dump($template);
            throw new \Exception("{$template} not to found");
        }

        return $twig->render($template, $params);
    }
}