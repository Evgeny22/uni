@if ($page == 'video-center' || $page == 'video' || $page == 'learning-module' || $page == 'learning-modules')
<script src="https://static.wistia.com/javascripts/upload_widget.js"></script>
<script src="//fast.wistia.com/assets/external/api.js" async></script>
{{--
<link rel="stylesheet" href="//fast.wistia.com/assets/external/uploader.css" />
--}}
<link rel="stylesheet" href="{{ app('request')->root() }}/css/wistia-uploader.css" />
{{--<script>--}}
    {{--window._wq = window._wq || [];--}}
    {{--_wq.push({--}}
        {{--id: "e1hg34oi29",--}}
        {{--onHasData: function(video) {--}}
            {{--video.plugin('midrollLink-v1', function(annotation) {--}}
                {{--// add a single annotation like this--}}
                {{--annotation.addLink({--}}
                    {{--time: 5,--}}
                    {{--duration: 3,--}}
                    {{--text: "I'm a dynamic annotation."--}}
                {{--});--}}
                {{--// or add a bunch like this--}}
                {{--annotation.setLinks(annotation.getLinks().concat([--}}
                    {{--{--}}
                        {{--time: 10,--}}
                        {{--duration: 3,--}}
                        {{--text: "I'm another dynamic annotation.",--}}
                        {{--url: "https://wistia.com"--}}
                    {{--}--}}
                {{--]));--}}
            {{--});--}}
        {{--}--}}
    {{--});--}}
{{--</script>--}}
{{--<script src="//fast.wistia.com/assets/external/E-v1.js" async></script>--}}
<script charset="ISO-8859-1" src="//fast.wistia.com/assets/external/E-v1.js" async></script>
@endif
