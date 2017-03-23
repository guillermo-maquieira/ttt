<?php

namespace Base;

use \Figures as ChildFigures;
use \FiguresQuery as ChildFiguresQuery;
use \Exception;
use \PDO;
use Map\FiguresTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'figures' table.
 *
 *
 *
 * @method     ChildFiguresQuery orderByIdFigure($order = Criteria::ASC) Order by the id_figure column
 * @method     ChildFiguresQuery orderByFigure($order = Criteria::ASC) Order by the figure column
 *
 * @method     ChildFiguresQuery groupByIdFigure() Group by the id_figure column
 * @method     ChildFiguresQuery groupByFigure() Group by the figure column
 *
 * @method     ChildFiguresQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildFiguresQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildFiguresQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildFiguresQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildFiguresQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildFiguresQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildFiguresQuery leftJoinBoardHasFigures($relationAlias = null) Adds a LEFT JOIN clause to the query using the BoardHasFigures relation
 * @method     ChildFiguresQuery rightJoinBoardHasFigures($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BoardHasFigures relation
 * @method     ChildFiguresQuery innerJoinBoardHasFigures($relationAlias = null) Adds a INNER JOIN clause to the query using the BoardHasFigures relation
 *
 * @method     ChildFiguresQuery joinWithBoardHasFigures($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the BoardHasFigures relation
 *
 * @method     ChildFiguresQuery leftJoinWithBoardHasFigures() Adds a LEFT JOIN clause and with to the query using the BoardHasFigures relation
 * @method     ChildFiguresQuery rightJoinWithBoardHasFigures() Adds a RIGHT JOIN clause and with to the query using the BoardHasFigures relation
 * @method     ChildFiguresQuery innerJoinWithBoardHasFigures() Adds a INNER JOIN clause and with to the query using the BoardHasFigures relation
 *
 * @method     \BoardHasFiguresQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildFigures findOne(ConnectionInterface $con = null) Return the first ChildFigures matching the query
 * @method     ChildFigures findOneOrCreate(ConnectionInterface $con = null) Return the first ChildFigures matching the query, or a new ChildFigures object populated from the query conditions when no match is found
 *
 * @method     ChildFigures findOneByIdFigure(int $id_figure) Return the first ChildFigures filtered by the id_figure column
 * @method     ChildFigures findOneByFigure(string $figure) Return the first ChildFigures filtered by the figure column *

 * @method     ChildFigures requirePk($key, ConnectionInterface $con = null) Return the ChildFigures by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFigures requireOne(ConnectionInterface $con = null) Return the first ChildFigures matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildFigures requireOneByIdFigure(int $id_figure) Return the first ChildFigures filtered by the id_figure column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFigures requireOneByFigure(string $figure) Return the first ChildFigures filtered by the figure column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildFigures[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildFigures objects based on current ModelCriteria
 * @method     ChildFigures[]|ObjectCollection findByIdFigure(int $id_figure) Return ChildFigures objects filtered by the id_figure column
 * @method     ChildFigures[]|ObjectCollection findByFigure(string $figure) Return ChildFigures objects filtered by the figure column
 * @method     ChildFigures[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class FiguresQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\FiguresQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Figures', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildFiguresQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildFiguresQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildFiguresQuery) {
            return $criteria;
        }
        $query = new ChildFiguresQuery();
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
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildFigures|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(FiguresTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = FiguresTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildFigures A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_figure, figure FROM figures WHERE id_figure = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildFigures $obj */
            $obj = new ChildFigures();
            $obj->hydrate($row);
            FiguresTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildFigures|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildFiguresQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FiguresTableMap::COL_ID_FIGURE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildFiguresQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FiguresTableMap::COL_ID_FIGURE, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_figure column
     *
     * Example usage:
     * <code>
     * $query->filterByIdFigure(1234); // WHERE id_figure = 1234
     * $query->filterByIdFigure(array(12, 34)); // WHERE id_figure IN (12, 34)
     * $query->filterByIdFigure(array('min' => 12)); // WHERE id_figure > 12
     * </code>
     *
     * @param     mixed $idFigure The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFiguresQuery The current query, for fluid interface
     */
    public function filterByIdFigure($idFigure = null, $comparison = null)
    {
        if (is_array($idFigure)) {
            $useMinMax = false;
            if (isset($idFigure['min'])) {
                $this->addUsingAlias(FiguresTableMap::COL_ID_FIGURE, $idFigure['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idFigure['max'])) {
                $this->addUsingAlias(FiguresTableMap::COL_ID_FIGURE, $idFigure['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FiguresTableMap::COL_ID_FIGURE, $idFigure, $comparison);
    }

    /**
     * Filter the query on the figure column
     *
     * Example usage:
     * <code>
     * $query->filterByFigure('fooValue');   // WHERE figure = 'fooValue'
     * $query->filterByFigure('%fooValue%', Criteria::LIKE); // WHERE figure LIKE '%fooValue%'
     * </code>
     *
     * @param     string $figure The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFiguresQuery The current query, for fluid interface
     */
    public function filterByFigure($figure = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($figure)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FiguresTableMap::COL_FIGURE, $figure, $comparison);
    }

    /**
     * Filter the query by a related \BoardHasFigures object
     *
     * @param \BoardHasFigures|ObjectCollection $boardHasFigures the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFiguresQuery The current query, for fluid interface
     */
    public function filterByBoardHasFigures($boardHasFigures, $comparison = null)
    {
        if ($boardHasFigures instanceof \BoardHasFigures) {
            return $this
                ->addUsingAlias(FiguresTableMap::COL_ID_FIGURE, $boardHasFigures->getFiguresIdFigure(), $comparison);
        } elseif ($boardHasFigures instanceof ObjectCollection) {
            return $this
                ->useBoardHasFiguresQuery()
                ->filterByPrimaryKeys($boardHasFigures->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByBoardHasFigures() only accepts arguments of type \BoardHasFigures or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the BoardHasFigures relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildFiguresQuery The current query, for fluid interface
     */
    public function joinBoardHasFigures($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('BoardHasFigures');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'BoardHasFigures');
        }

        return $this;
    }

    /**
     * Use the BoardHasFigures relation BoardHasFigures object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BoardHasFiguresQuery A secondary query class using the current class as primary query
     */
    public function useBoardHasFiguresQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBoardHasFigures($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'BoardHasFigures', '\BoardHasFiguresQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildFigures $figures Object to remove from the list of results
     *
     * @return $this|ChildFiguresQuery The current query, for fluid interface
     */
    public function prune($figures = null)
    {
        if ($figures) {
            $this->addUsingAlias(FiguresTableMap::COL_ID_FIGURE, $figures->getIdFigure(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the figures table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FiguresTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            FiguresTableMap::clearInstancePool();
            FiguresTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FiguresTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(FiguresTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            FiguresTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            FiguresTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // FiguresQuery
