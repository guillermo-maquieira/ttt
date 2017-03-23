<?php

namespace Base;

use \Games as ChildGames;
use \GamesQuery as ChildGamesQuery;
use \Exception;
use \PDO;
use Map\GamesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'games' table.
 *
 *
 *
 * @method     ChildGamesQuery orderByIdGame($order = Criteria::ASC) Order by the id_game column
 * @method     ChildGamesQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildGamesQuery orderByLastUpdated($order = Criteria::ASC) Order by the last_updated column
 * @method     ChildGamesQuery orderByBoardIdBoard($order = Criteria::ASC) Order by the board_id_board column
 *
 * @method     ChildGamesQuery groupByIdGame() Group by the id_game column
 * @method     ChildGamesQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildGamesQuery groupByLastUpdated() Group by the last_updated column
 * @method     ChildGamesQuery groupByBoardIdBoard() Group by the board_id_board column
 *
 * @method     ChildGamesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildGamesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildGamesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildGamesQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildGamesQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildGamesQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildGamesQuery leftJoinBoard($relationAlias = null) Adds a LEFT JOIN clause to the query using the Board relation
 * @method     ChildGamesQuery rightJoinBoard($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Board relation
 * @method     ChildGamesQuery innerJoinBoard($relationAlias = null) Adds a INNER JOIN clause to the query using the Board relation
 *
 * @method     ChildGamesQuery joinWithBoard($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Board relation
 *
 * @method     ChildGamesQuery leftJoinWithBoard() Adds a LEFT JOIN clause and with to the query using the Board relation
 * @method     ChildGamesQuery rightJoinWithBoard() Adds a RIGHT JOIN clause and with to the query using the Board relation
 * @method     ChildGamesQuery innerJoinWithBoard() Adds a INNER JOIN clause and with to the query using the Board relation
 *
 * @method     ChildGamesQuery leftJoinGamesHasUsers($relationAlias = null) Adds a LEFT JOIN clause to the query using the GamesHasUsers relation
 * @method     ChildGamesQuery rightJoinGamesHasUsers($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GamesHasUsers relation
 * @method     ChildGamesQuery innerJoinGamesHasUsers($relationAlias = null) Adds a INNER JOIN clause to the query using the GamesHasUsers relation
 *
 * @method     ChildGamesQuery joinWithGamesHasUsers($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the GamesHasUsers relation
 *
 * @method     ChildGamesQuery leftJoinWithGamesHasUsers() Adds a LEFT JOIN clause and with to the query using the GamesHasUsers relation
 * @method     ChildGamesQuery rightJoinWithGamesHasUsers() Adds a RIGHT JOIN clause and with to the query using the GamesHasUsers relation
 * @method     ChildGamesQuery innerJoinWithGamesHasUsers() Adds a INNER JOIN clause and with to the query using the GamesHasUsers relation
 *
 * @method     \BoardQuery|\GamesHasUsersQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildGames findOne(ConnectionInterface $con = null) Return the first ChildGames matching the query
 * @method     ChildGames findOneOrCreate(ConnectionInterface $con = null) Return the first ChildGames matching the query, or a new ChildGames object populated from the query conditions when no match is found
 *
 * @method     ChildGames findOneByIdGame(int $id_game) Return the first ChildGames filtered by the id_game column
 * @method     ChildGames findOneByCreatedAt(string $created_at) Return the first ChildGames filtered by the created_at column
 * @method     ChildGames findOneByLastUpdated(string $last_updated) Return the first ChildGames filtered by the last_updated column
 * @method     ChildGames findOneByBoardIdBoard(int $board_id_board) Return the first ChildGames filtered by the board_id_board column *

 * @method     ChildGames requirePk($key, ConnectionInterface $con = null) Return the ChildGames by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGames requireOne(ConnectionInterface $con = null) Return the first ChildGames matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGames requireOneByIdGame(int $id_game) Return the first ChildGames filtered by the id_game column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGames requireOneByCreatedAt(string $created_at) Return the first ChildGames filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGames requireOneByLastUpdated(string $last_updated) Return the first ChildGames filtered by the last_updated column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGames requireOneByBoardIdBoard(int $board_id_board) Return the first ChildGames filtered by the board_id_board column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGames[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildGames objects based on current ModelCriteria
 * @method     ChildGames[]|ObjectCollection findByIdGame(int $id_game) Return ChildGames objects filtered by the id_game column
 * @method     ChildGames[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildGames objects filtered by the created_at column
 * @method     ChildGames[]|ObjectCollection findByLastUpdated(string $last_updated) Return ChildGames objects filtered by the last_updated column
 * @method     ChildGames[]|ObjectCollection findByBoardIdBoard(int $board_id_board) Return ChildGames objects filtered by the board_id_board column
 * @method     ChildGames[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class GamesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\GamesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Games', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildGamesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildGamesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildGamesQuery) {
            return $criteria;
        }
        $query = new ChildGamesQuery();
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
     * @return ChildGames|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GamesTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = GamesTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildGames A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_game, created_at, last_updated, board_id_board FROM games WHERE id_game = :p0';
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
            /** @var ChildGames $obj */
            $obj = new ChildGames();
            $obj->hydrate($row);
            GamesTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildGames|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildGamesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(GamesTableMap::COL_ID_GAME, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildGamesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(GamesTableMap::COL_ID_GAME, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_game column
     *
     * Example usage:
     * <code>
     * $query->filterByIdGame(1234); // WHERE id_game = 1234
     * $query->filterByIdGame(array(12, 34)); // WHERE id_game IN (12, 34)
     * $query->filterByIdGame(array('min' => 12)); // WHERE id_game > 12
     * </code>
     *
     * @param     mixed $idGame The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGamesQuery The current query, for fluid interface
     */
    public function filterByIdGame($idGame = null, $comparison = null)
    {
        if (is_array($idGame)) {
            $useMinMax = false;
            if (isset($idGame['min'])) {
                $this->addUsingAlias(GamesTableMap::COL_ID_GAME, $idGame['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idGame['max'])) {
                $this->addUsingAlias(GamesTableMap::COL_ID_GAME, $idGame['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamesTableMap::COL_ID_GAME, $idGame, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGamesQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(GamesTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(GamesTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamesTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the last_updated column
     *
     * Example usage:
     * <code>
     * $query->filterByLastUpdated('2011-03-14'); // WHERE last_updated = '2011-03-14'
     * $query->filterByLastUpdated('now'); // WHERE last_updated = '2011-03-14'
     * $query->filterByLastUpdated(array('max' => 'yesterday')); // WHERE last_updated > '2011-03-13'
     * </code>
     *
     * @param     mixed $lastUpdated The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGamesQuery The current query, for fluid interface
     */
    public function filterByLastUpdated($lastUpdated = null, $comparison = null)
    {
        if (is_array($lastUpdated)) {
            $useMinMax = false;
            if (isset($lastUpdated['min'])) {
                $this->addUsingAlias(GamesTableMap::COL_LAST_UPDATED, $lastUpdated['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastUpdated['max'])) {
                $this->addUsingAlias(GamesTableMap::COL_LAST_UPDATED, $lastUpdated['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamesTableMap::COL_LAST_UPDATED, $lastUpdated, $comparison);
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
     * @return $this|ChildGamesQuery The current query, for fluid interface
     */
    public function filterByBoardIdBoard($boardIdBoard = null, $comparison = null)
    {
        if (is_array($boardIdBoard)) {
            $useMinMax = false;
            if (isset($boardIdBoard['min'])) {
                $this->addUsingAlias(GamesTableMap::COL_BOARD_ID_BOARD, $boardIdBoard['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($boardIdBoard['max'])) {
                $this->addUsingAlias(GamesTableMap::COL_BOARD_ID_BOARD, $boardIdBoard['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamesTableMap::COL_BOARD_ID_BOARD, $boardIdBoard, $comparison);
    }

    /**
     * Filter the query by a related \Board object
     *
     * @param \Board|ObjectCollection $board The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGamesQuery The current query, for fluid interface
     */
    public function filterByBoard($board, $comparison = null)
    {
        if ($board instanceof \Board) {
            return $this
                ->addUsingAlias(GamesTableMap::COL_BOARD_ID_BOARD, $board->getIdBoard(), $comparison);
        } elseif ($board instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GamesTableMap::COL_BOARD_ID_BOARD, $board->toKeyValue('IdBoard', 'IdBoard'), $comparison);
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
     * @return $this|ChildGamesQuery The current query, for fluid interface
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
     * Filter the query by a related \GamesHasUsers object
     *
     * @param \GamesHasUsers|ObjectCollection $gamesHasUsers the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGamesQuery The current query, for fluid interface
     */
    public function filterByGamesHasUsers($gamesHasUsers, $comparison = null)
    {
        if ($gamesHasUsers instanceof \GamesHasUsers) {
            return $this
                ->addUsingAlias(GamesTableMap::COL_ID_GAME, $gamesHasUsers->getGamesIdGame(), $comparison);
        } elseif ($gamesHasUsers instanceof ObjectCollection) {
            return $this
                ->useGamesHasUsersQuery()
                ->filterByPrimaryKeys($gamesHasUsers->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGamesHasUsers() only accepts arguments of type \GamesHasUsers or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GamesHasUsers relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGamesQuery The current query, for fluid interface
     */
    public function joinGamesHasUsers($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GamesHasUsers');

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
            $this->addJoinObject($join, 'GamesHasUsers');
        }

        return $this;
    }

    /**
     * Use the GamesHasUsers relation GamesHasUsers object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GamesHasUsersQuery A secondary query class using the current class as primary query
     */
    public function useGamesHasUsersQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGamesHasUsers($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GamesHasUsers', '\GamesHasUsersQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildGames $games Object to remove from the list of results
     *
     * @return $this|ChildGamesQuery The current query, for fluid interface
     */
    public function prune($games = null)
    {
        if ($games) {
            $this->addUsingAlias(GamesTableMap::COL_ID_GAME, $games->getIdGame(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the games table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GamesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GamesTableMap::clearInstancePool();
            GamesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(GamesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(GamesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            GamesTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            GamesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // GamesQuery
