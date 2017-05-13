<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta name="viewport" content="width=device-width" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>@get_meta('title')</title>
  @include('orchestra/foundation::emails.layouts.css')
</head>
<body itemscope itemtype="http://schema.org/EmailMessage">
  <table class="body-wrap">
    <tr>
      <td></td>
      <td class="container" width="600">
        <div class="content">
          <table class="main" width="100%" cellpadding="0" cellspacing="0">
            @if(isset($level) && ! is_null($level))
            <tr>
              <td class="alert alert-{{ $level }}">
                {{ $title }}
              </td>
            </tr>
            @endif
            <tr>
              <td class="content-wrap">
                <table width="100%" cellpadding="0" cellspacing="0">
                  {{-- Logo --}}
                  @unless(is_null($logoUrl = config('app.logo')))
                  <tr>
                    <td class="email-masthead">
                      <a class="email-masthead_name" href="{{ handles('app::/') }}" target="_blank">
                        <img src="{{ $logoUrl }}" class="email-logo" />
                      </a>
                    </td>
                  </tr>
                  @endif

                  {{-- Greeting --}}
                  <tr>
                    <td class="content-block">
                      <p>{{ title_case($greeting) }}</p>
                    </td>
                  </tr>

                  {{-- Intro --}}
                  <tr>
                    <td class="content-block">
                      @foreach($introLines as $line)
                      <p>{{ $line }}</p>
                      @endforeach
                    </td>
                  </tr>

                  {{-- Action --}}
                  @if(isset($actionText))
                  <tr>
                    <td class="content-block" itemprop="handler" itemscope itemtype="http://schema.org/HttpActionHandler">
                      <a href="{{ $actionUrl }}" class="btn btn-primary btn-sm" itemprop="url"  target="_blank">
                        {{ $actionText }}
                      </a>
                    </td>
                  </tr>
                  @endif

                  {{-- Outro --}}
                  <tr>
                    <td class="content-block">
                      @foreach ($outroLines as $line)
                        <p>{{ $line }}</p>
                      @endforeach
                    </td>
                  </tr>

                  {{-- Salutation --}}
                  <tr>
                    <td class="content-block">
                      &mdash; {{ memorize('site.name') }}
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <div class="footer">
            <table width="100%">
              <tr>
                <td class="aligncenter content-block">
                  @section('footer')
                  &copy; {{ date('Y') }} <a href="{!! handles('app::/') !!}">{{ memorize('site.name') }}</a>.
                  @show
                </td>
              </tr>
            </table>
          </div>
        </div>
      </td>
      <td></td>
    </tr>
  </table>
</body>
</html>






