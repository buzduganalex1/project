<?php

namespace bdxe\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use bdxe\TestEval as ChildTestEval;
use bdxe\TestEvalQuery as ChildTestEvalQuery;
use bdxe\Map\TestEvalTableMap;

/**
 * Base class that represents a query for the 'testeval_tb' table.
 *
 * 
 *
 * @method     ChildTestEvalQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildTestEvalQuery orderByTestId($order = Criteria::ASC) Order by the test_id column
 * @method     ChildTestEvalQuery orderBySubscriptionId($order = Criteria::ASC) Order by the subscription_id column
 *
 * @method     ChildTestEvalQuery groupById() Group by the id column
 * @method     ChildTestEvalQuery groupByTestId() Group by the test_id column
 * @method     ChildTestEvalQuery groupBySubscriptionId() Group by the subscription_id column
 *
 * @method     ChildTestEvalQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTestEvalQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTestEvalQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTestEvalQuery leftJoinTest($relationAlias = null) Adds a LEFT JOIN clause to the query using the Test relation
 * @method     ChildTestEvalQuery rightJoinTest($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Test relation
 * @method     ChildTestEvalQuery innerJoinTest($relationAlias = null) Adds a INNER JOIN clause to the query using the Test relation
 *
 * @method     ChildTestEvalQuery leftJoinSubscription($relationAlias = null) Adds a LEFT JOIN clause to the query using the Subscription relation
 * @method     ChildTestEvalQuery rightJoinSubscription($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Subscription relation
 * @method     ChildTestEvalQuery innerJoinSubscription($relationAlias = null) Adds a INNER JOIN clause to the query using the Subscription relation
 *
 * @method     \bdxe\TestQuery|\bdxe\SubscriptionQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTestEval findOne(ConnectionInterface $con = null) Return the first ChildTestEval matching the query
 * @method     ChildTestEval findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTestEval matching the query, or a new ChildTestEval object populated from the query conditions when no match is found
 *
 * @method     ChildTestEval findOneById(int $id) Return the first ChildTestEval filtered by the id column
 * @method     ChildTestEval findOneByTestId(int $test_id) Return the first ChildTestEval filtered by the test_id column
 * @method     ChildTestEval findOneBySubscriptionId(int $subscription_id) Return the first ChildTestEval filtered by the subscription_id column *

 * @method     ChildTestEval requirePk($key, ConnectionInterface $con = null) Return the ChildTestEval by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTestEval requireOne(ConnectionInterface $con = null) Return the first ChildTestEval matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTestEval requireOneById(int $id) Return the first ChildTestEval filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTestEval requireOneByTestId(int $test_id) Return the first ChildTestEval filtered by the test_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTestEval requireOneBySubscriptionId(int $subscription_id) Return the first ChildTestEval filtered by the subscription_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTestEval[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTestEval objects based on current ModelCriteria
 * @method     ChildTestEval[]|ObjectCollection findById(int $id) Return ChildTestEval objects filtered by the id column
 * @method     ChildTestEval[]|ObjectCollection findByTestId(int $test_id) Return ChildTestEval objects filtered by the test_id column
 * @method     ChildTestEval[]|ObjectCollection findBySubscriptionId(int $subscription_id) Return ChildTestEval objects filtered by the subscription_id column
 * @method     ChildTestEval[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TestEvalQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \bdxe\Base\TestEvalQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\bdxe\\TestEval', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTestEvalQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTestEvalQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTestEvalQuery) {
            return $criteria;
        }
        $query = new ChildTestEvalQuery();
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
     * @return ChildTestEval|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TestEvalTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TestEvalTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
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
     * @return ChildTestEval A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, test_id, subscription_id FROM testeval_tb WHERE id = :p0';
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
            /** @var ChildTestEval $obj */
            $obj = new ChildTestEval();
            $obj->hydrate($row);
            TestEvalTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildTestEval|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTestEvalQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TestEvalTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTestEvalQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TestEvalTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTestEvalQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TestEvalTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TestEvalTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TestEvalTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the test_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTestId(1234); // WHERE test_id = 1234
     * $query->filterByTestId(array(12, 34)); // WHERE test_id IN (12, 34)
     * $query->filterByTestId(array('min' => 12)); // WHERE test_id > 12
     * </code>
     *
     * @see       filterByTest()
     *
     * @param     mixed $testId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTestEvalQuery The current query, for fluid interface
     */
    public function filterByTestId($testId = null, $comparison = null)
    {
        if (is_array($testId)) {
            $useMinMax = false;
            if (isset($testId['min'])) {
                $this->addUsingAlias(TestEvalTableMap::COL_TEST_ID, $testId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($testId['max'])) {
                $this->addUsingAlias(TestEvalTableMap::COL_TEST_ID, $testId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TestEvalTableMap::COL_TEST_ID, $testId, $comparison);
    }

    /**
     * Filter the query on the subscription_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySubscriptionId(1234); // WHERE subscription_id = 1234
     * $query->filterBySubscriptionId(array(12, 34)); // WHERE subscription_id IN (12, 34)
     * $query->filterBySubscriptionId(array('min' => 12)); // WHERE subscription_id > 12
     * </code>
     *
     * @see       filterBySubscription()
     *
     * @param     mixed $subscriptionId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTestEvalQuery The current query, for fluid interface
     */
    public function filterBySubscriptionId($subscriptionId = null, $comparison = null)
    {
        if (is_array($subscriptionId)) {
            $useMinMax = false;
            if (isset($subscriptionId['min'])) {
                $this->addUsingAlias(TestEvalTableMap::COL_SUBSCRIPTION_ID, $subscriptionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($subscriptionId['max'])) {
                $this->addUsingAlias(TestEvalTableMap::COL_SUBSCRIPTION_ID, $subscriptionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TestEvalTableMap::COL_SUBSCRIPTION_ID, $subscriptionId, $comparison);
    }

    /**
     * Filter the query by a related \bdxe\Test object
     *
     * @param \bdxe\Test|ObjectCollection $test The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTestEvalQuery The current query, for fluid interface
     */
    public function filterByTest($test, $comparison = null)
    {
        if ($test instanceof \bdxe\Test) {
            return $this
                ->addUsingAlias(TestEvalTableMap::COL_TEST_ID, $test->getId(), $comparison);
        } elseif ($test instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TestEvalTableMap::COL_TEST_ID, $test->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByTest() only accepts arguments of type \bdxe\Test or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Test relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTestEvalQuery The current query, for fluid interface
     */
    public function joinTest($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Test');

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
            $this->addJoinObject($join, 'Test');
        }

        return $this;
    }

    /**
     * Use the Test relation Test object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \bdxe\TestQuery A secondary query class using the current class as primary query
     */
    public function useTestQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTest($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Test', '\bdxe\TestQuery');
    }

    /**
     * Filter the query by a related \bdxe\Subscription object
     *
     * @param \bdxe\Subscription|ObjectCollection $subscription The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTestEvalQuery The current query, for fluid interface
     */
    public function filterBySubscription($subscription, $comparison = null)
    {
        if ($subscription instanceof \bdxe\Subscription) {
            return $this
                ->addUsingAlias(TestEvalTableMap::COL_SUBSCRIPTION_ID, $subscription->getId(), $comparison);
        } elseif ($subscription instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TestEvalTableMap::COL_SUBSCRIPTION_ID, $subscription->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBySubscription() only accepts arguments of type \bdxe\Subscription or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Subscription relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTestEvalQuery The current query, for fluid interface
     */
    public function joinSubscription($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Subscription');

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
            $this->addJoinObject($join, 'Subscription');
        }

        return $this;
    }

    /**
     * Use the Subscription relation Subscription object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \bdxe\SubscriptionQuery A secondary query class using the current class as primary query
     */
    public function useSubscriptionQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSubscription($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Subscription', '\bdxe\SubscriptionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTestEval $testEval Object to remove from the list of results
     *
     * @return $this|ChildTestEvalQuery The current query, for fluid interface
     */
    public function prune($testEval = null)
    {
        if ($testEval) {
            $this->addUsingAlias(TestEvalTableMap::COL_ID, $testEval->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the testeval_tb table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TestEvalTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TestEvalTableMap::clearInstancePool();
            TestEvalTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TestEvalTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TestEvalTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            TestEvalTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            TestEvalTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TestEvalQuery
