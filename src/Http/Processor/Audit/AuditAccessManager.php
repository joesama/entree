<?php

namespace Joesama\Entree\Http\Processor\Audit;

use Joesama\Entree\Database\Model\UserAccessTrails;
use VueGrid;

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
            ['field' => 'user.fullname', 'title' => trans('joesama/entree::entree.audit.grid.user'), 'style' => 'text-left'],
            ['field' => 'ip', 'title' => trans('joesama/entree::entree.audit.grid.ip'), 'style' => 'text-left'],
            ['field' => 'method', 'title' => trans('joesama/entree::entree.audit.grid.method'), 'style' => 'text-left'],
            ['field' => 'path', 'title' => trans('joesama/entree::entree.audit.grid.uri'), 'style' => 'text-center'],
            ['field' => 'created_at', 'title' => trans('joesama/entree::entree.audit.grid.date'), 'style' => 'text-left'],
        ];

        $grid = new VueGrid();
        $grid->setColumns($columns);
        $grid->setModel($this->retrieveAccessAudit($request));
        $grid->apiUrl(handles('joesama/entree::audit/data'));
        // $grid->action([
        //         [ 'action' => trans('joesama/entree::datagrid.buttons.edit') ,
        //           'url' => handles('joesama/entree::user'),
        //           'icons' => 'fa fa-pencil',
        //           'key' => 'id'  ],
        //         // [ 'action' => trans('joesama/entree::datagrid.buttons.reset-pwd') ,
        //         //   'url' => handles('joesama/entree::user/reset'),
        //         //   'icons' => 'fa fa-key',
        //         //   'key' => 'id'   ],
        //         // [ 'delete' => trans('joesama/entree::datagrid.buttons.delete') ,
        //         //   'url' => handles('joesama/entree::user/delete/'),
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
