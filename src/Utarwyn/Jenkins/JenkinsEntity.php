<?php

namespace Utarwyn\Jenkins;

use Utarwyn\Jenkins\Helper\JsonData;
use Utarwyn\Jenkins\Server\ApiAccessor;


abstract class JenkinsEntity {

    /**
     * @var JsonData The API data of this entity.
     */
    private $data;

    public function __construct(ApiAccessor $apiAccessor, string $objectAction) {
        $this->loadData($apiAccessor, $objectAction);
    }

    protected function getData() {
        return $this->data;
    }

    private function loadData(ApiAccessor $apiAccessor, string $action) {
        $this->data = $apiAccessor->request("GET", $action);

        foreach (get_object_vars($this) as $variable => $value) {
            if ($variable === "data") continue;
            $this->$variable = $this->data->get($variable);
        }
    }

}