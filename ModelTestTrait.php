<?php
namespace svk\tests;

use yii\base\Model;

/**
 * Тестирование модели.
 *
 * Прогоняет через тесты всевозможные правила валидации (ошибочные и нет).
 * Каждый атрибут может принимать возможные значения из массива, и флаг "isValid", указывающий на валидность значения.
 *
 * Пример:
 *
 * ```php
 * public function testMe()
 * {
 *     $attributes = [
 *         'email' => [
 *             [
 *                 'value' => null,
 *                 'isValid' => false,
 *             ],
 *             [
 *                 'value' => 'test@email.com',
 *                 'isValid' => true,
 *             ],
 *         ],
 *         'name' => [
 *             [
 *                 'value' => false,
 *                 'isValid' => false,
 *             ],
 *             [
 *                 'value' => 'valid name',
 *                 'isValid' => true,
 *             ],
 *         ],
 *         'emai
 *     ];
 * }
 * ```
 */
trait ModelTestTrait
{
    /**
     * Валидация атрибутов.
     *
     * На вход передается модель для валидации и массив значений для валидации.
     * Массив значений должен иметь следующий формат:
     * ```php
     * array(
     *     '<attribute1>' => array(
     *         array(
     *             'value' => <mixed>, // значение для валидации
     *             'isValid' => <boolean>, // true, если значение должно проходить валидацию
     *         ),
     *     ),
     * )
     * ```
     *
     * Проверяет, что атрибут либо должен проходить проверку валидации, либо не должен.
     *
     * @param Model $model проверяемая модель
     * @param array $attributes массив значений атрибутов для валидации
     */
    protected function validateAttributes(Model $model, $attributes)
    {
        foreach ($attributes as $attribute => $values) {
            $attributeTitle = $model->getAttributeLabel($attribute);
            foreach ($values as $v) {
                $value = $v['value'];
                $isValid = $v['isValid'];
                $model->{$attribute} = $value;

                if ($isValid) {
                    $message = $attributeTitle . ' validation error: ' . implode("\n", $model->getErrors($attribute));
                    $message .= "\nAsserting value: " . print_r($value, true);
                    $this->assertTrue($model->validate([$attribute]), $message);
                }
                else {
                    $message = $attributeTitle . ' must be invalid' . "\n";
                    $message .= 'Asserting value: ' . print_r($value, true);
                    $this->assertFalse($model->validate([$attribute]), $message);
                }
            }
        }

    }
}
