<?php

use app\helpers\Html;

$this->registerWidgetJsFile('tinymce');

$this->registerJs(<<< JS
    new TinyMceWidget({
        widgetId: '{$widgetId}',
        options: {$options},
    }).init();
JS);

$this->registerCss(<<< CSS
    #tinymce-{$widgetId} .tox-tinymce {
        height: {$height} !important;
        max-height: {$height} !important;
    }
CSS);
?>
<div class="tinymce" id="tinymce-<?= $widgetId ?>">
    <?= $textInput ?>
</div>

