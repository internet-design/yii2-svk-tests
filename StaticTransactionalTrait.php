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
trait StaticTransactionalTrait
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
    protected static function getStaticDb()
    {
        return Yii::$app->db;
    }

    /**
     * Запуск статической транзакции
     */
    public static function beginStaticTransaction()
    {
        if (!self::$staticTransaction) {
            static::$staticTransaction = static::getDb()->beginTransaction();
        }
    }

    /**
     * Откат статической транзакции
     */
    public static function rollBackStaticTransaction()
    {
        static::$staticTransaction->rollBack();
        static::$staticTransaction = null;
    }
}
