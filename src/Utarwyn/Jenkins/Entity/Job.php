<?php

namespace Utarwyn\Jenkins\Entity;


use Utarwyn\Jenkins\JenkinsEntity;
use Utarwyn\Jenkins\Server\ApiAccessor;

class Job extends JenkinsEntity {

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $displayName;

    /**
     * @var string
     */
    protected $fullDisplayName;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var boolean
     */
    protected $buildable;

    protected $builds;

    /**
     * @var string
     */
    protected $color;

    protected $firstBuild;

    protected $healthReport;

    /**
     * @var boolean
     */
    protected $inQueue;

    /**
     * @var boolean
     */
    protected $keepDependencies;

    /**
     * @var integer
     */
    protected $nextBuildNumber;

    /**
     * @var boolean
     */
    protected $concurrentBuild;

    public function __construct(ApiAccessor $apiAccessor, string $name) {
        parent::__construct($apiAccessor, "job/$name");
    }

    /**
     * @return string
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getDisplayName(): string {
        return $this->displayName;
    }

    /**
     * @return string
     */
    public function getFullDisplayName(): string {
        return $this->fullDisplayName;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getUrl(): string {
        return $this->url;
    }

    /**
     * @return bool
     */
    public function isBuildable(): bool {
        return $this->buildable;
    }

    /**
     * @return string
     */
    public function getColor(): string {
        return $this->color;
    }

    /**
     * @return bool
     */
    public function isInQueue(): bool {
        return $this->inQueue;
    }

    /**
     * @return bool
     */
    public function isKeepDependencies(): bool {
        return $this->keepDependencies;
    }

    /**
     * @param int $id
     * @return Build
     */
    public function getBuild(int $id): Build {
        return new Build($this->getApiAccessor(), $this, $id);
    }

    /**
     * @return null|Build
     */
    public function getFirstBuild() {
        return Job::getBuildFromJson($this, "firstBuild");
    }

    /**
     * @return null|Build
     */
    public function getLastBuild() {
        return Job::getBuildFromJson($this, "lastBuild");
    }

    /**
     * @return null|Build
     */
    public function getLastCompletedBuild() {
        return Job::getBuildFromJson($this, "lastCompletedBuild");
    }

    /**
     * @return null|Build
     */
    public function getLastFailedBuild() {
        return Job::getBuildFromJson($this, "lastFailedBuild");
    }

    /**
     * @return null|Build
     */
    public function getLastStableBuild() {
        return Job::getBuildFromJson($this, "lastStableBuild");
    }

    /**
     * @return null|Build
     */
    public function getLastSuccessful() {
        return Job::getBuildFromJson($this, "lastSuccessfulBuild");
    }

    /**
     * @return null|Build
     */
    public function getLastUnstableBuild() {
        return Job::getBuildFromJson($this, "lastUnstableBuild");
    }

    /**
     * @return null|Build
     */
    public function getLastUnsuccessfulBuild() {
        return Job::getBuildFromJson($this, "lastUnsuccessfulBuild");
    }

    /**
     * @return int
     */
    public function getNextBuildNumber(): int {
        return $this->nextBuildNumber;
    }

    /**
     * @param Job $job
     * @param $jsonKey
     * @return null|Build
     */
    private static function getBuildFromJson(job $job, $jsonKey) {
        $buildObj = $job->getData()->get($jsonKey);

        if (empty($buildObj)) return null;
        return new Build($job->getApiAccessor(), $job, $buildObj->number);
    }

}