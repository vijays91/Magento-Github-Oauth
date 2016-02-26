<?php
$installer = $this;
$installer->startSetup();
$table = $installer->getConnection()
    ->newTable($installer->getTable('githublogin/githublogin'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Id')		
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        ), 'Store Id')			
    ->addColumn('email', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Email')
    ->addColumn('fullname', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Fullname')
    ->addColumn('company', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'company')
    ->addColumn('blog', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Blog')
    ->addColumn('location', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Location')
    ->addColumn('github_id', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Github Id')
    ->addColumn('github_username', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Github Username')
    ->addColumn('profile_image', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Profile Image')
    ->addColumn('github_url', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Github URL')
    ->addColumn('html_url', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'HTML URL')        
    ->addColumn('mage_customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        ), 'Customer Id')	
   ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable'  => false,
        ), 'Created At')
   ->addColumn('update_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable'  => false,
        ), 'Update At')
    ->setComment('Github Login Users');	
$installer->getConnection()->createTable($table);
$installer->endSetup();
?>