<?php
/**
 * @category Generator
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/7/16 11:28
 * @since
 */
namespace console\modules\tools\generators\basemodel;

use console\modules\tools\components\CodeFile;
use yii\helpers\Console;
use yii\helpers\Inflector;

/**
 * Class Generator
 * @package console\modules\tools\generators\basemodel
 */
class Generator extends \console\modules\tools\components\Generator
{
    public $db = 'db';
    public $ns;
    public $modelNs;
    /**
     * keywords
     */
    protected $keywords = [
        '__halt_compiler',
        'abstract',
        'and',
        'array',
        'as',
        'break',
        'callable',
        'case',
        'catch',
        'class',
        'clone',
        'const',
        'continue',
        'declare',
        'default',
        'die',
        'do',
        'echo',
        'else',
        'elseif',
        'empty',
        'enddeclare',
        'endfor',
        'endforeach',
        'endif',
        'endswitch',
        'endwhile',
        'eval',
        'exit',
        'extends',
        'final',
        'for',
        'foreach',
        'function',
        'global',
        'goto',
        'if',
        'implements',
        'include',
        'include_once',
        'instanceof',
        'insteadof',
        'interface',
        'isset',
        'list',
        'namespace',
        'new',
        'or',
        'print',
        'private',
        'protected',
        'public',
        'require',
        'require_once',
        'return',
        'static',
        'switch',
        'throw',
        'trait',
        'try',
        'unset',
        'use',
        'var',
        'while',
        'xor'
    ];

    /**
     * @return string
     */
    public function getName()
    {
        return 'Generate the base model extends from TblModel';
    }

    public function rules()
    {
        return [
            [['db', 'modelNs', 'ns'], 'required']
        ];
    }

    public function attributeLabels()
    {
        return [
            'db'      => 'Db Connection Components',
            'ns'      => 'Generate File Namespace',
            'modelNs' => 'model Namespace ',
        ];
    }

    public function generate()
    {
        $tblPath = $this->parseModelNs();
        if(!$tblPath){
            Console::output("目录 {$this->modelNs } 不存在", Console::FG_RED);
            return [];
        }
        $appNames = explode('\\',$this->modelNs);
        $appName = ucfirst($appNames[0]);
        $files = [];

        foreach(glob($tblPath . "/*") as $item){
            if(is_dir($item)){
                continue;
            }
            $fileName = str_replace(['Tbl'], '', basename($item));
            if(in_array(strtolower($fileName) , $this->keywords) ){
                // $fileName = $appName . $fileName;
                $fileName = Inflector::pluralize($fileName);
            }
            //fileClassName
            $params = [
                'extendsClassName' => basename($item, '.php'),
                'className'        => basename($fileName, '.php'),
            ];
            $codeFile = \Yii::getAlias('@' . ltrim(str_replace("\\", "/", $this->ns), '/')) . '/' . $fileName;
            if(file_exists($codeFile)){
                continue;
            }
            $files[] = new CodeFile($codeFile, $this->render('model.php', $params));
        }

        return $files;
    }

    protected function parseModelNs()
    {
        $path = \Yii::getAlias('@' . ltrim(str_replace("\\", "/", $this->modelNs), '/'));
        if(is_dir($path)){
            return $path;
        }
        return false;
    }
}
