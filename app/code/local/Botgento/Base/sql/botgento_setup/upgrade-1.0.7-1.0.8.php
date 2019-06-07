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

$installer = $this;
$installer->startSetup();
$al_botgento_users = $installer->getConnection()->getTableName('al_botgento_subscriber_quote_mapping');

$columnName = 'user_ref';

if ($installer->getConnection()->tableColumnExists($al_botgento_users, $columnName) === false) {
	$installer->getConnection()
	->addColumn(
		$al_botgento_users, $columnName, array(
			'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
			'nullable'  => true,
			'length'    => 255,
			'comment'   => 'User Ref'
		)
	);
}
$installer->endSetup();