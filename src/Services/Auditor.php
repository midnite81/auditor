<?php

namespace Midnite81\Auditor\Services;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Midnite81\Auditor\Contracts\Auditor as AuditorContract;
use Midnite81\Auditor\Exceptions\DataMustBeArrayOrCollectionException;
use Midnite81\Auditor\Exceptions\NoDataHasBeenSuppliedException;

class Auditor implements AuditorContract
{

    protected $data;

    protected $dataArray = [];

    protected $headings = [];

    protected $sorter = [];

    protected $column;
    

    /**
     * Set the Data to be used 
     * 
     * @param $data
     * @return $this
     * @throws DataMustBeArrayOrCollectionException
     */
    public function setData($data)
    {

        if (! is_array($data) && ! $data instanceof Collection && ! $data instanceof EloquentCollection) {
            throw new DataMustBeArrayOrCollectionException;
        }
        
        $this->data = (is_array($data)) ? $data : $data->toArray();

        return $this;
    }

    /**
     * Create sort order
     * 
     * @param array $sorter
     * @return $this
     */
    public function sort(array $sorter)
    {
        $this->sorter = $sorter;

        return $this;
    }
    

    /**
     * Set the Index name to be used
     *
     * @param $column
     * @return $this
     */
    public function setColumn($column)
    {
        $this->column = $column;

        return $this;
    }


    /**
     * Render out the Audit
     */
    public function render()
    {
        $data = $this->createDataArray();
        $headings = $this->headings;

        return view('auditor::table', compact('data', 'headings'));
    }

    /**
     * Create Data Array
     */
    protected function createDataArray()
    {
        $headings = $this->getHeadings();

        $dataArray = [];

        $count = 0;
        foreach($this->data as $data) {
            $column = (empty($this->column)) ? array_keys($data)[0] : $this->column;
            $dataItem = json_decode($data[$column], true);

            foreach($headings as $heading) {
                $this->dataArray[$count][$heading] = ! empty($dataItem[$heading]) ? $dataItem[$heading] : '';
            }

            $count++;
        }

        return $this->dataArray;

    }

    /**
     * Get the headings
     *
     * @return $this
     * @throws NoDataHasBeenSuppliedException
     */
    protected function getHeadings()
    {
        if (empty($this->data)) {
            throw new NoDataHasBeenSuppliedException;
        }


        foreach($this->data as $heading) {
            $column = (empty($this->column)) ? array_keys($heading)[0] : $this->column;
            $data = json_decode($heading[$column]);

            if (! empty($data)) {
                foreach($data as $key=>$value) {
                    if (! in_array($key, $this->headings)) {
                        $this->headings[] = $key;
                    }
                }
            }
        }


        if (! empty($this->sorter)) {
            uasort($this->headings, [$this, 'sortCompare']);
        }

        return $this->headings;
    }

    /**
     * Callback for uasort
     *
     * @param $a
     * @param $b
     * @return int
     */
    protected function sortCompare($a, $b)
    {
        $headings = $this->headings;

        $a = (in_array($a, $this->sorter)) ? array_search($a, $this->sorter) : 100 + array_search($a, $headings);
        $b = (in_array($b, $this->sorter)) ? array_search($b, $this->sorter) : 100 + array_search($b, $headings);

        if ($a < $b) {
            return -1;
        } else if ($b < $a) {
            return 1;
        }
        return 0;

    }

}