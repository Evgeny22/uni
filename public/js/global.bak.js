$navLink = $("nav ul li");
$navLinkHeight = $("nav ul li").outerHeight();
$navHelpers = $(".nav-helpers");
$navHelpersLink = $navHelpers.find("li");
$header = $("header");
$headerHeight = $header.outerHeight();
$headerName = $(".header-name");
$myName = $('#userName').html();
$myProfilePic = $header.find(".profile-pic").find("img").attr("src");
$headerAlerts = $(".header-alerts");
$options = $(".options");
$sort = $(".sort");
$main = $("main");
$mainZIndex = $main.css("z-index");
$tranisitionDuration = $(".btn").css("transition-duration");
$tranisitionDuration = String($tranisitionDuration);
$tranisitionDuration = $tranisitionDuration.substring(0, $tranisitionDuration.length-1) * 1000;
$dropdown = $(".dropdown");
$dropdownAccount = $(".dropdown-account");
$dropdownAlerts = $(".dropdown-alerts");
$dropdownSort = $(".dropdown-sort");
$popup = $("#popup");
$popupFlash = $("#popup-flash");
$popupError = $("#popup").find(".error");
$pageName = $("body").attr("class");
$currentRouteId = $("body").attr("id");
$wistiaWidget = $("#wistia-upload-widget");
$submitVideo = $("#submit-video");
$submitVideoBtn = $("#submitVideoPost");
$step1 = $(".step-1");
$goBack = $("#go-back");
$selectVideo = $("#select-video");
$timestamp = $(".timestamp");
$timestampMinute = $timestamp.find("input[name='minutes']");
$timestampSeconds = $timestamp.find("input[name='seconds']");
$annotations = $(".annotations");
$editPostArticle = $("article.edit-post");
$editPostArticleForm = $editPostArticle.find("form");
$mySignature = $('#userParticipantImage img.participant')[0].outerHTML;

console.log('Page name: ['+ $pageName +']');
console.log('Current route ID: ['+ $currentRouteId + ']');

// Remove navigation prompt
window.onbeforeunload = null;

// Templates
var templates = {
    // Progress Bars
    'progressbars': {
        'tasks': {
            'empty': '<div>\
                <div class="text-center pb-task" data-task-id="">\
                <span id="task_id" style="display:none"></span>\
                <button type="button" class="btn btn-primary pb-task-edit" id="edit_task">Edit</button>\
                <div class="well" style="margin:20px 0;">\
                <p style="margin: 0 auto;padding: 24px 0;">New Task</p>\
            </div>\
            <button type="button" class="btn btn-danger pb-task-delete" id="delete_task">Delete</button>\
            </div>\
            </div>',
            'add': '<button class="btn btn-success button-circle pb-task-add" data-direction="" style="height:40px;">\
                <i class="ti-plus"></i>\
                </button>'
        }
    },
    // Video Center
    'videocenter': {
        'prompts': {
            'question': '\
    <div class="question">\
        <div class="form-group m-t-10">\
            <p><small class="text-muted"><strong class="question-label"></strong></small></p>\
            <input type="text" name="question[]" value="" class="form-control" />\
        </div>\
    </div>'
        },
        'annotations': {
            'empty': '\
<li class="annotation item success" data-annotation-id="" data-target="" data-start="" data-end="">\
    <div class="annotation-details">\
        <div class="data">\
            <div class="time text-muted">\
                <span class="date-time">\
                    <a class="stamp-link" href="#" data-target="" data-start="" data-end=""></a>\
                </span>\
            </div>\
            <small></small>\
            <div class="form-group" style="margin-top: 10px;">\
                <div class="dropdown">\
                    <button class="btn btn-xs btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">\
                        <span class="glyphicon glyphicon-cog"></span>\
                        <span class="caret"></span>\
                    </button>\
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">\
                        <li><a class="edit-annotation">Edit</a></li>\
                        <li><a class="remove-annotation">Delete</a></li>\
                    </ul>\
                </div>\
                <p class="column-area"></p>\
            </div>\
        </div>\
        </div>\
    </div>\
</li>'
        },
        'columns': {
            'emptyObject': '\
<li class="annotation item success" data-annotation-id="" data-end="" data-start="" data-target="">\
    <div class="dropdown pull-right">\
        <button class="btn btn-xs btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">\
            <span class="glyphicon glyphicon-cog"></span>\
        <span class="caret"></span>\
        </button>\
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">\
            <li><a class="edit-annotation">Edit</a></li>\
            <li><a class="remove-annotation">Delete </a></li>\
            <li role="separator" class="divider"></li>\
            <li><a data-toggle="modal" data-target="#createPromptModal">Create Discussion</a></li>\
        </ul>\
    </div>\
    <div class="annotation-details">\
        <div class="data">\
            <div class="time text-muted">\
                <span class="date-time">\
                    <a class="stamp-link" data-end="" data-start="" data-target="" href="#"></a>\
                </span>\
            </div>\
            <small></small>\
        </div>\
    </div>\
</li>'
        }
    }
};

$(window).load(function() {
    dropdownPosition($headerName,$header,$dropdownAccount,'center'); // Profile dropdown
    dropdownPosition($headerAlerts,$header,$dropdownAlerts,'right'); // Alerts dropdown
    dropdownPosition($sort,$options,$dropdownSort,'center'); // Sort dropdown
});

$(document).ready(function() {
    $(".select-box-multiple").select2();

    /*$(document).on('click', function (e) {
        $('[data-toggle="popover"],[data-original-title]').each(function () {
            //the 'is' for buttons that trigger popups
            //the 'has' for icons within a button that triggers a popup
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                (($(this).popover('hide').data('bs.popover')||{}).inState||{}).click = false  // fix for BS 3.3.6
            }

        });
    });*/

    if ($('img.participant').length) {
        $('img.participant').initial();
    }

    $('textarea').each(function(textarea) {
        var textarea = $(this);

        if (!textarea.hasClass('no-ck-editor') && !textarea.hasClass('is-popup')) {
            /*CKEDITOR.replace(this, {
                extraPlugins: 'uploadcare',
                uploadcare: {
                    multiple: true
                }
            });*/

            if (textarea.hasClass('required')) {
                initTextEditorRequired(this);
            } else {
                initTextEditor(this);
            }
        }
    });

    $popupError.hide();

    $(document).on('click', '.cancel-redirect', function(e) {
        var redirect = $(this).data('redirect');

        e.preventDefault();

        console.log('.cancel-redirect clicked, URL: '+ redirect);

        window.location.replace(redirect);
    });

    $('.form-new-learning').on('submit', function (e) {
        $('#learning-content').attr('value', editor.serialize()['element-0'].value);
    });

    if ($popupFlash.length) {
        $popupFlash.appendTo("body").modal('show');
        $popupFlash.css('z-index', '100000');
    }

    $navLink.on(
        "mouseenter", function () {
            whichNavLink = $(this).index();
            $navHelpersLink.eq(whichNavLink).add($navHelpers).stop(true, true).css("z-index", 99).fadeTo($tranisitionDuration, 1);
        }
    ).on(
        "mouseleave", function () {
            $navHelpersLink.eq(whichNavLink).add($navHelpers).fadeTo($tranisitionDuration, 0, function () {
                $(this).stop(true, true).css("z-index", 1);
            });
        }
    );

    $(".add-comment").find("textarea").on("focus", function () {
        $(this).parent().next(".full").show();
        //console.log($(this).closest("."));
    });

    $headerName.on("click", function (e) {
        e.preventDefault();
        dropdownsToggle($dropdownAccount);
    });

    $sort.on("click", function (e) {
        e.preventDefault();
        dropdownsToggle($dropdownSort);
    });

    $headerAlerts.on("click", function (e) {
        e.preventDefault();
        dropdownsToggle($dropdownAlerts);
    });

    $("[data-trigger]").on("click", function (e) {
        e.preventDefault();
        var popupTrigger = $(this).attr("data-trigger");
        $main.css("z-index", 999);
        $popup.add("." + popupTrigger).show();
        $('body').addClass('popup-open');
        $popupInitialHeight = $popup.find("article:visible").outerHeight();
        $("input[name='document']").val('');

        $('textarea', "." + popupTrigger).each(function(textarea) {
            var textarea = $(this);

            if (textarea.hasClass('is-popup')) {
                //CKEDITOR.replace( this );
                if (textarea.hasClass('required')) {
                    initTextEditorRequired(this);
                } else {
                    initTextEditor(this);
                }
            }
        });

        // Page-specific functionality
        if ($currentRouteId == 'message') {
            if (popupTrigger == 'new-post') {
                $("select.participants").val([]).trigger('change'); // Participants
                $('input[name="title"]').val(''); // Title
                CKEDITOR.instances.description.setData(''); // Description

                // Tags
                $("select#crosscutting").val([]).trigger('change');
                $("select#practices").val([]).trigger('change');
                $("select#coreideas").val([]).trigger('change');
            }
        }

        if ($currentRouteId == 'video-center' || $currentRouteId == 'video') {
            if (popupTrigger == 'new-video') {
                $("select.participants").val([]).trigger('change'); // Participants
                $('input[name="title"]').val(''); // Title
                CKEDITOR.instances.description.setData(''); // Description

                // Tags
                $("select#crosscutting").val([]).trigger('change');
                $("select#practices").val([]).trigger('change');
                $("select#coreideas").val([]).trigger('change');
            } else if (popupTrigger == 'new-document') {
                $('label[for="document"]').html('Choose Document');
                $('input[name="title"]').val('');
            }
        }
    });

    $("[data-trigger-close]").on('click', function(e) {
        e.preventDefault();
        var popupTrigger = $(this).attr("data-trigger-close");
        $main.css("z-index", 1);

        $popup.remove("." + popupTrigger).hide();
    });

    $('article.new-document button[role="submit"]').on('click', function(e) {
        $(this.closest("form")).formvalidate({
            failureMessages: true,
            successMessages: false,
            messageFailureClass: 'div error',
            onSuccess: function (form) {
                return true;
            },
            onFailure: function (form) {
                e.preventDefault();
                return false;
            }
        });

        //e.preventDefault();

        $error = $(this).closest("form").find(".error");

        if ($("input#sd_name").val().length <= 0) {
            $error.show();

            return false;
        } else {
            $('article.new-document form').submit();
        }
    });

    /*$("#search-tags").on("click", function (e) {
        var tags = $("select[name='search_tags[]']").select2('data');
        $tags_titles = "";

        for ($i = 0; $i < tags.length; $i++) {

            $tags_titles += $tags_titles.length > 0 ? "," + tags[$i].text : tags[$i].text;
        }
        if ($tags_titles.length > 0) {
            /!* if( $pageName == 'video')
             window.location = "/video-center?search=true&tags="+$tags_titles.replace(/ /g,"+");
             else if($pageName == 'instructional-design-show')
             window.location = "/instructional-design?search=true&tags="+$tags_titles.replace(/ /g,"+");
             else
             window.location = "?search=true&tags="+$tags_titles.replace(/ /g,"+");*!/
            if ($currentRouteId == 'video') {
                window.location = "/video-center?search=true&tags=" + $tags_titles.replace(/ /g, "+");
            } else if ($currentRouteId == 'instructional-design-show') {
                window.location = "/instructional-design?search=true&tags=" + $tags_titles.replace(/ /g, "+");
            } else {
                window.location = "?search=true&tags=" + $tags_titles.replace(/ /g, "+");
            }
        }
    });*/

    $popup.find(".btn-cancel").on("click", function (e) {
        $('form').trigger('reset');
        closePopup($popup, e, this);
    });

    $popupFlash.find(".btn-cancel").on("click", function (e) {
        closePopup($popupFlash, e, this);
    });

    /* #### EXPAND POPUP CODE BELOW #### */

    $popupInitialWidth = $popup.find("article").width();
    $popupInitialMarginTop = $popup.find("article").css("marginTop");
    $popupInitialMarginBottom = $popup.find("article").css("marginBottom");

    $(".icon-expand").on("click", function (e) {
        $openModal = $popup.find("article:visible");

        e.preventDefault();

        $openModal.toggleClass("expanded");

        if ($openModal.hasClass("expanded")) {
            $animateWidth = $(window).width();
            $animateHeight = $(window).outerHeight();
            $modalMarginTop = 0;
            $modalMarginBottom = 0;

        } else {
            $animateWidth = $popupInitialWidth;
            $animateHeight = $popupInitialHeight;
            $modalMarginTop = $popupInitialMarginTop;
            $modalMarginBottom = $popupInitialMarginBottom;
        }

        $openModal.animate({
            width: $animateWidth,
            height: $animateHeight
        }, 300).css({"overflow": "visible", "marginTop": $modalMarginTop, "marginBottom": $modalMarginBottom});
    });

    /* #### END EXPAND CODE #### */

    if ($("body.profile")) {
        //$("input[name='avatar']").hide();
    }

    apiDir = '';

    // ##### JS THAT APPLIES TO SPECIFIC PAGE

    if ($currentRouteId == 'learning-modules' || $currentRouteId == 'learning-module') {
        apiDir = 'learning-modules';
    }

    if ($currentRouteId == 'instructional-design' || $currentRouteId == 'instructional-design-show') {
        apiDir = 'instructional-design';
    }

    if ($currentRouteId == 'video-center' || $currentRouteId == 'video') {
        apiDir = 'video-center';

        //if ($pageName == 'video') {
        if ($currentRouteId == 'video') {
            // "Stop" the user for interacting with the page until class ".wistia_not_playable_overlay" is not in the page
            //if ($('.wistia_responsive_padding').find('.wistia_not_playable_overlay').length > 0) {
            //var msgAlert = null;
            var checkStopInterval = setInterval(function () {
                console.log('checkStop() running...')
                if ($('.wistia_not_playable_overlay').length > 0) {
                    console.log('it is not playable');
                    if ($('.bootbox.modal').length == 0) {
                        var msgAlert = bootbox.alert("Please wait! The video you are uploading is still encoding onto the server. Leaving the page now will interrupt the process and you will need to re-upload the video.");
                    }
                } else {
                    if (typeof msgAlert !== 'undefined') {
                        msgAlert.modal('hide');
                    }
                    clearInterval(checkStopInterval);
                }
            }, 500);
            //}

            $timeline = $("#timeline");

            timelineWidth = $timeline.outerWidth;

            // Wait 1.5 seconds for Wistia to load
            setTimeout(function() {
                wistiaVideo = Wistia.api("vc-video");

                timelineTicks = _.uniq(_.pluck(annotations, "time_start"));

                wistiaVideo.ready(function () {
                    console.log("wistiaVideo.ready fired");
                });

                wistiaVideo.hasData(function () {
                    var videoDuration = wistiaVideo.duration();

                    window.videoDuration = videoDuration;

                    _.each(annotations, function(annotation) {
                        var timeStart = secondsToTime(annotation.time_start),
                            timeEnd = secondsToTime(annotation.time_end),
                            timeSum = annotation.time_start + annotation.time_end;

                        $timeline.find("ul").append('<li title="' + timeStart[0] + ':' + timeStart[1] + ' - ' + timeEnd[0] + ':' + timeEnd[1] +'" style="left:' + (((timeStart[0] + timeStart[1]) / videoDuration) * 100) + '%;" class="stamp-link" data-start="' + annotation.time_start + '" data-end="' + annotation.time_end + '"><a href="#">|</a></li>');
                    });

                    $timeline.find("ul").children("li").each(function () {
                        if ($(this).attr('title')) {
                            $(this).tooltipster();
                        }
                    });

                    wistiaVideo.bind("secondchange", function (t) {


                        /* var left = (t / wistiaVideo.duration()) * 100;

                         var left = Math.round(left);

                         var left = (left / 3) + left;
 */
                        //var left = wistiaVideo.percentWatched() * 100;

                        /*if (left > 30) {
                            left = left - 15;
                        }*/

                        //var left = ((t / wistiaVideo.duration()) * 100);

                        var left = (t / wistiaVideo.duration()) * 125;

                        console.log('wistia.secondchange called, time: ['+ t +'], left: ['+ left +']');

                        $("#timeline__playhead").stop(true, true).animate({"left": left + "%"}, 750);
                    });

                    wistiaVideo.bind("end", function () {
                        console.log('wistia.end called');

                        $("#timeline__playhead").stop(true, true).animate({"left": "0%"}, 750);
                    });

                    var playVideoHtml = '<button class="btn btn-success btn-xs pull-right video-btn play-video" style="margin-bottom: 2px;">\
                        <i class="ti-control-play"></i> Play Video\
                    </button>',
                        pauseVideoHtml = '<button class="btn btn-danger btn-xs pull-right video-btn pause-video" style="margin-bottom: 2px;">\
                        <i class="ti-control-pause"></i> Pause Video\
                    </button>';

                    wistiaVideo.bind("play", function() {
                        // Change button in Annotations section to "Pause"
                        $('.video-btn').replaceWith(pauseVideoHtml);
                    });

                    wistiaVideo.bind("pause", function() {
                        // Change button in Annotations section to "Play"
                        $('.video-btn').replaceWith(playVideoHtml);
                    });

                    var annotationsAsc = annotations
                        .sort(function (obj1, obj2) {
                            /*var total1 = obj1.created_at, //obj1.time_start + obj1.time_end,
                                total2 = obj2.created_at; //.time_start + obj2.time_end;

                            return total2 - total1;*/

                            //console.log('Comparing ', obj2, ' with ', obj1);

                            return new Date(obj2.created_at) - new Date(obj1.created_at);
                        });

                    var $videoColumnSelect = $('<select class="form-control select2 select-column" style="max-width: 90%;display:block;margin-top: 2px;margin-bottom: -12px;">');

                    // Add default "Please Select" option
                    $('<option value="0">-- Choose Column --</option>').appendTo($videoColumnSelect);

                    if (videoColumns.length > 0) {
                        _.each(videoColumns, function (videoColumn) {
                            $('<option value="' + videoColumn.id + '">' + videoColumn.name + '</option>').appendTo($videoColumnSelect);
                        });
                    } else {
                        var $videoColumnSelect = $('<button class="button btn-success button-royal-flat btn-xs pull-left new-col-from-annotation" data-toggle="modal" data-target="#addColumnModal" style="margin: 6px;">Create New Column</button>');
                    }

                    if (annotationsAsc.length > 0) {
                        for (var i = 0; i < annotationsAsc.length; i++) {
                            var currentAnnotation = annotationsAsc[i],
                                annotationTime = secondsToTime(currentAnnotation.time),
                                startTime = secondsToTime(currentAnnotation.time_start),
                                endTime = secondsToTime(currentAnnotation.time_end);

                            // Grab template
                            var template = $(templates.videocenter.annotations.empty);

                            // Add data to annotation
                            template
                                .attr('data-annotation-id', currentAnnotation.id)
                                .attr('data-start', currentAnnotation.time_start)
                                .attr('data-end', currentAnnotation.time_end);

                            $('div.annotation-details span.date-time a.stamp-link', template)
                                .attr('data-start', currentAnnotation.time_start)
                                .attr('data-end', currentAnnotation.time_end)
                                .html('@ '+ startTime[0] +':'+ startTime[1] +' - '+ endTime[0] +':'+ endTime[1]);

                            $('div.data small', template).html(currentAnnotation.content);

                            $('p.column-area', template).html($videoColumnSelect[0].outerHTML);

                            $annotations.append(template);

                            /*$annotations.append('\
                        <li class="annotation item success" data-annotation-id="'+ currentAnnotation.id +'" data-target="' + currentAnnotation.time + '" data-start="'+ currentAnnotation.time_start +'" data-end="'+ currentAnnotation.time_end +'" class="stamp-link">\
                                <div class="annotation-details">\
                                <div class="data"><div class="time text-muted"> <span class="date-time"><a href="#" data-target="' + currentAnnotation.time + '" data-start="'+ currentAnnotation.time_start +'" data-end="'+ currentAnnotation.time_end +'">@' + startTime[0] + ':' + startTime[1] + ' - '+ endTime[0] +':'+ endTime[1] +'</a></span></div>\
                        <small>' + currentAnnotation.content + '</small>\
                        <div class="form-group" style="margin-top: 10px;"><div class="btn-group" role="group" aria-label="Actions"><button class="btn btn-info btn-xs edit-annotation" type="button" title="Edit">Edit </button><button class="btn btn-danger btn-xs remove-annotation" type="button" title="Delete" data-trigger="remove-annotation">Delete</button>\
                                </div>\
                                <p class="column-area">'+ $videoColumnSelect[0].outerHTML +'\</p>\
                            </div>\
                        </div>\
                            </div>\
                        </div></li>');*/

                        }
                    }
                });
            }, 1500);
        } else if ($currentRouteId == 'video-center') {
            // Fetch video thumbnails
            $('.wistia-thumbnail').each(function(i) {
                var $e = $(this),
                    hashedId = $e.data('wistiaHashedId');

                if (hashedId) {
                    $.get('http://fast.wistia.net/oembed?url=http://home.wistia.com/medias/' + hashedId + '?embedType=async&videoWidth=375&videoHeight=375', function (response) {
                        var imgUrl = response.thumbnail_url;// +'&'+ 'image_resize=450';
                        $e.attr('src', imgUrl);
                    })
                }
            })
        }
    }

    if ($currentRouteId == 'message' || $currentRouteId == 'dashboard') {
        apiDir = 'messages';
    }

    if ($currentRouteId == 'resource' || $currentRouteId == 'resources' || $currentRouteId == 'resources_category') {
        apiDir = 'resources';
    }

    window.annotationStartTimeFilled = false;

    /**
     * Video Center
     * Play video from X until Y on click
     */
    $(document).on('click', '.stamp-link, div.annotation-details small', function (e) {
        e.preventDefault();

        console.log('.stamp-link clicked!');

        var seekStart = $(this).data('start'),
            seekEnd = $(this).data('end');

        wistiaVideo.time(seekStart);

        wistiaVideo.play();

        wistiaVideo.bind("secondchange", function(s) {
            console.log('wistia.secondchange called');

            if (s === seekEnd) {
                wistiaVideo.pause();
            }
        });
    });

    /**
     * Annotation label
     */
    $('body').on('click', 'input[name="no_column"]', function(e) {
        var val = $(this).val();

        if ($(this).is(':checked')) {
            $('input[name="column_color"]').prop('disabled', true);
        } else {
            $('input[name="column_color"]').prop('disabled', false);
        }
    });

    /* When a user clicks on "Create New Column" from the annotations list, pass the annotation ID */
    $('body').on('click', '.new-col-from-annotation', function(e) {
        // Get annotation ID
        var annotationId = $(this).closest('li.annotation').data('annotationId');

        $('#addColumnModal input[name="annotation_id"]').val(annotationId);

        console.log('Annotation ID: ', annotationId);
    });

    /** If the user clicks on "Create New Column" (not in an annotation) clear the annotaiton ID just to be safe. */
    $('body').on('click', '.new-col', function(e) {
        $('#addColumnModal input[name="annotation_id"]').val('');
    });

    /**
     * When a user starts typing, get the current time and inject in form
     */

    $('.annotation-text').on('click', function(e) {
        // Shortcuts to "Start" time
        var startMinutes = $('.minutes_start'),
            startSeconds = $('.seconds_start');

        // Pause video
        //wistiaVideo.pause();

        // Get current video time
        var seconds = wistiaVideo.time();

        // Convert to minutes and seconds
        var time = secondsToTime(seconds);

        console.log(time);

        if (!window.annotationStartTimeFilled) {
            window.annotationStartTimeFilled = true;

            startMinutes.val(time[0]);
            startSeconds.val(time[1]);
        }
    });

    /**
     * Video buttons
     */
    $('body').on('click', '.play-video', function(e) {
        e.preventDefault();

        wistiaVideo.play();
    });

    $('body').on('click', '.pause-video', function(e) {
        e.preventDefault();

        // Shortcuts to "End" time
        var endMinutes = $('.minutes_end'),
            endSeconds = $('.seconds_end');

        wistiaVideo.pause();

        // Get current video time
        var seconds = wistiaVideo.time();

        // Convert to minutes and seconds
        var time = secondsToTime(seconds);

        console.log(time);

        endMinutes.val(time[0]);
        endSeconds.val(time[1]);
    });

    $("#change-avatar").on("click", function (e) {

        //e.preventDefault();
        //$("input[name='avatar']").toggle();

    });

    /*$("select[name='search-by-title-and-author']").select2({
        placeholder: window.location.pathname.search("resource") == 1 || window.location.pathname.search("learning") == 1 ? "Search By Title" : "Search By Title Or Author",
        multiple: true,
        delay: 250,
        minimumInput: 3,
        templateResult: returnTitleAndAuthorTemplate,
        ajax: {
            url: jQuery('.self-api-url').attr('href') + '/' + apiDir
        }
    });

    $("select[name='search-by-title-and-author']").on("select2:selecting", function (e) {
        window.location = e.choice.url;
    });*/

    $("select.participants").select2({
        placeholder: 'Participants',
        multiple: true,
        delay: 250,
        templateResult: returnParticipantTemplate,
        ajax: {
            url: jQuery('.self-api-url').attr('href') + '/participants'
        }
    });

    //if ($currentRouteId == 'video-center') {
    $("select.search-by-author").select2({
        placeholder: "Search By Author",
        multiple: true,
        templateResult: returnAuthorTemplate,
        ajax: {
            url: jQuery('.self-api-url').attr('href') + '/video-center/search-author'
        }
    });
    /*} else {
        $("select.search-by-author").select2({
            placeholder: "Search By Author",
            multiple: true,
            delay: 250,
            minimumInput: 3,
            templateResult: returnAuthorTemplate,
            ajax: {
                url: jQuery('.self-api-url').attr('href') + '/' + apiDir
            }
        });
    }*/

    $("select.recipient").select2({
        placeholder: 'Recipient',
        multiple: false,
        delay: 250,
        templateResult: returnParticipantTemplate,
        ajax: {
            url: jQuery('.self-api-url').attr('href') + '/participants'
        }
    });

    $("select.tags").select2({
        placeholder: 'Search by Tags',
        multiple: true,
        delay: 250,
        templateResult: returnTagTemplate,
        ajax: {
            url: jQuery('.self-api-url').attr('href') + '/tags'
        }
    });

    $('.profile-pic img').each(function () {
        if ($(this).attr('title')) {
            $(this).tooltipster();
        }
    });

    /******************************************************************
     * Upload Video functionality
     ******************************************************************/

    window.videoCanBeUploaded = false;

    $submitVideoBtn.on('click', function(e) {
        e.preventDefault();

        var form = $(this).closest('.form');

        for (var instanceName in CKEDITOR.instances) {
            CKEDITOR.instances[instanceName].updateElement();
        }

        /*// Check if description has content
        var description = CKEDITOR.instances.description.getData(),
            descText = $('<p>'+ description +'</p>').text();

        console.log('Desct tet=xt: ['+ descText +']');

        if (descText == '') {
            console.log('its empty');
            $('#submit-video .errors').append('<div class="error" id="description">Description is required.</div>');

            //return false;
        } else {
            if ($('#submit-video .errors #description').length) {
                $('#submit-video .errors #description').remove();
            }
        }*/

        $(this.closest("form")).formvalidate({
            failureMessages: true,
            successMessages: false,
            messageFailureClass: 'error',
            preProcess: function() {
                console.log('Num select: '+ $('#submit-video select').length);
            },
            onSuccess: function (form) {
                window.videoCanBeUploaded = true;

                //form.submit();

                return true;
            },
            onFailure: function (form) {
                e.preventDefault();

                scrollPopupToTop($('#popup'));

                return false;
            }
        });

        //console.log(validate);

        //e.preventDefault();

        /*$error = $(this).closest("form").find(".error");

        if ($submitVideo.find("input[name='title']").val().length <= 0) {
            $error.show();

            return false;
        } else {
            window.videoCanBeUploaded = true;
        }*/
    });

    /* WISTIA UPLOAD WIDGET */
    if ($("#wistia-upload-widget").length) {
        var cvTimeout = null;

        window._wapiq = window._wapiq || [];
        _wapiq.push(function (W) {
            window.wistiaUploader = new W.Uploader({
                accessToken: "dffca5c0912d08121ef5c0fe11be4fd14f77dd1a13867d1aa05c02b75fb4e8ae",
                //dropIn: "wistia-upload-widget",
                button: "wistia-upload-widget",
                projectId: "e7h8i69p8q",
                allowNonVideoUploads: false,
                videoExtensions: 'mp4 mp3 avi wmv mov mkv',
                beforeUpload: function(file) {
                    console.log('beforeUpload: ', file);
                    $('#selected-video').html('You have selected: <strong>'+ file.name +'</strong> [<a id="cancel-upload">Remove / Choose Another Video</a>]');
                    $('.wistia_upload_button_text').html('Waiting to upload');
                    //$('.wistia_upload_button').hide();

                    var promise = new Promise(function(resolve, reject) {
                        setInterval(function() {
                            //wistiaUploader.setFileName('myfile');
                            //resolve();

                            if (window.videoCanBeUploaded) {
                                clearTimeout(cvTimeout);
                                console.log('Uploading!');
                                resolve();
                            } else {
                                console.log('Not uploading yet...');
                            }
                        }, 1000);
                    });
                    return promise;
                }
            });

            $('.wistia_upload_button_text').html('Choose Video');

            $('body').on('click', '#cancel-upload', function(e) {
                e.preventDefault();

                window.wistiaUploader.cancel();
            });

            window.wistiaUploader.bind('uploadsuccess', function (file, media) {

                var wistia_thumbnail = media.thumbnail.url;
                var wistia_thumbnail_original = wistia_thumbnail.split("?");

                $submitVideo.find("form").prepend('<input type="hidden" name="wistia_id" value="' + media.id + '"><input type="hidden" name="wistia_hashed_id" value="' + media.id + '"><input type="hidden" name="wistia_duration" value="' + Math.floor(media.duration) + '"><input type="hidden" name="wistia_thumbnail" value="' + wistia_thumbnail_original[0] + '">').submit();

            });

            window.wistiaUploader.bind("uploadfailed", function (file, error) {

                bootbox.alert(error);
            });

            window.wistiaUploader.bind("uploadprogress", function (file, progress, error) {
                //progressMessages += 1;

                if ($('#output .progress').size() == 0) {
                    //$('#output').append('<p>uploadProgress: <span class="progress">1</span></p>');
                } else {
                    $('#output span.progress').html(progress.toString());
                }
            });

            window.wistiaUploader.bind("uploadstart", function (file) {

            });

            window.wistiaUploader.bind('uploadcancelled', function(file) {
                $('#selected-video').html('No video has been selected.');

                cvTimeout = setInterval(function() {
                    $('.wistia_upload_button').show();
                    $('.wistia_upload_button_text').html('Choose Video');
                }, 100);
            });

        });
    }

    $(".form-new-message").submit(function (e) {

        $error = $(this).find(".error");
        $participansID = $(this).find("select.participants").select2('data').id;

        $('#message-content').attr('value', CKEDITOR.instances.description.getData());

        if ($(this).find("input[name='title']").val().length <= 0) {

            $error.show();
            return false;

        }

    });

    /**
     * Comment replying/nesting
     */
    $('body').on('click', '.comment-reply', function(e) {
        e.preventDefault();

        var commentId = $(this).data('commentId'),
            comment = $(this).closest('.comment-wrapper'),
            author = $('.author', comment).html(),
            body = $('.timeline-body p', comment).html(),
            parentId = comment.data('parentCommentId');

        console.log({
            commentId: commentId,
            author: author,
            body: body
        });

        // Populate "Reply to..." block
        $('div#reply-to .author').html(author);
        $('div#reply-to .body').html(body);
        $('div#reply-to').show();

        // Inject comment ID into new comment form
        if (parentId != '') {
            commentId = parentId;
        }

        console.log('Parent ID: ', commentId);

        $('.comment-form input.comment_parent_id').val(commentId);

        // Scroll to repy form
        $("html, body").animate({ scrollTop: $("#content").offset().top }, 750);
    });

    $('body').on('click', '.cancel-sub-comment', function(e) {
        e.preventDefault();

        // Remove comment ID from form
        $('.comment-form input.comment_parent_id').val('');

        // Delete "Reply To" data
        $('div#reply-to').hide();
        $('div#reply-to .author').html('');
        $('div#reply-to .body').html('');
    });

    $(".comment-form").submit(function (e) {

        e.preventDefault();

        for (var instanceName in CKEDITOR.instances) {
            CKEDITOR.instances[instanceName].updateElement();
        }

        var $currentForm = $(this);
        var $comment = $currentForm.find("textarea[name='content']");
        var $commentType = $currentForm.find("input[name='type']");
        var $commentParentId = $currentForm.find("input[name='parent_id']");
        var parentId = 0;

        if ($commentParentId.length) {
            parentId = $commentParentId.val();
        }

        if ($commentType.length) {
            $commentType = $commentType.val();
        } else {
            $commentType = null;
        }

        var commentAction = $.trim($currentForm.attr("action"));
        var commentContent = $comment.val();
        var $commentContain = $('div.comments');

        var profilePic = $currentForm.find(".profile-pic").html();

        if ($("input[name='video-comment']").length) {
            commentsExplode = commentContent.split(" ");
            commentContent2 = '';

            for (var i = 0; i < commentsExplode.length; i++) {

                var word = commentsExplode[i];
                commentContent2 += validateVideoStamp(word) + " ";

            }

            commentContent = commentContent2;
        }

        var commentData = {
            content: commentContent,
            '_token': $('meta[name="token"]').attr('value'),
            'type': $commentType,
            'parent_id': parentId
        };

        // Comment Date (for Instructional Design/Lesson Plans)
        if ($("input[name='comment_date']", $currentForm).length) {
            commentData.comment_date = $("input[name='comment_date']", $currentForm).val();
        }

        var subCommentClass = '';

        if (commentContent.length > 0) {

            var postComment = $.ajax({
                url: commentAction,
                method: "POST",
                data: commentData,
                success: function (data) {
                    console.log('Comment saved!');

                    //if ($('.comments').length == 0) {
                    //window.location.reload();
                    //} else {

                    // If it's a subcomment, add the subcomment class
                    if (parentId > 0) {
                        var subCommentClass = 'timeline-subcomment';
                        console.log("THis is a subcomment");

                        $commentContain = $('div.comments ul[data-comment-id="'+ parentId +'"]');
                        console.log('selector: div.comments ul[data-comment-id="'+ parentId +'"]');
                        console.log('Comment parent selector length: ', $commentContain.length)
                    }

                    $commentContain.append('<ul class="timeline-update timeline-comments comment-wrapper '+ subCommentClass +'" data-comment-id="' + data.comment_id + '" id="comment-id-' + data.comment_id + '">\
                            <li>\
                            <div class="timeline-badge center">\
                            <a href="">\
                                ' + $mySignature + '\
                            </a>\
                            </div>\
                            </a>\
                            </div>\
                            <div class="timeline-panel" style="display:inline-block;">\
                            <div class="timeline-heading">\
                            <p>\
                            <small class="text-default-gray">right now ' + $myName + '</small>\
                            </p>\
                            </div>\
                            <div class="timeline-body">\
                            <p>\
                            ' + commentContent + '\
                            </p>\
                            </div>\
                            <div class="timeline-footer">\
                            <div class="btn-group" role="group" aria-label="Actions" style="margin-top: 5px;">\
                            <a class="btn btn-success btn-xs comment-reply" data-comment-id="' + data.comment_id + '" href="#">Reply</a>\
                            <button type="button" class="btn btn-xs btn-action btn-danger delete-comment" data-route="/api/video-center/' + data.comment_id + '/comments" data-comment-id="' + data.comment_id + '">Delete</button>\
                        </div>\
                        </div>\
                        </li>\
                        </ul>');

                    $comment.val("");
                    CKEDITOR.instances.content.setData(''); // Content
                    $('.cancel-sub-comment').click();
                    //}

                },
                error: function (data) {

                    console.log('fail ' + data);

                }

            });

        }

    });

    $(".delete-comment").click(function (e) {
        var $currentForm = $(this);
        var $commentId = $currentForm.data('commentId');
        var $commentRoute = $currentForm.data('route');

        bootbox.confirm({
            title: "Delete comment?",
            message: "Are you sure you want to delete this comment?",
            buttons: {
                cancel: {
                    label: '<span class="glyphicon glyphicon-remove"></span> No',
                    className: 'btn-danger'
                },
                confirm: {
                    label: '<span class="glyphicon glyphicon-ok-sign"></span> Yes',
                    className: 'btn-success'
                }
            },
            callback: function (result) {
                if (result === true) {
                    $.ajax({
                        url: $commentRoute,
                        method: "DELETE",
                        data: {
                            id: $commentId,
                            '_token': $('meta[name="token"]').attr('value'),
                        },
                        success: function (data) {
                            console.log('Comment deleted!');

                            if ($('.comment[data-comment-id="' + $commentId + '"]').length) {
                                $('.comment[data-comment-id="' + $commentId + '"]').remove();
                            } else {
                                $('.comment-wrapper[data-comment-id="' + $commentId + '"]').remove();
                            }
                        },
                        error: function (data) {
                            console.log('fail ' + data);
                        }
                    });
                }
            }
        });

        /*if (confirm('Are you sure you want to delete this comment?')) {
            var deleteComment = $.ajax({
                url: $commentRoute,
                method: "DELETE",
                data: {
                    id: $commentId,
                    '_token': $('meta[name="token"]').attr('value'),
                },
                success: function (data) {
                    console.log('Comment deleted!');

                    if ($('.comment[data-comment-id="' + $commentId + '"]').length) {
                        $('.comment[data-comment-id="' + $commentId + '"]').remove();
                    } else {
                        $('.comment-wrapper[data-comment-id="' + $commentId + '"]').remove();
                    }
                },
                error: function (data) {
                    console.log('fail ' + data);
                }
            });
        }*/
    });

    $("a[data-trigger='video-update']").on("click", function (e) {
        e.preventDefault();

        $closestArticle = $(this).closest("article");
        $post = $closestArticle.find(".post-title a");

        var postUrl = $post.attr("href");

        $wistiaWidget.show();

        $("article.video-update").find("form").attr("action", $.trim(postUrl));
    });

    $(".icon-remove").on("click", function (e) {

        e.preventDefault();
        $post = $(this).closest("article").find(".post-title a");

        var postUrl = $post.attr("href");
        var postTitle = $post.text();
        //$("article.remove-post").find("form").attr("action", postUrl + "/remove").end().find(".remove-post-title").text(postTitle);

    });

    $('.modal').on('show.bs.modal', function(e) {
        console.log('show.bs.modal called');

        // Display selected participants & tags
        setTimeout(function() {
            $("select.participants").trigger('change');
            $("select[name='tags[]']").trigger('change');
        }, 500);
    });

    $(".icon-edit").on("click", function (e) {

        e.preventDefault();

        // Display selected participants & tags
        setTimeout(function() {
            $("select.participants").trigger('change');
            $("select[name='tags[]']").trigger('change');
        }, 500);


        $closestArticle = $(this).closest("article");
        $participants = $editPostArticleForm.find("select[name='participants[]']");
        $resources_types = $editPostArticleForm.find("input[name='resources_types[]']");
        $post = $closestArticle.find(".post-title");
        $tags = $editPostArticle.find("select[name='tags[]']");
        var tags_videos = $editPostArticleForm.find("input[name='tags[]']");

        var postUrl = $post.attr("href");
        var postTitle = $post.text();
        var postMessage = $closestArticle.find(".post-message").html();
        var index = ($editPostArticleForm.index("form")) - 1;
        var zoomUrl = $closestArticle.find(".zoom-url").text();
        var remoteUrl = $closestArticle.find(".remote-url").text();
        var description = $closestArticle.find(".description").text();
        var documentUrl = $closestArticle.find(".document-url").text();

        $editPostArticleForm.find("p[name='current_document']").text("");

        if (zoomUrl.length) {

            $editPostArticleForm.find("input[name='zoom_url']").val($.trim(zoomUrl));
        }
        if (remoteUrl.length) {

            $editPostArticleForm.find("input[name='remote_url']").val($.trim(remoteUrl));
        }
        if (documentUrl.length) {

            $editPostArticleForm.find("input[name='document_hidden']").val($.trim(documentUrl));
            $editPostArticleForm.find("p[name='current_document']").text($closestArticle.find(".document-url").data("name") + " is currently added");
        }

        if (description.length) {

            $editPostArticleForm.find("textarea[name='description']").val($.trim(description));
        }

        //$editPostArticleForm.attr("action", postUrl).end().find("input[name='title']").val($.trim(postTitle));

        if ($('.editable').length) {

            editor.setContent(postMessage, index);

            editor.subscribe('editableInput', function (event, editable) {

            });

        }

        if ($('.select2-selection__choice').length) {
            $('.select2-selection__choice').remove();
        }

        if ($participants.length) {

            //$participants.empty(); //.html("<option value></option>");

            var postUrlParsed = parseURL(postUrl);
            var postUrlParsedPath = postUrlParsed.path;

            console.log('postUrl: '+ postUrl);
            console.log('postUrlParsed: '+ postUrlParsed);
            console.log('postUrlParsedPath'+ postUrlParsedPath);

            /*$.getJSON(jQuery('.self-api-url').attr('href') + '/' + postUrlParsedPath + '/participants', function (data) {

                var participantsList = data;

                $.each(participantsList, function (k, v) {

                    var participantId = v.id;
                    var participantName = v.display_name;

                    $participants.append($("<option value='" + participantId + "' selected>" + participantName + "</option>")).trigger("change");

                });

            });*/

        }

        if ($resources_types.length) {
            var resourceId = $closestArticle.data('id');
            $editPostArticleForm.find("input[name='resources_types[]']").prop('checked', false);

            /*$.getJSON(jQuery('.self-api-url').attr('href') + '/resources/' + resourceId + '/resource_types', function (data) {

                var resource_types = data;

                $.each(resource_types, function (k, v) {

                    var resourceId = v.id;
                    var resourceType = v.type;
                    var resourceCategory = v.category;
                    $("#resources_type_" + resourceId).prop('checked', true);

                });

            });*/

        }

        /*if ($tags.length) {
            $tags.empty(); //.html("<option value></option>");

            var postUrlParsed = parseURL(postUrl);
            var postUrlParsedPath = postUrlParsed.path;

            $.getJSON(jQuery('.self-api-url').attr('href') + '/' + postUrlParsedPath + '/tags', function (data) {

                var tagsList = data;

                $.each(tagsList, function (k, v) {

                    var tagId = v.id;
                    var tagName = v.tag;

                    $tags.append($("<option value='" + tagId + "' selected>" + tagName + "</option>")).trigger("change");

                });

            });

        }*/

        if (tags_videos.length) {
            var videoId = $closestArticle.data('id');
            $editPostArticleForm.find("input[name='tags[]']").prop('checked', false);
            /* $.getJSON(jQuery('.self-api-url').attr('href') + '/' + postUrlParsedPath + '/tags', function (data) {

                 var tagsList = data;

                 $.each(tagsList, function (k, v) {

                     var tagId = v.id;

                     $("#tag_" + tagId).prop('checked', true);

                 });

             });*/
        }

    });

    $editPostArticle.find("form").on("submit", function (e) {
        //e.preventDefault();

        if ($(".editable").length) {

            var index = ($editPostArticleForm.index("form")) - 1;
            var currentContentVal = editor.serialize()['element-' + index + ''].value;
            if ($editPostArticle.find("input[name='content']").length)
                $editPostArticle.find("input[name='content']").val(currentContentVal);
            if ($editPostArticle.find("input[name='description']").length)
                $editPostArticle.find("input[name='description']").val(currentContentVal);

        }
        //$(this)[0].submit();
    });

    $goBack.hide();

    /*$selectVideo.on("click", function (e) {

        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");
        if (/MSIE 10/i.test(navigator.userAgent) || /MSIE 9/i.test(navigator.userAgent) || /rv:11.0/i.test(navigator.userAgent)) {
            // This is internet explorer

        }
        else if (!/Edge\/\d./i.test(navigator.userAgent)) {
            $(this.closest("form")).formvalidate({
                failureMessages: true,
                successMessages: false,
                messageFailureClass: 'div error',
                onSuccess: function (form) {
                    return true;
                },
                onFailure: function (form) {
                    e.preventDefault();
                    return false;
                },
                localization: {
                    en: {
                        failure: {
                            title: function (title, value, name, input) {
                                return 'There is no way that email ' + value + ' is valid.';
                            }
                        }
                    }
                }
            });
        }

        e.preventDefault();

        $error = $(this).closest("form").find(".error");

        if ($submitVideo.find("input[name='title']").val().length <= 0) {

            $error.show();
            return false;

        }

    });*/

    $goBack.on("click", function (e) {

        e.preventDefault();

        $selectVideo.add($step1).show();
        $goBack.add($wistiaWidget).hide();

    });

    $submitVideo.find(".btn-cancel").on("click", function (e) {
        //$wistiaWidget.find("a.cancel").trigger("click");
        window.wistiaUploader.cancel();
    });

    /**
     * Allows for a user to create a new video category on-the-fly
     */
    $submitVideo.find(".category").on("change", function (e) {
        console.log('Category changed!');

        var category = $(this).val();

        console.log('Selected cat: ', category);

        if (category == 'new') {
            console.log('New cat field shown!');

            // Display "New Category" input field
            $('.new_category_name').show();
        } else {
            console.log('New cat field shown!');

            // Hide "New Category" input field
            $('.new_category_name').hide();
        }
    });

    /**
     * Allows for a user to create a new resource category on-the-fly
     */
    $('body').on('change', '.resource_category', function (e) {
        e.preventDefault();

        console.log('Category changed!');

        var category = $(this).val();

        console.log('Selected cat: ', category);

        if (category == 'new') {
            console.log('New cat field shown!');

            // Display "New Category" input field
            $('.new_category_name').show();
        } else {
            console.log('New cat field shown!');

            // Hide "New Category" input field
            $('.new_category_name').hide();
        }
    });

    /** Add annotation to Column on select of cycle **/
    $('body').on('change', '.select-column', function(e) {
        console.log('.select-column changed');
        console.log('videoid: ', videoId);

        var columnId = $(this).val();

        console.log('Selected column ID: '+ columnId);

        // Grab the selected annotation
        var $annotation = $(this).closest('.annotation-details'),
            time = $('.date-time a', $annotation).html(),
            text = $('small', $annotation).html(),
            annotationId = $(this).closest('li.annotation').data('annotationId'),
            $ann = $(this).closest('li.annotation');

        var addToColumnData = {
            'column_id': columnId,
            'object_id': annotationId,
            'object_type': 'App' +'\\'+ 'Annotation',
            'video_id': videoId,
            '_token': $('meta[name="token"]').attr('value')
        };

        console.log('Add to column data: ', addToColumnData);

        // Save as a "column" (step) in the cycle (progress bar)
        $.ajax({
            method: "POST",
            url: '/video-center/column/addToColumn',
            data: addToColumnData,
            complete: function() {
                //window.location.reload();

                // Grab template
                var template = $(templates.videocenter.columns.emptyObject);

                // Populate data
                template
                    .attr('data-end', $ann.attr('data-end'))
                    .attr('data-start', $ann.attr('data-start'))
                    .attr('data-annotation-id', annotationId);

                $('.stamp-link', template)
                    .attr('data-end', $ann.attr('data-end'))
                    .attr('data-start', $ann.attr('data-start'));

                var startTime = secondsToTime($ann.attr('data-start')),
                    endTime = secondsToTime($ann.attr('data-end'));

                $('.stamp-link', template).html('@ '+ startTime[0] +':'+ startTime[1] +' - '+ endTime[0] +':'+ endTime[1]);

                $('.data .details', template).attr('data-annotation-id', annotationId);

                console.log('ann id: ', annotationId);

                $('.annotation-details small', template).html($ann.find('.annotation-details small').html());

                template.appendTo('.annotations-in-column[data-column-id="'+ columnId +'"] ul');

                // Scroll to columns list and expand if necessary
                $("html, body").animate({ scrollTop: $("#columns-list").offset().top }, 750);
            }
        });
    });

    /** Edit column modal functionality **/
    $('body').on('click', '.edit-column', function(e) {
        console.log('.edit-column clicked');

        // Get column data
        var $columnData = $(this).closest('.column'),
            columnId = $('span#column_id', $columnData).html(),
            columnName = $('span#column_name', $columnData).html(),
            columnColor = $('span#column_color', $columnData).html(),
            videoId = $('span#video_id', $columnData).html();

        console.log('Columd ID: '+ columnId);

        $('#editColumnModal #column_name').val(columnName);
        $('#editColumnModal #column_id').val(columnId);
        $('#editColumnModal #column_color').val(columnColor);
        $('#editColumnModal #video_id').val(videoId);
        $('#editColumnModal #column_color').val(columnColor);
    });

    /** Delete column functionality **/
    $('body').on('click', '.delete-column', function(e) {
        console.log('.delete-column clicked');

        // Get column data
        var $columnData = $(this).closest('.column'),
            columnId = $('span#column_id', $columnData).html(),
            videoId = $('span#video_id', $columnData).html();

        /*if (confirm('Are you sure you want to delete this column?')) {
            var deleteStepData = {
                'column_id': columnId,
                'video_id': videoId,
                '_token': $('meta[name="token"]').attr('value')
            };

            $.ajax({
                method: "GET",
                url: '/video-center/destroyColumn',
                data: deleteStepData,
                success: function() {
                    window.location.reload();
                }
            });
        }*/

        bootbox.confirm({
            title: "Delete column?",
            message: "Are you sure you want to delete this column?",
            buttons: {
                confirm: {
                    label: '<span class="glyphicon glyphicon-ok-sign"></span> Yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: '<span class="glyphicon glyphicon-remove"></span> No',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if (result === true) {
                    var deleteStepData = {
                        'column_id': columnId,
                        'video_id': videoId,
                        '_token': $('meta[name="token"]').attr('value')
                    };

                    $.ajax({
                        method: "GET",
                        url: '/video-center/destroyColumn',
                        data: deleteStepData,
                        success: function() {
                            window.location.reload();
                        }
                    });
                }
            }
        });
    });

    /** Share object functionality **/
    $('body').on('click', '.share-object', function(e) {
        console.log('.share-object clicked');

        // Get object data
        var objectId = $(this).data('objectId'),
            objectType = $(this).data('objectType');

        console.log('Object ID:'+ objectId);
        console.log('Object type: '+ objectType);

        $("#shareObjectModal select.participants").val([]).trigger('change'); // Participants

        // Add to share object modal
        $('#shareObjectModal #object_id').val(objectId);
        $('#shareObjectModal #object_type').val(objectType);
    });

    /** Save object functionality **/
    $('body').on('click', '.save-object', function(e) {
        console.log('.save-object clicked');

        // Get object data
        var objectId = $(this).data('objectId'),
            objectType = $(this).data('objectType');

        console.log('Object ID:'+ objectId);
        console.log('Object type: '+ objectType);

        // Send AJAX request
        $.ajax({
            'method': 'POST',
            'url': '/save',
            'data': {
                'object_id': objectId,
                'object_type': objectType,
                '_token': $('meta[name="token"]').attr('value')
            },
            success: function(response) {
                location.reload();
            }
        })
    });

    /** Unsave object functionality **/
    $('body').on('click', '.unsave-object', function(e) {
        console.log('.unsave-object clicked');

        // Get object data
        var objectId = $(this).data('objectId'),
            objectType = $(this).data('objectType');

        console.log('Object ID:'+ objectId);
        console.log('Object type: '+ objectType);

        // Send AJAX request
        $.ajax({
            'method': 'POST',
            'url': '/unsave',
            'data': {
                'object_id': objectId,
                'object_type': objectType,
                '_token': $('meta[name="token"]').attr('value')
            },
            success: function(response) {
                location.reload();
            }
        })
    });

    /** Request to remove functionality **/
    $('body').on('click', '.request-delete', function(e) {
        console.log('.request-delete clicked');

        // Get object data
        var objectId = $(this).data('objectId'),
            objectType = $(this).data('objectType');

        console.log('Object ID:'+ objectId);
        console.log('Object type: '+ objectType);

        // Send AJAX request
        $.ajax({
            'method': 'POST',
            'url': '/request-delete',
            'data': {
                'object_id': objectId,
                'object_type': objectType,
                '_token': $('meta[name="token"]').attr('value')
            },
            success: function(response) {
                location.reload();
            }
        })
    });

    /** Request to recover functionality **/
    $('body').on('click', '.request-recover', function(e) {
        console.log('.request-recover clicked');

        // Get object data
        var objectId = $(this).data('objectId'),
            objectType = $(this).data('objectType');

        console.log('Object ID:'+ objectId);
        console.log('Object type: '+ objectType);

        // Send AJAX request
        $.ajax({
            'method': 'POST',
            'url': '/request-recover',
            'data': {
                'object_id': objectId,
                'object_type': objectType,
                '_token': $('meta[name="token"]').attr('value')
            },
            success: function(response) {
                location.reload();
            }
        })
    });

    /** Add question to prompt */
    $('body').on('click', '.add-prompt-question', function(e) {
        // Fetch template
        var template = $(templates.videocenter.prompts.question);

        // Count number of current questions
        var numQuestions = $('#createPromptModal .questions-list .question').length;

        // Add one to the number of questions
        var numQuestion = numQuestions + 1;

        // Create label
        var questionLabel = 'Question/Comment #'+ numQuestion;

        // Update template with label
        $('.question-label', template).html(questionLabel);

        // Add question to list of questions
        $('.questions-list').append(template);
    });

    /**
     * Add selected annotation text to prompt modal on click of "Create Discussion"
     */
    $('body').on('click', '.create-discussion', function(e) {
        var annotation = $(this).parents().find('.annotation'),
            id = annotation.attr('data-annotation-id'),
            text = $('small', annotation).html()

        console.log('Selected annotation: ', {id: id, text: text});

        $('#createPromptModal textarea#message').html(text);
        $('#createPromptModal input#annotation_id').val(id);
    });

    /** User attempting to Respond to a Discussion **/
    $('body').on('click', '#submit_discussion_response, #add_discussion, #add_column', function(e) {
        e.preventDefault();

        var that = $(this).closest("form");

        $(this).closest("form").formvalidate({
            failureMessages: true,
            successMessages: false,
            messageFailureClass: 'error',
            onSuccess: function (form) {
                that.submit();
                return true;
            },
            onFailure: function (form) {
                e.preventDefault();
                return false;
            }
        });
    });

    /******************************************************************
     * Progress Bars
     /*******************************************************************/

    $('body').on('click', '.progressbar', function(e) {
        var progressBarId = $(this).data('progressBarId'),
            name = $(this).data('name'),
            //actionPlan = $('span.progress-bar-action-plan', $(this)).html().replace(/<(?:.|\n)*?>/gm, ''),
            stepsHtml = $('.progress-bar-steps-edit', this).html(),
            isTemplate = $(this).data('isTemplate'),
            tags = $(this).data('tags');

        console.log('.progressbar clicked');
        console.log('pb id: '+ progressBarId);

        $('#editProgressBarModal input[name="progress_bar_id"]').val(progressBarId);
        $('#editProgressBarModal input[name="name"]').val(name);
        //$('#editProgressBarModal textarea[name="action_plan"]').val(actionPlan);
        $('#editProgressBarModal input[name="is_template"]').val(isTemplate);
        $('#editProgressBarModal .pb-tasks-edit').html(stepsHtml);

        // For each tag, we need to append the <option> since the Tags select is fed via AJAX
        var tagIds = [];

        tags.forEach(function(tag) {
            console.log('Setting: ', tag);

            $('#editProgressBarModal select.tags').append('<option value="'+ tag.id +'">'+ tag.name +'</option>');
            tagIds.push(tag.id);
        });

        $('#editProgressBarModal select.tags').val(tagIds).trigger('change');

        if (isTemplate == '0') {
            // Show "Mark As Template" button
            $('#editProgressBarModal .makeTemplate').show();
        } else {
            // Hide "Mark As Template" button
            $('#editProgressBarModal .makeTemplate').hide();

            // Show "Unmark As Template" button
            $('#editProgressBarModal .unmakeTemplate').show();
        }

        //CKEDITOR.instances['action_plan'].insertHtml(actionPlan);
    });

    $('body').on('click', '#add_pb', function(e) {
        e.preventDefault();

        $(this.closest("form")).formvalidate({
            failureMessages: true,
            successMessages: false,
            messageFailureClass: 'div error',
            onSuccess: function (form) {
                return true;
            },
            onFailure: function (form) {
                e.preventDefault();
                return false;
            }
        });

        $error = $(this).closest("form").find(".error");

        if ($("input[name='name']").val().length <= 0) {
            $error.show();

            return false;
        } else {
            $(this).closest("form").submit();
        }
    });

    /** Save progress bar as a template **/
    $('body').on('click', '#editProgressBarModal .makeTemplate', function(e) {
        // Find form
        var form = $(this).closest('form');

        // Get make template action
        var makeTemplateAction = form.data('templateAction');

        // Update action
        form.attr('action', makeTemplateAction);

        // Set "Is template" to 1
        $('#editProgressBarModal input[name="is_template"]').val('1');

        // Submit form
        form.submit();
    });

    /** Save progress bar as a non-template/unmark as template **/
    $('body').on('click', '#editProgressBarModal .unmakeTemplate', function(e) {
        // Find form
        var form = $(this).closest('form');

        // Get make template action
        var makeTemplateAction = form.data('templateAction');

        // Update action
        form.attr('action', makeTemplateAction);

        // Set "Is template" to 1
        $('#editProgressBarModal input[name="is_template"]').val('0');

        // Submit form
        form.submit();
    });

    /** Show list of progress bar templates **/
    $('body').on('click', '#createProgressBarModal #use_template', function(e) {
        e.preventDefault();

        // Open the templates modal
        $('#createProgressBarModalFromTemplate').modal('show');

        // Close the add new template modal
        $('#createProgressBarModal').modal('hide');
    });

    /** Update progress bar ID when creating from template **/
    $('body').on('click', '#createProgressBarModalFromTemplate #select_template', function(e) {
        e.preventDefault();

        // Grab progress bar ID
        var progressBarId = $(this).data('progressBarId');

        console.log('PB ID: ', progressBarId);

        // Inject into form
        $('#createProgressBarModalFromTemplate input[name="progress_bar_id"]').val(progressBarId);

        // Submit form
        $('#createProgressBarModalFromTemplate form').submit();
    });

    /**
     * Add progress bar task
     */
    $('body').on('click', '.pb-task-add', function(e) {
        e.preventDefault();

        var direction = $(this).data('direction'),
            emptyTemplate = $(templates.progressbars.tasks.empty),
            addTemplate = $(templates.progressbars.tasks.add).data('direction', direction),
            directionSelector = '.pb-tasks-'+ direction,
            numTasksInDirection = $(directionSelector +' .pb-ind-task').length;

        console.log({
            'direction': direction,
            'directionSelector': directionSelector,
            'numTasksInDirection': numTasksInDirection
            //'order': order
        });

        // Add step to the DB
        $.ajax({
            method: 'POST',
            url: '/progress-bars/storeStepAjax',
            data: {
                'progress_bar_id': $('#editProgressBarModal input[name="progress_bar_id"]').val(),
                'step_name': 'Step',
                'link': '#',
                'type': '1',
                '_token': $('meta[name="token"]').attr('value')
            },
            success: function(response) {
                $('span#task_id', emptyTemplate).html(response.id);
                $('div.pb-task', emptyTemplate).attr('data-task-id', response.id);

                if (direction == 'left') {
                    //var order = numTasksInDirection == 0 ? 0 : -Math.abs(numTasksInDirection);

                    //$('p', emptyTemplate).append('<p>Order: '+ order +'</p>');

                    //emptyTemplate.attr('id', guid());
                    emptyTemplate.prependTo($('.pb-tasks-left'));

                    addTemplate.addClass('pull-left');
                    addTemplate.prependTo($('.pb-tasks-left'));
                } else {
                    //var order = numTasksInDirection == 0 ? 0 : Math.abs(numTasksInDirection);

                    //$('p', emptyTemplate).append('<p>Order: '+ order +'</p>');

                    //emptyTemplate.attr('id', guid());
                    emptyTemplate.appendTo($(directionSelector));

                    addTemplate.addClass('pull-right');
                    addTemplate.appendTo($(directionSelector));
                }

                console.log('Left length: ', $('div.pb-tasks-left div.pb-task').length);
                console.log('Right length: ', $('div.pb-tasks-right div.pb-task').length);
            }
        });
    });

    /**
     * Add/Edit progress bar task
     */
    $('body').on('click', '#edit_task', function(e) {
        e.preventDefault();

        console.log('#edit_task clicked');

        // Get task data
        var taskId = $(this).parent('.pb-task').data('taskId');

        // Fetch task data from DB
        $.ajax({
            'method': 'POST',
            'url': '/progress-bars/fetchStepAjax',
            'data': {
                'id': taskId,
                '_token': $('meta[name="token"]').attr('value')
            },
            'success': function(response) {
                // Hide the object selection fields
                $('.obj-cat').hide();
                $('.obj').hide();

                // Show the manual input fields
                $('.step-link').show();

                // Reset "Type of Object"
                $('.object_type').val('');

                $('#addEditProgressBarStepModal .task_id').val(taskId);
                $('#addEditProgressBarStepModal .task_name').val(response.task.name);
                $('#addEditProgressBarStepModal .task_link').val(response.task.link);
                $('#addEditProgressBarStepModal .task_type').val(response.task.type);
                $('#addEditProgressBarStepModal .step-link').show();

                $('#addEditProgressBarStepModal').modal();
            }
        });
    });

    /**
     * Updates the task in the DB and updates the DOM
     */
    $('body').on('click', '#addEditProgressBarStepModal #update_step', function(e) {
        console.log('#addEditProgressBarStepModal #update_step clicked');

        // Validate form
        $(this.closest("form")).formvalidate({
            failureMessages: true,
            successMessages: false,
            messageFailureClass: 'div error',
            onSuccess: function (form) {
                return true;
            },
            onFailure: function (form) {
                e.preventDefault();
                return false;
            }
        });

        // Get individual elements + save as object
        var task = {
            id: $('input.task_id').val(),
            name: $('input.task_name').val(),
            link: $('input.task_link').val(),
            type: $('select.task_type').val()
        };

        // Update the task via AJAX
        $.ajax({
            'method': 'POST',
            'url': '/progress-bars/updateStepAjax',
            'data': {
                'id': task.id,
                'name': task.name,
                'link': task.link,
                'type': task.type,
                '_token': $('meta[name="token"]').attr('value')
            },
            'success': function(response) {
                // Update the DOM (where data-task-id == id) to reflect new task name
                $('.pb-task[data-task-id="'+ task.id +'"] .well p').html(task.name);

                // Close the modal
                $('#addEditProgressBarStepModal').modal('hide');
            }
        })
    });

    /**
     * Resource Finder
     */
    $('body').on('change', '#addEditProgressBarStepModal .object_type', function(e) {
        var objType = $(this).val();

        console.log('Selected: ', objType);

        if (objType == '1') {
            // Show the object selection fields
            $('.obj-cat').show();
            $('.obj').show();

            // Hide the manual input fields
            $('.step-link').hide();
        } else if (objType == '2') {
            // Hide the object selection fields
            $('.obj-cat').hide();
            $('.obj').hide();

            // Show the manual input fields
            $('.step-link').show();
        }
    });

    $('body').on('change', '#addEditProgressBarStepModal .object_category', function(e) {
        var objCat = $(this).val(),
            endpoints = {
                '1': '/api/video-center',
                '2': '/api/instructional-design',
                '3': '/api/resources'
            };

        if (objCat == '') {
            // Do nothing
            console.log('Selected nothing in .object_category');

        } else {
            var endpoint = APP_URL +''+ endpoints[objCat] +'?take=50';

            console.log('Selected endpoint: ', endpoint);

            var objectDropdown = $('<select name="object" class="object form-control"><option value="">-- Please Select --</option></select>');

            // Create an AJAX request to the endpoint
            $.ajax({
                method: 'GET',
                url: endpoint,
                success: function(response) {
                    // Sort results array by Title ascending
                    response.results.sort(function(a, b) {
                        if (a.title < b.title) return -1;
                        if (a.title > b.title) return 1;
                        return 0;
                    });

                    $.each(response.results, function (index, item) {
                        console.log('Item: ', item);

                        if (item.title) {
                            var option = $('<option value="' + item.url + '">' + item.title + '</option>');
                            option.appendTo(objectDropdown);
                        }
                    });

                    $('.object').replaceWith(objectDropdown);
                }
            })
        }
    });

    /**
     * Inject URL into "Link" when a user selects an option from the populated Object dropdown
     */
    $('body').on('change', '#addEditProgressBarStepModal .object', function(e) {
        var optionLink = $(this).val();

        if (optionLink) {
            $('.step-link').show();
            $('.task_link').val(optionLink);
        }
    });

    /** Delete progress bar step **/
    $('body').on('click', '#editProgressBarModal #delete_step', function(e) {
        console.log('#delete_step clicked');

        // Get ID of the task
        var taskId = $(this).data('taskId');

        // Delete the task via AJAX
        $.ajax({
            'method': 'POST',
            'url': '/progress-bars/destroyStepAjax',
            'data': {
                'id': taskId,
                '_token': $('meta[name="token"]').attr('value')
            },
            success: function(response) {
                // Delete the task element from the edit progress bar screen
                $('.pb-task[data-task-id="'+ taskId +'"]').remove();
            }
        })
    });

    $('body').on('click', '.delete-pb', function(e) {
        // Grab progress bar ID
        var progressBarId = $(this).data('pb-id');

        console.log('PB ID: ', progressBarId);

        // Inject progress bar ID
        $('#deleteProgressBarModal input[name="progress_bar_id"]').val(progressBarId);

        // Show delete progress bar modal
        $('#deleteProgressBarModal').modal('show');
    });

    $('body').on('click', '.edit-annotation', function(e) {
        console.log('.edit-annotation clicked');

        // Get annotation data
        var $annData = $(this).closest('.annotation'),
            annId = $annData.attr('data-annotation-id');

        // Convert annotation to "Edit Annotation" form
        var text = $('small', $annData).html();

        var editAnnForm = '<div class="edit-ann-form"><textarea class="edit-ann-content" name="content" rows="3" cols="5">'+ text +'</textarea>\
        <button class="btn btn-success btn-xs save-annotation" type="button" title="Save" data-annotation-id="'+ annId +'">Edit</button></div>';

        $('.annotation-details', $annData).append(editAnnForm);
    });

    $('body').on('click', '.save-annotation', function(e) {
        // Get annotation data
        var annId = $(this).data('annotationId'),
            content = $('.edit-ann-content').val();

        var editAnnData = {
            'annotation_id': annId,
            'content': content,
            '_token': $('meta[name="token"]').attr('value')
        };

        console.log('Edit ann data: ', editAnnData);

        $.ajax({
            method: "POST",
            data: editAnnData,
            url: '/api/annotations/'+ annId,
            success: function() {
                // Remove edit form
                $('li.annotation[data-annotation-id="'+ annId +'"] div.edit-ann-form').hide();

                // Find the element & update the content
                $('li.annotation[data-annotation-id="'+ annId +'"] div.annotation-details small').html(content);
            }
        });
    });

    $('body').on('click', '.remove-annotation', function(e) {
        console.log('.remove-annotation clicked');

        // Get annotation data
        var $annData = $(this).closest('.annotation'),
            annId = $annData.data('annotationId');

        bootbox.confirm({
            title: "Delete annotation?",
            message: "Are you sure you want to delete this annotation?",
            buttons: {
                cancel: {
                    label: '<span class="glyphicon glyphicon-remove"></span> No',
                    className: 'btn-danger'
                },
                confirm: {
                    label: '<span class="glyphicon glyphicon-ok-sign"></span> Yes',
                    className: 'btn-success'
                }
            },
            callback: function (result) {
                if (result === true) {
                    var deleteAnnData = {
                        'annotation_id': annId,
                        '_token': $('meta[name="token"]').attr('value')
                    };

                    $.ajax({
                        method: "DELETE",
                        data: deleteAnnData,
                        url: '/api/annotations/'+ annId,
                        success: function() {
                            // Find the element & remove from the DOM
                            $('li.annotation[data-annotation-id="'+ annId +'"]').remove();
                        }
                    });
                }
            }
        });

        /*if (confirm('Are you sure you want to delete this annotation?')) {
            var deleteAnnData = {
                'annotation_id': annId,
                '_token': $('meta[name="token"]').attr('value')
            };

            $.ajax({
                method: "DELETE",
                data: deleteAnnData,
                url: '/api/annotations/'+ annId,
                success: function() {
                    // Find the element & remove from the DOM
                    $('li.annotation[data-annotation-id="'+ annId +'"]').remove();
                }
            });
        }*/
    });

    $("#time-stamp-comment").on("click", function (e) {

        e.preventDefault();
        $stamp = $(this).parent().find(".stamp");
        var minutes = $stamp.find("input[name='minutes']").val();
        var seconds = $stamp.find("input[name='seconds']").val();

        $(this).closest(".add-comment").find("textarea").insertAtCaret(" @" + minutes + ":" + seconds + " ");

    });

    $(".icon-document-remove").on("click", function (e) {

        e.preventDefault();
        $doc = $(this).closest("li").find("a");

        var docId = $doc.attr("data-target");
        var docTitle = $doc.text();

        $("article.remove-document").find("form").attr("action", "/api/documents/" + docId).end().find(".remove-document-title").text(docTitle);

    });

    /** Add annotation **/
    $(".add-annotation").find("form").on("submit", function (e) {
        console.log('.add-annotation clicked');

        e.preventDefault();

        var $annotation = $(this).find("textarea");
        var annotationContent = $annotation.val();
        var annotationTime = Math.floor(wistiaVideo.time());
        var annotationAction = $(this).closest("form").attr("action");
        var $annotationContain = $(this).closest(".add-annotation").siblings(".annotations");
        var profilePic = $(this).find(".profile-pic").html();
        var ans = [];

        if (annotationContent.length > 0) {
            if ($('input[name="no_column"]').is(':checked')) {
                var columnColor = '';
            } else {
                var columnColor = $('input[name="column_color"]').val();
            }

            var annData = {
                content: annotationContent,
                time: annotationTime,
                minutes_start: $(this).closest("form").find('.minutes_start').val(),
                seconds_start: $(this).closest("form").find('.seconds_start').val(),
                minutes_end: $(this).closest("form").find('.minutes_end').val(),
                seconds_end: $(this).closest("form").find('.seconds_end').val(),
                ann_column: $(this).closest("form").find('#ann_column').val(),
                column_color: columnColor,
                '_token': $('meta[name="token"]').attr('value')
            };

            var postAnnotation = $.ajax({

                url: annotationAction,
                method: "POST",
                data: {
                    content: annotationContent,
                    time: annotationTime,
                    minutes_start: $(this).closest("form").find('.minutes_start').val(),
                    seconds_start: $(this).closest("form").find('.seconds_start').val(),
                    minutes_end: $(this).closest("form").find('.minutes_end').val(),
                    seconds_end: $(this).closest("form").find('.seconds_end').val(),
                    ann_column: $(this).closest("form").find('#ann_column').val(),
                    column_color: columnColor,
                    '_token': $('meta[name="token"]').attr('value')
                },
                success: function (annotationId) {
                    $annotation.val("");
                    $('.minutes_start').val('');
                    $('.seconds_start').val('');
                    $('.minutes_end').val('');
                    $('.seconds_end').val('');
                    $('#ann_column').val('');

                    // Reset annotation start time tracker
                    window.annotationStartTimeFilled = false;

                    //ans.push(annotationTime);
                    var timestamp = secondsToTime(annotationTime);

                    /*var annotationText = '<div class="annotation current" data-target="' + annotationTime + '"><div class="profile-pic">' + profilePic + '</div> <div class="annotation-details"><div><strong>' + $myName + '</strong><span class="date-time"><a href="#" class="stamp-link" data-target="' + annotationTime + '">@' + timestamp[0] + ':' + timestamp[1] + '</a></span><p>' + annotationContent + '</p></div></div></div>';*/

                    /*var annotationText = '<li class="annotation item success">\
                                <div class="annotation-details">\
                                <div class="data"><div class="time text-muted"> <span class="date-time"><a href="#" class="stamp-link">@' + data.minutes_start + ':' + data.seconds_start +' - '+ data.minutes_end +':'+ data.seconds_end +'</a></span></div>\
                        <small>' + annotationContent+ '</small>\
                        </div></div></li>';*/

                    /*$annotationContain.find(".annotation").each(function () {
                        ans.push(Number($(this).attr("data-target")));
                    });

                    ans = _.sortBy(_.uniq(ans));

                    annotations[annotations.length] = {
                        "author": {"avatar_url": $myProfilePic, "display_name": $myName},
                        "content": annotationContent,
                        "time": annotationTime.toString()
                    };*/

                    var minutesStart = timeToSeconds(annData.minutes_start +':'+ annData.seconds_start),
                        minutesEnd = timeToSeconds(annData.minutes_end +':'+ annData.seconds_end);

                    console.log('Minutes start: ', minutesStart);
                    console.log('Minutes end: ', minutesEnd);

                    if (videoColumns.length > 0) {
                        var $videoColumnSelect = $('<select class="form-control select2 select-column" style="max-width: 90%;display:block;margin-top: 2px;margin-bottom: -12px;">');

                        // Add default "Please Select" option
                        $('<option value="0">-- Choose Column --</option>').appendTo($videoColumnSelect);

                        _.each(videoColumns, function (videoColumn) {
                            $('<option value="' + videoColumn.id + '">' + videoColumn.name + '</option>').appendTo($videoColumnSelect);
                        });
                    } else {
                        var $videoColumnSelect = $('<button class="button btn-success button-royal-flat btn-xs pull-left new-col-from-annotation" data-toggle="modal" data-target="#addColumnModal" style="margin: 6px;">Create New Column</button>');
                    }

                    // Grab template
                    var template = $(templates.videocenter.annotations.empty);

                    // Add data to annotation
                    template
                        .attr('data-annotation-id', annotationId)
                        .attr('data-start', minutesStart)
                        .attr('data-end', minutesEnd);

                    $('div.annotation-details span.date-time a', template)
                        .attr('data-start', minutesStart)
                        .attr('data-end', minutesEnd);

                    $('div.data small', template).html(annData.content);

                    $('p.column-area', template).html($videoColumnSelect[0].outerHTML);

                    $annotations.prepend(template);

                    /*$annotations.prepend('\
                        <li class="annotation item success" data-annotation-id="" data-start="'+ minutesStart +'" data-end="'+ minutesEnd +'">\
                                <div class="annotation-details">\
                                <div class="data"><div class="time text-muted"> <span class="date-time"><a href="#" class="stamp-link" data-start="'+ minutesStart +'" data-end="'+ minutesStart +'">@' + annData.minutes_start + ':' + annData.seconds_start + ' - '+ annData.minutes_end +':'+ annData.seconds_end +'</a></span></div>\
                        <small>' + annData.content + '</small>\
                                '+ $videoColumnSelect[0].outerHTML +'\
                            </div>\
                        </div>\
                            </div>\
                        </div></li>');*/

                    var stampExists = _.find(timelineTicks, function (minutesStart) {
                        return minutesStart == annotationTime;
                    });

                    /*_.each(annotations, function(annotation) {
                        var timeStart = secondsToTime(annotation.time_start),
                            timeEnd = secondsToTime(annotation.time_end),
                            timeSum = annotation.time_start + annotation.time_end;

                        $timeline.find("ul").append('<li title="' + timeStart[0] + ':' + timeStart[1] + ' - ' + timeEnd[0] + ':' + timeEnd[1] +'" style="left:' + (((timeStart[0] + timeStart[1]) / videoDuration) * 100) + '%;" class="stamp-link" data-start="' + annotation.time_start + '" data-end="' + annotation.time_end + '"><a href="#">|</a></li>');
                    });*/

                    var timeStart = secondsToTime(minutesStart),
                        timeEnd = secondsToTime(minutesEnd);

                    //if (stampExists == undefined) {
                    $timeline.find('ul').append('<li title="' + timeStart[0] +':' + timeStart[1] + ' - ' + timeEnd[0] + ':' + timeEnd[1] +'" style="left:' + (((timeStart[0] + timeStart[1]) / window.videoDuration) * 100) + '%;" class="stamp-link" data-start="' + minutesStart + '" data-end="' + minutesEnd + '"><a href="#">|</a></li>');

                    $timeline.find("ul").children("li:last-child").tooltipster({
                        position: "bottom",
                        theme: "video-ticker",
                        delay: 0
                    });
                    //}

                    /*var stampExists = _.find(timelineTicks, function (num) {
                        return num == annotationTime;
                    });

                    if (stampExists == undefined) {
                        $timeline.find("ul").append('<li title="' + timestamp[0] + ':' + timestamp[1] + '" style="left:' + ((annotationTime / wistiaVideo.duration()) * 100) + '%";" class="stamp-link" data-target="' + annotationTime + '"><a href="#">|</a></li>');

                        $timeline.find("ul").children("li:last-child").tooltipster({
                            position: "bottom",
                            theme: "video-ticker",
                            delay: 0
                        });
                    }

                    _.each(ans, function (time, index) {

                        if (time.toString() == annotationTime) {

                            if (stampExists == undefined) { // if it is 1st annotation w/ this timestamp

                                if (index == 0) { // if this is the 1st annotation for this video

                                    $annotationContain.append(annotationText);

                                } else {

                                    var ansBefore = ans[index - 1].toString();
                                    $annotationContain.find(".annotation[data-target='" + ansBefore + "']").last().after(annotationText);

                                }

                            } else {

                                $annotationContain.find(".annotation[data-target='" + annotationTime + "']").last().after(annotationText);

                            }

                        }

                    });

                    $annotations.scrollTo($(".annotation[data-target='" + annotationTime + "']").last(), 800);
                    displayAnnotations(annotationTime);*/
                },

                error: function (data) {
                    console.log('fail ' + data);
                }
            });
        }
    });

    $(".exemplar-response").find("form").on("submit", function (e) {

        e.preventDefault();

        //console.log($(this).find("button[type=submit][clicked=true]").val());

        //console.log($(this).find("button[type='submit'][clicked=true]").text());

        //$(this)[0].submit();

    });

    $(".exemplar-response").find("button[role='submit']").on("click", function (e) {

        var status = $(this).attr("data-target");

        $("input[name='_method']").val(status);

        $(this).closest("form")[0].submit();

    });

    if ($('#user-role').length) {

        $('.styled-select[for="school_id"]').hide();
        $('.styled-select[for="classroom_id"]').hide();
        $('.styled-select[for="masterteacher"]').hide();

        $('#user-role').change(function () {

            var select = $(this);
            var value = select.val();
            var option = select.find('[value="' + value + '"]').html();

            if (value == '' || option == 'Project Admin') {
                $('.styled-select[for="school_id"]').hide();
                $('.styled-select[for="classroom_id"]').hide();
            } else {
                $('.styled-select[for="school_id"]').show();
                $('.styled-select[for="classroom_id"]').show();
                $('.styled-select[for="masterteacher"]').hide();

                if (option == 'Teacher') {
                    $('.styled-select[for="masterteacher"]').show();
                }
                else if (option == 'Master Teacher') {
                    $('.styled-select[for="classroom_id"]').hide();
                }
            }
        });
    }

    if ($('#sign-up-school').length) {

        var classroomOrMasterTeacherRefresh = function (e) {

            console.log('classroomOrMasterTeacherRefresh() called');
            console.log('schools: ', schools);

            var selectedSchoolId = parseInt($('#sign-up-school').val());

            console.log('selected school id: ', selectedSchoolId);
            console.log(typeof selectedSchoolId);

            if (selectedSchoolId == '') {
                console.log('selectedschoolid is empty, exited function');
                return;
            }

            var school = _.findWhere(schools, {id: selectedSchoolId});

            var optionTemplate = _.template('<option value="<%- value %>"><%- name %></option>');

            console.log('School: ', school);

            var html = _.reduce(school.classrooms, function (memo, classroom) {

                return memo + optionTemplate({value: classroom.id, name: classroom.name});

            }, '');

            $('#sign-up-classroom').html(html);


            var optionTemplate = _.template('<option value="<%- value %>"><%- name %></option>');

            var html = _.reduce(school.users, function (memo, teacher) {

                return memo + optionTemplate({value: teacher.id, name: teacher.name});

            }, '');

            $('#sign-up-masterteacher').html(html);

        };

        $('#sign-up-school').change(classroomOrMasterTeacherRefresh);

        classroomOrMasterTeacherRefresh();

    }

    $('.notifications-bubble').on('click', function (e) {
        e.preventDefault();

        var userId = jQuery(this).data('userId');

        jQuery.get(jQuery('.self-api-url').attr('href') + '/activities/' + userId + '/markReadByUserId', function() {
            $('.label-danger').remove();
        });
    });
});

function parseURL(url){
    parsed_url = {}

    if ( url == null || url.length == 0 )
        return parsed_url;

    protocol_i = url.indexOf('://');
    parsed_url.protocol = url.substr(0,protocol_i);

    remaining_url = url.substr(protocol_i + 3, url.length);
    domain_i = remaining_url.indexOf('/');
    domain_i = domain_i == -1 ? remaining_url.length - 1 : domain_i;
    parsed_url.domain = remaining_url.substr(0, domain_i);
    parsed_url.path = domain_i == -1 || domain_i + 1 == remaining_url.length ? null : remaining_url.substr(domain_i + 1, remaining_url.length);

    domain_parts = parsed_url.domain.split('.');
    switch ( domain_parts.length ){
        case 2:
            parsed_url.subdomain = null;
            parsed_url.host = domain_parts[0];
            parsed_url.tld = domain_parts[1];
            break;
        case 3:
            parsed_url.subdomain = domain_parts[0];
            parsed_url.host = domain_parts[1];
            parsed_url.tld = domain_parts[2];
            break;
        case 4:
            parsed_url.subdomain = domain_parts[0];
            parsed_url.host = domain_parts[1];
            parsed_url.tld = domain_parts[2] + '.' + domain_parts[3];
            break;
    }

    parsed_url.parent_domain = parsed_url.host + '.' + parsed_url.tld;

    return parsed_url;
}

function dropdownsToggle($dd) {

    if ($dd.is(':visible')) {

        $dd.hide();

    } else {

        $dropdown.hide();
        $dd.show();

    }

}

function dropdownPosition(trigger,parent,dropdown,aligned) {

    triggerWidth = trigger.outerWidth();
    triggerPosition = trigger.offset();

    parentHeight= parent.outerHeight();
    parentPosition = parent.offset();

    if ( undefined == parentPosition ) return;
    if ( undefined == triggerPosition ) return;

    dropdownWidth = dropdown.outerWidth();

    switch(aligned) {

        case 'center':
            dropdown.css({"top": (parentPosition.top + parentHeight), "left": ((triggerPosition.left + (triggerWidth / 2)) - (dropdownWidth / 2))});
            break;
        case 'right':
            dropdown.css({"top": (parentPosition.top + parentHeight), "left": ((triggerPosition.left - dropdownWidth) + triggerWidth)});
            break;

    }

}

function closePopup(p,e,t) {

    e.preventDefault();
    $(t).closest(".module").add(p).hide();
    $main.css("z-index",$mainZIndex);

}

function secondsToTime(seconds) {

    var minutes = Math.floor(seconds / 60);
    var seconds = seconds % 60;

    if (seconds < 10) {

        seconds = "0" + seconds;

    }

    // Round seconds
    seconds = parseFloat(seconds).toFixed(0);

    return [minutes,seconds];

}

function timeToSeconds(stamp) {

    var splitTime = stamp.split(":");

    var minutes = parseInt(Math.ceil(splitTime[0] * 60));
    var seconds = parseInt(splitTime[1]);

    return minutes + seconds;

}

function removeStampLeadingZeros(stamp) {

    var splitTime = stamp.split(":");

    var minutes = splitTime[0].replace("@", "");
    minutes = minutes.replace(/\b0+/g, '');

    if (minutes == '') {

        minutes = 0;
    }

    return "@" + minutes + ":" + splitTime[1];

}

function validateVideoStamp(stamp) {

    if( /(^@[0-9]\d*:\b[0-5]\d$)/.test(stamp) ){

        return '<a href="#" class="stamp-link" data-target="' + timeToSeconds(stamp.replace("@", "")) + '">' + removeStampLeadingZeros(stamp) + '</a>';

    } else {

        return stamp;

    }

}

function displayAnnotations(s) {

    var findAnnotations = _.where(annotations, {time: s.toString()});

    $timeline.find("ul").find("li").each(function() {

        if ($(this).hasClass("tooltipstered")) {

            $(this).tooltipster('hide');

        }

        if ($(this).attr("data-target") == s) {

            $(this).trigger("mouseenter");

        }

    });

    if (findAnnotations.length > 0) {

        //$annotations.scrollTo($(".annotation[data-target='" + s + "']"), 800);

        $annotations.find(".annotation").each(function() {

            $(this).removeClass("current");

        })
            .end()
            .find(".annotation[data-target='" + s + "']").addClass("current");


    }

}

function displayTimelineRanges() {
    console.group('displayTimelineRanges called');

    //var findAnnotations = _.where(annotations, {time: s.toString()});
    //var findAnnotations = _.where(annotations, {time_start: start.toString(), time_end: end.toString()});

    //console.log(annotations);

    if (annotations.length > 0) {
        _.each(annotations, function (annotation) {
            // "Highlight" this annotation underneath the progress bar
            for (var z = annotation.time_start; z <= annotation.time_end; z++) {
                // Highlight the target
                //$annotations.find(".annotation[data-target='" + z + "']").addClass('current');
                var target = $timeline.find("li[data-target='"+ z +"']");

                console.log('Target: ', target);

                //if (target.hasClass("tooltipstered")) {
                target.tooltipster({
                    position: "bottom",
                    theme: "video-ticker",
                    delay: 0
                });
                //}

                target.trigger("mouseenter");
            }
        });
    }

    console.groupEnd();
}

function returnParticipantTemplate(user) {

    if (user.url) {

        return $('<span class="select2-avatar profile-pic"><img src="' + user.url + '" alt="' + user.text + '" /></span><span class="select2-name">' + user.text + '</span>');

    } else if (user.id) {

        return $('<span class="select2-avatar profile-pic">&nbsp;</span><span class="select2-name upper">' + user.text + '</span>');

    } else {

        return user.text
    }

}

function returnTagTemplate(user) {

    return $('<span class="select2-name">' + user.text + '</span>');

}

function returnTitleAndAuthorTemplate(title) {

    if (title.id) {

        if (title.isExemplar == true) {

            var showExemplar = '<i class="icon icon-exemplar approved"></i>';

        } else {

            var showExemplar = '';

        }

        if (title.avatar == null) {

            var avatarImg = '&nbsp;'

        } else {

            var avatarImg = '<img src="' + title.avatar + '" alt="' + title.author.name + '" />';
        }
        if (title.hide_author)
            return $('<a href="' + title.url + '"><span class="select2-name no-position">"' + title.title + '" ' + showExemplar + '</span></a>');
        else
            return $('<a href="' + title.url + '"><span class="select2-avatar profile-pic">' + avatarImg + '</span><span class="select2-name no-position">"' + title.title + '" ' + showExemplar + ' <span class="search-by-author">by ' + title.author.display_name + '</span></span></a>');

    } else {

        return title.text;

    }

}

function returnTitleTemplate(title) {
    console.log(title);

    if (title.id) {
        if (title.isExemplar == true) {
            var showExemplar = '<i class="icon icon-exemplar approved"></i>';
        } else {
            var showExemplar = '';
        }

        return $('<a href="' + title.url + '"><span class="select2-name no-position">"' + title.title + '" ' + showExemplar + '</span></a>');
    } else {
        return title.text;
    }
}

function returnProgressBarTitleTemplate(title) {
    console.log(title);

    if (title.id) {
        return $('<a href="/progress-bars/view/'+ title.id +'"><span class="select2-name no-position">' + title.name + '</span></a>');
    } else {
        return title.name;
    }
}

function returnProgressBarAuthorTemplate(title) {
    console.log(title);

    if (title.id) {
        return $('<a href="/progress-bars/author/'+ title.id +'"><span class="search-by-author">' + title.author.display_name + '</span>');
    }
}

function returnAuthorTemplate(user) {
    console.log(user);

    if (user.id) {
        //return $('<a href="/video-center/author/'+ title.id +'"><span class="search-by-author">' + title.display_name + '</span></a>');
        return $('<span class="select2-name">' + user.text + '</span>');
    }
}

function guid() {
    function s4() {
        return Math.floor((1 + Math.random()) * 0x10000)
            .toString(16)
            .substring(1);
    }
    return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
        s4() + '-' + s4() + s4() + s4();
}

function initTextEditor(source) {
    if (typeof CKEDITOR !== 'undefined') {
        CKEDITOR.replace(source, {
            /*toolbar: [
                // add Uploadcare button to toolbar, e.g.:
                ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'Uploadcare']
            ]*/
            extraPlugins: 'uploadcare,scayt', // this will enable plugin
            toolbar: [
                // add Uploadcare button to toolbar, e.g.:
                ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'Uploadcare', 'Scayt']
            ]
        });
    }
}

function initTextEditorRequired(source) {
    if (typeof CKEDITOR !== 'undefined') {
        CKEDITOR.replace(source, {
            replaceClass: 'required',
            /*toolbar: [
                // add Uploadcare button to toolbar, e.g.:
                ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'Uploadcare']
            ]*/
            extraPlugins: 'uploadcare,scayt', // this will enable plugin
            toolbar: [
                // add Uploadcare button to toolbar, e.g.:
                ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'Uploadcare', 'Scayt']
            ]
        });
    }
}

function scrollPopupToTop(element) {
    element.each( function()
    {
        // certain browsers have a bug such that scrollHeight is too small
        // when content does not fill the client area of the element
        var scrollHeight = Math.max(this.scrollHeight, this.clientHeight);
        this.scrollTop = scrollHeight^2 - this.clientHeight;
    });
}

jQuery.fn.extend({
    insertAtCaret: function(myValue){
        return this.each(function(i) {
            if (document.selection) {
                //For browsers like Internet Explorer
                this.focus();
                var sel = document.selection.createRange();
                sel.text = myValue;
                this.focus();
            }
            else if (this.selectionStart || this.selectionStart == '0') {
                //For browsers like Firefox and Webkit based
                var startPos = this.selectionStart;
                var endPos = this.selectionEnd;
                var scrollTop = this.scrollTop;
                this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
                this.focus();
                this.selectionStart = startPos + myValue.length;
                this.selectionEnd = startPos + myValue.length;
                this.scrollTop = scrollTop;
            } else {
                this.value += myValue;
                this.focus();
            }
        });
    }
});

'use strict';

;(function($, window, document, undefined) {
    /*tinymce.init({
        selector: 'textarea',
        height: 100,
        menubar: false,
        theme: 'modern',
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools',
            'spellchecker'
        ],
        external_plugins: {"nanospell": APP_URL+"/js/nanospell/plugin.js"},
        nanospell_server: "php",
        toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print | media | emoticons | nanospell'
    });
    tinymce.init({
        selector: '.editable',
        height: 100,
        menubar: false,
        theme: 'modern',
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools',
            'spellchecker'
        ],
        external_plugins: {"nanospell": APP_URL+"/js/nanospell/plugin.js"},
        nanospell_server: "php",
        toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print | media | emoticons | nanospell'
    });*/
    $("input[type='file']").each(function () {
        //console.log("input[type='file'] - event fired")
        var $input = $(this),
            $label = $input.next('label'),
            labelVal = $label.html();

        $input.on('change', function (e) {
            var fileName = '';

            console.log(this.files);

            if (this.files && this.files.length > 1) {
                fileName = ( this.getAttribute('data-multiple-caption') || '' ).replace('{count}', this.files.length);
            } else if (e.target.value) {
                fileName = e.target.value.split('\\').pop();
            }

            console.log('File Name: ', fileName);
            console.log('Label: ', $label);

            if (fileName) {
                $label.html(fileName);
            } else {
                $label.html(labelVal);
            }

            console.log(this.files);
        });

        // Firefox bug fix
        $input
            .on('focus', function () {
                $input.addClass('has-focus');
            })
            .on('blur', function () {
                $input.removeClass('has-focus');
            });
    });
})(jQuery, window, document);

(function ($) {
    var $body = $('body'),
        $rightToggle = $('.toggle-right');

    if ($('#right').length) {
        $rightToggle.on("click", function (e) {
            switch (true) {
                // Close right panel
                case $body.hasClass("sidebar-right-opened"):
                    $body.removeClass("sidebar-right-opened");
                    if ($body.hasClass("boxed")) {
                        $('#right').css('right', '-270px');
                    }
                    break;

                default:
                    // Open right panel
                    $body.addClass("sidebar-right-opened");
                    adjust_boxright();
                    $('.navbar-nav>.dropdown').removeClass("open");
            }
            e.preventDefault();
        });
    } else {
        $rightToggle.addClass('hidden');
    }
})(jQuery);

(function(open) {
    XMLHttpRequest.prototype.open = function() {
        this.addEventListener("readystatechange", function() {
            if(this.status == 400)
            {
                var error = $.parseJSON(this.responseText).error;
                alert(error);
                if(window.wistiaUploader)
                    window.wistiaUploader.cancel();

                $.ajax({

                    url: '/video-center/emailError',
                    method: "POST",
                    data: { content: error, '_token': $('meta[name="token"]').attr('value')},
                    success: function(data) {

                    },
                    error: function(data) {

                        console.log('fail ' + data);

                    }
                });
            }
        }, false);
        open.apply(this, arguments);
    };
})(XMLHttpRequest.prototype.open);

$('.modal').on('hidden.bs.modal', function(e)
{
    $(this).removeData();
}) ;