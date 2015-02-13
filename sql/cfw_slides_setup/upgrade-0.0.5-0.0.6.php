<?php

$installer = $this;
$connection = $installer->getConnection();
$installer->startSetup();

$installer->getConnection()
	->addColumn($installer->getTable('cfw_slides/slide'),
		'carousel_id',
		array(
			'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
			100,
			'nullable' => true,
			'default' => null,
			'comment' => "Carousel ID"
		)
	);

$installer->getConnection()
	->addColumn($installer->getTable('cfw_slides/slide'),
		'sort_order',
		array(
			'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
			100,
			'nullable' => true,
			'default' => null,
			'comment' => "sort_order"
		)
	);

$installer->getConnection()
	->addColumn($installer->getTable('cfw_slides/slide'),
		'visibility',
		array(
			'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
			2,
			'nullable' => false,
			'default' => 1,
			'comment' => "Visibility"
		)
	);


$installer->endSetup();