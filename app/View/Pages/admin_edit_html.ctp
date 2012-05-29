<?php echo $this->element('page_edit_top'); ?>
<?php echo $this->Form->input('html', array('id' => 'page-html-content')); ?>
<div id="html-editor" class="code-editor"><?php echo $this->data['Page']['html']; ?></div>
<?php if (!empty($this->data['Page']['js'])): ?>
<?php echo $this->Form->input('js', array('id' => 'page-js-content')); ?>
<div id="js-editor" class="code-editor"><?php echo $this->data['Page']['js']; ?></div>		
<?php endif ?>
<?php echo $this->element('page_edit_bottom'); ?>
<?php 
echo $this->Html->script(array('ace/src/ace', 'ace/src/theme-twilight', 'ace/src/mode-html', 'ace/src/mode-javascript'), array('inline' => false));
echo $this->Html->scriptBlock(
	"window.onload = function() {
		if (!leimi.isMobile) {
	        var htmlEditor = ace.edit('html-editor');
	        var HtmlMode = require('ace/mode/html').Mode;
	        htmlEditor.setTheme('ace/theme/twilight');
			htmlEditor.getSession().setMode(new HtmlMode());
			htmlEditor.setShowPrintMargin(false);
			htmlEditor.getSession().setUseWrapMode(true);
			document.getElementById('html-editor').style.fontSize='14px';
			document.getElementById('html-editor').style.fontFamily=\"'Monaco for Powerline', 'Monaco', 'Menlo', 'Ubuntu Mono', 'Droid Sans Mono', 'Courier New', monospace\";
			//everything typed in the ace editor goes in the form 'html' textarea
			//people without JS can simply type HTML in the textarea
			$('#page-html-content').parent().addClass('hidden');
			htmlEditor.getSession().on('change', function() {
				$('#page-html-content').val(htmlEditor.getSession().getValue());
			});

			var jsEditor = ace.edit('js-editor');
	        var JavascriptMode = require('ace/mode/javascript').Mode;
	        jsEditor.setTheme('ace/theme/twilight');
			jsEditor.getSession().setMode(new JavascriptMode());
			jsEditor.setShowPrintMargin(false);
			jsEditor.getSession().setUseWrapMode(true);
			document.getElementById('js-editor').style.fontSize='12px';
			document.getElementById('js-editor').style.fontFamily=\"'Monaco for Powerline', 'Monaco', 'Menlo', 'Ubuntu Mono', 'Droid Sans Mono', 'Courier New', monospace\";


			//everything typed in the ace editor goes in the form 'html' textarea
			//people without JS can simply type HTML in the textarea
			$('#page-js-content').parent().addClass('hidden');
			jsEditor.getSession().on('change', function() {
				$('#page-js-content').val(jsEditor.getSession().getValue());
			});
		}
    };",
   	array('inline' => false)
); ?>

