<?php

class FeedPost extends Eloquent {

    use EloquentTrait;
    
    protected $table = 'apl_feed_post';
    public static $ftable = 'apl_feed_post'; // public table name
    public $timestamps = false;
    
}