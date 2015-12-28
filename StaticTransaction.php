<?php
namespace svk\tests;

use Yii;
use yii\db\Connection;
use yii\db\Transaction;

/**
 * Оборачивает все тесты внутри кейса в транзакцию.
 * По завершению всех тестов откатывает транзакцию.
 *
 * Подключение к БД берется из метода getDb.
 * По умолчанию - подключение из Yii::$app->db.
 */
trait StaticTransaction
{
    /**
     * @var Transaction транзакция
     */
    protected static $staticTransaction;

    /**
     * Получить подключение
     *
     * @return Connection
     */
    protected static function getDb()
    {
        return Yii::$app->db;
    }

    /**
     * Действия перед запуском всех тестов
     */
    public static function setUpBeforeClass()
    {
        static::$staticTransaction = static::getDb()->beginTransaction();
        parent::setUpBeforeClass();
    }

    /**
     * Действия после запуска всех тестов
     */
    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();
        static::$staticTransaction->rollBack();
    }
}
