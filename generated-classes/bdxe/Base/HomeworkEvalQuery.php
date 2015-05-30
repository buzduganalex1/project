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
use bdxe\HomeworkEval as ChildHomeworkEval;
use bdxe\HomeworkEvalQuery as ChildHomeworkEvalQuery;
use bdxe\Map\HomeworkEvalTableMap;

/**
 * Base class that represents a query for the 'homeworkeval_tb' table.
 *
 * 
 *
 * @method     ChildHomeworkEvalQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildHomeworkEvalQuery orderByHomeworkId($order = Criteria::ASC) Order by the homework_id column
 * @method     ChildHomeworkEvalQuery orderBySubscriptionId($order = Criteria::ASC) Order by the subscription_id column
 *
 * @method     ChildHomeworkEvalQuery groupById() Group by the id column
 * @method     ChildHomeworkEvalQuery groupByHomeworkId() Group by the homework_id column
 * @method     ChildHomeworkEvalQuery groupBySubscriptionId() Group by the subscription_id column
 *
 * @method     ChildHomeworkEvalQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildHomeworkEvalQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildHomeworkEvalQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildHomeworkEvalQuery leftJoinHomework($relationAlias = null) Adds a LEFT JOIN clause to the query using the Homework relation
 * @method     ChildHomeworkEvalQuery rightJoinHomework($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Homework relation
 * @method     ChildHomeworkEvalQuery innerJoinHomework($relationAlias = null) Adds a INNER JOIN clause to the query using the Homework relation
 *
 * @method     ChildHomeworkEvalQuery leftJoinSubscription($relationAlias = null) Adds a LEFT JOIN clause to the query using the Subscription relation
 * @method     ChildHomeworkEvalQuery rightJoinSubscription($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Subscription relation
 * @method     ChildHomeworkEvalQuery innerJoinSubscription($relationAlias = null) Adds a INNER JOIN clause to the query using the Subscription relation
 *
 * @method     \bdxe\HomeworkQuery|\bdxe\SubscriptionQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildHomeworkEval findOne(ConnectionInterface $con = null) Return the first ChildHomeworkEval matching the query
 * @method     ChildHomeworkEval findOneOrCreate(ConnectionInterface $con = null) Return the first ChildHomeworkEval matching the query, or a new ChildHomeworkEval object populated from the query conditions when no match is found
 *
 * @method     ChildHomeworkEval findOneById(int $id) Return the first ChildHomeworkEval filtered by the id column
 * @method     ChildHomeworkEval findOneByHomeworkId(int $homework_id) Return the first ChildHomeworkEval filtered by the homework_id column
 * @method     ChildHomeworkEval findOneBySubscriptionId(int $subscription_id) Return the first ChildHomeworkEval filtered by the subscription_id column *

 * @method     ChildHomeworkEval requirePk($key, ConnectionInterface $con = null) Return the ChildHomeworkEval by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHomeworkEval requireOne(ConnectionInterface $con = null) Return the first ChildHomeworkEval matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildHomeworkEval requireOneById(int $id) Return the first ChildHomeworkEval filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHomeworkEval requireOneByHomeworkId(int $homework_id) Return the first ChildHomeworkEval filtered by the homework_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHomeworkEval requireOneBySubscriptionId(int $subscription_id) Return the first ChildHomeworkEval filtered by the subscription_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildHomeworkEval[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildHomeworkEval objects based on current ModelCriteria
 * @method     ChildHomeworkEval[]|ObjectCollection findById(int $id) Return ChildHomeworkEval objects filtered by the id column
 * @method     ChildHomeworkEval[]|ObjectCollection findByHomeworkId(int $homework_id) Return ChildHomeworkEval objects filtered by the homework_id column
 * @method     ChildHomeworkEval[]|ObjectCollection findBySubscriptionId(int $subscription_id) Return ChildHomeworkEval objects filtered by the subscription_id column
 * @method     ChildHomeworkEval[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class HomeworkEvalQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \bdxe\Base\HomeworkEvalQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\bdxe\\HomeworkEval', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildHomeworkEvalQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildHomeworkEvalQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildHomeworkEvalQuery) {
            return $criteria;
        }
        $query = new ChildHomeworkEvalQuery();
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
     * @return ChildHomeworkEval|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = HomeworkEvalTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(HomeworkEvalTableMap::DATABASE_NAME);
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
     * @return ChildHomeworkEval A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, homework_id, subscription_id FROM homeworkeval_tb WHERE id = :p0';
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
            /** @var ChildHomeworkEval $obj */
            $obj = new ChildHomeworkEval();
            $obj->hydrate($row);
            HomeworkEvalTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildHomeworkEval|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildHomeworkEvalQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(HomeworkEvalTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildHomeworkEvalQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(HomeworkEvalTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildHomeworkEvalQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(HomeworkEvalTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(HomeworkEvalTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HomeworkEvalTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the homework_id column
     *
     * Example usage:
     * <code>
     * $query->filterByHomeworkId(1234); // WHERE homework_id = 1234
     * $query->filterByHomeworkId(array(12, 34)); // WHERE homework_id IN (12, 34)
     * $query->filterByHomeworkId(array('min' => 12)); // WHERE homework_id > 12
     * </code>
     *
     * @see       filterByHomework()
     *
     * @param     mixed $homeworkId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildHomeworkEvalQuery The current query, for fluid interface
     */
    public function filterByHomeworkId($homeworkId = null, $comparison = null)
    {
        if (is_array($homeworkId)) {
            $useMinMax = false;
            if (isset($homeworkId['min'])) {
                $this->addUsingAlias(HomeworkEvalTableMap::COL_HOMEWORK_ID, $homeworkId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($homeworkId['max'])) {
                $this->addUsingAlias(HomeworkEvalTableMap::COL_HOMEWORK_ID, $homeworkId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HomeworkEvalTableMap::COL_HOMEWORK_ID, $homeworkId, $comparison);
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
     * @return $this|ChildHomeworkEvalQuery The current query, for fluid interface
     */
    public function filterBySubscriptionId($subscriptionId = null, $comparison = null)
    {
        if (is_array($subscriptionId)) {
            $useMinMax = false;
            if (isset($subscriptionId['min'])) {
                $this->addUsingAlias(HomeworkEvalTableMap::COL_SUBSCRIPTION_ID, $subscriptionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($subscriptionId['max'])) {
                $this->addUsingAlias(HomeworkEvalTableMap::COL_SUBSCRIPTION_ID, $subscriptionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HomeworkEvalTableMap::COL_SUBSCRIPTION_ID, $subscriptionId, $comparison);
    }

    /**
     * Filter the query by a related \bdxe\Homework object
     *
     * @param \bdxe\Homework|ObjectCollection $homework The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildHomeworkEvalQuery The current query, for fluid interface
     */
    public function filterByHomework($homework, $comparison = null)
    {
        if ($homework instanceof \bdxe\Homework) {
            return $this
                ->addUsingAlias(HomeworkEvalTableMap::COL_HOMEWORK_ID, $homework->getId(), $comparison);
        } elseif ($homework instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(HomeworkEvalTableMap::COL_HOMEWORK_ID, $homework->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByHomework() only accepts arguments of type \bdxe\Homework or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Homework relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildHomeworkEvalQuery The current query, for fluid interface
     */
    public function joinHomework($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Homework');

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
            $this->addJoinObject($join, 'Homework');
        }

        return $this;
    }

    /**
     * Use the Homework relation Homework object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \bdxe\HomeworkQuery A secondary query class using the current class as primary query
     */
    public function useHomeworkQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinHomework($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Homework', '\bdxe\HomeworkQuery');
    }

    /**
     * Filter the query by a related \bdxe\Subscription object
     *
     * @param \bdxe\Subscription|ObjectCollection $subscription The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildHomeworkEvalQuery The current query, for fluid interface
     */
    public function filterBySubscription($subscription, $comparison = null)
    {
        if ($subscription instanceof \bdxe\Subscription) {
            return $this
                ->addUsingAlias(HomeworkEvalTableMap::COL_SUBSCRIPTION_ID, $subscription->getId(), $comparison);
        } elseif ($subscription instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(HomeworkEvalTableMap::COL_SUBSCRIPTION_ID, $subscription->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildHomeworkEvalQuery The current query, for fluid interface
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
     * @param   ChildHomeworkEval $homeworkEval Object to remove from the list of results
     *
     * @return $this|ChildHomeworkEvalQuery The current query, for fluid interface
     */
    public function prune($homeworkEval = null)
    {
        if ($homeworkEval) {
            $this->addUsingAlias(HomeworkEvalTableMap::COL_ID, $homeworkEval->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the homeworkeval_tb table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(HomeworkEvalTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            HomeworkEvalTableMap::clearInstancePool();
            HomeworkEvalTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(HomeworkEvalTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(HomeworkEvalTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            HomeworkEvalTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            HomeworkEvalTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // HomeworkEvalQuery
