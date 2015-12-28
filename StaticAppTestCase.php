<?php
namespace svk\tests;

use yii\codeception\TestCase as BaseTestCase;

/**
 * Расширение TestCase из yii2-codeception.
 *
 * По умолчанию кейс в yii2-codeception пересоздает приложение перед каждым тестом.
 * Все приложение должно создаваться в bootstrap-файле, соответственно в этом классе
 * методы mockApplication и destroyApplication переопределны таким образом, что
 * кейс не создает и не дестроит приложение
 */
class StaticAppTestCase extends BaseTestCase
{
    /**
     * @inheridoc
     */
    protected function mockApplication($config = null)
    {
        // приложение создается в bootstrap-файле
        // в рамках этого метода приложение не создаем
    }

    /**
     * @inheridoc
     */
    protected function destroyApplication()
    {
        // в этом классе не создается приложение,
        // соответственно не дестроим его здесь
    }
}
