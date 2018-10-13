<?php

namespace Joesama\Entree\Http\Processor;

use Illuminate\Support\Arr;
use Orchestra\Contracts\Authorization\Factory;
use Orchestra\Support\Keyword;
use Joesama\Entree\Database\Model\Role;
use Joesama\Entree\EntreeMenu;

/**
 * undocumented class.
 *
 * @author
 **/
class MenuAccessManager
{
    public function __construct(EntreeMenu $menu, Role $roles, Factory $acl)
    {
        $this->menu = $menu;
        $this->roles = $roles;
        $this->acl = $acl;
    }

    /**
     * Manage User Menu Access.
     *
     * @return void
     **/
    public function menuManager($controller, $request)
    {
        $acl = $this->acl->get('entree');

        $actionRoles = $this->getRolesActions($acl);

        $menu = $this->menu->menu();
        $access = $this->menu->acl();

        $roles = $this->getAclRoles();

        return $controller->viewMain(compact('menu', 'roles', 'access', 'actionRoles'));
    }

    /**
     * Update Manage User Menu Access.
     *
     * @return void
     **/
    public function manageAccess($request)
    {
        $acl = $this->menu->acl();

        $params = $this->getParamsClean($request->except('_token'));

        $actions = $this->getAclActions();
        $roles = $this->getAclRoles();

        if (empty($acl->actions()->get()) && empty($acl->roles()->get())):

            $acl->actions()->attach($actions);
        $acl->roles()->attach($roles);
        $acl->sync();
        endif;

        foreach ($roles as $roleKey => $roleName) {
            foreach ($actions as $actionKey => $actionName) {
                $menu = Keyword::make($actionName)->getSlug();
                $role = Keyword::make($roleName)->getSlug();

                if (!$acl->actions()->has($menu)):
                    $acl->actions()->add($menu);
                endif;

                if (!$acl->roles()->has($role)):
                    $acl->roles()->add($role);
                endif;

                $value = ('yes' === Arr::get($params, "{$menu}_{$role}", 'no'));
                $acl->allow($roleName, $actionName, $value);
            }
        }

        return redirect_with_message(handles('joesama/entree::menu'), trans('joesama/entree::respond.respond.saved'), 'success');
    }

    /**
     * undocumented function.
     *
     * @return void
     *
     * @author
     **/
    protected function getParamsClean($params)
    {
        $result = collect([]);

        foreach ($params as $param => $yes):

            $array = explode('_', $param);
        $role = $array[count($array) - 1];
        array_pop($array);

        foreach ($array as $menu):
                $result->put($menu.'_'.$role, 'yes');
        endforeach;
        endforeach;

        return $result->toArray();
    }

    /**
     * Get All Action For ACL.
     *
     * @return Illuminate\Support\Collection
     **/
    protected function getAclActions()
    {
        $menus = $this->menu->menu();

        $actions = collect([]);

        foreach ($menus as $menu):
            if ($menu->id !== 'home'):
            $action = Keyword::make($menu->id)->getSlug();
        $actions->push($action);

        if (!empty($menu->childs)):
                $this->getAclChildActions($menu->childs, $actions);
        endif;

        endif;
        endforeach;

        return $actions;
    }

    /**
     * Proceesing child actions.
     *
     **/
    protected function getAclChildActions($childs, $actions)
    {
        foreach ($childs as $item):
            $action = Keyword::make($item->id)->getSlug();
        $actions->push($action);

        if (!empty($item->childs)):
                $this->getAclChildActions($item->childs, $actions);
        endif;

        endforeach;
    }

    /**
     * Get All Role For ACL.
     *
     * @return Illuminate\Support\Collection
     **/
    protected function getAclRoles()
    {
        return $this->roles->where('id', '!=', 1)->pluck('name', 'id')
                 ->transform(function ($item, $key) {
                     return Keyword::make($item)->getSlug();
                 });
    }

    /**
     * Get Action Priveleges For Roles.
     *
     * @return Illuminate\Support\Collection
     **/
    protected function getRolesActions($acl)
    {
        $actionAvail = collect([]);

        foreach ($acl->actions()->get() as $action) {
            $access = collect([]);

            $roles = $this->getAclRoles();

            foreach ($roles as $roleId => $role) {
                if ($acl->check($role, $action)):
                    $access->push($roleId);
                endif;
            }

            $actionAvail->put($action, $access);
        }

        return $actionAvail;
    }
} // END class MenuAccessManager
