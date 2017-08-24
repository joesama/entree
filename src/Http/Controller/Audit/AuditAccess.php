<?php 
namespace Threef\Entree\Http\Controller\Audit;

use Illuminate\Http\Request;
use Threef\Entree\Http\Processor\Audit\AuditAccessManager;
use Threef\Entree\Http\Controller\Controller;

class AuditAccess extends Controller
{

    public function __construct(AuditAccessManager $manager)
    {
        $this->manager = $manager;
    }


    /**
     * Audit Trail User Access
     **/
    public function accessUser(Request $request)
    {

        $table = $this->manager->listAuditAccess($request);

        return view('threef/entree::entree.datagrid.list',compact('table'));
    }


    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    public function auditData(Request $request)
    {
        return $this->manager->retrieveAccessAudit($request);
    }

}
