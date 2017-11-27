<?php
/**
 * @category rest.php
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/3/6 10:00
 * @since
 */

/** @var $generator console\modules\tools\generators\rest\Generator */
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

echo "<?php\n";
?>

namespace <?= $generator->getControllerNamespace() ?>;

class <?= StringHelper::basename($controllerClass) ?> extends <?= '\\' . trim($generator->baseClass, '\\') . "\n" ?>
{
    public $modelClass = '<?=$modelClass;?>';

    <?php if($generator->isGenerateSearch()){?>
    public function search(){
        $serarch = new
    }
    <?php}?>
}
