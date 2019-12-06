<?php

/*
 * Backend Helper bundle for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2019, pdir GmbH
 * @author     Mathias Arzberger <https://pdir.de>
 * @license    MIT
 */

namespace Pdir\BackendHelperBundle\EventListener;

class EditAllHelperListener
{
    public function addScripts($strContent, $strTemplate)
    {
        if ('be_main' === $strTemplate) {
            // check if some bulk console is needed
            if (isset($_GET['act']) && 'editAll' === $_GET['act'] && isset($_GET['fields'])) {
                $strContent = str_replace('</body>', $this->generateBuffer().'</body>', $strContent);
            }
        }

        return $strContent;
    }

    private function generateBuffer()
    {
        // script code
        $buffer = <<<'EOF'
const div = document.createElement('div');
div.className = 'bhb-container';
div.setAttribute("id", "bhbContainer");
div.innerHTML = '<span>{console}</span>' + 
  '<button class="tl_submit" onClick="bhbCheckAll()">{openCheckboxes}</button>' +
  '<button class="tl_submit" onClick="bhbRenderSelectFields()">{renderSelectFields}</button>' + 
  '<div class="bhb-selects" id="bhbSelects"></div>';
document.getElementById('tl_buttons').appendChild(div);

function bhbCheckAll(){
  var items = document.querySelectorAll('input[type=checkbox]');
  for (var i = 0; i < items.length; i++) {
    if (items[i].type == 'checkbox')
      items[i].click();
  }
}

function bhbRenderSelectFields(){
  var bhbCont = document.getElementById('bhbContainer');
  var bhbSelects = document.getElementById('bhbSelects');
  
  // clear select fields
  bhbSelects.innerHTML = '';
  
  // add class full
  bhbCont.classList.add('full');
  
  // allowed fields
  var fields = ['type','layout', 'mobileLayout', 'cuser', 'cgroup', 'robots'];
  
  fields.forEach(field => bhbRenderSelect(field));
}

function bhbRenderSelect(field)
{
  var items = document.querySelectorAll('select[name*='+field+']');
  
  if(items.length === 0)
    return;
  
  // create select 
  const select = document.createElement('select');
  select.className = 'tl_select';
  select.setAttribute('name', field)
  select.innerHTML = items[0].innerHTML;
  select.onchange = function (e) {  
    bhbPreSelectFields(e);
  };

  var bhbSelects = document.getElementById('bhbSelects');

  // add label
  var label = document.createElement('label');
  label.innerHTML = items[0].previousSibling.previousSibling.innerHTML.replace(/<[^>]*>?/gm, '');
  bhbSelects.appendChild(label);
  
  // add select
  bhbSelects.appendChild(select);
}

function bhbPreSelectFields(event)
{
  var selected = event.target;
  var index = selected.selectedIndex;
  var field = selected.name;
  
  var items = document.querySelectorAll('select[name*='+field+']');for (var i = 0; i < items.length; i++) {
    if (items[i].type == 'select-one'){
      items[i].value = items[i].options[index].value;
      items[i].selectedIndex = index;        
      $$('#' + items[i].id + '_chzn').destroy();
      $$('#' + items[i].id).chosen();    
    }
  }
}
EOF;

        return '<script>'.$this->replaceLabels($buffer).'</script>'.$this->getStyles();
    }

    private function replaceLabels($str)
    {
        return str_replace([
            '{openCheckboxes}',
            '{console}',
            '{renderSelectFields}',
        ], [
            $GLOBALS['TL_LANG']['BHB']['button']['openCheckboxes'],
            $GLOBALS['TL_LANG']['BHB']['text']['console'],
            $GLOBALS['TL_LANG']['BHB']['button']['renderSelectFields'],
        ], $str);
    }

    private function getStyles()
    {
        return <<<'EOF'
<style>
.bhb-container{min-height:30px;}
.bhb-container.full{min-height:70px;}
.bhb-container>*{float:left;margin-right:5px;}
.bhb-container span{padding:7px 0 0 0;}
.bhb-selects{clear: both;padding:10px 0;}
.bhb-selects label{margin-right:5px;}
.bhb-selects select{width:auto;margin-right:5px;border-color:darkred}
</style>
EOF;
    }
}
