<?php

namespace Base;

use \Board as ChildBoard;
use \BoardQuery as ChildBoardQuery;
use \Exception;
use \PDO;
use Map\BoardTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'board' table.
 *
 *
 *
 * @method     ChildBoardQuery orderByIdBoard($order = Criteria::ASC) Order by the id_board column
 * @method     ChildBoardQuery orderByRow($order = Criteria::ASC) Order by the row column
 * @method     ChildBoardQuery orderByCol($order = Criteria::ASC) Order by the col column
 * @method     ChildBoardQuery orderByFigure($order = Criteria::ASC) Order by the figure column
 *
 * @method     ChildBoardQuery groupByIdBoard() Group by the id_board column
 * @method     ChildBoardQuery groupByRow() Group by the row column
 * @method     ChildBoardQuery groupByCol() Group by the col column
 * @method     ChildBoardQuery groupByFigure() Group by the figure column
 *
 * @method     ChildBoardQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildBoardQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildBoardQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildBoardQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildBoardQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildBoardQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildBoardQuery leftJoinBoardHasFigures($relationAlias = null) Adds a LEFT JOIN clause to the query using the BoardHasFigures relation
 * @method     ChildBoardQuery rightJoinBoardHasFigures($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BoardHasFigures relation
 * @method     ChildBoardQuery innerJoinBoardHasFigures($relationAlias = null) Adds a INNER JOIN clause to the query using the BoardHasFigures relation
 *
 * @method     ChildBoardQuery joinWithBoardHasFigures($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the BoardHasFigures relation
 *
 * @method     ChildBoardQuery leftJoinWithBoardHasFigures() Adds a LEFT JOIN clause and with to the query using the BoardHasFigures relation
 * @method     ChildBoardQuery rightJoinWithBoardHasFigures() Adds a RIGHT JOIN clause and with to the query using the BoardHasFigures relation
 * @method     ChildBoardQuery innerJoinWithBoardHasFigures() Adds a INNER JOIN clause and with to the query using the BoardHasFigures relation
 *
 * @method     ChildBoardQuery leftJoinGames($relationAlias = null) Adds a LEFT JOIN clause to the query using the Games relation
 * @method     ChildBoardQuery rightJoinGames($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Games relation
 * @method     ChildBoardQuery innerJoinGames($relationAlias = null) Adds a INNER JOIN clause to the query using the Games relation
 *
 * @method     ChildBoardQuery joinWithGames($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Games relation
 *
 * @method     ChildBoardQuery leftJoinWithGames() Adds a LEFT JOIN clause and with to the query using the Games relation
 * @method     ChildBoardQuery rightJoinWithGames() Adds a RIGHT JOIN clause and with to the query using the Games relation
 * @method     ChildBoardQuery innerJoinWithGames() Adds a INNER JOIN clause and with to the query using the Games relation
 *
 * @method     \BoardHasFiguresQuery|\GamesQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildBoard findOne(ConnectionInterface $con = null) Return the first ChildBoard matching the query
 * @method     ChildBoard findOneOrCreate(ConnectionInterface $con = null) Return the first ChildBoard matching the query, or a new ChildBoard object populated from the query conditions when no match is found
 *
 * @method     ChildBoard findOneByIdBoard(int $id_board) Return the first ChildBoard filtered by the id_board column
 * @method     ChildBoard findOneByRow(int $row) Return the first ChildBoard filtered by the row column
 * @method     ChildBoard findOneByCol(int $col) Return the first ChildBoard filtered by the col column
 * @method     ChildBoard findOneByFigure(string $figure) Return the first ChildBoard filtered by the figure column *

 * @method     ChildBoard requirePk($key, ConnectionInterface $con = null) Return the ChildBoard by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBoard requireOne(ConnectionInterface $con = null) Return the first ChildBoard matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBoard requireOneByIdBoard(int $id_board) Return the first ChildBoard filtered by the id_board column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBoard requireOneByRow(int $row) Return the first ChildBoard filtered by the row column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBoard requireOneByCol(int $col) Return the first ChildBoard filtered by the col column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBoard requireOneByFigure(string $figure) Return the first ChildBoard filtered by the figure column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBoard[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildBoard objects based on current ModelCriteria
 * @method     ChildBoard[]|ObjectCollection findByIdBoard(int $id_board) Return ChildBoard objects filtered by the id_board column
 * @method     ChildBoard[]|ObjectCollection findByRow(int $row) Return ChildBoard objects filtered by the row column
 * @method     ChildBoard[]|ObjectCollection findByCol(int $col) Return ChildBoard objects filtered by the col column
 * @method     ChildBoard[]|ObjectCollection findByFigure(string $figure) Return ChildBoard objects filtered by the figure column
 * @method     ChildBoard[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class BoardQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\BoardQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Board', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildBoardQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildBoardQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildBoardQuery) {
            return $criteria;
        }
        $query = new ChildBoardQuery();
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
     * $obj = $c->findPk(array(12, 34, 56), $con);
     * </code>
     *
     * @param array[$id_board, $row, $col] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildBoard|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(BoardTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = BoardTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2])]))))) {
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
     * @return ChildBoard A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_board, row, col, figure FROM board WHERE id_board = :p0 AND row = :p1 AND col = :p2';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->bindValue(':p2', $key[2], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildBoard $obj */
            $obj = new ChildBoard();
            $obj->hydrate($row);
            BoardTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2])]));
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
     * @return ChildBoard|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildBoardQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(BoardTableMap::COL_ID_BOARD, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(BoardTableMap::COL_ROW, $key[1], Criteria::EQUAL);
        $this->addUsingAlias(BoardTableMap::COL_COL, $key[2], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildBoardQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(BoardTableMap::COL_ID_BOARD, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(BoardTableMap::COL_ROW, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $cton2 = $this->getNewCriterion(BoardTableMap::COL_COL, $key[2], Criteria::EQUAL);
            $cton0->addAnd($cton2);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the id_board column
     *
     * Example usage:
     * <code>
     * $query->filterByIdBoard(1234); // WHERE id_board = 1234
     * $query->filterByIdBoard(array(12, 34)); // WHERE id_board IN (12, 34)
     * $query->filterByIdBoard(array('min' => 12)); // WHERE id_board > 12
     * </code>
     *
     * @param     mixed $idBoard The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBoardQuery The current query, for fluid interface
     */
    public function filterByIdBoard($idBoard = null, $comparison = null)
    {
        if (is_array($idBoard)) {
            $useMinMax = false;
            if (isset($idBoard['min'])) {
                $this->addUsingAlias(BoardTableMap::COL_ID_BOARD, $idBoard['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idBoard['max'])) {
                $this->addUsingAlias(BoardTableMap::COL_ID_BOARD, $idBoard['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BoardTableMap::COL_ID_BOARD, $idBoard, $comparison);
    }

    /**
     * Filter the query on the row column
     *
     * Example usage:
     * <code>
     * $query->filterByRow(1234); // WHERE row = 1234
     * $query->filterByRow(array(12, 34)); // WHERE row IN (12, 34)
     * $query->filterByRow(array('min' => 12)); // WHERE row > 12
     * </code>
     *
     * @param     mixed $row The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBoardQuery The current query, for fluid interface
     */
    public function filterByRow($row = null, $comparison = null)
    {
        if (is_array($row)) {
            $useMinMax = false;
            if (isset($row['min'])) {
                $this->addUsingAlias(BoardTableMap::COL_ROW, $row['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($row['max'])) {
                $this->addUsingAlias(BoardTableMap::COL_ROW, $row['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BoardTableMap::COL_ROW, $row, $comparison);
    }

    /**
     * Filter the query on the col column
     *
     * Example usage:
     * <code>
     * $query->filterByCol(1234); // WHERE col = 1234
     * $query->filterByCol(array(12, 34)); // WHERE col IN (12, 34)
     * $query->filterByCol(array('min' => 12)); // WHERE col > 12
     * </code>
     *
     * @param     mixed $col The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBoardQuery The current query, for fluid interface
     */
    public function filterByCol($col = null, $comparison = null)
    {
        if (is_array($col)) {
            $useMinMax = false;
            if (isset($col['min'])) {
                $this->addUsingAlias(BoardTableMap::COL_COL, $col['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($col['max'])) {
                $this->addUsingAlias(BoardTableMap::COL_COL, $col['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BoardTableMap::COL_COL, $col, $comparison);
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
     * @return $this|ChildBoardQuery The current query, for fluid interface
     */
    public function filterByFigure($figure = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($figure)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BoardTableMap::COL_FIGURE, $figure, $comparison);
    }

    /**
     * Filter the query by a related \BoardHasFigures object
     *
     * @param \BoardHasFigures|ObjectCollection $boardHasFigures the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBoardQuery The current query, for fluid interface
     */
    public function filterByBoardHasFigures($boardHasFigures, $comparison = null)
    {
        if ($boardHasFigures instanceof \BoardHasFigures) {
            return $this
                ->addUsingAlias(BoardTableMap::COL_ID_BOARD, $boardHasFigures->getBoardIdBoard(), $comparison);
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
     * @return $this|ChildBoardQuery The current query, for fluid interface
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
     * Filter the query by a related \Games object
     *
     * @param \Games|ObjectCollection $games the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBoardQuery The current query, for fluid interface
     */
    public function filterByGames($games, $comparison = null)
    {
        if ($games instanceof \Games) {
            return $this
                ->addUsingAlias(BoardTableMap::COL_ID_BOARD, $games->getBoardIdBoard(), $comparison);
        } elseif ($games instanceof ObjectCollection) {
            return $this
                ->useGamesQuery()
                ->filterByPrimaryKeys($games->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGames() only accepts arguments of type \Games or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Games relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBoardQuery The current query, for fluid interface
     */
    public function joinGames($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Games');

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
            $this->addJoinObject($join, 'Games');
        }

        return $this;
    }

    /**
     * Use the Games relation Games object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GamesQuery A secondary query class using the current class as primary query
     */
    public function useGamesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGames($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Games', '\GamesQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildBoard $board Object to remove from the list of results
     *
     * @return $this|ChildBoardQuery The current query, for fluid interface
     */
    public function prune($board = null)
    {
        if ($board) {
            $this->addCond('pruneCond0', $this->getAliasedColName(BoardTableMap::COL_ID_BOARD), $board->getIdBoard(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(BoardTableMap::COL_ROW), $board->getRow(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond2', $this->getAliasedColName(BoardTableMap::COL_COL), $board->getCol(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1', 'pruneCond2'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the board table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BoardTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BoardTableMap::clearInstancePool();
            BoardTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(BoardTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(BoardTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            BoardTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            BoardTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // BoardQuery
