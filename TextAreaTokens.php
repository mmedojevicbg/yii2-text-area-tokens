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
                                      'data-textareaname' => $this->fieldName]);
        echo Html::beginTag('div');
        echo 'Available tokens:';
        foreach($this->tokens as $token) {
            echo Html::beginTag('span', ['class' => 'token']);
            echo '[' . $token . ']';
            echo Html::endTag('span');
        }
        echo Html::endTag('div');
        echo Html::endTag('div');
    }
    protected function registerClientScript()
    {
        $view = $this->getView();
        $js = <<<EOT
        function insertAtCaret(areaId,text) {
            var txtarea = document.getElementById(areaId);
            var scrollPos = txtarea.scrollTop;
            var strPos = 0;
            var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ?
                'ff' : (document.selection ? 'ie' : false ) );
            if (br == 'ie') {
                txtarea.focus();
                var range = document.selection.createRange();
                range.moveStart ('character', -txtarea.value.length);
                strPos = range.text.length;
            }
            else if (br == 'ff') strPos = txtarea.selectionStart;

            var front = (txtarea.value).substring(0,strPos);
            var back = (txtarea.value).substring(strPos,txtarea.value.length);
            txtarea.value=front+text+back;
            strPos = strPos + text.length;
            if (br == 'ie') {
                txtarea.focus();
                var range = document.selection.createRange();
                range.moveStart ('character', -txtarea.value.length);
                range.moveStart ('character', strPos);
                range.moveEnd ('character', 0);
                range.select();
            }
            else if (br == 'ff') {
                txtarea.selectionStart = strPos;
                txtarea.selectionEnd = strPos;
                txtarea.focus();
            }
            txtarea.scrollTop = scrollPos;
        }
        $('.available-tokens .token').click(function(){
            var token = $(this).html();
            insertAtCaret('$this->textAreaId', token);
        });
EOT;
        $view->registerJs($js);
    }
    private function createTextAreaId() {
        return $this->textAreaId = 'text-area-tokens-' . $this->fieldName;
    }
}