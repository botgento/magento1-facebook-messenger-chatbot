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
CREATE TABLE IF NOT EXISTS {$this->getTable('al_botgento_sync_attributes')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `type` varchar(50) NOT NULL default '',
  `attributes_json` text NOT NULL default '',
  `created_at` datetime NULL,
  `updated_at` datetime NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
);

$installer->run(
    "
CREATE TABLE IF NOT EXISTS {$this->getTable('al_botgento_sync_log')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `type` varchar(50) NOT NULL default '',
  `status` varchar(20) NOT NULL default '',
  `error_details` text NULL default '',
  `total_sync_data` int(11) unsigned NOT NULL,
  `created_at` datetime NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
);

$installer->run(
    "
CREATE TABLE IF NOT EXISTS {$this->getTable('al_botgento_subscriber_quote_mapping')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `uuid` varchar(100) NOT NULL default '',
  `quote_id` int(20) NOT NULL,
  `is_button_press` BOOLEAN NOT NULL default 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
);

$installer->getConnection()
    ->addColumn(
        'al_botgento_users', 'website_id', array(
        'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'nullable'  => false,
        'length'    => 5,
        'after'     => 'customer_id',
        'comment'   => 'Website Id'
        )
    );

$installer->endSetup();
