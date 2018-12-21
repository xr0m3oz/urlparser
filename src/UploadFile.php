<?php

namespace xr0m3oz\urlparser;


class UploadFile
{
    protected $url;
    protected $format = ['image/jpeg','image/png','image/gif'];
    protected $path;

    public function __construct($savePath='/uploads')
    {
        $this->path = $savePath;
    }

    public function upload($urlToImg){
        $this->url = $urlToImg;
        $this->check();

        $imgData = getimagesize($this->url);
        if(!in_array($imgData['mime'],$this->format))
            throw new \Exception('Недопустимый формат файла');

        $img = file_get_contents($this->url);

        if($img === false)
            throw new \Exception('Ошибка загрузки файла');



        if(!file_exists($this->path))
            mkdir($this->path);

        file_put_contents($this->path.'/'.time().'_'.$imgData[2], $img);
    }

    public function changeFormats(array $arr){
        $this->format = $arr;
    }

    protected function check(){
        if(!is_string($this->url)){
            throw new \Exception('Адрес должен быть строкой');
        }

        if(!filter_var($this->url, FILTER_VALIDATE_URL)){
            throw new \Exception('Строка не Url');
        }

        if(!is_string($this->path)){
            throw new \Exception('Путь должен быть строкой');
        }
    }

}