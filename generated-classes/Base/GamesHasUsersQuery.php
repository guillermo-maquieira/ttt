<?php

namespace Base;

use \GamesHasUsers as ChildGamesHasUsers;
use \GamesHasUsersQuery as ChildGamesHasUsersQuery;
use \Exception;
use \PDO;
use Map\GamesHasUsersTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'games_has_users' table.
 *
 *
 *
 * @method     ChildGamesHasUsersQuery orderByGamesIdGame($order = Criteria::ASC) Order by the games_id_game column
 * @method     ChildGamesHasUsersQuery orderByUsersIdUser($order = Criteria::ASC) Order by the users_id_user column
 *
 * @method     ChildGamesHasUsersQuery groupByGamesIdGame() Group by the games_id_game column
 * @method     ChildGamesHasUsersQuery groupByUsersIdUser() Group by the users_id_user column
 *
 * @method     ChildGamesHasUsersQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildGamesHasUsersQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildGamesHasUsersQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildGamesHasUsersQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildGamesHasUsersQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildGamesHasUsersQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildGamesHasUsersQuery leftJoinGames($relationAlias = null) Adds a LEFT JOIN clause to the query using the Games relation
 * @method     ChildGamesHasUsersQuery rightJoinGames($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Games relation
 * @method     ChildGamesHasUsersQuery innerJoinGames($relationAlias = null) Adds a INNER JOIN clause to the query using the Games relation
 *
 * @method     ChildGamesHasUsersQuery joinWithGames($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Games relation
 *
 * @method     ChildGamesHasUsersQuery leftJoinWithGames() Adds a LEFT JOIN clause and with to the query using the Games relation
 * @method     ChildGamesHasUsersQuery rightJoinWithGames() Adds a RIGHT JOIN clause and with to the query using the Games relation
 * @method     ChildGamesHasUsersQuery innerJoinWithGames() Adds a INNER JOIN clause and with to the query using the Games relation
 *
 * @method     ChildGamesHasUsersQuery leftJoinUsers($relationAlias = null) Adds a LEFT JOIN clause to the query using the Users relation
 * @method     ChildGamesHasUsersQuery rightJoinUsers($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Users relation
 * @method     ChildGamesHasUsersQuery innerJoinUsers($relationAlias = null) Adds a INNER JOIN clause to the query using the Users relation
 *
 * @method     ChildGamesHasUsersQuery joinWithUsers($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Users relation
 *
 * @method     ChildGamesHasUsersQuery leftJoinWithUsers() Adds a LEFT JOIN clause and with to the query using the Users relation
 * @method     ChildGamesHasUsersQuery rightJoinWithUsers() Adds a RIGHT JOIN clause and with to the query using the Users relation
 * @method     ChildGamesHasUsersQuery innerJoinWithUsers() Adds a INNER JOIN clause and with to the query using the Users relation
 *
 * @method     \GamesQuery|\UsersQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildGamesHasUsers findOne(ConnectionInterface $con = null) Return the first ChildGamesHasUsers matching the query
 * @method     ChildGamesHasUsers findOneOrCreate(ConnectionInterface $con = null) Return the first ChildGamesHasUsers matching the query, or a new ChildGamesHasUsers object populated from the query conditions when no match is found
 *
 * @method     ChildGamesHasUsers findOneByGamesIdGame(int $games_id_game) Return the first ChildGamesHasUsers filtered by the games_id_game column
 * @method     ChildGamesHasUsers findOneByUsersIdUser(int $users_id_user) Return the first ChildGamesHasUsers filtered by the users_id_user column *

 * @method     ChildGamesHasUsers requirePk($key, ConnectionInterface $con = null) Return the ChildGamesHasUsers by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGamesHasUsers requireOne(ConnectionInterface $con = null) Return the first ChildGamesHasUsers matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGamesHasUsers requireOneByGamesIdGame(int $games_id_game) Return the first ChildGamesHasUsers filtered by the games_id_game column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGamesHasUsers requireOneByUsersIdUser(int $users_id_user) Return the first ChildGamesHasUsers filtered by the users_id_user column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGamesHasUsers[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildGamesHasUsers objects based on current ModelCriteria
 * @method     ChildGamesHasUsers[]|ObjectCollection findByGamesIdGame(int $games_id_game) Return ChildGamesHasUsers objects filtered by the games_id_game column
 * @method     ChildGamesHasUsers[]|ObjectCollection findByUsersIdUser(int $users_id_user) Return ChildGamesHasUsers objects filtered by the users_id_user column
 * @method     ChildGamesHasUsers[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class GamesHasUsersQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\GamesHasUsersQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\GamesHasUsers', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildGamesHasUsersQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildGamesHasUsersQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildGamesHasUsersQuery) {
            return $criteria;
        }
        $query = new ChildGamesHasUsersQuery();
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
     * @param array[$games_id_game, $users_id_user] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildGamesHasUsers|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GamesHasUsersTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = GamesHasUsersTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildGamesHasUsers A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT games_id_game, users_id_user FROM games_has_users WHERE games_id_game = :p0 AND users_id_user = :p1';
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
            /** @var ChildGamesHasUsers $obj */
            $obj = new ChildGamesHasUsers();
            $obj->hydrate($row);
            GamesHasUsersTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildGamesHasUsers|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildGamesHasUsersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(GamesHasUsersTableMap::COL_GAMES_ID_GAME, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(GamesHasUsersTableMap::COL_USERS_ID_USER, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildGamesHasUsersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(GamesHasUsersTableMap::COL_GAMES_ID_GAME, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(GamesHasUsersTableMap::COL_USERS_ID_USER, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the games_id_game column
     *
     * Example usage:
     * <code>
     * $query->filterByGamesIdGame(1234); // WHERE games_id_game = 1234
     * $query->filterByGamesIdGame(array(12, 34)); // WHERE games_id_game IN (12, 34)
     * $query->filterByGamesIdGame(array('min' => 12)); // WHERE games_id_game > 12
     * </code>
     *
     * @see       filterByGames()
     *
     * @param     mixed $gamesIdGame The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGamesHasUsersQuery The current query, for fluid interface
     */
    public function filterByGamesIdGame($gamesIdGame = null, $comparison = null)
    {
        if (is_array($gamesIdGame)) {
            $useMinMax = false;
            if (isset($gamesIdGame['min'])) {
                $this->addUsingAlias(GamesHasUsersTableMap::COL_GAMES_ID_GAME, $gamesIdGame['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($gamesIdGame['max'])) {
                $this->addUsingAlias(GamesHasUsersTableMap::COL_GAMES_ID_GAME, $gamesIdGame['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamesHasUsersTableMap::COL_GAMES_ID_GAME, $gamesIdGame, $comparison);
    }

    /**
     * Filter the query on the users_id_user column
     *
     * Example usage:
     * <code>
     * $query->filterByUsersIdUser(1234); // WHERE users_id_user = 1234
     * $query->filterByUsersIdUser(array(12, 34)); // WHERE users_id_user IN (12, 34)
     * $query->filterByUsersIdUser(array('min' => 12)); // WHERE users_id_user > 12
     * </code>
     *
     * @see       filterByUsers()
     *
     * @param     mixed $usersIdUser The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGamesHasUsersQuery The current query, for fluid interface
     */
    public function filterByUsersIdUser($usersIdUser = null, $comparison = null)
    {
        if (is_array($usersIdUser)) {
            $useMinMax = false;
            if (isset($usersIdUser['min'])) {
                $this->addUsingAlias(GamesHasUsersTableMap::COL_USERS_ID_USER, $usersIdUser['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($usersIdUser['max'])) {
                $this->addUsingAlias(GamesHasUsersTableMap::COL_USERS_ID_USER, $usersIdUser['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamesHasUsersTableMap::COL_USERS_ID_USER, $usersIdUser, $comparison);
    }

    /**
     * Filter the query by a related \Games object
     *
     * @param \Games|ObjectCollection $games The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGamesHasUsersQuery The current query, for fluid interface
     */
    public function filterByGames($games, $comparison = null)
    {
        if ($games instanceof \Games) {
            return $this
                ->addUsingAlias(GamesHasUsersTableMap::COL_GAMES_ID_GAME, $games->getIdGame(), $comparison);
        } elseif ($games instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GamesHasUsersTableMap::COL_GAMES_ID_GAME, $games->toKeyValue('PrimaryKey', 'IdGame'), $comparison);
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
     * @return $this|ChildGamesHasUsersQuery The current query, for fluid interface
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
     * Filter the query by a related \Users object
     *
     * @param \Users|ObjectCollection $users The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGamesHasUsersQuery The current query, for fluid interface
     */
    public function filterByUsers($users, $comparison = null)
    {
        if ($users instanceof \Users) {
            return $this
                ->addUsingAlias(GamesHasUsersTableMap::COL_USERS_ID_USER, $users->getIdUser(), $comparison);
        } elseif ($users instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GamesHasUsersTableMap::COL_USERS_ID_USER, $users->toKeyValue('PrimaryKey', 'IdUser'), $comparison);
        } else {
            throw new PropelException('filterByUsers() only accepts arguments of type \Users or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Users relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGamesHasUsersQuery The current query, for fluid interface
     */
    public function joinUsers($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Users');

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
            $this->addJoinObject($join, 'Users');
        }

        return $this;
    }

    /**
     * Use the Users relation Users object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UsersQuery A secondary query class using the current class as primary query
     */
    public function useUsersQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUsers($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Users', '\UsersQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildGamesHasUsers $gamesHasUsers Object to remove from the list of results
     *
     * @return $this|ChildGamesHasUsersQuery The current query, for fluid interface
     */
    public function prune($gamesHasUsers = null)
    {
        if ($gamesHasUsers) {
            $this->addCond('pruneCond0', $this->getAliasedColName(GamesHasUsersTableMap::COL_GAMES_ID_GAME), $gamesHasUsers->getGamesIdGame(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(GamesHasUsersTableMap::COL_USERS_ID_USER), $gamesHasUsers->getUsersIdUser(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the games_has_users table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GamesHasUsersTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GamesHasUsersTableMap::clearInstancePool();
            GamesHasUsersTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(GamesHasUsersTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(GamesHasUsersTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            GamesHasUsersTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            GamesHasUsersTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // GamesHasUsersQuery
