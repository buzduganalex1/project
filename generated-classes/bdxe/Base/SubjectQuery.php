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
use bdxe\Subject as ChildSubject;
use bdxe\SubjectQuery as ChildSubjectQuery;
use bdxe\Map\SubjectTableMap;

/**
 * Base class that represents a query for the 'subject_tb' table.
 *
 * 
 *
 * @method     ChildSubjectQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSubjectQuery orderByStudentId($order = Criteria::ASC) Order by the student_id column
 * @method     ChildSubjectQuery orderByCourseId($order = Criteria::ASC) Order by the course_id column
 *
 * @method     ChildSubjectQuery groupById() Group by the id column
 * @method     ChildSubjectQuery groupByStudentId() Group by the student_id column
 * @method     ChildSubjectQuery groupByCourseId() Group by the course_id column
 *
 * @method     ChildSubjectQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSubjectQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSubjectQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSubjectQuery leftJoinStudent($relationAlias = null) Adds a LEFT JOIN clause to the query using the Student relation
 * @method     ChildSubjectQuery rightJoinStudent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Student relation
 * @method     ChildSubjectQuery innerJoinStudent($relationAlias = null) Adds a INNER JOIN clause to the query using the Student relation
 *
 * @method     ChildSubjectQuery leftJoinCourseRelatedByCourseId($relationAlias = null) Adds a LEFT JOIN clause to the query using the CourseRelatedByCourseId relation
 * @method     ChildSubjectQuery rightJoinCourseRelatedByCourseId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CourseRelatedByCourseId relation
 * @method     ChildSubjectQuery innerJoinCourseRelatedByCourseId($relationAlias = null) Adds a INNER JOIN clause to the query using the CourseRelatedByCourseId relation
 *
 * @method     ChildSubjectQuery leftJoinCourseRelatedBySubjectId($relationAlias = null) Adds a LEFT JOIN clause to the query using the CourseRelatedBySubjectId relation
 * @method     ChildSubjectQuery rightJoinCourseRelatedBySubjectId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CourseRelatedBySubjectId relation
 * @method     ChildSubjectQuery innerJoinCourseRelatedBySubjectId($relationAlias = null) Adds a INNER JOIN clause to the query using the CourseRelatedBySubjectId relation
 *
 * @method     \bdxe\StudentQuery|\bdxe\CourseQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSubject findOne(ConnectionInterface $con = null) Return the first ChildSubject matching the query
 * @method     ChildSubject findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSubject matching the query, or a new ChildSubject object populated from the query conditions when no match is found
 *
 * @method     ChildSubject findOneById(int $id) Return the first ChildSubject filtered by the id column
 * @method     ChildSubject findOneByStudentId(int $student_id) Return the first ChildSubject filtered by the student_id column
 * @method     ChildSubject findOneByCourseId(int $course_id) Return the first ChildSubject filtered by the course_id column *

 * @method     ChildSubject requirePk($key, ConnectionInterface $con = null) Return the ChildSubject by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSubject requireOne(ConnectionInterface $con = null) Return the first ChildSubject matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSubject requireOneById(int $id) Return the first ChildSubject filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSubject requireOneByStudentId(int $student_id) Return the first ChildSubject filtered by the student_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSubject requireOneByCourseId(int $course_id) Return the first ChildSubject filtered by the course_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSubject[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSubject objects based on current ModelCriteria
 * @method     ChildSubject[]|ObjectCollection findById(int $id) Return ChildSubject objects filtered by the id column
 * @method     ChildSubject[]|ObjectCollection findByStudentId(int $student_id) Return ChildSubject objects filtered by the student_id column
 * @method     ChildSubject[]|ObjectCollection findByCourseId(int $course_id) Return ChildSubject objects filtered by the course_id column
 * @method     ChildSubject[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SubjectQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \bdxe\Base\SubjectQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\bdxe\\Subject', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSubjectQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSubjectQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSubjectQuery) {
            return $criteria;
        }
        $query = new ChildSubjectQuery();
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
     * @return ChildSubject|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SubjectTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SubjectTableMap::DATABASE_NAME);
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
     * @return ChildSubject A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, student_id, course_id FROM subject_tb WHERE id = :p0';
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
            /** @var ChildSubject $obj */
            $obj = new ChildSubject();
            $obj->hydrate($row);
            SubjectTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSubject|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSubjectQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SubjectTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSubjectQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SubjectTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSubjectQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SubjectTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SubjectTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SubjectTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the student_id column
     *
     * Example usage:
     * <code>
     * $query->filterByStudentId(1234); // WHERE student_id = 1234
     * $query->filterByStudentId(array(12, 34)); // WHERE student_id IN (12, 34)
     * $query->filterByStudentId(array('min' => 12)); // WHERE student_id > 12
     * </code>
     *
     * @see       filterByStudent()
     *
     * @param     mixed $studentId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSubjectQuery The current query, for fluid interface
     */
    public function filterByStudentId($studentId = null, $comparison = null)
    {
        if (is_array($studentId)) {
            $useMinMax = false;
            if (isset($studentId['min'])) {
                $this->addUsingAlias(SubjectTableMap::COL_STUDENT_ID, $studentId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($studentId['max'])) {
                $this->addUsingAlias(SubjectTableMap::COL_STUDENT_ID, $studentId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SubjectTableMap::COL_STUDENT_ID, $studentId, $comparison);
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
     * @see       filterByCourseRelatedByCourseId()
     *
     * @param     mixed $courseId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSubjectQuery The current query, for fluid interface
     */
    public function filterByCourseId($courseId = null, $comparison = null)
    {
        if (is_array($courseId)) {
            $useMinMax = false;
            if (isset($courseId['min'])) {
                $this->addUsingAlias(SubjectTableMap::COL_COURSE_ID, $courseId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($courseId['max'])) {
                $this->addUsingAlias(SubjectTableMap::COL_COURSE_ID, $courseId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SubjectTableMap::COL_COURSE_ID, $courseId, $comparison);
    }

    /**
     * Filter the query by a related \bdxe\Student object
     *
     * @param \bdxe\Student|ObjectCollection $student The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSubjectQuery The current query, for fluid interface
     */
    public function filterByStudent($student, $comparison = null)
    {
        if ($student instanceof \bdxe\Student) {
            return $this
                ->addUsingAlias(SubjectTableMap::COL_STUDENT_ID, $student->getId(), $comparison);
        } elseif ($student instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SubjectTableMap::COL_STUDENT_ID, $student->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByStudent() only accepts arguments of type \bdxe\Student or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Student relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSubjectQuery The current query, for fluid interface
     */
    public function joinStudent($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Student');

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
            $this->addJoinObject($join, 'Student');
        }

        return $this;
    }

    /**
     * Use the Student relation Student object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \bdxe\StudentQuery A secondary query class using the current class as primary query
     */
    public function useStudentQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinStudent($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Student', '\bdxe\StudentQuery');
    }

    /**
     * Filter the query by a related \bdxe\Course object
     *
     * @param \bdxe\Course|ObjectCollection $course The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSubjectQuery The current query, for fluid interface
     */
    public function filterByCourseRelatedByCourseId($course, $comparison = null)
    {
        if ($course instanceof \bdxe\Course) {
            return $this
                ->addUsingAlias(SubjectTableMap::COL_COURSE_ID, $course->getId(), $comparison);
        } elseif ($course instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SubjectTableMap::COL_COURSE_ID, $course->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCourseRelatedByCourseId() only accepts arguments of type \bdxe\Course or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CourseRelatedByCourseId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSubjectQuery The current query, for fluid interface
     */
    public function joinCourseRelatedByCourseId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CourseRelatedByCourseId');

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
            $this->addJoinObject($join, 'CourseRelatedByCourseId');
        }

        return $this;
    }

    /**
     * Use the CourseRelatedByCourseId relation Course object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \bdxe\CourseQuery A secondary query class using the current class as primary query
     */
    public function useCourseRelatedByCourseIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCourseRelatedByCourseId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CourseRelatedByCourseId', '\bdxe\CourseQuery');
    }

    /**
     * Filter the query by a related \bdxe\Course object
     *
     * @param \bdxe\Course|ObjectCollection $course the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSubjectQuery The current query, for fluid interface
     */
    public function filterByCourseRelatedBySubjectId($course, $comparison = null)
    {
        if ($course instanceof \bdxe\Course) {
            return $this
                ->addUsingAlias(SubjectTableMap::COL_ID, $course->getSubjectId(), $comparison);
        } elseif ($course instanceof ObjectCollection) {
            return $this
                ->useCourseRelatedBySubjectIdQuery()
                ->filterByPrimaryKeys($course->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCourseRelatedBySubjectId() only accepts arguments of type \bdxe\Course or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CourseRelatedBySubjectId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSubjectQuery The current query, for fluid interface
     */
    public function joinCourseRelatedBySubjectId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CourseRelatedBySubjectId');

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
            $this->addJoinObject($join, 'CourseRelatedBySubjectId');
        }

        return $this;
    }

    /**
     * Use the CourseRelatedBySubjectId relation Course object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \bdxe\CourseQuery A secondary query class using the current class as primary query
     */
    public function useCourseRelatedBySubjectIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCourseRelatedBySubjectId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CourseRelatedBySubjectId', '\bdxe\CourseQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSubject $subject Object to remove from the list of results
     *
     * @return $this|ChildSubjectQuery The current query, for fluid interface
     */
    public function prune($subject = null)
    {
        if ($subject) {
            $this->addUsingAlias(SubjectTableMap::COL_ID, $subject->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the subject_tb table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SubjectTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SubjectTableMap::clearInstancePool();
            SubjectTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SubjectTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SubjectTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            SubjectTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            SubjectTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SubjectQuery
