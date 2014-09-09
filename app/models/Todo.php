<?php

class Todo extends \Eloquent {
	protected $fillable = ['title', 'description'];
    protected $table = 'todos';

    public function user()
    {
        return $this->belongsTo('User');
    }
}