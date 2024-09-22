<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\TagManagerInputExtension\Template\Trigger;

use Piwik\Piwik;
use Piwik\Settings\FieldConfig;
use Piwik\Validators\NotEmpty;
use Piwik\Plugins\TagManager\Template\Trigger\BaseTrigger;

class InputChangeTrigger extends BaseTrigger
{
    public function getCategory()
    {
        return self::CATEGORY_USER_ENGAGEMENT;
    }

    public function getName()
    {
        // By default, the name will be automatically fetched from the TagManagerInputExtension_InputChangeTriggerName translation key.
        // you can either adjust/create/remove this translation key, or return a different value here directly.
        return parent::getName();
    }

    public function getDescription()
    {
        // By default, the description will be automatically fetched from the TagManagerInputExtension_InputChangeTriggerDescription
        // translation key. you can either adjust/create/remove this translation key, or return a different value
        // here directly.
        return parent::getDescription();
    }

    public function getHelp()
    {
        // By default, the help will be automatically fetched from the TagManagerInputExtension_InputChangeTriggerHelp translation key.
        // you can either adjust/create/remove this translation key, or return a different value here directly.
        return parent::getHelp();
    }

    public function getIcon()
    {
        // You may optionally specify a path to an image icon URL, for example:
        //
        // return 'plugins/TagManagerInputExtension/images/MyIcon.png';
        //
        // The image should have ideally a resolution of about 64x64 pixels.
        return parent::getIcon();
    }

    public function getParameters()
    {
        $selectionMethod = $this->makeSetting('selectionMethod', 'elementId', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = Piwik::translate('TagManagerInputExtension_InputChangeTriggerSelectionMethodTitle');
            $field->description = Piwik::translate('TagManagerInputExtension_InputChangeTriggerSelectionMethodDescription');
            $field->uiControl = FieldConfig::UI_CONTROL_SINGLE_SELECT;
            $field->validators[] = new NotEmpty();
            $field->availableValues = array(
                'cssSelector' => 'CSS Selector',
                'elementId' => 'Element ID',
            );
        });
        return array(
            $selectionMethod,
            $this->makeSetting('cssSelector', '', FieldConfig::TYPE_STRING, function (FieldConfig $field) use ($selectionMethod) {
                $field->title = Piwik::translate('TagManagerInputExtension_InputChangeTriggerCssSelectorTitle');
                $field->description = Piwik::translate('TagManagerInputExtension_InputChangeTriggerCssSelectorDescription');
                $field->condition = 'selectionMethod == "cssSelector"';
                $field->validate = function ($value) use ($selectionMethod, $field) {
                    if ($selectionMethod->getValue() === 'cssSelector' && empty($value)) {
                        throw new \Exception('Please specify a value for ' . $field->title);
                    }
                };
            }),
            $this->makeSetting('elementId', '', FieldConfig::TYPE_STRING, function (FieldConfig $field) use ($selectionMethod) {
                $field->title = Piwik::translate('TagManagerInputExtension_InputChangeTriggerElementIDTitle');
                $field->description = Piwik::translate('TagManagerInputExtension_InputChangeTriggerElementIDDescription');
                $field->condition = 'selectionMethod == "elementId"';
                $field->validate = function ($value) use ($selectionMethod, $field) {
                    if ($selectionMethod->getValue() === 'elementId' && empty($value)) {
                        throw new \Exception('Please specify a value for ' . $field->title);
                    }
                };
            }),
        );
    }

}
