<?php

namespace bdxe\Base;

use \Exception;
use \PDO;
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
use bdxe\Course as ChildCourse;
use bdxe\CourseQuery as ChildCourseQuery;
use bdxe\HomeworkEval as ChildHomeworkEval;
use bdxe\HomeworkEvalQuery as ChildHomeworkEvalQuery;
use bdxe\Pack as ChildPack;
use bdxe\PackQuery as ChildPackQuery;
use bdxe\ProjectEval as ChildProjectEval;
use bdxe\ProjectEvalQuery as ChildProjectEvalQuery;
use bdxe\Student as ChildStudent;
use bdxe\StudentQuery as ChildStudentQuery;
use bdxe\Subscription as ChildSubscription;
use bdxe\SubscriptionQuery as ChildSubscriptionQuery;
use bdxe\TestEval as ChildTestEval;
use bdxe\TestEvalQuery as ChildTestEvalQuery;
use bdxe\Map\SubscriptionTableMap;

/**
 * Base class that represents a row from the 'subscription_tb' table.
 *
 * 
 *
* @package    propel.generator.bdxe.Base
*/
abstract class Subscription implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\bdxe\\Map\\SubscriptionTableMap';


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
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the student_id field.
     * @var        int
     */
    protected $student_id;

    /**
     * The value for the course_id field.
     * @var        int
     */
    protected $course_id;

    /**
     * @var        ChildStudent
     */
    protected $aStudent;

    /**
     * @var        ChildCourse
     */
    protected $aCourse;

    /**
     * @var        ObjectCollection|ChildHomeworkEval[] Collection to store aggregation of ChildHomeworkEval objects.
     */
    protected $collHomeworkEvals;
    protected $collHomeworkEvalsPartial;

    /**
     * @var        ObjectCollection|ChildTestEval[] Collection to store aggregation of ChildTestEval objects.
     */
    protected $collTestEvals;
    protected $collTestEvalsPartial;

    /**
     * @var        ObjectCollection|ChildProjectEval[] Collection to store aggregation of ChildProjectEval objects.
     */
    protected $collProjectEvals;
    protected $collProjectEvalsPartial;

    /**
     * @var        ObjectCollection|ChildPack[] Collection to store aggregation of ChildPack objects.
     */
    protected $collPacks;
    protected $collPacksPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildHomeworkEval[]
     */
    protected $homeworkEvalsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTestEval[]
     */
    protected $testEvalsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildProjectEval[]
     */
    protected $projectEvalsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPack[]
     */
    protected $packsScheduledForDeletion = null;

    /**
     * Initializes internal state of bdxe\Base\Subscription object.
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
     * Compares this with another <code>Subscription</code> instance.  If
     * <code>obj</code> is an instance of <code>Subscription</code>, delegates to
     * <code>equals(Subscription)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Subscription The current object, for fluid interface
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

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [id] column value.
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [student_id] column value.
     * 
     * @return int
     */
    public function getStudentId()
    {
        return $this->student_id;
    }

    /**
     * Get the [course_id] column value.
     * 
     * @return int
     */
    public function getCourseId()
    {
        return $this->course_id;
    }

    /**
     * Set the value of [id] column.
     * 
     * @param int $v new value
     * @return $this|\bdxe\Subscription The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[SubscriptionTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [student_id] column.
     * 
     * @param int $v new value
     * @return $this|\bdxe\Subscription The current object (for fluent API support)
     */
    public function setStudentId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->student_id !== $v) {
            $this->student_id = $v;
            $this->modifiedColumns[SubscriptionTableMap::COL_STUDENT_ID] = true;
        }

        if ($this->aStudent !== null && $this->aStudent->getId() !== $v) {
            $this->aStudent = null;
        }

        return $this;
    } // setStudentId()

    /**
     * Set the value of [course_id] column.
     * 
     * @param int $v new value
     * @return $this|\bdxe\Subscription The current object (for fluent API support)
     */
    public function setCourseId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->course_id !== $v) {
            $this->course_id = $v;
            $this->modifiedColumns[SubscriptionTableMap::COL_COURSE_ID] = true;
        }

        if ($this->aCourse !== null && $this->aCourse->getId() !== $v) {
            $this->aCourse = null;
        }

        return $this;
    } // setCourseId()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SubscriptionTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SubscriptionTableMap::translateFieldName('StudentId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->student_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SubscriptionTableMap::translateFieldName('CourseId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->course_id = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 3; // 3 = SubscriptionTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\bdxe\\Subscription'), 0, $e);
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
        if ($this->aStudent !== null && $this->student_id !== $this->aStudent->getId()) {
            $this->aStudent = null;
        }
        if ($this->aCourse !== null && $this->course_id !== $this->aCourse->getId()) {
            $this->aCourse = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(SubscriptionTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSubscriptionQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aStudent = null;
            $this->aCourse = null;
            $this->collHomeworkEvals = null;

            $this->collTestEvals = null;

            $this->collProjectEvals = null;

            $this->collPacks = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Subscription::setDeleted()
     * @see Subscription::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SubscriptionTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSubscriptionQuery::create()
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

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SubscriptionTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
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
                SubscriptionTableMap::addInstanceToPool($this);
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

            if ($this->aStudent !== null) {
                if ($this->aStudent->isModified() || $this->aStudent->isNew()) {
                    $affectedRows += $this->aStudent->save($con);
                }
                $this->setStudent($this->aStudent);
            }

            if ($this->aCourse !== null) {
                if ($this->aCourse->isModified() || $this->aCourse->isNew()) {
                    $affectedRows += $this->aCourse->save($con);
                }
                $this->setCourse($this->aCourse);
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

            if ($this->homeworkEvalsScheduledForDeletion !== null) {
                if (!$this->homeworkEvalsScheduledForDeletion->isEmpty()) {
                    foreach ($this->homeworkEvalsScheduledForDeletion as $homeworkEval) {
                        // need to save related object because we set the relation to null
                        $homeworkEval->save($con);
                    }
                    $this->homeworkEvalsScheduledForDeletion = null;
                }
            }

            if ($this->collHomeworkEvals !== null) {
                foreach ($this->collHomeworkEvals as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->testEvalsScheduledForDeletion !== null) {
                if (!$this->testEvalsScheduledForDeletion->isEmpty()) {
                    foreach ($this->testEvalsScheduledForDeletion as $testEval) {
                        // need to save related object because we set the relation to null
                        $testEval->save($con);
                    }
                    $this->testEvalsScheduledForDeletion = null;
                }
            }

            if ($this->collTestEvals !== null) {
                foreach ($this->collTestEvals as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->projectEvalsScheduledForDeletion !== null) {
                if (!$this->projectEvalsScheduledForDeletion->isEmpty()) {
                    foreach ($this->projectEvalsScheduledForDeletion as $projectEval) {
                        // need to save related object because we set the relation to null
                        $projectEval->save($con);
                    }
                    $this->projectEvalsScheduledForDeletion = null;
                }
            }

            if ($this->collProjectEvals !== null) {
                foreach ($this->collProjectEvals as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->packsScheduledForDeletion !== null) {
                if (!$this->packsScheduledForDeletion->isEmpty()) {
                    foreach ($this->packsScheduledForDeletion as $pack) {
                        // need to save related object because we set the relation to null
                        $pack->save($con);
                    }
                    $this->packsScheduledForDeletion = null;
                }
            }

            if ($this->collPacks !== null) {
                foreach ($this->collPacks as $referrerFK) {
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

        $this->modifiedColumns[SubscriptionTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SubscriptionTableMap::COL_ID . ')');
        }
        if (null === $this->id) {
            try {                
                $dataFetcher = $con->query('SELECT subscription_tb_SEQ.nextval FROM dual');
                $this->id = $dataFetcher->fetchColumn();
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', 0, $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SubscriptionTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(SubscriptionTableMap::COL_STUDENT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'student_id';
        }
        if ($this->isColumnModified(SubscriptionTableMap::COL_COURSE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'course_id';
        }

        $sql = sprintf(
            'INSERT INTO subscription_tb (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':                        
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'student_id':                        
                        $stmt->bindValue($identifier, $this->student_id, PDO::PARAM_INT);
                        break;
                    case 'course_id':                        
                        $stmt->bindValue($identifier, $this->course_id, PDO::PARAM_INT);
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
        $pos = SubscriptionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getId();
                break;
            case 1:
                return $this->getStudentId();
                break;
            case 2:
                return $this->getCourseId();
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

        if (isset($alreadyDumpedObjects['Subscription'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Subscription'][$this->hashCode()] = true;
        $keys = SubscriptionTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getStudentId(),
            $keys[2] => $this->getCourseId(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->aStudent) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'student';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'student_tb';
                        break;
                    default:
                        $key = 'Student';
                }
        
                $result[$key] = $this->aStudent->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aCourse) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'course';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'course_tb';
                        break;
                    default:
                        $key = 'Course';
                }
        
                $result[$key] = $this->aCourse->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collHomeworkEvals) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'homeworkEvals';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'homeworkeval_tbs';
                        break;
                    default:
                        $key = 'HomeworkEvals';
                }
        
                $result[$key] = $this->collHomeworkEvals->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTestEvals) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'testEvals';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'testeval_tbs';
                        break;
                    default:
                        $key = 'TestEvals';
                }
        
                $result[$key] = $this->collTestEvals->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collProjectEvals) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'projectEvals';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'projecteval_tbs';
                        break;
                    default:
                        $key = 'ProjectEvals';
                }
        
                $result[$key] = $this->collProjectEvals->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPacks) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'packs';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'pack_tbs';
                        break;
                    default:
                        $key = 'Packs';
                }
        
                $result[$key] = $this->collPacks->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\bdxe\Subscription
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SubscriptionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\bdxe\Subscription
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setStudentId($value);
                break;
            case 2:
                $this->setCourseId($value);
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
        $keys = SubscriptionTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setStudentId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setCourseId($arr[$keys[2]]);
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
     * @return $this|\bdxe\Subscription The current object, for fluid interface
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
        $criteria = new Criteria(SubscriptionTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SubscriptionTableMap::COL_ID)) {
            $criteria->add(SubscriptionTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(SubscriptionTableMap::COL_STUDENT_ID)) {
            $criteria->add(SubscriptionTableMap::COL_STUDENT_ID, $this->student_id);
        }
        if ($this->isColumnModified(SubscriptionTableMap::COL_COURSE_ID)) {
            $criteria->add(SubscriptionTableMap::COL_COURSE_ID, $this->course_id);
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
        $criteria = ChildSubscriptionQuery::create();
        $criteria->add(SubscriptionTableMap::COL_ID, $this->id);

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
        $validPk = null !== $this->getId();

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
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \bdxe\Subscription (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setStudentId($this->getStudentId());
        $copyObj->setCourseId($this->getCourseId());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getHomeworkEvals() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addHomeworkEval($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTestEvals() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTestEval($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getProjectEvals() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProjectEval($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPacks() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPack($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
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
     * @return \bdxe\Subscription Clone of current object.
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
     * Declares an association between this object and a ChildStudent object.
     *
     * @param  ChildStudent $v
     * @return $this|\bdxe\Subscription The current object (for fluent API support)
     * @throws PropelException
     */
    public function setStudent(ChildStudent $v = null)
    {
        if ($v === null) {
            $this->setStudentId(NULL);
        } else {
            $this->setStudentId($v->getId());
        }

        $this->aStudent = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildStudent object, it will not be re-added.
        if ($v !== null) {
            $v->addSubscription($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildStudent object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildStudent The associated ChildStudent object.
     * @throws PropelException
     */
    public function getStudent(ConnectionInterface $con = null)
    {
        if ($this->aStudent === null && ($this->student_id !== null)) {
            $this->aStudent = ChildStudentQuery::create()->findPk($this->student_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aStudent->addSubscriptions($this);
             */
        }

        return $this->aStudent;
    }

    /**
     * Declares an association between this object and a ChildCourse object.
     *
     * @param  ChildCourse $v
     * @return $this|\bdxe\Subscription The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCourse(ChildCourse $v = null)
    {
        if ($v === null) {
            $this->setCourseId(NULL);
        } else {
            $this->setCourseId($v->getId());
        }

        $this->aCourse = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildCourse object, it will not be re-added.
        if ($v !== null) {
            $v->addSubscription($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildCourse object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildCourse The associated ChildCourse object.
     * @throws PropelException
     */
    public function getCourse(ConnectionInterface $con = null)
    {
        if ($this->aCourse === null && ($this->course_id !== null)) {
            $this->aCourse = ChildCourseQuery::create()->findPk($this->course_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCourse->addSubscriptions($this);
             */
        }

        return $this->aCourse;
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
        if ('HomeworkEval' == $relationName) {
            return $this->initHomeworkEvals();
        }
        if ('TestEval' == $relationName) {
            return $this->initTestEvals();
        }
        if ('ProjectEval' == $relationName) {
            return $this->initProjectEvals();
        }
        if ('Pack' == $relationName) {
            return $this->initPacks();
        }
    }

    /**
     * Clears out the collHomeworkEvals collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addHomeworkEvals()
     */
    public function clearHomeworkEvals()
    {
        $this->collHomeworkEvals = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collHomeworkEvals collection loaded partially.
     */
    public function resetPartialHomeworkEvals($v = true)
    {
        $this->collHomeworkEvalsPartial = $v;
    }

    /**
     * Initializes the collHomeworkEvals collection.
     *
     * By default this just sets the collHomeworkEvals collection to an empty array (like clearcollHomeworkEvals());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initHomeworkEvals($overrideExisting = true)
    {
        if (null !== $this->collHomeworkEvals && !$overrideExisting) {
            return;
        }
        $this->collHomeworkEvals = new ObjectCollection();
        $this->collHomeworkEvals->setModel('\bdxe\HomeworkEval');
    }

    /**
     * Gets an array of ChildHomeworkEval objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSubscription is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildHomeworkEval[] List of ChildHomeworkEval objects
     * @throws PropelException
     */
    public function getHomeworkEvals(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collHomeworkEvalsPartial && !$this->isNew();
        if (null === $this->collHomeworkEvals || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collHomeworkEvals) {
                // return empty collection
                $this->initHomeworkEvals();
            } else {
                $collHomeworkEvals = ChildHomeworkEvalQuery::create(null, $criteria)
                    ->filterBySubscription($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collHomeworkEvalsPartial && count($collHomeworkEvals)) {
                        $this->initHomeworkEvals(false);

                        foreach ($collHomeworkEvals as $obj) {
                            if (false == $this->collHomeworkEvals->contains($obj)) {
                                $this->collHomeworkEvals->append($obj);
                            }
                        }

                        $this->collHomeworkEvalsPartial = true;
                    }

                    return $collHomeworkEvals;
                }

                if ($partial && $this->collHomeworkEvals) {
                    foreach ($this->collHomeworkEvals as $obj) {
                        if ($obj->isNew()) {
                            $collHomeworkEvals[] = $obj;
                        }
                    }
                }

                $this->collHomeworkEvals = $collHomeworkEvals;
                $this->collHomeworkEvalsPartial = false;
            }
        }

        return $this->collHomeworkEvals;
    }

    /**
     * Sets a collection of ChildHomeworkEval objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $homeworkEvals A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSubscription The current object (for fluent API support)
     */
    public function setHomeworkEvals(Collection $homeworkEvals, ConnectionInterface $con = null)
    {
        /** @var ChildHomeworkEval[] $homeworkEvalsToDelete */
        $homeworkEvalsToDelete = $this->getHomeworkEvals(new Criteria(), $con)->diff($homeworkEvals);

        
        $this->homeworkEvalsScheduledForDeletion = $homeworkEvalsToDelete;

        foreach ($homeworkEvalsToDelete as $homeworkEvalRemoved) {
            $homeworkEvalRemoved->setSubscription(null);
        }

        $this->collHomeworkEvals = null;
        foreach ($homeworkEvals as $homeworkEval) {
            $this->addHomeworkEval($homeworkEval);
        }

        $this->collHomeworkEvals = $homeworkEvals;
        $this->collHomeworkEvalsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related HomeworkEval objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related HomeworkEval objects.
     * @throws PropelException
     */
    public function countHomeworkEvals(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collHomeworkEvalsPartial && !$this->isNew();
        if (null === $this->collHomeworkEvals || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collHomeworkEvals) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getHomeworkEvals());
            }

            $query = ChildHomeworkEvalQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySubscription($this)
                ->count($con);
        }

        return count($this->collHomeworkEvals);
    }

    /**
     * Method called to associate a ChildHomeworkEval object to this object
     * through the ChildHomeworkEval foreign key attribute.
     *
     * @param  ChildHomeworkEval $l ChildHomeworkEval
     * @return $this|\bdxe\Subscription The current object (for fluent API support)
     */
    public function addHomeworkEval(ChildHomeworkEval $l)
    {
        if ($this->collHomeworkEvals === null) {
            $this->initHomeworkEvals();
            $this->collHomeworkEvalsPartial = true;
        }

        if (!$this->collHomeworkEvals->contains($l)) {
            $this->doAddHomeworkEval($l);
        }

        return $this;
    }

    /**
     * @param ChildHomeworkEval $homeworkEval The ChildHomeworkEval object to add.
     */
    protected function doAddHomeworkEval(ChildHomeworkEval $homeworkEval)
    {
        $this->collHomeworkEvals[]= $homeworkEval;
        $homeworkEval->setSubscription($this);
    }

    /**
     * @param  ChildHomeworkEval $homeworkEval The ChildHomeworkEval object to remove.
     * @return $this|ChildSubscription The current object (for fluent API support)
     */
    public function removeHomeworkEval(ChildHomeworkEval $homeworkEval)
    {
        if ($this->getHomeworkEvals()->contains($homeworkEval)) {
            $pos = $this->collHomeworkEvals->search($homeworkEval);
            $this->collHomeworkEvals->remove($pos);
            if (null === $this->homeworkEvalsScheduledForDeletion) {
                $this->homeworkEvalsScheduledForDeletion = clone $this->collHomeworkEvals;
                $this->homeworkEvalsScheduledForDeletion->clear();
            }
            $this->homeworkEvalsScheduledForDeletion[]= $homeworkEval;
            $homeworkEval->setSubscription(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Subscription is new, it will return
     * an empty collection; or if this Subscription has previously
     * been saved, it will retrieve related HomeworkEvals from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Subscription.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildHomeworkEval[] List of ChildHomeworkEval objects
     */
    public function getHomeworkEvalsJoinHomework(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildHomeworkEvalQuery::create(null, $criteria);
        $query->joinWith('Homework', $joinBehavior);

        return $this->getHomeworkEvals($query, $con);
    }

    /**
     * Clears out the collTestEvals collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTestEvals()
     */
    public function clearTestEvals()
    {
        $this->collTestEvals = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTestEvals collection loaded partially.
     */
    public function resetPartialTestEvals($v = true)
    {
        $this->collTestEvalsPartial = $v;
    }

    /**
     * Initializes the collTestEvals collection.
     *
     * By default this just sets the collTestEvals collection to an empty array (like clearcollTestEvals());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTestEvals($overrideExisting = true)
    {
        if (null !== $this->collTestEvals && !$overrideExisting) {
            return;
        }
        $this->collTestEvals = new ObjectCollection();
        $this->collTestEvals->setModel('\bdxe\TestEval');
    }

    /**
     * Gets an array of ChildTestEval objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSubscription is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTestEval[] List of ChildTestEval objects
     * @throws PropelException
     */
    public function getTestEvals(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTestEvalsPartial && !$this->isNew();
        if (null === $this->collTestEvals || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTestEvals) {
                // return empty collection
                $this->initTestEvals();
            } else {
                $collTestEvals = ChildTestEvalQuery::create(null, $criteria)
                    ->filterBySubscription($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTestEvalsPartial && count($collTestEvals)) {
                        $this->initTestEvals(false);

                        foreach ($collTestEvals as $obj) {
                            if (false == $this->collTestEvals->contains($obj)) {
                                $this->collTestEvals->append($obj);
                            }
                        }

                        $this->collTestEvalsPartial = true;
                    }

                    return $collTestEvals;
                }

                if ($partial && $this->collTestEvals) {
                    foreach ($this->collTestEvals as $obj) {
                        if ($obj->isNew()) {
                            $collTestEvals[] = $obj;
                        }
                    }
                }

                $this->collTestEvals = $collTestEvals;
                $this->collTestEvalsPartial = false;
            }
        }

        return $this->collTestEvals;
    }

    /**
     * Sets a collection of ChildTestEval objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $testEvals A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSubscription The current object (for fluent API support)
     */
    public function setTestEvals(Collection $testEvals, ConnectionInterface $con = null)
    {
        /** @var ChildTestEval[] $testEvalsToDelete */
        $testEvalsToDelete = $this->getTestEvals(new Criteria(), $con)->diff($testEvals);

        
        $this->testEvalsScheduledForDeletion = $testEvalsToDelete;

        foreach ($testEvalsToDelete as $testEvalRemoved) {
            $testEvalRemoved->setSubscription(null);
        }

        $this->collTestEvals = null;
        foreach ($testEvals as $testEval) {
            $this->addTestEval($testEval);
        }

        $this->collTestEvals = $testEvals;
        $this->collTestEvalsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related TestEval objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related TestEval objects.
     * @throws PropelException
     */
    public function countTestEvals(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTestEvalsPartial && !$this->isNew();
        if (null === $this->collTestEvals || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTestEvals) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTestEvals());
            }

            $query = ChildTestEvalQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySubscription($this)
                ->count($con);
        }

        return count($this->collTestEvals);
    }

    /**
     * Method called to associate a ChildTestEval object to this object
     * through the ChildTestEval foreign key attribute.
     *
     * @param  ChildTestEval $l ChildTestEval
     * @return $this|\bdxe\Subscription The current object (for fluent API support)
     */
    public function addTestEval(ChildTestEval $l)
    {
        if ($this->collTestEvals === null) {
            $this->initTestEvals();
            $this->collTestEvalsPartial = true;
        }

        if (!$this->collTestEvals->contains($l)) {
            $this->doAddTestEval($l);
        }

        return $this;
    }

    /**
     * @param ChildTestEval $testEval The ChildTestEval object to add.
     */
    protected function doAddTestEval(ChildTestEval $testEval)
    {
        $this->collTestEvals[]= $testEval;
        $testEval->setSubscription($this);
    }

    /**
     * @param  ChildTestEval $testEval The ChildTestEval object to remove.
     * @return $this|ChildSubscription The current object (for fluent API support)
     */
    public function removeTestEval(ChildTestEval $testEval)
    {
        if ($this->getTestEvals()->contains($testEval)) {
            $pos = $this->collTestEvals->search($testEval);
            $this->collTestEvals->remove($pos);
            if (null === $this->testEvalsScheduledForDeletion) {
                $this->testEvalsScheduledForDeletion = clone $this->collTestEvals;
                $this->testEvalsScheduledForDeletion->clear();
            }
            $this->testEvalsScheduledForDeletion[]= $testEval;
            $testEval->setSubscription(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Subscription is new, it will return
     * an empty collection; or if this Subscription has previously
     * been saved, it will retrieve related TestEvals from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Subscription.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTestEval[] List of ChildTestEval objects
     */
    public function getTestEvalsJoinTest(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTestEvalQuery::create(null, $criteria);
        $query->joinWith('Test', $joinBehavior);

        return $this->getTestEvals($query, $con);
    }

    /**
     * Clears out the collProjectEvals collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addProjectEvals()
     */
    public function clearProjectEvals()
    {
        $this->collProjectEvals = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collProjectEvals collection loaded partially.
     */
    public function resetPartialProjectEvals($v = true)
    {
        $this->collProjectEvalsPartial = $v;
    }

    /**
     * Initializes the collProjectEvals collection.
     *
     * By default this just sets the collProjectEvals collection to an empty array (like clearcollProjectEvals());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProjectEvals($overrideExisting = true)
    {
        if (null !== $this->collProjectEvals && !$overrideExisting) {
            return;
        }
        $this->collProjectEvals = new ObjectCollection();
        $this->collProjectEvals->setModel('\bdxe\ProjectEval');
    }

    /**
     * Gets an array of ChildProjectEval objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSubscription is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildProjectEval[] List of ChildProjectEval objects
     * @throws PropelException
     */
    public function getProjectEvals(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collProjectEvalsPartial && !$this->isNew();
        if (null === $this->collProjectEvals || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collProjectEvals) {
                // return empty collection
                $this->initProjectEvals();
            } else {
                $collProjectEvals = ChildProjectEvalQuery::create(null, $criteria)
                    ->filterBySubscription($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collProjectEvalsPartial && count($collProjectEvals)) {
                        $this->initProjectEvals(false);

                        foreach ($collProjectEvals as $obj) {
                            if (false == $this->collProjectEvals->contains($obj)) {
                                $this->collProjectEvals->append($obj);
                            }
                        }

                        $this->collProjectEvalsPartial = true;
                    }

                    return $collProjectEvals;
                }

                if ($partial && $this->collProjectEvals) {
                    foreach ($this->collProjectEvals as $obj) {
                        if ($obj->isNew()) {
                            $collProjectEvals[] = $obj;
                        }
                    }
                }

                $this->collProjectEvals = $collProjectEvals;
                $this->collProjectEvalsPartial = false;
            }
        }

        return $this->collProjectEvals;
    }

    /**
     * Sets a collection of ChildProjectEval objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $projectEvals A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSubscription The current object (for fluent API support)
     */
    public function setProjectEvals(Collection $projectEvals, ConnectionInterface $con = null)
    {
        /** @var ChildProjectEval[] $projectEvalsToDelete */
        $projectEvalsToDelete = $this->getProjectEvals(new Criteria(), $con)->diff($projectEvals);

        
        $this->projectEvalsScheduledForDeletion = $projectEvalsToDelete;

        foreach ($projectEvalsToDelete as $projectEvalRemoved) {
            $projectEvalRemoved->setSubscription(null);
        }

        $this->collProjectEvals = null;
        foreach ($projectEvals as $projectEval) {
            $this->addProjectEval($projectEval);
        }

        $this->collProjectEvals = $projectEvals;
        $this->collProjectEvalsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ProjectEval objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ProjectEval objects.
     * @throws PropelException
     */
    public function countProjectEvals(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collProjectEvalsPartial && !$this->isNew();
        if (null === $this->collProjectEvals || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProjectEvals) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getProjectEvals());
            }

            $query = ChildProjectEvalQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySubscription($this)
                ->count($con);
        }

        return count($this->collProjectEvals);
    }

    /**
     * Method called to associate a ChildProjectEval object to this object
     * through the ChildProjectEval foreign key attribute.
     *
     * @param  ChildProjectEval $l ChildProjectEval
     * @return $this|\bdxe\Subscription The current object (for fluent API support)
     */
    public function addProjectEval(ChildProjectEval $l)
    {
        if ($this->collProjectEvals === null) {
            $this->initProjectEvals();
            $this->collProjectEvalsPartial = true;
        }

        if (!$this->collProjectEvals->contains($l)) {
            $this->doAddProjectEval($l);
        }

        return $this;
    }

    /**
     * @param ChildProjectEval $projectEval The ChildProjectEval object to add.
     */
    protected function doAddProjectEval(ChildProjectEval $projectEval)
    {
        $this->collProjectEvals[]= $projectEval;
        $projectEval->setSubscription($this);
    }

    /**
     * @param  ChildProjectEval $projectEval The ChildProjectEval object to remove.
     * @return $this|ChildSubscription The current object (for fluent API support)
     */
    public function removeProjectEval(ChildProjectEval $projectEval)
    {
        if ($this->getProjectEvals()->contains($projectEval)) {
            $pos = $this->collProjectEvals->search($projectEval);
            $this->collProjectEvals->remove($pos);
            if (null === $this->projectEvalsScheduledForDeletion) {
                $this->projectEvalsScheduledForDeletion = clone $this->collProjectEvals;
                $this->projectEvalsScheduledForDeletion->clear();
            }
            $this->projectEvalsScheduledForDeletion[]= $projectEval;
            $projectEval->setSubscription(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Subscription is new, it will return
     * an empty collection; or if this Subscription has previously
     * been saved, it will retrieve related ProjectEvals from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Subscription.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildProjectEval[] List of ChildProjectEval objects
     */
    public function getProjectEvalsJoinProject(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildProjectEvalQuery::create(null, $criteria);
        $query->joinWith('Project', $joinBehavior);

        return $this->getProjectEvals($query, $con);
    }

    /**
     * Clears out the collPacks collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPacks()
     */
    public function clearPacks()
    {
        $this->collPacks = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPacks collection loaded partially.
     */
    public function resetPartialPacks($v = true)
    {
        $this->collPacksPartial = $v;
    }

    /**
     * Initializes the collPacks collection.
     *
     * By default this just sets the collPacks collection to an empty array (like clearcollPacks());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPacks($overrideExisting = true)
    {
        if (null !== $this->collPacks && !$overrideExisting) {
            return;
        }
        $this->collPacks = new ObjectCollection();
        $this->collPacks->setModel('\bdxe\Pack');
    }

    /**
     * Gets an array of ChildPack objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSubscription is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPack[] List of ChildPack objects
     * @throws PropelException
     */
    public function getPacks(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPacksPartial && !$this->isNew();
        if (null === $this->collPacks || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPacks) {
                // return empty collection
                $this->initPacks();
            } else {
                $collPacks = ChildPackQuery::create(null, $criteria)
                    ->filterBySubscription($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPacksPartial && count($collPacks)) {
                        $this->initPacks(false);

                        foreach ($collPacks as $obj) {
                            if (false == $this->collPacks->contains($obj)) {
                                $this->collPacks->append($obj);
                            }
                        }

                        $this->collPacksPartial = true;
                    }

                    return $collPacks;
                }

                if ($partial && $this->collPacks) {
                    foreach ($this->collPacks as $obj) {
                        if ($obj->isNew()) {
                            $collPacks[] = $obj;
                        }
                    }
                }

                $this->collPacks = $collPacks;
                $this->collPacksPartial = false;
            }
        }

        return $this->collPacks;
    }

    /**
     * Sets a collection of ChildPack objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $packs A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSubscription The current object (for fluent API support)
     */
    public function setPacks(Collection $packs, ConnectionInterface $con = null)
    {
        /** @var ChildPack[] $packsToDelete */
        $packsToDelete = $this->getPacks(new Criteria(), $con)->diff($packs);

        
        $this->packsScheduledForDeletion = $packsToDelete;

        foreach ($packsToDelete as $packRemoved) {
            $packRemoved->setSubscription(null);
        }

        $this->collPacks = null;
        foreach ($packs as $pack) {
            $this->addPack($pack);
        }

        $this->collPacks = $packs;
        $this->collPacksPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Pack objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Pack objects.
     * @throws PropelException
     */
    public function countPacks(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPacksPartial && !$this->isNew();
        if (null === $this->collPacks || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPacks) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPacks());
            }

            $query = ChildPackQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySubscription($this)
                ->count($con);
        }

        return count($this->collPacks);
    }

    /**
     * Method called to associate a ChildPack object to this object
     * through the ChildPack foreign key attribute.
     *
     * @param  ChildPack $l ChildPack
     * @return $this|\bdxe\Subscription The current object (for fluent API support)
     */
    public function addPack(ChildPack $l)
    {
        if ($this->collPacks === null) {
            $this->initPacks();
            $this->collPacksPartial = true;
        }

        if (!$this->collPacks->contains($l)) {
            $this->doAddPack($l);
        }

        return $this;
    }

    /**
     * @param ChildPack $pack The ChildPack object to add.
     */
    protected function doAddPack(ChildPack $pack)
    {
        $this->collPacks[]= $pack;
        $pack->setSubscription($this);
    }

    /**
     * @param  ChildPack $pack The ChildPack object to remove.
     * @return $this|ChildSubscription The current object (for fluent API support)
     */
    public function removePack(ChildPack $pack)
    {
        if ($this->getPacks()->contains($pack)) {
            $pos = $this->collPacks->search($pack);
            $this->collPacks->remove($pos);
            if (null === $this->packsScheduledForDeletion) {
                $this->packsScheduledForDeletion = clone $this->collPacks;
                $this->packsScheduledForDeletion->clear();
            }
            $this->packsScheduledForDeletion[]= $pack;
            $pack->setSubscription(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Subscription is new, it will return
     * an empty collection; or if this Subscription has previously
     * been saved, it will retrieve related Packs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Subscription.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPack[] List of ChildPack objects
     */
    public function getPacksJoinGroup(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPackQuery::create(null, $criteria);
        $query->joinWith('Group', $joinBehavior);

        return $this->getPacks($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aStudent) {
            $this->aStudent->removeSubscription($this);
        }
        if (null !== $this->aCourse) {
            $this->aCourse->removeSubscription($this);
        }
        $this->id = null;
        $this->student_id = null;
        $this->course_id = null;
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
            if ($this->collHomeworkEvals) {
                foreach ($this->collHomeworkEvals as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTestEvals) {
                foreach ($this->collTestEvals as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collProjectEvals) {
                foreach ($this->collProjectEvals as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPacks) {
                foreach ($this->collPacks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collHomeworkEvals = null;
        $this->collTestEvals = null;
        $this->collProjectEvals = null;
        $this->collPacks = null;
        $this->aStudent = null;
        $this->aCourse = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SubscriptionTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

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
