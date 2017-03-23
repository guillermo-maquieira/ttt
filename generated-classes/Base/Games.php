<?php

namespace Base;

use \Board as ChildBoard;
use \BoardQuery as ChildBoardQuery;
use \Games as ChildGames;
use \GamesHasUsers as ChildGamesHasUsers;
use \GamesHasUsersQuery as ChildGamesHasUsersQuery;
use \GamesQuery as ChildGamesQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\GamesHasUsersTableMap;
use Map\GamesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'games' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Games implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\GamesTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id_game field.
     *
     * @var        int
     */
    protected $id_game;

    /**
     * The value for the created_at field.
     *
     * @var        DateTime
     */
    protected $created_at;

    /**
     * The value for the last_updated field.
     *
     * @var        DateTime
     */
    protected $last_updated;

    /**
     * The value for the board_id_board field.
     *
     * @var        int
     */
    protected $board_id_board;

    /**
     * @var        ChildBoard
     */
    protected $aBoard;

    /**
     * @var        ObjectCollection|ChildGamesHasUsers[] Collection to store aggregation of ChildGamesHasUsers objects.
     */
    protected $collGamesHasUserss;
    protected $collGamesHasUserssPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGamesHasUsers[]
     */
    protected $gamesHasUserssScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Games object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Games</code> instance.  If
     * <code>obj</code> is an instance of <code>Games</code>, delegates to
     * <code>equals(Games)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Games The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id_game] column value.
     *
     * @return int
     */
    public function getIdGame()
    {
        return $this->id_game;
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->created_at;
        } else {
            return $this->created_at instanceof \DateTimeInterface ? $this->created_at->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [last_updated] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getLastUpdated($format = NULL)
    {
        if ($format === null) {
            return $this->last_updated;
        } else {
            return $this->last_updated instanceof \DateTimeInterface ? $this->last_updated->format($format) : null;
        }
    }

    /**
     * Get the [board_id_board] column value.
     *
     * @return int
     */
    public function getBoardIdBoard()
    {
        return $this->board_id_board;
    }

    /**
     * Set the value of [id_game] column.
     *
     * @param int $v new value
     * @return $this|\Games The current object (for fluent API support)
     */
    public function setIdGame($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_game !== $v) {
            $this->id_game = $v;
            $this->modifiedColumns[GamesTableMap::COL_ID_GAME] = true;
        }

        return $this;
    } // setIdGame()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Games The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d") !== $this->created_at->format("Y-m-d")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[GamesTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [last_updated] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Games The current object (for fluent API support)
     */
    public function setLastUpdated($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->last_updated !== null || $dt !== null) {
            if ($this->last_updated === null || $dt === null || $dt->format("Y-m-d") !== $this->last_updated->format("Y-m-d")) {
                $this->last_updated = $dt === null ? null : clone $dt;
                $this->modifiedColumns[GamesTableMap::COL_LAST_UPDATED] = true;
            }
        } // if either are not null

        return $this;
    } // setLastUpdated()

    /**
     * Set the value of [board_id_board] column.
     *
     * @param int $v new value
     * @return $this|\Games The current object (for fluent API support)
     */
    public function setBoardIdBoard($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->board_id_board !== $v) {
            $this->board_id_board = $v;
            $this->modifiedColumns[GamesTableMap::COL_BOARD_ID_BOARD] = true;
        }

        if ($this->aBoard !== null && $this->aBoard->getIdBoard() !== $v) {
            $this->aBoard = null;
        }

        return $this;
    } // setBoardIdBoard()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : GamesTableMap::translateFieldName('IdGame', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_game = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : GamesTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : GamesTableMap::translateFieldName('LastUpdated', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->last_updated = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : GamesTableMap::translateFieldName('BoardIdBoard', TableMap::TYPE_PHPNAME, $indexType)];
            $this->board_id_board = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 4; // 4 = GamesTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Games'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aBoard !== null && $this->board_id_board !== $this->aBoard->getIdBoard()) {
            $this->aBoard = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GamesTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildGamesQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aBoard = null;
            $this->collGamesHasUserss = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Games::setDeleted()
     * @see Games::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(GamesTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildGamesQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(GamesTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                GamesTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aBoard !== null) {
                if ($this->aBoard->isModified() || $this->aBoard->isNew()) {
                    $affectedRows += $this->aBoard->save($con);
                }
                $this->setBoard($this->aBoard);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->gamesHasUserssScheduledForDeletion !== null) {
                if (!$this->gamesHasUserssScheduledForDeletion->isEmpty()) {
                    \GamesHasUsersQuery::create()
                        ->filterByPrimaryKeys($this->gamesHasUserssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->gamesHasUserssScheduledForDeletion = null;
                }
            }

            if ($this->collGamesHasUserss !== null) {
                foreach ($this->collGamesHasUserss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(GamesTableMap::COL_ID_GAME)) {
            $modifiedColumns[':p' . $index++]  = 'id_game';
        }
        if ($this->isColumnModified(GamesTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(GamesTableMap::COL_LAST_UPDATED)) {
            $modifiedColumns[':p' . $index++]  = 'last_updated';
        }
        if ($this->isColumnModified(GamesTableMap::COL_BOARD_ID_BOARD)) {
            $modifiedColumns[':p' . $index++]  = 'board_id_board';
        }

        $sql = sprintf(
            'INSERT INTO games (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id_game':
                        $stmt->bindValue($identifier, $this->id_game, PDO::PARAM_INT);
                        break;
                    case 'created_at':
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'last_updated':
                        $stmt->bindValue($identifier, $this->last_updated ? $this->last_updated->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'board_id_board':
                        $stmt->bindValue($identifier, $this->board_id_board, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = GamesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getIdGame();
                break;
            case 1:
                return $this->getCreatedAt();
                break;
            case 2:
                return $this->getLastUpdated();
                break;
            case 3:
                return $this->getBoardIdBoard();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Games'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Games'][$this->hashCode()] = true;
        $keys = GamesTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdGame(),
            $keys[1] => $this->getCreatedAt(),
            $keys[2] => $this->getLastUpdated(),
            $keys[3] => $this->getBoardIdBoard(),
        );
        if ($result[$keys[1]] instanceof \DateTime) {
            $result[$keys[1]] = $result[$keys[1]]->format('c');
        }

        if ($result[$keys[2]] instanceof \DateTime) {
            $result[$keys[2]] = $result[$keys[2]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aBoard) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'board';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'board';
                        break;
                    default:
                        $key = 'Board';
                }

                $result[$key] = $this->aBoard->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collGamesHasUserss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'gamesHasUserss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'games_has_userss';
                        break;
                    default:
                        $key = 'GamesHasUserss';
                }

                $result[$key] = $this->collGamesHasUserss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Games
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = GamesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Games
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdGame($value);
                break;
            case 1:
                $this->setCreatedAt($value);
                break;
            case 2:
                $this->setLastUpdated($value);
                break;
            case 3:
                $this->setBoardIdBoard($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = GamesTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setIdGame($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setCreatedAt($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setLastUpdated($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setBoardIdBoard($arr[$keys[3]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Games The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(GamesTableMap::DATABASE_NAME);

        if ($this->isColumnModified(GamesTableMap::COL_ID_GAME)) {
            $criteria->add(GamesTableMap::COL_ID_GAME, $this->id_game);
        }
        if ($this->isColumnModified(GamesTableMap::COL_CREATED_AT)) {
            $criteria->add(GamesTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(GamesTableMap::COL_LAST_UPDATED)) {
            $criteria->add(GamesTableMap::COL_LAST_UPDATED, $this->last_updated);
        }
        if ($this->isColumnModified(GamesTableMap::COL_BOARD_ID_BOARD)) {
            $criteria->add(GamesTableMap::COL_BOARD_ID_BOARD, $this->board_id_board);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildGamesQuery::create();
        $criteria->add(GamesTableMap::COL_ID_GAME, $this->id_game);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getIdGame();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getIdGame();
    }

    /**
     * Generic method to set the primary key (id_game column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdGame($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getIdGame();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Games (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setIdGame($this->getIdGame());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setLastUpdated($this->getLastUpdated());
        $copyObj->setBoardIdBoard($this->getBoardIdBoard());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getGamesHasUserss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addGamesHasUsers($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Games Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildBoard object.
     *
     * @param  ChildBoard $v
     * @return $this|\Games The current object (for fluent API support)
     * @throws PropelException
     */
    public function setBoard(ChildBoard $v = null)
    {
        if ($v === null) {
            $this->setBoardIdBoard(NULL);
        } else {
            $this->setBoardIdBoard($v->getIdBoard());
        }

        $this->aBoard = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildBoard object, it will not be re-added.
        if ($v !== null) {
            $v->addGames($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildBoard object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildBoard The associated ChildBoard object.
     * @throws PropelException
     */
    public function getBoard(ConnectionInterface $con = null)
    {
        if ($this->aBoard === null && ($this->board_id_board !== null)) {
            $this->aBoard = ChildBoardQuery::create()
                ->filterByGames($this) // here
                ->findOne($con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aBoard->addGamess($this);
             */
        }

        return $this->aBoard;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('GamesHasUsers' == $relationName) {
            return $this->initGamesHasUserss();
        }
    }

    /**
     * Clears out the collGamesHasUserss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addGamesHasUserss()
     */
    public function clearGamesHasUserss()
    {
        $this->collGamesHasUserss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collGamesHasUserss collection loaded partially.
     */
    public function resetPartialGamesHasUserss($v = true)
    {
        $this->collGamesHasUserssPartial = $v;
    }

    /**
     * Initializes the collGamesHasUserss collection.
     *
     * By default this just sets the collGamesHasUserss collection to an empty array (like clearcollGamesHasUserss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initGamesHasUserss($overrideExisting = true)
    {
        if (null !== $this->collGamesHasUserss && !$overrideExisting) {
            return;
        }

        $collectionClassName = GamesHasUsersTableMap::getTableMap()->getCollectionClassName();

        $this->collGamesHasUserss = new $collectionClassName;
        $this->collGamesHasUserss->setModel('\GamesHasUsers');
    }

    /**
     * Gets an array of ChildGamesHasUsers objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildGames is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildGamesHasUsers[] List of ChildGamesHasUsers objects
     * @throws PropelException
     */
    public function getGamesHasUserss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collGamesHasUserssPartial && !$this->isNew();
        if (null === $this->collGamesHasUserss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collGamesHasUserss) {
                // return empty collection
                $this->initGamesHasUserss();
            } else {
                $collGamesHasUserss = ChildGamesHasUsersQuery::create(null, $criteria)
                    ->filterByGames($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collGamesHasUserssPartial && count($collGamesHasUserss)) {
                        $this->initGamesHasUserss(false);

                        foreach ($collGamesHasUserss as $obj) {
                            if (false == $this->collGamesHasUserss->contains($obj)) {
                                $this->collGamesHasUserss->append($obj);
                            }
                        }

                        $this->collGamesHasUserssPartial = true;
                    }

                    return $collGamesHasUserss;
                }

                if ($partial && $this->collGamesHasUserss) {
                    foreach ($this->collGamesHasUserss as $obj) {
                        if ($obj->isNew()) {
                            $collGamesHasUserss[] = $obj;
                        }
                    }
                }

                $this->collGamesHasUserss = $collGamesHasUserss;
                $this->collGamesHasUserssPartial = false;
            }
        }

        return $this->collGamesHasUserss;
    }

    /**
     * Sets a collection of ChildGamesHasUsers objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $gamesHasUserss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildGames The current object (for fluent API support)
     */
    public function setGamesHasUserss(Collection $gamesHasUserss, ConnectionInterface $con = null)
    {
        /** @var ChildGamesHasUsers[] $gamesHasUserssToDelete */
        $gamesHasUserssToDelete = $this->getGamesHasUserss(new Criteria(), $con)->diff($gamesHasUserss);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->gamesHasUserssScheduledForDeletion = clone $gamesHasUserssToDelete;

        foreach ($gamesHasUserssToDelete as $gamesHasUsersRemoved) {
            $gamesHasUsersRemoved->setGames(null);
        }

        $this->collGamesHasUserss = null;
        foreach ($gamesHasUserss as $gamesHasUsers) {
            $this->addGamesHasUsers($gamesHasUsers);
        }

        $this->collGamesHasUserss = $gamesHasUserss;
        $this->collGamesHasUserssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related GamesHasUsers objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related GamesHasUsers objects.
     * @throws PropelException
     */
    public function countGamesHasUserss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collGamesHasUserssPartial && !$this->isNew();
        if (null === $this->collGamesHasUserss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collGamesHasUserss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getGamesHasUserss());
            }

            $query = ChildGamesHasUsersQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByGames($this)
                ->count($con);
        }

        return count($this->collGamesHasUserss);
    }

    /**
     * Method called to associate a ChildGamesHasUsers object to this object
     * through the ChildGamesHasUsers foreign key attribute.
     *
     * @param  ChildGamesHasUsers $l ChildGamesHasUsers
     * @return $this|\Games The current object (for fluent API support)
     */
    public function addGamesHasUsers(ChildGamesHasUsers $l)
    {
        if ($this->collGamesHasUserss === null) {
            $this->initGamesHasUserss();
            $this->collGamesHasUserssPartial = true;
        }

        if (!$this->collGamesHasUserss->contains($l)) {
            $this->doAddGamesHasUsers($l);

            if ($this->gamesHasUserssScheduledForDeletion and $this->gamesHasUserssScheduledForDeletion->contains($l)) {
                $this->gamesHasUserssScheduledForDeletion->remove($this->gamesHasUserssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildGamesHasUsers $gamesHasUsers The ChildGamesHasUsers object to add.
     */
    protected function doAddGamesHasUsers(ChildGamesHasUsers $gamesHasUsers)
    {
        $this->collGamesHasUserss[]= $gamesHasUsers;
        $gamesHasUsers->setGames($this);
    }

    /**
     * @param  ChildGamesHasUsers $gamesHasUsers The ChildGamesHasUsers object to remove.
     * @return $this|ChildGames The current object (for fluent API support)
     */
    public function removeGamesHasUsers(ChildGamesHasUsers $gamesHasUsers)
    {
        if ($this->getGamesHasUserss()->contains($gamesHasUsers)) {
            $pos = $this->collGamesHasUserss->search($gamesHasUsers);
            $this->collGamesHasUserss->remove($pos);
            if (null === $this->gamesHasUserssScheduledForDeletion) {
                $this->gamesHasUserssScheduledForDeletion = clone $this->collGamesHasUserss;
                $this->gamesHasUserssScheduledForDeletion->clear();
            }
            $this->gamesHasUserssScheduledForDeletion[]= clone $gamesHasUsers;
            $gamesHasUsers->setGames(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Games is new, it will return
     * an empty collection; or if this Games has previously
     * been saved, it will retrieve related GamesHasUserss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Games.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGamesHasUsers[] List of ChildGamesHasUsers objects
     */
    public function getGamesHasUserssJoinUsers(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGamesHasUsersQuery::create(null, $criteria);
        $query->joinWith('Users', $joinBehavior);

        return $this->getGamesHasUserss($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aBoard) {
            $this->aBoard->removeGames($this);
        }
        $this->id_game = null;
        $this->created_at = null;
        $this->last_updated = null;
        $this->board_id_board = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collGamesHasUserss) {
                foreach ($this->collGamesHasUserss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collGamesHasUserss = null;
        $this->aBoard = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(GamesTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
