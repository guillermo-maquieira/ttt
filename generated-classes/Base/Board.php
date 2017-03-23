<?php

namespace Base;

use \Board as ChildBoard;
use \BoardHasFigures as ChildBoardHasFigures;
use \BoardHasFiguresQuery as ChildBoardHasFiguresQuery;
use \BoardQuery as ChildBoardQuery;
use \Games as ChildGames;
use \GamesQuery as ChildGamesQuery;
use \Exception;
use \PDO;
use Map\BoardHasFiguresTableMap;
use Map\BoardTableMap;
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

/**
 * Base class that represents a row from the 'board' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Board implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\BoardTableMap';


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
     * The value for the id_board field.
     *
     * @var        int
     */
    protected $id_board;

    /**
     * The value for the row field.
     *
     * @var        int
     */
    protected $row;

    /**
     * The value for the col field.
     *
     * @var        int
     */
    protected $col;

    /**
     * The value for the figure field.
     *
     * @var        string
     */
    protected $figure;

    /**
     * @var        ObjectCollection|ChildBoardHasFigures[] Collection to store aggregation of ChildBoardHasFigures objects.
     */
    protected $collBoardHasFiguress;
    protected $collBoardHasFiguressPartial;

    /**
     * @var        ObjectCollection|ChildGames[] Collection to store aggregation of ChildGames objects.
     */
    protected $collGamess;
    protected $collGamessPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildBoardHasFigures[]
     */
    protected $boardHasFiguressScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGames[]
     */
    protected $gamessScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Board object.
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
     * Compares this with another <code>Board</code> instance.  If
     * <code>obj</code> is an instance of <code>Board</code>, delegates to
     * <code>equals(Board)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Board The current object, for fluid interface
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
     * Get the [id_board] column value.
     *
     * @return int
     */
    public function getIdBoard()
    {
        return $this->id_board;
    }

    /**
     * Get the [row] column value.
     *
     * @return int
     */
    public function getRow()
    {
        return $this->row;
    }

    /**
     * Get the [col] column value.
     *
     * @return int
     */
    public function getCol()
    {
        return $this->col;
    }

    /**
     * Get the [figure] column value.
     *
     * @return string
     */
    public function getFigure()
    {
        return $this->figure;
    }

    /**
     * Set the value of [id_board] column.
     *
     * @param int $v new value
     * @return $this|\Board The current object (for fluent API support)
     */
    public function setIdBoard($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_board !== $v) {
            $this->id_board = $v;
            $this->modifiedColumns[BoardTableMap::COL_ID_BOARD] = true;
        }

        return $this;
    } // setIdBoard()

    /**
     * Set the value of [row] column.
     *
     * @param int $v new value
     * @return $this|\Board The current object (for fluent API support)
     */
    public function setRow($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->row !== $v) {
            $this->row = $v;
            $this->modifiedColumns[BoardTableMap::COL_ROW] = true;
        }

        return $this;
    } // setRow()

    /**
     * Set the value of [col] column.
     *
     * @param int $v new value
     * @return $this|\Board The current object (for fluent API support)
     */
    public function setCol($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->col !== $v) {
            $this->col = $v;
            $this->modifiedColumns[BoardTableMap::COL_COL] = true;
        }

        return $this;
    } // setCol()

    /**
     * Set the value of [figure] column.
     *
     * @param string $v new value
     * @return $this|\Board The current object (for fluent API support)
     */
    public function setFigure($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->figure !== $v) {
            $this->figure = $v;
            $this->modifiedColumns[BoardTableMap::COL_FIGURE] = true;
        }

        return $this;
    } // setFigure()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : BoardTableMap::translateFieldName('IdBoard', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_board = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : BoardTableMap::translateFieldName('Row', TableMap::TYPE_PHPNAME, $indexType)];
            $this->row = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : BoardTableMap::translateFieldName('Col', TableMap::TYPE_PHPNAME, $indexType)];
            $this->col = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : BoardTableMap::translateFieldName('Figure', TableMap::TYPE_PHPNAME, $indexType)];
            $this->figure = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 4; // 4 = BoardTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Board'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(BoardTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildBoardQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collBoardHasFiguress = null;

            $this->collGamess = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Board::setDeleted()
     * @see Board::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(BoardTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildBoardQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(BoardTableMap::DATABASE_NAME);
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
                BoardTableMap::addInstanceToPool($this);
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

            if ($this->boardHasFiguressScheduledForDeletion !== null) {
                if (!$this->boardHasFiguressScheduledForDeletion->isEmpty()) {
                    \BoardHasFiguresQuery::create()
                        ->filterByPrimaryKeys($this->boardHasFiguressScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->boardHasFiguressScheduledForDeletion = null;
                }
            }

            if ($this->collBoardHasFiguress !== null) {
                foreach ($this->collBoardHasFiguress as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->gamessScheduledForDeletion !== null) {
                if (!$this->gamessScheduledForDeletion->isEmpty()) {
                    \GamesQuery::create()
                        ->filterByPrimaryKeys($this->gamessScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->gamessScheduledForDeletion = null;
                }
            }

            if ($this->collGamess !== null) {
                foreach ($this->collGamess as $referrerFK) {
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
        if ($this->isColumnModified(BoardTableMap::COL_ID_BOARD)) {
            $modifiedColumns[':p' . $index++]  = 'id_board';
        }
        if ($this->isColumnModified(BoardTableMap::COL_ROW)) {
            $modifiedColumns[':p' . $index++]  = 'row';
        }
        if ($this->isColumnModified(BoardTableMap::COL_COL)) {
            $modifiedColumns[':p' . $index++]  = 'col';
        }
        if ($this->isColumnModified(BoardTableMap::COL_FIGURE)) {
            $modifiedColumns[':p' . $index++]  = 'figure';
        }

        $sql = sprintf(
            'INSERT INTO board (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id_board':
                        $stmt->bindValue($identifier, $this->id_board, PDO::PARAM_INT);
                        break;
                    case 'row':
                        $stmt->bindValue($identifier, $this->row, PDO::PARAM_INT);
                        break;
                    case 'col':
                        $stmt->bindValue($identifier, $this->col, PDO::PARAM_INT);
                        break;
                    case 'figure':
                        $stmt->bindValue($identifier, $this->figure, PDO::PARAM_STR);
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
        $pos = BoardTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getIdBoard();
                break;
            case 1:
                return $this->getRow();
                break;
            case 2:
                return $this->getCol();
                break;
            case 3:
                return $this->getFigure();
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

        if (isset($alreadyDumpedObjects['Board'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Board'][$this->hashCode()] = true;
        $keys = BoardTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdBoard(),
            $keys[1] => $this->getRow(),
            $keys[2] => $this->getCol(),
            $keys[3] => $this->getFigure(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collBoardHasFiguress) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'boardHasFiguress';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'board_has_figuress';
                        break;
                    default:
                        $key = 'BoardHasFiguress';
                }

                $result[$key] = $this->collBoardHasFiguress->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collGamess) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'gamess';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'gamess';
                        break;
                    default:
                        $key = 'Gamess';
                }

                $result[$key] = $this->collGamess->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Board
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = BoardTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Board
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdBoard($value);
                break;
            case 1:
                $this->setRow($value);
                break;
            case 2:
                $this->setCol($value);
                break;
            case 3:
                $this->setFigure($value);
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
        $keys = BoardTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setIdBoard($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setRow($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setCol($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setFigure($arr[$keys[3]]);
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
     * @return $this|\Board The current object, for fluid interface
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
        $criteria = new Criteria(BoardTableMap::DATABASE_NAME);

        if ($this->isColumnModified(BoardTableMap::COL_ID_BOARD)) {
            $criteria->add(BoardTableMap::COL_ID_BOARD, $this->id_board);
        }
        if ($this->isColumnModified(BoardTableMap::COL_ROW)) {
            $criteria->add(BoardTableMap::COL_ROW, $this->row);
        }
        if ($this->isColumnModified(BoardTableMap::COL_COL)) {
            $criteria->add(BoardTableMap::COL_COL, $this->col);
        }
        if ($this->isColumnModified(BoardTableMap::COL_FIGURE)) {
            $criteria->add(BoardTableMap::COL_FIGURE, $this->figure);
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
        $criteria = ChildBoardQuery::create();
        $criteria->add(BoardTableMap::COL_ID_BOARD, $this->id_board);
        $criteria->add(BoardTableMap::COL_ROW, $this->row);
        $criteria->add(BoardTableMap::COL_COL, $this->col);

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
        $validPk = null !== $this->getIdBoard() &&
            null !== $this->getRow() &&
            null !== $this->getCol();

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
     * Returns the composite primary key for this object.
     * The array elements will be in same order as specified in XML.
     * @return array
     */
    public function getPrimaryKey()
    {
        $pks = array();
        $pks[0] = $this->getIdBoard();
        $pks[1] = $this->getRow();
        $pks[2] = $this->getCol();

        return $pks;
    }

    /**
     * Set the [composite] primary key.
     *
     * @param      array $keys The elements of the composite key (order must match the order in XML file).
     * @return void
     */
    public function setPrimaryKey($keys)
    {
        $this->setIdBoard($keys[0]);
        $this->setRow($keys[1]);
        $this->setCol($keys[2]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return (null === $this->getIdBoard()) && (null === $this->getRow()) && (null === $this->getCol());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Board (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setIdBoard($this->getIdBoard());
        $copyObj->setRow($this->getRow());
        $copyObj->setCol($this->getCol());
        $copyObj->setFigure($this->getFigure());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getBoardHasFiguress() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBoardHasFigures($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getGamess() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addGames($relObj->copy($deepCopy));
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
     * @return \Board Clone of current object.
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
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('BoardHasFigures' == $relationName) {
            return $this->initBoardHasFiguress();
        }
        if ('Games' == $relationName) {
            return $this->initGamess();
        }
    }

    /**
     * Clears out the collBoardHasFiguress collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addBoardHasFiguress()
     */
    public function clearBoardHasFiguress()
    {
        $this->collBoardHasFiguress = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collBoardHasFiguress collection loaded partially.
     */
    public function resetPartialBoardHasFiguress($v = true)
    {
        $this->collBoardHasFiguressPartial = $v;
    }

    /**
     * Initializes the collBoardHasFiguress collection.
     *
     * By default this just sets the collBoardHasFiguress collection to an empty array (like clearcollBoardHasFiguress());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBoardHasFiguress($overrideExisting = true)
    {
        if (null !== $this->collBoardHasFiguress && !$overrideExisting) {
            return;
        }

        $collectionClassName = BoardHasFiguresTableMap::getTableMap()->getCollectionClassName();

        $this->collBoardHasFiguress = new $collectionClassName;
        $this->collBoardHasFiguress->setModel('\BoardHasFigures');
    }

    /**
     * Gets an array of ChildBoardHasFigures objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBoard is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildBoardHasFigures[] List of ChildBoardHasFigures objects
     * @throws PropelException
     */
    public function getBoardHasFiguress(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collBoardHasFiguressPartial && !$this->isNew();
        if (null === $this->collBoardHasFiguress || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBoardHasFiguress) {
                // return empty collection
                $this->initBoardHasFiguress();
            } else {
                $collBoardHasFiguress = ChildBoardHasFiguresQuery::create(null, $criteria)
                    ->filterByBoard($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collBoardHasFiguressPartial && count($collBoardHasFiguress)) {
                        $this->initBoardHasFiguress(false);

                        foreach ($collBoardHasFiguress as $obj) {
                            if (false == $this->collBoardHasFiguress->contains($obj)) {
                                $this->collBoardHasFiguress->append($obj);
                            }
                        }

                        $this->collBoardHasFiguressPartial = true;
                    }

                    return $collBoardHasFiguress;
                }

                if ($partial && $this->collBoardHasFiguress) {
                    foreach ($this->collBoardHasFiguress as $obj) {
                        if ($obj->isNew()) {
                            $collBoardHasFiguress[] = $obj;
                        }
                    }
                }

                $this->collBoardHasFiguress = $collBoardHasFiguress;
                $this->collBoardHasFiguressPartial = false;
            }
        }

        return $this->collBoardHasFiguress;
    }

    /**
     * Sets a collection of ChildBoardHasFigures objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $boardHasFiguress A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildBoard The current object (for fluent API support)
     */
    public function setBoardHasFiguress(Collection $boardHasFiguress, ConnectionInterface $con = null)
    {
        /** @var ChildBoardHasFigures[] $boardHasFiguressToDelete */
        $boardHasFiguressToDelete = $this->getBoardHasFiguress(new Criteria(), $con)->diff($boardHasFiguress);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->boardHasFiguressScheduledForDeletion = clone $boardHasFiguressToDelete;

        foreach ($boardHasFiguressToDelete as $boardHasFiguresRemoved) {
            $boardHasFiguresRemoved->setBoard(null);
        }

        $this->collBoardHasFiguress = null;
        foreach ($boardHasFiguress as $boardHasFigures) {
            $this->addBoardHasFigures($boardHasFigures);
        }

        $this->collBoardHasFiguress = $boardHasFiguress;
        $this->collBoardHasFiguressPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BoardHasFigures objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related BoardHasFigures objects.
     * @throws PropelException
     */
    public function countBoardHasFiguress(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collBoardHasFiguressPartial && !$this->isNew();
        if (null === $this->collBoardHasFiguress || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBoardHasFiguress) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getBoardHasFiguress());
            }

            $query = ChildBoardHasFiguresQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBoard($this)
                ->count($con);
        }

        return count($this->collBoardHasFiguress);
    }

    /**
     * Method called to associate a ChildBoardHasFigures object to this object
     * through the ChildBoardHasFigures foreign key attribute.
     *
     * @param  ChildBoardHasFigures $l ChildBoardHasFigures
     * @return $this|\Board The current object (for fluent API support)
     */
    public function addBoardHasFigures(ChildBoardHasFigures $l)
    {
        if ($this->collBoardHasFiguress === null) {
            $this->initBoardHasFiguress();
            $this->collBoardHasFiguressPartial = true;
        }

        if (!$this->collBoardHasFiguress->contains($l)) {
            $this->doAddBoardHasFigures($l);

            if ($this->boardHasFiguressScheduledForDeletion and $this->boardHasFiguressScheduledForDeletion->contains($l)) {
                $this->boardHasFiguressScheduledForDeletion->remove($this->boardHasFiguressScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildBoardHasFigures $boardHasFigures The ChildBoardHasFigures object to add.
     */
    protected function doAddBoardHasFigures(ChildBoardHasFigures $boardHasFigures)
    {
        $this->collBoardHasFiguress[]= $boardHasFigures;
        $boardHasFigures->setBoard($this);
    }

    /**
     * @param  ChildBoardHasFigures $boardHasFigures The ChildBoardHasFigures object to remove.
     * @return $this|ChildBoard The current object (for fluent API support)
     */
    public function removeBoardHasFigures(ChildBoardHasFigures $boardHasFigures)
    {
        if ($this->getBoardHasFiguress()->contains($boardHasFigures)) {
            $pos = $this->collBoardHasFiguress->search($boardHasFigures);
            $this->collBoardHasFiguress->remove($pos);
            if (null === $this->boardHasFiguressScheduledForDeletion) {
                $this->boardHasFiguressScheduledForDeletion = clone $this->collBoardHasFiguress;
                $this->boardHasFiguressScheduledForDeletion->clear();
            }
            $this->boardHasFiguressScheduledForDeletion[]= clone $boardHasFigures;
            $boardHasFigures->setBoard(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Board is new, it will return
     * an empty collection; or if this Board has previously
     * been saved, it will retrieve related BoardHasFiguress from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Board.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildBoardHasFigures[] List of ChildBoardHasFigures objects
     */
    public function getBoardHasFiguressJoinFigures(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildBoardHasFiguresQuery::create(null, $criteria);
        $query->joinWith('Figures', $joinBehavior);

        return $this->getBoardHasFiguress($query, $con);
    }

    /**
     * Clears out the collGamess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addGamess()
     */
    public function clearGamess()
    {
        $this->collGamess = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collGamess collection loaded partially.
     */
    public function resetPartialGamess($v = true)
    {
        $this->collGamessPartial = $v;
    }

    /**
     * Initializes the collGamess collection.
     *
     * By default this just sets the collGamess collection to an empty array (like clearcollGamess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initGamess($overrideExisting = true)
    {
        if (null !== $this->collGamess && !$overrideExisting) {
            return;
        }

        $collectionClassName = GamesTableMap::getTableMap()->getCollectionClassName();

        $this->collGamess = new $collectionClassName;
        $this->collGamess->setModel('\Games');
    }

    /**
     * Gets an array of ChildGames objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBoard is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildGames[] List of ChildGames objects
     * @throws PropelException
     */
    public function getGamess(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collGamessPartial && !$this->isNew();
        if (null === $this->collGamess || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collGamess) {
                // return empty collection
                $this->initGamess();
            } else {
                $collGamess = ChildGamesQuery::create(null, $criteria)
                    ->filterByBoard($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collGamessPartial && count($collGamess)) {
                        $this->initGamess(false);

                        foreach ($collGamess as $obj) {
                            if (false == $this->collGamess->contains($obj)) {
                                $this->collGamess->append($obj);
                            }
                        }

                        $this->collGamessPartial = true;
                    }

                    return $collGamess;
                }

                if ($partial && $this->collGamess) {
                    foreach ($this->collGamess as $obj) {
                        if ($obj->isNew()) {
                            $collGamess[] = $obj;
                        }
                    }
                }

                $this->collGamess = $collGamess;
                $this->collGamessPartial = false;
            }
        }

        return $this->collGamess;
    }

    /**
     * Sets a collection of ChildGames objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $gamess A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildBoard The current object (for fluent API support)
     */
    public function setGamess(Collection $gamess, ConnectionInterface $con = null)
    {
        /** @var ChildGames[] $gamessToDelete */
        $gamessToDelete = $this->getGamess(new Criteria(), $con)->diff($gamess);


        $this->gamessScheduledForDeletion = $gamessToDelete;

        foreach ($gamessToDelete as $gamesRemoved) {
            $gamesRemoved->setBoard(null);
        }

        $this->collGamess = null;
        foreach ($gamess as $games) {
            $this->addGames($games);
        }

        $this->collGamess = $gamess;
        $this->collGamessPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Games objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Games objects.
     * @throws PropelException
     */
    public function countGamess(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collGamessPartial && !$this->isNew();
        if (null === $this->collGamess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collGamess) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getGamess());
            }

            $query = ChildGamesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBoard($this)
                ->count($con);
        }

        return count($this->collGamess);
    }

    /**
     * Method called to associate a ChildGames object to this object
     * through the ChildGames foreign key attribute.
     *
     * @param  ChildGames $l ChildGames
     * @return $this|\Board The current object (for fluent API support)
     */
    public function addGames(ChildGames $l)
    {
        if ($this->collGamess === null) {
            $this->initGamess();
            $this->collGamessPartial = true;
        }

        if (!$this->collGamess->contains($l)) {
            $this->doAddGames($l);

            if ($this->gamessScheduledForDeletion and $this->gamessScheduledForDeletion->contains($l)) {
                $this->gamessScheduledForDeletion->remove($this->gamessScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildGames $games The ChildGames object to add.
     */
    protected function doAddGames(ChildGames $games)
    {
        $this->collGamess[]= $games;
        $games->setBoard($this);
    }

    /**
     * @param  ChildGames $games The ChildGames object to remove.
     * @return $this|ChildBoard The current object (for fluent API support)
     */
    public function removeGames(ChildGames $games)
    {
        if ($this->getGamess()->contains($games)) {
            $pos = $this->collGamess->search($games);
            $this->collGamess->remove($pos);
            if (null === $this->gamessScheduledForDeletion) {
                $this->gamessScheduledForDeletion = clone $this->collGamess;
                $this->gamessScheduledForDeletion->clear();
            }
            $this->gamessScheduledForDeletion[]= clone $games;
            $games->setBoard(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id_board = null;
        $this->row = null;
        $this->col = null;
        $this->figure = null;
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
            if ($this->collBoardHasFiguress) {
                foreach ($this->collBoardHasFiguress as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collGamess) {
                foreach ($this->collGamess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collBoardHasFiguress = null;
        $this->collGamess = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(BoardTableMap::DEFAULT_STRING_FORMAT);
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
