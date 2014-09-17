<?php
namespace Api\Models;

/**
 * Class Todo
 * @package Api\Models
 */
class Todo extends \Eloquent
{
    /**
     * @var array
     */
    protected $fillable = ['title', 'description'];
    /**
     * @var string
     */
    protected $table = 'todos';

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo('User');
    }
}
