<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 9/08/16
 * Time: 19:59
 */

namespace istheweb\rating\contracts;


use October\Rain\Database\Model;

interface Ratingable
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function ratings();
    /**
     *
     * @return mix
     */
    public function averageRating();

    /**
     *
     * @return mix
     */
    public function countRatings();
    /**
     *
     * @return mix
     */
    public function sumRating();
    /**
     * @param $max
     *
     * @return mix
     */
    public function ratingPercent($max = 5);

    /**
     * @param $data
     * @param Model      $author
     * @param Model|null $parent
     *
     * @return mixed
     */
    public function rating($data, Model $author, Model $parent = null);
    /**
     * @param $id
     * @param $data
     * @param Model|null $parent
     *
     * @return mixed
     */
    public function updateRating($id, $data, Model $parent = null);
    /**
     * @param $id
     *
     * @return mixed
     */
    public function deleteRating($id);
}