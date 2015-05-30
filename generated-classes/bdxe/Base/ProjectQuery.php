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
use bdxe\Project as ChildProject;
use bdxe\ProjectQuery as ChildProjectQuery;
use bdxe\Map\ProjectTableMap;

/**
 * Base class that represents a query for the 'project_tb' table.
 *
 * 
 *
 * @method     ChildProjectQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildProjectQuery orderByCourseId($order = Criteria::ASC) Order by the course_id column
 * @method     ChildProjectQuery orderByTitlu($order = Criteria::ASC) Order by the Titlu column
 * @method     ChildProjectQuery orderByMaterie($order = Criteria::ASC) Order by the Materie column
 * @method     ChildProjectQuery orderByDificultate($order = Criteria::ASC) Order by the Dificultate column
 * @method     ChildProjectQuery orderByDescription($order = Criteria::ASC) Order by the Description column
 * @method     ChildProjectQuery orderByNota($order = Criteria::ASC) Order by the Nota column
 * @method     ChildProjectQuery orderByNumarParticipanti($order = Criteria::ASC) Order by the Numar_Participanti column
 * @method     ChildProjectQuery orderByDuetime($order = Criteria::ASC) Order by the DueTime column
 * @method     ChildProjectQuery orderByPosttime($order = Criteria::ASC) Order by the PostTime column
 *
 * @method     ChildProjectQuery groupById() Group by the id column
 * @method     ChildProjectQuery groupByCourseId() Group by the course_id column
 * @method     ChildProjectQuery groupByTitlu() Group by the Titlu column
 * @method     ChildProjectQuery groupByMaterie() Group by the Materie column
 * @method     ChildProjectQuery groupByDificultate() Group by the Dificultate column
 * @method     ChildProjectQuery groupByDescription() Group by the Description column
 * @method     ChildProjectQuery groupByNota() Group by the Nota column
 * @method     ChildProjectQuery groupByNumarParticipanti() Group by the Numar_Participanti column
 * @method     ChildProjectQuery groupByDuetime() Group by the DueTime column
 * @method     ChildProjectQuery groupByPosttime() Group by the PostTime column
 *
 * @method     ChildProjectQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildProjectQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildProjectQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildProjectQuery leftJoinCourse($relationAlias = null) Adds a LEFT JOIN clause to the query using the Course relation
 * @method     ChildProjectQuery rightJoinCourse($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Course relation
 * @method     ChildProjectQuery innerJoinCourse($relationAlias = null) Adds a INNER JOIN clause to the query using the Course relation
 *
 * @method     ChildProjectQuery leftJoinProjectEval($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProjectEval relation
 * @method     ChildProjectQuery rightJoinProjectEval($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProjectEval relation
 * @method     ChildProjectQuery innerJoinProjectEval($relationAlias = null) Adds a INNER JOIN clause to the query using the ProjectEval relation
 *
 * @method     ChildProjectQuery leftJoinGroup($relationAlias = null) Adds a LEFT JOIN clause to the query using the Group relation
 * @method     ChildProjectQuery rightJoinGroup($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Group relation
 * @method     ChildProjectQuery innerJoinGroup($relationAlias = null) Adds a INNER JOIN clause to the query using the Group relation
 *
 * @method     \bdxe\CourseQuery|\bdxe\ProjectEvalQuery|\bdxe\GroupQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildProject findOne(ConnectionInterface $con = null) Return the first ChildProject matching the query
 * @method     ChildProject findOneOrCreate(ConnectionInterface $con = null) Return the first ChildProject matching the query, or a new ChildProject object populated from the query conditions when no match is found
 *
 * @method     ChildProject findOneById(int $id) Return the first ChildProject filtered by the id column
 * @method     ChildProject findOneByCourseId(int $course_id) Return the first ChildProject filtered by the course_id column
 * @method     ChildProject findOneByTitlu(string $Titlu) Return the first ChildProject filtered by the Titlu column
 * @method     ChildProject findOneByMaterie(string $Materie) Return the first ChildProject filtered by the Materie column
 * @method     ChildProject findOneByDificultate(string $Dificultate) Return the first ChildProject filtered by the Dificultate column
 * @method     ChildProject findOneByDescription(string $Description) Return the first ChildProject filtered by the Description column
 * @method     ChildProject findOneByNota(int $Nota) Return the first ChildProject filtered by the Nota column
 * @method     ChildProject findOneByNumarParticipanti(int $Numar_Participanti) Return the first ChildProject filtered by the Numar_Participanti column
 * @method     ChildProject findOneByDuetime(string $DueTime) Return the first ChildProject filtered by the DueTime column
 * @method     ChildProject findOneByPosttime(string $PostTime) Return the first ChildProject filtered by the PostTime column *

 * @method     ChildProject requirePk($key, ConnectionInterface $con = null) Return the ChildProject by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProject requireOne(ConnectionInterface $con = null) Return the first ChildProject matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildProject requireOneById(int $id) Return the first ChildProject filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProject requireOneByCourseId(int $course_id) Return the first ChildProject filtered by the course_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProject requireOneByTitlu(string $Titlu) Return the first ChildProject filtered by the Titlu column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProject requireOneByMaterie(string $Materie) Return the first ChildProject filtered by the Materie column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProject requireOneByDificultate(string $Dificultate) Return the first ChildProject filtered by the Dificultate column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProject requireOneByDescription(string $Description) Return the first ChildProject filtered by the Description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProject requireOneByNota(int $Nota) Return the first ChildProject filtered by the Nota column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProject requireOneByNumarParticipanti(int $Numar_Participanti) Return the first ChildProject filtered by the Numar_Participanti column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProject requireOneByDuetime(string $DueTime) Return the first ChildProject filtered by the DueTime column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProject requireOneByPosttime(string $PostTime) Return the first ChildProject filtered by the PostTime column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildProject[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildProject objects based on current ModelCriteria
 * @method     ChildProject[]|ObjectCollection findById(int $id) Return ChildProject objects filtered by the id column
 * @method     ChildProject[]|ObjectCollection findByCourseId(int $course_id) Return ChildProject objects filtered by the course_id column
 * @method     ChildProject[]|ObjectCollection findByTitlu(string $Titlu) Return ChildProject objects filtered by the Titlu column
 * @method     ChildProject[]|ObjectCollection findByMaterie(string $Materie) Return ChildProject objects filtered by the Materie column
 * @method     ChildProject[]|ObjectCollection findByDificultate(string $Dificultate) Return ChildProject objects filtered by the Dificultate column
 * @method     ChildProject[]|ObjectCollection findByDescription(string $Description) Return ChildProject objects filtered by the Description column
 * @method     ChildProject[]|ObjectCollection findByNota(int $Nota) Return ChildProject objects filtered by the Nota column
 * @method     ChildProject[]|ObjectCollection findByNumarParticipanti(int $Numar_Participanti) Return ChildProject objects filtered by the Numar_Participanti column
 * @method     ChildProject[]|ObjectCollection findByDuetime(string $DueTime) Return ChildProject objects filtered by the DueTime column
 * @method     ChildProject[]|ObjectCollection findByPosttime(string $PostTime) Return ChildProject objects filtered by the PostTime column
 * @method     ChildProject[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ProjectQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \bdxe\Base\ProjectQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\bdxe\\Project', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildProjectQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildProjectQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildProjectQuery) {
            return $criteria;
        }
        $query = new ChildProjectQuery();
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
     * @return ChildProject|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProjectTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ProjectTableMap::DATABASE_NAME);
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
     * @return ChildProject A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, course_id, Titlu, Materie, Dificultate, Description, Nota, Numar_Participanti, DueTime, PostTime FROM project_tb WHERE id = :p0';
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
            /** @var ChildProject $obj */
            $obj = new ChildProject();
            $obj->hydrate($row);
            ProjectTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildProject|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildProjectQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProjectTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildProjectQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProjectTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildProjectQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ProjectTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ProjectTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildProjectQuery The current query, for fluid interface
     */
    public function filterByCourseId($courseId = null, $comparison = null)
    {
        if (is_array($courseId)) {
            $useMinMax = false;
            if (isset($courseId['min'])) {
                $this->addUsingAlias(ProjectTableMap::COL_COURSE_ID, $courseId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($courseId['max'])) {
                $this->addUsingAlias(ProjectTableMap::COL_COURSE_ID, $courseId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectTableMap::COL_COURSE_ID, $courseId, $comparison);
    }

    /**
     * Filter the query on the Titlu column
     *
     * Example usage:
     * <code>
     * $query->filterByTitlu('fooValue');   // WHERE Titlu = 'fooValue'
     * $query->filterByTitlu('%fooValue%'); // WHERE Titlu LIKE '%fooValue%'
     * </code>
     *
     * @param     string $titlu The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProjectQuery The current query, for fluid interface
     */
    public function filterByTitlu($titlu = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($titlu)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $titlu)) {
                $titlu = str_replace('*', '%', $titlu);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProjectTableMap::COL_TITLU, $titlu, $comparison);
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
     * @return $this|ChildProjectQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ProjectTableMap::COL_MATERIE, $materie, $comparison);
    }

    /**
     * Filter the query on the Dificultate column
     *
     * Example usage:
     * <code>
     * $query->filterByDificultate('fooValue');   // WHERE Dificultate = 'fooValue'
     * $query->filterByDificultate('%fooValue%'); // WHERE Dificultate LIKE '%fooValue%'
     * </code>
     *
     * @param     string $dificultate The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProjectQuery The current query, for fluid interface
     */
    public function filterByDificultate($dificultate = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($dificultate)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $dificultate)) {
                $dificultate = str_replace('*', '%', $dificultate);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProjectTableMap::COL_DIFICULTATE, $dificultate, $comparison);
    }

    /**
     * Filter the query on the Description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE Description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE Description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProjectQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProjectTableMap::COL_DESCRIPTION, $description, $comparison);
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
     * @return $this|ChildProjectQuery The current query, for fluid interface
     */
    public function filterByNota($nota = null, $comparison = null)
    {
        if (is_array($nota)) {
            $useMinMax = false;
            if (isset($nota['min'])) {
                $this->addUsingAlias(ProjectTableMap::COL_NOTA, $nota['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($nota['max'])) {
                $this->addUsingAlias(ProjectTableMap::COL_NOTA, $nota['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectTableMap::COL_NOTA, $nota, $comparison);
    }

    /**
     * Filter the query on the Numar_Participanti column
     *
     * Example usage:
     * <code>
     * $query->filterByNumarParticipanti(1234); // WHERE Numar_Participanti = 1234
     * $query->filterByNumarParticipanti(array(12, 34)); // WHERE Numar_Participanti IN (12, 34)
     * $query->filterByNumarParticipanti(array('min' => 12)); // WHERE Numar_Participanti > 12
     * </code>
     *
     * @param     mixed $numarParticipanti The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProjectQuery The current query, for fluid interface
     */
    public function filterByNumarParticipanti($numarParticipanti = null, $comparison = null)
    {
        if (is_array($numarParticipanti)) {
            $useMinMax = false;
            if (isset($numarParticipanti['min'])) {
                $this->addUsingAlias(ProjectTableMap::COL_NUMAR_PARTICIPANTI, $numarParticipanti['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($numarParticipanti['max'])) {
                $this->addUsingAlias(ProjectTableMap::COL_NUMAR_PARTICIPANTI, $numarParticipanti['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectTableMap::COL_NUMAR_PARTICIPANTI, $numarParticipanti, $comparison);
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
     * @return $this|ChildProjectQuery The current query, for fluid interface
     */
    public function filterByDuetime($duetime = null, $comparison = null)
    {
        if (is_array($duetime)) {
            $useMinMax = false;
            if (isset($duetime['min'])) {
                $this->addUsingAlias(ProjectTableMap::COL_DUETIME, $duetime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($duetime['max'])) {
                $this->addUsingAlias(ProjectTableMap::COL_DUETIME, $duetime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectTableMap::COL_DUETIME, $duetime, $comparison);
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
     * @return $this|ChildProjectQuery The current query, for fluid interface
     */
    public function filterByPosttime($posttime = null, $comparison = null)
    {
        if (is_array($posttime)) {
            $useMinMax = false;
            if (isset($posttime['min'])) {
                $this->addUsingAlias(ProjectTableMap::COL_POSTTIME, $posttime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($posttime['max'])) {
                $this->addUsingAlias(ProjectTableMap::COL_POSTTIME, $posttime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectTableMap::COL_POSTTIME, $posttime, $comparison);
    }

    /**
     * Filter the query by a related \bdxe\Course object
     *
     * @param \bdxe\Course|ObjectCollection $course The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildProjectQuery The current query, for fluid interface
     */
    public function filterByCourse($course, $comparison = null)
    {
        if ($course instanceof \bdxe\Course) {
            return $this
                ->addUsingAlias(ProjectTableMap::COL_COURSE_ID, $course->getId(), $comparison);
        } elseif ($course instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProjectTableMap::COL_COURSE_ID, $course->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildProjectQuery The current query, for fluid interface
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
     * Filter the query by a related \bdxe\ProjectEval object
     *
     * @param \bdxe\ProjectEval|ObjectCollection $projectEval the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProjectQuery The current query, for fluid interface
     */
    public function filterByProjectEval($projectEval, $comparison = null)
    {
        if ($projectEval instanceof \bdxe\ProjectEval) {
            return $this
                ->addUsingAlias(ProjectTableMap::COL_ID, $projectEval->getProjectId(), $comparison);
        } elseif ($projectEval instanceof ObjectCollection) {
            return $this
                ->useProjectEvalQuery()
                ->filterByPrimaryKeys($projectEval->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProjectEval() only accepts arguments of type \bdxe\ProjectEval or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProjectEval relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildProjectQuery The current query, for fluid interface
     */
    public function joinProjectEval($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProjectEval');

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
            $this->addJoinObject($join, 'ProjectEval');
        }

        return $this;
    }

    /**
     * Use the ProjectEval relation ProjectEval object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \bdxe\ProjectEvalQuery A secondary query class using the current class as primary query
     */
    public function useProjectEvalQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinProjectEval($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProjectEval', '\bdxe\ProjectEvalQuery');
    }

    /**
     * Filter the query by a related \bdxe\Group object
     *
     * @param \bdxe\Group|ObjectCollection $group the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProjectQuery The current query, for fluid interface
     */
    public function filterByGroup($group, $comparison = null)
    {
        if ($group instanceof \bdxe\Group) {
            return $this
                ->addUsingAlias(ProjectTableMap::COL_ID, $group->getProjectId(), $comparison);
        } elseif ($group instanceof ObjectCollection) {
            return $this
                ->useGroupQuery()
                ->filterByPrimaryKeys($group->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGroup() only accepts arguments of type \bdxe\Group or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Group relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildProjectQuery The current query, for fluid interface
     */
    public function joinGroup($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Group');

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
            $this->addJoinObject($join, 'Group');
        }

        return $this;
    }

    /**
     * Use the Group relation Group object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \bdxe\GroupQuery A secondary query class using the current class as primary query
     */
    public function useGroupQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinGroup($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Group', '\bdxe\GroupQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildProject $project Object to remove from the list of results
     *
     * @return $this|ChildProjectQuery The current query, for fluid interface
     */
    public function prune($project = null)
    {
        if ($project) {
            $this->addUsingAlias(ProjectTableMap::COL_ID, $project->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the project_tb table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProjectTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ProjectTableMap::clearInstancePool();
            ProjectTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ProjectTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ProjectTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            ProjectTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            ProjectTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ProjectQuery
