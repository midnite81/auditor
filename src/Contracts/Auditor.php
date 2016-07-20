<?php

namespace Midnite81\Auditor\Contracts;

interface Auditor
{

    /**
     * Set the Data to be used
     *
     * @param $data
     * @return $this
     * @throws DataMustBeArrayOrCollectionException
     */
    public function setData($data);

    /**
     * Create sort order
     *
     * @param array $sorter
     * @return $this
     */
    public function sort(array $sorter);

    /**
     * Set the Index name to be used
     *
     * @param $column
     * @return $this
     */
    public function setColumn($column);

    /**
     * Render out the Audit
     */
    public function render();

    /**
     * Pass the Data Out as an Array
     */
    public function toArray();
    
}