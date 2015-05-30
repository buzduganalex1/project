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
use bdxe\Course as ChildCourse;
use bdxe\CourseQuery as ChildCourseQuery;
use bdxe\Map\CourseTableMap;

/**
 * Base class that represents a query for the 'course_tb' table.
 *
 * 
 *
 * @method     ChildCourseQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCourseQuery orderByProfesorId($order = Criteria::ASC) Order by the profesor_id column
 * @method     ChildCourseQuery orderBySubjectId($order = Criteria::ASC) Order by the subject_id column
 * @method     ChildCourseQuery orderBySubjectName($order = Criteria::ASC) Order by the Subject_Name column
 * @method     ChildCourseQuery orderByClassCapacity($order = Criteria::ASC) Order by the Class_Capacity column
 * @method     ChildCourseQuery orderByInitialClassCapacity($order = Criteria::ASC) Order by the Initial_Class_Capacity column
 * @method     ChildCourseQuery orderByStartDate($order = Criteria::ASC) Order by the Start_Date column
 * @method     ChildCourseQuery orderByFinishDate($order = Criteria::ASC) Order by the Finish_Date column
 *
 * @method     ChildCourseQuery groupById() Group by the id column
 * @method     ChildCourseQuery groupByProfesorId() Group by the profesor_id column
 * @method     ChildCourseQuery groupBySubjectId() Group by the subject_id column
 * @method     ChildCourseQuery groupBySubjectName() Group by the Subject_Name column
 * @method     ChildCourseQuery groupByClassCapacity() Group by the Class_Capacity column
 * @method     ChildCourseQuery groupByInitialClassCapacity() Group by the Initial_Class_Capacity column
 * @method     ChildCourseQuery groupByStartDate() Group by the Start_Date column
 * @method     ChildCourseQuery groupByFinishDate() Group by the Finish_Date column
 *
 * @method     ChildCourseQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCourseQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCourseQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCourseQuery leftJoinProfesor($relationAlias = null) Adds a LEFT JOIN clause to the query using the Profesor relation
 * @method     ChildCourseQuery rightJoinProfesor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Profesor relation
 * @method     ChildCourseQuery innerJoinProfesor($relationAlias = null) Adds a INNER JOIN clause to the query using the Profesor relation
 *
 * @method     ChildCourseQuery leftJoinSubjectRelatedBySubjectId($relationAlias = null) Adds a LEFT JOIN clause to the query using the SubjectRelatedBySubjectId relation
 * @method     ChildCourseQuery rightJoinSubjectRelatedBySubjectId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SubjectRelatedBySubjectId relation
 * @method     ChildCourseQuery innerJoinSubjectRelatedBySubjectId($relationAlias = null) Adds a INNER JOIN clause to the query using the SubjectRelatedBySubjectId relation
 *
 * @method     ChildCourseQuery leftJoinSubscription($relationAlias = null) Adds a LEFT JOIN clause to the query using the Subscription relation
 * @method     ChildCourseQuery rightJoinSubscription($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Subscription relation
 * @method     ChildCourseQuery innerJoinSubscription($relationAlias = null) Adds a INNER JOIN clause to the query using the Subscription relation
 *
 * @method     ChildCourseQuery leftJoinHomework($relationAlias = null) Adds a LEFT JOIN clause to the query using the Homework relation
 * @method     ChildCourseQuery rightJoinHomework($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Homework relation
 * @method     ChildCourseQuery innerJoinHomework($relationAlias = null) Adds a INNER JOIN clause to the query using the Homework relation
 *
 * @method     ChildCourseQuery leftJoinTest($relationAlias = null) Adds a LEFT JOIN clause to the query using the Test relation
 * @method     ChildCourseQuery rightJoinTest($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Test relation
 * @method     ChildCourseQuery innerJoinTest($relationAlias = null) Adds a INNER JOIN clause to the query using the Test relation
 *
 * @method     ChildCourseQuery leftJoinProject($relationAlias = null) Adds a LEFT JOIN clause to the query using the Project relation
 * @method     ChildCourseQuery rightJoinProject($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Project relation
 * @method     ChildCourseQuery innerJoinProject($relationAlias = null) Adds a INNER JOIN clause to the query using the Project relation
 *
 * @method     ChildCourseQuery leftJoinSubjectRelatedByCourseId($relationAlias = null) Adds a LEFT JOIN clause to the query using the SubjectRelatedByCourseId relation
 * @method     ChildCourseQuery rightJoinSubjectRelatedByCourseId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SubjectRelatedByCourseId relation
 * @method     ChildCourseQuery innerJoinSubjectRelatedByCourseId($relationAlias = null) Adds a INNER JOIN clause to the query using the SubjectRelatedByCourseId relation
 *
 * @method     \bdxe\ProfesorQuery|\bdxe\SubjectQuery|\bdxe\SubscriptionQuery|\bdxe\HomeworkQuery|\bdxe\TestQuery|\bdxe\ProjectQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCourse findOne(ConnectionInterface $con = null) Return the first ChildCourse matching the query
 * @method     ChildCourse findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCourse matching the query, or a new ChildCourse object populated from the query conditions when no match is found
 *
 * @method     ChildCourse findOneById(int $id) Return the first ChildCourse filtered by the id column
 * @method     ChildCourse findOneByProfesorId(int $profesor_id) Return the first ChildCourse filtered by the profesor_id column
 * @method     ChildCourse findOneBySubjectId(int $subject_id) Return the first ChildCourse filtered by the subject_id column
 * @method     ChildCourse findOneBySubjectName(string $Subject_Name) Return the first ChildCourse filtered by the Subject_Name column
 * @method     ChildCourse findOneByClassCapacity(int $Class_Capacity) Return the first ChildCourse filtered by the Class_Capacity column
 * @method     ChildCourse findOneByInitialClassCapacity(int $Initial_Class_Capacity) Return the first ChildCourse filtered by the Initial_Class_Capacity column
 * @method     ChildCourse findOneByStartDate(string $Start_Date) Return the first ChildCourse filtered by the Start_Date column
 * @method     ChildCourse findOneByFinishDate(string $Finish_Date) Return the first ChildCourse filtered by the Finish_Date column *

 * @method     ChildCourse requirePk($key, ConnectionInterface $con = null) Return the ChildCourse by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCourse requireOne(ConnectionInterface $con = null) Return the first ChildCourse matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCourse requireOneById(int $id) Return the first ChildCourse filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCourse requireOneByProfesorId(int $profesor_id) Return the first ChildCourse filtered by the profesor_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCourse requireOneBySubjectId(int $subject_id) Return the first ChildCourse filtered by the subject_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCourse requireOneBySubjectName(string $Subject_Name) Return the first ChildCourse filtered by the Subject_Name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCourse requireOneByClassCapacity(int $Class_Capacity) Return the first ChildCourse filtered by the Class_Capacity column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCourse requireOneByInitialClassCapacity(int $Initial_Class_Capacity) Return the first ChildCourse filtered by the Initial_Class_Capacity column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCourse requireOneByStartDate(string $Start_Date) Return the first ChildCourse filtered by the Start_Date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCourse requireOneByFinishDate(string $Finish_Date) Return the first ChildCourse filtered by the Finish_Date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCourse[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCourse objects based on current ModelCriteria
 * @method     ChildCourse[]|ObjectCollection findById(int $id) Return ChildCourse objects filtered by the id column
 * @method     ChildCourse[]|ObjectCollection findByProfesorId(int $profesor_id) Return ChildCourse objects filtered by the profesor_id column
 * @method     ChildCourse[]|ObjectCollection findBySubjectId(int $subject_id) Return ChildCourse objects filtered by the subject_id column
 * @method     ChildCourse[]|ObjectCollection findBySubjectName(string $Subject_Name) Return ChildCourse objects filtered by the Subject_Name column
 * @method     ChildCourse[]|ObjectCollection findByClassCapacity(int $Class_Capacity) Return ChildCourse objects filtered by the Class_Capacity column
 * @method     ChildCourse[]|ObjectCollection findByInitialClassCapacity(int $Initial_Class_Capacity) Return ChildCourse objects filtered by the Initial_Class_Capacity column
 * @method     ChildCourse[]|ObjectCollection findByStartDate(string $Start_Date) Return ChildCourse objects filtered by the Start_Date column
 * @method     ChildCourse[]|ObjectCollection findByFinishDate(string $Finish_Date) Return ChildCourse objects filtered by the Finish_Date column
 * @method     ChildCourse[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CourseQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \bdxe\Base\CourseQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\bdxe\\Course', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCourseQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCourseQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCourseQuery) {
            return $criteria;
        }
        $query = new ChildCourseQuery();
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
     * @return ChildCourse|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CourseTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CourseTableMap::DATABASE_NAME);
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
     * @return ChildCourse A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, profesor_id, subject_id, Subject_Name, Class_Capacity, Initial_Class_Capacity, Start_Date, Finish_Date FROM course_tb WHERE id = :p0';
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
            /** @var ChildCourse $obj */
            $obj = new ChildCourse();
            $obj->hydrate($row);
            CourseTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildCourse|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCourseQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CourseTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCourseQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CourseTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildCourseQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CourseTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CourseTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CourseTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the profesor_id column
     *
     * Example usage:
     * <code>
     * $query->filterByProfesorId(1234); // WHERE profesor_id = 1234
     * $query->filterByProfesorId(array(12, 34)); // WHERE profesor_id IN (12, 34)
     * $query->filterByProfesorId(array('min' => 12)); // WHERE profesor_id > 12
     * </code>
     *
     * @see       filterByProfesor()
     *
     * @param     mixed $profesorId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCourseQuery The current query, for fluid interface
     */
    public function filterByProfesorId($profesorId = null, $comparison = null)
    {
        if (is_array($profesorId)) {
            $useMinMax = false;
            if (isset($profesorId['min'])) {
                $this->addUsingAlias(CourseTableMap::COL_PROFESOR_ID, $profesorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($profesorId['max'])) {
                $this->addUsingAlias(CourseTableMap::COL_PROFESOR_ID, $profesorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CourseTableMap::COL_PROFESOR_ID, $profesorId, $comparison);
    }

    /**
     * Filter the query on the subject_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySubjectId(1234); // WHERE subject_id = 1234
     * $query->filterBySubjectId(array(12, 34)); // WHERE subject_id IN (12, 34)
     * $query->filterBySubjectId(array('min' => 12)); // WHERE subject_id > 12
     * </code>
     *
     * @see       filterBySubjectRelatedBySubjectId()
     *
     * @param     mixed $subjectId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCourseQuery The current query, for fluid interface
     */
    public function filterBySubjectId($subjectId = null, $comparison = null)
    {
        if (is_array($subjectId)) {
            $useMinMax = false;
            if (isset($subjectId['min'])) {
                $this->addUsingAlias(CourseTableMap::COL_SUBJECT_ID, $subjectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($subjectId['max'])) {
                $this->addUsingAlias(CourseTableMap::COL_SUBJECT_ID, $subjectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CourseTableMap::COL_SUBJECT_ID, $subjectId, $comparison);
    }

    /**
     * Filter the query on the Subject_Name column
     *
     * Example usage:
     * <code>
     * $query->filterBySubjectName('fooValue');   // WHERE Subject_Name = 'fooValue'
     * $query->filterBySubjectName('%fooValue%'); // WHERE Subject_Name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $subjectName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCourseQuery The current query, for fluid interface
     */
    public function filterBySubjectName($subjectName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($subjectName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $subjectName)) {
                $subjectName = str_replace('*', '%', $subjectName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CourseTableMap::COL_SUBJECT_NAME, $subjectName, $comparison);
    }

    /**
     * Filter the query on the Class_Capacity column
     *
     * Example usage:
     * <code>
     * $query->filterByClassCapacity(1234); // WHERE Class_Capacity = 1234
     * $query->filterByClassCapacity(array(12, 34)); // WHERE Class_Capacity IN (12, 34)
     * $query->filterByClassCapacity(array('min' => 12)); // WHERE Class_Capacity > 12
     * </code>
     *
     * @param     mixed $classCapacity The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCourseQuery The current query, for fluid interface
     */
    public function filterByClassCapacity($classCapacity = null, $comparison = null)
    {
        if (is_array($classCapacity)) {
            $useMinMax = false;
            if (isset($classCapacity['min'])) {
                $this->addUsingAlias(CourseTableMap::COL_CLASS_CAPACITY, $classCapacity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($classCapacity['max'])) {
                $this->addUsingAlias(CourseTableMap::COL_CLASS_CAPACITY, $classCapacity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CourseTableMap::COL_CLASS_CAPACITY, $classCapacity, $comparison);
    }

    /**
     * Filter the query on the Initial_Class_Capacity column
     *
     * Example usage:
     * <code>
     * $query->filterByInitialClassCapacity(1234); // WHERE Initial_Class_Capacity = 1234
     * $query->filterByInitialClassCapacity(array(12, 34)); // WHERE Initial_Class_Capacity IN (12, 34)
     * $query->filterByInitialClassCapacity(array('min' => 12)); // WHERE Initial_Class_Capacity > 12
     * </code>
     *
     * @param     mixed $initialClassCapacity The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCourseQuery The current query, for fluid interface
     */
    public function filterByInitialClassCapacity($initialClassCapacity = null, $comparison = null)
    {
        if (is_array($initialClassCapacity)) {
            $useMinMax = false;
            if (isset($initialClassCapacity['min'])) {
                $this->addUsingAlias(CourseTableMap::COL_INITIAL_CLASS_CAPACITY, $initialClassCapacity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($initialClassCapacity['max'])) {
                $this->addUsingAlias(CourseTableMap::COL_INITIAL_CLASS_CAPACITY, $initialClassCapacity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CourseTableMap::COL_INITIAL_CLASS_CAPACITY, $initialClassCapacity, $comparison);
    }

    /**
     * Filter the query on the Start_Date column
     *
     * Example usage:
     * <code>
     * $query->filterByStartDate('2011-03-14'); // WHERE Start_Date = '2011-03-14'
     * $query->filterByStartDate('now'); // WHERE Start_Date = '2011-03-14'
     * $query->filterByStartDate(array('max' => 'yesterday')); // WHERE Start_Date > '2011-03-13'
     * </code>
     *
     * @param     mixed $startDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCourseQuery The current query, for fluid interface
     */
    public function filterByStartDate($startDate = null, $comparison = null)
    {
        if (is_array($startDate)) {
            $useMinMax = false;
            if (isset($startDate['min'])) {
                $this->addUsingAlias(CourseTableMap::COL_START_DATE, $startDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($startDate['max'])) {
                $this->addUsingAlias(CourseTableMap::COL_START_DATE, $startDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CourseTableMap::COL_START_DATE, $startDate, $comparison);
    }

    /**
     * Filter the query on the Finish_Date column
     *
     * Example usage:
     * <code>
     * $query->filterByFinishDate('2011-03-14'); // WHERE Finish_Date = '2011-03-14'
     * $query->filterByFinishDate('now'); // WHERE Finish_Date = '2011-03-14'
     * $query->filterByFinishDate(array('max' => 'yesterday')); // WHERE Finish_Date > '2011-03-13'
     * </code>
     *
     * @param     mixed $finishDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCourseQuery The current query, for fluid interface
     */
    public function filterByFinishDate($finishDate = null, $comparison = null)
    {
        if (is_array($finishDate)) {
            $useMinMax = false;
            if (isset($finishDate['min'])) {
                $this->addUsingAlias(CourseTableMap::COL_FINISH_DATE, $finishDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($finishDate['max'])) {
                $this->addUsingAlias(CourseTableMap::COL_FINISH_DATE, $finishDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CourseTableMap::COL_FINISH_DATE, $finishDate, $comparison);
    }

    /**
     * Filter the query by a related \bdxe\Profesor object
     *
     * @param \bdxe\Profesor|ObjectCollection $profesor The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCourseQuery The current query, for fluid interface
     */
    public function filterByProfesor($profesor, $comparison = null)
    {
        if ($profesor instanceof \bdxe\Profesor) {
            return $this
                ->addUsingAlias(CourseTableMap::COL_PROFESOR_ID, $profesor->getId(), $comparison);
        } elseif ($profesor instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CourseTableMap::COL_PROFESOR_ID, $profesor->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByProfesor() only accepts arguments of type \bdxe\Profesor or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Profesor relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCourseQuery The current query, for fluid interface
     */
    public function joinProfesor($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Profesor');

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
            $this->addJoinObject($join, 'Profesor');
        }

        return $this;
    }

    /**
     * Use the Profesor relation Profesor object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \bdxe\ProfesorQuery A secondary query class using the current class as primary query
     */
    public function useProfesorQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinProfesor($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Profesor', '\bdxe\ProfesorQuery');
    }

    /**
     * Filter the query by a related \bdxe\Subject object
     *
     * @param \bdxe\Subject|ObjectCollection $subject The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCourseQuery The current query, for fluid interface
     */
    public function filterBySubjectRelatedBySubjectId($subject, $comparison = null)
    {
        if ($subject instanceof \bdxe\Subject) {
            return $this
                ->addUsingAlias(CourseTableMap::COL_SUBJECT_ID, $subject->getId(), $comparison);
        } elseif ($subject instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CourseTableMap::COL_SUBJECT_ID, $subject->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBySubjectRelatedBySubjectId() only accepts arguments of type \bdxe\Subject or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SubjectRelatedBySubjectId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCourseQuery The current query, for fluid interface
     */
    public function joinSubjectRelatedBySubjectId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SubjectRelatedBySubjectId');

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
            $this->addJoinObject($join, 'SubjectRelatedBySubjectId');
        }

        return $this;
    }

    /**
     * Use the SubjectRelatedBySubjectId relation Subject object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \bdxe\SubjectQuery A secondary query class using the current class as primary query
     */
    public function useSubjectRelatedBySubjectIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSubjectRelatedBySubjectId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SubjectRelatedBySubjectId', '\bdxe\SubjectQuery');
    }

    /**
     * Filter the query by a related \bdxe\Subscription object
     *
     * @param \bdxe\Subscription|ObjectCollection $subscription the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCourseQuery The current query, for fluid interface
     */
    public function filterBySubscription($subscription, $comparison = null)
    {
        if ($subscription instanceof \bdxe\Subscription) {
            return $this
                ->addUsingAlias(CourseTableMap::COL_ID, $subscription->getCourseId(), $comparison);
        } elseif ($subscription instanceof ObjectCollection) {
            return $this
                ->useSubscriptionQuery()
                ->filterByPrimaryKeys($subscription->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildCourseQuery The current query, for fluid interface
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
     * Filter the query by a related \bdxe\Homework object
     *
     * @param \bdxe\Homework|ObjectCollection $homework the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCourseQuery The current query, for fluid interface
     */
    public function filterByHomework($homework, $comparison = null)
    {
        if ($homework instanceof \bdxe\Homework) {
            return $this
                ->addUsingAlias(CourseTableMap::COL_ID, $homework->getCourseId(), $comparison);
        } elseif ($homework instanceof ObjectCollection) {
            return $this
                ->useHomeworkQuery()
                ->filterByPrimaryKeys($homework->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildCourseQuery The current query, for fluid interface
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
     * Filter the query by a related \bdxe\Test object
     *
     * @param \bdxe\Test|ObjectCollection $test the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCourseQuery The current query, for fluid interface
     */
    public function filterByTest($test, $comparison = null)
    {
        if ($test instanceof \bdxe\Test) {
            return $this
                ->addUsingAlias(CourseTableMap::COL_ID, $test->getCourseId(), $comparison);
        } elseif ($test instanceof ObjectCollection) {
            return $this
                ->useTestQuery()
                ->filterByPrimaryKeys($test->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildCourseQuery The current query, for fluid interface
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
     * Filter the query by a related \bdxe\Project object
     *
     * @param \bdxe\Project|ObjectCollection $project the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCourseQuery The current query, for fluid interface
     */
    public function filterByProject($project, $comparison = null)
    {
        if ($project instanceof \bdxe\Project) {
            return $this
                ->addUsingAlias(CourseTableMap::COL_ID, $project->getCourseId(), $comparison);
        } elseif ($project instanceof ObjectCollection) {
            return $this
                ->useProjectQuery()
                ->filterByPrimaryKeys($project->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProject() only accepts arguments of type \bdxe\Project or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Project relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCourseQuery The current query, for fluid interface
     */
    public function joinProject($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Project');

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
            $this->addJoinObject($join, 'Project');
        }

        return $this;
    }

    /**
     * Use the Project relation Project object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \bdxe\ProjectQuery A secondary query class using the current class as primary query
     */
    public function useProjectQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinProject($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Project', '\bdxe\ProjectQuery');
    }

    /**
     * Filter the query by a related \bdxe\Subject object
     *
     * @param \bdxe\Subject|ObjectCollection $subject the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCourseQuery The current query, for fluid interface
     */
    public function filterBySubjectRelatedByCourseId($subject, $comparison = null)
    {
        if ($subject instanceof \bdxe\Subject) {
            return $this
                ->addUsingAlias(CourseTableMap::COL_ID, $subject->getCourseId(), $comparison);
        } elseif ($subject instanceof ObjectCollection) {
            return $this
                ->useSubjectRelatedByCourseIdQuery()
                ->filterByPrimaryKeys($subject->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySubjectRelatedByCourseId() only accepts arguments of type \bdxe\Subject or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SubjectRelatedByCourseId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCourseQuery The current query, for fluid interface
     */
    public function joinSubjectRelatedByCourseId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SubjectRelatedByCourseId');

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
            $this->addJoinObject($join, 'SubjectRelatedByCourseId');
        }

        return $this;
    }

    /**
     * Use the SubjectRelatedByCourseId relation Subject object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \bdxe\SubjectQuery A secondary query class using the current class as primary query
     */
    public function useSubjectRelatedByCourseIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSubjectRelatedByCourseId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SubjectRelatedByCourseId', '\bdxe\SubjectQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCourse $course Object to remove from the list of results
     *
     * @return $this|ChildCourseQuery The current query, for fluid interface
     */
    public function prune($course = null)
    {
        if ($course) {
            $this->addUsingAlias(CourseTableMap::COL_ID, $course->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the course_tb table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CourseTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CourseTableMap::clearInstancePool();
            CourseTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CourseTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CourseTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            CourseTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            CourseTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CourseQuery
