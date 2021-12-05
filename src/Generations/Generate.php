<?php

namespace DNT\Permission\Generations;

use Illuminate\Support\Facades\File;

class Generate
{
    protected static $instance;
    protected $commondData;

    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new static;
        }
        return self::$instance;
    }

    protected function getViewPath()
    {
        return trim(config('permission.publish_path.views', resource_path('views/')), '/') . '/';
    }

    protected function getControllerPath()
    {
        return trim(config('permission.publish_path.controller', app_path('Http/Controllers/')), '/') . '/';
    }


    protected function getViewsPrefix(): string
    {
        $viewRootPath = resource_path('views/');
        $viewPath = $this->getViewPath();
        $viewFolder = trim(str_replace($viewRootPath, '', $viewPath), '/');
        return !empty($viewFolder) ? ($viewFolder . '.') : '';
    }

    public function getCommonData()
    {
        if (!$this->commondData) {
            return [
                '$VIEW_PREFIX$' => $this->getViewsPrefix(),
                '$LAYOUT$' => config('permission.layout', 'layouts.app'),
                '$NAMESPACE_CONTROLLER$' => config('permission.namespace_controller', 'App\Http\Controllers\Admin'),
            ];
        }
        return $this->commondData;
    }

    public function getStubPath($stubFile)
    {
        return $this->getPackagePath() . 'Generations/Stubs/' . $stubFile;
    }


    public function fillDataStubFile($stubFile, array $data = [])
    {
        $filePath = $this->getStubPath($stubFile);
        $template = '';
        if (file_exists($filePath)) {
            $data = array_merge($data, $this->getCommonData());
            $template = file_get_contents($filePath);
            $template = str_replace(array_keys($data), array_values($data), $template);
        } else {
            $this->throwMessage('file not found : ' . $filePath);
        }
        return $template;

    }

    public function getPackagePath()
    {
        return trim(config('permission.path.package', app_path('vendor/dungnt1312/dnt-permission/src/')), '/') . '/';
    }

    public function compileControllers(array $controllers)
    {
        $controllerPath = $this->getControllerPath();
        foreach ($controllers as $stubFile => $file) {
            $filePath = $controllerPath . $file;
            $templateData = $this->fillDataStubFile($stubFile);
            $this->fillFile($filePath, $templateData);
        }
    }

    public function compileViews(array $views)
    {
        $viewsPrefix = $this->getViewsPrefix();
        foreach ($views as $stubFile => $file) {
            $filePath = $this->getViewPath() . $file;
            $templateData = $this->fillDataStubFile($stubFile);
            $this->fillFile($filePath, $templateData);
        }
    }

    public function appendRoutes(array $routes)
    {
        foreach ($routes as $stubFile => $file) {
            $templateData = $this->fillDataStubFile($stubFile);
            $this->appendFile(base_path($file), $templateData);
        }
    }

    public function createDirIfNotExist($path)
    {

        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
    }


    public function fillFile($filePath, $templateData)
    {
        $this->createDirIfNotExist(File::dirname($filePath));
        File::put($filePath, $templateData);
    }

    public function appendFile($filePath, $templateData)
    {
        if (file_exists($filePath)) {
            File::append($filePath, $templateData);
        }
    }

    protected function throwMessage($message)
    {
        echo $message . PHP_EOL;
    }
}
