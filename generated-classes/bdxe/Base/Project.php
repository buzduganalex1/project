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
use bdxe\Group as ChildGroup;
use bdxe\GroupQuery as ChildGroupQuery;
use bdxe\Project as ChildProject;
use bdxe\ProjectEval as ChildProjectEval;
use bdxe\ProjectEvalQuery as ChildProjectEvalQuery;
use bdxe\ProjectQuery as ChildProjectQuery;
use bdxe\Map\ProjectTableMap;

/**
 * Base class that represents a row from the 'project_tb' table.
 *
 * 
 *
* @package    propel.generator.bdxe.Base
*/
abstract class Project implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\bdxe\\Map\\ProjectTableMap';


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
     * The value for the course_id field.
     * @var        int
     */
    protected $course_id;

    /**
     * The value for the titlu field.
     * @var        string
     */
    protected $titlu;

    /**
     * The value for the materie field.
     * @var        string
     */
    protected $materie;

    /**
     * The value for the dificultate field.
     * @var        string
     */
    protected $dificultate;

    /**
     * The value for the description field.
     * @var        string
     */
    protected $description;

    /**
     * The value for the nota field.
     * @var        int
     */
    protected $nota;

    /**
     * The value for the numar_participanti field.
     * @var        int
     */
    protected $numar_participanti;

    /**
     * The value for the duetime field.
     * @var        \DateTime
     */
    protected $duetime;

    /**
     * The value for the posttime field.
     * @var        \DateTime
     */
    protected $posttime;

    /**
     * @var        ChildCourse
     */
    protected $aCourse;

    /**
     * @var        ObjectCollection|ChildProjectEval[] Collection to store aggregation of ChildProjectEval objects.
     */
    protected $collProjectEvals;
    protected $collProjectEvalsPartial;

    /**
     * @var        ObjectCollection|ChildGroup[] Collection to store aggregation of ChildGroup objects.
     */
    protected $collGroups;
    protected $collGroupsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildProjectEval[]
     */
    protected $projectEvalsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGroup[]
     */
    protected $groupsScheduledForDeletion = null;

    /**
     * Initializes internal state of bdxe\Base\Project object.
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
     * Compares this with another <code>Project</code> instance.  If
     * <code>obj</code> is an instance of <code>Project</code>, delegates to
     * <code>equals(Project)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Project The current object, for fluid interface
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
     * Get the [course_id] column value.
     * 
     * @return int
     */
    public function getCourseId()
    {
        return $this->course_id;
    }

    /**
     * Get the [titlu] column value.
     * 
     * @return string
     */
    public function getTitlu()
    {
        return $this->titlu;
    }

    /**
     * Get the [materie] column value.
     * 
     * @return string
     */
    public function getMaterie()
    {
        return $this->materie;
    }

    /**
     * Get the [dificultate] column value.
     * 
     * @return string
     */
    public function getDificultate()
    {
        return $this->dificultate;
    }

    /**
     * Get the [description] column value.
     * 
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the [nota] column value.
     * 
     * @return int
     */
    public function getNota()
    {
        return $this->nota;
    }

    /**
     * Get the [numar_participanti] column value.
     * 
     * @return int
     */
    public function getNumarParticipanti()
    {
        return $this->numar_participanti;
    }

    /**
     * Get the [optionally formatted] temporal [duetime] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDuetime($format = NULL)
    {
        if ($format === null) {
            return $this->duetime;
        } else {
            return $this->duetime instanceof \DateTime ? $this->duetime->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [posttime] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getPosttime($format = NULL)
    {
        if ($format === null) {
            return $this->posttime;
        } else {
            return $this->posttime instanceof \DateTime ? $this->posttime->format($format) : null;
        }
    }

    /**
     * Set the value of [id] column.
     * 
     * @param int $v new value
     * @return $this|\bdxe\Project The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ProjectTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [course_id] column.
     * 
     * @param int $v new value
     * @return $this|\bdxe\Project The current object (for fluent API support)
     */
    public function setCourseId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->course_id !== $v) {
            $this->course_id = $v;
            $this->modifiedColumns[ProjectTableMap::COL_COURSE_ID] = true;
        }

        if ($this->aCourse !== null && $this->aCourse->getId() !== $v) {
            $this->aCourse = null;
        }

        return $this;
    } // setCourseId()

    /**
     * Set the value of [titlu] column.
     * 
     * @param string $v new value
     * @return $this|\bdxe\Project The current object (for fluent API support)
     */
    public function setTitlu($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->titlu !== $v) {
            $this->titlu = $v;
            $this->modifiedColumns[ProjectTableMap::COL_TITLU] = true;
        }

        return $this;
    } // setTitlu()

    /**
     * Set the value of [materie] column.
     * 
     * @param string $v new value
     * @return $this|\bdxe\Project The current object (for fluent API support)
     */
    public function setMaterie($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->materie !== $v) {
            $this->materie = $v;
            $this->modifiedColumns[ProjectTableMap::COL_MATERIE] = true;
        }

        return $this;
    } // setMaterie()

    /**
     * Set the value of [dificultate] column.
     * 
     * @param string $v new value
     * @return $this|\bdxe\Project The current object (for fluent API support)
     */
    public function setDificultate($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->dificultate !== $v) {
            $this->dificultate = $v;
            $this->modifiedColumns[ProjectTableMap::COL_DIFICULTATE] = true;
        }

        return $this;
    } // setDificultate()

    /**
     * Set the value of [description] column.
     * 
     * @param string $v new value
     * @return $this|\bdxe\Project The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[ProjectTableMap::COL_DESCRIPTION] = true;
        }

        return $this;
    } // setDescription()

    /**
     * Set the value of [nota] column.
     * 
     * @param int $v new value
     * @return $this|\bdxe\Project The current object (for fluent API support)
     */
    public function setNota($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->nota !== $v) {
            $this->nota = $v;
            $this->modifiedColumns[ProjectTableMap::COL_NOTA] = true;
        }

        return $this;
    } // setNota()

    /**
     * Set the value of [numar_participanti] column.
     * 
     * @param int $v new value
     * @return $this|\bdxe\Project The current object (for fluent API support)
     */
    public function setNumarParticipanti($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->numar_participanti !== $v) {
            $this->numar_participanti = $v;
            $this->modifiedColumns[ProjectTableMap::COL_NUMAR_PARTICIPANTI] = true;
        }

        return $this;
    } // setNumarParticipanti()

    /**
     * Sets the value of [duetime] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\bdxe\Project The current object (for fluent API support)
     */
    public function setDuetime($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->duetime !== null || $dt !== null) {
            if ($this->duetime === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->duetime->format("Y-m-d H:i:s")) {
                $this->duetime = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ProjectTableMap::COL_DUETIME] = true;
            }
        } // if either are not null

        return $this;
    } // setDuetime()

    /**
     * Sets the value of [posttime] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\bdxe\Project The current object (for fluent API support)
     */
    public function setPosttime($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->posttime !== null || $dt !== null) {
            if ($this->posttime === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->posttime->format("Y-m-d H:i:s")) {
                $this->posttime = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ProjectTableMap::COL_POSTTIME] = true;
            }
        } // if either are not null

        return $this;
    } // setPosttime()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ProjectTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ProjectTableMap::translateFieldName('CourseId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->course_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ProjectTableMap::translateFieldName('Titlu', TableMap::TYPE_PHPNAME, $indexType)];
            $this->titlu = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ProjectTableMap::translateFieldName('Materie', TableMap::TYPE_PHPNAME, $indexType)];
            $this->materie = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ProjectTableMap::translateFieldName('Dificultate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->dificultate = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ProjectTableMap::translateFieldName('Description', TableMap::TYPE_PHPNAME, $indexType)];
            $this->description = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ProjectTableMap::translateFieldName('Nota', TableMap::TYPE_PHPNAME, $indexType)];
            $this->nota = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : ProjectTableMap::translateFieldName('NumarParticipanti', TableMap::TYPE_PHPNAME, $indexType)];
            $this->numar_participanti = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : ProjectTableMap::translateFieldName('Duetime', TableMap::TYPE_PHPNAME, $indexType)];
            $this->duetime = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : ProjectTableMap::translateFieldName('Posttime', TableMap::TYPE_PHPNAME, $indexType)];
            $this->posttime = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10; // 10 = ProjectTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\bdxe\\Project'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(ProjectTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildProjectQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCourse = null;
            $this->collProjectEvals = null;

            $this->collGroups = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Project::setDeleted()
     * @see Project::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProjectTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildProjectQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ProjectTableMap::DATABASE_NAME);
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
                ProjectTableMap::addInstanceToPool($this);
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

            if ($this->groupsScheduledForDeletion !== null) {
                if (!$this->groupsScheduledForDeletion->isEmpty()) {
                    foreach ($this->groupsScheduledForDeletion as $group) {
                        // need to save related object because we set the relation to null
                        $group->save($con);
                    }
                    $this->groupsScheduledForDeletion = null;
                }
            }

            if ($this->collGroups !== null) {
                foreach ($this->collGroups as $referrerFK) {
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

        $this->modifiedColumns[ProjectTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ProjectTableMap::COL_ID . ')');
        }
        if (null === $this->id) {
            try {                
                $dataFetcher = $con->query('SELECT project_tb_SEQ.nextval FROM dual');
                $this->id = $dataFetcher->fetchColumn();
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', 0, $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ProjectTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(ProjectTableMap::COL_COURSE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'course_id';
        }
        if ($this->isColumnModified(ProjectTableMap::COL_TITLU)) {
            $modifiedColumns[':p' . $index++]  = 'Titlu';
        }
        if ($this->isColumnModified(ProjectTableMap::COL_MATERIE)) {
            $modifiedColumns[':p' . $index++]  = 'Materie';
        }
        if ($this->isColumnModified(ProjectTableMap::COL_DIFICULTATE)) {
            $modifiedColumns[':p' . $index++]  = 'Dificultate';
        }
        if ($this->isColumnModified(ProjectTableMap::COL_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'Description';
        }
        if ($this->isColumnModified(ProjectTableMap::COL_NOTA)) {
            $modifiedColumns[':p' . $index++]  = 'Nota';
        }
        if ($this->isColumnModified(ProjectTableMap::COL_NUMAR_PARTICIPANTI)) {
            $modifiedColumns[':p' . $index++]  = 'Numar_Participanti';
        }
        if ($this->isColumnModified(ProjectTableMap::COL_DUETIME)) {
            $modifiedColumns[':p' . $index++]  = 'DueTime';
        }
        if ($this->isColumnModified(ProjectTableMap::COL_POSTTIME)) {
            $modifiedColumns[':p' . $index++]  = 'PostTime';
        }

        $sql = sprintf(
            'INSERT INTO project_tb (%s) VALUES (%s)',
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
                    case 'course_id':                        
                        $stmt->bindValue($identifier, $this->course_id, PDO::PARAM_INT);
                        break;
                    case 'Titlu':                        
                        $stmt->bindValue($identifier, $this->titlu, PDO::PARAM_STR);
                        break;
                    case 'Materie':                        
                        $stmt->bindValue($identifier, $this->materie, PDO::PARAM_STR);
                        break;
                    case 'Dificultate':                        
                        $stmt->bindValue($identifier, $this->dificultate, PDO::PARAM_STR);
                        break;
                    case 'Description':                        
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                    case 'Nota':                        
                        $stmt->bindValue($identifier, $this->nota, PDO::PARAM_INT);
                        break;
                    case 'Numar_Participanti':                        
                        $stmt->bindValue($identifier, $this->numar_participanti, PDO::PARAM_INT);
                        break;
                    case 'DueTime':                        
                        $stmt->bindValue($identifier, $this->duetime ? $this->duetime->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'PostTime':                        
                        $stmt->bindValue($identifier, $this->posttime ? $this->posttime->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
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
        $pos = ProjectTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getCourseId();
                break;
            case 2:
                return $this->getTitlu();
                break;
            case 3:
                return $this->getMaterie();
                break;
            case 4:
                return $this->getDificultate();
                break;
            case 5:
                return $this->getDescription();
                break;
            case 6:
                return $this->getNota();
                break;
            case 7:
                return $this->getNumarParticipanti();
                break;
            case 8:
                return $this->getDuetime();
                break;
            case 9:
                return $this->getPosttime();
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

        if (isset($alreadyDumpedObjects['Project'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Project'][$this->hashCode()] = true;
        $keys = ProjectTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getCourseId(),
            $keys[2] => $this->getTitlu(),
            $keys[3] => $this->getMaterie(),
            $keys[4] => $this->getDificultate(),
            $keys[5] => $this->getDescription(),
            $keys[6] => $this->getNota(),
            $keys[7] => $this->getNumarParticipanti(),
            $keys[8] => $this->getDuetime(),
            $keys[9] => $this->getPosttime(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[8]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[8]];
            $result[$keys[8]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }
        
        if ($result[$keys[9]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[9]];
            $result[$keys[9]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }
        
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
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
            if (null !== $this->collGroups) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'groups';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'group_tbs';
                        break;
                    default:
                        $key = 'Groups';
                }
        
                $result[$key] = $this->collGroups->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\bdxe\Project
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ProjectTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\bdxe\Project
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setCourseId($value);
                break;
            case 2:
                $this->setTitlu($value);
                break;
            case 3:
                $this->setMaterie($value);
                break;
            case 4:
                $this->setDificultate($value);
                break;
            case 5:
                $this->setDescription($value);
                break;
            case 6:
                $this->setNota($value);
                break;
            case 7:
                $this->setNumarParticipanti($value);
                break;
            case 8:
                $this->setDuetime($value);
                break;
            case 9:
                $this->setPosttime($value);
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
        $keys = ProjectTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setCourseId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setTitlu($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setMaterie($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setDificultate($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setDescription($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setNota($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setNumarParticipanti($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setDuetime($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setPosttime($arr[$keys[9]]);
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
     * @return $this|\bdxe\Project The current object, for fluid interface
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
        $criteria = new Criteria(ProjectTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ProjectTableMap::COL_ID)) {
            $criteria->add(ProjectTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(ProjectTableMap::COL_COURSE_ID)) {
            $criteria->add(ProjectTableMap::COL_COURSE_ID, $this->course_id);
        }
        if ($this->isColumnModified(ProjectTableMap::COL_TITLU)) {
            $criteria->add(ProjectTableMap::COL_TITLU, $this->titlu);
        }
        if ($this->isColumnModified(ProjectTableMap::COL_MATERIE)) {
            $criteria->add(ProjectTableMap::COL_MATERIE, $this->materie);
        }
        if ($this->isColumnModified(ProjectTableMap::COL_DIFICULTATE)) {
            $criteria->add(ProjectTableMap::COL_DIFICULTATE, $this->dificultate);
        }
        if ($this->isColumnModified(ProjectTableMap::COL_DESCRIPTION)) {
            $criteria->add(ProjectTableMap::COL_DESCRIPTION, $this->description);
        }
        if ($this->isColumnModified(ProjectTableMap::COL_NOTA)) {
            $criteria->add(ProjectTableMap::COL_NOTA, $this->nota);
        }
        if ($this->isColumnModified(ProjectTableMap::COL_NUMAR_PARTICIPANTI)) {
            $criteria->add(ProjectTableMap::COL_NUMAR_PARTICIPANTI, $this->numar_participanti);
        }
        if ($this->isColumnModified(ProjectTableMap::COL_DUETIME)) {
            $criteria->add(ProjectTableMap::COL_DUETIME, $this->duetime);
        }
        if ($this->isColumnModified(ProjectTableMap::COL_POSTTIME)) {
            $criteria->add(ProjectTableMap::COL_POSTTIME, $this->posttime);
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
        $criteria = ChildProjectQuery::create();
        $criteria->add(ProjectTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \bdxe\Project (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setCourseId($this->getCourseId());
        $copyObj->setTitlu($this->getTitlu());
        $copyObj->setMaterie($this->getMaterie());
        $copyObj->setDificultate($this->getDificultate());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setNota($this->getNota());
        $copyObj->setNumarParticipanti($this->getNumarParticipanti());
        $copyObj->setDuetime($this->getDuetime());
        $copyObj->setPosttime($this->getPosttime());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getProjectEvals() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProjectEval($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getGroups() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addGroup($relObj->copy($deepCopy));
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
     * @return \bdxe\Project Clone of current object.
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
     * Declares an association between this object and a ChildCourse object.
     *
     * @param  ChildCourse $v
     * @return $this|\bdxe\Project The current object (for fluent API support)
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
            $v->addProject($this);
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
                $this->aCourse->addProjects($this);
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
        if ('ProjectEval' == $relationName) {
            return $this->initProjectEvals();
        }
        if ('Group' == $relationName) {
            return $this->initGroups();
        }
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
     * If this ChildProject is new, it will return
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
                    ->filterByProject($this)
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
     * @return $this|ChildProject The current object (for fluent API support)
     */
    public function setProjectEvals(Collection $projectEvals, ConnectionInterface $con = null)
    {
        /** @var ChildProjectEval[] $projectEvalsToDelete */
        $projectEvalsToDelete = $this->getProjectEvals(new Criteria(), $con)->diff($projectEvals);

        
        $this->projectEvalsScheduledForDeletion = $projectEvalsToDelete;

        foreach ($projectEvalsToDelete as $projectEvalRemoved) {
            $projectEvalRemoved->setProject(null);
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
                ->filterByProject($this)
                ->count($con);
        }

        return count($this->collProjectEvals);
    }

    /**
     * Method called to associate a ChildProjectEval object to this object
     * through the ChildProjectEval foreign key attribute.
     *
     * @param  ChildProjectEval $l ChildProjectEval
     * @return $this|\bdxe\Project The current object (for fluent API support)
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
        $projectEval->setProject($this);
    }

    /**
     * @param  ChildProjectEval $projectEval The ChildProjectEval object to remove.
     * @return $this|ChildProject The current object (for fluent API support)
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
            $projectEval->setProject(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Project is new, it will return
     * an empty collection; or if this Project has previously
     * been saved, it will retrieve related ProjectEvals from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Project.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildProjectEval[] List of ChildProjectEval objects
     */
    public function getProjectEvalsJoinSubscription(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildProjectEvalQuery::create(null, $criteria);
        $query->joinWith('Subscription', $joinBehavior);

        return $this->getProjectEvals($query, $con);
    }

    /**
     * Clears out the collGroups collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addGroups()
     */
    public function clearGroups()
    {
        $this->collGroups = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collGroups collection loaded partially.
     */
    public function resetPartialGroups($v = true)
    {
        $this->collGroupsPartial = $v;
    }

    /**
     * Initializes the collGroups collection.
     *
     * By default this just sets the collGroups collection to an empty array (like clearcollGroups());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initGroups($overrideExisting = true)
    {
        if (null !== $this->collGroups && !$overrideExisting) {
            return;
        }
        $this->collGroups = new ObjectCollection();
        $this->collGroups->setModel('\bdxe\Group');
    }

    /**
     * Gets an array of ChildGroup objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildProject is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildGroup[] List of ChildGroup objects
     * @throws PropelException
     */
    public function getGroups(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collGroupsPartial && !$this->isNew();
        if (null === $this->collGroups || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collGroups) {
                // return empty collection
                $this->initGroups();
            } else {
                $collGroups = ChildGroupQuery::create(null, $criteria)
                    ->filterByProject($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collGroupsPartial && count($collGroups)) {
                        $this->initGroups(false);

                        foreach ($collGroups as $obj) {
                            if (false == $this->collGroups->contains($obj)) {
                                $this->collGroups->append($obj);
                            }
                        }

                        $this->collGroupsPartial = true;
                    }

                    return $collGroups;
                }

                if ($partial && $this->collGroups) {
                    foreach ($this->collGroups as $obj) {
                        if ($obj->isNew()) {
                            $collGroups[] = $obj;
                        }
                    }
                }

                $this->collGroups = $collGroups;
                $this->collGroupsPartial = false;
            }
        }

        return $this->collGroups;
    }

    /**
     * Sets a collection of ChildGroup objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $groups A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildProject The current object (for fluent API support)
     */
    public function setGroups(Collection $groups, ConnectionInterface $con = null)
    {
        /** @var ChildGroup[] $groupsToDelete */
        $groupsToDelete = $this->getGroups(new Criteria(), $con)->diff($groups);

        
        $this->groupsScheduledForDeletion = $groupsToDelete;

        foreach ($groupsToDelete as $groupRemoved) {
            $groupRemoved->setProject(null);
        }

        $this->collGroups = null;
        foreach ($groups as $group) {
            $this->addGroup($group);
        }

        $this->collGroups = $groups;
        $this->collGroupsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Group objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Group objects.
     * @throws PropelException
     */
    public function countGroups(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collGroupsPartial && !$this->isNew();
        if (null === $this->collGroups || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collGroups) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getGroups());
            }

            $query = ChildGroupQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProject($this)
                ->count($con);
        }

        return count($this->collGroups);
    }

    /**
     * Method called to associate a ChildGroup object to this object
     * through the ChildGroup foreign key attribute.
     *
     * @param  ChildGroup $l ChildGroup
     * @return $this|\bdxe\Project The current object (for fluent API support)
     */
    public function addGroup(ChildGroup $l)
    {
        if ($this->collGroups === null) {
            $this->initGroups();
            $this->collGroupsPartial = true;
        }

        if (!$this->collGroups->contains($l)) {
            $this->doAddGroup($l);
        }

        return $this;
    }

    /**
     * @param ChildGroup $group The ChildGroup object to add.
     */
    protected function doAddGroup(ChildGroup $group)
    {
        $this->collGroups[]= $group;
        $group->setProject($this);
    }

    /**
     * @param  ChildGroup $group The ChildGroup object to remove.
     * @return $this|ChildProject The current object (for fluent API support)
     */
    public function removeGroup(ChildGroup $group)
    {
        if ($this->getGroups()->contains($group)) {
            $pos = $this->collGroups->search($group);
            $this->collGroups->remove($pos);
            if (null === $this->groupsScheduledForDeletion) {
                $this->groupsScheduledForDeletion = clone $this->collGroups;
                $this->groupsScheduledForDeletion->clear();
            }
            $this->groupsScheduledForDeletion[]= $group;
            $group->setProject(null);
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
        if (null !== $this->aCourse) {
            $this->aCourse->removeProject($this);
        }
        $this->id = null;
        $this->course_id = null;
        $this->titlu = null;
        $this->materie = null;
        $this->dificultate = null;
        $this->description = null;
        $this->nota = null;
        $this->numar_participanti = null;
        $this->duetime = null;
        $this->posttime = null;
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
            if ($this->collProjectEvals) {
                foreach ($this->collProjectEvals as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collGroups) {
                foreach ($this->collGroups as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collProjectEvals = null;
        $this->collGroups = null;
        $this->aCourse = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ProjectTableMap::DEFAULT_STRING_FORMAT);
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
