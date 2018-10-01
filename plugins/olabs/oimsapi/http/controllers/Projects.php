<?php

namespace Olabs\Oimsapi\Http\Controllers;

use Olabs\Oims\Models\Project;
use Olabs\Oimsapi\Http\Transformers\ProjectTransformer;
use Autumn\Api\Classes\ApiController;
use Illuminate\Http\Request;
use Olabs\Tenant\Models\BaseModel;
use Db;
use Olabs\App\Classes\App;

use BackendAuth;
class Projects extends ApiController
{


    protected $defaultLimit = 50;
     protected $maximumLimit = 50;
    /**
     * Eloquent model.
     *
     * @return \October\Rain\Database\Model
     */
    protected function model()
    {
        return new Project;
    }

    /**
     * Transformer for the current model.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    protected function transformer()
    {
        return new ProjectTransformer;
    }

    /**
     * Display a listing of the resource.
     * GET /api/{resource}.
     *
     * @return Response
     */
    public function index(Request $request )
    {

        BaseModel::$feature_enabled = false;

        $with = $this->getEagerLoad();
        $skip = (int) $this->request->input('skip', 0);
        $limit = $this->calculateLimit();


        $baseModel = new \Olabs\Oims\Models\BaseModel();
        $assigned_projects = $baseModel->getProjectOptions();

        $user = BackendAuth::getUser();
        if (!$user->isAdmin()) {
//            foreach ($user->projects as $project) {
//                $list[$project->id] = $project->name;
//            }
            $list = $user->projects;
        } else {
            $list = Project::where([])->get();
        }
 //$list = Project::all()->get();
        $response = $this->respondWithCollection($list, $skip, $limit);
        BaseModel::$feature_enabled = true;

        return $response;


        $where = ['status'=>'L'];//,'site_domain_code'=>'ehr'];

        $criteria = $this->model->where($where)->where('status','<>','O');;

        

        $criteria->whereIn('profile_type',['his_clinic','his_lab']);

        $items = $limit
            ? $criteria->with($with)->skip($skip)->limit($limit)->get()
            : $criteria->with($with)->get();
        $response = $this->respondWithCollection($items, $skip, $limit);
        BaseModel::$feature_enabled = true;

        return $response;

    }
}
