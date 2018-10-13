<?php

namespace Joesama\Entree\Http\Controller;

class Entrance extends Controller
{
    /**
     * Displaying landing page.
     *
     * @return mixed
     **/
    public function getIndex()
    {
        $announcer = \Joesama\Entree\Facades\Announcer::notify();

        return  $this->viewMain(compact('announcer'));
    }

    /**
     * change language.
     *
     **/
    public function changeLange($lang)
    {
        $sessionLang = 'lang'.str_replace('.', '', app(\Joesama\Entree\Entity\IpOrigin::class)->ipOrigin());

        session([$sessionLang => $lang]);

        return redirect(url()->previous());
    }

    /**
     * Landing Page View.
     *
     * @return view
     **/
    public function viewMain($data)
    {
        return view('joesama/entree::entree.index', $data);
    }
}
