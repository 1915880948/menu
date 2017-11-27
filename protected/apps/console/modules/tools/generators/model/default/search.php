<?php
/**
 * This is the template for generating CRUD search class of the specified model.
 */

use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator console\modules\tools\generators\model\Generator */

$modelClass = StringHelper::basename($modelClassName);
$searchModelClass = StringHelper::basename($searchClassName);
if ($modelClass === $searchModelClass) {
    $modelAlias = $modelClass . 'Model';
}
$rules = $generator->generateSearchRules($modelClassName);
$labels = $generator->generateSearchLabels($modelClassName);
$searchAttributes = $generator->getSearchAttributes($modelClassName);
$searchConditions = $generator->generateSearchConditions($modelClassName);

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($searchClassName, '\\')) ?>;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use <?= ltrim($modelClassName, '\\') . (isset($modelAlias) ? " as $modelAlias" : "") ?>;

/**
 * <?= $searchModelClass ?> represents the model behind the search form about `<?= $modelClassName ?>`.
 */
class <?= $searchModelClass ?> extends <?= isset($modelAlias) ? $modelAlias : $modelClass ?>

{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            <?= implode(",\n            ", $rules) ?>,
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params = [])
    {
        $query = <?= isset($modelAlias) ? $modelAlias : $modelClass ?>::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        <?= implode("\n        ", $searchConditions) ?>

        return $dataProvider;
    }
}
