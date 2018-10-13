<?php

namespace Joesama\Entree\Http\Controller\Audit;

use Illuminate\Http\Request;
use Joesama\Entree\Http\Controller\Controller;
use Joesama\Entree\Http\Processor\Audit\AuditAccessManager;

class AuditAccess extends Controller
{
    public function __construct(AuditAccessManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Audit Trail User Access.
     **/
    public function accessUser(Request $request)
    {
        $table = $this->manager->listAuditAccess($request);

        return view('joesama/entree::entree.datagrid.list', compact('table'));
    }

    /**
     * undocumented function.
     *
     * @return void
     *
     * @author
     **/
    public function auditData(Request $request)
    {
        return $this->manager->retrieveAccessAudit($request);
    }
}
