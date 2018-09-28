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

$installer->run(
    "
CREATE TABLE IF NOT EXISTS {$this->getTable('al_botgento_users')} (
  `botgento_id` int(11) unsigned NOT NULL auto_increment,
  `customer_id` int(11) unsigned NOT NULL,
  `website_id` int(11) unsigned NOT NULL,
  `email` varchar(255) NOT NULL default '',
  `subscriber_id` varchar(50) NOT NULL default '',
  `created_time` datetime NULL,
  PRIMARY KEY (`botgento_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
);

$installer->run(
    "
CREATE TABLE IF NOT EXISTS {$this->getTable('al_botgento_data')} (
  `botgento_data_id` int(11) unsigned NOT NULL auto_increment,
  `apidata` text NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `website_id` int(5) unsigned NOT NULL,
  `order_id` text NOT NULL default '',
  `recipient_id` varchar(255) NOT NULL default '',
  `is_guest` int(11) unsigned NOT NULL,
  `send_time` timestamp NULL,
  `status` int(11) unsigned NOT NULL,
  `cron_exec_count` int(11) unsigned NOT NULL,
  PRIMARY KEY (`botgento_data_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
);

$this->addAttribute(
    'catalog_category',
    'shop_now',
    array(
        'group' => 'General Information',
        'input' => 'select',
        'type' => 'int',
        'source' => 'eav/entity_attribute_source_boolean',
        'label' => 'Enable for Shop Now?',
        'required' => 0,
        'unique' => 0,
        'sort_order' => 5,
        'user_defined' => 1,
        'default' => 'no',
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    )
);
$installer->endSetup();