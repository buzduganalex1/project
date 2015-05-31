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
use bdxe\HomeworkEval;
use bdxe\HomeworkEvalQuery;


/**
 * This class defines the structure of the 'homeworkeval_tb' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class HomeworkEvalTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'bdxe.Map.HomeworkEvalTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'homeworkeval_tb';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\bdxe\\HomeworkEval';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'bdxe.HomeworkEval';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 4;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 4;

    /**
     * the column name for the id field
     */
    const COL_ID = 'homeworkeval_tb.id';

    /**
     * the column name for the homework_id field
     */
    const COL_HOMEWORK_ID = 'homeworkeval_tb.homework_id';

    /**
     * the column name for the subscription_id field
     */
    const COL_SUBSCRIPTION_ID = 'homeworkeval_tb.subscription_id';

    /**
     * the column name for the Nota field
     */
    const COL_NOTA = 'homeworkeval_tb.Nota';

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
        self::TYPE_PHPNAME       => array('Id', 'HomeworkId', 'SubscriptionId', 'Nota', ),
        self::TYPE_CAMELNAME     => array('id', 'homeworkId', 'subscriptionId', 'nota', ),
        self::TYPE_COLNAME       => array(HomeworkEvalTableMap::COL_ID, HomeworkEvalTableMap::COL_HOMEWORK_ID, HomeworkEvalTableMap::COL_SUBSCRIPTION_ID, HomeworkEvalTableMap::COL_NOTA, ),
        self::TYPE_FIELDNAME     => array('id', 'homework_id', 'subscription_id', 'Nota', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'HomeworkId' => 1, 'SubscriptionId' => 2, 'Nota' => 3, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'homeworkId' => 1, 'subscriptionId' => 2, 'nota' => 3, ),
        self::TYPE_COLNAME       => array(HomeworkEvalTableMap::COL_ID => 0, HomeworkEvalTableMap::COL_HOMEWORK_ID => 1, HomeworkEvalTableMap::COL_SUBSCRIPTION_ID => 2, HomeworkEvalTableMap::COL_NOTA => 3, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'homework_id' => 1, 'subscription_id' => 2, 'Nota' => 3, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, )
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
        $this->setName('homeworkeval_tb');
        $this->setPhpName('HomeworkEval');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\bdxe\\HomeworkEval');
        $this->setPackage('bdxe');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('homeworkeval_tb_SEQ');
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('homework_id', 'HomeworkId', 'INTEGER', 'homework_tb', 'id', false, null, null);
        $this->addForeignKey('subscription_id', 'SubscriptionId', 'INTEGER', 'subscription_tb', 'id', false, null, null);
        $this->addColumn('Nota', 'Nota', 'INTEGER', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Homework', '\\bdxe\\Homework', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':homework_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Subscription', '\\bdxe\\Subscription', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':subscription_id',
    1 => ':id',
  ),
), null, null, null, false);
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
        return $withPrefix ? HomeworkEvalTableMap::CLASS_DEFAULT : HomeworkEvalTableMap::OM_CLASS;
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
     * @return array           (HomeworkEval object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = HomeworkEvalTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = HomeworkEvalTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + HomeworkEvalTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = HomeworkEvalTableMap::OM_CLASS;
            /** @var HomeworkEval $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            HomeworkEvalTableMap::addInstanceToPool($obj, $key);
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
            $key = HomeworkEvalTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = HomeworkEvalTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var HomeworkEval $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                HomeworkEvalTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(HomeworkEvalTableMap::COL_ID);
            $criteria->addSelectColumn(HomeworkEvalTableMap::COL_HOMEWORK_ID);
            $criteria->addSelectColumn(HomeworkEvalTableMap::COL_SUBSCRIPTION_ID);
            $criteria->addSelectColumn(HomeworkEvalTableMap::COL_NOTA);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.homework_id');
            $criteria->addSelectColumn($alias . '.subscription_id');
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
        return Propel::getServiceContainer()->getDatabaseMap(HomeworkEvalTableMap::DATABASE_NAME)->getTable(HomeworkEvalTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(HomeworkEvalTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(HomeworkEvalTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new HomeworkEvalTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a HomeworkEval or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or HomeworkEval object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(HomeworkEvalTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \bdxe\HomeworkEval) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(HomeworkEvalTableMap::DATABASE_NAME);
            $criteria->add(HomeworkEvalTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = HomeworkEvalQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            HomeworkEvalTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                HomeworkEvalTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the homeworkeval_tb table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return HomeworkEvalQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a HomeworkEval or Criteria object.
     *
     * @param mixed               $criteria Criteria or HomeworkEval object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(HomeworkEvalTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from HomeworkEval object
        }

        if ($criteria->containsKey(HomeworkEvalTableMap::COL_ID) && $criteria->keyContainsValue(HomeworkEvalTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.HomeworkEvalTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = HomeworkEvalQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // HomeworkEvalTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
HomeworkEvalTableMap::buildTableMap();
