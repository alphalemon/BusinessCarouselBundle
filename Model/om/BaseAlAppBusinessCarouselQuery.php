<?php

namespace AlphaLemon\Block\BusinessCarouselBundle\Model\om;

use \Criteria;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelPDO;
use AlphaLemon\AlphaLemonCmsBundle\Model\AlBlock;
use AlphaLemon\Block\BusinessCarouselBundle\Model\AlAppBusinessCarousel;
use AlphaLemon\Block\BusinessCarouselBundle\Model\AlAppBusinessCarouselPeer;
use AlphaLemon\Block\BusinessCarouselBundle\Model\AlAppBusinessCarouselQuery;

/**
 * Base class that represents a query for the 'al_app_business_carousel' table.
 *
 * 
 *
 * @method     AlAppBusinessCarouselQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     AlAppBusinessCarouselQuery orderByBlockId($order = Criteria::ASC) Order by the block_id column
 * @method     AlAppBusinessCarouselQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     AlAppBusinessCarouselQuery orderBySurname($order = Criteria::ASC) Order by the surname column
 * @method     AlAppBusinessCarouselQuery orderByRole($order = Criteria::ASC) Order by the role column
 * @method     AlAppBusinessCarouselQuery orderByContent($order = Criteria::ASC) Order by the content column
 *
 * @method     AlAppBusinessCarouselQuery groupById() Group by the id column
 * @method     AlAppBusinessCarouselQuery groupByBlockId() Group by the block_id column
 * @method     AlAppBusinessCarouselQuery groupByName() Group by the name column
 * @method     AlAppBusinessCarouselQuery groupBySurname() Group by the surname column
 * @method     AlAppBusinessCarouselQuery groupByRole() Group by the role column
 * @method     AlAppBusinessCarouselQuery groupByContent() Group by the content column
 *
 * @method     AlAppBusinessCarouselQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     AlAppBusinessCarouselQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     AlAppBusinessCarouselQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     AlAppBusinessCarouselQuery leftJoinAlBlock($relationAlias = null) Adds a LEFT JOIN clause to the query using the AlBlock relation
 * @method     AlAppBusinessCarouselQuery rightJoinAlBlock($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AlBlock relation
 * @method     AlAppBusinessCarouselQuery innerJoinAlBlock($relationAlias = null) Adds a INNER JOIN clause to the query using the AlBlock relation
 *
 * @method     AlAppBusinessCarousel findOne(PropelPDO $con = null) Return the first AlAppBusinessCarousel matching the query
 * @method     AlAppBusinessCarousel findOneOrCreate(PropelPDO $con = null) Return the first AlAppBusinessCarousel matching the query, or a new AlAppBusinessCarousel object populated from the query conditions when no match is found
 *
 * @method     AlAppBusinessCarousel findOneById(int $id) Return the first AlAppBusinessCarousel filtered by the id column
 * @method     AlAppBusinessCarousel findOneByBlockId(int $block_id) Return the first AlAppBusinessCarousel filtered by the block_id column
 * @method     AlAppBusinessCarousel findOneByName(string $name) Return the first AlAppBusinessCarousel filtered by the name column
 * @method     AlAppBusinessCarousel findOneBySurname(string $surname) Return the first AlAppBusinessCarousel filtered by the surname column
 * @method     AlAppBusinessCarousel findOneByRole(string $role) Return the first AlAppBusinessCarousel filtered by the role column
 * @method     AlAppBusinessCarousel findOneByContent(string $content) Return the first AlAppBusinessCarousel filtered by the content column
 *
 * @method     array findById(int $id) Return AlAppBusinessCarousel objects filtered by the id column
 * @method     array findByBlockId(int $block_id) Return AlAppBusinessCarousel objects filtered by the block_id column
 * @method     array findByName(string $name) Return AlAppBusinessCarousel objects filtered by the name column
 * @method     array findBySurname(string $surname) Return AlAppBusinessCarousel objects filtered by the surname column
 * @method     array findByRole(string $role) Return AlAppBusinessCarousel objects filtered by the role column
 * @method     array findByContent(string $content) Return AlAppBusinessCarousel objects filtered by the content column
 *
 * @package    propel.generator.src.AlphaLemon.Block.BusinessCarouselBundle.Model.om
 */
abstract class BaseAlAppBusinessCarouselQuery extends ModelCriteria
{
	
	/**
	 * Initializes internal state of BaseAlAppBusinessCarouselQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'default', $modelName = 'AlphaLemon\\Block\\BusinessCarouselBundle\\Model\\AlAppBusinessCarousel', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new AlAppBusinessCarouselQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    AlAppBusinessCarouselQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof AlAppBusinessCarouselQuery) {
			return $criteria;
		}
		$query = new AlAppBusinessCarouselQuery();
		if (null !== $modelAlias) {
			$query->setModelAlias($modelAlias);
		}
		if ($criteria instanceof Criteria) {
			$query->mergeWith($criteria);
		}
		return $query;
	}

	/**
	 * Find object by primary key.
	 * Propel uses the instance pool to skip the database if the object exists.
	 * Go fast if the query is untouched.
	 *
	 * <code>
	 * $obj  = $c->findPk(12, $con);
	 * </code>
	 *
	 * @param     mixed $key Primary key to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    AlAppBusinessCarousel|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ($key === null) {
			return null;
		}
		if ((null !== ($obj = AlAppBusinessCarouselPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
			// the object is alredy in the instance pool
			return $obj;
		}
		if ($con === null) {
			$con = Propel::getConnection(AlAppBusinessCarouselPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
		$this->basePreSelect($con);
		if ($this->formatter || $this->modelAlias || $this->with || $this->select
		 || $this->selectColumns || $this->asColumns || $this->selectModifiers
		 || $this->map || $this->having || $this->joins) {
			return $this->findPkComplex($key, $con);
		} else {
			return $this->findPkSimple($key, $con);
		}
	}

	/**
	 * Find object by primary key using raw SQL to go fast.
	 * Bypass doSelect() and the object formatter by using generated code.
	 *
	 * @param     mixed $key Primary key to use for the query
	 * @param     PropelPDO $con A connection object
	 *
	 * @return    AlAppBusinessCarousel A model object, or null if the key is not found
	 */
	protected function findPkSimple($key, $con)
	{
		$sql = 'SELECT `ID`, `BLOCK_ID`, `NAME`, `SURNAME`, `ROLE`, `CONTENT` FROM `al_app_business_carousel` WHERE `ID` = :p0';
		try {
			$stmt = $con->prepare($sql);
			$stmt->bindValue(':p0', $key, PDO::PARAM_INT);
			$stmt->execute();
		} catch (Exception $e) {
			Propel::log($e->getMessage(), Propel::LOG_ERR);
			throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
		}
		$obj = null;
		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$obj = new AlAppBusinessCarousel();
			$obj->hydrate($row);
			AlAppBusinessCarouselPeer::addInstanceToPool($obj, (string) $key);
		}
		$stmt->closeCursor();

		return $obj;
	}

	/**
	 * Find object by primary key.
	 *
	 * @param     mixed $key Primary key to use for the query
	 * @param     PropelPDO $con A connection object
	 *
	 * @return    AlAppBusinessCarousel|array|mixed the result, formatted by the current formatter
	 */
	protected function findPkComplex($key, $con)
	{
		// As the query uses a PK condition, no limit(1) is necessary.
		$criteria = $this->isKeepQuery() ? clone $this : $this;
		$stmt = $criteria
			->filterByPrimaryKey($key)
			->doSelect($con);
		return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
	}

	/**
	 * Find objects by primary key
	 * <code>
	 * $objs = $c->findPks(array(12, 56, 832), $con);
	 * </code>
	 * @param     array $keys Primary keys to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    PropelObjectCollection|array|mixed the list of results, formatted by the current formatter
	 */
	public function findPks($keys, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
		}
		$this->basePreSelect($con);
		$criteria = $this->isKeepQuery() ? clone $this : $this;
		$stmt = $criteria
			->filterByPrimaryKeys($keys)
			->doSelect($con);
		return $criteria->getFormatter()->init($criteria)->format($stmt);
	}

	/**
	 * Filter the query by primary key
	 *
	 * @param     mixed $key Primary key to use for the query
	 *
	 * @return    AlAppBusinessCarouselQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(AlAppBusinessCarouselPeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    AlAppBusinessCarouselQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(AlAppBusinessCarouselPeer::ID, $keys, Criteria::IN);
	}

	/**
	 * Filter the query on the id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterById(1234); // WHERE id = 1234
	 * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
	 * $query->filterById(array('min' => 12)); // WHERE id > 12
	 * </code>
	 *
	 * @param     mixed $id The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    AlAppBusinessCarouselQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = null)
	{
		if (is_array($id) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(AlAppBusinessCarouselPeer::ID, $id, $comparison);
	}

	/**
	 * Filter the query on the block_id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByBlockId(1234); // WHERE block_id = 1234
	 * $query->filterByBlockId(array(12, 34)); // WHERE block_id IN (12, 34)
	 * $query->filterByBlockId(array('min' => 12)); // WHERE block_id > 12
	 * </code>
	 *
	 * @see       filterByAlBlock()
	 *
	 * @param     mixed $blockId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    AlAppBusinessCarouselQuery The current query, for fluid interface
	 */
	public function filterByBlockId($blockId = null, $comparison = null)
	{
		if (is_array($blockId)) {
			$useMinMax = false;
			if (isset($blockId['min'])) {
				$this->addUsingAlias(AlAppBusinessCarouselPeer::BLOCK_ID, $blockId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($blockId['max'])) {
				$this->addUsingAlias(AlAppBusinessCarouselPeer::BLOCK_ID, $blockId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(AlAppBusinessCarouselPeer::BLOCK_ID, $blockId, $comparison);
	}

	/**
	 * Filter the query on the name column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
	 * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $name The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    AlAppBusinessCarouselQuery The current query, for fluid interface
	 */
	public function filterByName($name = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($name)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $name)) {
				$name = str_replace('*', '%', $name);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(AlAppBusinessCarouselPeer::NAME, $name, $comparison);
	}

	/**
	 * Filter the query on the surname column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterBySurname('fooValue');   // WHERE surname = 'fooValue'
	 * $query->filterBySurname('%fooValue%'); // WHERE surname LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $surname The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    AlAppBusinessCarouselQuery The current query, for fluid interface
	 */
	public function filterBySurname($surname = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($surname)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $surname)) {
				$surname = str_replace('*', '%', $surname);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(AlAppBusinessCarouselPeer::SURNAME, $surname, $comparison);
	}

	/**
	 * Filter the query on the role column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByRole('fooValue');   // WHERE role = 'fooValue'
	 * $query->filterByRole('%fooValue%'); // WHERE role LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $role The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    AlAppBusinessCarouselQuery The current query, for fluid interface
	 */
	public function filterByRole($role = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($role)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $role)) {
				$role = str_replace('*', '%', $role);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(AlAppBusinessCarouselPeer::ROLE, $role, $comparison);
	}

	/**
	 * Filter the query on the content column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByContent('fooValue');   // WHERE content = 'fooValue'
	 * $query->filterByContent('%fooValue%'); // WHERE content LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $content The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    AlAppBusinessCarouselQuery The current query, for fluid interface
	 */
	public function filterByContent($content = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($content)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $content)) {
				$content = str_replace('*', '%', $content);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(AlAppBusinessCarouselPeer::CONTENT, $content, $comparison);
	}

	/**
	 * Filter the query by a related AlBlock object
	 *
	 * @param     AlBlock|PropelCollection $alBlock The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    AlAppBusinessCarouselQuery The current query, for fluid interface
	 */
	public function filterByAlBlock($alBlock, $comparison = null)
	{
		if ($alBlock instanceof AlBlock) {
			return $this
				->addUsingAlias(AlAppBusinessCarouselPeer::BLOCK_ID, $alBlock->getId(), $comparison);
		} elseif ($alBlock instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(AlAppBusinessCarouselPeer::BLOCK_ID, $alBlock->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterByAlBlock() only accepts arguments of type AlBlock or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the AlBlock relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    AlAppBusinessCarouselQuery The current query, for fluid interface
	 */
	public function joinAlBlock($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('AlBlock');

		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}

		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'AlBlock');
		}

		return $this;
	}

	/**
	 * Use the AlBlock relation AlBlock object
	 *
	 * @see       useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    \AlphaLemon\AlphaLemonCmsBundle\Model\AlBlockQuery A secondary query class using the current class as primary query
	 */
	public function useAlBlockQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinAlBlock($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'AlBlock', '\AlphaLemon\AlphaLemonCmsBundle\Model\AlBlockQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     AlAppBusinessCarousel $alAppBusinessCarousel Object to remove from the list of results
	 *
	 * @return    AlAppBusinessCarouselQuery The current query, for fluid interface
	 */
	public function prune($alAppBusinessCarousel = null)
	{
		if ($alAppBusinessCarousel) {
			$this->addUsingAlias(AlAppBusinessCarouselPeer::ID, $alAppBusinessCarousel->getId(), Criteria::NOT_EQUAL);
		}

		return $this;
	}

} // BaseAlAppBusinessCarouselQuery