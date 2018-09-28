<?php
/**
 * Botgento
 *
 * @category    Botgento
 * @package     Botgento_Base
 * @author      Botgento Team <support@botgento.com>
 * @copyright   Botgento (https://www.botgento.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

Class Botgento_Base_Block_Adminhtml_Renderer extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    /**
     * ElementHtml
     *
     * @param Varien_Data_Form_Element_Abstract $element Element
     *
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $element->setDisabled('disabled');
        return parent::_getElementHtml($element);
    }
}