<?php namespace Lambda\Model;

use CodeIgniter\Model as BaseModel;

class Model extends BaseModel
{
    public function pagination(int $perPage = 10)
    {
        $request = \Config\Services::request();
        $page = $request->getGetPost('page');
        $page =  $page ? $page : 1;

        $offset      = ($page - 1) * $perPage;
        $total = $this->countAllResults(false);
        $last_page = ceil($total/$perPage);

        $next_page = $last_page;
        $prev_page = 0;
        $current_page=$page*1;
        if($current_page >= 2){
            $prev_page = $current_page-1;
        }
        if($current_page < $last_page){
            $next_page = $current_page+1;
        }

        $data = [
            "data"=>$this->findAll($perPage, $offset),
            "limit"=>$perPage,
            "offset"=>$offset,
            "total"=>$total,
            "current_page"=>$current_page,
            "last_page"=>$last_page,
            "prev_page"=>$prev_page,
            "next_page"=>$next_page,
        ];

        return $data;
    }
}
