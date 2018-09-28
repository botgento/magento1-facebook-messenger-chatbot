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
CREATE TABLE IF NOT EXISTS {$this->getTable('al_botgento_instock_alert_subscriber')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `uuid` varchar(100) NOT NULL default '',
  `product_id` int(20) NOT NULL,
  `website_id` int(5) unsigned NOT NULL,
  `is_notification_sent` BOOLEAN NOT NULL default 0,
  `created_at` datetime NULL,
  `updated_at` datetime NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
);

$installer->endSetup();