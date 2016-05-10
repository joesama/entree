@inject('user', 'Illuminate\Contracts\Auth\Authenticatable')
<nav class="navbar navbar-inverse navbar-static-top">
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                    <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
                    3FRSB - PSS
                    <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                </a>
                
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                @unless(is_null($user))
                <ul class="nav navbar-nav pull-right">
                    <li class=" dropdown"><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    {{ strtoupper($user->fullname) }}
                    <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li>
                                <div class="col-md-12 text-center">
                                    <div class="media">
                                        <img class="dp img-circle" style="width: 100px;height:100px;" src="data:image/png;base64,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"/>
                                        
                                        <div class="media-body">
                                            <h4 class="media-heading"><small>{{ $user->fullname }}</small></h4>
                                            <h5><small>
                                                @foreach ($user->roles() as $role)
                                                {{ $role->name }}
                                                @endforeach

                                            at <a href="http://3fresources.com">3FRSB</a></small></h5>
                                        </div>
                                    </div> 
                                </div>
                                <div class="clearfix">&nbsp;</div>
                                </li>
                                <li class="divider"></li> 
                                <li><a href="{!! handles('threef::password') !!}">
                                    <span class="glyphicon glyphicon-user glyphicon-white" aria-hidden="true"></span>&nbsp;&nbsp;
                                    {{ trans('orchestra/foundation::title.account.password') }}
                                </a></li>  
                            </ul>
                    </li>                 
                    <li class=""><a href="{!! handles('threef::logout') !!}">
                        <span class="glyphicon glyphicon-user glyphicon-log-out" aria-hidden="true"></span>&nbsp;&nbsp;
                        {{ trans('orchestra/foundation::title.logout') }}
                    </a></li>
                </ul>
                @endunless
            </div>
        </div>
    </div>
</nav>