<?php

class Post extends Eloquent {

    use EloquentTrait;

    protected $table = 'apl_post';
    public static $ftable = 'apl_post'; // public table name
    public $timestamps = true;
    public static $taxonomy = 1;

    public function langs() {
        return $this->hasMany('PostLang', 'post_id', 'id');
    }

    public static function tree($taxonomy_id, $parent = 0) {
        $list = Post::where('parent', $parent)->where('taxonomy_id', $taxonomy_id)->get();

        foreach ($list as &$item) {
            $item['lang'] = $item->langs()->where('lang_id', Language::getId())->first();
            $item['list'] = Post::tree($taxonomy_id, $item->id);
        }

        return $list;
    }

    public static function findTax($id, $taxonomy_id) {
        return Post::where('id', $id)->where('taxonomy_id', $taxonomy_id)->first();
    }

    public static function feedsID($post_id) {
        $ids = array();
        foreach (FeedPost::where('post_id', $post_id)->get() as $record) {
            $ids[] = $record->feed_id;
        }
        return $ids;
    }

    protected static function columns() {
        return array(Post::$ftable . ".*", PostLang::$ftable . ".text", PostLang::$ftable . ".title", PostLang::$ftable . ".enabled", PostLang::$ftable . ".lang_id", PostLang::$ftable . ".uri");
    }

    protected static function prepareQuery() {
        return Post::join(PostLang::$ftable, PostLang::$ftable . ".post_id", '=', Post::$ftable . ".id")
                        ->select(
                                Post::columns()
                        )
                        ->where(PostLang::$ftable . ".lang_id", Language::getId())->where('taxonomy_id', self::$taxonomy);
    }

    public static function findRow($where = array(), $enabled = 0) {
        $row = Post::prepareQuery();

        if ($enabled) {
            $row = $row->where(PostLang::$ftable . ".enabled", 1);
        }

        return $row->where($where)->get()->first();
    }

    public static function findWithParent($parent_id) {
        $query = Post::prepareQuery();
        $list = $query->where(array(
                    'parent' => $parent_id
                ))->get();

        foreach ($list as &$item) {
            $item['url'] = Post::getFullURI($item['id']);
        }

        return $list;
    }

    public static $cache_posts = array();

    public static function findID($id, $enabled = 0) {
        if (isset(self::$cache_posts[$id]) && self::$cache_posts[$id]) {
            $item = self::$cache_posts[$id];
        } else {
            $item = Post::findRow(
                            array(Post::$ftable . ".id" => $id), $enabled
            );
            self::$cache_posts[$id] = $item;
        }

        return $item;
    }

    public static function findURI($uri, $enabled = 0) {
        return Post::findRow(
                        array(PostLang::$ftable . ".uri" => $uri), $enabled
        );
    }

    public static function getParents($parent_id) {
        $list = array();
        while ($parent_id) {
            $item = Post::findID($parent_id);
            if ($item) {
                $list[] = $item->toArray();
                $parent_id = $item->parent;
            } else {
                $parent_id = 0;
            }
        }
        return $list;
    }

    public static function getFullURI($id) {
        $parents = Post::getParents($id);
        $uri_segments = array();
        foreach (array_reverse($parents) as $parent) {
            $uri_segments[] = $parent['uri'];
        }
        return Post::getURL(implode('/', $uri_segments));
    }

    public static function getURL($uri) {
        return Core\APL\Language::url("page/" . $uri);
    }

    public static function oneView($id) {
        $post = Post::find($id);
        if ($post) {
            $post->views = $post->views + 1;
            $post->save();
        }
    }

    public static function postsFeed($feed_id) {
        $posts = Post::prepareQuery()
                ->join(FeedPost::getTableName(), Post::getField("id"), '=', FeedPost::getField("post_id"))
                ->where(FeedPost::getField("feed_id"), $feed_id)
                ->select(
                        Post::columns() + array(FeedPost::getField("feed_id"))
                )
                ->get();
        
        foreach ($posts as &$post) {
            $fields = FeedField::leftJoin(FeedFieldValue::getTableName(), FeedFieldValue::getField("feed_field_id"), "=", FeedField::getField("id"))
                    ->whereIn(FeedFieldValue::getField("lang_id"), array(0, \Core\APL\Language::getId()))
                    ->where(FeedFieldValue::getField("post_id"), $post->id)
                    ->select(FeedField::getField("fkey"), FeedFieldValue::getField("value"))
                    ->get();
            foreach ($fields as $field) {
                $post[$field->fkey] = $field->value;
            }
        }

        return $posts;
    }

}