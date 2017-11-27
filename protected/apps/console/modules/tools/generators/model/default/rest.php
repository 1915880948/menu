<?php
/**
 * @category rest.php
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/3/6 10:00
 * @since
 */

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

echo "<?php\n";
?>

namespace <?= $generator->getControllerNamespace() ?>;

class <?= StringHelper::basename($generator->controllerClass) ?> extends <?= '\\' . trim($generator->baseClass, '\\') . "\n" ?>
{
    public $modelClass = '<?=$generator->modelClass;?>';

<?php foreach ($generator->getActionIDs() as $action): ?>
    public function action<?= Inflector::id2camel($action) ?>()
    {
        return $this->render('<?= $action ?>');
    }
<?php endforeach; ?>
}
