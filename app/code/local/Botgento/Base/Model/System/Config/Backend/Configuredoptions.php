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

class Botgento_Base_Model_System_Config_Backend_Configuredoptions extends Mage_Core_Model_Config_Data
{
    protected function _beforeSave()
    {
        $this->_dataSaveAllowed = false;
        return $this;
    }
}