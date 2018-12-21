<?php

namespace xr0m3oz\urlparser;


/**
 * Class UploadFile
 * @package xr0m3oz\urlparser
 */
class UploadFile
{
    protected $url;
    protected $format = ['image/jpeg', 'image/png', 'image/gif'];
    protected $path;
    protected $imageType;

    public function __construct($savePath = '/uploads')
    {
        $this->path = __DIR__ . '/../../../../' . $savePath;
    }

    /**
     * @param $urlToImg
     * @return bool|int
     * @throws \Exception
     */
    public function upload($urlToImg)
    {
        $this->url = $urlToImg;
        $this->updateImageType();
        $this->check();
        return $this->saveImage();
    }

    /**
     * @return bool
     * @throws \Exception
     */
    protected function saveImage(){
        $img = file_get_contents($this->url);

        if ($img === false) {
            throw new \Exception('Ошибка загрузки файла');
        }

        if (!file_exists($this->path)) {
            mkdir($this->path);
        }

        $result = file_put_contents($this->path . '/' . time() . '.' . $this->imageType, $img);

        return boolval($result);
    }

    /**
     * @return mixed
     */
    protected function updateImageType()
    {
        $imgData = getimagesize($this->url);
        $this->imageType = explode('/', $imgData['mime'])[1];

        return $this->imageType;
    }

    /**
     * @throws \Exception
     */
    protected function check()
    {
        if (!is_string($this->url)) {
            throw new \Exception('Адрес должен быть строкой');
        }

        if (!filter_var($this->url, FILTER_VALIDATE_URL)) {
            throw new \Exception('Строка не Url');
        }

        if (!is_string($this->path)) {
            throw new \Exception('Путь должен быть строкой');
        }

        if (!in_array('image/' . $this->imageType, $this->format)) {
            throw new \Exception('Недопустимый формат файла');
        }
    }

}