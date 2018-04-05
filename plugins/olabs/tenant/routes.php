<?php
/**
 * Created by PhpStorm.
 * User: Lokendra
 * Date: 9/14/16
 * Time: 4:15 PM
 */

use Olabs\Tenant\Classes\Tenant;

use Olabs\Tenant\Models\Organizations;
/*
use Lang;
use Auth;
use Backend;
use OlabsAuth;
use Mail;
use Event;
use Flash;
use Input;
use Request;
use Redirect;
use Validator;
use ValidationException;
use ApplicationException;*/
Route::get('api1', function () {
    return 'Hello World';
});

Route::post('api1/foo/bar', function () {
    return 'Hello World';
});

Route::put('api1/foo/bar', function () {
    //
});

Route::delete('a/signin', function () {
});


/**
 * curl --data "param1=value1&param2=value2" https://example.com/resource.cgi

 curl --data "login=admin&password=mkb@123!" http://resort2.schoolengage.opaclabs.com/a/signin

 */
Route::post('old/a/signin', function () {
        $rules = [
            'login'    => 'required|between:2,255',
            'password' => 'required|between:4,255'
        ];

        $validation = Validator::make(post(), $rules);
        if ($validation->fails()) {
            //throw new ValidationException($validation);
            return ['s'=>'403'];
        }

        // Authenticate user
        $user = OlabsAuth::authenticate([
            'login' => post('login'),
            'password' => post('password')
        ], true);
    return ['s'=>'200','user'=>$user, 'groups'=>$user->groups];
});

Route::get('api1/user/{id}', function ($id) {
    return 'User '.$id;
});


function setOrg($org){
    $slides = Olabs\Tenant\Models\Contents::where(['tenant_id'=>$org->id])->where('tags','like','%home_slider%')->orderBy('name', 'asc')->get();


    $org = $org->toArray();

    $desc = Olabs\Parsers\Models\TextUtils::toText($org['description']);
    $org['description'] = $desc;
    $org['excerpt'] = isset($org['excerpt']) && $org['excerpt']?$org['excerpt']:$desc;

    $LEN = 200;
    if(utf8_strlen( $org['excerpt'])>$LEN){
        $org['excerpt'] = utf8_substr(strip_tags(html_entity_decode($org['excerpt'], ENT_QUOTES, 'UTF-8'))  , 0, $LEN) . '..';
    }

    $currentHostUrl = $org['config_url'];
    $currentHostUrl = 'http://'.$currentHostUrl;
    $org['address'] = Tenant::toAddressText($org);
    $org['type'] ='organization';

    //$org['request_url'] =  $requestUrl;
    $org['current_host_url'] =  $currentHostUrl;

    $categories = array();
    //$org['type'] ='org';
    //$org['id'] =$org['id'];
    $org['img'] = $currentHostUrl.'/storage/app/media/1-278tqw9zNPe2WCAz29Wzdw.jpeg';
    if($slides && count($slides)>0){
        $featured_images = array();
        foreach($slides as $image){
            $url = $currentHostUrl.'/storage/app/media/'.$image->cover_photo;
            $featured_images[] = array('thumb'=>$url,'main'=>$url);
            if(!isset($org['img'])){
               $org['img'] = $url;
            }
        }

        $org['images'] = $featured_images;

    }

    if(!isset($org['img'])){
        // $o['img'] = 'http://www.getmdl.io/assets/demos/welcome_card.jpg';
        $org['img'] = $currentHostUrl.'/storage/app/media/1-278tqw9zNPe2WCAz29Wzdw.jpeg';
    }

    //$categories[] = $org;

    if ($org['profile_type'] == 'school') {
        $categories[] = array('name' => 'News', 'id' => 'news', 'data_source' => $currentHostUrl . '/a/posts/'.$org['id'].'/news', 'child_types' => 'articles');
        $categories[] = array('name' => 'Gallery', 'id' => 'Gallery', 'data_source' => $currentHostUrl . '/a/posts/'.$org['id'].'/gallery', 'child_types' => 'articles');
        $categories[] = array('name' => 'Blogs', 'id' => 'Blogs', 'data_source' => $currentHostUrl . '/a/posts/'.$org['id'].'/blogs', 'child_types' => 'articles');
        $categories[] = array('name' => 'Team', 'id' => 'team', 'data_source' => $currentHostUrl . '/a/posts/'.$org['id'].'/team');
        $categories[] = array('name' => 'Classrooms', 'id' => 'classrooms', 'data_source' => $currentHostUrl . '/a/posts/'.$org['id'].'/classrooms', 'child_types' => 'classrooms');


    }
    if ($org['profile_type'] == 'hotel') {
        $categories[] = array('name' => 'News', 'id' => 'news', 'data_source' => $currentHostUrl . '/a/posts/'.$org['id'].'/news', 'child_types' => 'articles');
        $categories[] = array('name' => 'Gallery', 'id' => 'Gallery', 'data_source' => $currentHostUrl . '/a/posts/'.$org['id'].'/gallery', 'child_types' => 'articles');
        $categories[] = array('name' => 'Blogs', 'id' => 'Blogs', 'data_source' => $currentHostUrl . '/a/posts/'.$org['id'].'/blogs', 'child_types' => 'articles');
        $categories[] = array('name' => 'Excursions', 'id' => 'Excursions', 'data_source' => $currentHostUrl . '/a/posts/'.$org['id'].'/excursions', 'child_types' => 'articles');
        $categories[] = array('name' => 'Team', 'id' => 'team', 'data_source' => $currentHostUrl . '/a/posts/'.$org['id'].'/team');
    }

    if ($org['profile_type'] == 'schools') {
        $categories[] = array('name' => 'Schools', 'id' => 'schools', 'data_source' => $currentHostUrl . '/a/organizations/school');
        $categories[] = array('name' => 'Hotels/Resorts', 'id' => 'hotel', 'data_source' => $currentHostUrl . '/a/organizations/hotel');
        $categories[] = array('name' => 'News', 'id' => 'news', 'data_source' => $currentHostUrl . '/a/posts/'.$org['id'].'/news', 'child_types' => 'articles');
        $categories[] = array('name' => 'Gallery', 'id' => 'Gallery', 'data_source' => $currentHostUrl . '/a/posts/'.$org['id'].'/gallery', 'child_types' => 'articles');
        $categories[] = array('name' => 'Blogs', 'id' => 'Blogs', 'data_source' => $currentHostUrl . '/a/posts/'.$org['id'].'/blogs', 'child_types' => 'articles');
        $categories[] = array('name' => 'Team', 'id' => 'team', 'data_source' => $currentHostUrl . '/a/posts/'.$org['id'].'/team');

    }


    $org['categories'] =  $categories;

   /* $list = Olabs\Tenant\Models\Organizations::get();

    $rlist = array();
    foreach($list as $post){

    }*/

    return $org;

}


Route::get('a/org/{id?}', function ($id=null) {
    $backendUri = Config::get('cms.backendUri');
    $requestUrl = Request::url();
    $currentHostUrl = Request::getHost();
    $currentHostUrl = 'http://'.$currentHostUrl;

    $org = Tenant::getOrg();
    $org = setOrg($org);

    return $org;
    return 'User '.$id;
});

function utf8_strlen($string) {
    return mb_strlen($string);
}
function utf8_substr($string, $offset, $length = null) {
    if ($length === null) {
        return mb_substr($string, $offset, utf8_strlen($string));
    } else {
        return mb_substr($string, $offset, $length);
    }
}




Route::get('a/organizations/{profile_type?}', function ($profile_type=null) {
    $backendUri = Config::get('cms.backendUri');
    $requestUrl = Request::url();
    $currentHostUrl = Request::getHost();
    $currentHostUrl = 'http://'.$currentHostUrl;

    $response =[];

    $list = Olabs\Tenant\Models\Organizations::where('profile_type',$profile_type)->get();

    $rlist = array();
    foreach($list as $post){
        $o = setOrg($post);
        $rlist[] = $o;
    }

    $response['data'] = $rlist;
    return $response;

});

Route::get('a/posts/{tenant?}/{slug?}', function ($tenant=null,$slug=null) {
    $backendUri = Config::get('cms.backendUri');
    $requestUrl = Request::url();
    $currentHostUrl = Request::getHost();
    $currentHostUrl = 'http://'.$currentHostUrl;

    $response = [];

    $where = ['tenant_id'=>$tenant,'slug'=>$slug];
    $where = ['slug'=>$slug];
    //$where = ['tenant_id'=>'4','slug'=>'gallery'];
    $list = array();//RainLab\Blog\Models\Post::where($where)->get();

    $category = RainLab\Blog\Models\Category::where($where)->first();

    $response['where'] = $where;
    $response['category'] = $category;


    if($category){
        $categoryId = $category ? $category->id : null;
        $sub_categories = $category->getAllChildren();
        $response['sub_categories'] = $sub_categories;
        /*
        * List all the posts, eager load their categories
        */
        $posts = RainLab\Blog\Models\Post::with('categories')->listFrontEnd([
            'category'   => $categoryId
        ]);

        $response['posts'] = $posts;
        $list = $posts;
    }

    $rlist = array();
    foreach($list as $post){
        $desc = Olabs\Parsers\Models\TextUtils::toText($post->content_html);
        $o = array('name'=>$post->title, 'description'=>$desc, 'excerpt'=>$post->excerpt?$post->excerpt:$desc);

        $LEN = 400;
        if(utf8_strlen( $o['excerpt'])>$LEN){
        $o['excerpt'] = utf8_substr(strip_tags(html_entity_decode($o['excerpt'], ENT_QUOTES, 'UTF-8'))  , 0, $LEN) . '..';
        }
        $dateTime =  new \DateTime($post->published_at);
        $created_since = System\Helpers\DateTime::timeSince($dateTime);
        $o['created_since'] = $created_since;

        if($post->featured_images && count($post->featured_images)>0){
          $featured_images = array();
          foreach($post->featured_images as $image){
              $featured_images[] = array('thumb'=>$currentHostUrl.$image['path'],'main'=>$currentHostUrl.$image['path']);
              $o['img'] =  $currentHostUrl.$image['path'];
          }

          $o['images'] = $featured_images;

        }

        if(!isset($o['img'])){
           // $o['img'] = 'http://www.getmdl.io/assets/demos/welcome_card.jpg';
        }

        $rlist[] = $o;
    }

    $response['data'] = $rlist;
    return $response;

});



Route::get('a/follow/{org_id}/{group_type}/{group_id}/{circle}{user_id}', function ($org_id,$group_type,$group_id,$circle,$user_id) {


    $response =[];

    $member = Olabs\Tenant\Models\Members::where(['org_id'=>$org_id,'user_id'=>$user_id,'group_type'=>$group_type,'group_id'=>$group_id,'circle'=>$circle])->first();

    if(!$member){
        $member = new Olabs\Tenant\Models\Members();
        $member->org_id = $org_id;
        $member->user_id = $user_id;
        $member->group_type = $group_type;
        $member->group_id = $group_id;
        $member->circle = $circle;
        $member->status = '200';
        $member->save();

    }

    return array('member'=>$member);

});


Route::get('a/unfollow/{org_id}/{group_type}/{group_id}/{circle}{user_id}', function ($org_id,$group_type,$group_id,$circle,$user_id) {

    $response =[];

    $status = Olabs\Tenant\Models\Members::where(['org_id'=>$org_id,'user_id'=>$user_id,'group_type'=>$group_type,'group_id'=>$group_id,'circle'=>$circle])->delete();


    return array('s'=>'200','data'=>$status);

});




Route::get('a/contact', function () {



    $vars = Input::all();

    Mail::send('olabs.tenant::mail.contact', $vars, function($message) {

        $message->to('lokendra@opaclabs.com', 'Admin Person');
        //$message->cc('lokendra@opaclabscom','Support');
        $message->subject('This is a reminder');

    });
    return 'Mail Sent!';

});