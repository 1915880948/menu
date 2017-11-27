<?php
/**
 * This is the template for generating the model class of a specified table.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $queryClassName string query class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */

echo "<?php\n";
?>

namespace <?= ltrim($generator->ns,'\\') ?>;
use Yii;
use <?= ltrim($generator->modelNs , '\\'). '\\'.$extendsClassName ;?> ;

/**
 * This is the model class for tableClass "<?= $extendsClassName ?>".
 * className <?= $className."\n" ?>
 * @package <?= $generator->ns."\n" ?>
 */
class <?= $className ?> extends <?= $extendsClassName . "\n" ?>
{

}
