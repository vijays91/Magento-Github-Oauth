<?php
class Learn_GithubLogin_Block_Adminhtml_GithubLogin_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

 public function __construct()
    {
        parent::__construct();
        $this->setId('githubloginGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
 
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('githublogin/githublogin')->getCollection();
        $this->setCollection($collection);		
        return parent::_prepareCollection();
    }
 
    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header'    => Mage::helper('githublogin')->__('ID'),
            'align'     => 'right',
			'type'		=> 'number',
            'index'     => 'id',
        ));
        $this->addColumn('github_id', array(
            'header'    => Mage::helper('githublogin')->__('Github ID'),
			'width'     => '100px',
            'index' 	=> 'github_id',
        ));
        $this->addColumn('mage_customer_id', array(
            'header'    => Mage::helper('githublogin')->__('Customer ID'),
			'type'		=> 'number',
			'width'     => '100px',
            'index' 	=> 'mage_customer_id',
            'renderer'	=> 'Learn_GithubLogin_Block_Adminhtml_Renderer_CustomerId'
        ));
        $this->addColumn('github_username', array(
            'header'    => Mage::helper('githublogin')->__('User Name'),
            'align'     => 'left',
			'width'		=> '200px',
            'index'     => 'github_username',
        ));
        $this->addColumn('fullname', array(
            'header'    => Mage::helper('githublogin')->__('Fullname'),
			'width'     => '150px',
            'index' 	=> 'fullname',
			'renderer'	=> 'Learn_GithubLogin_Block_Adminhtml_Renderer_Fullname'
        ));
		$this->addColumn('email', array(
			'header'    => Mage::helper('githublogin')->__('Email'),
			'width'     => '150',
			'index'     => 'email'
		));
        $this->addColumn('profile_image', array(
            'header'    => Mage::helper('githublogin')->__('Profile Image'),
			'width'		=> '120px',
            'index'     => 'profile_image',
			'filter' 	=> false,
			'sortable'  => false,
			'renderer'	=> 'Learn_GithubLogin_Block_Adminhtml_Renderer_Profileimage'
        ));
        $this->addColumn('created_at', array(
            'header'    => Mage::helper('githublogin')->__('Created At'),
            'index' 	=> 'created_at',
			'filter' 	=> false,
            /* 'type' 		=> 'datetime', */
            'width' 	=> '150px',
        ));
        
		$this->addExportType('*/*/exportCsv', Mage::helper('githublogin')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('githublogin')->__('XML'));
		
        return parent::_prepareColumns();
    }
	
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/view', array('id' => $row->getId()));
    }
    public function getGridUrl()
    {
      return $this->getUrl('*/*/grid', array('_current'=>true));
    }
}