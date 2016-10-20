<?php namespace Threef\Entree\DataGrid;

use Threef\Entree\Database\Model\User;
use Yajra\Datatables\Services\DataTable;

class UsersDataTable extends DataTable
{
    // protected $printPreview  = 'path.to.print.preview.view';

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 
            	'<div class="btn-group">
				  <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    Action <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">
				    <li><a href="{{ handles("threef/entree::user") }}/{!! $id !!}" class="text-primary"><i class="glyphicon glyphicon-edit"></i> ' .trans('threef/entree::entree.user.action.edit'). '</a></li>
				    <li><a href="{{ handles("threef/entree::user/reset") }}/{!! $id !!}" class="text-info"><i class="glyphicon glyphicon-retweet"></i> ' .trans('threef/entree::entree.user.action.reset'). '</a></li>
				    <li><a href="{{ handles("threef/entree::user") }}/{!! $id !!}" class="text-danger"><i class="glyphicon glyphicon-remove-sign"></i> ' .trans('threef/entree::entree.user.action.remove'). '</a></li>
				  </ul>
				</div>'
            	)
            ->editColumn('lastlogin', '{!! date("d-m-Y H:i:s",strtotime($lastlogin)) !!}')
            ->editColumn('created_at', '{!! date("d-m-Y",strtotime($created_at)) !!}')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $users = User::query();//where('id','!=',1);

        return $this->applyScopes($users);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->ajax('')
                    ->addAction(['width' => '80px'])
                    ->parameters([
                        'dom' => 'Bfrtip',
                        'buttons' => ['copy', 'csv', 'pdfHtml5', 'print'],
			        ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    private function getColumns()
    {
        return [
        	['data' => 'id', 'name' => 'id', 'title' => 'Id'],
        	['data' => 'fullname', 'name' => 'fullname', 'title' => trans('threef/entree::entree.user.grid.fullname')],
        	['data' => 'username', 'name' => 'username', 'title' => trans('threef/entree::entree.user.grid.username')],
        	['data' => 'email', 'name' => 'email', 'title' => trans('threef/entree::entree.user.grid.email')],
        	['data' => 'lastlogin', 'name' => 'lastlogin', 'title' => trans('threef/entree::entree.login.lastlogin')],
        	['data' => 'created_at', 'name' => 'created_at', 'title' => trans('threef/entree::entree.user.grid.created')],
        	['data' => 'status', 'name' => 'status', 'title' => trans('threef/entree::entree.user.grid.status')]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'users_'. date('d_m_Y_H_i_s');
    }
}
