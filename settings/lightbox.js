!function(t,i){"function"==typeof define&&define.amd?define(["jquery"],i):"object"==typeof exports?module.exports=i(require("jquery")):t.lightbox=i(t.jQuery)}(this,function(d){function t(t){this.album=[],this.currentImageIndex=void 0,this.init(),this.options=d.extend({},this.constructor.defaults),this.option(t)}return t.defaults={albumLabel:"Image %1 of %2",alwaysShowNavOnTouchDevices:!1,fadeDuration:600,fitImagesInViewport:!0,imageFadeDuration:600,positionFromTop:50,resizeDuration:700,showImageNumberLabel:!0,wrapAround:!1,disableScrolling:!1,sanitizeTitle:!1},t.prototype.option=function(t){d.extend(this.options,t)},t.prototype.imageCountLabel=function(t,i){return this.options.albumLabel.replace(/%1/g,t).replace(/%2/g,i)},t.prototype.init=function(){var t=this;d(document).ready(function(){t.enable(),t.build()})},t.prototype.enable=function(){var i=this;d("body").on("click","a[rel^=lightbox], area[rel^=lightbox], a[data-lightbox], area[data-lightbox]",function(t){return i.start(d(t.currentTarget)),!1})},t.prototype.build=function(){var i;0<d("#lightbox").length||(i=this,d('<div id="lightboxOverlay" tabindex="-1" class="lightboxOverlay"></div><div id="lightbox" tabindex="-1" class="lightbox"><div class="lb-outerContainer"><div class="lb-container"><img class="lb-image" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" alt=""/><div class="lb-nav"><a class="lb-prev" aria-label="Previous image" href="" ></a><a class="lb-next" aria-label="Next image" href="" ></a></div><div class="lb-loader"><a class="lb-cancel"></a></div></div></div><div class="lb-dataContainer"><div class="lb-data"><div class="lb-details"><span class="lb-caption"></span><span class="lb-number"></span></div><div class="lb-closeContainer"><a class="lb-close"></a></div></div></div></div>').appendTo(d("body")),this.$lightbox=d("#lightbox"),this.$overlay=d("#lightboxOverlay"),this.$outerContainer=this.$lightbox.find(".lb-outerContainer"),this.$container=this.$lightbox.find(".lb-container"),this.$image=this.$lightbox.find(".lb-image"),this.$nav=this.$lightbox.find(".lb-nav"),this.containerPadding={top:parseInt(this.$container.css("padding-top"),10),right:parseInt(this.$container.css("padding-right"),10),bottom:parseInt(this.$container.css("padding-bottom"),10),left:parseInt(this.$container.css("padding-left"),10)},this.imageBorderWidth={top:parseInt(this.$image.css("border-top-width"),10),right:parseInt(this.$image.css("border-right-width"),10),bottom:parseInt(this.$image.css("border-bottom-width"),10),left:parseInt(this.$image.css("border-left-width"),10)},this.$overlay.hide().on("click",function(){return i.end(),!1}),this.$lightbox.hide().on("click",function(t){"lightbox"===d(t.target).attr("id")&&i.end()}),this.$outerContainer.on("click",function(t){return"lightbox"===d(t.target).attr("id")&&i.end(),!1}),this.$lightbox.find(".lb-prev").on("click",function(){return 0===i.currentImageIndex?i.changeImage(i.album.length-1):i.changeImage(i.currentImageIndex-1),!1}),this.$lightbox.find(".lb-next").on("click",function(){return i.currentImageIndex===i.album.length-1?i.changeImage(0):i.changeImage(i.currentImageIndex+1),!1}),this.$nav.on("mousedown",function(t){3===t.which&&(i.$nav.css("pointer-events","none"),i.$lightbox.one("contextmenu",function(){setTimeout(function(){this.$nav.css("pointer-events","auto")}.bind(i),0)}))}),this.$lightbox.find(".lb-loader, .lb-close").on("click",function(){return i.end(),!1}))},t.prototype.start=function(t){var i=this,e=d(window);e.on("resize",d.proxy(this.sizeOverlay,this)),this.sizeOverlay(),this.album=[];var n=0;function o(t){i.album.push({alt:t.attr("data-alt"),link:t.attr("href"),title:t.attr("data-title")||t.attr("title")})}var a,s=t.attr("data-lightbox");if(s){a=d(t.prop("tagName")+'[data-lightbox="'+s+'"]');for(var h=0;h<a.length;h=++h)o(d(a[h])),a[h]===t[0]&&(n=h)}else if("lightbox"===t.attr("rel"))o(t);else{a=d(t.prop("tagName")+'[rel="'+t.attr("rel")+'"]');for(var r=0;r<a.length;r=++r)o(d(a[r])),a[r]===t[0]&&(n=r)}s=e.scrollTop()+this.options.positionFromTop,e=e.scrollLeft();this.$lightbox.css({top:s+"px",left:e+"px"}).fadeIn(this.options.fadeDuration),this.options.disableScrolling&&d("body").addClass("lb-disable-scrolling"),this.changeImage(n)},t.prototype.changeImage=function(o){var a=this,s=this.album[o].link,h=s.split(".").slice(-1)[0],r=this.$lightbox.find(".lb-image");this.disableKeyboardNav(),this.$overlay.fadeIn(this.options.fadeDuration),d(".lb-loader").fadeIn("slow"),this.$lightbox.find(".lb-image, .lb-nav, .lb-prev, .lb-next, .lb-dataContainer, .lb-numbers, .lb-caption").hide(),this.$outerContainer.addClass("animating");var l=new Image;l.onload=function(){var t,i,e,n;r.attr({alt:a.album[o].alt,src:s}),d(l),r.width(l.width),r.height(l.height),n=d(window).width(),e=d(window).height(),n=n-a.containerPadding.left-a.containerPadding.right-a.imageBorderWidth.left-a.imageBorderWidth.right-20,e=e-a.containerPadding.top-a.containerPadding.bottom-a.imageBorderWidth.top-a.imageBorderWidth.bottom-a.options.positionFromTop-70,"svg"===h&&(r.width(n),r.height(e)),a.options.fitImagesInViewport?(a.options.maxWidth&&a.options.maxWidth<n&&(n=a.options.maxWidth),a.options.maxHeight&&a.options.maxHeight<e&&(e=a.options.maxHeight)):(n=a.options.maxWidth||l.width||n,e=a.options.maxHeight||l.height||e),(l.width>n||l.height>e)&&(l.width/n>l.height/e?(i=n,t=parseInt(l.height/(l.width/i),10)):(t=e,i=parseInt(l.width/(l.height/t),10)),r.width(i),r.height(t)),a.sizeContainer(r.width(),r.height())},l.src=this.album[o].link,this.currentImageIndex=o},t.prototype.sizeOverlay=function(){var t=this;setTimeout(function(){t.$overlay.width(d(document).width()).height(d(document).height())},0)},t.prototype.sizeContainer=function(t,i){var e=this,n=this.$outerContainer.outerWidth(),o=this.$outerContainer.outerHeight(),a=t+this.containerPadding.left+this.containerPadding.right+this.imageBorderWidth.left+this.imageBorderWidth.right,s=i+this.containerPadding.top+this.containerPadding.bottom+this.imageBorderWidth.top+this.imageBorderWidth.bottom;function h(){e.$lightbox.find(".lb-dataContainer").width(a),e.$lightbox.find(".lb-prevLink").height(s),e.$lightbox.find(".lb-nextLink").height(s),e.$overlay.focus(),e.showImage()}n!==a||o!==s?this.$outerContainer.animate({width:a,height:s},this.options.resizeDuration,"swing",function(){h()}):h()},t.prototype.showImage=function(){this.$lightbox.find(".lb-loader").stop(!0).hide(),this.$lightbox.find(".lb-image").fadeIn(this.options.imageFadeDuration),this.updateNav(),this.updateDetails(),this.preloadNeighboringImages(),this.enableKeyboardNav()},t.prototype.updateNav=function(){var t=!1;try{document.createEvent("TouchEvent"),t=!!this.options.alwaysShowNavOnTouchDevices}catch(t){}this.$lightbox.find(".lb-nav").show(),1<this.album.length&&(this.options.wrapAround?(t&&this.$lightbox.find(".lb-prev, .lb-next").css("opacity","1"),this.$lightbox.find(".lb-prev, .lb-next").show()):(0<this.currentImageIndex&&(this.$lightbox.find(".lb-prev").show(),t&&this.$lightbox.find(".lb-prev").css("opacity","1")),this.currentImageIndex<this.album.length-1&&(this.$lightbox.find(".lb-next").show(),t&&this.$lightbox.find(".lb-next").css("opacity","1"))))},t.prototype.updateDetails=function(){var t,i=this;void 0!==this.album[this.currentImageIndex].title&&""!==this.album[this.currentImageIndex].title&&(t=this.$lightbox.find(".lb-caption"),this.options.sanitizeTitle?t.text(this.album[this.currentImageIndex].title):t.html(this.album[this.currentImageIndex].title),t.fadeIn("fast")),1<this.album.length&&this.options.showImageNumberLabel?(t=this.imageCountLabel(this.currentImageIndex+1,this.album.length),this.$lightbox.find(".lb-number").text(t).fadeIn("fast")):this.$lightbox.find(".lb-number").hide(),this.$outerContainer.removeClass("animating"),this.$lightbox.find(".lb-dataContainer").fadeIn(this.options.resizeDuration,function(){return i.sizeOverlay()})},t.prototype.preloadNeighboringImages=function(){this.album.length>this.currentImageIndex+1&&((new Image).src=this.album[this.currentImageIndex+1].link),0<this.currentImageIndex&&((new Image).src=this.album[this.currentImageIndex-1].link)},t.prototype.enableKeyboardNav=function(){this.$lightbox.on("keyup.keyboard",d.proxy(this.keyboardAction,this)),this.$overlay.on("keyup.keyboard",d.proxy(this.keyboardAction,this))},t.prototype.disableKeyboardNav=function(){this.$lightbox.off(".keyboard"),this.$overlay.off(".keyboard")},t.prototype.keyboardAction=function(t){var i=t.keyCode;27===i?(t.stopPropagation(),this.end()):37===i?0!==this.currentImageIndex?this.changeImage(this.currentImageIndex-1):this.options.wrapAround&&1<this.album.length&&this.changeImage(this.album.length-1):39===i&&(this.currentImageIndex!==this.album.length-1?this.changeImage(this.currentImageIndex+1):this.options.wrapAround&&1<this.album.length&&this.changeImage(0))},t.prototype.end=function(){this.disableKeyboardNav(),d(window).off("resize",this.sizeOverlay),this.$lightbox.fadeOut(this.options.fadeDuration),this.$overlay.fadeOut(this.options.fadeDuration),this.options.disableScrolling&&d("body").removeClass("lb-disable-scrolling")},new t});