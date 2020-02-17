<?php
/**
 * Created by PhpStorm.
 * User: SWESWE
 * Date: 2019/9/8
 * Time: 14:07
 */

namespace App\Repositories;

use Exception;
use App\Interfaces\RespositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model;

abstract  class BaseRepository implements RespositoryInterface
{

    private  $app;
    protected  $model;
    public function __construct(Application $app)
    {
        $this->app=$app;
        $this->makeModel();
    }
    public function makeModel(){
        //从容器中解析对象
        if($this->modelname()=='User'){
            $model = $this->app->make('App\\'.$this->modelname());
        }else{
            $model = $this->app->make('App\Models\\'.$this->modelname());
            //instanceof判断一个对象是否是某个类的实例 判断一个对象是否实现了某个接口
            if (!$model instanceof Model)
                throw new Exception("Class {$this->modelname()} 
            must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }
//    /**
//     * @return mixed
//     */
    public function getModel()
    {
        return $this->model;
    }
    abstract public function modelname();
    public function paginate($data = 6)
    {
//        // TODO: Implement paginate() method.
        return $this->model->paginate($data);
    }
    //按条件分页
    public function paginateBy($name, $value, $data = 3)
    {
        // TODO: Implement paginateBy() method.
        return $this->model->where($name,'=',$value)->paginate($data);
    }
    public function paginateByTwo($name, $value, $data = 3)
    {
        // TODO: Implement paginateByTwo() method.
        return $this->model
            ->where($name[0],'=',$value[0])
            ->where($name[1],'=',$value[1])->paginate($data);
    }
    public function dataSelect()
    {
        // TODO: Implement dataSelect() method.
        $res=$this->model->all();
        return $res;
    }

    public function dataAdd(array $data)
    {
        // TODO: Implement dataAdd() method.
        return $this->model->create($data);
    }

    public function findByfirst($field, $value, $columns = array('*'))
    {
        // TODO: Implement findByfirst() method.
        $res=$this->model->where($field,'=',$value)->first($columns);
        return $res;
    }
    public function findByGet($field, $value, $columns = array('*'))
    {
        // TODO: Implement findByGet() method.
        $res=$this->model->where($field,'=',$value)->get($columns);
        return $res;
    }
    //多条价查询
    public function findBy2($field, $value, $columns = array('*'))
    {
        // TODO: Implement findBy2() method.
        $res=$this->model
            ->where($field[0],'=',$value[0])
            ->where($field[1],'=',$value[1])
            ->get($columns);
        return $res;
    }
    public function findBy3($field, $value, $columns = array('*'))
    {
        // TODO: Implement findBy3() method.
        $res=$this->model
            ->where($field[0],'=',$value[0])
            ->where($field[1],'=',$value[1])
            ->where($field[2],'=',$value[2])
            ->get($columns);
        return $res;
    }
    public function findBy4($field, $value, $columns = array('*'))
    {
        // TODO: Implement findBy4() method.
        $res=$this->model
            ->where($field[0],'=',$value[0])
            ->where($field[1],'=',$value[1])
            ->where($field[2],'=',$value[2])
            ->where($field[3],'=',$value[3])
            ->get($columns);
        return $res;
    }
    public function findBy5($field, $value, $columns = array('*'))
    {
        // TODO: Implement findBy5() method.
        $res=$this->model
            ->where($field[0],'=',$value[0])
            ->where($field[1],'=',$value[1])
            ->where($field[2],'=',$value[2])
            ->where($field[3],'=',$value[3])
            ->where($field[4],'=',$value[4])
            ->get($columns);
        return $res;
    }

    public function updateBy($field, $value, $data)
    {
        // TODO: Implement updateBy() method.
        $res=$this->model->where($field,'=',$value)->update($data);
        return $res;
    }

    public function updateBy2($field, $value, $data)
    {
        // TODO: Implement updateBy2() method.
        $res=$this->model->where($field[0],'=',$value[0])->where($field[1],'=',$value[1])->update($data);
        return $res;

    }
    public function updateBy3($field, $value, $data)
    {
        // TODO: Implement updateBy3() method.
        $res=$this->model
            ->where($field[0],'=',$value[0])
            ->where($field[1],'=',$value[1])
            ->where($field[2],'=',$value[2])
            ->update($data);
        return $res;
    }

    public function dataDelete($field, $value)
    {
        // TODO: Implement dataDelete() method.
        $res=$this->model->where($field,'=',$value)->delete();
        return $res;
    }

    public function dataDelete2($field, $value)
    {
        // TODO: Implement dataDelete2() method.
        $res=$this->model->where($field[0],'=',$value[0])->where($field[1],'=',$value[1])->delete();
        return $res;
    }



}