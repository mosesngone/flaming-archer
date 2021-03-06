<?php
/**
 * Flaming Archer
 *
 * @link      http://github.com/jeremykendall/flaming-archer for the canonical source repository
 * @copyright Copyright (c) 2012 Jeremy Kendall (http://about.me/jeremykendall)
 * @license   http://github.com/jeremykendall/flaming-archer/blob/master/LICENSE MIT License
 */

namespace FA;

use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;

/**
 * Returns a Paginator
 */
class Pagination
{
    /**
     * Creates a paginator
     *
     * @return Paginator Zend Paginator
     */
    public function newPaginator(array $images = array(), $currentPage = 1, $perPage = 25)
    {
        $paginator = new Paginator(new ArrayAdapter($images));
        $paginator->setItemCountPerPage($perPage);
        $paginator->setCurrentPageNumber($currentPage);

        return $paginator;
    }
}
