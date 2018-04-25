<?php

namespace Threef\Entree\Event\Listener\Presenter;

use Orchestra\Contracts\Html\Table\Grid as TableGrid;

class EntreeUserGridAction
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
     * Handle User List Grid Event.
     *
     * @param threef.user.profile $event
     *
     * @return void
     */
    public function handle($table)
    {
        return $table->extend(function (TableGrid $table) {
            $table->find('actions')
                ->label('')
                ->escape(false)
                ->headers(['class' => 'th-action'])
                ->attributes(function () {
                    return ['class' => 'th-action  text-center'];
                })
                ->value($this->getActionsColumn());
        });
    }

    /**
     * Get actions column for table builder.
     *
     * @return callable
     */
    protected function getActionsColumn()
    {
        return function ($row) {
            $btn = [];

            $edit = trans('entree::button.edit');

            $btn[] = app('html')->link(
                handles("threef::user/{$row->id}"),
                trans('entree::entree.button.update'),
                [
                    'class'   => 'btn btn-xs btn-warning',
                    'role'    => 'edit',
                    'data-id' => $row->id,
                ]
            );

            $btn[] = app('html')->link(
                handles("threef::user/reset/{$row->id}"),
                trans('entree::entree.button.reset'),
                [
                    'class'   => 'btn btn-xs btn-info',
                    'role'    => 'reset',
                    'data-id' => $row->id,
                ]
            );

            if (\Auth::user()->isAdmin) {
                $btn[] = app('html')->link(
                    handles("orchestra::users/{$row->id}/delete", ['csrf' => true]),
                    trans('entree::entree.button.delete'),
                    [
                        'class'   => 'btn btn-xs btn-danger',
                        'role'    => 'delete',
                        'data-id' => $row->id,
                    ]
                );
            }

            return app('html')->create(
                'div',
                app('html')->raw(implode('', $btn)),
                ['class' => 'btn-group']
            );
        };
    }
}
