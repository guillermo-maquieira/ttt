<?php

namespace Base;

use \BoardHasFigures as ChildBoardHasFigures;
use \BoardHasFiguresQuery as ChildBoardHasFiguresQuery;
use \Exception;
use \PDO;
use Map\BoardHasFiguresTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'board_has_figures' table.
 *
 *
 *
 * @method     ChildBoardHasFiguresQuery orderByBoardIdBoard($order = Criteria::ASC) Order by the board_id_board column
 * @method     ChildBoardHasFiguresQuery orderByFiguresIdFigure($order = Criteria::ASC) Order by the figures_id_figure column
 *
 * @method     ChildBoardHasFiguresQuery groupByBoardIdBoard() Group by the board_id_board column
 * @method     ChildBoardHasFiguresQuery groupByFiguresIdFigure() Group by the figures_id_figure column
 *
 * @method     ChildBoardHasFiguresQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildBoardHasFiguresQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildBoardHasFiguresQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildBoardHasFiguresQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildBoardHasFiguresQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildBoardHasFiguresQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildBoardHasFiguresQuery leftJoinBoard($relationAlias = null) Adds a LEFT JOIN clause to the query using the Board relation
 * @method     ChildBoardHasFiguresQuery rightJoinBoard($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Board relation
 * @method     ChildBoardHasFiguresQuery innerJoinBoard($relationAlias = null) Adds a INNER JOIN clause to the query using the Board relation
 *
 * @method     ChildBoardHasFiguresQuery joinWithBoard($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Board relation
 *
 * @method     ChildBoardHasFiguresQuery leftJoinWithBoard() Adds a LEFT JOIN clause and with to the query using the Board relation
 * @method     ChildBoardHasFiguresQuery rightJoinWithBoard() Adds a RIGHT JOIN clause and with to the query using the Board relation
 * @method     ChildBoardHasFiguresQuery innerJoinWithBoard() Adds a INNER JOIN clause and with to the query using the Board relation
 *
 * @method     ChildBoardHasFiguresQuery leftJoinFigures($relationAlias = null) Adds a LEFT JOIN clause to the query using the Figures relation
 * @method     ChildBoardHasFiguresQuery rightJoinFigures($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Figures relation
 * @method     ChildBoardHasFiguresQuery innerJoinFigures($relationAlias = null) Adds a INNER JOIN clause to the query using the Figures relation
 *
 * @method     ChildBoardHasFiguresQuery joinWithFigures($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Figures relation
 *
 * @method     ChildBoardHasFiguresQuery leftJoinWithFigures() Adds a LEFT JOIN clause and with to the query using the Figures relation
 * @method     ChildBoardHasFiguresQuery rightJoinWithFigures() Adds a RIGHT JOIN clause and with to the query using the Figures relation
 * @method     ChildBoardHasFiguresQuery innerJoinWithFigures() Adds a INNER JOIN clause and with to the query using the Figures relation
 *
 * @method     \BoardQuery|\FiguresQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildBoardHasFigures findOne(ConnectionInterface $con = null) Return the first ChildBoardHasFigures matching the query
 * @method     ChildBoardHasFigures findOneOrCreate(ConnectionInterface $con = null) Return the first ChildBoardHasFigures matching the query, or a new ChildBoardHasFigures object populated from the query conditions when no match is found
 *
 * @method     ChildBoardHasFigures findOneByBoardIdBoard(int $board_id_board) Return the first ChildBoardHasFigures filtered by the board_id_board column
 * @method     ChildBoardHasFigures findOneByFiguresIdFigure(int $figures_id_figure) Return the first ChildBoardHasFigures filtered by the figures_id_figure column *

 * @method     ChildBoardHasFigures requirePk($key, ConnectionInterface $con = null) Return the ChildBoardHasFigures by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBoardHasFigures requireOne(ConnectionInterface $con = null) Return the first ChildBoardHasFigures matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBoardHasFigures requireOneByBoardIdBoard(int $board_id_board) Return the first ChildBoardHasFigures filtered by the board_id_board column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBoardHasFigures requireOneByFiguresIdFigure(int $figures_id_figure) Return the first ChildBoardHasFigures filtered by the figures_id_figure column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBoardHasFigures[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildBoardHasFigures objects based on current ModelCriteria
 * @method     ChildBoardHasFigures[]|ObjectCollection findByBoardIdBoard(int $board_id_board) Return ChildBoardHasFigures objects filtered by the board_id_board column
 * @method     ChildBoardHasFigures[]|ObjectCollection findByFiguresIdFigure(int $figures_id_figure) Return ChildBoardHasFigures objects filtered by the figures_id_figure column
 * @method     ChildBoardHasFigures[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class BoardHasFiguresQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\BoardHasFiguresQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\BoardHasFigures', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildBoardHasFiguresQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildBoardHasFiguresQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildBoardHasFiguresQuery) {
            return $criteria;
        }
        $query = new ChildBoardHasFiguresQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$board_id_board, $figures_id_figure] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildBoardHasFigures|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(BoardHasFiguresTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = BoardHasFiguresTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildBoardHasFigures A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT board_id_board, figures_id_figure FROM board_has_figures WHERE board_id_board = :p0 AND figures_id_figure = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildBoardHasFigures $obj */
            $obj = new ChildBoardHasFigures();
            $obj->hydrate($row);
            BoardHasFiguresTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildBoardHasFigures|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildBoardHasFiguresQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(BoardHasFiguresTableMap::COL_BOARD_ID_BOARD, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(BoardHasFiguresTableMap::COL_FIGURES_ID_FIGURE, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildBoardHasFiguresQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(BoardHasFiguresTableMap::COL_BOARD_ID_BOARD, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(BoardHasFiguresTableMap::COL_FIGURES_ID_FIGURE, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the board_id_board column
     *
     * Example usage:
     * <code>
     * $query->filterByBoardIdBoard(1234); // WHERE board_id_board = 1234
     * $query->filterByBoardIdBoard(array(12, 34)); // WHERE board_id_board IN (12, 34)
     * $query->filterByBoardIdBoard(array('min' => 12)); // WHERE board_id_board > 12
     * </code>
     *
     * @see       filterByBoard()
     *
     * @param     mixed $boardIdBoard The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBoardHasFiguresQuery The current query, for fluid interface
     */
    public function filterByBoardIdBoard($boardIdBoard = null, $comparison = null)
    {
        if (is_array($boardIdBoard)) {
            $useMinMax = false;
            if (isset($boardIdBoard['min'])) {
                $this->addUsingAlias(BoardHasFiguresTableMap::COL_BOARD_ID_BOARD, $boardIdBoard['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($boardIdBoard['max'])) {
                $this->addUsingAlias(BoardHasFiguresTableMap::COL_BOARD_ID_BOARD, $boardIdBoard['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BoardHasFiguresTableMap::COL_BOARD_ID_BOARD, $boardIdBoard, $comparison);
    }

    /**
     * Filter the query on the figures_id_figure column
     *
     * Example usage:
     * <code>
     * $query->filterByFiguresIdFigure(1234); // WHERE figures_id_figure = 1234
     * $query->filterByFiguresIdFigure(array(12, 34)); // WHERE figures_id_figure IN (12, 34)
     * $query->filterByFiguresIdFigure(array('min' => 12)); // WHERE figures_id_figure > 12
     * </code>
     *
     * @see       filterByFigures()
     *
     * @param     mixed $figuresIdFigure The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBoardHasFiguresQuery The current query, for fluid interface
     */
    public function filterByFiguresIdFigure($figuresIdFigure = null, $comparison = null)
    {
        if (is_array($figuresIdFigure)) {
            $useMinMax = false;
            if (isset($figuresIdFigure['min'])) {
                $this->addUsingAlias(BoardHasFiguresTableMap::COL_FIGURES_ID_FIGURE, $figuresIdFigure['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($figuresIdFigure['max'])) {
                $this->addUsingAlias(BoardHasFiguresTableMap::COL_FIGURES_ID_FIGURE, $figuresIdFigure['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BoardHasFiguresTableMap::COL_FIGURES_ID_FIGURE, $figuresIdFigure, $comparison);
    }

    /**
     * Filter the query by a related \Board object
     *
     * @param \Board|ObjectCollection $board The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildBoardHasFiguresQuery The current query, for fluid interface
     */
    public function filterByBoard($board, $comparison = null)
    {
        if ($board instanceof \Board) {
            return $this
                ->addUsingAlias(BoardHasFiguresTableMap::COL_BOARD_ID_BOARD, $board->getIdBoard(), $comparison);
        } elseif ($board instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BoardHasFiguresTableMap::COL_BOARD_ID_BOARD, $board->toKeyValue('IdBoard', 'IdBoard'), $comparison);
        } else {
            throw new PropelException('filterByBoard() only accepts arguments of type \Board or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Board relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBoardHasFiguresQuery The current query, for fluid interface
     */
    public function joinBoard($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Board');

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
            $this->addJoinObject($join, 'Board');
        }

        return $this;
    }

    /**
     * Use the Board relation Board object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BoardQuery A secondary query class using the current class as primary query
     */
    public function useBoardQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBoard($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Board', '\BoardQuery');
    }

    /**
     * Filter the query by a related \Figures object
     *
     * @param \Figures|ObjectCollection $figures The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildBoardHasFiguresQuery The current query, for fluid interface
     */
    public function filterByFigures($figures, $comparison = null)
    {
        if ($figures instanceof \Figures) {
            return $this
                ->addUsingAlias(BoardHasFiguresTableMap::COL_FIGURES_ID_FIGURE, $figures->getIdFigure(), $comparison);
        } elseif ($figures instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BoardHasFiguresTableMap::COL_FIGURES_ID_FIGURE, $figures->toKeyValue('PrimaryKey', 'IdFigure'), $comparison);
        } else {
            throw new PropelException('filterByFigures() only accepts arguments of type \Figures or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Figures relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBoardHasFiguresQuery The current query, for fluid interface
     */
    public function joinFigures($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Figures');

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
            $this->addJoinObject($join, 'Figures');
        }

        return $this;
    }

    /**
     * Use the Figures relation Figures object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \FiguresQuery A secondary query class using the current class as primary query
     */
    public function useFiguresQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFigures($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Figures', '\FiguresQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildBoardHasFigures $boardHasFigures Object to remove from the list of results
     *
     * @return $this|ChildBoardHasFiguresQuery The current query, for fluid interface
     */
    public function prune($boardHasFigures = null)
    {
        if ($boardHasFigures) {
            $this->addCond('pruneCond0', $this->getAliasedColName(BoardHasFiguresTableMap::COL_BOARD_ID_BOARD), $boardHasFigures->getBoardIdBoard(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(BoardHasFiguresTableMap::COL_FIGURES_ID_FIGURE), $boardHasFigures->getFiguresIdFigure(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the board_has_figures table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BoardHasFiguresTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BoardHasFiguresTableMap::clearInstancePool();
            BoardHasFiguresTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(BoardHasFiguresTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(BoardHasFiguresTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            BoardHasFiguresTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            BoardHasFiguresTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // BoardHasFiguresQuery
