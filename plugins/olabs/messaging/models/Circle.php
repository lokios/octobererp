<?php

namespace Olabs\Messaging\Models;

use Model;

/**
 * Model
 */
class Circle extends BaseModel {

    use \October\Rain\Database\Traits\Validation;

    /**
     * @var array Validation rules
     */
    public $rules = [
        'code' => [
            'required',
            'alpha_dash',
            'between:1,255',
            'unique:olabs_messaging_circles',
        ],
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_messaging_circles';
    public $hasMany = [
        'members' => [
            'Olabs\Messaging\Models\CircleMember',
            'key' => 'circle_id',
            'otherKey' => 'user_id'
        ]
    ];

//    public $belongsToMany = [
//        'members' => [
//            'Olabs\Messaging\Models\Circle',
//            'table' => 'olabs_messaging_circle_members',
//            'key' => 'circle_id',
//            'otherKey' => 'user_id'
//        ],
//    ];

    /*
     * Check if circle avaiable for tenant or not 
     * if not then add new
     */

    public static function getCircle($tenant_code, $circle_code = NULL, $circle_title = NULL, $circle_members = NULL) {
        $circle_model = false;

        if ($tenant_code != '' && $circle_code != '') {
            $circle_model = Circle::where('tenant_code', $tenant_code)->where('code', $circle_code)->where('status', self::STATUS_LIVE)->first();
        }

        if (!$circle_model) {
            $circle_model = new Circle();
            $circle_model->tenant_code = $tenant_code;
            $circle_model->code = $circle_code != '' ? $circle_code : $circle_model->generateCircleCode();
            $circle_model->status = self::STATUS_LIVE;
            $circle_model->title = $circle_title;
            $circle_model->save();
        }

        //Add members in circle
//        $circle_members = $this->data['to_users']; 
        if ($circle_members) {
            foreach ($circle_members as $circle_member) {
                $circle_member['circle_id'] = $circle_model->id;
                $circle_model->addMember($circle_member);
            }
        }

//        $circle_model->reload();
//        $circle_model = Circle::where('tenant_code', $tenant_code)->where('code', $circle_code)->where('status', self::STATUS_LIVE)->first();

        return $circle_model;
    }

    public function getCircleMembers($circle_id = NULL) {
        $circle_id = $circle_id ? $circle_id : $this->circle_id;
        $members = CircleMember::where('circle_id', $circle_id)->get();
        return $members;
    }

    /*
     * Add circle Member
     */

    public function addMember($member, $circle_id = NULL) {
        $circle_id = $circle_id > 0 ? $circle_id : $this->id;
        $circle_member = CircleMember::where('circle_id', $circle_id)->where('user_id', $member['user_id'])->first();

        if (!$circle_member) {
            $circle_member = new CircleMember();
            $circle_member->circle_id = $circle_id;
        }
        $circle_member->fill($member);

        $circle_member->save();

        return true;
    }

    /*
     * Remove circle Member
     */

    public function removeMember($user_id, $circle_id = NULL) {
        $circle_id = $circle_id > 0 ? $circle_id : $this->id;
        $circle_member = CircleMember::where('circle_id', $circle_id)->where('user_id', $user_id)->first();

        if ($circle_member) {
            $circle_member->delete();
        }
        return true;
    }

    protected function generateCircleCode() {
        $tenant_code = $this->tenant_code != '' ? $this->tenant_code : uniqid();
        $circle_code = $tenant_code . '_' . time();
        return $circle_code;
    }

    public function transformForApi() {
        $data = $this->toArray();


        return $data;
    }

}
