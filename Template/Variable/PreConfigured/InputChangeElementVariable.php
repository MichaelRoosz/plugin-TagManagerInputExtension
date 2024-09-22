<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\TagManagerInputExtension\Template\Variable\PreConfigured;

use Piwik\Plugins\TagManager\Template\Variable\PreConfigured\BaseDataLayerVariable;

class InputChangeElementVariable extends BaseDataLayerVariable
{
    public function getCategory()
    {
        return 'InputChange';
    }

    protected function getDataLayerVariableName()
    {
        return 'TagManagerInputExtension.InputChangeElement';
    }

}
