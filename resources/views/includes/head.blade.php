<meta charset="UTF-8">
<title>{{ $title or 'Coaching UP' }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="token" value="{{ csrf_token() }}">
<link rel="shortcut icon" href="{{ app('request')->root() }}/img/favicon.png"/>
<link class="self-api-url" href="{{ route('api-front') }}" />
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="//oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
<link href="{{ app('request')->root() }}/vendors/animate/animate.min.css" rel="stylesheet">
<link href="{{ app('request')->root() }}/_OLD_css/screen.css" rel="stylesheet">
<link href="{{ app('request')->root() }}/_OLD_css/select2.min.css" rel="stylesheet">
<link href="{{ app('request')->root() }}/_OLD_css/tooltipster.css" rel="stylesheet">
<link href="{{ app('request')->root() }}/css/custom.css" rel="stylesheet">
<link href="{{ app('request')->root() }}/css/app.css" rel="stylesheet">
<script type="text/javascript">
    var APP_URL = {!! json_encode(url('/')) !!};
</script>
<link type="text/css" rel="stylesheet" href="{{ app('request')->root() }}/vendors/daterangepicker/css/daterangepicker.css" />
<link type="text/css" rel="stylesheet" href="{{ app('request')->root() }}/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css"/>
<link type="text/css" rel="stylesheet" href="{{ app('request')->root() }}/vendors/datedropper/datedropper.css">
<link type="text/css" rel="stylesheet" href="{{ app('request')->root() }}/vendors/timedropper/css/timedropper.css">
<link type="text/css" rel="stylesheet" href="{{ app('request')->root() }}/vendors/jquerydaterangepicker/css/daterangepicker.min.css">
<link type="text/css" rel="stylesheet" href="{{ app('request')->root() }}/vendors/clockpicker/css/bootstrap-clockpicker.min.css">
<link type="text/css" rel="stylesheet" href="{{ app('request')->root() }}/css/custom.css">
<link type="text/css" rel="stylesheet" href="{{ app('request')->root() }}/css/datepicker.css">
<style>
    .date-picker-wrapper{z-index:1151 !important;}
</style>