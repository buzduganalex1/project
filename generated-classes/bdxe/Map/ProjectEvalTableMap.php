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
use bdxe\ProjectEval;
use bdxe\ProjectEvalQuery;


/**
 * This class defines the structure of the 'projecteval_tb' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ProjectEvalTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'bdxe.Map.ProjectEvalTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'projecteval_tb';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\bdxe\\ProjectEval';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'bdxe.ProjectEval';

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
    const COL_ID = 'projecteval_tb.id';

    /**
     * the column name for the project_id field
     */
    const COL_PROJECT_ID = 'projecteval_tb.project_id';

    /**
     * the column name for the subscription_id field
     */
    const COL_SUBSCRIPTION_ID = 'projecteval_tb.subscription_id';

    /**
     * the column name for the Nota field
     */
    const COL_NOTA = 'projecteval_tb.Nota';

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
        self::TYPE_PHPNAME       => array('Id', 'ProjectId', 'SubscriptionId', 'Nota', ),
        self::TYPE_CAMELNAME     => array('id', 'projectId', 'subscriptionId', 'nota', ),
        self::TYPE_COLNAME       => array(ProjectEvalTableMap::COL_ID, ProjectEvalTableMap::COL_PROJECT_ID, ProjectEvalTableMap::COL_SUBSCRIPTION_ID, ProjectEvalTableMap::COL_NOTA, ),
        self::TYPE_FIELDNAME     => array('id', 'project_id', 'subscription_id', 'Nota', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'ProjectId' => 1, 'SubscriptionId' => 2, 'Nota' => 3, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'projectId' => 1, 'subscriptionId' => 2, 'nota' => 3, ),
        self::TYPE_COLNAME       => array(ProjectEvalTableMap::COL_ID => 0, ProjectEvalTableMap::COL_PROJECT_ID => 1, ProjectEvalTableMap::COL_SUBSCRIPTION_ID => 2, ProjectEvalTableMap::COL_NOTA => 3, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'project_id' => 1, 'subscription_id' => 2, 'Nota' => 3, ),
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
        $this->setName('projecteval_tb');
        $this->setPhpName('ProjectEval');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\bdxe\\ProjectEval');
        $this->setPackage('bdxe');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('projecteval_tb_SEQ');
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('project_id', 'ProjectId', 'INTEGER', 'project_tb', 'id', false, null, null);
        $this->addForeignKey('subscription_id', 'SubscriptionId', 'INTEGER', 'subscription_tb', 'id', false, null, null);
        $this->addColumn('Nota', 'Nota', 'INTEGER', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Project', '\\bdxe\\Project', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':project_id',
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
        return $withPrefix ? ProjectEvalTableMap::CLASS_DEFAULT : ProjectEvalTableMap::OM_CLASS;
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
     * @return array           (ProjectEval object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ProjectEvalTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ProjectEvalTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ProjectEvalTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ProjectEvalTableMap::OM_CLASS;
            /** @var ProjectEval $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ProjectEvalTableMap::addInstanceToPool($obj, $key);
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
            $key = ProjectEvalTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ProjectEvalTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var ProjectEval $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ProjectEvalTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ProjectEvalTableMap::COL_ID);
            $criteria->addSelectColumn(ProjectEvalTableMap::COL_PROJECT_ID);
            $criteria->addSelectColumn(ProjectEvalTableMap::COL_SUBSCRIPTION_ID);
            $criteria->addSelectColumn(ProjectEvalTableMap::COL_NOTA);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.project_id');
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
        return Propel::getServiceContainer()->getDatabaseMap(ProjectEvalTableMap::DATABASE_NAME)->getTable(ProjectEvalTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ProjectEvalTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ProjectEvalTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ProjectEvalTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a ProjectEval or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ProjectEval object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ProjectEvalTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \bdxe\ProjectEval) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ProjectEvalTableMap::DATABASE_NAME);
            $criteria->add(ProjectEvalTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = ProjectEvalQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ProjectEvalTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ProjectEvalTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the projecteval_tb table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ProjectEvalQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a ProjectEval or Criteria object.
     *
     * @param mixed               $criteria Criteria or ProjectEval object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProjectEvalTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from ProjectEval object
        }

        if ($criteria->containsKey(ProjectEvalTableMap::COL_ID) && $criteria->keyContainsValue(ProjectEvalTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ProjectEvalTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = ProjectEvalQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ProjectEvalTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ProjectEvalTableMap::buildTableMap();
