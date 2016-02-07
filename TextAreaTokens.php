<?php
namespace mmedojevicbg\TextAreaTokens;

use yii\helpers\Html;
use yii\widgets\InputWidget;

class TextAreaTokens extends InputWidget
{
    /**
     * @var TextAreaTokensAsset
     */
    protected $asset;
    protected $fieldName;
    protected $textAreaId;
    protected $tokenContainerId;
    public $tokens = [];
    public function init()
    {
        parent::init();
        if ($this->hasModel()) {
            $this->fieldName = $this->attribute;
        } else {
            $this->fieldName = $this->name;
        }
        $this->createTextAreaId();
        $this->createTokenContainerId();
    }
    public function run()
    {
        $this->options['id'] = $this->textAreaId;
        if ($this->hasModel()) {
            echo Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textarea($this->name, $this->value, $this->options);
        }
        $this->renderTokens();
        $this->registerClientScript();
    }
    private function renderTokens() {
        echo Html::beginTag('div', ['class' => 'available-tokens',
                                     'id' => $this->tokenContainerId]);
        echo Html::beginTag('div');
        echo 'Available tokens:';
        echo Html::endTag('div');
        foreach($this->tokens as $token) {
            echo Html::beginTag('span', ['class' => 'token']);
            echo '[' . $token . ']';
            echo Html::endTag('span');
        }
        echo Html::endTag('div');
    }
    protected function registerClientScript()
    {
        $view = $this->getView();
        TextAreaTokensAsset::register($view);
        $js = <<<EOT
        $('#$this->tokenContainerId .token').click(function(){
            var token = $(this).html();
            insertAtCaret('$this->textAreaId', token);
        });
EOT;
        $view->registerJs($js);
    }
    private function createTextAreaId() {
        return $this->textAreaId = 'text-area-tokens-' . $this->fieldName;
    }
    private function createTokenContainerId() {
        return $this->tokenContainerId = 'available-tokens-' . $this->fieldName;
    }
}