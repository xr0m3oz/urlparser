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

    /**
     * UploadFile constructor.
     * @param $savePath (example __DIR__.'/uploads')
     */
    public function __construct(string $savePath)
    {
        $this->path = $savePath;
    }

    /**
     * @param $urlToImg
     * @return bool|int
     * @throws \Exception
     */
    public function upload(string $urlToImg) : bool
    {
        $this->url = $urlToImg;

        if (!filter_var($this->url, FILTER_VALIDATE_URL)) {
            throw new \Exception('Строка не Url');
        }

        if (empty($this->path)) {
            throw new \Exception('Нужно указать путь');
        }

        $this->updateImageType();

        return $this->saveImage();
    }

    /**
     * @return bool
     * @throws \Exception
     */
    protected function saveImage(): bool {
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

        if (!in_array('image/' . $this->imageType, $this->format)) {
            throw new \Exception('Недопустимый формат файла');
        }

        return $this->imageType;
    }
}