<?php

namespace bdxe\Map;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;
use bdxe\Homework;
use bdxe\HomeworkQuery;


/**
 * This class defines the structure of the 'homework_tb' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class HomeworkTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'bdxe.Map.HomeworkTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'homework_tb';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\bdxe\\Homework';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'bdxe.Homework';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the id field
     */
    const COL_ID = 'homework_tb.id';

    /**
     * the column name for the course_id field
     */
    const COL_COURSE_ID = 'homework_tb.course_id';

    /**
     * the column name for the Materie field
     */
    const COL_MATERIE = 'homework_tb.Materie';

    /**
     * the column name for the DueTime field
     */
    const COL_DUETIME = 'homework_tb.DueTime';

    /**
     * the column name for the Description field
     */
    const COL_DESCRIPTION = 'homework_tb.Description';

    /**
     * the column name for the PostTime field
     */
    const COL_POSTTIME = 'homework_tb.PostTime';

    /**
     * the column name for the Nota field
     */
    const COL_NOTA = 'homework_tb.Nota';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'CourseId', 'Materie', 'Duetime', 'Description', 'Posttime', 'Nota', ),
        self::TYPE_CAMELNAME     => array('id', 'courseId', 'materie', 'duetime', 'description', 'posttime', 'nota', ),
        self::TYPE_COLNAME       => array(HomeworkTableMap::COL_ID, HomeworkTableMap::COL_COURSE_ID, HomeworkTableMap::COL_MATERIE, HomeworkTableMap::COL_DUETIME, HomeworkTableMap::COL_DESCRIPTION, HomeworkTableMap::COL_POSTTIME, HomeworkTableMap::COL_NOTA, ),
        self::TYPE_FIELDNAME     => array('id', 'course_id', 'Materie', 'DueTime', 'Description', 'PostTime', 'Nota', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'CourseId' => 1, 'Materie' => 2, 'Duetime' => 3, 'Description' => 4, 'Posttime' => 5, 'Nota' => 6, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'courseId' => 1, 'materie' => 2, 'duetime' => 3, 'description' => 4, 'posttime' => 5, 'nota' => 6, ),
        self::TYPE_COLNAME       => array(HomeworkTableMap::COL_ID => 0, HomeworkTableMap::COL_COURSE_ID => 1, HomeworkTableMap::COL_MATERIE => 2, HomeworkTableMap::COL_DUETIME => 3, HomeworkTableMap::COL_DESCRIPTION => 4, HomeworkTableMap::COL_POSTTIME => 5, HomeworkTableMap::COL_NOTA => 6, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'course_id' => 1, 'Materie' => 2, 'DueTime' => 3, 'Description' => 4, 'PostTime' => 5, 'Nota' => 6, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('homework_tb');
        $this->setPhpName('Homework');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\bdxe\\Homework');
        $this->setPackage('bdxe');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('homework_tb_SEQ');
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('course_id', 'CourseId', 'INTEGER', 'course_tb', 'id', false, null, null);
        $this->addColumn('Materie', 'Materie', 'VARCHAR', false, 255, null);
        $this->addColumn('DueTime', 'Duetime', 'TIMESTAMP', false, null, null);
        $this->addColumn('Description', 'Description', 'LONGVARCHAR', false, 2000, null);
        $this->addColumn('PostTime', 'Posttime', 'TIMESTAMP', false, null, null);
        $this->addColumn('Nota', 'Nota', 'INTEGER', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Course', '\\bdxe\\Course', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':course_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('HomeworkEval', '\\bdxe\\HomeworkEval', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':homework_id',
    1 => ':id',
  ),
), null, null, 'HomeworkEvals', false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }
    
    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? HomeworkTableMap::CLASS_DEFAULT : HomeworkTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Homework object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = HomeworkTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = HomeworkTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + HomeworkTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = HomeworkTableMap::OM_CLASS;
            /** @var Homework $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            HomeworkTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();
    
        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = HomeworkTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = HomeworkTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Homework $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                HomeworkTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(HomeworkTableMap::COL_ID);
            $criteria->addSelectColumn(HomeworkTableMap::COL_COURSE_ID);
            $criteria->addSelectColumn(HomeworkTableMap::COL_MATERIE);
            $criteria->addSelectColumn(HomeworkTableMap::COL_DUETIME);
            $criteria->addSelectColumn(HomeworkTableMap::COL_DESCRIPTION);
            $criteria->addSelectColumn(HomeworkTableMap::COL_POSTTIME);
            $criteria->addSelectColumn(HomeworkTableMap::COL_NOTA);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.course_id');
            $criteria->addSelectColumn($alias . '.Materie');
            $criteria->addSelectColumn($alias . '.DueTime');
            $criteria->addSelectColumn($alias . '.Description');
            $criteria->addSelectColumn($alias . '.PostTime');
            $criteria->addSelectColumn($alias . '.Nota');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(HomeworkTableMap::DATABASE_NAME)->getTable(HomeworkTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(HomeworkTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(HomeworkTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new HomeworkTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Homework or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Homework object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(HomeworkTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \bdxe\Homework) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(HomeworkTableMap::DATABASE_NAME);
            $criteria->add(HomeworkTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = HomeworkQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            HomeworkTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                HomeworkTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the homework_tb table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return HomeworkQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Homework or Criteria object.
     *
     * @param mixed               $criteria Criteria or Homework object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(HomeworkTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Homework object
        }

        if ($criteria->containsKey(HomeworkTableMap::COL_ID) && $criteria->keyContainsValue(HomeworkTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.HomeworkTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = HomeworkQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // HomeworkTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
HomeworkTableMap::buildTableMap();
