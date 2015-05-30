<?php

namespace bdxe\Base;

use \DateTime;
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
use Propel\Runtime\Util\PropelDateTime;
use bdxe\Course as ChildCourse;
use bdxe\CourseQuery as ChildCourseQuery;
use bdxe\Homework as ChildHomework;
use bdxe\HomeworkQuery as ChildHomeworkQuery;
use bdxe\Profesor as ChildProfesor;
use bdxe\ProfesorQuery as ChildProfesorQuery;
use bdxe\Project as ChildProject;
use bdxe\ProjectQuery as ChildProjectQuery;
use bdxe\Subject as ChildSubject;
use bdxe\SubjectQuery as ChildSubjectQuery;
use bdxe\Subscription as ChildSubscription;
use bdxe\SubscriptionQuery as ChildSubscriptionQuery;
use bdxe\Test as ChildTest;
use bdxe\TestQuery as ChildTestQuery;
use bdxe\Map\CourseTableMap;

/**
 * Base class that represents a row from the 'course_tb' table.
 *
 * 
 *
* @package    propel.generator.bdxe.Base
*/
abstract class Course implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\bdxe\\Map\\CourseTableMap';


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
     * The value for the profesor_id field.
     * @var        int
     */
    protected $profesor_id;

    /**
     * The value for the subject_id field.
     * @var        int
     */
    protected $subject_id;

    /**
     * The value for the subject_name field.
     * @var        string
     */
    protected $subject_name;

    /**
     * The value for the class_capacity field.
     * @var        int
     */
    protected $class_capacity;

    /**
     * The value for the initial_class_capacity field.
     * @var        int
     */
    protected $initial_class_capacity;

    /**
     * The value for the start_date field.
     * @var        \DateTime
     */
    protected $start_date;

    /**
     * The value for the finish_date field.
     * @var        \DateTime
     */
    protected $finish_date;

    /**
     * @var        ChildProfesor
     */
    protected $aProfesor;

    /**
     * @var        ChildSubject
     */
    protected $aSubjectRelatedBySubjectId;

    /**
     * @var        ObjectCollection|ChildSubscription[] Collection to store aggregation of ChildSubscription objects.
     */
    protected $collSubscriptions;
    protected $collSubscriptionsPartial;

    /**
     * @var        ObjectCollection|ChildHomework[] Collection to store aggregation of ChildHomework objects.
     */
    protected $collHomeworks;
    protected $collHomeworksPartial;

    /**
     * @var        ObjectCollection|ChildTest[] Collection to store aggregation of ChildTest objects.
     */
    protected $collTests;
    protected $collTestsPartial;

    /**
     * @var        ObjectCollection|ChildProject[] Collection to store aggregation of ChildProject objects.
     */
    protected $collProjects;
    protected $collProjectsPartial;

    /**
     * @var        ObjectCollection|ChildSubject[] Collection to store aggregation of ChildSubject objects.
     */
    protected $collSubjectsRelatedByCourseId;
    protected $collSubjectsRelatedByCourseIdPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSubscription[]
     */
    protected $subscriptionsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildHomework[]
     */
    protected $homeworksScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTest[]
     */
    protected $testsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildProject[]
     */
    protected $projectsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSubject[]
     */
    protected $subjectsRelatedByCourseIdScheduledForDeletion = null;

    /**
     * Initializes internal state of bdxe\Base\Course object.
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
     * Compares this with another <code>Course</code> instance.  If
     * <code>obj</code> is an instance of <code>Course</code>, delegates to
     * <code>equals(Course)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Course The current object, for fluid interface
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
     * Get the [profesor_id] column value.
     * 
     * @return int
     */
    public function getProfesorId()
    {
        return $this->profesor_id;
    }

    /**
     * Get the [subject_id] column value.
     * 
     * @return int
     */
    public function getSubjectId()
    {
        return $this->subject_id;
    }

    /**
     * Get the [subject_name] column value.
     * 
     * @return string
     */
    public function getSubjectName()
    {
        return $this->subject_name;
    }

    /**
     * Get the [class_capacity] column value.
     * 
     * @return int
     */
    public function getClassCapacity()
    {
        return $this->class_capacity;
    }

    /**
     * Get the [initial_class_capacity] column value.
     * 
     * @return int
     */
    public function getInitialClassCapacity()
    {
        return $this->initial_class_capacity;
    }

    /**
     * Get the [optionally formatted] temporal [start_date] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getStartDate($format = NULL)
    {
        if ($format === null) {
            return $this->start_date;
        } else {
            return $this->start_date instanceof \DateTime ? $this->start_date->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [finish_date] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getFinishDate($format = NULL)
    {
        if ($format === null) {
            return $this->finish_date;
        } else {
            return $this->finish_date instanceof \DateTime ? $this->finish_date->format($format) : null;
        }
    }

    /**
     * Set the value of [id] column.
     * 
     * @param int $v new value
     * @return $this|\bdxe\Course The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[CourseTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [profesor_id] column.
     * 
     * @param int $v new value
     * @return $this|\bdxe\Course The current object (for fluent API support)
     */
    public function setProfesorId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->profesor_id !== $v) {
            $this->profesor_id = $v;
            $this->modifiedColumns[CourseTableMap::COL_PROFESOR_ID] = true;
        }

        if ($this->aProfesor !== null && $this->aProfesor->getId() !== $v) {
            $this->aProfesor = null;
        }

        return $this;
    } // setProfesorId()

    /**
     * Set the value of [subject_id] column.
     * 
     * @param int $v new value
     * @return $this|\bdxe\Course The current object (for fluent API support)
     */
    public function setSubjectId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->subject_id !== $v) {
            $this->subject_id = $v;
            $this->modifiedColumns[CourseTableMap::COL_SUBJECT_ID] = true;
        }

        if ($this->aSubjectRelatedBySubjectId !== null && $this->aSubjectRelatedBySubjectId->getId() !== $v) {
            $this->aSubjectRelatedBySubjectId = null;
        }

        return $this;
    } // setSubjectId()

    /**
     * Set the value of [subject_name] column.
     * 
     * @param string $v new value
     * @return $this|\bdxe\Course The current object (for fluent API support)
     */
    public function setSubjectName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->subject_name !== $v) {
            $this->subject_name = $v;
            $this->modifiedColumns[CourseTableMap::COL_SUBJECT_NAME] = true;
        }

        return $this;
    } // setSubjectName()

    /**
     * Set the value of [class_capacity] column.
     * 
     * @param int $v new value
     * @return $this|\bdxe\Course The current object (for fluent API support)
     */
    public function setClassCapacity($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->class_capacity !== $v) {
            $this->class_capacity = $v;
            $this->modifiedColumns[CourseTableMap::COL_CLASS_CAPACITY] = true;
        }

        return $this;
    } // setClassCapacity()

    /**
     * Set the value of [initial_class_capacity] column.
     * 
     * @param int $v new value
     * @return $this|\bdxe\Course The current object (for fluent API support)
     */
    public function setInitialClassCapacity($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->initial_class_capacity !== $v) {
            $this->initial_class_capacity = $v;
            $this->modifiedColumns[CourseTableMap::COL_INITIAL_CLASS_CAPACITY] = true;
        }

        return $this;
    } // setInitialClassCapacity()

    /**
     * Sets the value of [start_date] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\bdxe\Course The current object (for fluent API support)
     */
    public function setStartDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->start_date !== null || $dt !== null) {
            if ($this->start_date === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->start_date->format("Y-m-d H:i:s")) {
                $this->start_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[CourseTableMap::COL_START_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setStartDate()

    /**
     * Sets the value of [finish_date] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\bdxe\Course The current object (for fluent API support)
     */
    public function setFinishDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->finish_date !== null || $dt !== null) {
            if ($this->finish_date === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->finish_date->format("Y-m-d H:i:s")) {
                $this->finish_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[CourseTableMap::COL_FINISH_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setFinishDate()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : CourseTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : CourseTableMap::translateFieldName('ProfesorId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->profesor_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : CourseTableMap::translateFieldName('SubjectId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->subject_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : CourseTableMap::translateFieldName('SubjectName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->subject_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : CourseTableMap::translateFieldName('ClassCapacity', TableMap::TYPE_PHPNAME, $indexType)];
            $this->class_capacity = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : CourseTableMap::translateFieldName('InitialClassCapacity', TableMap::TYPE_PHPNAME, $indexType)];
            $this->initial_class_capacity = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : CourseTableMap::translateFieldName('StartDate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->start_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : CourseTableMap::translateFieldName('FinishDate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->finish_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 8; // 8 = CourseTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\bdxe\\Course'), 0, $e);
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
        if ($this->aProfesor !== null && $this->profesor_id !== $this->aProfesor->getId()) {
            $this->aProfesor = null;
        }
        if ($this->aSubjectRelatedBySubjectId !== null && $this->subject_id !== $this->aSubjectRelatedBySubjectId->getId()) {
            $this->aSubjectRelatedBySubjectId = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(CourseTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildCourseQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aProfesor = null;
            $this->aSubjectRelatedBySubjectId = null;
            $this->collSubscriptions = null;

            $this->collHomeworks = null;

            $this->collTests = null;

            $this->collProjects = null;

            $this->collSubjectsRelatedByCourseId = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Course::setDeleted()
     * @see Course::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CourseTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildCourseQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(CourseTableMap::DATABASE_NAME);
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
                CourseTableMap::addInstanceToPool($this);
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

            if ($this->aProfesor !== null) {
                if ($this->aProfesor->isModified() || $this->aProfesor->isNew()) {
                    $affectedRows += $this->aProfesor->save($con);
                }
                $this->setProfesor($this->aProfesor);
            }

            if ($this->aSubjectRelatedBySubjectId !== null) {
                if ($this->aSubjectRelatedBySubjectId->isModified() || $this->aSubjectRelatedBySubjectId->isNew()) {
                    $affectedRows += $this->aSubjectRelatedBySubjectId->save($con);
                }
                $this->setSubjectRelatedBySubjectId($this->aSubjectRelatedBySubjectId);
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

            if ($this->subscriptionsScheduledForDeletion !== null) {
                if (!$this->subscriptionsScheduledForDeletion->isEmpty()) {
                    foreach ($this->subscriptionsScheduledForDeletion as $subscription) {
                        // need to save related object because we set the relation to null
                        $subscription->save($con);
                    }
                    $this->subscriptionsScheduledForDeletion = null;
                }
            }

            if ($this->collSubscriptions !== null) {
                foreach ($this->collSubscriptions as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->homeworksScheduledForDeletion !== null) {
                if (!$this->homeworksScheduledForDeletion->isEmpty()) {
                    foreach ($this->homeworksScheduledForDeletion as $homework) {
                        // need to save related object because we set the relation to null
                        $homework->save($con);
                    }
                    $this->homeworksScheduledForDeletion = null;
                }
            }

            if ($this->collHomeworks !== null) {
                foreach ($this->collHomeworks as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->testsScheduledForDeletion !== null) {
                if (!$this->testsScheduledForDeletion->isEmpty()) {
                    foreach ($this->testsScheduledForDeletion as $test) {
                        // need to save related object because we set the relation to null
                        $test->save($con);
                    }
                    $this->testsScheduledForDeletion = null;
                }
            }

            if ($this->collTests !== null) {
                foreach ($this->collTests as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->projectsScheduledForDeletion !== null) {
                if (!$this->projectsScheduledForDeletion->isEmpty()) {
                    foreach ($this->projectsScheduledForDeletion as $project) {
                        // need to save related object because we set the relation to null
                        $project->save($con);
                    }
                    $this->projectsScheduledForDeletion = null;
                }
            }

            if ($this->collProjects !== null) {
                foreach ($this->collProjects as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->subjectsRelatedByCourseIdScheduledForDeletion !== null) {
                if (!$this->subjectsRelatedByCourseIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->subjectsRelatedByCourseIdScheduledForDeletion as $subjectRelatedByCourseId) {
                        // need to save related object because we set the relation to null
                        $subjectRelatedByCourseId->save($con);
                    }
                    $this->subjectsRelatedByCourseIdScheduledForDeletion = null;
                }
            }

            if ($this->collSubjectsRelatedByCourseId !== null) {
                foreach ($this->collSubjectsRelatedByCourseId as $referrerFK) {
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

        $this->modifiedColumns[CourseTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CourseTableMap::COL_ID . ')');
        }
        if (null === $this->id) {
            try {                
                $dataFetcher = $con->query('SELECT course_tb_SEQ.nextval FROM dual');
                $this->id = $dataFetcher->fetchColumn();
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', 0, $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CourseTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(CourseTableMap::COL_PROFESOR_ID)) {
            $modifiedColumns[':p' . $index++]  = 'profesor_id';
        }
        if ($this->isColumnModified(CourseTableMap::COL_SUBJECT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'subject_id';
        }
        if ($this->isColumnModified(CourseTableMap::COL_SUBJECT_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'Subject_Name';
        }
        if ($this->isColumnModified(CourseTableMap::COL_CLASS_CAPACITY)) {
            $modifiedColumns[':p' . $index++]  = 'Class_Capacity';
        }
        if ($this->isColumnModified(CourseTableMap::COL_INITIAL_CLASS_CAPACITY)) {
            $modifiedColumns[':p' . $index++]  = 'Initial_Class_Capacity';
        }
        if ($this->isColumnModified(CourseTableMap::COL_START_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'Start_Date';
        }
        if ($this->isColumnModified(CourseTableMap::COL_FINISH_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'Finish_Date';
        }

        $sql = sprintf(
            'INSERT INTO course_tb (%s) VALUES (%s)',
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
                    case 'profesor_id':                        
                        $stmt->bindValue($identifier, $this->profesor_id, PDO::PARAM_INT);
                        break;
                    case 'subject_id':                        
                        $stmt->bindValue($identifier, $this->subject_id, PDO::PARAM_INT);
                        break;
                    case 'Subject_Name':                        
                        $stmt->bindValue($identifier, $this->subject_name, PDO::PARAM_STR);
                        break;
                    case 'Class_Capacity':                        
                        $stmt->bindValue($identifier, $this->class_capacity, PDO::PARAM_INT);
                        break;
                    case 'Initial_Class_Capacity':                        
                        $stmt->bindValue($identifier, $this->initial_class_capacity, PDO::PARAM_INT);
                        break;
                    case 'Start_Date':                        
                        $stmt->bindValue($identifier, $this->start_date ? $this->start_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'Finish_Date':                        
                        $stmt->bindValue($identifier, $this->finish_date ? $this->finish_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
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
        $pos = CourseTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getProfesorId();
                break;
            case 2:
                return $this->getSubjectId();
                break;
            case 3:
                return $this->getSubjectName();
                break;
            case 4:
                return $this->getClassCapacity();
                break;
            case 5:
                return $this->getInitialClassCapacity();
                break;
            case 6:
                return $this->getStartDate();
                break;
            case 7:
                return $this->getFinishDate();
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

        if (isset($alreadyDumpedObjects['Course'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Course'][$this->hashCode()] = true;
        $keys = CourseTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getProfesorId(),
            $keys[2] => $this->getSubjectId(),
            $keys[3] => $this->getSubjectName(),
            $keys[4] => $this->getClassCapacity(),
            $keys[5] => $this->getInitialClassCapacity(),
            $keys[6] => $this->getStartDate(),
            $keys[7] => $this->getFinishDate(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[6]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[6]];
            $result[$keys[6]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }
        
        if ($result[$keys[7]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[7]];
            $result[$keys[7]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }
        
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->aProfesor) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'profesor';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'profesor_tb';
                        break;
                    default:
                        $key = 'Profesor';
                }
        
                $result[$key] = $this->aProfesor->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aSubjectRelatedBySubjectId) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'subject';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'subject_tb';
                        break;
                    default:
                        $key = 'Subject';
                }
        
                $result[$key] = $this->aSubjectRelatedBySubjectId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collSubscriptions) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'subscriptions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'subscription_tbs';
                        break;
                    default:
                        $key = 'Subscriptions';
                }
        
                $result[$key] = $this->collSubscriptions->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collHomeworks) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'homeworks';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'homework_tbs';
                        break;
                    default:
                        $key = 'Homeworks';
                }
        
                $result[$key] = $this->collHomeworks->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTests) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'tests';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'test_tbs';
                        break;
                    default:
                        $key = 'Tests';
                }
        
                $result[$key] = $this->collTests->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collProjects) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'projects';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'project_tbs';
                        break;
                    default:
                        $key = 'Projects';
                }
        
                $result[$key] = $this->collProjects->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSubjectsRelatedByCourseId) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'subjects';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'subject_tbs';
                        break;
                    default:
                        $key = 'Subjects';
                }
        
                $result[$key] = $this->collSubjectsRelatedByCourseId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\bdxe\Course
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = CourseTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\bdxe\Course
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setProfesorId($value);
                break;
            case 2:
                $this->setSubjectId($value);
                break;
            case 3:
                $this->setSubjectName($value);
                break;
            case 4:
                $this->setClassCapacity($value);
                break;
            case 5:
                $this->setInitialClassCapacity($value);
                break;
            case 6:
                $this->setStartDate($value);
                break;
            case 7:
                $this->setFinishDate($value);
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
        $keys = CourseTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setProfesorId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setSubjectId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setSubjectName($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setClassCapacity($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setInitialClassCapacity($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setStartDate($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setFinishDate($arr[$keys[7]]);
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
     * @return $this|\bdxe\Course The current object, for fluid interface
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
        $criteria = new Criteria(CourseTableMap::DATABASE_NAME);

        if ($this->isColumnModified(CourseTableMap::COL_ID)) {
            $criteria->add(CourseTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(CourseTableMap::COL_PROFESOR_ID)) {
            $criteria->add(CourseTableMap::COL_PROFESOR_ID, $this->profesor_id);
        }
        if ($this->isColumnModified(CourseTableMap::COL_SUBJECT_ID)) {
            $criteria->add(CourseTableMap::COL_SUBJECT_ID, $this->subject_id);
        }
        if ($this->isColumnModified(CourseTableMap::COL_SUBJECT_NAME)) {
            $criteria->add(CourseTableMap::COL_SUBJECT_NAME, $this->subject_name);
        }
        if ($this->isColumnModified(CourseTableMap::COL_CLASS_CAPACITY)) {
            $criteria->add(CourseTableMap::COL_CLASS_CAPACITY, $this->class_capacity);
        }
        if ($this->isColumnModified(CourseTableMap::COL_INITIAL_CLASS_CAPACITY)) {
            $criteria->add(CourseTableMap::COL_INITIAL_CLASS_CAPACITY, $this->initial_class_capacity);
        }
        if ($this->isColumnModified(CourseTableMap::COL_START_DATE)) {
            $criteria->add(CourseTableMap::COL_START_DATE, $this->start_date);
        }
        if ($this->isColumnModified(CourseTableMap::COL_FINISH_DATE)) {
            $criteria->add(CourseTableMap::COL_FINISH_DATE, $this->finish_date);
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
        $criteria = ChildCourseQuery::create();
        $criteria->add(CourseTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \bdxe\Course (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setProfesorId($this->getProfesorId());
        $copyObj->setSubjectId($this->getSubjectId());
        $copyObj->setSubjectName($this->getSubjectName());
        $copyObj->setClassCapacity($this->getClassCapacity());
        $copyObj->setInitialClassCapacity($this->getInitialClassCapacity());
        $copyObj->setStartDate($this->getStartDate());
        $copyObj->setFinishDate($this->getFinishDate());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getSubscriptions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSubscription($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getHomeworks() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addHomework($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTests() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTest($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getProjects() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProject($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSubjectsRelatedByCourseId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSubjectRelatedByCourseId($relObj->copy($deepCopy));
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
     * @return \bdxe\Course Clone of current object.
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
     * Declares an association between this object and a ChildProfesor object.
     *
     * @param  ChildProfesor $v
     * @return $this|\bdxe\Course The current object (for fluent API support)
     * @throws PropelException
     */
    public function setProfesor(ChildProfesor $v = null)
    {
        if ($v === null) {
            $this->setProfesorId(NULL);
        } else {
            $this->setProfesorId($v->getId());
        }

        $this->aProfesor = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildProfesor object, it will not be re-added.
        if ($v !== null) {
            $v->addCourse($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildProfesor object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildProfesor The associated ChildProfesor object.
     * @throws PropelException
     */
    public function getProfesor(ConnectionInterface $con = null)
    {
        if ($this->aProfesor === null && ($this->profesor_id !== null)) {
            $this->aProfesor = ChildProfesorQuery::create()->findPk($this->profesor_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aProfesor->addCourses($this);
             */
        }

        return $this->aProfesor;
    }

    /**
     * Declares an association between this object and a ChildSubject object.
     *
     * @param  ChildSubject $v
     * @return $this|\bdxe\Course The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSubjectRelatedBySubjectId(ChildSubject $v = null)
    {
        if ($v === null) {
            $this->setSubjectId(NULL);
        } else {
            $this->setSubjectId($v->getId());
        }

        $this->aSubjectRelatedBySubjectId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSubject object, it will not be re-added.
        if ($v !== null) {
            $v->addCourseRelatedBySubjectId($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildSubject object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildSubject The associated ChildSubject object.
     * @throws PropelException
     */
    public function getSubjectRelatedBySubjectId(ConnectionInterface $con = null)
    {
        if ($this->aSubjectRelatedBySubjectId === null && ($this->subject_id !== null)) {
            $this->aSubjectRelatedBySubjectId = ChildSubjectQuery::create()->findPk($this->subject_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSubjectRelatedBySubjectId->addCoursesRelatedBySubjectId($this);
             */
        }

        return $this->aSubjectRelatedBySubjectId;
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
        if ('Subscription' == $relationName) {
            return $this->initSubscriptions();
        }
        if ('Homework' == $relationName) {
            return $this->initHomeworks();
        }
        if ('Test' == $relationName) {
            return $this->initTests();
        }
        if ('Project' == $relationName) {
            return $this->initProjects();
        }
        if ('SubjectRelatedByCourseId' == $relationName) {
            return $this->initSubjectsRelatedByCourseId();
        }
    }

    /**
     * Clears out the collSubscriptions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSubscriptions()
     */
    public function clearSubscriptions()
    {
        $this->collSubscriptions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSubscriptions collection loaded partially.
     */
    public function resetPartialSubscriptions($v = true)
    {
        $this->collSubscriptionsPartial = $v;
    }

    /**
     * Initializes the collSubscriptions collection.
     *
     * By default this just sets the collSubscriptions collection to an empty array (like clearcollSubscriptions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSubscriptions($overrideExisting = true)
    {
        if (null !== $this->collSubscriptions && !$overrideExisting) {
            return;
        }
        $this->collSubscriptions = new ObjectCollection();
        $this->collSubscriptions->setModel('\bdxe\Subscription');
    }

    /**
     * Gets an array of ChildSubscription objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCourse is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSubscription[] List of ChildSubscription objects
     * @throws PropelException
     */
    public function getSubscriptions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSubscriptionsPartial && !$this->isNew();
        if (null === $this->collSubscriptions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSubscriptions) {
                // return empty collection
                $this->initSubscriptions();
            } else {
                $collSubscriptions = ChildSubscriptionQuery::create(null, $criteria)
                    ->filterByCourse($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSubscriptionsPartial && count($collSubscriptions)) {
                        $this->initSubscriptions(false);

                        foreach ($collSubscriptions as $obj) {
                            if (false == $this->collSubscriptions->contains($obj)) {
                                $this->collSubscriptions->append($obj);
                            }
                        }

                        $this->collSubscriptionsPartial = true;
                    }

                    return $collSubscriptions;
                }

                if ($partial && $this->collSubscriptions) {
                    foreach ($this->collSubscriptions as $obj) {
                        if ($obj->isNew()) {
                            $collSubscriptions[] = $obj;
                        }
                    }
                }

                $this->collSubscriptions = $collSubscriptions;
                $this->collSubscriptionsPartial = false;
            }
        }

        return $this->collSubscriptions;
    }

    /**
     * Sets a collection of ChildSubscription objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $subscriptions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCourse The current object (for fluent API support)
     */
    public function setSubscriptions(Collection $subscriptions, ConnectionInterface $con = null)
    {
        /** @var ChildSubscription[] $subscriptionsToDelete */
        $subscriptionsToDelete = $this->getSubscriptions(new Criteria(), $con)->diff($subscriptions);

        
        $this->subscriptionsScheduledForDeletion = $subscriptionsToDelete;

        foreach ($subscriptionsToDelete as $subscriptionRemoved) {
            $subscriptionRemoved->setCourse(null);
        }

        $this->collSubscriptions = null;
        foreach ($subscriptions as $subscription) {
            $this->addSubscription($subscription);
        }

        $this->collSubscriptions = $subscriptions;
        $this->collSubscriptionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Subscription objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Subscription objects.
     * @throws PropelException
     */
    public function countSubscriptions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSubscriptionsPartial && !$this->isNew();
        if (null === $this->collSubscriptions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSubscriptions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSubscriptions());
            }

            $query = ChildSubscriptionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCourse($this)
                ->count($con);
        }

        return count($this->collSubscriptions);
    }

    /**
     * Method called to associate a ChildSubscription object to this object
     * through the ChildSubscription foreign key attribute.
     *
     * @param  ChildSubscription $l ChildSubscription
     * @return $this|\bdxe\Course The current object (for fluent API support)
     */
    public function addSubscription(ChildSubscription $l)
    {
        if ($this->collSubscriptions === null) {
            $this->initSubscriptions();
            $this->collSubscriptionsPartial = true;
        }

        if (!$this->collSubscriptions->contains($l)) {
            $this->doAddSubscription($l);
        }

        return $this;
    }

    /**
     * @param ChildSubscription $subscription The ChildSubscription object to add.
     */
    protected function doAddSubscription(ChildSubscription $subscription)
    {
        $this->collSubscriptions[]= $subscription;
        $subscription->setCourse($this);
    }

    /**
     * @param  ChildSubscription $subscription The ChildSubscription object to remove.
     * @return $this|ChildCourse The current object (for fluent API support)
     */
    public function removeSubscription(ChildSubscription $subscription)
    {
        if ($this->getSubscriptions()->contains($subscription)) {
            $pos = $this->collSubscriptions->search($subscription);
            $this->collSubscriptions->remove($pos);
            if (null === $this->subscriptionsScheduledForDeletion) {
                $this->subscriptionsScheduledForDeletion = clone $this->collSubscriptions;
                $this->subscriptionsScheduledForDeletion->clear();
            }
            $this->subscriptionsScheduledForDeletion[]= $subscription;
            $subscription->setCourse(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Course is new, it will return
     * an empty collection; or if this Course has previously
     * been saved, it will retrieve related Subscriptions from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Course.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSubscription[] List of ChildSubscription objects
     */
    public function getSubscriptionsJoinStudent(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSubscriptionQuery::create(null, $criteria);
        $query->joinWith('Student', $joinBehavior);

        return $this->getSubscriptions($query, $con);
    }

    /**
     * Clears out the collHomeworks collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addHomeworks()
     */
    public function clearHomeworks()
    {
        $this->collHomeworks = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collHomeworks collection loaded partially.
     */
    public function resetPartialHomeworks($v = true)
    {
        $this->collHomeworksPartial = $v;
    }

    /**
     * Initializes the collHomeworks collection.
     *
     * By default this just sets the collHomeworks collection to an empty array (like clearcollHomeworks());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initHomeworks($overrideExisting = true)
    {
        if (null !== $this->collHomeworks && !$overrideExisting) {
            return;
        }
        $this->collHomeworks = new ObjectCollection();
        $this->collHomeworks->setModel('\bdxe\Homework');
    }

    /**
     * Gets an array of ChildHomework objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCourse is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildHomework[] List of ChildHomework objects
     * @throws PropelException
     */
    public function getHomeworks(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collHomeworksPartial && !$this->isNew();
        if (null === $this->collHomeworks || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collHomeworks) {
                // return empty collection
                $this->initHomeworks();
            } else {
                $collHomeworks = ChildHomeworkQuery::create(null, $criteria)
                    ->filterByCourse($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collHomeworksPartial && count($collHomeworks)) {
                        $this->initHomeworks(false);

                        foreach ($collHomeworks as $obj) {
                            if (false == $this->collHomeworks->contains($obj)) {
                                $this->collHomeworks->append($obj);
                            }
                        }

                        $this->collHomeworksPartial = true;
                    }

                    return $collHomeworks;
                }

                if ($partial && $this->collHomeworks) {
                    foreach ($this->collHomeworks as $obj) {
                        if ($obj->isNew()) {
                            $collHomeworks[] = $obj;
                        }
                    }
                }

                $this->collHomeworks = $collHomeworks;
                $this->collHomeworksPartial = false;
            }
        }

        return $this->collHomeworks;
    }

    /**
     * Sets a collection of ChildHomework objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $homeworks A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCourse The current object (for fluent API support)
     */
    public function setHomeworks(Collection $homeworks, ConnectionInterface $con = null)
    {
        /** @var ChildHomework[] $homeworksToDelete */
        $homeworksToDelete = $this->getHomeworks(new Criteria(), $con)->diff($homeworks);

        
        $this->homeworksScheduledForDeletion = $homeworksToDelete;

        foreach ($homeworksToDelete as $homeworkRemoved) {
            $homeworkRemoved->setCourse(null);
        }

        $this->collHomeworks = null;
        foreach ($homeworks as $homework) {
            $this->addHomework($homework);
        }

        $this->collHomeworks = $homeworks;
        $this->collHomeworksPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Homework objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Homework objects.
     * @throws PropelException
     */
    public function countHomeworks(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collHomeworksPartial && !$this->isNew();
        if (null === $this->collHomeworks || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collHomeworks) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getHomeworks());
            }

            $query = ChildHomeworkQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCourse($this)
                ->count($con);
        }

        return count($this->collHomeworks);
    }

    /**
     * Method called to associate a ChildHomework object to this object
     * through the ChildHomework foreign key attribute.
     *
     * @param  ChildHomework $l ChildHomework
     * @return $this|\bdxe\Course The current object (for fluent API support)
     */
    public function addHomework(ChildHomework $l)
    {
        if ($this->collHomeworks === null) {
            $this->initHomeworks();
            $this->collHomeworksPartial = true;
        }

        if (!$this->collHomeworks->contains($l)) {
            $this->doAddHomework($l);
        }

        return $this;
    }

    /**
     * @param ChildHomework $homework The ChildHomework object to add.
     */
    protected function doAddHomework(ChildHomework $homework)
    {
        $this->collHomeworks[]= $homework;
        $homework->setCourse($this);
    }

    /**
     * @param  ChildHomework $homework The ChildHomework object to remove.
     * @return $this|ChildCourse The current object (for fluent API support)
     */
    public function removeHomework(ChildHomework $homework)
    {
        if ($this->getHomeworks()->contains($homework)) {
            $pos = $this->collHomeworks->search($homework);
            $this->collHomeworks->remove($pos);
            if (null === $this->homeworksScheduledForDeletion) {
                $this->homeworksScheduledForDeletion = clone $this->collHomeworks;
                $this->homeworksScheduledForDeletion->clear();
            }
            $this->homeworksScheduledForDeletion[]= $homework;
            $homework->setCourse(null);
        }

        return $this;
    }

    /**
     * Clears out the collTests collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTests()
     */
    public function clearTests()
    {
        $this->collTests = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTests collection loaded partially.
     */
    public function resetPartialTests($v = true)
    {
        $this->collTestsPartial = $v;
    }

    /**
     * Initializes the collTests collection.
     *
     * By default this just sets the collTests collection to an empty array (like clearcollTests());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTests($overrideExisting = true)
    {
        if (null !== $this->collTests && !$overrideExisting) {
            return;
        }
        $this->collTests = new ObjectCollection();
        $this->collTests->setModel('\bdxe\Test');
    }

    /**
     * Gets an array of ChildTest objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCourse is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTest[] List of ChildTest objects
     * @throws PropelException
     */
    public function getTests(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTestsPartial && !$this->isNew();
        if (null === $this->collTests || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTests) {
                // return empty collection
                $this->initTests();
            } else {
                $collTests = ChildTestQuery::create(null, $criteria)
                    ->filterByCourse($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTestsPartial && count($collTests)) {
                        $this->initTests(false);

                        foreach ($collTests as $obj) {
                            if (false == $this->collTests->contains($obj)) {
                                $this->collTests->append($obj);
                            }
                        }

                        $this->collTestsPartial = true;
                    }

                    return $collTests;
                }

                if ($partial && $this->collTests) {
                    foreach ($this->collTests as $obj) {
                        if ($obj->isNew()) {
                            $collTests[] = $obj;
                        }
                    }
                }

                $this->collTests = $collTests;
                $this->collTestsPartial = false;
            }
        }

        return $this->collTests;
    }

    /**
     * Sets a collection of ChildTest objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $tests A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCourse The current object (for fluent API support)
     */
    public function setTests(Collection $tests, ConnectionInterface $con = null)
    {
        /** @var ChildTest[] $testsToDelete */
        $testsToDelete = $this->getTests(new Criteria(), $con)->diff($tests);

        
        $this->testsScheduledForDeletion = $testsToDelete;

        foreach ($testsToDelete as $testRemoved) {
            $testRemoved->setCourse(null);
        }

        $this->collTests = null;
        foreach ($tests as $test) {
            $this->addTest($test);
        }

        $this->collTests = $tests;
        $this->collTestsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Test objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Test objects.
     * @throws PropelException
     */
    public function countTests(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTestsPartial && !$this->isNew();
        if (null === $this->collTests || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTests) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTests());
            }

            $query = ChildTestQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCourse($this)
                ->count($con);
        }

        return count($this->collTests);
    }

    /**
     * Method called to associate a ChildTest object to this object
     * through the ChildTest foreign key attribute.
     *
     * @param  ChildTest $l ChildTest
     * @return $this|\bdxe\Course The current object (for fluent API support)
     */
    public function addTest(ChildTest $l)
    {
        if ($this->collTests === null) {
            $this->initTests();
            $this->collTestsPartial = true;
        }

        if (!$this->collTests->contains($l)) {
            $this->doAddTest($l);
        }

        return $this;
    }

    /**
     * @param ChildTest $test The ChildTest object to add.
     */
    protected function doAddTest(ChildTest $test)
    {
        $this->collTests[]= $test;
        $test->setCourse($this);
    }

    /**
     * @param  ChildTest $test The ChildTest object to remove.
     * @return $this|ChildCourse The current object (for fluent API support)
     */
    public function removeTest(ChildTest $test)
    {
        if ($this->getTests()->contains($test)) {
            $pos = $this->collTests->search($test);
            $this->collTests->remove($pos);
            if (null === $this->testsScheduledForDeletion) {
                $this->testsScheduledForDeletion = clone $this->collTests;
                $this->testsScheduledForDeletion->clear();
            }
            $this->testsScheduledForDeletion[]= $test;
            $test->setCourse(null);
        }

        return $this;
    }

    /**
     * Clears out the collProjects collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addProjects()
     */
    public function clearProjects()
    {
        $this->collProjects = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collProjects collection loaded partially.
     */
    public function resetPartialProjects($v = true)
    {
        $this->collProjectsPartial = $v;
    }

    /**
     * Initializes the collProjects collection.
     *
     * By default this just sets the collProjects collection to an empty array (like clearcollProjects());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProjects($overrideExisting = true)
    {
        if (null !== $this->collProjects && !$overrideExisting) {
            return;
        }
        $this->collProjects = new ObjectCollection();
        $this->collProjects->setModel('\bdxe\Project');
    }

    /**
     * Gets an array of ChildProject objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCourse is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildProject[] List of ChildProject objects
     * @throws PropelException
     */
    public function getProjects(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collProjectsPartial && !$this->isNew();
        if (null === $this->collProjects || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collProjects) {
                // return empty collection
                $this->initProjects();
            } else {
                $collProjects = ChildProjectQuery::create(null, $criteria)
                    ->filterByCourse($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collProjectsPartial && count($collProjects)) {
                        $this->initProjects(false);

                        foreach ($collProjects as $obj) {
                            if (false == $this->collProjects->contains($obj)) {
                                $this->collProjects->append($obj);
                            }
                        }

                        $this->collProjectsPartial = true;
                    }

                    return $collProjects;
                }

                if ($partial && $this->collProjects) {
                    foreach ($this->collProjects as $obj) {
                        if ($obj->isNew()) {
                            $collProjects[] = $obj;
                        }
                    }
                }

                $this->collProjects = $collProjects;
                $this->collProjectsPartial = false;
            }
        }

        return $this->collProjects;
    }

    /**
     * Sets a collection of ChildProject objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $projects A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCourse The current object (for fluent API support)
     */
    public function setProjects(Collection $projects, ConnectionInterface $con = null)
    {
        /** @var ChildProject[] $projectsToDelete */
        $projectsToDelete = $this->getProjects(new Criteria(), $con)->diff($projects);

        
        $this->projectsScheduledForDeletion = $projectsToDelete;

        foreach ($projectsToDelete as $projectRemoved) {
            $projectRemoved->setCourse(null);
        }

        $this->collProjects = null;
        foreach ($projects as $project) {
            $this->addProject($project);
        }

        $this->collProjects = $projects;
        $this->collProjectsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Project objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Project objects.
     * @throws PropelException
     */
    public function countProjects(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collProjectsPartial && !$this->isNew();
        if (null === $this->collProjects || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProjects) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getProjects());
            }

            $query = ChildProjectQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCourse($this)
                ->count($con);
        }

        return count($this->collProjects);
    }

    /**
     * Method called to associate a ChildProject object to this object
     * through the ChildProject foreign key attribute.
     *
     * @param  ChildProject $l ChildProject
     * @return $this|\bdxe\Course The current object (for fluent API support)
     */
    public function addProject(ChildProject $l)
    {
        if ($this->collProjects === null) {
            $this->initProjects();
            $this->collProjectsPartial = true;
        }

        if (!$this->collProjects->contains($l)) {
            $this->doAddProject($l);
        }

        return $this;
    }

    /**
     * @param ChildProject $project The ChildProject object to add.
     */
    protected function doAddProject(ChildProject $project)
    {
        $this->collProjects[]= $project;
        $project->setCourse($this);
    }

    /**
     * @param  ChildProject $project The ChildProject object to remove.
     * @return $this|ChildCourse The current object (for fluent API support)
     */
    public function removeProject(ChildProject $project)
    {
        if ($this->getProjects()->contains($project)) {
            $pos = $this->collProjects->search($project);
            $this->collProjects->remove($pos);
            if (null === $this->projectsScheduledForDeletion) {
                $this->projectsScheduledForDeletion = clone $this->collProjects;
                $this->projectsScheduledForDeletion->clear();
            }
            $this->projectsScheduledForDeletion[]= $project;
            $project->setCourse(null);
        }

        return $this;
    }

    /**
     * Clears out the collSubjectsRelatedByCourseId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSubjectsRelatedByCourseId()
     */
    public function clearSubjectsRelatedByCourseId()
    {
        $this->collSubjectsRelatedByCourseId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSubjectsRelatedByCourseId collection loaded partially.
     */
    public function resetPartialSubjectsRelatedByCourseId($v = true)
    {
        $this->collSubjectsRelatedByCourseIdPartial = $v;
    }

    /**
     * Initializes the collSubjectsRelatedByCourseId collection.
     *
     * By default this just sets the collSubjectsRelatedByCourseId collection to an empty array (like clearcollSubjectsRelatedByCourseId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSubjectsRelatedByCourseId($overrideExisting = true)
    {
        if (null !== $this->collSubjectsRelatedByCourseId && !$overrideExisting) {
            return;
        }
        $this->collSubjectsRelatedByCourseId = new ObjectCollection();
        $this->collSubjectsRelatedByCourseId->setModel('\bdxe\Subject');
    }

    /**
     * Gets an array of ChildSubject objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCourse is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSubject[] List of ChildSubject objects
     * @throws PropelException
     */
    public function getSubjectsRelatedByCourseId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSubjectsRelatedByCourseIdPartial && !$this->isNew();
        if (null === $this->collSubjectsRelatedByCourseId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSubjectsRelatedByCourseId) {
                // return empty collection
                $this->initSubjectsRelatedByCourseId();
            } else {
                $collSubjectsRelatedByCourseId = ChildSubjectQuery::create(null, $criteria)
                    ->filterByCourseRelatedByCourseId($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSubjectsRelatedByCourseIdPartial && count($collSubjectsRelatedByCourseId)) {
                        $this->initSubjectsRelatedByCourseId(false);

                        foreach ($collSubjectsRelatedByCourseId as $obj) {
                            if (false == $this->collSubjectsRelatedByCourseId->contains($obj)) {
                                $this->collSubjectsRelatedByCourseId->append($obj);
                            }
                        }

                        $this->collSubjectsRelatedByCourseIdPartial = true;
                    }

                    return $collSubjectsRelatedByCourseId;
                }

                if ($partial && $this->collSubjectsRelatedByCourseId) {
                    foreach ($this->collSubjectsRelatedByCourseId as $obj) {
                        if ($obj->isNew()) {
                            $collSubjectsRelatedByCourseId[] = $obj;
                        }
                    }
                }

                $this->collSubjectsRelatedByCourseId = $collSubjectsRelatedByCourseId;
                $this->collSubjectsRelatedByCourseIdPartial = false;
            }
        }

        return $this->collSubjectsRelatedByCourseId;
    }

    /**
     * Sets a collection of ChildSubject objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $subjectsRelatedByCourseId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCourse The current object (for fluent API support)
     */
    public function setSubjectsRelatedByCourseId(Collection $subjectsRelatedByCourseId, ConnectionInterface $con = null)
    {
        /** @var ChildSubject[] $subjectsRelatedByCourseIdToDelete */
        $subjectsRelatedByCourseIdToDelete = $this->getSubjectsRelatedByCourseId(new Criteria(), $con)->diff($subjectsRelatedByCourseId);

        
        $this->subjectsRelatedByCourseIdScheduledForDeletion = $subjectsRelatedByCourseIdToDelete;

        foreach ($subjectsRelatedByCourseIdToDelete as $subjectRelatedByCourseIdRemoved) {
            $subjectRelatedByCourseIdRemoved->setCourseRelatedByCourseId(null);
        }

        $this->collSubjectsRelatedByCourseId = null;
        foreach ($subjectsRelatedByCourseId as $subjectRelatedByCourseId) {
            $this->addSubjectRelatedByCourseId($subjectRelatedByCourseId);
        }

        $this->collSubjectsRelatedByCourseId = $subjectsRelatedByCourseId;
        $this->collSubjectsRelatedByCourseIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Subject objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Subject objects.
     * @throws PropelException
     */
    public function countSubjectsRelatedByCourseId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSubjectsRelatedByCourseIdPartial && !$this->isNew();
        if (null === $this->collSubjectsRelatedByCourseId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSubjectsRelatedByCourseId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSubjectsRelatedByCourseId());
            }

            $query = ChildSubjectQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCourseRelatedByCourseId($this)
                ->count($con);
        }

        return count($this->collSubjectsRelatedByCourseId);
    }

    /**
     * Method called to associate a ChildSubject object to this object
     * through the ChildSubject foreign key attribute.
     *
     * @param  ChildSubject $l ChildSubject
     * @return $this|\bdxe\Course The current object (for fluent API support)
     */
    public function addSubjectRelatedByCourseId(ChildSubject $l)
    {
        if ($this->collSubjectsRelatedByCourseId === null) {
            $this->initSubjectsRelatedByCourseId();
            $this->collSubjectsRelatedByCourseIdPartial = true;
        }

        if (!$this->collSubjectsRelatedByCourseId->contains($l)) {
            $this->doAddSubjectRelatedByCourseId($l);
        }

        return $this;
    }

    /**
     * @param ChildSubject $subjectRelatedByCourseId The ChildSubject object to add.
     */
    protected function doAddSubjectRelatedByCourseId(ChildSubject $subjectRelatedByCourseId)
    {
        $this->collSubjectsRelatedByCourseId[]= $subjectRelatedByCourseId;
        $subjectRelatedByCourseId->setCourseRelatedByCourseId($this);
    }

    /**
     * @param  ChildSubject $subjectRelatedByCourseId The ChildSubject object to remove.
     * @return $this|ChildCourse The current object (for fluent API support)
     */
    public function removeSubjectRelatedByCourseId(ChildSubject $subjectRelatedByCourseId)
    {
        if ($this->getSubjectsRelatedByCourseId()->contains($subjectRelatedByCourseId)) {
            $pos = $this->collSubjectsRelatedByCourseId->search($subjectRelatedByCourseId);
            $this->collSubjectsRelatedByCourseId->remove($pos);
            if (null === $this->subjectsRelatedByCourseIdScheduledForDeletion) {
                $this->subjectsRelatedByCourseIdScheduledForDeletion = clone $this->collSubjectsRelatedByCourseId;
                $this->subjectsRelatedByCourseIdScheduledForDeletion->clear();
            }
            $this->subjectsRelatedByCourseIdScheduledForDeletion[]= $subjectRelatedByCourseId;
            $subjectRelatedByCourseId->setCourseRelatedByCourseId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Course is new, it will return
     * an empty collection; or if this Course has previously
     * been saved, it will retrieve related SubjectsRelatedByCourseId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Course.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSubject[] List of ChildSubject objects
     */
    public function getSubjectsRelatedByCourseIdJoinStudent(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSubjectQuery::create(null, $criteria);
        $query->joinWith('Student', $joinBehavior);

        return $this->getSubjectsRelatedByCourseId($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aProfesor) {
            $this->aProfesor->removeCourse($this);
        }
        if (null !== $this->aSubjectRelatedBySubjectId) {
            $this->aSubjectRelatedBySubjectId->removeCourseRelatedBySubjectId($this);
        }
        $this->id = null;
        $this->profesor_id = null;
        $this->subject_id = null;
        $this->subject_name = null;
        $this->class_capacity = null;
        $this->initial_class_capacity = null;
        $this->start_date = null;
        $this->finish_date = null;
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
            if ($this->collSubscriptions) {
                foreach ($this->collSubscriptions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collHomeworks) {
                foreach ($this->collHomeworks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTests) {
                foreach ($this->collTests as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collProjects) {
                foreach ($this->collProjects as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSubjectsRelatedByCourseId) {
                foreach ($this->collSubjectsRelatedByCourseId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collSubscriptions = null;
        $this->collHomeworks = null;
        $this->collTests = null;
        $this->collProjects = null;
        $this->collSubjectsRelatedByCourseId = null;
        $this->aProfesor = null;
        $this->aSubjectRelatedBySubjectId = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CourseTableMap::DEFAULT_STRING_FORMAT);
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
