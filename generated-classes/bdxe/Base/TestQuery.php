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
use bdxe\Test as ChildTest;
use bdxe\TestQuery as ChildTestQuery;
use bdxe\Map\TestTableMap;

/**
 * Base class that represents a query for the 'test_tb' table.
 *
 * 
 *
 * @method     ChildTestQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildTestQuery orderByCourseId($order = Criteria::ASC) Order by the course_id column
 * @method     ChildTestQuery orderByMaterie($order = Criteria::ASC) Order by the Materie column
 * @method     ChildTestQuery orderByDuetime($order = Criteria::ASC) Order by the DueTime column
 * @method     ChildTestQuery orderByPosttime($order = Criteria::ASC) Order by the PostTime column
 * @method     ChildTestQuery orderByNota($order = Criteria::ASC) Order by the Nota column
 *
 * @method     ChildTestQuery groupById() Group by the id column
 * @method     ChildTestQuery groupByCourseId() Group by the course_id column
 * @method     ChildTestQuery groupByMaterie() Group by the Materie column
 * @method     ChildTestQuery groupByDuetime() Group by the DueTime column
 * @method     ChildTestQuery groupByPosttime() Group by the PostTime column
 * @method     ChildTestQuery groupByNota() Group by the Nota column
 *
 * @method     ChildTestQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTestQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTestQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTestQuery leftJoinCourse($relationAlias = null) Adds a LEFT JOIN clause to the query using the Course relation
 * @method     ChildTestQuery rightJoinCourse($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Course relation
 * @method     ChildTestQuery innerJoinCourse($relationAlias = null) Adds a INNER JOIN clause to the query using the Course relation
 *
 * @method     ChildTestQuery leftJoinTestEval($relationAlias = null) Adds a LEFT JOIN clause to the query using the TestEval relation
 * @method     ChildTestQuery rightJoinTestEval($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TestEval relation
 * @method     ChildTestQuery innerJoinTestEval($relationAlias = null) Adds a INNER JOIN clause to the query using the TestEval relation
 *
 * @method     \bdxe\CourseQuery|\bdxe\TestEvalQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTest findOne(ConnectionInterface $con = null) Return the first ChildTest matching the query
 * @method     ChildTest findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTest matching the query, or a new ChildTest object populated from the query conditions when no match is found
 *
 * @method     ChildTest findOneById(int $id) Return the first ChildTest filtered by the id column
 * @method     ChildTest findOneByCourseId(int $course_id) Return the first ChildTest filtered by the course_id column
 * @method     ChildTest findOneByMaterie(string $Materie) Return the first ChildTest filtered by the Materie column
 * @method     ChildTest findOneByDuetime(string $DueTime) Return the first ChildTest filtered by the DueTime column
 * @method     ChildTest findOneByPosttime(string $PostTime) Return the first ChildTest filtered by the PostTime column
 * @method     ChildTest findOneByNota(int $Nota) Return the first ChildTest filtered by the Nota column *

 * @method     ChildTest requirePk($key, ConnectionInterface $con = null) Return the ChildTest by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTest requireOne(ConnectionInterface $con = null) Return the first ChildTest matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTest requireOneById(int $id) Return the first ChildTest filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTest requireOneByCourseId(int $course_id) Return the first ChildTest filtered by the course_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTest requireOneByMaterie(string $Materie) Return the first ChildTest filtered by the Materie column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTest requireOneByDuetime(string $DueTime) Return the first ChildTest filtered by the DueTime column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTest requireOneByPosttime(string $PostTime) Return the first ChildTest filtered by the PostTime column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTest requireOneByNota(int $Nota) Return the first ChildTest filtered by the Nota column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTest[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTest objects based on current ModelCriteria
 * @method     ChildTest[]|ObjectCollection findById(int $id) Return ChildTest objects filtered by the id column
 * @method     ChildTest[]|ObjectCollection findByCourseId(int $course_id) Return ChildTest objects filtered by the course_id column
 * @method     ChildTest[]|ObjectCollection findByMaterie(string $Materie) Return ChildTest objects filtered by the Materie column
 * @method     ChildTest[]|ObjectCollection findByDuetime(string $DueTime) Return ChildTest objects filtered by the DueTime column
 * @method     ChildTest[]|ObjectCollection findByPosttime(string $PostTime) Return ChildTest objects filtered by the PostTime column
 * @method     ChildTest[]|ObjectCollection findByNota(int $Nota) Return ChildTest objects filtered by the Nota column
 * @method     ChildTest[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TestQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \bdxe\Base\TestQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\bdxe\\Test', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTestQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTestQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTestQuery) {
            return $criteria;
        }
        $query = new ChildTestQuery();
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
     * @return ChildTest|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TestTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TestTableMap::DATABASE_NAME);
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
     * @return ChildTest A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, course_id, Materie, DueTime, PostTime, Nota FROM test_tb WHERE id = :p0';
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
            /** @var ChildTest $obj */
            $obj = new ChildTest();
            $obj->hydrate($row);
            TestTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildTest|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTestQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TestTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTestQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TestTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildTestQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TestTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TestTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TestTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the course_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCourseId(1234); // WHERE course_id = 1234
     * $query->filterByCourseId(array(12, 34)); // WHERE course_id IN (12, 34)
     * $query->filterByCourseId(array('min' => 12)); // WHERE course_id > 12
     * </code>
     *
     * @see       filterByCourse()
     *
     * @param     mixed $courseId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTestQuery The current query, for fluid interface
     */
    public function filterByCourseId($courseId = null, $comparison = null)
    {
        if (is_array($courseId)) {
            $useMinMax = false;
            if (isset($courseId['min'])) {
                $this->addUsingAlias(TestTableMap::COL_COURSE_ID, $courseId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($courseId['max'])) {
                $this->addUsingAlias(TestTableMap::COL_COURSE_ID, $courseId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TestTableMap::COL_COURSE_ID, $courseId, $comparison);
    }

    /**
     * Filter the query on the Materie column
     *
     * Example usage:
     * <code>
     * $query->filterByMaterie('fooValue');   // WHERE Materie = 'fooValue'
     * $query->filterByMaterie('%fooValue%'); // WHERE Materie LIKE '%fooValue%'
     * </code>
     *
     * @param     string $materie The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTestQuery The current query, for fluid interface
     */
    public function filterByMaterie($materie = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($materie)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $materie)) {
                $materie = str_replace('*', '%', $materie);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TestTableMap::COL_MATERIE, $materie, $comparison);
    }

    /**
     * Filter the query on the DueTime column
     *
     * Example usage:
     * <code>
     * $query->filterByDuetime('2011-03-14'); // WHERE DueTime = '2011-03-14'
     * $query->filterByDuetime('now'); // WHERE DueTime = '2011-03-14'
     * $query->filterByDuetime(array('max' => 'yesterday')); // WHERE DueTime > '2011-03-13'
     * </code>
     *
     * @param     mixed $duetime The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTestQuery The current query, for fluid interface
     */
    public function filterByDuetime($duetime = null, $comparison = null)
    {
        if (is_array($duetime)) {
            $useMinMax = false;
            if (isset($duetime['min'])) {
                $this->addUsingAlias(TestTableMap::COL_DUETIME, $duetime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($duetime['max'])) {
                $this->addUsingAlias(TestTableMap::COL_DUETIME, $duetime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TestTableMap::COL_DUETIME, $duetime, $comparison);
    }

    /**
     * Filter the query on the PostTime column
     *
     * Example usage:
     * <code>
     * $query->filterByPosttime('2011-03-14'); // WHERE PostTime = '2011-03-14'
     * $query->filterByPosttime('now'); // WHERE PostTime = '2011-03-14'
     * $query->filterByPosttime(array('max' => 'yesterday')); // WHERE PostTime > '2011-03-13'
     * </code>
     *
     * @param     mixed $posttime The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTestQuery The current query, for fluid interface
     */
    public function filterByPosttime($posttime = null, $comparison = null)
    {
        if (is_array($posttime)) {
            $useMinMax = false;
            if (isset($posttime['min'])) {
                $this->addUsingAlias(TestTableMap::COL_POSTTIME, $posttime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($posttime['max'])) {
                $this->addUsingAlias(TestTableMap::COL_POSTTIME, $posttime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TestTableMap::COL_POSTTIME, $posttime, $comparison);
    }

    /**
     * Filter the query on the Nota column
     *
     * Example usage:
     * <code>
     * $query->filterByNota(1234); // WHERE Nota = 1234
     * $query->filterByNota(array(12, 34)); // WHERE Nota IN (12, 34)
     * $query->filterByNota(array('min' => 12)); // WHERE Nota > 12
     * </code>
     *
     * @param     mixed $nota The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTestQuery The current query, for fluid interface
     */
    public function filterByNota($nota = null, $comparison = null)
    {
        if (is_array($nota)) {
            $useMinMax = false;
            if (isset($nota['min'])) {
                $this->addUsingAlias(TestTableMap::COL_NOTA, $nota['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($nota['max'])) {
                $this->addUsingAlias(TestTableMap::COL_NOTA, $nota['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TestTableMap::COL_NOTA, $nota, $comparison);
    }

    /**
     * Filter the query by a related \bdxe\Course object
     *
     * @param \bdxe\Course|ObjectCollection $course The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTestQuery The current query, for fluid interface
     */
    public function filterByCourse($course, $comparison = null)
    {
        if ($course instanceof \bdxe\Course) {
            return $this
                ->addUsingAlias(TestTableMap::COL_COURSE_ID, $course->getId(), $comparison);
        } elseif ($course instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TestTableMap::COL_COURSE_ID, $course->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCourse() only accepts arguments of type \bdxe\Course or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Course relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTestQuery The current query, for fluid interface
     */
    public function joinCourse($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Course');

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
            $this->addJoinObject($join, 'Course');
        }

        return $this;
    }

    /**
     * Use the Course relation Course object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \bdxe\CourseQuery A secondary query class using the current class as primary query
     */
    public function useCourseQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCourse($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Course', '\bdxe\CourseQuery');
    }

    /**
     * Filter the query by a related \bdxe\TestEval object
     *
     * @param \bdxe\TestEval|ObjectCollection $testEval the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTestQuery The current query, for fluid interface
     */
    public function filterByTestEval($testEval, $comparison = null)
    {
        if ($testEval instanceof \bdxe\TestEval) {
            return $this
                ->addUsingAlias(TestTableMap::COL_ID, $testEval->getTestId(), $comparison);
        } elseif ($testEval instanceof ObjectCollection) {
            return $this
                ->useTestEvalQuery()
                ->filterByPrimaryKeys($testEval->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTestEval() only accepts arguments of type \bdxe\TestEval or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TestEval relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTestQuery The current query, for fluid interface
     */
    public function joinTestEval($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TestEval');

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
            $this->addJoinObject($join, 'TestEval');
        }

        return $this;
    }

    /**
     * Use the TestEval relation TestEval object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \bdxe\TestEvalQuery A secondary query class using the current class as primary query
     */
    public function useTestEvalQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTestEval($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TestEval', '\bdxe\TestEvalQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTest $test Object to remove from the list of results
     *
     * @return $this|ChildTestQuery The current query, for fluid interface
     */
    public function prune($test = null)
    {
        if ($test) {
            $this->addUsingAlias(TestTableMap::COL_ID, $test->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the test_tb table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TestTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TestTableMap::clearInstancePool();
            TestTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TestTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TestTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            TestTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            TestTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TestQuery
