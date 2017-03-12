<?php namespace Istheweb\Rating\Models;

use Model;

/**
 * Rating Model
 */
class Rating extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'istheweb_rating_ratings';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function ratingable()
    {
        return $this->morphTo();
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function author()
    {
        return $this->morphTo('author');
    }
    /**
     * @param Model $ratingable
     * @param $data
     * @param Model $author
     *
     * @return static
     */
    public function createRating(Model $ratingable, $data, Model $author)
    {
        $rating = new static();
        $rating->fill(array_merge($data, [
            'author_id' => $author->id,
            'author_type' => get_class($author),
        ]));
        $ratingable->ratings()->save($rating);
        return $rating;
    }
    /**
     * @param $id
     * @param $data
     *
     * @return mixed
     */
    public function updateRating($id, $data)
    {
        $rating = static::find($id);
        $rating->update($data);
        return $rating;
    }
    /**
     * @param $id
     *
     * @return mixed
     */
    public function deleteRating($id)
    {
        return static::find($id)->delete();
    }
}