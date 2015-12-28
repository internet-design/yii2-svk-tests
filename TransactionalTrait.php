<?php

namespace svk\tests;

use yii\db\Transaction;
use yii\db\Connection;
use Yii;

/**
 * Трейт для оборачивания каждого теста в транзакции.
 *
 * Перед каждым тестом запускается транзакция БД и откатывается после каждого метода.
 *
 * Подключение к БД берется из метода getDb().
 * По умолчанию используется Yii::$app->db.
 */
trait TransactionalTrait
{
    /**
     * @var Transaction транзакция
     */
    protected $transaction;

    /**
     * Получить подключение к БД
     *
     * @return Connection
     */
    protected function getDb()
    {
        return Yii::$app->db;
    }

    /**
     * Перед тестом запустить транзакцию
     */
    public function beginTransaction()
    {
        if (!$this->transaction) {
            $this->transaction = $this->getDb()->beginTransaction();
        }
    }

    /**
     * Откатить транзакцию после каждого теста
     */
    public function rollBackTransaction()
    {
        $this->transaction->rollBack();
        $this->transaction = null;
    }
}
