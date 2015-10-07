/*
 * JQuery image preloader
 */
(function($) {
    if (!Array.prototype.indexOf)
    {
        Array.prototype.indexOf = function(elt)
        {
            var len  = this.length >>> 0;
            var from = Number(arguments[1]) || 0;
            from = (from < 0)
            ? Math.ceil(from)
            : Math.floor(from);
            if (from < 0)
                from += len;

            for (; from < len; from++)
            {
                if (from in this &&
                    this[from] === elt)
                    return from;
            }
            return -1;
        };
    }


    var uPimages = new Array;
    var uPdone = 0;
    var uPdestroyed = false;

    var uPimageContainer = "";
    var uPoverlay = "";
    var uPoverlay2 = "";
    var uPbar = "";
    var uPpercentage = "";
    var uPimageCounter = 0;
    var uPpreloaderBgImg = "";
    var uPstart = 0;

    var uPoptions = {
        onComplete: function () {},
        backgroundColor: "#000",
        barColor: "#29a2db",
        barHeight: 1,
        percentage: true,
        deepSearch: true,
        completeAnimation: "1",
        minimumTime: 500,
        onLoadComplete: function () {
            if(uPoptions.completeAnimation == "2"){
                var animationTime = 500;
                var currentTime = new Date();
                if ((currentTime.getTime() - uPstart) < uPoptions.minimumTime) {
                    animationTime = (uPoptions.minimumTime - (currentTime.getTime() - uPstart));
                }

                $(uPbar).stop().animate({
                    "width": "100%"
                }, animationTime, function () {
                    $(this).animate({
                        right: "0%",
                        width: "0%"
                    }, 500, function () {
                        $(uPoverlay).fadeOut(500, function () {
                            $(this).remove();
                            uPoptions.onComplete();
                        })
                    });
                });
            } else if(uPoptions.completeAnimation == "3"){
                var animationTime = 500;
                var currentTime = new Date();
                if ((currentTime.getTime() - uPstart) < uPoptions.minimumTime) {
                    animationTime = (uPoptions.minimumTime - (currentTime.getTime() - uPstart));
                }

                $(uPbar).stop().animate({
                    "width": "100%"
                }, animationTime, function () {
                    $(this).animate({
                        right: "50%",
                        left: "50%",
                        width: "0%"
                    }, 500, function () {
                        $(uPoverlay).fadeOut(500, function () {
                            $(this).remove();
                            uPoptions.onComplete();
                        })
                    });
                });
            } else {
                $(uPoverlay).fadeOut(500, function () {
                    $(uPoverlay).remove();
                    uPoptions.onComplete();
                });
            }
        }
    };

    var afterEach = function () {
        var currentTime = new Date();
        uPstart = currentTime.getTime();

        createPreloadContainer();
        createOverlayLoader();
    };

    var createPreloadContainer = function() {
        uPimageContainer = $("<div></div>").appendTo("body").css({
            display: "none",
            width: 0,
            height: 0,
            overflow: "hidden"
        });
        for (var i = 0; uPimages.length > i; i++) {
            $.ajax({
                url: uPimages[i],
                type: 'HEAD',
                complete: function(data) {
                    if(!uPdestroyed){
                        uPimageCounter++;
                        addImageForPreload(this['url']);
                    }
                }
            });
        }
    };

    var addImageForPreload = function(url) {
        var image = $("<img />").attr("src", url).bind("load", function () {
            completeImageLoading();
        }).appendTo(uPimageContainer);
    };

    var completeImageLoading = function () {
        uPdone++;

        var percentage = (uPdone / uPimageCounter) * 100;
        $(uPbar).stop().animate({
            width: percentage + "%"
        }, 200);

        if (uPoptions.percentage == true) {
            $(uPpercentage).text(Math.ceil(percentage) + "%");
        }

        if (uPdone == uPimageCounter) {
            destroyQueryLoader();
        }
    };

    var destroyQueryLoader = function () {
        $(uPimageContainer).remove();
        uPoptions.onLoadComplete();
        uPdestroyed = true;
    };

    var createOverlayLoader = function () {
        uPoverlay = $("<div id='uPoverlay'></div>").css({
            width: "100%",
            height: "100%",
            backgroundColor: uPoptions.backgroundColor,
            backgroundPosition: "fixed",
            position: "fixed",
            fontFamily: "Arial",
            lineHeight: "normal",
            zIndex: 666999,
            top: 0,
            left: 0
        }).appendTo("body");

        var custom_max_width = "100%";
        var custom_left = "0";
        var custom_marginLeft = "0";
        if(uPoptions.custom_width_opt == '1'){
            custom_max_width = uPoptions.mwidth;
            custom_left = "50%";
            custom_marginLeft = -(uPoptions.mwidth/2);
        }
        
        var preloaderBgImg = uPoptions.preloaderBgImg;
        uPpreloaderBgImg = $("<div id='uPimgWrap'></div>").css({
            width: "100%",
            height: "100%",
            position: "absolute",
            top: "0",
            left: "0",
            background: "url('"+preloaderBgImg+"') no-repeat " + uPoptions.preloaderBgImgPos + " transparent"
        }).appendTo(uPoverlay);
        
        
        uPoverlay2 = $("<div id='uPbarWrap'></div>").css({
            width: custom_max_width,
            position: "absolute",
            top: "50%",
            left: custom_left,
            marginLeft: custom_marginLeft
        }).appendTo(uPoverlay);


        uPbar = $("<div id='uPbar'></div>").css({
            height: uPoptions.barHeight + "px",
            marginTop: "-" + (uPoptions.barHeight / 2) + "px",
            backgroundColor: uPoptions.barColor,
            width: "0%",
            position: "absolute",
            top: "0%"
        }).appendTo(uPoverlay2);
        if (uPoptions.percentage == true) {
            var uPp_left = "";
            var uPp_top = "";
            var uPp_right = "";
            var uPp_marginLeft = "0px";
            
            switch (uPoptions.percetange_position_opt){
                case "0":
                    uPp_left = "0px";
                    uPp_top = "-" + (parseInt(uPoptions.barHeight) + parseInt(uPoptions.percetange_size_opt)) + "px";
                    break;
                case "1":
                    uPp_left = "50%";
                    uPp_top = "-" + (parseInt(uPoptions.barHeight) + parseInt(uPoptions.percetange_size_opt)) + "px";
                    uPp_marginLeft = "-" + uPoptions.percetange_size_opt + "px";
                    break;
                case "2":
                    uPp_top = "-" + (parseInt(uPoptions.barHeight) + parseInt(uPoptions.percetange_size_opt)) + "px";
                    uPp_right = "0px";
                    break;
            
                case "3":
                    uPp_left = "0px";
                    uPp_top = "" + uPoptions.barHeight + "px";
                    break;
                case "4":
                    uPp_left = "50%";
                    uPp_top = "" + uPoptions.barHeight + "px";
                    uPp_marginLeft = "-" + uPoptions.percetange_size_opt + "px";
                    break;
                case "5":
                    uPp_top = "" + uPoptions.barHeight + "px";
                    uPp_right = "0px";
                    break;
            
                default :
                    uPp_left = "50%";
                    uPp_top = "-" + (parseInt(uPoptions.barHeight) + parseInt(uPoptions.percetange_size_opt)) + "px";
                    uPp_marginLeft = "-" + uPoptions.percetange_size_opt + "px";
            }
            
            
            uPpercentage = $("<div id='uPpercentage'></div>").text("0%").css({
                height: "auto",
                width: "auto",
                position: "absolute",
                fontSize: uPoptions.percetange_size_opt + "px",
                left: uPp_left,
                top: uPp_top, 
                right: uPp_right, 
                fontFamily: "Arial",
                lineHeight: "normal",
                textAlign: "center",
                marginLeft: uPp_marginLeft,
                color: uPoptions.barColor
            }).appendTo(uPoverlay2);
        }
    };

    var findImageInElement = function (element) {
        var url = "";

        if ($(element).css("background-image") != "none") {
            var url = $(element).css("background-image");
        } else if (typeof($(element).attr("src")) != "undefined" && element.nodeName.toLowerCase() == "img") {
            var url = $(element).attr("src");
        }

        if (url.indexOf("gradient") == -1) {
            url = url.replace(/url\(\"/g, "");
            url = url.replace(/url\(/g, "");
            url = url.replace(/\"\)/g, "");
            url = url.replace(/\)/g, "");

            var urls = url.split(", ");

            for (var i = 0; i < urls.length; i++) {
                if (urls[i].length > 0 && uPimages.indexOf(urls[i]) == -1) {
                    var extra = "";
                    if ($.browser.msie && $.browser.version < 9) {
                        extra = "?" + Math.floor(Math.random() * 3000);
                    }
                    uPimages.push(urls[i] + extra);
                }
            }
        }
    }

    $.fn.UP2LoaderJQ = function(options) {
        if(options) {
            $.extend(uPoptions, options );
        }

        this.each(function() {
            findImageInElement(this);
            if (uPoptions.deepSearch == true) {
                $(this).find("*:not(script)").each(function() {
                    findImageInElement(this);
                });
            }
        });
        afterEach();
        return this;
    };
})(jQuery);