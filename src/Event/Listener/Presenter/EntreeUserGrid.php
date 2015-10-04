<?php namespace Threef\Entree\Event\Listener\Presenter;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Orchestra\Contracts\Html\Table\Grid as TableGrid;

class EntreeUserGrid
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle User List Grid Event
     *
     * @param  threef.user.profile  $event
     * @return void
     */
    public function handle($eloquent, $table)
    {
        return $table->extend(function (TableGrid $table) {

            $table->layout('entree::layouts.components.table');

            $table->find('fullname')
                ->label(trans('entree::entree.user.grid.fullname'))
                ->value(function($row){
                    return $row->fullname;
                });

            $table->find('email')
                ->label(trans('entree::entree.user.grid.username'))
                ->value(function($row){
                    return $row->username;
                });


            $table->column('role')
                ->label(trans('entree::entree.user.grid.role'))
                ->value($this->getRoleColumn());

            $table->column('email','email')
                ->label(trans('entree::entree.user.grid.email'));
        });
    }


    /**
     * Get role column for table builder.
     *
     * @return callable
     */
    protected function getRoleColumn()
    {
        return function ($row) {
            $roles = $row->roles;
            $value = [];

            foreach ($roles as $role) {
                $value[] = app('html')->create('span', e(strtoupper($role->name)), [
                    'class' => 'label label-success',
                    'role'  => 'role',
                ]);
            }

            return implode('', [
                app('html')->create('span', app('html')->raw(implode(' ', $value)), [
                    'class' => 'meta',
                ]),
            ]);
        };
    }

}
