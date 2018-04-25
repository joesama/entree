<?php

namespace Threef\Entree\Http\Processor\Audit;

use Threef\Entree\Database\Model\UserAccessTrails;
use Threef\Entree\Services\DataGrid\VueDatagrid;

/**
 * undocumented class.
 *
 * @author
 **/
class AuditAccessManager
{
    /**
     * undocumented function.
     *
     * @return void
     *
     * @author
     **/
    public function listAuditAccess($request)
    {
        $columns = [
            ['field' => 'user.fullname', 'title' => trans('threef/entree::entree.audit.grid.user'), 'style' => 'text-left'],
            ['field' => 'ip', 'title' => trans('threef/entree::entree.audit.grid.ip'), 'style' => 'text-left'],
            ['field' => 'method', 'title' => trans('threef/entree::entree.audit.grid.method'), 'style' => 'text-left'],
            ['field' => 'path', 'title' => trans('threef/entree::entree.audit.grid.uri'), 'style' => 'text-center'],
            ['field' => 'created_at', 'title' => trans('threef/entree::entree.audit.grid.date'), 'style' => 'text-left'],
        ];

        $grid = new VueDatagrid();
        $grid->setColumns($columns);
        $grid->setModel($this->retrieveAccessAudit($request));
        $grid->apiUrl(handles('threef/entree::audit/data'));
        // $grid->action([
        //         [ 'action' => trans('threef/entree::datagrid.buttons.edit') ,
        //           'url' => handles('threef/entree::user'),
        //           'icons' => 'fa fa-pencil',
        //           'key' => 'id'  ],
        //         // [ 'action' => trans('threef/entree::datagrid.buttons.reset-pwd') ,
        //         //   'url' => handles('threef/entree::user/reset'),
        //         //   'icons' => 'fa fa-key',
        //         //   'key' => 'id'   ],
        //         // [ 'delete' => trans('threef/entree::datagrid.buttons.delete') ,
        //         //   'url' => handles('threef/entree::user/delete/'),
        //         //   'icons' => 'fa fa-trash',
        //         //   'key' => 'id'  ]
        //     ],TRUE);

        return $grid->build();
    }

    /**
     * Prepare all audit data.
     *
     * @return void
     *
     * @author
     **/
    public function retrieveAccessAudit($request)
    {
        $search = $request->get('search');

        $access = UserAccessTrails::when($search,
        function ($query) use ($search) {
            return $query->where(function ($query) use ($search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('fullname', 'like', '%'.$search.'%');
                })->orWhere('ip', 'like', '%'.$search.'%')
                          ->orWhere('path', 'like', '%'.$search.'%')
                          ->orWhere('created_at', 'like', '%'.$search.'%')
                          ->orWhere('method', 'like', '%'.$search.'%');
            })->orderBy('created_at', 'asc');
        }, function ($query) {
            return $query->whereNotNull('user_id')
                    ->orderBy('created_at', 'desc');
        })->with('user');

        return $access->paginate(100);
    }
} // END class PasswordManager
