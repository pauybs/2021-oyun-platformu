!function(e,t){"function"==typeof define&&define.amd?define(t):"object"==typeof exports&&"string"!=typeof exports.nodeName?module.exports=t():e.Croppie=t()}("undefined"!=typeof self?self:this,function(){function n(e,t){return function(){e.apply(t,arguments)}}function e(e){if("object"!=typeof this)throw new TypeError("Promises must be constructed via new");if("function"!=typeof e)throw new TypeError("not a function");this._state=null,this._value=null,this._deferreds=[],l(e,n(i,this),n(o,this))}function r(n){var i=this;return null===this._state?void this._deferreds.push(n):void c(function(){var e,t=i._state?n.onFulfilled:n.onRejected;if(null!==t){try{e=t(i._value)}catch(e){return void n.reject(e)}n.resolve(e)}else(i._state?n.resolve:n.reject)(i._value)})}function i(e){try{if(e===this)throw new TypeError("A promise cannot be resolved with itself.");if(e&&("object"==typeof e||"function"==typeof e)){var t=e.then;if("function"==typeof t)return void l(n(t,e),n(i,this),n(o,this))}this._state=!0,this._value=e,a.call(this)}catch(e){o.call(this,e)}}function o(e){this._state=!1,this._value=e,a.call(this)}function a(){for(var e=0,t=this._deferreds.length;e<t;e++)r.call(this,this._deferreds[e]);this._deferreds=null}function s(e,t,n,i){this.onFulfilled="function"==typeof e?e:null,this.onRejected="function"==typeof t?t:null,this.resolve=n,this.reject=i}function l(e,t,n){var i=!1;try{e(function(e){i||(i=!0,t(e))},function(e){i||(i=!0,n(e))})}catch(e){if(i)return;i=!0,n(e)}}var t,u,c,h;function p(e,t){t=t||{bubbles:!1,cancelable:!1,detail:void 0};var n=document.createEvent("CustomEvent");return n.initCustomEvent(e,t.bubbles,t.cancelable,t.detail),n}"function"!=typeof Promise&&(t=this,u=setTimeout,c="function"==typeof setImmediate&&setImmediate||function(e){u(e,1)},h=Array.isArray||function(e){return"[object Array]"===Object.prototype.toString.call(e)},e.prototype.catch=function(e){return this.then(null,e)},e.prototype.then=function(n,i){var o=this;return new e(function(e,t){r.call(o,new s(n,i,e,t))})},e.all=function(){var s=Array.prototype.slice.call(1===arguments.length&&h(arguments[0])?arguments[0]:arguments);return new e(function(o,r){if(0===s.length)return o([]);for(var a=s.length,e=0;e<s.length;e++)!function t(n,e){try{if(e&&("object"==typeof e||"function"==typeof e)){var i=e.then;if("function"==typeof i)return i.call(e,function(e){t(n,e)},r),0}s[n]=e,0==--a&&o(s)}catch(e){r(e)}}(e,s[e])})},e.resolve=function(t){return t&&"object"==typeof t&&t.constructor===e?t:new e(function(e){e(t)})},e.reject=function(n){return new e(function(e,t){t(n)})},e.race=function(o){return new e(function(e,t){for(var n=0,i=o.length;n<i;n++)o[n].then(e,t)})},e._setImmediateFn=function(e){c=e},"undefined"!=typeof module&&module.exports?module.exports=e:t.Promise||(t.Promise=e)),"undefined"!=typeof window&&"function"!=typeof window.CustomEvent&&(p.prototype=window.Event.prototype,window.CustomEvent=p),"undefined"==typeof HTMLCanvasElement||HTMLCanvasElement.prototype.toBlob||Object.defineProperty(HTMLCanvasElement.prototype,"toBlob",{value:function(e,t,n){for(var i=atob(this.toDataURL(t,n).split(",")[1]),o=i.length,r=new Uint8Array(o),a=0;a<o;a++)r[a]=i.charCodeAt(a);e(new Blob([r],{type:t||"image/png"}))}});var d,m,f,v=["Webkit","Moz","ms"],g="undefined"!=typeof document?document.createElement("div").style:{},w=[1,8,3,6],y=[2,7,4,5];function b(e){if(e in g)return e;for(var t=e[0].toUpperCase()+e.slice(1),n=v.length;n--;)if((e=v[n]+t)in g)return e}function x(e,t){for(var n in e=e||{},t)t[n]&&t[n].constructor&&t[n].constructor===Object?(e[n]=e[n]||{},x(e[n],t[n])):e[n]=t[n];return e}function C(e){return x({},e)}function E(e){var t;"createEvent"in document?((t=document.createEvent("HTMLEvents")).initEvent("change",!1,!0),e.dispatchEvent(t)):e.fireEvent("onchange")}function _(e,t,n){var i,o;for(o in"string"==typeof t&&(i=t,(t={})[i]=n),t)e.style[o]=t[o]}function L(e,t){e.classList?e.classList.add(t):e.className+=" "+t}function R(e,t){for(var n in t)e.setAttribute(n,t[n])}function B(e){return parseInt(e,10)}function Z(e,t){var n=e.naturalWidth,i=e.naturalHeight,e=t||F(e);return e&&5<=e&&(e=n,n=i,i=e),{width:n,height:i}}m=b("transform"),d=b("transformOrigin"),f=b("userSelect");var I={translate3d:{suffix:", 0px"},translate:{suffix:""}},M=function(e,t,n){this.x=parseFloat(e),this.y=parseFloat(t),this.scale=parseFloat(n)};M.parse=function(e){return e.style?M.parse(e.style[m]):-1<e.indexOf("matrix")||-1<e.indexOf("none")?M.fromMatrix(e):M.fromString(e)},M.fromMatrix=function(e){var t=e.substring(7).split(",");return t.length&&"none"!==e||(t=[1,0,0,1,0,0]),new M(B(t[4]),B(t[5]),parseFloat(t[0]))},M.fromString=function(e){var t=e.split(") "),n=t[0].substring(ie.globals.translate.length+1).split(","),e=1<t.length?t[1].substring(6):1,t=1<n.length?n[0]:0,n=1<n.length?n[1]:0;return new M(t,n,e)},M.prototype.toString=function(){var e=I[ie.globals.translate].suffix||"";return ie.globals.translate+"("+this.x+"px, "+this.y+"px"+e+") scale("+this.scale+")"};var z=function(e){if(!e||!e.style[d])return this.x=0,void(this.y=0);e=e.style[d].split(" ");this.x=parseFloat(e[0]),this.y=parseFloat(e[1])};function F(e){return e.exifdata&&e.exifdata.Orientation?B(e.exifdata.Orientation):1}function W(e,t,n){var i=t.width,o=t.height,r=e.getContext("2d");switch(e.width=t.width,e.height=t.height,r.save(),n){case 2:r.translate(i,0),r.scale(-1,1);break;case 3:r.translate(i,o),r.rotate(180*Math.PI/180);break;case 4:r.translate(0,o),r.scale(1,-1);break;case 5:e.width=o,e.height=i,r.rotate(90*Math.PI/180),r.scale(1,-1);break;case 6:e.width=o,e.height=i,r.rotate(90*Math.PI/180),r.translate(0,-o);break;case 7:e.width=o,e.height=i,r.rotate(-90*Math.PI/180),r.translate(-i,o),r.scale(1,-1);break;case 8:e.width=o,e.height=i,r.translate(0,i),r.rotate(-90*Math.PI/180)}r.drawImage(t,0,0,i,o),r.restore()}function X(){var e,t,n,i,o,r=this,a=r.options.viewport.type?"cr-vp-"+r.options.viewport.type:null;r.options.useCanvas=r.options.enableOrientation||Y.call(r),r.data={},r.elements={},e=r.elements.boundary=document.createElement("div"),t=r.elements.viewport=document.createElement("div"),o=r.elements.img=document.createElement("img"),n=r.elements.overlay=document.createElement("div"),r.options.useCanvas?(r.elements.canvas=document.createElement("canvas"),r.elements.preview=r.elements.canvas):r.elements.preview=o,L(e,"cr-boundary"),e.setAttribute("aria-dropeffect","none"),i=r.options.boundary.width,o=r.options.boundary.height,_(e,{width:i+(isNaN(i)?"":"px"),height:o+(isNaN(o)?"":"px")}),L(t,"cr-viewport"),a&&L(t,a),_(t,{width:r.options.viewport.width+"px",height:r.options.viewport.height+"px"}),t.setAttribute("tabindex",0),L(r.elements.preview,"cr-image"),R(r.elements.preview,{alt:"preview","aria-grabbed":"false"}),L(n,"cr-overlay"),r.element.appendChild(e),e.appendChild(r.elements.preview),e.appendChild(t),e.appendChild(n),L(r.element,"croppie-container"),r.options.customClass&&L(r.element,r.options.customClass),function(){var s,l,u,r,c,h=this,t=!1;function p(e,t){var n=h.elements.preview.getBoundingClientRect(),i=c.y+t,o=c.x+e;h.options.enforceBoundary?(r.top>n.top+t&&r.bottom<n.bottom+t&&(c.y=i),r.left>n.left+e&&r.right<n.right+e&&(c.x=o)):(c.y=i,c.x=o)}function n(e){h.elements.preview.setAttribute("aria-grabbed",e),h.elements.boundary.setAttribute("aria-dropeffect",e?"move":"none")}function e(e){void 0!==e.button&&0!==e.button||(e.preventDefault(),t||(t=!0,s=e.pageX,l=e.pageY,e.touches&&(e=e.touches[0],s=e.pageX,l=e.pageY),n(t),c=M.parse(h.elements.preview),window.addEventListener("mousemove",i),window.addEventListener("touchmove",i),window.addEventListener("mouseup",o),window.addEventListener("touchend",o),document.body.style[f]="none",r=h.elements.viewport.getBoundingClientRect()))}function i(e){e.preventDefault();var t=e.pageX,n=e.pageY;e.touches&&(t=(a=e.touches[0]).pageX,n=a.pageY);var i=t-s,o=n-l,r={};if("touchmove"===e.type&&1<e.touches.length){var a=e.touches[0],e=e.touches[1],e=Math.sqrt((a.pageX-e.pageX)*(a.pageX-e.pageX)+(a.pageY-e.pageY)*(a.pageY-e.pageY));return u=u||e/h._currentZoom,H.call(h,e/u),void E(h.elements.zoomer)}p(i,o),r[m]=c.toString(),_(h.elements.preview,r),k.call(h),l=n,s=t}function o(){n(t=!1),window.removeEventListener("mousemove",i),window.removeEventListener("touchmove",i),window.removeEventListener("mouseup",o),window.removeEventListener("touchend",o),document.body.style[f]="",O.call(h),T.call(h),u=0}h.elements.overlay.addEventListener("mousedown",e),h.elements.viewport.addEventListener("keydown",function(e){var t,n,i;!e.shiftKey||38!==e.keyCode&&40!==e.keyCode?h.options.enableKeyMovement&&37<=e.keyCode&&e.keyCode<=40&&(e.preventDefault(),i=function(e){switch(e){case 37:return[1,0];case 38:return[0,1];case 39:return[-1,0];case 40:return[0,-1]}}(e.keyCode),c=M.parse(h.elements.preview),document.body.style[f]="none",r=h.elements.viewport.getBoundingClientRect(),n=(t=i)[0],i=t[1],t={},p(n,i),t[m]=c.toString(),_(h.elements.preview,t),k.call(h),document.body.style[f]="",O.call(h),T.call(h),u=0):(e=38===e.keyCode?parseFloat(h.elements.zoomer.value)+parseFloat(h.elements.zoomer.step):parseFloat(h.elements.zoomer.value)-parseFloat(h.elements.zoomer.step),h.setZoom(e))}),h.elements.overlay.addEventListener("touchstart",e)}.call(this),r.options.enableZoom&&function(){var n=this,e=n.elements.zoomerWrap=document.createElement("div"),t=n.elements.zoomer=document.createElement("input");function i(){(function(e){var t=this,n=e?e.transform:M.parse(t.elements.preview),i=e?e.viewportRect:t.elements.viewport.getBoundingClientRect(),o=e?e.origin:new z(t.elements.preview);function r(){var e={};e[m]=n.toString(),e[d]=o.toString(),_(t.elements.preview,e)}t._currentZoom=e?e.value:t._currentZoom,n.scale=t._currentZoom,t.elements.zoomer.setAttribute("aria-valuenow",t._currentZoom),r(),t.options.enforceBoundary&&(e=function(e){var t=this._currentZoom,n=e.width,i=e.height,o=this.elements.boundary.clientWidth/2,r=this.elements.boundary.clientHeight/2,a=this.elements.preview.getBoundingClientRect(),s=a.width,l=a.height,e=n/2,a=i/2,o=-1*(e/t-o),r=-1*(a/t-r),e=1/t*e,a=1/t*a;return{translate:{maxX:o,minX:o-(s*(1/t)-n*(1/t)),maxY:r,minY:r-(l*(1/t)-i*(1/t))},origin:{maxX:s*(1/t)-e,minX:e,maxY:l*(1/t)-a,minY:a}}}.call(t,i),i=e.translate,e=e.origin,n.x>=i.maxX&&(o.x=e.minX,n.x=i.maxX),n.x<=i.minX&&(o.x=e.maxX,n.x=i.minX),n.y>=i.maxY&&(o.y=e.minY,n.y=i.maxY),n.y<=i.minY&&(o.y=e.maxY,n.y=i.minY));r(),P.call(t),T.call(t)}).call(n,{value:parseFloat(t.value),origin:new z(n.elements.preview),viewportRect:n.elements.viewport.getBoundingClientRect(),transform:M.parse(n.elements.preview)})}function o(e){var t;if("ctrl"===n.options.mouseWheelZoom&&!0!==e.ctrlKey)return 0;t=e.wheelDelta?e.wheelDelta/1200:e.deltaY?e.deltaY/1060:e.detail?e.detail/-60:0,t=n._currentZoom+t*n._currentZoom,e.preventDefault(),H.call(n,t),i.call(n)}L(e,"cr-slider-wrap"),L(t,"cr-slider"),t.type="range",t.step="0.0001",t.value="1",t.style.display=n.options.showZoomer?"":"none",t.setAttribute("aria-label","zoom"),n.element.appendChild(e),e.appendChild(t),n._currentZoom=1,n.elements.zoomer.addEventListener("input",i),n.elements.zoomer.addEventListener("change",i),n.options.mouseWheelZoom&&(n.elements.boundary.addEventListener("mousewheel",o),n.elements.boundary.addEventListener("DOMMouseScroll",o))}.call(r),r.options.enableResize&&function(){var a,s,l,u,c,e,t,h=this,p=document.createElement("div"),n=!1,d=50;L(p,"cr-resizer"),_(p,{width:this.options.viewport.width+"px",height:this.options.viewport.height+"px"}),this.options.resizeControls.height&&(L(e=document.createElement("div"),"cr-resizer-vertical"),p.appendChild(e));this.options.resizeControls.width&&(L(t=document.createElement("div"),"cr-resizer-horisontal"),p.appendChild(t));function i(e){var t;void 0!==e.button&&0!==e.button||(e.preventDefault(),n||(t=h.elements.overlay.getBoundingClientRect(),n=!0,s=e.pageX,l=e.pageY,a=-1!==e.currentTarget.className.indexOf("vertical")?"v":"h",u=t.width,c=t.height,e.touches&&(e=e.touches[0],s=e.pageX,l=e.pageY),window.addEventListener("mousemove",o),window.addEventListener("touchmove",o),window.addEventListener("mouseup",r),window.addEventListener("touchend",r),document.body.style[f]="none"))}function o(e){var t=e.pageX,n=e.pageY;e.preventDefault(),e.touches&&(t=(r=e.touches[0]).pageX,n=r.pageY);var i=t-s,o=n-l,e=h.options.viewport.height+o,r=h.options.viewport.width+i;"v"===a&&d<=e&&e<=c?(_(p,{height:e+"px"}),h.options.boundary.height+=o,_(h.elements.boundary,{height:h.options.boundary.height+"px"}),h.options.viewport.height+=o,_(h.elements.viewport,{height:h.options.viewport.height+"px"})):"h"===a&&d<=r&&r<=u&&(_(p,{width:r+"px"}),h.options.boundary.width+=i,_(h.elements.boundary,{width:h.options.boundary.width+"px"}),h.options.viewport.width+=i,_(h.elements.viewport,{width:h.options.viewport.width+"px"})),k.call(h),K.call(h),O.call(h),T.call(h),l=n,s=t}function r(){n=!1,window.removeEventListener("mousemove",o),window.removeEventListener("touchmove",o),window.removeEventListener("mouseup",r),window.removeEventListener("touchend",r),document.body.style[f]=""}e&&(e.addEventListener("mousedown",i),e.addEventListener("touchstart",i));t&&(t.addEventListener("mousedown",i),t.addEventListener("touchstart",i));this.elements.boundary.appendChild(p)}.call(r)}function Y(){return this.options.enableExif&&window.EXIF}function H(e){var t;this.options.enableZoom&&(t=this.elements.zoomer,e=Q(e,4),t.value=Math.max(parseFloat(t.min),Math.min(parseFloat(t.max),e)).toString())}function O(e){var t,n=this,i=n._currentZoom,o=n.elements.preview.getBoundingClientRect(),r=n.elements.viewport.getBoundingClientRect(),a=M.parse(n.elements.preview.style[m]),s=new z(n.elements.preview),l=r.top-o.top+r.height/2,u=r.left-o.left+r.width/2,c={},h={};e?(t=s.x,o=s.y,r=a.x,e=a.y,c.y=t,c.x=o,a.y=r,a.x=e):(c.y=l/i,c.x=u/i,h.y=(c.y-s.y)*(1-i),h.x=(c.x-s.x)*(1-i),a.x-=h.x,a.y-=h.y);h={};h[d]=c.x+"px "+c.y+"px",h[m]=a.toString(),_(n.elements.preview,h)}function k(){var e,t;this.elements&&(e=this.elements.boundary.getBoundingClientRect(),t=this.elements.preview.getBoundingClientRect(),_(this.elements.overlay,{width:t.width+"px",height:t.height+"px",top:t.top-e.top+"px",left:t.left-e.left+"px"}))}z.prototype.toString=function(){return this.x+"px "+this.y+"px"};var A,S,j,N,P=(A=k,S=500,function(){var e=this,t=arguments,n=j&&!N;clearTimeout(N),N=setTimeout(function(){N=null,j||A.apply(e,t)},S),n&&A.apply(e,t)});function T(){var e,t=this,n=t.get();D.call(t)&&(t.options.update.call(t,n),t.$&&"undefined"==typeof Prototype?t.$(t.element).trigger("update.croppie",n):(window.CustomEvent?e=new CustomEvent("update",{detail:n}):(e=document.createEvent("CustomEvent")).initCustomEvent("update",!0,!0,n),t.element.dispatchEvent(e)))}function D(){return 0<this.elements.preview.offsetHeight&&0<this.elements.preview.offsetWidth}function q(){var e=this,t={},n=e.elements.preview,i=new M(0,0,1),o=new z;D.call(e)&&!e.data.bound&&(e.data.bound=!0,t[m]=i.toString(),t[d]=o.toString(),t.opacity=1,_(n,t),o=e.elements.preview.getBoundingClientRect(),e._originalImageWidth=o.width,e._originalImageHeight=o.height,e.data.orientation=Y.call(e)?F(e.elements.img):e.data.orientation,e.options.enableZoom?K.call(e,!0):e._currentZoom=1,i.scale=e._currentZoom,t[m]=i.toString(),_(n,t),e.data.points.length?function(e){if(4!==e.length)throw"Croppie - Invalid number of points supplied: "+e;var t=this,n=e[2]-e[0],i=t.elements.viewport.getBoundingClientRect(),o=t.elements.boundary.getBoundingClientRect(),r=i.left-o.left,a=i.top-o.top,o=i.width/n,i=e[1],n=e[0],a=-1*e[1]+a,e=-1*e[0]+r,r={};r[d]=n+"px "+i+"px",r[m]=new M(e,a,o).toString(),_(t.elements.preview,r),H.call(t,o),t._currentZoom=o}.call(e,e.data.points):function(){var e=this,t=e.elements.preview.getBoundingClientRect(),n=e.elements.viewport.getBoundingClientRect(),i=e.elements.boundary.getBoundingClientRect(),o=n.left-i.left,i=n.top-i.top,o=o-(t.width-n.width)/2,n=i-(t.height-n.height)/2,n=new M(o,n,e._currentZoom);_(e.elements.preview,m,n.toString())}.call(e),O.call(e),k.call(e))}function K(e){var t,n=this,i=Math.max(n.options.minZoom,0)||0,o=n.options.maxZoom||1.5,r=n.elements.zoomer,a=parseFloat(r.value),s=n.elements.boundary.getBoundingClientRect(),l=Z(n.elements.img,n.data.orientation),u=n.elements.viewport.getBoundingClientRect();n.options.enforceBoundary&&(t=u.width/l.width,u=u.height/l.height,i=Math.max(t,u)),o<=i&&(o=i+1),r.min=Q(i,4),r.max=Q(o,4),!e&&(a<r.min||a>r.max)?H.call(n,a<r.min?r.min:r.max):e&&(l=Math.max(s.width/l.width,s.height/l.height),l=null!==n.data.boundZoom?n.data.boundZoom:l,H.call(n,l)),E(r)}function U(e){var t=e.points,n=B(t[0]),i=B(t[1]),o=B(t[2])-n,r=B(t[3])-i,a=e.circle,s=document.createElement("canvas"),l=s.getContext("2d"),u=e.outputWidth||o,c=e.outputHeight||r;s.width=u,s.height=c,e.backgroundColor&&(l.fillStyle=e.backgroundColor,l.fillRect(0,0,u,c));var h=n,p=i,d=o,m=r,f=0,v=0,t=u,e=c;return n<0&&(h=0,f=Math.abs(n)/o*u),d+h>this._originalImageWidth&&(t=(d=this._originalImageWidth-h)/o*u),i<0&&(p=0,v=Math.abs(i)/r*c),m+p>this._originalImageHeight&&(e=(m=this._originalImageHeight-p)/r*c),l.drawImage(this.elements.preview,h,p,d,m,f,v,t,e),a&&(l.fillStyle="#fff",l.globalCompositeOperation="destination-in",l.beginPath(),l.arc(s.width/2,s.height/2,s.width/2,0,2*Math.PI,!0),l.closePath(),l.fill()),s}function $(o,r){var e,a=this,s=[],t=null,n=Y.call(a);if("string"==typeof o)e=o,o={};else if(Array.isArray(o))s=o.slice();else{if(void 0===o&&a.data.url)return q.call(a),T.call(a),null;e=o.url,s=o.points||[],t=void 0===o.zoom?null:o.zoom}return a.data.bound=!1,a.data.url=e||a.data.url,a.data.boundZoom=t,function(i,o){if(!i)throw"Source image missing";var r=new Image;return r.style.opacity="0",new Promise(function(e,t){function n(){r.style.opacity="1",setTimeout(function(){e(r)},1)}r.removeAttribute("crossOrigin"),i.match(/^https?:\/\/|^\/\//)&&r.setAttribute("crossOrigin","anonymous"),r.onload=function(){o?EXIF.getData(r,function(){n()}):n()},r.onerror=function(e){r.style.opacity=1,setTimeout(function(){t(e)},1)},r.src=i})}(e,n).then(function(e){var t,n,i;(function(t){this.elements.img.parentNode&&(Array.prototype.forEach.call(this.elements.img.classList,function(e){t.classList.add(e)}),this.elements.img.parentNode.replaceChild(t,this.elements.img),this.elements.preview=t),this.elements.img=t}).call(a,e),s.length?a.options.relative&&(s=[s[0]*e.naturalWidth/100,s[1]*e.naturalHeight/100,s[2]*e.naturalWidth/100,s[3]*e.naturalHeight/100]):(t=Z(e),(e=(e=a.elements.viewport.getBoundingClientRect()).width/e.height)<t.width/t.height?n=(i=t.height)*e:(n=t.width,i=t.height/e),n=(e=(t.width-n)/2)+n,i=(t=(t.height-i)/2)+i,a.data.points=[e,t,n,i]),a.data.orientation=o.orientation||1,a.data.points=s.map(function(e){return parseFloat(e)}),a.options.useCanvas&&function(e){var t=this.elements.canvas,n=this.elements.img;t.getContext("2d").clearRect(0,0,t.width,t.height),t.width=n.width,t.height=n.height,W(t,n,this.options.enableOrientation&&e||F(n))}.call(a,a.data.orientation),q.call(a),T.call(a),r&&r()})}function Q(e,t){return parseFloat(e).toFixed(t||0)}function G(){var e=this,t=e.elements.preview.getBoundingClientRect(),n=e.elements.viewport.getBoundingClientRect(),i=n.left-t.left,o=n.top-t.top,r=(n.width-e.elements.viewport.offsetWidth)/2,a=(n.height-e.elements.viewport.offsetHeight)/2,t=i+e.elements.viewport.offsetWidth+r,n=o+e.elements.viewport.offsetHeight+a,r=e._currentZoom;r!==1/0&&!isNaN(r)||(r=1);a=e.options.enforceBoundary?0:Number.NEGATIVE_INFINITY,i=Math.max(a,i/r),o=Math.max(a,o/r),t=Math.max(a,t/r),n=Math.max(a,n/r);return{points:[Q(i),Q(o),Q(t),Q(n)],zoom:r,orientation:e.data.orientation}}var V,J={type:"canvas",format:"png",quality:1},ee=["jpeg","webp","png"];function te(e){var t=this,n=G.call(t),i=x(C(J),C(e)),o="string"==typeof e?e:i.type||"base64",r=i.size||"viewport",a=i.format,s=i.quality,l=i.backgroundColor,u="boolean"==typeof i.circle?i.circle:"circle"===t.options.viewport.type,e=t.elements.viewport.getBoundingClientRect(),i=e.width/e.height;return"viewport"===r?(n.outputWidth=e.width,n.outputHeight=e.height):"object"==typeof r&&(r.width&&r.height?(n.outputWidth=r.width,n.outputHeight=r.height):r.width?(n.outputWidth=r.width,n.outputHeight=r.width/i):r.height&&(n.outputWidth=r.height*i,n.outputHeight=r.height)),-1<ee.indexOf(a)&&(n.format="image/"+a,n.quality=s),n.circle=u,n.url=t.data.url,n.backgroundColor=l,new Promise(function(e){switch(o.toLowerCase()){case"rawcanvas":e(U.call(t,n));break;case"canvas":case"base64":e(function(e){return U.call(this,e).toDataURL(e.format,e.quality)}.call(t,n));break;case"blob":(function(e){var n=this;return new Promise(function(t){U.call(n,e).toBlob(function(e){t(e)},e.format,e.quality)})}).call(t,n).then(e);break;default:e(function(e){var t=e.points,n=document.createElement("div"),i=document.createElement("img"),o=t[2]-t[0],r=t[3]-t[1];return L(n,"croppie-result"),n.appendChild(i),_(i,{left:-1*t[0]+"px",top:-1*t[1]+"px"}),i.src=e.url,_(n,{width:o+"px",height:r+"px"}),n}.call(t,n))}})}function ne(e){if(!this.options.useCanvas||!this.options.enableOrientation)throw"Croppie: Cannot rotate without enableOrientation && EXIF.js included";var t,n,i,o=this,r=o.elements.canvas;o.data.orientation=(t=o.data.orientation,n=e,i=-1<w.indexOf(t)?w:y,t=i.indexOf(t),n=n/90%i.length,i[(i.length+t+n%i.length)%i.length]),W(r,o.elements.img,o.data.orientation),O.call(o,!0),K.call(o),Math.abs(e)/90%2==1&&(r=o._originalImageHeight,e=o._originalImageWidth,o._originalImageWidth=r,o._originalImageHeight=e)}function ie(e,t){if(-1<e.className.indexOf("croppie-container"))throw new Error("Croppie: Can't initialize croppie more than once");var n;this.element=e,this.options=x(C(ie.defaults),t),"img"===this.element.tagName.toLowerCase()&&(L(n=this.element,"cr-original-image"),R(n,{"aria-hidden":"true",alt:""}),t=document.createElement("div"),this.element.parentNode.appendChild(t),t.appendChild(n),this.element=t,this.options.url=this.options.url||n.src),X.call(this),this.options.url&&(n={url:this.options.url,points:this.options.points},delete this.options.url,delete this.options.points,$.call(this,n))}return"undefined"!=typeof window&&window.jQuery&&((V=window.jQuery).fn.croppie=function(n){if("string"!=typeof n)return this.each(function(){var e=new ie(this,n);(e.$=V)(this).data("croppie",e)});var i=Array.prototype.slice.call(arguments,1),e=V(this).data("croppie");return"get"===n?e.get():"result"===n?e.result.apply(e,i):"bind"===n?e.bind.apply(e,i):this.each(function(){var e=V(this).data("croppie");if(e){var t=e[n];if(!V.isFunction(t))throw"Croppie "+n+" method not found";t.apply(e,i),"destroy"===n&&V(this).removeData("croppie")}})}),ie.defaults={viewport:{width:100,height:100,type:"square"},boundary:{},orientationControls:{enabled:!0,leftClass:"",rightClass:""},resizeControls:{width:!0,height:!0},customClass:"",showZoomer:!0,enableZoom:!0,enableResize:!1,mouseWheelZoom:!0,enableExif:!1,enforceBoundary:!0,enableOrientation:!1,enableKeyMovement:!0,update:function(){}},ie.globals={translate:"translate3d"},x(ie.prototype,{bind:function(e,t){return $.call(this,e,t)},get:function(){var e=G.call(this),t=e.points;return this.options.relative&&(t[0]/=this.elements.img.naturalWidth/100,t[1]/=this.elements.img.naturalHeight/100,t[2]/=this.elements.img.naturalWidth/100,t[3]/=this.elements.img.naturalHeight/100),e},result:function(e){return te.call(this,e)},refresh:function(){return function(){q.call(this)}.call(this)},setZoom:function(e){H.call(this,e),E(this.elements.zoomer)},rotate:function(e){ne.call(this,e)},destroy:function(){return function(){var e,t,n=this;n.element.removeChild(n.elements.boundary),e=n.element,t="croppie-container",e.classList?e.classList.remove(t):e.className=e.className.replace(t,""),n.options.enableZoom&&n.element.removeChild(n.elements.zoomerWrap),delete n.elements}.call(this)}}),ie});