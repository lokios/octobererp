<?php namespace Olabs\Messaging\Models;

use Model;

/**
 * Model
 */
class Template extends BaseModel
{
    use \October\Rain\Database\Traits\Validation;
    
    /**
     * @var array Validation rules
     */
    public $rules = [
        'code' => [
            'required',
            'alpha_dash',
            'between:1,255',
            'unique:olabs_messaging_templates',
        ],
    ];
    
    protected $jsonable = [
        'web_push_template',
        'sms_template',
        'email_template',
        'mobile_push_template',
        ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_messaging_templates';
    
    
    public static function getTemplate($template_code, $tenant_code){
        //get notification template
        $template = Template::where('code', $template_code)->where('tenant_code', $tenant_code)->where('status', self::STATUS_LIVE)->first();
        
        return $template;
    }




    /*
     * Bind notification from templates 
     * Structure :
     *  [
     *      'web_push' => ['title'=> '', 'message' => ''],
     *      'sms' => ['title'=> '', 'message' => ''],
     *      'mobile_push' => ['title'=> '', 'message' => ''],
     *      'email' => ['title'=> '', 'message' => ''],
     * ]
     */
    

    public function bind_template($params) {
        //get notification template
//        $template = Template::where('code', $template_code)->where('tenant_code', $tenant_code)->where('status', self::STATUS_LIVE)->first();
        $template = $this;
        
//        if (!$template) {
//            throw new Exception("Error Processing Request", 403);
//        }
        $notification = [];

        //update notification templates with params
        //WEB_PUSH
        if (isset($template->web_push_template['status']) && $template->web_push_template['status']) {
            $title = isset($template->web_push_template['title']) ? Settings::notification_format($template->web_push_template['title'], $params) : '';
            $message = isset($template->web_push_template['message']) ? Settings::notification_format($template->web_push_template['message'], $params) : '';
            $url = isset($template->web_push_template['url']) ? Settings::notification_format($template->web_push_template['url'], $params) : '';
            $notification['web_push'] = ['title' => $title, 'message' => $message, 'url' => $url];
        }
        

        //SMS
        if (isset($template->sms_template['status']) && $template->sms_template['status']) {
            $title = isset($template->sms_template['title']) ? Settings::notification_format($template->sms_template['title'], $params) : '';
            $message = isset($template->sms_template['message']) ? Settings::notification_format($template->sms_template['message'], $params) : '';
            $notification['sms'] = ['title' => $title, 'message' => $message];
        }

        //MOBILE_PUSH
        if (isset($template->mobile_push_template['status']) && $template->mobile_push_template['status']) {
            $title = isset($template->mobile_push_template['title']) ? Settings::notification_format($template->mobile_push_template['title'], $params) : '';
            $message = isset($template->mobile_push_template['message']) ? Settings::notification_format($template->mobile_push_template['message'], $params) : '';
            $notification['mobile_push'] = ['title' => $title, 'message' => $message];
        }

        //Email
        if (isset($template->email_template['status']) && $template->email_template['status']) {
            $title = isset($template->email_template['title']) ? Settings::notification_format($template->email_template['title'], $params) : '';
            $message = isset($template->email_template['message']) ? Settings::notification_format($template->email_template['message'], $params) : '';
            $notification['email'] = ['title' => $title, 'message' => $message];
        }


        return $notification;
    }
}
