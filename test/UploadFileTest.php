<?php

namespace test;

use PHPUnit\Framework\TestCase;
use xr0m3oz\urlparser\UploadFile;


class UploadFileTest extends TestCase
{
    public function testUploadSuccess()
    {
        $file = new UploadFile(__DIR__.'/../uploadTest');
        $result = $file->upload('https://www.gettyimages.ie/gi-resources/images/Homepage/Hero/UK/CMS_Creative_164657191_Kingfisher.jpg');

        $this->assertTrue($result);
    }

    public function testUploadPathThrowsException()
    {
        $this->expectExceptionMessage('Нужно указать путь');
        $file = new UploadFile('');
        $file->upload('https://www.gettyimages.ie/gi-resources/images/Homepage/Hero/UK/CMS_Creative_164657191_Kingfisher.jpg');
    }

    public function testUploadUrlThrowsException()
    {
        $this->expectExceptionMessage('Строка не Url');
        $file = new UploadFile(__DIR__.'/../uploadTest');
        $file->upload('Kingfisher.jpg');
    }

    public function testUploadFormatThrowsException()
    {
        $this->expectExceptionMessage('Недопустимый формат файла');
        $file = new UploadFile(__DIR__.'/../uploadTest');
        $file->upload('http://khpi-iip.mipk.kharkiv.edu/library/technpgm/labs/lab06.html');
    }
}