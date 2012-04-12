<?php

namespace AlphaLemon\Block\BusinessCarouselBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'al_app_business_carousel' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.AlphaLemon.Block.BusinessCarouselBundle.Model.map
 */
class AlAppBusinessCarouselTableMap extends TableMap
{

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'src.AlphaLemon.Block.BusinessCarouselBundle.Model.map.AlAppBusinessCarouselTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
		// attributes
		$this->setName('al_app_business_carousel');
		$this->setPhpName('AlAppBusinessCarousel');
		$this->setClassname('AlphaLemon\\Block\\BusinessCarouselBundle\\Model\\AlAppBusinessCarousel');
		$this->setPackage('src.AlphaLemon.Block.BusinessCarouselBundle.Model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('BLOCK_ID', 'BlockId', 'INTEGER', 'al_block', 'ID', true, null, null);
		$this->addColumn('NAME', 'Name', 'VARCHAR', false, 128, null);
		$this->addColumn('SURNAME', 'Surname', 'VARCHAR', false, 128, null);
		$this->addColumn('ROLE', 'Role', 'VARCHAR', false, 128, null);
		$this->addColumn('CONTENT', 'Content', 'LONGVARCHAR', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
		$this->addRelation('AlBlock', 'AlphaLemon\\AlphaLemonCmsBundle\\Model\\AlBlock', RelationMap::MANY_TO_ONE, array('block_id' => 'id', ), 'CASCADE', null);
	} // buildRelations()

} // AlAppBusinessCarouselTableMap
