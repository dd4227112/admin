<!DOCTYPE html>
<?php $root = url('/') . '/public/' ?>
<style>
    /*!
 * Bootstrap v3.3.7 (http://getbootstrap.com)
 * Copyright 2011-2016 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 *//*! normalize.css v3.0.3 | MIT License | github.com/necolas/normalize.css */html{font-family:sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}body{margin:0}article,aside,details,figcaption,figure,footer,header,hgroup,main,menu,nav,section,summary{display:block}audio,canvas,progress,video{display:inline-block;vertical-align:baseline}audio:not([controls]){display:none;height:0}[hidden],template{display:none}a{background-color:transparent}a:active,a:hover{outline:0}abbr[title]{border-bottom:1px dotted}b,strong{font-weight:700}dfn{font-style:italic}h1{margin:.67em 0;font-size:2em}mark{color:#000;background:#ff0}small{font-size:80%}sub,sup{position:relative;font-size:75%;line-height:0;vertical-align:baseline}sup{top:-.5em}sub{bottom:-.25em}img{border:0}svg:not(:root){overflow:hidden}figure{margin:1em 40px}hr{height:0;-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box}pre{overflow:auto}code,kbd,pre,samp{font-family:monospace,monospace;font-size:1em}button,input,optgroup,select,textarea{margin:0;font:inherit;color:inherit}button{overflow:visible}button,select{text-transform:none}button,html input[type=button],input[type=reset],input[type=submit]{-webkit-appearance:button;cursor:pointer}button[disabled],html input[disabled]{cursor:default}button::-moz-focus-inner,input::-moz-focus-inner{padding:0;border:0}input{line-height:normal}input[type=checkbox],input[type=radio]{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;padding:0}input[type=number]::-webkit-inner-spin-button,input[type=number]::-webkit-outer-spin-button{height:auto}input[type=search]{-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;-webkit-appearance:textfield}input[type=search]::-webkit-search-cancel-button,input[type=search]::-webkit-search-decoration{-webkit-appearance:none}fieldset{padding:.35em .625em .75em;margin:0 2px;border:1px solid silver}legend{padding:0;border:0}textarea{overflow:auto}optgroup{font-weight:700}table{border-spacing:0;border-collapse:collapse}td,th{padding:0}/*! Source: https://github.com/h5bp/html5-boilerplate/blob/master/src/css/main.css */@media print{*,:after,:before{color:#000!important;text-shadow:none!important;background:0 0!important;-webkit-box-shadow:none!important;box-shadow:none!important}a,a:visited{text-decoration:underline}a[href]:after{content:" (" attr(href) ")"}abbr[title]:after{content:" (" attr(title) ")"}a[href^="javascript:"]:after,a[href^="#"]:after{content:""}blockquote,pre{border:1px solid #999;page-break-inside:avoid}thead{display:table-header-group}img,tr{page-break-inside:avoid}img{max-width:100%!important}h2,h3,p{orphans:3;widows:3}h2,h3{page-break-after:avoid}.navbar{display:none}.btn>.caret,.dropup>.btn>.caret{border-top-color:#000!important}.label{border:1px solid #000}.table{border-collapse:collapse!important}.table td,.table th{background-color:#fff!important}.table-bordered td,.table-bordered th{border:1px solid #ddd!important}}@font-face{font-family:'Glyphicons Halflings';src:url(../fonts/glyphicons-halflings-regular.eot);src:url(../fonts/glyphicons-halflings-regulard41d.eot?#iefix) format('embedded-opentype'),url(../fonts/glyphicons-halflings-regular.html) format('woff2'),url(../fonts/glyphicons-halflings-regular.woff) format('woff'),url(../fonts/glyphicons-halflings-regular.ttf) format('truetype'),url(../fonts/glyphicons-halflings-regular.svg#glyphicons_halflingsregular) format('svg')}.glyphicon{position:relative;top:1px;display:inline-block;font-family:'Glyphicons Halflings';font-style:normal;font-weight:400;line-height:1;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.glyphicon-asterisk:before{content:"\002a"}.glyphicon-plus:before{content:"\002b"}.glyphicon-eur:before,.glyphicon-euro:before{content:"\20ac"}.glyphicon-minus:before{content:"\2212"}.glyphicon-cloud:before{content:"\2601"}.glyphicon-envelope:before{content:"\2709"}.glyphicon-pencil:before{content:"\270f"}.glyphicon-glass:before{content:"\e001"}.glyphicon-music:before{content:"\e002"}.glyphicon-search:before{content:"\e003"}.glyphicon-heart:before{content:"\e005"}.glyphicon-star:before{content:"\e006"}.glyphicon-star-empty:before{content:"\e007"}.glyphicon-user:before{content:"\e008"}.glyphicon-film:before{content:"\e009"}.glyphicon-th-large:before{content:"\e010"}.glyphicon-th:before{content:"\e011"}.glyphicon-th-list:before{content:"\e012"}.glyphicon-ok:before{content:"\e013"}.glyphicon-remove:before{content:"\e014"}.glyphicon-zoom-in:before{content:"\e015"}.glyphicon-zoom-out:before{content:"\e016"}.glyphicon-off:before{content:"\e017"}.glyphicon-signal:before{content:"\e018"}.glyphicon-cog:before{content:"\e019"}.glyphicon-trash:before{content:"\e020"}.glyphicon-home:before{content:"\e021"}.glyphicon-file:before{content:"\e022"}.glyphicon-time:before{content:"\e023"}.glyphicon-road:before{content:"\e024"}.glyphicon-download-alt:before{content:"\e025"}.glyphicon-download:before{content:"\e026"}.glyphicon-upload:before{content:"\e027"}.glyphicon-inbox:before{content:"\e028"}.glyphicon-play-circle:before{content:"\e029"}.glyphicon-repeat:before{content:"\e030"}.glyphicon-refresh:before{content:"\e031"}.glyphicon-list-alt:before{content:"\e032"}.glyphicon-lock:before{content:"\e033"}.glyphicon-flag:before{content:"\e034"}.glyphicon-headphones:before{content:"\e035"}.glyphicon-volume-off:before{content:"\e036"}.glyphicon-volume-down:before{content:"\e037"}.glyphicon-volume-up:before{content:"\e038"}.glyphicon-qrcode:before{content:"\e039"}.glyphicon-barcode:before{content:"\e040"}.glyphicon-tag:before{content:"\e041"}.glyphicon-tags:before{content:"\e042"}.glyphicon-book:before{content:"\e043"}.glyphicon-bookmark:before{content:"\e044"}.glyphicon-print:before{content:"\e045"}.glyphicon-camera:before{content:"\e046"}.glyphicon-font:before{content:"\e047"}.glyphicon-bold:before{content:"\e048"}.glyphicon-italic:before{content:"\e049"}.glyphicon-text-height:before{content:"\e050"}.glyphicon-text-width:before{content:"\e051"}.glyphicon-align-left:before{content:"\e052"}.glyphicon-align-center:before{content:"\e053"}.glyphicon-align-right:before{content:"\e054"}.glyphicon-align-justify:before{content:"\e055"}.glyphicon-list:before{content:"\e056"}.glyphicon-indent-left:before{content:"\e057"}.glyphicon-indent-right:before{content:"\e058"}.glyphicon-facetime-video:before{content:"\e059"}.glyphicon-picture:before{content:"\e060"}.glyphicon-map-marker:before{content:"\e062"}.glyphicon-adjust:before{content:"\e063"}.glyphicon-tint:before{content:"\e064"}.glyphicon-edit:before{content:"\e065"}.glyphicon-share:before{content:"\e066"}.glyphicon-check:before{content:"\e067"}.glyphicon-move:before{content:"\e068"}.glyphicon-step-backward:before{content:"\e069"}.glyphicon-fast-backward:before{content:"\e070"}.glyphicon-backward:before{content:"\e071"}.glyphicon-play:before{content:"\e072"}.glyphicon-pause:before{content:"\e073"}.glyphicon-stop:before{content:"\e074"}.glyphicon-forward:before{content:"\e075"}.glyphicon-fast-forward:before{content:"\e076"}.glyphicon-step-forward:before{content:"\e077"}.glyphicon-eject:before{content:"\e078"}.glyphicon-chevron-left:before{content:"\e079"}.glyphicon-chevron-right:before{content:"\e080"}.glyphicon-plus-sign:before{content:"\e081"}.glyphicon-minus-sign:before{content:"\e082"}.glyphicon-remove-sign:before{content:"\e083"}.glyphicon-ok-sign:before{content:"\e084"}.glyphicon-question-sign:before{content:"\e085"}.glyphicon-info-sign:before{content:"\e086"}.glyphicon-screenshot:before{content:"\e087"}.glyphicon-remove-circle:before{content:"\e088"}.glyphicon-ok-circle:before{content:"\e089"}.glyphicon-ban-circle:before{content:"\e090"}.glyphicon-arrow-left:before{content:"\e091"}.glyphicon-arrow-right:before{content:"\e092"}.glyphicon-arrow-up:before{content:"\e093"}.glyphicon-arrow-down:before{content:"\e094"}.glyphicon-share-alt:before{content:"\e095"}.glyphicon-resize-full:before{content:"\e096"}.glyphicon-resize-small:before{content:"\e097"}.glyphicon-exclamation-sign:before{content:"\e101"}.glyphicon-gift:before{content:"\e102"}.glyphicon-leaf:before{content:"\e103"}.glyphicon-fire:before{content:"\e104"}.glyphicon-eye-open:before{content:"\e105"}.glyphicon-eye-close:before{content:"\e106"}.glyphicon-warning-sign:before{content:"\e107"}.glyphicon-plane:before{content:"\e108"}.glyphicon-calendar:before{content:"\e109"}.glyphicon-random:before{content:"\e110"}.glyphicon-comment:before{content:"\e111"}.glyphicon-magnet:before{content:"\e112"}.glyphicon-chevron-up:before{content:"\e113"}.glyphicon-chevron-down:before{content:"\e114"}.glyphicon-retweet:before{content:"\e115"}.glyphicon-shopping-cart:before{content:"\e116"}.glyphicon-folder-close:before{content:"\e117"}.glyphicon-folder-open:before{content:"\e118"}.glyphicon-resize-vertical:before{content:"\e119"}.glyphicon-resize-horizontal:before{content:"\e120"}.glyphicon-hdd:before{content:"\e121"}.glyphicon-bullhorn:before{content:"\e122"}.glyphicon-bell:before{content:"\e123"}.glyphicon-certificate:before{content:"\e124"}.glyphicon-thumbs-up:before{content:"\e125"}.glyphicon-thumbs-down:before{content:"\e126"}.glyphicon-hand-right:before{content:"\e127"}.glyphicon-hand-left:before{content:"\e128"}.glyphicon-hand-up:before{content:"\e129"}.glyphicon-hand-down:before{content:"\e130"}.glyphicon-circle-arrow-right:before{content:"\e131"}.glyphicon-circle-arrow-left:before{content:"\e132"}.glyphicon-circle-arrow-up:before{content:"\e133"}.glyphicon-circle-arrow-down:before{content:"\e134"}.glyphicon-globe:before{content:"\e135"}.glyphicon-wrench:before{content:"\e136"}.glyphicon-tasks:before{content:"\e137"}.glyphicon-filter:before{content:"\e138"}.glyphicon-briefcase:before{content:"\e139"}.glyphicon-fullscreen:before{content:"\e140"}.glyphicon-dashboard:before{content:"\e141"}.glyphicon-paperclip:before{content:"\e142"}.glyphicon-heart-empty:before{content:"\e143"}.glyphicon-link:before{content:"\e144"}.glyphicon-phone:before{content:"\e145"}.glyphicon-pushpin:before{content:"\e146"}.glyphicon-usd:before{content:"\e148"}.glyphicon-gbp:before{content:"\e149"}.glyphicon-sort:before{content:"\e150"}.glyphicon-sort-by-alphabet:before{content:"\e151"}.glyphicon-sort-by-alphabet-alt:before{content:"\e152"}.glyphicon-sort-by-order:before{content:"\e153"}.glyphicon-sort-by-order-alt:before{content:"\e154"}.glyphicon-sort-by-attributes:before{content:"\e155"}.glyphicon-sort-by-attributes-alt:before{content:"\e156"}.glyphicon-unchecked:before{content:"\e157"}.glyphicon-expand:before{content:"\e158"}.glyphicon-collapse-down:before{content:"\e159"}.glyphicon-collapse-up:before{content:"\e160"}.glyphicon-log-in:before{content:"\e161"}.glyphicon-flash:before{content:"\e162"}.glyphicon-log-out:before{content:"\e163"}.glyphicon-new-window:before{content:"\e164"}.glyphicon-record:before{content:"\e165"}.glyphicon-save:before{content:"\e166"}.glyphicon-open:before{content:"\e167"}.glyphicon-saved:before{content:"\e168"}.glyphicon-import:before{content:"\e169"}.glyphicon-export:before{content:"\e170"}.glyphicon-send:before{content:"\e171"}.glyphicon-floppy-disk:before{content:"\e172"}.glyphicon-floppy-saved:before{content:"\e173"}.glyphicon-floppy-remove:before{content:"\e174"}.glyphicon-floppy-save:before{content:"\e175"}.glyphicon-floppy-open:before{content:"\e176"}.glyphicon-credit-card:before{content:"\e177"}.glyphicon-transfer:before{content:"\e178"}.glyphicon-cutlery:before{content:"\e179"}.glyphicon-header:before{content:"\e180"}.glyphicon-compressed:before{content:"\e181"}.glyphicon-earphone:before{content:"\e182"}.glyphicon-phone-alt:before{content:"\e183"}.glyphicon-tower:before{content:"\e184"}.glyphicon-stats:before{content:"\e185"}.glyphicon-sd-video:before{content:"\e186"}.glyphicon-hd-video:before{content:"\e187"}.glyphicon-subtitles:before{content:"\e188"}.glyphicon-sound-stereo:before{content:"\e189"}.glyphicon-sound-dolby:before{content:"\e190"}.glyphicon-sound-5-1:before{content:"\e191"}.glyphicon-sound-6-1:before{content:"\e192"}.glyphicon-sound-7-1:before{content:"\e193"}.glyphicon-copyright-mark:before{content:"\e194"}.glyphicon-registration-mark:before{content:"\e195"}.glyphicon-cloud-download:before{content:"\e197"}.glyphicon-cloud-upload:before{content:"\e198"}.glyphicon-tree-conifer:before{content:"\e199"}.glyphicon-tree-deciduous:before{content:"\e200"}.glyphicon-cd:before{content:"\e201"}.glyphicon-save-file:before{content:"\e202"}.glyphicon-open-file:before{content:"\e203"}.glyphicon-level-up:before{content:"\e204"}.glyphicon-copy:before{content:"\e205"}.glyphicon-paste:before{content:"\e206"}.glyphicon-alert:before{content:"\e209"}.glyphicon-equalizer:before{content:"\e210"}.glyphicon-king:before{content:"\e211"}.glyphicon-queen:before{content:"\e212"}.glyphicon-pawn:before{content:"\e213"}.glyphicon-bishop:before{content:"\e214"}.glyphicon-knight:before{content:"\e215"}.glyphicon-baby-formula:before{content:"\e216"}.glyphicon-tent:before{content:"\26fa"}.glyphicon-blackboard:before{content:"\e218"}.glyphicon-bed:before{content:"\e219"}.glyphicon-apple:before{content:"\f8ff"}.glyphicon-erase:before{content:"\e221"}.glyphicon-hourglass:before{content:"\231b"}.glyphicon-lamp:before{content:"\e223"}.glyphicon-duplicate:before{content:"\e224"}.glyphicon-piggy-bank:before{content:"\e225"}.glyphicon-scissors:before{content:"\e226"}.glyphicon-bitcoin:before{content:"\e227"}.glyphicon-btc:before{content:"\e227"}.glyphicon-xbt:before{content:"\e227"}.glyphicon-yen:before{content:"\00a5"}.glyphicon-jpy:before{content:"\00a5"}.glyphicon-ruble:before{content:"\20bd"}.glyphicon-rub:before{content:"\20bd"}.glyphicon-scale:before{content:"\e230"}.glyphicon-ice-lolly:before{content:"\e231"}.glyphicon-ice-lolly-tasted:before{content:"\e232"}.glyphicon-education:before{content:"\e233"}.glyphicon-option-horizontal:before{content:"\e234"}.glyphicon-option-vertical:before{content:"\e235"}.glyphicon-menu-hamburger:before{content:"\e236"}.glyphicon-modal-window:before{content:"\e237"}.glyphicon-oil:before{content:"\e238"}.glyphicon-grain:before{content:"\e239"}.glyphicon-sunglasses:before{content:"\e240"}.glyphicon-text-size:before{content:"\e241"}.glyphicon-text-color:before{content:"\e242"}.glyphicon-text-background:before{content:"\e243"}.glyphicon-object-align-top:before{content:"\e244"}.glyphicon-object-align-bottom:before{content:"\e245"}.glyphicon-object-align-horizontal:before{content:"\e246"}.glyphicon-object-align-left:before{content:"\e247"}.glyphicon-object-align-vertical:before{content:"\e248"}.glyphicon-object-align-right:before{content:"\e249"}.glyphicon-triangle-right:before{content:"\e250"}.glyphicon-triangle-left:before{content:"\e251"}.glyphicon-triangle-bottom:before{content:"\e252"}.glyphicon-triangle-top:before{content:"\e253"}.glyphicon-console:before{content:"\e254"}.glyphicon-superscript:before{content:"\e255"}.glyphicon-subscript:before{content:"\e256"}.glyphicon-menu-left:before{content:"\e257"}.glyphicon-menu-right:before{content:"\e258"}.glyphicon-menu-down:before{content:"\e259"}.glyphicon-menu-up:before{content:"\e260"}*{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}:after,:before{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}html{font-size:10px;-webkit-tap-highlight-color:rgba(0,0,0,0)}body{font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:14px;line-height:1.42857143;color:#333;background-color:#fff}button,input,select,textarea{font-family:inherit;font-size:inherit;line-height:inherit}a{color:#337ab7;text-decoration:none}a:focus,a:hover{color:#23527c;text-decoration:underline}a:focus{outline:5px auto -webkit-focus-ring-color;outline-offset:-2px}figure{margin:0}img{vertical-align:middle}.carousel-inner>.item>a>img,.carousel-inner>.item>img,.img-responsive,.thumbnail a>img,.thumbnail>img{display:block;max-width:100%;height:auto}.img-rounded{border-radius:6px}.img-thumbnail{display:inline-block;max-width:100%;height:auto;padding:4px;line-height:1.42857143;background-color:#fff;border:1px solid #ddd;border-radius:4px;-webkit-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;transition:all .2s ease-in-out}.img-circle{border-radius:50%}hr{margin-top:20px;margin-bottom:20px;border:0;border-top:1px solid #eee}.sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);border:0}.sr-only-focusable:active,.sr-only-focusable:focus{position:static;width:auto;height:auto;margin:0;overflow:visible;clip:auto}[role=button]{cursor:pointer}.h1,.h2,.h3,.h4,.h5,.h6,h1,h2,h3,h4,h5,h6{font-family:inherit;font-weight:500;line-height:1.1;color:inherit}.h1 .small,.h1 small,.h2 .small,.h2 small,.h3 .small,.h3 small,.h4 .small,.h4 small,.h5 .small,.h5 small,.h6 .small,.h6 small,h1 .small,h1 small,h2 .small,h2 small,h3 .small,h3 small,h4 .small,h4 small,h5 .small,h5 small,h6 .small,h6 small{font-weight:400;line-height:1;color:#777}.h1,.h2,.h3,h1,h2,h3{margin-top:20px;margin-bottom:10px}.h1 .small,.h1 small,.h2 .small,.h2 small,.h3 .small,.h3 small,h1 .small,h1 small,h2 .small,h2 small,h3 .small,h3 small{font-size:65%}.h4,.h5,.h6,h4,h5,h6{margin-top:10px;margin-bottom:10px}.h4 .small,.h4 small,.h5 .small,.h5 small,.h6 .small,.h6 small,h4 .small,h4 small,h5 .small,h5 small,h6 .small,h6 small{font-size:75%}.h1,h1{font-size:36px}.h2,h2{font-size:30px}.h3,h3{font-size:24px}.h4,h4{font-size:18px}.h5,h5{font-size:14px}.h6,h6{font-size:12px}p{margin:0 0 10px}.lead{margin-bottom:20px;font-size:16px;font-weight:300;line-height:1.4}@media (min-width:768px){.lead{font-size:21px}}.small,small{font-size:85%}.mark,mark{padding:.2em;background-color:#fcf8e3}.text-left{text-align:left}.text-right{text-align:right}.text-center{text-align:center}.text-justify{text-align:justify}.text-nowrap{white-space:nowrap}.text-lowercase{text-transform:lowercase}.text-uppercase{text-transform:uppercase}.text-capitalize{text-transform:capitalize}.text-muted{color:#777}.text-primary{color:#337ab7}a.text-primary:focus,a.text-primary:hover{color:#286090}.text-success{color:#3c763d}a.text-success:focus,a.text-success:hover{color:#2b542c}.text-info{color:#31708f}a.text-info:focus,a.text-info:hover{color:#245269}.text-warning{color:#8a6d3b}a.text-warning:focus,a.text-warning:hover{color:#66512c}.text-danger{color:#a94442}a.text-danger:focus,a.text-danger:hover{color:#843534}.bg-primary{color:#fff;background-color:#337ab7}a.bg-primary:focus,a.bg-primary:hover{background-color:#286090}.bg-success{background-color:#dff0d8}a.bg-success:focus,a.bg-success:hover{background-color:#c1e2b3}.bg-info{background-color:#d9edf7}a.bg-info:focus,a.bg-info:hover{background-color:#afd9ee}.bg-warning{background-color:#fcf8e3}a.bg-warning:focus,a.bg-warning:hover{background-color:#f7ecb5}.bg-danger{background-color:#f2dede}a.bg-danger:focus,a.bg-danger:hover{background-color:#e4b9b9}.page-header{padding-bottom:9px;margin:40px 0 20px;border-bottom:1px solid #eee}ol,ul{margin-top:0;margin-bottom:10px}ol ol,ol ul,ul ol,ul ul{margin-bottom:0}.list-unstyled{padding-left:0;list-style:none}.list-inline{padding-left:0;margin-left:-5px;list-style:none}.list-inline>li{display:inline-block;padding-right:5px;padding-left:5px}dl{margin-top:0;margin-bottom:20px}dd,dt{line-height:1.42857143}dt{font-weight:700}dd{margin-left:0}@media (min-width:768px){.dl-horizontal dt{float:left;width:160px;overflow:hidden;clear:left;text-align:right;text-overflow:ellipsis;white-space:nowrap}.dl-horizontal dd{margin-left:180px}}abbr[data-original-title],abbr[title]{cursor:help;border-bottom:1px dotted #777}.initialism{font-size:90%;text-transform:uppercase}blockquote{padding:10px 20px;margin:0 0 20px;font-size:17.5px;border-left:5px solid #eee}blockquote ol:last-child,blockquote p:last-child,blockquote ul:last-child{margin-bottom:0}blockquote .small,blockquote footer,blockquote small{display:block;font-size:80%;line-height:1.42857143;color:#777}blockquote .small:before,blockquote footer:before,blockquote small:before{content:'\2014 \00A0'}.blockquote-reverse,blockquote.pull-right{padding-right:15px;padding-left:0;text-align:right;border-right:5px solid #eee;border-left:0}.blockquote-reverse .small:before,.blockquote-reverse footer:before,.blockquote-reverse small:before,blockquote.pull-right .small:before,blockquote.pull-right footer:before,blockquote.pull-right small:before{content:''}.blockquote-reverse .small:after,.blockquote-reverse footer:after,.blockquote-reverse small:after,blockquote.pull-right .small:after,blockquote.pull-right footer:after,blockquote.pull-right small:after{content:'\00A0 \2014'}address{margin-bottom:20px;font-style:normal;line-height:1.42857143}code,kbd,pre,samp{font-family:Menlo,Monaco,Consolas,"Courier New",monospace}code{padding:2px 4px;font-size:90%;color:#c7254e;background-color:#f9f2f4;border-radius:4px}kbd{padding:2px 4px;font-size:90%;color:#fff;background-color:#333;border-radius:3px;-webkit-box-shadow:inset 0 -1px 0 rgba(0,0,0,.25);box-shadow:inset 0 -1px 0 rgba(0,0,0,.25)}kbd kbd{padding:0;font-size:100%;font-weight:700;-webkit-box-shadow:none;box-shadow:none}pre{display:block;padding:9.5px;margin:0 0 10px;font-size:13px;line-height:1.42857143;color:#333;word-break:break-all;word-wrap:break-word;background-color:#f5f5f5;border:1px solid #ccc;border-radius:4px}pre code{padding:0;font-size:inherit;color:inherit;white-space:pre-wrap;background-color:transparent;border-radius:0}.pre-scrollable{max-height:340px;overflow-y:scroll}.container{padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}@media (min-width:768px){.container{width:750px}}@media (min-width:992px){.container{width:970px}}@media (min-width:1200px){.container{width:1170px}}.container-fluid{padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}.row{margin-right:-15px;margin-left:-15px}.col-lg-1,.col-lg-10,.col-lg-11,.col-lg-12,.col-lg-2,.col-lg-3,.col-lg-4,.col-lg-5,.col-lg-6,.col-lg-7,.col-lg-8,.col-lg-9,.col-md-1,.col-md-10,.col-md-11,.col-md-12,.col-md-2,.col-md-3,.col-md-4,.col-md-5,.col-md-6,.col-md-7,.col-md-8,.col-md-9,.col-sm-1,.col-sm-10,.col-sm-11,.col-sm-12,.col-sm-2,.col-sm-3,.col-sm-4,.col-sm-5,.col-sm-6,.col-sm-7,.col-sm-8,.col-sm-9,.col-xs-1,.col-xs-10,.col-xs-11,.col-xs-12,.col-xs-2,.col-xs-3,.col-xs-4,.col-xs-5,.col-xs-6,.col-xs-7,.col-xs-8,.col-xs-9{position:relative;min-height:1px;padding-right:15px;padding-left:15px}.col-xs-1,.col-xs-10,.col-xs-11,.col-xs-12,.col-xs-2,.col-xs-3,.col-xs-4,.col-xs-5,.col-xs-6,.col-xs-7,.col-xs-8,.col-xs-9{float:left}.col-xs-12{width:100%}.col-xs-11{width:91.66666667%}.col-xs-10{width:83.33333333%}.col-xs-9{width:75%}.col-xs-8{width:66.66666667%}.col-xs-7{width:58.33333333%}.col-xs-6{width:50%}.col-xs-5{width:41.66666667%}.col-xs-4{width:33.33333333%}.col-xs-3{width:25%}.col-xs-2{width:16.66666667%}.col-xs-1{width:8.33333333%}.col-xs-pull-12{right:100%}.col-xs-pull-11{right:91.66666667%}.col-xs-pull-10{right:83.33333333%}.col-xs-pull-9{right:75%}.col-xs-pull-8{right:66.66666667%}.col-xs-pull-7{right:58.33333333%}.col-xs-pull-6{right:50%}.col-xs-pull-5{right:41.66666667%}.col-xs-pull-4{right:33.33333333%}.col-xs-pull-3{right:25%}.col-xs-pull-2{right:16.66666667%}.col-xs-pull-1{right:8.33333333%}.col-xs-pull-0{right:auto}.col-xs-push-12{left:100%}.col-xs-push-11{left:91.66666667%}.col-xs-push-10{left:83.33333333%}.col-xs-push-9{left:75%}.col-xs-push-8{left:66.66666667%}.col-xs-push-7{left:58.33333333%}.col-xs-push-6{left:50%}.col-xs-push-5{left:41.66666667%}.col-xs-push-4{left:33.33333333%}.col-xs-push-3{left:25%}.col-xs-push-2{left:16.66666667%}.col-xs-push-1{left:8.33333333%}.col-xs-push-0{left:auto}.col-xs-offset-12{margin-left:100%}.col-xs-offset-11{margin-left:91.66666667%}.col-xs-offset-10{margin-left:83.33333333%}.col-xs-offset-9{margin-left:75%}.col-xs-offset-8{margin-left:66.66666667%}.col-xs-offset-7{margin-left:58.33333333%}.col-xs-offset-6{margin-left:50%}.col-xs-offset-5{margin-left:41.66666667%}.col-xs-offset-4{margin-left:33.33333333%}.col-xs-offset-3{margin-left:25%}.col-xs-offset-2{margin-left:16.66666667%}.col-xs-offset-1{margin-left:8.33333333%}.col-xs-offset-0{margin-left:0}@media (min-width:768px){.col-sm-1,.col-sm-10,.col-sm-11,.col-sm-12,.col-sm-2,.col-sm-3,.col-sm-4,.col-sm-5,.col-sm-6,.col-sm-7,.col-sm-8,.col-sm-9{float:left}.col-sm-12{width:100%}.col-sm-11{width:91.66666667%}.col-sm-10{width:83.33333333%}.col-sm-9{width:75%}.col-sm-8{width:66.66666667%}.col-sm-7{width:58.33333333%}.col-sm-6{width:50%}.col-sm-5{width:41.66666667%}.col-sm-4{width:33.33333333%}.col-sm-3{width:25%}.col-sm-2{width:16.66666667%}.col-sm-1{width:8.33333333%}.col-sm-pull-12{right:100%}.col-sm-pull-11{right:91.66666667%}.col-sm-pull-10{right:83.33333333%}.col-sm-pull-9{right:75%}.col-sm-pull-8{right:66.66666667%}.col-sm-pull-7{right:58.33333333%}.col-sm-pull-6{right:50%}.col-sm-pull-5{right:41.66666667%}.col-sm-pull-4{right:33.33333333%}.col-sm-pull-3{right:25%}.col-sm-pull-2{right:16.66666667%}.col-sm-pull-1{right:8.33333333%}.col-sm-pull-0{right:auto}.col-sm-push-12{left:100%}.col-sm-push-11{left:91.66666667%}.col-sm-push-10{left:83.33333333%}.col-sm-push-9{left:75%}.col-sm-push-8{left:66.66666667%}.col-sm-push-7{left:58.33333333%}.col-sm-push-6{left:50%}.col-sm-push-5{left:41.66666667%}.col-sm-push-4{left:33.33333333%}.col-sm-push-3{left:25%}.col-sm-push-2{left:16.66666667%}.col-sm-push-1{left:8.33333333%}.col-sm-push-0{left:auto}.col-sm-offset-12{margin-left:100%}.col-sm-offset-11{margin-left:91.66666667%}.col-sm-offset-10{margin-left:83.33333333%}.col-sm-offset-9{margin-left:75%}.col-sm-offset-8{margin-left:66.66666667%}.col-sm-offset-7{margin-left:58.33333333%}.col-sm-offset-6{margin-left:50%}.col-sm-offset-5{margin-left:41.66666667%}.col-sm-offset-4{margin-left:33.33333333%}.col-sm-offset-3{margin-left:25%}.col-sm-offset-2{margin-left:16.66666667%}.col-sm-offset-1{margin-left:8.33333333%}.col-sm-offset-0{margin-left:0}}@media (min-width:992px){.col-md-1,.col-md-10,.col-md-11,.col-md-12,.col-md-2,.col-md-3,.col-md-4,.col-md-5,.col-md-6,.col-md-7,.col-md-8,.col-md-9{float:left}.col-md-12{width:100%}.col-md-11{width:91.66666667%}.col-md-10{width:83.33333333%}.col-md-9{width:75%}.col-md-8{width:66.66666667%}.col-md-7{width:58.33333333%}.col-md-6{width:50%}.col-md-5{width:41.66666667%}.col-md-4{width:33.33333333%}.col-md-3{width:25%}.col-md-2{width:16.66666667%}.col-md-1{width:8.33333333%}.col-md-pull-12{right:100%}.col-md-pull-11{right:91.66666667%}.col-md-pull-10{right:83.33333333%}.col-md-pull-9{right:75%}.col-md-pull-8{right:66.66666667%}.col-md-pull-7{right:58.33333333%}.col-md-pull-6{right:50%}.col-md-pull-5{right:41.66666667%}.col-md-pull-4{right:33.33333333%}.col-md-pull-3{right:25%}.col-md-pull-2{right:16.66666667%}.col-md-pull-1{right:8.33333333%}.col-md-pull-0{right:auto}.col-md-push-12{left:100%}.col-md-push-11{left:91.66666667%}.col-md-push-10{left:83.33333333%}.col-md-push-9{left:75%}.col-md-push-8{left:66.66666667%}.col-md-push-7{left:58.33333333%}.col-md-push-6{left:50%}.col-md-push-5{left:41.66666667%}.col-md-push-4{left:33.33333333%}.col-md-push-3{left:25%}.col-md-push-2{left:16.66666667%}.col-md-push-1{left:8.33333333%}.col-md-push-0{left:auto}.col-md-offset-12{margin-left:100%}.col-md-offset-11{margin-left:91.66666667%}.col-md-offset-10{margin-left:83.33333333%}.col-md-offset-9{margin-left:75%}.col-md-offset-8{margin-left:66.66666667%}.col-md-offset-7{margin-left:58.33333333%}.col-md-offset-6{margin-left:50%}.col-md-offset-5{margin-left:41.66666667%}.col-md-offset-4{margin-left:33.33333333%}.col-md-offset-3{margin-left:25%}.col-md-offset-2{margin-left:16.66666667%}.col-md-offset-1{margin-left:8.33333333%}.col-md-offset-0{margin-left:0}}@media (min-width:1200px){.col-lg-1,.col-lg-10,.col-lg-11,.col-lg-12,.col-lg-2,.col-lg-3,.col-lg-4,.col-lg-5,.col-lg-6,.col-lg-7,.col-lg-8,.col-lg-9{float:left}.col-lg-12{width:100%}.col-lg-11{width:91.66666667%}.col-lg-10{width:83.33333333%}.col-lg-9{width:75%}.col-lg-8{width:66.66666667%}.col-lg-7{width:58.33333333%}.col-lg-6{width:50%}.col-lg-5{width:41.66666667%}.col-lg-4{width:33.33333333%}.col-lg-3{width:25%}.col-lg-2{width:16.66666667%}.col-lg-1{width:8.33333333%}.col-lg-pull-12{right:100%}.col-lg-pull-11{right:91.66666667%}.col-lg-pull-10{right:83.33333333%}.col-lg-pull-9{right:75%}.col-lg-pull-8{right:66.66666667%}.col-lg-pull-7{right:58.33333333%}.col-lg-pull-6{right:50%}.col-lg-pull-5{right:41.66666667%}.col-lg-pull-4{right:33.33333333%}.col-lg-pull-3{right:25%}.col-lg-pull-2{right:16.66666667%}.col-lg-pull-1{right:8.33333333%}.col-lg-pull-0{right:auto}.col-lg-push-12{left:100%}.col-lg-push-11{left:91.66666667%}.col-lg-push-10{left:83.33333333%}.col-lg-push-9{left:75%}.col-lg-push-8{left:66.66666667%}.col-lg-push-7{left:58.33333333%}.col-lg-push-6{left:50%}.col-lg-push-5{left:41.66666667%}.col-lg-push-4{left:33.33333333%}.col-lg-push-3{left:25%}.col-lg-push-2{left:16.66666667%}.col-lg-push-1{left:8.33333333%}.col-lg-push-0{left:auto}.col-lg-offset-12{margin-left:100%}.col-lg-offset-11{margin-left:91.66666667%}.col-lg-offset-10{margin-left:83.33333333%}.col-lg-offset-9{margin-left:75%}.col-lg-offset-8{margin-left:66.66666667%}.col-lg-offset-7{margin-left:58.33333333%}.col-lg-offset-6{margin-left:50%}.col-lg-offset-5{margin-left:41.66666667%}.col-lg-offset-4{margin-left:33.33333333%}.col-lg-offset-3{margin-left:25%}.col-lg-offset-2{margin-left:16.66666667%}.col-lg-offset-1{margin-left:8.33333333%}.col-lg-offset-0{margin-left:0}}table{background-color:transparent}caption{padding-top:8px;padding-bottom:8px;color:#777;text-align:left}th{text-align:left}.table{width:100%;max-width:100%;margin-bottom:20px}.table>tbody>tr>td,.table>tbody>tr>th,.table>tfoot>tr>td,.table>tfoot>tr>th,.table>thead>tr>td,.table>thead>tr>th{padding:8px;line-height:1.42857143;vertical-align:top;border-top:1px solid #ddd}.table>thead>tr>th{vertical-align:bottom;border-bottom:2px solid #ddd}.table>caption+thead>tr:first-child>td,.table>caption+thead>tr:first-child>th,.table>colgroup+thead>tr:first-child>td,.table>colgroup+thead>tr:first-child>th,.table>thead:first-child>tr:first-child>td,.table>thead:first-child>tr:first-child>th{border-top:0}.table>tbody+tbody{border-top:2px solid #ddd}.table .table{background-color:#fff}.table-condensed>tbody>tr>td,.table-condensed>tbody>tr>th,.table-condensed>tfoot>tr>td,.table-condensed>tfoot>tr>th,.table-condensed>thead>tr>td,.table-condensed>thead>tr>th{padding:5px}.table-bordered{border:1px solid #ddd}.table-bordered>tbody>tr>td,.table-bordered>tbody>tr>th,.table-bordered>tfoot>tr>td,.table-bordered>tfoot>tr>th,.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border:1px solid #ddd}.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border-bottom-width:2px}.table-striped>tbody>tr:nth-of-type(odd){background-color:#f9f9f9}.table-hover>tbody>tr:hover{background-color:#f5f5f5}table col[class*=col-]{position:static;display:table-column;float:none}table td[class*=col-],table th[class*=col-]{position:static;display:table-cell;float:none}.table>tbody>tr.active>td,.table>tbody>tr.active>th,.table>tbody>tr>td.active,.table>tbody>tr>th.active,.table>tfoot>tr.active>td,.table>tfoot>tr.active>th,.table>tfoot>tr>td.active,.table>tfoot>tr>th.active,.table>thead>tr.active>td,.table>thead>tr.active>th,.table>thead>tr>td.active,.table>thead>tr>th.active{background-color:#f5f5f5}.table-hover>tbody>tr.active:hover>td,.table-hover>tbody>tr.active:hover>th,.table-hover>tbody>tr:hover>.active,.table-hover>tbody>tr>td.active:hover,.table-hover>tbody>tr>th.active:hover{background-color:#e8e8e8}.table>tbody>tr.success>td,.table>tbody>tr.success>th,.table>tbody>tr>td.success,.table>tbody>tr>th.success,.table>tfoot>tr.success>td,.table>tfoot>tr.success>th,.table>tfoot>tr>td.success,.table>tfoot>tr>th.success,.table>thead>tr.success>td,.table>thead>tr.success>th,.table>thead>tr>td.success,.table>thead>tr>th.success{background-color:#dff0d8}.table-hover>tbody>tr.success:hover>td,.table-hover>tbody>tr.success:hover>th,.table-hover>tbody>tr:hover>.success,.table-hover>tbody>tr>td.success:hover,.table-hover>tbody>tr>th.success:hover{background-color:#d0e9c6}.table>tbody>tr.info>td,.table>tbody>tr.info>th,.table>tbody>tr>td.info,.table>tbody>tr>th.info,.table>tfoot>tr.info>td,.table>tfoot>tr.info>th,.table>tfoot>tr>td.info,.table>tfoot>tr>th.info,.table>thead>tr.info>td,.table>thead>tr.info>th,.table>thead>tr>td.info,.table>thead>tr>th.info{background-color:#d9edf7}.table-hover>tbody>tr.info:hover>td,.table-hover>tbody>tr.info:hover>th,.table-hover>tbody>tr:hover>.info,.table-hover>tbody>tr>td.info:hover,.table-hover>tbody>tr>th.info:hover{background-color:#c4e3f3}.table>tbody>tr.warning>td,.table>tbody>tr.warning>th,.table>tbody>tr>td.warning,.table>tbody>tr>th.warning,.table>tfoot>tr.warning>td,.table>tfoot>tr.warning>th,.table>tfoot>tr>td.warning,.table>tfoot>tr>th.warning,.table>thead>tr.warning>td,.table>thead>tr.warning>th,.table>thead>tr>td.warning,.table>thead>tr>th.warning{background-color:#fcf8e3}.table-hover>tbody>tr.warning:hover>td,.table-hover>tbody>tr.warning:hover>th,.table-hover>tbody>tr:hover>.warning,.table-hover>tbody>tr>td.warning:hover,.table-hover>tbody>tr>th.warning:hover{background-color:#faf2cc}.table>tbody>tr.danger>td,.table>tbody>tr.danger>th,.table>tbody>tr>td.danger,.table>tbody>tr>th.danger,.table>tfoot>tr.danger>td,.table>tfoot>tr.danger>th,.table>tfoot>tr>td.danger,.table>tfoot>tr>th.danger,.table>thead>tr.danger>td,.table>thead>tr.danger>th,.table>thead>tr>td.danger,.table>thead>tr>th.danger{background-color:#f2dede}.table-hover>tbody>tr.danger:hover>td,.table-hover>tbody>tr.danger:hover>th,.table-hover>tbody>tr:hover>.danger,.table-hover>tbody>tr>td.danger:hover,.table-hover>tbody>tr>th.danger:hover{background-color:#ebcccc}.table-responsive{min-height:.01%;overflow-x:auto}@media screen and (max-width:767px){.table-responsive{width:100%;margin-bottom:15px;overflow-y:hidden;-ms-overflow-style:-ms-autohiding-scrollbar;border:1px solid #ddd}.table-responsive>.table{margin-bottom:0}.table-responsive>.table>tbody>tr>td,.table-responsive>.table>tbody>tr>th,.table-responsive>.table>tfoot>tr>td,.table-responsive>.table>tfoot>tr>th,.table-responsive>.table>thead>tr>td,.table-responsive>.table>thead>tr>th{white-space:nowrap}.table-responsive>.table-bordered{border:0}.table-responsive>.table-bordered>tbody>tr>td:first-child,.table-responsive>.table-bordered>tbody>tr>th:first-child,.table-responsive>.table-bordered>tfoot>tr>td:first-child,.table-responsive>.table-bordered>tfoot>tr>th:first-child,.table-responsive>.table-bordered>thead>tr>td:first-child,.table-responsive>.table-bordered>thead>tr>th:first-child{border-left:0}.table-responsive>.table-bordered>tbody>tr>td:last-child,.table-responsive>.table-bordered>tbody>tr>th:last-child,.table-responsive>.table-bordered>tfoot>tr>td:last-child,.table-responsive>.table-bordered>tfoot>tr>th:last-child,.table-responsive>.table-bordered>thead>tr>td:last-child,.table-responsive>.table-bordered>thead>tr>th:last-child{border-right:0}.table-responsive>.table-bordered>tbody>tr:last-child>td,.table-responsive>.table-bordered>tbody>tr:last-child>th,.table-responsive>.table-bordered>tfoot>tr:last-child>td,.table-responsive>.table-bordered>tfoot>tr:last-child>th{border-bottom:0}}fieldset{min-width:0;padding:0;margin:0;border:0}legend{display:block;width:100%;padding:0;margin-bottom:20px;font-size:21px;line-height:inherit;color:#333;border:0;border-bottom:1px solid #e5e5e5}label{display:inline-block;max-width:100%;margin-bottom:5px;font-weight:700}input[type=search]{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}input[type=checkbox],input[type=radio]{margin:4px 0 0;margin-top:1px\9;line-height:normal}input[type=file]{display:block}input[type=range]{display:block;width:100%}select[multiple],select[size]{height:auto}input[type=file]:focus,input[type=checkbox]:focus,input[type=radio]:focus{outline:5px auto -webkit-focus-ring-color;outline-offset:-2px}output{display:block;padding-top:7px;font-size:14px;line-height:1.42857143;color:#555}.form-control{display:block;width:100%;height:34px;padding:6px 12px;font-size:14px;line-height:1.42857143;color:#555;background-color:#fff;background-image:none;border:1px solid #ccc;border-radius:4px;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);box-shadow:inset 0 1px 1px rgba(0,0,0,.075);-webkit-transition:border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;-o-transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s;transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s}.form-control:focus{border-color:#66afe9;outline:0;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6);box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6)}.form-control::-moz-placeholder{color:#999;opacity:1}.form-control:-ms-input-placeholder{color:#999}.form-control::-webkit-input-placeholder{color:#999}.form-control::-ms-expand{background-color:transparent;border:0}.form-control[disabled],.form-control[readonly],fieldset[disabled] .form-control{background-color:#eee;opacity:1}.form-control[disabled],fieldset[disabled] .form-control{cursor:not-allowed}textarea.form-control{height:auto}input[type=search]{-webkit-appearance:none}@media screen and (-webkit-min-device-pixel-ratio:0){input[type=date].form-control,input[type=time].form-control,input[type=datetime-local].form-control,input[type=month].form-control{line-height:34px}.input-group-sm input[type=date],.input-group-sm input[type=time],.input-group-sm input[type=datetime-local],.input-group-sm input[type=month],input[type=date].input-sm,input[type=time].input-sm,input[type=datetime-local].input-sm,input[type=month].input-sm{line-height:30px}.input-group-lg input[type=date],.input-group-lg input[type=time],.input-group-lg input[type=datetime-local],.input-group-lg input[type=month],input[type=date].input-lg,input[type=time].input-lg,input[type=datetime-local].input-lg,input[type=month].input-lg{line-height:46px}}.form-group{margin-bottom:15px}.checkbox,.radio{position:relative;display:block;margin-top:10px;margin-bottom:10px}.checkbox label,.radio label{min-height:20px;padding-left:20px;margin-bottom:0;font-weight:400;cursor:pointer}.checkbox input[type=checkbox],.checkbox-inline input[type=checkbox],.radio input[type=radio],.radio-inline input[type=radio]{position:absolute;margin-top:4px\9;margin-left:-20px}.checkbox+.checkbox,.radio+.radio{margin-top:-5px}.checkbox-inline,.radio-inline{position:relative;display:inline-block;padding-left:20px;margin-bottom:0;font-weight:400;vertical-align:middle;cursor:pointer}.checkbox-inline+.checkbox-inline,.radio-inline+.radio-inline{margin-top:0;margin-left:10px}fieldset[disabled] input[type=checkbox],fieldset[disabled] input[type=radio],input[type=checkbox].disabled,input[type=checkbox][disabled],input[type=radio].disabled,input[type=radio][disabled]{cursor:not-allowed}.checkbox-inline.disabled,.radio-inline.disabled,fieldset[disabled] .checkbox-inline,fieldset[disabled] .radio-inline{cursor:not-allowed}.checkbox.disabled label,.radio.disabled label,fieldset[disabled] .checkbox label,fieldset[disabled] .radio label{cursor:not-allowed}.form-control-static{min-height:34px;padding-top:7px;padding-bottom:7px;margin-bottom:0}.form-control-static.input-lg,.form-control-static.input-sm{padding-right:0;padding-left:0}.input-sm{height:30px;padding:5px 10px;font-size:12px;line-height:1.5;border-radius:3px}select.input-sm{height:30px;line-height:30px}select[multiple].input-sm,textarea.input-sm{height:auto}.form-group-sm .form-control{height:30px;padding:5px 10px;font-size:12px;line-height:1.5;border-radius:3px}.form-group-sm select.form-control{height:30px;line-height:30px}.form-group-sm select[multiple].form-control,.form-group-sm textarea.form-control{height:auto}.form-group-sm .form-control-static{height:30px;min-height:32px;padding:6px 10px;font-size:12px;line-height:1.5}.input-lg{height:46px;padding:10px 16px;font-size:18px;line-height:1.3333333;border-radius:6px}select.input-lg{height:46px;line-height:46px}select[multiple].input-lg,textarea.input-lg{height:auto}.form-group-lg .form-control{height:46px;padding:10px 16px;font-size:18px;line-height:1.3333333;border-radius:6px}.form-group-lg select.form-control{height:46px;line-height:46px}.form-group-lg select[multiple].form-control,.form-group-lg textarea.form-control{height:auto}.form-group-lg .form-control-static{height:46px;min-height:38px;padding:11px 16px;font-size:18px;line-height:1.3333333}.has-feedback{position:relative}.has-feedback .form-control{padding-right:42.5px}.form-control-feedback{position:absolute;top:0;right:0;z-index:2;display:block;width:34px;height:34px;line-height:34px;text-align:center;pointer-events:none}.form-group-lg .form-control+.form-control-feedback,.input-group-lg+.form-control-feedback,.input-lg+.form-control-feedback{width:46px;height:46px;line-height:46px}.form-group-sm .form-control+.form-control-feedback,.input-group-sm+.form-control-feedback,.input-sm+.form-control-feedback{width:30px;height:30px;line-height:30px}.has-success .checkbox,.has-success .checkbox-inline,.has-success .control-label,.has-success .help-block,.has-success .radio,.has-success .radio-inline,.has-success.checkbox label,.has-success.checkbox-inline label,.has-success.radio label,.has-success.radio-inline label{color:#3c763d}.has-success .form-control{border-color:#3c763d;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);box-shadow:inset 0 1px 1px rgba(0,0,0,.075)}.has-success .form-control:focus{border-color:#2b542c;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 6px #67b168;box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 6px #67b168}.has-success .input-group-addon{color:#3c763d;background-color:#dff0d8;border-color:#3c763d}.has-success .form-control-feedback{color:#3c763d}.has-warning .checkbox,.has-warning .checkbox-inline,.has-warning .control-label,.has-warning .help-block,.has-warning .radio,.has-warning .radio-inline,.has-warning.checkbox label,.has-warning.checkbox-inline label,.has-warning.radio label,.has-warning.radio-inline label{color:#8a6d3b}.has-warning .form-control{border-color:#8a6d3b;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);box-shadow:inset 0 1px 1px rgba(0,0,0,.075)}.has-warning .form-control:focus{border-color:#66512c;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 6px #c0a16b;box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 6px #c0a16b}.has-warning .input-group-addon{color:#8a6d3b;background-color:#fcf8e3;border-color:#8a6d3b}.has-warning .form-control-feedback{color:#8a6d3b}.has-error .checkbox,.has-error .checkbox-inline,.has-error .control-label,.has-error .help-block,.has-error .radio,.has-error .radio-inline,.has-error.checkbox label,.has-error.checkbox-inline label,.has-error.radio label,.has-error.radio-inline label{color:#a94442}.has-error .form-control{border-color:#a94442;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);box-shadow:inset 0 1px 1px rgba(0,0,0,.075)}.has-error .form-control:focus{border-color:#843534;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 6px #ce8483;box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 6px #ce8483}.has-error .input-group-addon{color:#a94442;background-color:#f2dede;border-color:#a94442}.has-error .form-control-feedback{color:#a94442}.has-feedback label~.form-control-feedback{top:25px}.has-feedback label.sr-only~.form-control-feedback{top:0}.help-block{display:block;margin-top:5px;margin-bottom:10px;color:#737373}@media (min-width:768px){.form-inline .form-group{display:inline-block;margin-bottom:0;vertical-align:middle}.form-inline .form-control{display:inline-block;width:auto;vertical-align:middle}.form-inline .form-control-static{display:inline-block}.form-inline .input-group{display:inline-table;vertical-align:middle}.form-inline .input-group .form-control,.form-inline .input-group .input-group-addon,.form-inline .input-group .input-group-btn{width:auto}.form-inline .input-group>.form-control{width:100%}.form-inline .control-label{margin-bottom:0;vertical-align:middle}.form-inline .checkbox,.form-inline .radio{display:inline-block;margin-top:0;margin-bottom:0;vertical-align:middle}.form-inline .checkbox label,.form-inline .radio label{padding-left:0}.form-inline .checkbox input[type=checkbox],.form-inline .radio input[type=radio]{position:relative;margin-left:0}.form-inline .has-feedback .form-control-feedback{top:0}}.form-horizontal .checkbox,.form-horizontal .checkbox-inline,.form-horizontal .radio,.form-horizontal .radio-inline{padding-top:7px;margin-top:0;margin-bottom:0}.form-horizontal .checkbox,.form-horizontal .radio{min-height:27px}.form-horizontal .form-group{margin-right:-15px;margin-left:-15px}@media (min-width:768px){.form-horizontal .control-label{padding-top:7px;margin-bottom:0;text-align:right}}.form-horizontal .has-feedback .form-control-feedback{right:15px}@media (min-width:768px){.form-horizontal .form-group-lg .control-label{padding-top:11px;font-size:18px}}@media (min-width:768px){.form-horizontal .form-group-sm .control-label{padding-top:6px;font-size:12px}}.btn{display:inline-block;padding:6px 12px;margin-bottom:0;font-size:14px;font-weight:400;line-height:1.42857143;text-align:center;white-space:nowrap;vertical-align:middle;-ms-touch-action:manipulation;touch-action:manipulation;cursor:pointer;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;background-image:none;border:1px solid transparent;border-radius:4px}.btn.active.focus,.btn.active:focus,.btn.focus,.btn:active.focus,.btn:active:focus,.btn:focus{outline:5px auto -webkit-focus-ring-color;outline-offset:-2px}.btn.focus,.btn:focus,.btn:hover{color:#333;text-decoration:none}.btn.active,.btn:active{background-image:none;outline:0;-webkit-box-shadow:inset 0 3px 5px rgba(0,0,0,.125);box-shadow:inset 0 3px 5px rgba(0,0,0,.125)}.btn.disabled,.btn[disabled],fieldset[disabled] .btn{cursor:not-allowed;filter:alpha(opacity=65);-webkit-box-shadow:none;box-shadow:none;opacity:.65}a.btn.disabled,fieldset[disabled] a.btn{pointer-events:none}.btn-default{color:#333;background-color:#fff;border-color:#ccc}.btn-default.focus,.btn-default:focus{color:#333;background-color:#e6e6e6;border-color:#8c8c8c}.btn-default:hover{color:#333;background-color:#e6e6e6;border-color:#adadad}.btn-default.active,.btn-default:active,.open>.dropdown-toggle.btn-default{color:#333;background-color:#e6e6e6;border-color:#adadad}.btn-default.active.focus,.btn-default.active:focus,.btn-default.active:hover,.btn-default:active.focus,.btn-default:active:focus,.btn-default:active:hover,.open>.dropdown-toggle.btn-default.focus,.open>.dropdown-toggle.btn-default:focus,.open>.dropdown-toggle.btn-default:hover{color:#333;background-color:#d4d4d4;border-color:#8c8c8c}.btn-default.active,.btn-default:active,.open>.dropdown-toggle.btn-default{background-image:none}.btn-default.disabled.focus,.btn-default.disabled:focus,.btn-default.disabled:hover,.btn-default[disabled].focus,.btn-default[disabled]:focus,.btn-default[disabled]:hover,fieldset[disabled] .btn-default.focus,fieldset[disabled] .btn-default:focus,fieldset[disabled] .btn-default:hover{background-color:#fff;border-color:#ccc}.btn-default .badge{color:#fff;background-color:#333}.btn-primary{color:#fff;background-color:#337ab7;border-color:#2e6da4}.btn-primary.focus,.btn-primary:focus{color:#fff;background-color:#286090;border-color:#122b40}.btn-primary:hover{color:#fff;background-color:#286090;border-color:#204d74}.btn-primary.active,.btn-primary:active,.open>.dropdown-toggle.btn-primary{color:#fff;background-color:#286090;border-color:#204d74}.btn-primary.active.focus,.btn-primary.active:focus,.btn-primary.active:hover,.btn-primary:active.focus,.btn-primary:active:focus,.btn-primary:active:hover,.open>.dropdown-toggle.btn-primary.focus,.open>.dropdown-toggle.btn-primary:focus,.open>.dropdown-toggle.btn-primary:hover{color:#fff;background-color:#204d74;border-color:#122b40}.btn-primary.active,.btn-primary:active,.open>.dropdown-toggle.btn-primary{background-image:none}.btn-primary.disabled.focus,.btn-primary.disabled:focus,.btn-primary.disabled:hover,.btn-primary[disabled].focus,.btn-primary[disabled]:focus,.btn-primary[disabled]:hover,fieldset[disabled] .btn-primary.focus,fieldset[disabled] .btn-primary:focus,fieldset[disabled] .btn-primary:hover{background-color:#337ab7;border-color:#2e6da4}.btn-primary .badge{color:#337ab7;background-color:#fff}.btn-success{color:#fff;background-color:#5cb85c;border-color:#4cae4c}.btn-success.focus,.btn-success:focus{color:#fff;background-color:#449d44;border-color:#255625}.btn-success:hover{color:#fff;background-color:#449d44;border-color:#398439}.btn-success.active,.btn-success:active,.open>.dropdown-toggle.btn-success{color:#fff;background-color:#449d44;border-color:#398439}.btn-success.active.focus,.btn-success.active:focus,.btn-success.active:hover,.btn-success:active.focus,.btn-success:active:focus,.btn-success:active:hover,.open>.dropdown-toggle.btn-success.focus,.open>.dropdown-toggle.btn-success:focus,.open>.dropdown-toggle.btn-success:hover{color:#fff;background-color:#398439;border-color:#255625}.btn-success.active,.btn-success:active,.open>.dropdown-toggle.btn-success{background-image:none}.btn-success.disabled.focus,.btn-success.disabled:focus,.btn-success.disabled:hover,.btn-success[disabled].focus,.btn-success[disabled]:focus,.btn-success[disabled]:hover,fieldset[disabled] .btn-success.focus,fieldset[disabled] .btn-success:focus,fieldset[disabled] .btn-success:hover{background-color:#5cb85c;border-color:#4cae4c}.btn-success .badge{color:#5cb85c;background-color:#fff}.btn-info{color:#fff;background-color:#5bc0de;border-color:#46b8da}.btn-info.focus,.btn-info:focus{color:#fff;background-color:#31b0d5;border-color:#1b6d85}.btn-info:hover{color:#fff;background-color:#31b0d5;border-color:#269abc}.btn-info.active,.btn-info:active,.open>.dropdown-toggle.btn-info{color:#fff;background-color:#31b0d5;border-color:#269abc}.btn-info.active.focus,.btn-info.active:focus,.btn-info.active:hover,.btn-info:active.focus,.btn-info:active:focus,.btn-info:active:hover,.open>.dropdown-toggle.btn-info.focus,.open>.dropdown-toggle.btn-info:focus,.open>.dropdown-toggle.btn-info:hover{color:#fff;background-color:#269abc;border-color:#1b6d85}.btn-info.active,.btn-info:active,.open>.dropdown-toggle.btn-info{background-image:none}.btn-info.disabled.focus,.btn-info.disabled:focus,.btn-info.disabled:hover,.btn-info[disabled].focus,.btn-info[disabled]:focus,.btn-info[disabled]:hover,fieldset[disabled] .btn-info.focus,fieldset[disabled] .btn-info:focus,fieldset[disabled] .btn-info:hover{background-color:#5bc0de;border-color:#46b8da}.btn-info .badge{color:#5bc0de;background-color:#fff}.btn-warning{color:#fff;background-color:#f0ad4e;border-color:#eea236}.btn-warning.focus,.btn-warning:focus{color:#fff;background-color:#ec971f;border-color:#985f0d}.btn-warning:hover{color:#fff;background-color:#ec971f;border-color:#d58512}.btn-warning.active,.btn-warning:active,.open>.dropdown-toggle.btn-warning{color:#fff;background-color:#ec971f;border-color:#d58512}.btn-warning.active.focus,.btn-warning.active:focus,.btn-warning.active:hover,.btn-warning:active.focus,.btn-warning:active:focus,.btn-warning:active:hover,.open>.dropdown-toggle.btn-warning.focus,.open>.dropdown-toggle.btn-warning:focus,.open>.dropdown-toggle.btn-warning:hover{color:#fff;background-color:#d58512;border-color:#985f0d}.btn-warning.active,.btn-warning:active,.open>.dropdown-toggle.btn-warning{background-image:none}.btn-warning.disabled.focus,.btn-warning.disabled:focus,.btn-warning.disabled:hover,.btn-warning[disabled].focus,.btn-warning[disabled]:focus,.btn-warning[disabled]:hover,fieldset[disabled] .btn-warning.focus,fieldset[disabled] .btn-warning:focus,fieldset[disabled] .btn-warning:hover{background-color:#f0ad4e;border-color:#eea236}.btn-warning .badge{color:#f0ad4e;background-color:#fff}.btn-danger{color:#fff;background-color:#d9534f;border-color:#d43f3a}.btn-danger.focus,.btn-danger:focus{color:#fff;background-color:#c9302c;border-color:#761c19}.btn-danger:hover{color:#fff;background-color:#c9302c;border-color:#ac2925}.btn-danger.active,.btn-danger:active,.open>.dropdown-toggle.btn-danger{color:#fff;background-color:#c9302c;border-color:#ac2925}.btn-danger.active.focus,.btn-danger.active:focus,.btn-danger.active:hover,.btn-danger:active.focus,.btn-danger:active:focus,.btn-danger:active:hover,.open>.dropdown-toggle.btn-danger.focus,.open>.dropdown-toggle.btn-danger:focus,.open>.dropdown-toggle.btn-danger:hover{color:#fff;background-color:#ac2925;border-color:#761c19}.btn-danger.active,.btn-danger:active,.open>.dropdown-toggle.btn-danger{background-image:none}.btn-danger.disabled.focus,.btn-danger.disabled:focus,.btn-danger.disabled:hover,.btn-danger[disabled].focus,.btn-danger[disabled]:focus,.btn-danger[disabled]:hover,fieldset[disabled] .btn-danger.focus,fieldset[disabled] .btn-danger:focus,fieldset[disabled] .btn-danger:hover{background-color:#d9534f;border-color:#d43f3a}.btn-danger .badge{color:#d9534f;background-color:#fff}.btn-link{font-weight:400;color:#337ab7;border-radius:0}.btn-link,.btn-link.active,.btn-link:active,.btn-link[disabled],fieldset[disabled] .btn-link{background-color:transparent;-webkit-box-shadow:none;box-shadow:none}.btn-link,.btn-link:active,.btn-link:focus,.btn-link:hover{border-color:transparent}.btn-link:focus,.btn-link:hover{color:#23527c;text-decoration:underline;background-color:transparent}.btn-link[disabled]:focus,.btn-link[disabled]:hover,fieldset[disabled] .btn-link:focus,fieldset[disabled] .btn-link:hover{color:#777;text-decoration:none}.btn-group-lg>.btn,.btn-lg{padding:10px 16px;font-size:18px;line-height:1.3333333;border-radius:6px}.btn-group-sm>.btn,.btn-sm{padding:5px 10px;font-size:12px;line-height:1.5;border-radius:3px}.btn-group-xs>.btn,.btn-xs{padding:1px 5px;font-size:12px;line-height:1.5;border-radius:3px}.btn-block{display:block;width:100%}.btn-block+.btn-block{margin-top:5px}input[type=button].btn-block,input[type=reset].btn-block,input[type=submit].btn-block{width:100%}.fade{opacity:0;-webkit-transition:opacity .15s linear;-o-transition:opacity .15s linear;transition:opacity .15s linear}.fade.in{opacity:1}.collapse{display:none}.collapse.in{display:block}tr.collapse.in{display:table-row}tbody.collapse.in{display:table-row-group}.collapsing{position:relative;height:0;overflow:hidden;-webkit-transition-timing-function:ease;-o-transition-timing-function:ease;transition-timing-function:ease;-webkit-transition-duration:.35s;-o-transition-duration:.35s;transition-duration:.35s;-webkit-transition-property:height,visibility;-o-transition-property:height,visibility;transition-property:height,visibility}.caret{display:inline-block;width:0;height:0;margin-left:2px;vertical-align:middle;border-top:4px dashed;border-top:4px solid\9;border-right:4px solid transparent;border-left:4px solid transparent}.dropdown,.dropup{position:relative}.dropdown-toggle:focus{outline:0}.dropdown-menu{position:absolute;top:100%;left:0;z-index:1000;display:none;float:left;min-width:160px;padding:5px 0;margin:2px 0 0;font-size:14px;text-align:left;list-style:none;background-color:#fff;-webkit-background-clip:padding-box;background-clip:padding-box;border:1px solid #ccc;border:1px solid rgba(0,0,0,.15);border-radius:4px;-webkit-box-shadow:0 6px 12px rgba(0,0,0,.175);box-shadow:0 6px 12px rgba(0,0,0,.175)}.dropdown-menu.pull-right{right:0;left:auto}.dropdown-menu .divider{height:1px;margin:9px 0;overflow:hidden;background-color:#e5e5e5}.dropdown-menu>li>a{display:block;padding:3px 20px;clear:both;font-weight:400;line-height:1.42857143;color:#333;white-space:nowrap}.dropdown-menu>li>a:focus,.dropdown-menu>li>a:hover{color:#262626;text-decoration:none;background-color:#f5f5f5}.dropdown-menu>.active>a,.dropdown-menu>.active>a:focus,.dropdown-menu>.active>a:hover{color:#fff;text-decoration:none;background-color:#337ab7;outline:0}.dropdown-menu>.disabled>a,.dropdown-menu>.disabled>a:focus,.dropdown-menu>.disabled>a:hover{color:#777}.dropdown-menu>.disabled>a:focus,.dropdown-menu>.disabled>a:hover{text-decoration:none;cursor:not-allowed;background-color:transparent;background-image:none;filter:progid:DXImageTransform.Microsoft.gradient(enabled=false)}.open>.dropdown-menu{display:block}.open>a{outline:0}.dropdown-menu-right{right:0;left:auto}.dropdown-menu-left{right:auto;left:0}.dropdown-header{display:block;padding:3px 20px;font-size:12px;line-height:1.42857143;color:#777;white-space:nowrap}.dropdown-backdrop{position:fixed;top:0;right:0;bottom:0;left:0;z-index:990}.pull-right>.dropdown-menu{right:0;left:auto}.dropup .caret,.navbar-fixed-bottom .dropdown .caret{content:"";border-top:0;border-bottom:4px dashed;border-bottom:4px solid\9}.dropup .dropdown-menu,.navbar-fixed-bottom .dropdown .dropdown-menu{top:auto;bottom:100%;margin-bottom:2px}@media (min-width:768px){.navbar-right .dropdown-menu{right:0;left:auto}.navbar-right .dropdown-menu-left{right:auto;left:0}}.btn-group,.btn-group-vertical{position:relative;display:inline-block;vertical-align:middle}.btn-group-vertical>.btn,.btn-group>.btn{position:relative;float:left}.btn-group-vertical>.btn.active,.btn-group-vertical>.btn:active,.btn-group-vertical>.btn:focus,.btn-group-vertical>.btn:hover,.btn-group>.btn.active,.btn-group>.btn:active,.btn-group>.btn:focus,.btn-group>.btn:hover{z-index:2}.btn-group .btn+.btn,.btn-group .btn+.btn-group,.btn-group .btn-group+.btn,.btn-group .btn-group+.btn-group{margin-left:-1px}.btn-toolbar{margin-left:-5px}.btn-toolbar .btn,.btn-toolbar .btn-group,.btn-toolbar .input-group{float:left}.btn-toolbar>.btn,.btn-toolbar>.btn-group,.btn-toolbar>.input-group{margin-left:5px}.btn-group>.btn:not(:first-child):not(:last-child):not(.dropdown-toggle){border-radius:0}.btn-group>.btn:first-child{margin-left:0}.btn-group>.btn:first-child:not(:last-child):not(.dropdown-toggle){border-top-right-radius:0;border-bottom-right-radius:0}.btn-group>.btn:last-child:not(:first-child),.btn-group>.dropdown-toggle:not(:first-child){border-top-left-radius:0;border-bottom-left-radius:0}.btn-group>.btn-group{float:left}.btn-group>.btn-group:not(:first-child):not(:last-child)>.btn{border-radius:0}.btn-group>.btn-group:first-child:not(:last-child)>.btn:last-child,.btn-group>.btn-group:first-child:not(:last-child)>.dropdown-toggle{border-top-right-radius:0;border-bottom-right-radius:0}.btn-group>.btn-group:last-child:not(:first-child)>.btn:first-child{border-top-left-radius:0;border-bottom-left-radius:0}.btn-group .dropdown-toggle:active,.btn-group.open .dropdown-toggle{outline:0}.btn-group>.btn+.dropdown-toggle{padding-right:8px;padding-left:8px}.btn-group>.btn-lg+.dropdown-toggle{padding-right:12px;padding-left:12px}.btn-group.open .dropdown-toggle{-webkit-box-shadow:inset 0 3px 5px rgba(0,0,0,.125);box-shadow:inset 0 3px 5px rgba(0,0,0,.125)}.btn-group.open .dropdown-toggle.btn-link{-webkit-box-shadow:none;box-shadow:none}.btn .caret{margin-left:0}.btn-lg .caret{border-width:5px 5px 0;border-bottom-width:0}.dropup .btn-lg .caret{border-width:0 5px 5px}.btn-group-vertical>.btn,.btn-group-vertical>.btn-group,.btn-group-vertical>.btn-group>.btn{display:block;float:none;width:100%;max-width:100%}.btn-group-vertical>.btn-group>.btn{float:none}.btn-group-vertical>.btn+.btn,.btn-group-vertical>.btn+.btn-group,.btn-group-vertical>.btn-group+.btn,.btn-group-vertical>.btn-group+.btn-group{margin-top:-1px;margin-left:0}.btn-group-vertical>.btn:not(:first-child):not(:last-child){border-radius:0}.btn-group-vertical>.btn:first-child:not(:last-child){border-top-left-radius:4px;border-top-right-radius:4px;border-bottom-right-radius:0;border-bottom-left-radius:0}.btn-group-vertical>.btn:last-child:not(:first-child){border-top-left-radius:0;border-top-right-radius:0;border-bottom-right-radius:4px;border-bottom-left-radius:4px}.btn-group-vertical>.btn-group:not(:first-child):not(:last-child)>.btn{border-radius:0}.btn-group-vertical>.btn-group:first-child:not(:last-child)>.btn:last-child,.btn-group-vertical>.btn-group:first-child:not(:last-child)>.dropdown-toggle{border-bottom-right-radius:0;border-bottom-left-radius:0}.btn-group-vertical>.btn-group:last-child:not(:first-child)>.btn:first-child{border-top-left-radius:0;border-top-right-radius:0}.btn-group-justified{display:table;width:100%;table-layout:fixed;border-collapse:separate}.btn-group-justified>.btn,.btn-group-justified>.btn-group{display:table-cell;float:none;width:1%}.btn-group-justified>.btn-group .btn{width:100%}.btn-group-justified>.btn-group .dropdown-menu{left:auto}[data-toggle=buttons]>.btn input[type=checkbox],[data-toggle=buttons]>.btn input[type=radio],[data-toggle=buttons]>.btn-group>.btn input[type=checkbox],[data-toggle=buttons]>.btn-group>.btn input[type=radio]{position:absolute;clip:rect(0,0,0,0);pointer-events:none}.input-group{position:relative;display:table;border-collapse:separate}.input-group[class*=col-]{float:none;padding-right:0;padding-left:0}.input-group .form-control{position:relative;z-index:2;float:left;width:100%;margin-bottom:0}.input-group .form-control:focus{z-index:3}.input-group-lg>.form-control,.input-group-lg>.input-group-addon,.input-group-lg>.input-group-btn>.btn{height:46px;padding:10px 16px;font-size:18px;line-height:1.3333333;border-radius:6px}select.input-group-lg>.form-control,select.input-group-lg>.input-group-addon,select.input-group-lg>.input-group-btn>.btn{height:46px;line-height:46px}select[multiple].input-group-lg>.form-control,select[multiple].input-group-lg>.input-group-addon,select[multiple].input-group-lg>.input-group-btn>.btn,textarea.input-group-lg>.form-control,textarea.input-group-lg>.input-group-addon,textarea.input-group-lg>.input-group-btn>.btn{height:auto}.input-group-sm>.form-control,.input-group-sm>.input-group-addon,.input-group-sm>.input-group-btn>.btn{height:30px;padding:5px 10px;font-size:12px;line-height:1.5;border-radius:3px}select.input-group-sm>.form-control,select.input-group-sm>.input-group-addon,select.input-group-sm>.input-group-btn>.btn{height:30px;line-height:30px}select[multiple].input-group-sm>.form-control,select[multiple].input-group-sm>.input-group-addon,select[multiple].input-group-sm>.input-group-btn>.btn,textarea.input-group-sm>.form-control,textarea.input-group-sm>.input-group-addon,textarea.input-group-sm>.input-group-btn>.btn{height:auto}.input-group .form-control,.input-group-addon,.input-group-btn{display:table-cell}.input-group .form-control:not(:first-child):not(:last-child),.input-group-addon:not(:first-child):not(:last-child),.input-group-btn:not(:first-child):not(:last-child){border-radius:0}.input-group-addon,.input-group-btn{width:1%;white-space:nowrap;vertical-align:middle}.input-group-addon{padding:6px 12px;font-size:14px;font-weight:400;line-height:1;color:#555;text-align:center;background-color:#eee;border:1px solid #ccc;border-radius:4px}.input-group-addon.input-sm{padding:5px 10px;font-size:12px;border-radius:3px}.input-group-addon.input-lg{padding:10px 16px;font-size:18px;border-radius:6px}.input-group-addon input[type=checkbox],.input-group-addon input[type=radio]{margin-top:0}.input-group .form-control:first-child,.input-group-addon:first-child,.input-group-btn:first-child>.btn,.input-group-btn:first-child>.btn-group>.btn,.input-group-btn:first-child>.dropdown-toggle,.input-group-btn:last-child>.btn-group:not(:last-child)>.btn,.input-group-btn:last-child>.btn:not(:last-child):not(.dropdown-toggle){border-top-right-radius:0;border-bottom-right-radius:0}.input-group-addon:first-child{border-right:0}.input-group .form-control:last-child,.input-group-addon:last-child,.input-group-btn:first-child>.btn-group:not(:first-child)>.btn,.input-group-btn:first-child>.btn:not(:first-child),.input-group-btn:last-child>.btn,.input-group-btn:last-child>.btn-group>.btn,.input-group-btn:last-child>.dropdown-toggle{border-top-left-radius:0;border-bottom-left-radius:0}.input-group-addon:last-child{border-left:0}.input-group-btn{position:relative;font-size:0;white-space:nowrap}.input-group-btn>.btn{position:relative}.input-group-btn>.btn+.btn{margin-left:-1px}.input-group-btn>.btn:active,.input-group-btn>.btn:focus,.input-group-btn>.btn:hover{z-index:2}.input-group-btn:first-child>.btn,.input-group-btn:first-child>.btn-group{margin-right:-1px}.input-group-btn:last-child>.btn,.input-group-btn:last-child>.btn-group{z-index:2;margin-left:-1px}.nav{padding-left:0;margin-bottom:0;list-style:none}.nav>li{position:relative;display:block}.nav>li>a{position:relative;display:block;padding:10px 15px}.nav>li>a:focus,.nav>li>a:hover{text-decoration:none;background-color:#eee}.nav>li.disabled>a{color:#777}.nav>li.disabled>a:focus,.nav>li.disabled>a:hover{color:#777;text-decoration:none;cursor:not-allowed;background-color:transparent}.nav .open>a,.nav .open>a:focus,.nav .open>a:hover{background-color:#eee;border-color:#337ab7}.nav .nav-divider{height:1px;margin:9px 0;overflow:hidden;background-color:#e5e5e5}.nav>li>a>img{max-width:none}.nav-tabs{border-bottom:1px solid #ddd}.nav-tabs>li{float:left;margin-bottom:-1px}.nav-tabs>li>a{margin-right:2px;line-height:1.42857143;border:1px solid transparent;border-radius:4px 4px 0 0}.nav-tabs>li>a:hover{border-color:#eee #eee #ddd}.nav-tabs>li.active>a,.nav-tabs>li.active>a:focus,.nav-tabs>li.active>a:hover{color:#555;cursor:default;background-color:#fff;border:1px solid #ddd;border-bottom-color:transparent}.nav-tabs.nav-justified{width:100%;border-bottom:0}.nav-tabs.nav-justified>li{float:none}.nav-tabs.nav-justified>li>a{margin-bottom:5px;text-align:center}.nav-tabs.nav-justified>.dropdown .dropdown-menu{top:auto;left:auto}@media (min-width:768px){.nav-tabs.nav-justified>li{display:table-cell;width:1%}.nav-tabs.nav-justified>li>a{margin-bottom:0}}.nav-tabs.nav-justified>li>a{margin-right:0;border-radius:4px}.nav-tabs.nav-justified>.active>a,.nav-tabs.nav-justified>.active>a:focus,.nav-tabs.nav-justified>.active>a:hover{border:1px solid #ddd}@media (min-width:768px){.nav-tabs.nav-justified>li>a{border-bottom:1px solid #ddd;border-radius:4px 4px 0 0}.nav-tabs.nav-justified>.active>a,.nav-tabs.nav-justified>.active>a:focus,.nav-tabs.nav-justified>.active>a:hover{border-bottom-color:#fff}}.nav-pills>li{float:left}.nav-pills>li>a{border-radius:4px}.nav-pills>li+li{margin-left:2px}.nav-pills>li.active>a,.nav-pills>li.active>a:focus,.nav-pills>li.active>a:hover{color:#fff;background-color:#337ab7}.nav-stacked>li{float:none}.nav-stacked>li+li{margin-top:2px;margin-left:0}.nav-justified{width:100%}.nav-justified>li{float:none}.nav-justified>li>a{margin-bottom:5px;text-align:center}.nav-justified>.dropdown .dropdown-menu{top:auto;left:auto}@media (min-width:768px){.nav-justified>li{display:table-cell;width:1%}.nav-justified>li>a{margin-bottom:0}}.nav-tabs-justified{border-bottom:0}.nav-tabs-justified>li>a{margin-right:0;border-radius:4px}.nav-tabs-justified>.active>a,.nav-tabs-justified>.active>a:focus,.nav-tabs-justified>.active>a:hover{border:1px solid #ddd}@media (min-width:768px){.nav-tabs-justified>li>a{border-bottom:1px solid #ddd;border-radius:4px 4px 0 0}.nav-tabs-justified>.active>a,.nav-tabs-justified>.active>a:focus,.nav-tabs-justified>.active>a:hover{border-bottom-color:#fff}}.tab-content>.tab-pane{display:none}.tab-content>.active{display:block}.nav-tabs .dropdown-menu{margin-top:-1px;border-top-left-radius:0;border-top-right-radius:0}.navbar{position:relative;min-height:50px;margin-bottom:20px;border:1px solid transparent}@media (min-width:768px){.navbar{border-radius:4px}}@media (min-width:768px){.navbar-header{float:left}}.navbar-collapse{padding-right:15px;padding-left:15px;overflow-x:visible;-webkit-overflow-scrolling:touch;border-top:1px solid transparent;-webkit-box-shadow:inset 0 1px 0 rgba(255,255,255,.1);box-shadow:inset 0 1px 0 rgba(255,255,255,.1)}.navbar-collapse.in{overflow-y:auto}@media (min-width:768px){.navbar-collapse{width:auto;border-top:0;-webkit-box-shadow:none;box-shadow:none}.navbar-collapse.collapse{display:block!important;height:auto!important;padding-bottom:0;overflow:visible!important}.navbar-collapse.in{overflow-y:visible}.navbar-fixed-bottom .navbar-collapse,.navbar-fixed-top .navbar-collapse,.navbar-static-top .navbar-collapse{padding-right:0;padding-left:0}}.navbar-fixed-bottom .navbar-collapse,.navbar-fixed-top .navbar-collapse{max-height:340px}@media (max-device-width:480px) and (orientation:landscape){.navbar-fixed-bottom .navbar-collapse,.navbar-fixed-top .navbar-collapse{max-height:200px}}.container-fluid>.navbar-collapse,.container-fluid>.navbar-header,.container>.navbar-collapse,.container>.navbar-header{margin-right:-15px;margin-left:-15px}@media (min-width:768px){.container-fluid>.navbar-collapse,.container-fluid>.navbar-header,.container>.navbar-collapse,.container>.navbar-header{margin-right:0;margin-left:0}}.navbar-static-top{z-index:1000;border-width:0 0 1px}@media (min-width:768px){.navbar-static-top{border-radius:0}}.navbar-fixed-bottom,.navbar-fixed-top{position:fixed;right:0;left:0;z-index:1030}@media (min-width:768px){.navbar-fixed-bottom,.navbar-fixed-top{border-radius:0}}.navbar-fixed-top{top:0;border-width:0 0 1px}.navbar-fixed-bottom{bottom:0;margin-bottom:0;border-width:1px 0 0}.navbar-brand{float:left;height:50px;padding:15px 15px;font-size:18px;line-height:20px}.navbar-brand:focus,.navbar-brand:hover{text-decoration:none}.navbar-brand>img{display:block}@media (min-width:768px){.navbar>.container .navbar-brand,.navbar>.container-fluid .navbar-brand{margin-left:-15px}}.navbar-toggle{position:relative;float:right;padding:9px 10px;margin-top:8px;margin-right:15px;margin-bottom:8px;background-color:transparent;background-image:none;border:1px solid transparent;border-radius:4px}.navbar-toggle:focus{outline:0}.navbar-toggle .icon-bar{display:block;width:22px;height:2px;border-radius:1px}.navbar-toggle .icon-bar+.icon-bar{margin-top:4px}@media (min-width:768px){.navbar-toggle{display:none}}.navbar-nav{margin:7.5px -15px}.navbar-nav>li>a{padding-top:10px;padding-bottom:10px;line-height:20px}@media (max-width:767px){.navbar-nav .open .dropdown-menu{position:static;float:none;width:auto;margin-top:0;background-color:transparent;border:0;-webkit-box-shadow:none;box-shadow:none}.navbar-nav .open .dropdown-menu .dropdown-header,.navbar-nav .open .dropdown-menu>li>a{padding:5px 15px 5px 25px}.navbar-nav .open .dropdown-menu>li>a{line-height:20px}.navbar-nav .open .dropdown-menu>li>a:focus,.navbar-nav .open .dropdown-menu>li>a:hover{background-image:none}}@media (min-width:768px){.navbar-nav{float:left;margin:0}.navbar-nav>li{float:left}.navbar-nav>li>a{padding-top:15px;padding-bottom:15px}}.navbar-form{padding:10px 15px;margin-top:8px;margin-right:-15px;margin-bottom:8px;margin-left:-15px;border-top:1px solid transparent;border-bottom:1px solid transparent;-webkit-box-shadow:inset 0 1px 0 rgba(255,255,255,.1),0 1px 0 rgba(255,255,255,.1);box-shadow:inset 0 1px 0 rgba(255,255,255,.1),0 1px 0 rgba(255,255,255,.1)}@media (min-width:768px){.navbar-form .form-group{display:inline-block;margin-bottom:0;vertical-align:middle}.navbar-form .form-control{display:inline-block;width:auto;vertical-align:middle}.navbar-form .form-control-static{display:inline-block}.navbar-form .input-group{display:inline-table;vertical-align:middle}.navbar-form .input-group .form-control,.navbar-form .input-group .input-group-addon,.navbar-form .input-group .input-group-btn{width:auto}.navbar-form .input-group>.form-control{width:100%}.navbar-form .control-label{margin-bottom:0;vertical-align:middle}.navbar-form .checkbox,.navbar-form .radio{display:inline-block;margin-top:0;margin-bottom:0;vertical-align:middle}.navbar-form .checkbox label,.navbar-form .radio label{padding-left:0}.navbar-form .checkbox input[type=checkbox],.navbar-form .radio input[type=radio]{position:relative;margin-left:0}.navbar-form .has-feedback .form-control-feedback{top:0}}@media (max-width:767px){.navbar-form .form-group{margin-bottom:5px}.navbar-form .form-group:last-child{margin-bottom:0}}@media (min-width:768px){.navbar-form{width:auto;padding-top:0;padding-bottom:0;margin-right:0;margin-left:0;border:0;-webkit-box-shadow:none;box-shadow:none}}.navbar-nav>li>.dropdown-menu{margin-top:0;border-top-left-radius:0;border-top-right-radius:0}.navbar-fixed-bottom .navbar-nav>li>.dropdown-menu{margin-bottom:0;border-top-left-radius:4px;border-top-right-radius:4px;border-bottom-right-radius:0;border-bottom-left-radius:0}.navbar-btn{margin-top:8px;margin-bottom:8px}.navbar-btn.btn-sm{margin-top:10px;margin-bottom:10px}.navbar-btn.btn-xs{margin-top:14px;margin-bottom:14px}.navbar-text{margin-top:15px;margin-bottom:15px}@media (min-width:768px){.navbar-text{float:left;margin-right:15px;margin-left:15px}}@media (min-width:768px){.navbar-left{float:left!important}.navbar-right{float:right!important;margin-right:-15px}.navbar-right~.navbar-right{margin-right:0}}.navbar-default{background-color:#f8f8f8;border-color:#e7e7e7}.navbar-default .navbar-brand{color:#777}.navbar-default .navbar-brand:focus,.navbar-default .navbar-brand:hover{color:#5e5e5e;background-color:transparent}.navbar-default .navbar-text{color:#777}.navbar-default .navbar-nav>li>a{color:#777}.navbar-default .navbar-nav>li>a:focus,.navbar-default .navbar-nav>li>a:hover{color:#333;background-color:transparent}.navbar-default .navbar-nav>.active>a,.navbar-default .navbar-nav>.active>a:focus,.navbar-default .navbar-nav>.active>a:hover{color:#555;background-color:#e7e7e7}.navbar-default .navbar-nav>.disabled>a,.navbar-default .navbar-nav>.disabled>a:focus,.navbar-default .navbar-nav>.disabled>a:hover{color:#ccc;background-color:transparent}.navbar-default .navbar-toggle{border-color:#ddd}.navbar-default .navbar-toggle:focus,.navbar-default .navbar-toggle:hover{background-color:#ddd}.navbar-default .navbar-toggle .icon-bar{background-color:#888}.navbar-default .navbar-collapse,.navbar-default .navbar-form{border-color:#e7e7e7}.navbar-default .navbar-nav>.open>a,.navbar-default .navbar-nav>.open>a:focus,.navbar-default .navbar-nav>.open>a:hover{color:#555;background-color:#e7e7e7}@media (max-width:767px){.navbar-default .navbar-nav .open .dropdown-menu>li>a{color:#777}.navbar-default .navbar-nav .open .dropdown-menu>li>a:focus,.navbar-default .navbar-nav .open .dropdown-menu>li>a:hover{color:#333;background-color:transparent}.navbar-default .navbar-nav .open .dropdown-menu>.active>a,.navbar-default .navbar-nav .open .dropdown-menu>.active>a:focus,.navbar-default .navbar-nav .open .dropdown-menu>.active>a:hover{color:#555;background-color:#e7e7e7}.navbar-default .navbar-nav .open .dropdown-menu>.disabled>a,.navbar-default .navbar-nav .open .dropdown-menu>.disabled>a:focus,.navbar-default .navbar-nav .open .dropdown-menu>.disabled>a:hover{color:#ccc;background-color:transparent}}.navbar-default .navbar-link{color:#777}.navbar-default .navbar-link:hover{color:#333}.navbar-default .btn-link{color:#777}.navbar-default .btn-link:focus,.navbar-default .btn-link:hover{color:#333}.navbar-default .btn-link[disabled]:focus,.navbar-default .btn-link[disabled]:hover,fieldset[disabled] .navbar-default .btn-link:focus,fieldset[disabled] .navbar-default .btn-link:hover{color:#ccc}.navbar-inverse{background-color:#222;border-color:#080808}.navbar-inverse .navbar-brand{color:#9d9d9d}.navbar-inverse .navbar-brand:focus,.navbar-inverse .navbar-brand:hover{color:#fff;background-color:transparent}.navbar-inverse .navbar-text{color:#9d9d9d}.navbar-inverse .navbar-nav>li>a{color:#9d9d9d}.navbar-inverse .navbar-nav>li>a:focus,.navbar-inverse .navbar-nav>li>a:hover{color:#fff;background-color:transparent}.navbar-inverse .navbar-nav>.active>a,.navbar-inverse .navbar-nav>.active>a:focus,.navbar-inverse .navbar-nav>.active>a:hover{color:#fff;background-color:#080808}.navbar-inverse .navbar-nav>.disabled>a,.navbar-inverse .navbar-nav>.disabled>a:focus,.navbar-inverse .navbar-nav>.disabled>a:hover{color:#444;background-color:transparent}.navbar-inverse .navbar-toggle{border-color:#333}.navbar-inverse .navbar-toggle:focus,.navbar-inverse .navbar-toggle:hover{background-color:#333}.navbar-inverse .navbar-toggle .icon-bar{background-color:#fff}.navbar-inverse .navbar-collapse,.navbar-inverse .navbar-form{border-color:#101010}.navbar-inverse .navbar-nav>.open>a,.navbar-inverse .navbar-nav>.open>a:focus,.navbar-inverse .navbar-nav>.open>a:hover{color:#fff;background-color:#080808}@media (max-width:767px){.navbar-inverse .navbar-nav .open .dropdown-menu>.dropdown-header{border-color:#080808}.navbar-inverse .navbar-nav .open .dropdown-menu .divider{background-color:#080808}.navbar-inverse .navbar-nav .open .dropdown-menu>li>a{color:#9d9d9d}.navbar-inverse .navbar-nav .open .dropdown-menu>li>a:focus,.navbar-inverse .navbar-nav .open .dropdown-menu>li>a:hover{color:#fff;background-color:transparent}.navbar-inverse .navbar-nav .open .dropdown-menu>.active>a,.navbar-inverse .navbar-nav .open .dropdown-menu>.active>a:focus,.navbar-inverse .navbar-nav .open .dropdown-menu>.active>a:hover{color:#fff;background-color:#080808}.navbar-inverse .navbar-nav .open .dropdown-menu>.disabled>a,.navbar-inverse .navbar-nav .open .dropdown-menu>.disabled>a:focus,.navbar-inverse .navbar-nav .open .dropdown-menu>.disabled>a:hover{color:#444;background-color:transparent}}.navbar-inverse .navbar-link{color:#9d9d9d}.navbar-inverse .navbar-link:hover{color:#fff}.navbar-inverse .btn-link{color:#9d9d9d}.navbar-inverse .btn-link:focus,.navbar-inverse .btn-link:hover{color:#fff}.navbar-inverse .btn-link[disabled]:focus,.navbar-inverse .btn-link[disabled]:hover,fieldset[disabled] .navbar-inverse .btn-link:focus,fieldset[disabled] .navbar-inverse .btn-link:hover{color:#444}.breadcrumb{padding:8px 15px;margin-bottom:20px;list-style:none;background-color:#f5f5f5;border-radius:4px}.breadcrumb>li{display:inline-block}.breadcrumb>li+li:before{padding:0 5px;color:#ccc;content:"/\00a0"}.breadcrumb>.active{color:#777}.pagination{display:inline-block;padding-left:0;margin:20px 0;border-radius:4px}.pagination>li{display:inline}.pagination>li>a,.pagination>li>span{position:relative;float:left;padding:6px 12px;margin-left:-1px;line-height:1.42857143;color:#337ab7;text-decoration:none;background-color:#fff;border:1px solid #ddd}.pagination>li:first-child>a,.pagination>li:first-child>span{margin-left:0;border-top-left-radius:4px;border-bottom-left-radius:4px}.pagination>li:last-child>a,.pagination>li:last-child>span{border-top-right-radius:4px;border-bottom-right-radius:4px}.pagination>li>a:focus,.pagination>li>a:hover,.pagination>li>span:focus,.pagination>li>span:hover{z-index:2;color:#23527c;background-color:#eee;border-color:#ddd}.pagination>.active>a,.pagination>.active>a:focus,.pagination>.active>a:hover,.pagination>.active>span,.pagination>.active>span:focus,.pagination>.active>span:hover{z-index:3;color:#fff;cursor:default;background-color:#337ab7;border-color:#337ab7}.pagination>.disabled>a,.pagination>.disabled>a:focus,.pagination>.disabled>a:hover,.pagination>.disabled>span,.pagination>.disabled>span:focus,.pagination>.disabled>span:hover{color:#777;cursor:not-allowed;background-color:#fff;border-color:#ddd}.pagination-lg>li>a,.pagination-lg>li>span{padding:10px 16px;font-size:18px;line-height:1.3333333}.pagination-lg>li:first-child>a,.pagination-lg>li:first-child>span{border-top-left-radius:6px;border-bottom-left-radius:6px}.pagination-lg>li:last-child>a,.pagination-lg>li:last-child>span{border-top-right-radius:6px;border-bottom-right-radius:6px}.pagination-sm>li>a,.pagination-sm>li>span{padding:5px 10px;font-size:12px;line-height:1.5}.pagination-sm>li:first-child>a,.pagination-sm>li:first-child>span{border-top-left-radius:3px;border-bottom-left-radius:3px}.pagination-sm>li:last-child>a,.pagination-sm>li:last-child>span{border-top-right-radius:3px;border-bottom-right-radius:3px}.pager{padding-left:0;margin:20px 0;text-align:center;list-style:none}.pager li{display:inline}.pager li>a,.pager li>span{display:inline-block;padding:5px 14px;background-color:#fff;border:1px solid #ddd;border-radius:15px}.pager li>a:focus,.pager li>a:hover{text-decoration:none;background-color:#eee}.pager .next>a,.pager .next>span{float:right}.pager .previous>a,.pager .previous>span{float:left}.pager .disabled>a,.pager .disabled>a:focus,.pager .disabled>a:hover,.pager .disabled>span{color:#777;cursor:not-allowed;background-color:#fff}.label{display:inline;padding:.2em .6em .3em;font-size:75%;font-weight:700;line-height:1;color:#fff;text-align:center;white-space:nowrap;vertical-align:baseline;border-radius:.25em}a.label:focus,a.label:hover{color:#fff;text-decoration:none;cursor:pointer}.label:empty{display:none}.btn .label{position:relative;top:-1px}.label-default{background-color:#777}.label-default[href]:focus,.label-default[href]:hover{background-color:#5e5e5e}.label-primary{background-color:#337ab7}.label-primary[href]:focus,.label-primary[href]:hover{background-color:#286090}.label-success{background-color:#5cb85c}.label-success[href]:focus,.label-success[href]:hover{background-color:#449d44}.label-info{background-color:#5bc0de}.label-info[href]:focus,.label-info[href]:hover{background-color:#31b0d5}.label-warning{background-color:#f0ad4e}.label-warning[href]:focus,.label-warning[href]:hover{background-color:#ec971f}.label-danger{background-color:#d9534f}.label-danger[href]:focus,.label-danger[href]:hover{background-color:#c9302c}.badge{display:inline-block;min-width:10px;padding:3px 7px;font-size:12px;font-weight:700;line-height:1;color:#fff;text-align:center;white-space:nowrap;vertical-align:middle;background-color:#777;border-radius:10px}.badge:empty{display:none}.btn .badge{position:relative;top:-1px}.btn-group-xs>.btn .badge,.btn-xs .badge{top:0;padding:1px 5px}a.badge:focus,a.badge:hover{color:#fff;text-decoration:none;cursor:pointer}.list-group-item.active>.badge,.nav-pills>.active>a>.badge{color:#337ab7;background-color:#fff}.list-group-item>.badge{float:right}.list-group-item>.badge+.badge{margin-right:5px}.nav-pills>li>a>.badge{margin-left:3px}.jumbotron{padding-top:30px;padding-bottom:30px;margin-bottom:30px;color:inherit;background-color:#eee}.jumbotron .h1,.jumbotron h1{color:inherit}.jumbotron p{margin-bottom:15px;font-size:21px;font-weight:200}.jumbotron>hr{border-top-color:#d5d5d5}.container .jumbotron,.container-fluid .jumbotron{padding-right:15px;padding-left:15px;border-radius:6px}.jumbotron .container{max-width:100%}@media screen and (min-width:768px){.jumbotron{padding-top:48px;padding-bottom:48px}.container .jumbotron,.container-fluid .jumbotron{padding-right:60px;padding-left:60px}.jumbotron .h1,.jumbotron h1{font-size:63px}}.thumbnail{display:block;padding:4px;margin-bottom:20px;line-height:1.42857143;background-color:#fff;border:1px solid #ddd;border-radius:4px;-webkit-transition:border .2s ease-in-out;-o-transition:border .2s ease-in-out;transition:border .2s ease-in-out}.thumbnail a>img,.thumbnail>img{margin-right:auto;margin-left:auto}a.thumbnail.active,a.thumbnail:focus,a.thumbnail:hover{border-color:#337ab7}.thumbnail .caption{padding:9px;color:#333}.alert{padding:15px;margin-bottom:20px;border:1px solid transparent;border-radius:4px}.alert h4{margin-top:0;color:inherit}.alert .alert-link{font-weight:700}.alert>p,.alert>ul{margin-bottom:0}.alert>p+p{margin-top:5px}.alert-dismissable,.alert-dismissible{padding-right:35px}.alert-dismissable .close,.alert-dismissible .close{position:relative;top:-2px;right:-21px;color:inherit}.alert-success{color:#3c763d;background-color:#dff0d8;border-color:#d6e9c6}.alert-success hr{border-top-color:#c9e2b3}.alert-success .alert-link{color:#2b542c}.alert-info{color:#31708f;background-color:#d9edf7;border-color:#bce8f1}.alert-info hr{border-top-color:#a6e1ec}.alert-info .alert-link{color:#245269}.alert-warning{color:#8a6d3b;background-color:#fcf8e3;border-color:#faebcc}.alert-warning hr{border-top-color:#f7e1b5}.alert-warning .alert-link{color:#66512c}.alert-danger{color:#a94442;background-color:#f2dede;border-color:#ebccd1}.alert-danger hr{border-top-color:#e4b9c0}.alert-danger .alert-link{color:#843534}@-webkit-keyframes progress-bar-stripes{from{background-position:40px 0}to{background-position:0 0}}@-o-keyframes progress-bar-stripes{from{background-position:40px 0}to{background-position:0 0}}@keyframes progress-bar-stripes{from{background-position:40px 0}to{background-position:0 0}}.progress{height:20px;margin-bottom:20px;overflow:hidden;background-color:#f5f5f5;border-radius:4px;-webkit-box-shadow:inset 0 1px 2px rgba(0,0,0,.1);box-shadow:inset 0 1px 2px rgba(0,0,0,.1)}.progress-bar{float:left;width:0;height:100%;font-size:12px;line-height:20px;color:#fff;text-align:center;background-color:#337ab7;-webkit-box-shadow:inset 0 -1px 0 rgba(0,0,0,.15);box-shadow:inset 0 -1px 0 rgba(0,0,0,.15);-webkit-transition:width .6s ease;-o-transition:width .6s ease;transition:width .6s ease}.progress-bar-striped,.progress-striped .progress-bar{background-image:-webkit-linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);background-image:-o-linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);background-image:linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);-webkit-background-size:40px 40px;background-size:40px 40px}.progress-bar.active,.progress.active .progress-bar{-webkit-animation:progress-bar-stripes 2s linear infinite;-o-animation:progress-bar-stripes 2s linear infinite;animation:progress-bar-stripes 2s linear infinite}.progress-bar-success{background-color:#5cb85c}.progress-striped .progress-bar-success{background-image:-webkit-linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);background-image:-o-linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);background-image:linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent)}.progress-bar-info{background-color:#5bc0de}.progress-striped .progress-bar-info{background-image:-webkit-linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);background-image:-o-linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);background-image:linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent)}.progress-bar-warning{background-color:#f0ad4e}.progress-striped .progress-bar-warning{background-image:-webkit-linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);background-image:-o-linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);background-image:linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent)}.progress-bar-danger{background-color:#d9534f}.progress-striped .progress-bar-danger{background-image:-webkit-linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);background-image:-o-linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);background-image:linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent)}.media{margin-top:15px}.media:first-child{margin-top:0}.media,.media-body{overflow:hidden;zoom:1}.media-body{width:10000px}.media-object{display:block}.media-object.img-thumbnail{max-width:none}.media-right,.media>.pull-right{padding-left:10px}.media-left,.media>.pull-left{padding-right:10px}.media-body,.media-left,.media-right{display:table-cell;vertical-align:top}.media-middle{vertical-align:middle}.media-bottom{vertical-align:bottom}.media-heading{margin-top:0;margin-bottom:5px}.media-list{padding-left:0;list-style:none}.list-group{padding-left:0;margin-bottom:20px}.list-group-item{position:relative;display:block;padding:10px 15px;margin-bottom:-1px;background-color:#fff;border:1px solid #ddd}.list-group-item:first-child{border-top-left-radius:4px;border-top-right-radius:4px}.list-group-item:last-child{margin-bottom:0;border-bottom-right-radius:4px;border-bottom-left-radius:4px}a.list-group-item,button.list-group-item{color:#555}a.list-group-item .list-group-item-heading,button.list-group-item .list-group-item-heading{color:#333}a.list-group-item:focus,a.list-group-item:hover,button.list-group-item:focus,button.list-group-item:hover{color:#555;text-decoration:none;background-color:#f5f5f5}button.list-group-item{width:100%;text-align:left}.list-group-item.disabled,.list-group-item.disabled:focus,.list-group-item.disabled:hover{color:#777;cursor:not-allowed;background-color:#eee}.list-group-item.disabled .list-group-item-heading,.list-group-item.disabled:focus .list-group-item-heading,.list-group-item.disabled:hover .list-group-item-heading{color:inherit}.list-group-item.disabled .list-group-item-text,.list-group-item.disabled:focus .list-group-item-text,.list-group-item.disabled:hover .list-group-item-text{color:#777}.list-group-item.active,.list-group-item.active:focus,.list-group-item.active:hover{z-index:2;color:#fff;background-color:#337ab7;border-color:#337ab7}.list-group-item.active .list-group-item-heading,.list-group-item.active .list-group-item-heading>.small,.list-group-item.active .list-group-item-heading>small,.list-group-item.active:focus .list-group-item-heading,.list-group-item.active:focus .list-group-item-heading>.small,.list-group-item.active:focus .list-group-item-heading>small,.list-group-item.active:hover .list-group-item-heading,.list-group-item.active:hover .list-group-item-heading>.small,.list-group-item.active:hover .list-group-item-heading>small{color:inherit}.list-group-item.active .list-group-item-text,.list-group-item.active:focus .list-group-item-text,.list-group-item.active:hover .list-group-item-text{color:#c7ddef}.list-group-item-success{color:#3c763d;background-color:#dff0d8}a.list-group-item-success,button.list-group-item-success{color:#3c763d}a.list-group-item-success .list-group-item-heading,button.list-group-item-success .list-group-item-heading{color:inherit}a.list-group-item-success:focus,a.list-group-item-success:hover,button.list-group-item-success:focus,button.list-group-item-success:hover{color:#3c763d;background-color:#d0e9c6}a.list-group-item-success.active,a.list-group-item-success.active:focus,a.list-group-item-success.active:hover,button.list-group-item-success.active,button.list-group-item-success.active:focus,button.list-group-item-success.active:hover{color:#fff;background-color:#3c763d;border-color:#3c763d}.list-group-item-info{color:#31708f;background-color:#d9edf7}a.list-group-item-info,button.list-group-item-info{color:#31708f}a.list-group-item-info .list-group-item-heading,button.list-group-item-info .list-group-item-heading{color:inherit}a.list-group-item-info:focus,a.list-group-item-info:hover,button.list-group-item-info:focus,button.list-group-item-info:hover{color:#31708f;background-color:#c4e3f3}a.list-group-item-info.active,a.list-group-item-info.active:focus,a.list-group-item-info.active:hover,button.list-group-item-info.active,button.list-group-item-info.active:focus,button.list-group-item-info.active:hover{color:#fff;background-color:#31708f;border-color:#31708f}.list-group-item-warning{color:#8a6d3b;background-color:#fcf8e3}a.list-group-item-warning,button.list-group-item-warning{color:#8a6d3b}a.list-group-item-warning .list-group-item-heading,button.list-group-item-warning .list-group-item-heading{color:inherit}a.list-group-item-warning:focus,a.list-group-item-warning:hover,button.list-group-item-warning:focus,button.list-group-item-warning:hover{color:#8a6d3b;background-color:#faf2cc}a.list-group-item-warning.active,a.list-group-item-warning.active:focus,a.list-group-item-warning.active:hover,button.list-group-item-warning.active,button.list-group-item-warning.active:focus,button.list-group-item-warning.active:hover{color:#fff;background-color:#8a6d3b;border-color:#8a6d3b}.list-group-item-danger{color:#a94442;background-color:#f2dede}a.list-group-item-danger,button.list-group-item-danger{color:#a94442}a.list-group-item-danger .list-group-item-heading,button.list-group-item-danger .list-group-item-heading{color:inherit}a.list-group-item-danger:focus,a.list-group-item-danger:hover,button.list-group-item-danger:focus,button.list-group-item-danger:hover{color:#a94442;background-color:#ebcccc}a.list-group-item-danger.active,a.list-group-item-danger.active:focus,a.list-group-item-danger.active:hover,button.list-group-item-danger.active,button.list-group-item-danger.active:focus,button.list-group-item-danger.active:hover{color:#fff;background-color:#a94442;border-color:#a94442}.list-group-item-heading{margin-top:0;margin-bottom:5px}.list-group-item-text{margin-bottom:0;line-height:1.3}.panel{margin-bottom:20px;background-color:#fff;border:1px solid transparent;border-radius:4px;-webkit-box-shadow:0 1px 1px rgba(0,0,0,.05);box-shadow:0 1px 1px rgba(0,0,0,.05)}.panel-body{padding:15px}.panel-heading{padding:10px 15px;border-bottom:1px solid transparent;border-top-left-radius:3px;border-top-right-radius:3px}.panel-heading>.dropdown .dropdown-toggle{color:inherit}.panel-title{margin-top:0;margin-bottom:0;font-size:16px;color:inherit}.panel-title>.small,.panel-title>.small>a,.panel-title>a,.panel-title>small,.panel-title>small>a{color:inherit}.panel-footer{padding:10px 15px;background-color:#f5f5f5;border-top:1px solid #ddd;border-bottom-right-radius:3px;border-bottom-left-radius:3px}.panel>.list-group,.panel>.panel-collapse>.list-group{margin-bottom:0}.panel>.list-group .list-group-item,.panel>.panel-collapse>.list-group .list-group-item{border-width:1px 0;border-radius:0}.panel>.list-group:first-child .list-group-item:first-child,.panel>.panel-collapse>.list-group:first-child .list-group-item:first-child{border-top:0;border-top-left-radius:3px;border-top-right-radius:3px}.panel>.list-group:last-child .list-group-item:last-child,.panel>.panel-collapse>.list-group:last-child .list-group-item:last-child{border-bottom:0;border-bottom-right-radius:3px;border-bottom-left-radius:3px}.panel>.panel-heading+.panel-collapse>.list-group .list-group-item:first-child{border-top-left-radius:0;border-top-right-radius:0}.panel-heading+.list-group .list-group-item:first-child{border-top-width:0}.list-group+.panel-footer{border-top-width:0}.panel>.panel-collapse>.table,.panel>.table,.panel>.table-responsive>.table{margin-bottom:0}.panel>.panel-collapse>.table caption,.panel>.table caption,.panel>.table-responsive>.table caption{padding-right:15px;padding-left:15px}.panel>.table-responsive:first-child>.table:first-child,.panel>.table:first-child{border-top-left-radius:3px;border-top-right-radius:3px}.panel>.table-responsive:first-child>.table:first-child>tbody:first-child>tr:first-child,.panel>.table-responsive:first-child>.table:first-child>thead:first-child>tr:first-child,.panel>.table:first-child>tbody:first-child>tr:first-child,.panel>.table:first-child>thead:first-child>tr:first-child{border-top-left-radius:3px;border-top-right-radius:3px}.panel>.table-responsive:first-child>.table:first-child>tbody:first-child>tr:first-child td:first-child,.panel>.table-responsive:first-child>.table:first-child>tbody:first-child>tr:first-child th:first-child,.panel>.table-responsive:first-child>.table:first-child>thead:first-child>tr:first-child td:first-child,.panel>.table-responsive:first-child>.table:first-child>thead:first-child>tr:first-child th:first-child,.panel>.table:first-child>tbody:first-child>tr:first-child td:first-child,.panel>.table:first-child>tbody:first-child>tr:first-child th:first-child,.panel>.table:first-child>thead:first-child>tr:first-child td:first-child,.panel>.table:first-child>thead:first-child>tr:first-child th:first-child{border-top-left-radius:3px}.panel>.table-responsive:first-child>.table:first-child>tbody:first-child>tr:first-child td:last-child,.panel>.table-responsive:first-child>.table:first-child>tbody:first-child>tr:first-child th:last-child,.panel>.table-responsive:first-child>.table:first-child>thead:first-child>tr:first-child td:last-child,.panel>.table-responsive:first-child>.table:first-child>thead:first-child>tr:first-child th:last-child,.panel>.table:first-child>tbody:first-child>tr:first-child td:last-child,.panel>.table:first-child>tbody:first-child>tr:first-child th:last-child,.panel>.table:first-child>thead:first-child>tr:first-child td:last-child,.panel>.table:first-child>thead:first-child>tr:first-child th:last-child{border-top-right-radius:3px}.panel>.table-responsive:last-child>.table:last-child,.panel>.table:last-child{border-bottom-right-radius:3px;border-bottom-left-radius:3px}.panel>.table-responsive:last-child>.table:last-child>tbody:last-child>tr:last-child,.panel>.table-responsive:last-child>.table:last-child>tfoot:last-child>tr:last-child,.panel>.table:last-child>tbody:last-child>tr:last-child,.panel>.table:last-child>tfoot:last-child>tr:last-child{border-bottom-right-radius:3px;border-bottom-left-radius:3px}.panel>.table-responsive:last-child>.table:last-child>tbody:last-child>tr:last-child td:first-child,.panel>.table-responsive:last-child>.table:last-child>tbody:last-child>tr:last-child th:first-child,.panel>.table-responsive:last-child>.table:last-child>tfoot:last-child>tr:last-child td:first-child,.panel>.table-responsive:last-child>.table:last-child>tfoot:last-child>tr:last-child th:first-child,.panel>.table:last-child>tbody:last-child>tr:last-child td:first-child,.panel>.table:last-child>tbody:last-child>tr:last-child th:first-child,.panel>.table:last-child>tfoot:last-child>tr:last-child td:first-child,.panel>.table:last-child>tfoot:last-child>tr:last-child th:first-child{border-bottom-left-radius:3px}.panel>.table-responsive:last-child>.table:last-child>tbody:last-child>tr:last-child td:last-child,.panel>.table-responsive:last-child>.table:last-child>tbody:last-child>tr:last-child th:last-child,.panel>.table-responsive:last-child>.table:last-child>tfoot:last-child>tr:last-child td:last-child,.panel>.table-responsive:last-child>.table:last-child>tfoot:last-child>tr:last-child th:last-child,.panel>.table:last-child>tbody:last-child>tr:last-child td:last-child,.panel>.table:last-child>tbody:last-child>tr:last-child th:last-child,.panel>.table:last-child>tfoot:last-child>tr:last-child td:last-child,.panel>.table:last-child>tfoot:last-child>tr:last-child th:last-child{border-bottom-right-radius:3px}.panel>.panel-body+.table,.panel>.panel-body+.table-responsive,.panel>.table+.panel-body,.panel>.table-responsive+.panel-body{border-top:1px solid #ddd}.panel>.table>tbody:first-child>tr:first-child td,.panel>.table>tbody:first-child>tr:first-child th{border-top:0}.panel>.table-bordered,.panel>.table-responsive>.table-bordered{border:0}.panel>.table-bordered>tbody>tr>td:first-child,.panel>.table-bordered>tbody>tr>th:first-child,.panel>.table-bordered>tfoot>tr>td:first-child,.panel>.table-bordered>tfoot>tr>th:first-child,.panel>.table-bordered>thead>tr>td:first-child,.panel>.table-bordered>thead>tr>th:first-child,.panel>.table-responsive>.table-bordered>tbody>tr>td:first-child,.panel>.table-responsive>.table-bordered>tbody>tr>th:first-child,.panel>.table-responsive>.table-bordered>tfoot>tr>td:first-child,.panel>.table-responsive>.table-bordered>tfoot>tr>th:first-child,.panel>.table-responsive>.table-bordered>thead>tr>td:first-child,.panel>.table-responsive>.table-bordered>thead>tr>th:first-child{border-left:0}.panel>.table-bordered>tbody>tr>td:last-child,.panel>.table-bordered>tbody>tr>th:last-child,.panel>.table-bordered>tfoot>tr>td:last-child,.panel>.table-bordered>tfoot>tr>th:last-child,.panel>.table-bordered>thead>tr>td:last-child,.panel>.table-bordered>thead>tr>th:last-child,.panel>.table-responsive>.table-bordered>tbody>tr>td:last-child,.panel>.table-responsive>.table-bordered>tbody>tr>th:last-child,.panel>.table-responsive>.table-bordered>tfoot>tr>td:last-child,.panel>.table-responsive>.table-bordered>tfoot>tr>th:last-child,.panel>.table-responsive>.table-bordered>thead>tr>td:last-child,.panel>.table-responsive>.table-bordered>thead>tr>th:last-child{border-right:0}.panel>.table-bordered>tbody>tr:first-child>td,.panel>.table-bordered>tbody>tr:first-child>th,.panel>.table-bordered>thead>tr:first-child>td,.panel>.table-bordered>thead>tr:first-child>th,.panel>.table-responsive>.table-bordered>tbody>tr:first-child>td,.panel>.table-responsive>.table-bordered>tbody>tr:first-child>th,.panel>.table-responsive>.table-bordered>thead>tr:first-child>td,.panel>.table-responsive>.table-bordered>thead>tr:first-child>th{border-bottom:0}.panel>.table-bordered>tbody>tr:last-child>td,.panel>.table-bordered>tbody>tr:last-child>th,.panel>.table-bordered>tfoot>tr:last-child>td,.panel>.table-bordered>tfoot>tr:last-child>th,.panel>.table-responsive>.table-bordered>tbody>tr:last-child>td,.panel>.table-responsive>.table-bordered>tbody>tr:last-child>th,.panel>.table-responsive>.table-bordered>tfoot>tr:last-child>td,.panel>.table-responsive>.table-bordered>tfoot>tr:last-child>th{border-bottom:0}.panel>.table-responsive{margin-bottom:0;border:0}.panel-group{margin-bottom:20px}.panel-group .panel{margin-bottom:0;border-radius:4px}.panel-group .panel+.panel{margin-top:5px}.panel-group .panel-heading{border-bottom:0}.panel-group .panel-heading+.panel-collapse>.list-group,.panel-group .panel-heading+.panel-collapse>.panel-body{border-top:1px solid #ddd}.panel-group .panel-footer{border-top:0}.panel-group .panel-footer+.panel-collapse .panel-body{border-bottom:1px solid #ddd}.panel-default{border-color:#ddd}.panel-default>.panel-heading{color:#333;background-color:#f5f5f5;border-color:#ddd}.panel-default>.panel-heading+.panel-collapse>.panel-body{border-top-color:#ddd}.panel-default>.panel-heading .badge{color:#f5f5f5;background-color:#333}.panel-default>.panel-footer+.panel-collapse>.panel-body{border-bottom-color:#ddd}.panel-primary{border-color:#337ab7}.panel-primary>.panel-heading{color:#fff;background-color:#337ab7;border-color:#337ab7}.panel-primary>.panel-heading+.panel-collapse>.panel-body{border-top-color:#337ab7}.panel-primary>.panel-heading .badge{color:#337ab7;background-color:#fff}.panel-primary>.panel-footer+.panel-collapse>.panel-body{border-bottom-color:#337ab7}.panel-success{border-color:#d6e9c6}.panel-success>.panel-heading{color:#3c763d;background-color:#dff0d8;border-color:#d6e9c6}.panel-success>.panel-heading+.panel-collapse>.panel-body{border-top-color:#d6e9c6}.panel-success>.panel-heading .badge{color:#dff0d8;background-color:#3c763d}.panel-success>.panel-footer+.panel-collapse>.panel-body{border-bottom-color:#d6e9c6}.panel-info{border-color:#bce8f1}.panel-info>.panel-heading{color:#31708f;background-color:#d9edf7;border-color:#bce8f1}.panel-info>.panel-heading+.panel-collapse>.panel-body{border-top-color:#bce8f1}.panel-info>.panel-heading .badge{color:#d9edf7;background-color:#31708f}.panel-info>.panel-footer+.panel-collapse>.panel-body{border-bottom-color:#bce8f1}.panel-warning{border-color:#faebcc}.panel-warning>.panel-heading{color:#8a6d3b;background-color:#fcf8e3;border-color:#faebcc}.panel-warning>.panel-heading+.panel-collapse>.panel-body{border-top-color:#faebcc}.panel-warning>.panel-heading .badge{color:#fcf8e3;background-color:#8a6d3b}.panel-warning>.panel-footer+.panel-collapse>.panel-body{border-bottom-color:#faebcc}.panel-danger{border-color:#ebccd1}.panel-danger>.panel-heading{color:#a94442;background-color:#f2dede;border-color:#ebccd1}.panel-danger>.panel-heading+.panel-collapse>.panel-body{border-top-color:#ebccd1}.panel-danger>.panel-heading .badge{color:#f2dede;background-color:#a94442}.panel-danger>.panel-footer+.panel-collapse>.panel-body{border-bottom-color:#ebccd1}.embed-responsive{position:relative;display:block;height:0;padding:0;overflow:hidden}.embed-responsive .embed-responsive-item,.embed-responsive embed,.embed-responsive iframe,.embed-responsive object,.embed-responsive video{position:absolute;top:0;bottom:0;left:0;width:100%;height:100%;border:0}.embed-responsive-16by9{padding-bottom:56.25%}.embed-responsive-4by3{padding-bottom:75%}.well{min-height:20px;padding:19px;margin-bottom:20px;background-color:#f5f5f5;border:1px solid #e3e3e3;border-radius:4px;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.05);box-shadow:inset 0 1px 1px rgba(0,0,0,.05)}.well blockquote{border-color:#ddd;border-color:rgba(0,0,0,.15)}.well-lg{padding:24px;border-radius:6px}.well-sm{padding:9px;border-radius:3px}.close{float:right;font-size:21px;font-weight:700;line-height:1;color:#000;text-shadow:0 1px 0 #fff;filter:alpha(opacity=20);opacity:.2}.close:focus,.close:hover{color:#000;text-decoration:none;cursor:pointer;filter:alpha(opacity=50);opacity:.5}button.close{-webkit-appearance:none;padding:0;cursor:pointer;background:0 0;border:0}.modal-open{overflow:hidden}.modal{position:fixed;top:0;right:0;bottom:0;left:0;z-index:1050;display:none;overflow:hidden;-webkit-overflow-scrolling:touch;outline:0}.modal.fade .modal-dialog{-webkit-transition:-webkit-transform .3s ease-out;-o-transition:-o-transform .3s ease-out;transition:transform .3s ease-out;-webkit-transform:translate(0,-25%);-ms-transform:translate(0,-25%);-o-transform:translate(0,-25%);transform:translate(0,-25%)}.modal.in .modal-dialog{-webkit-transform:translate(0,0);-ms-transform:translate(0,0);-o-transform:translate(0,0);transform:translate(0,0)}.modal-open .modal{overflow-x:hidden;overflow-y:auto}.modal-dialog{position:relative;width:auto;margin:10px}.modal-content{position:relative;background-color:#fff;-webkit-background-clip:padding-box;background-clip:padding-box;border:1px solid #999;border:1px solid rgba(0,0,0,.2);border-radius:6px;outline:0;-webkit-box-shadow:0 3px 9px rgba(0,0,0,.5);box-shadow:0 3px 9px rgba(0,0,0,.5)}.modal-backdrop{position:fixed;top:0;right:0;bottom:0;left:0;z-index:1040;background-color:#000}.modal-backdrop.fade{filter:alpha(opacity=0);opacity:0}.modal-backdrop.in{filter:alpha(opacity=50);opacity:.5}.modal-header{padding:15px;border-bottom:1px solid #e5e5e5}.modal-header .close{margin-top:-2px}.modal-title{margin:0;line-height:1.42857143}.modal-body{position:relative;padding:15px}.modal-footer{padding:15px;text-align:right;border-top:1px solid #e5e5e5}.modal-footer .btn+.btn{margin-bottom:0;margin-left:5px}.modal-footer .btn-group .btn+.btn{margin-left:-1px}.modal-footer .btn-block+.btn-block{margin-left:0}.modal-scrollbar-measure{position:absolute;top:-9999px;width:50px;height:50px;overflow:scroll}@media (min-width:768px){.modal-dialog{width:600px;margin:30px auto}.modal-content{-webkit-box-shadow:0 5px 15px rgba(0,0,0,.5);box-shadow:0 5px 15px rgba(0,0,0,.5)}.modal-sm{width:300px}}@media (min-width:992px){.modal-lg{width:900px}}.tooltip{position:absolute;z-index:1070;display:block;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:12px;font-style:normal;font-weight:400;line-height:1.42857143;text-align:left;text-align:start;text-decoration:none;text-shadow:none;text-transform:none;letter-spacing:normal;word-break:normal;word-spacing:normal;word-wrap:normal;white-space:normal;filter:alpha(opacity=0);opacity:0;line-break:auto}.tooltip.in{filter:alpha(opacity=90);opacity:.9}.tooltip.top{padding:5px 0;margin-top:-3px}.tooltip.right{padding:0 5px;margin-left:3px}.tooltip.bottom{padding:5px 0;margin-top:3px}.tooltip.left{padding:0 5px;margin-left:-3px}.tooltip-inner{max-width:200px;padding:3px 8px;color:#fff;text-align:center;background-color:#000;border-radius:4px}.tooltip-arrow{position:absolute;width:0;height:0;border-color:transparent;border-style:solid}.tooltip.top .tooltip-arrow{bottom:0;left:50%;margin-left:-5px;border-width:5px 5px 0;border-top-color:#000}.tooltip.top-left .tooltip-arrow{right:5px;bottom:0;margin-bottom:-5px;border-width:5px 5px 0;border-top-color:#000}.tooltip.top-right .tooltip-arrow{bottom:0;left:5px;margin-bottom:-5px;border-width:5px 5px 0;border-top-color:#000}.tooltip.right .tooltip-arrow{top:50%;left:0;margin-top:-5px;border-width:5px 5px 5px 0;border-right-color:#000}.tooltip.left .tooltip-arrow{top:50%;right:0;margin-top:-5px;border-width:5px 0 5px 5px;border-left-color:#000}.tooltip.bottom .tooltip-arrow{top:0;left:50%;margin-left:-5px;border-width:0 5px 5px;border-bottom-color:#000}.tooltip.bottom-left .tooltip-arrow{top:0;right:5px;margin-top:-5px;border-width:0 5px 5px;border-bottom-color:#000}.tooltip.bottom-right .tooltip-arrow{top:0;left:5px;margin-top:-5px;border-width:0 5px 5px;border-bottom-color:#000}.popover{position:absolute;top:0;left:0;z-index:1060;display:none;max-width:276px;padding:1px;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:14px;font-style:normal;font-weight:400;line-height:1.42857143;text-align:left;text-align:start;text-decoration:none;text-shadow:none;text-transform:none;letter-spacing:normal;word-break:normal;word-spacing:normal;word-wrap:normal;white-space:normal;background-color:#fff;-webkit-background-clip:padding-box;background-clip:padding-box;border:1px solid #ccc;border:1px solid rgba(0,0,0,.2);border-radius:6px;-webkit-box-shadow:0 5px 10px rgba(0,0,0,.2);box-shadow:0 5px 10px rgba(0,0,0,.2);line-break:auto}.popover.top{margin-top:-10px}.popover.right{margin-left:10px}.popover.bottom{margin-top:10px}.popover.left{margin-left:-10px}.popover-title{padding:8px 14px;margin:0;font-size:14px;background-color:#f7f7f7;border-bottom:1px solid #ebebeb;border-radius:5px 5px 0 0}.popover-content{padding:9px 14px}.popover>.arrow,.popover>.arrow:after{position:absolute;display:block;width:0;height:0;border-color:transparent;border-style:solid}.popover>.arrow{border-width:11px}.popover>.arrow:after{content:"";border-width:10px}.popover.top>.arrow{bottom:-11px;left:50%;margin-left:-11px;border-top-color:#999;border-top-color:rgba(0,0,0,.25);border-bottom-width:0}.popover.top>.arrow:after{bottom:1px;margin-left:-10px;content:" ";border-top-color:#fff;border-bottom-width:0}.popover.right>.arrow{top:50%;left:-11px;margin-top:-11px;border-right-color:#999;border-right-color:rgba(0,0,0,.25);border-left-width:0}.popover.right>.arrow:after{bottom:-10px;left:1px;content:" ";border-right-color:#fff;border-left-width:0}.popover.bottom>.arrow{top:-11px;left:50%;margin-left:-11px;border-top-width:0;border-bottom-color:#999;border-bottom-color:rgba(0,0,0,.25)}.popover.bottom>.arrow:after{top:1px;margin-left:-10px;content:" ";border-top-width:0;border-bottom-color:#fff}.popover.left>.arrow{top:50%;right:-11px;margin-top:-11px;border-right-width:0;border-left-color:#999;border-left-color:rgba(0,0,0,.25)}.popover.left>.arrow:after{right:1px;bottom:-10px;content:" ";border-right-width:0;border-left-color:#fff}.carousel{position:relative}.carousel-inner{position:relative;width:100%;overflow:hidden}.carousel-inner>.item{position:relative;display:none;-webkit-transition:.6s ease-in-out left;-o-transition:.6s ease-in-out left;transition:.6s ease-in-out left}.carousel-inner>.item>a>img,.carousel-inner>.item>img{line-height:1}@media all and (transform-3d),(-webkit-transform-3d){.carousel-inner>.item{-webkit-transition:-webkit-transform .6s ease-in-out;-o-transition:-o-transform .6s ease-in-out;transition:transform .6s ease-in-out;-webkit-backface-visibility:hidden;backface-visibility:hidden;-webkit-perspective:1000px;perspective:1000px}.carousel-inner>.item.active.right,.carousel-inner>.item.next{left:0;-webkit-transform:translate3d(100%,0,0);transform:translate3d(100%,0,0)}.carousel-inner>.item.active.left,.carousel-inner>.item.prev{left:0;-webkit-transform:translate3d(-100%,0,0);transform:translate3d(-100%,0,0)}.carousel-inner>.item.active,.carousel-inner>.item.next.left,.carousel-inner>.item.prev.right{left:0;-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}}.carousel-inner>.active,.carousel-inner>.next,.carousel-inner>.prev{display:block}.carousel-inner>.active{left:0}.carousel-inner>.next,.carousel-inner>.prev{position:absolute;top:0;width:100%}.carousel-inner>.next{left:100%}.carousel-inner>.prev{left:-100%}.carousel-inner>.next.left,.carousel-inner>.prev.right{left:0}.carousel-inner>.active.left{left:-100%}.carousel-inner>.active.right{left:100%}.carousel-control{position:absolute;top:0;bottom:0;left:0;width:15%;font-size:20px;color:#fff;text-align:center;text-shadow:0 1px 2px rgba(0,0,0,.6);background-color:rgba(0,0,0,0);filter:alpha(opacity=50);opacity:.5}.carousel-control.left{background-image:-webkit-linear-gradient(left,rgba(0,0,0,.5) 0,rgba(0,0,0,.0001) 100%);background-image:-o-linear-gradient(left,rgba(0,0,0,.5) 0,rgba(0,0,0,.0001) 100%);background-image:-webkit-gradient(linear,left top,right top,from(rgba(0,0,0,.5)),to(rgba(0,0,0,.0001)));background-image:linear-gradient(to right,rgba(0,0,0,.5) 0,rgba(0,0,0,.0001) 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#80000000', endColorstr='#00000000', GradientType=1);background-repeat:repeat-x}.carousel-control.right{right:0;left:auto;background-image:-webkit-linear-gradient(left,rgba(0,0,0,.0001) 0,rgba(0,0,0,.5) 100%);background-image:-o-linear-gradient(left,rgba(0,0,0,.0001) 0,rgba(0,0,0,.5) 100%);background-image:-webkit-gradient(linear,left top,right top,from(rgba(0,0,0,.0001)),to(rgba(0,0,0,.5)));background-image:linear-gradient(to right,rgba(0,0,0,.0001) 0,rgba(0,0,0,.5) 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#00000000', endColorstr='#80000000', GradientType=1);background-repeat:repeat-x}.carousel-control:focus,.carousel-control:hover{color:#fff;text-decoration:none;filter:alpha(opacity=90);outline:0;opacity:.9}.carousel-control .glyphicon-chevron-left,.carousel-control .glyphicon-chevron-right,.carousel-control .icon-next,.carousel-control .icon-prev{position:absolute;top:50%;z-index:5;display:inline-block;margin-top:-10px}.carousel-control .glyphicon-chevron-left,.carousel-control .icon-prev{left:50%;margin-left:-10px}.carousel-control .glyphicon-chevron-right,.carousel-control .icon-next{right:50%;margin-right:-10px}.carousel-control .icon-next,.carousel-control .icon-prev{width:20px;height:20px;font-family:serif;line-height:1}.carousel-control .icon-prev:before{content:'\2039'}.carousel-control .icon-next:before{content:'\203a'}.carousel-indicators{position:absolute;bottom:10px;left:50%;z-index:15;width:60%;padding-left:0;margin-left:-30%;text-align:center;list-style:none}.carousel-indicators li{display:inline-block;width:10px;height:10px;margin:1px;text-indent:-999px;cursor:pointer;background-color:#000\9;background-color:rgba(0,0,0,0);border:1px solid #fff;border-radius:10px}.carousel-indicators .active{width:12px;height:12px;margin:0;background-color:#fff}.carousel-caption{position:absolute;right:15%;bottom:20px;left:15%;z-index:10;padding-top:20px;padding-bottom:20px;color:#fff;text-align:center;text-shadow:0 1px 2px rgba(0,0,0,.6)}.carousel-caption .btn{text-shadow:none}@media screen and (min-width:768px){.carousel-control .glyphicon-chevron-left,.carousel-control .glyphicon-chevron-right,.carousel-control .icon-next,.carousel-control .icon-prev{width:30px;height:30px;margin-top:-10px;font-size:30px}.carousel-control .glyphicon-chevron-left,.carousel-control .icon-prev{margin-left:-10px}.carousel-control .glyphicon-chevron-right,.carousel-control .icon-next{margin-right:-10px}.carousel-caption{right:20%;left:20%;padding-bottom:30px}.carousel-indicators{bottom:20px}}.btn-group-vertical>.btn-group:after,.btn-group-vertical>.btn-group:before,.btn-toolbar:after,.btn-toolbar:before,.clearfix:after,.clearfix:before,.container-fluid:after,.container-fluid:before,.container:after,.container:before,.dl-horizontal dd:after,.dl-horizontal dd:before,.form-horizontal .form-group:after,.form-horizontal .form-group:before,.modal-footer:after,.modal-footer:before,.modal-header:after,.modal-header:before,.nav:after,.nav:before,.navbar-collapse:after,.navbar-collapse:before,.navbar-header:after,.navbar-header:before,.navbar:after,.navbar:before,.pager:after,.pager:before,.panel-body:after,.panel-body:before,.row:after,.row:before{display:table;content:" "}.btn-group-vertical>.btn-group:after,.btn-toolbar:after,.clearfix:after,.container-fluid:after,.container:after,.dl-horizontal dd:after,.form-horizontal .form-group:after,.modal-footer:after,.modal-header:after,.nav:after,.navbar-collapse:after,.navbar-header:after,.navbar:after,.pager:after,.panel-body:after,.row:after{clear:both}.center-block{display:block;margin-right:auto;margin-left:auto}.pull-right{float:right!important}.pull-left{float:left!important}.hide{display:none!important}.show{display:block!important}.invisible{visibility:hidden}.text-hide{font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.hidden{display:none!important}.affix{position:fixed}@-ms-viewport{width:device-width}.visible-lg,.visible-md,.visible-sm,.visible-xs{display:none!important}.visible-lg-block,.visible-lg-inline,.visible-lg-inline-block,.visible-md-block,.visible-md-inline,.visible-md-inline-block,.visible-sm-block,.visible-sm-inline,.visible-sm-inline-block,.visible-xs-block,.visible-xs-inline,.visible-xs-inline-block{display:none!important}@media (max-width:767px){.visible-xs{display:block!important}table.visible-xs{display:table!important}tr.visible-xs{display:table-row!important}td.visible-xs,th.visible-xs{display:table-cell!important}}@media (max-width:767px){.visible-xs-block{display:block!important}}@media (max-width:767px){.visible-xs-inline{display:inline!important}}@media (max-width:767px){.visible-xs-inline-block{display:inline-block!important}}@media (min-width:768px) and (max-width:991px){.visible-sm{display:block!important}table.visible-sm{display:table!important}tr.visible-sm{display:table-row!important}td.visible-sm,th.visible-sm{display:table-cell!important}}@media (min-width:768px) and (max-width:991px){.visible-sm-block{display:block!important}}@media (min-width:768px) and (max-width:991px){.visible-sm-inline{display:inline!important}}@media (min-width:768px) and (max-width:991px){.visible-sm-inline-block{display:inline-block!important}}@media (min-width:992px) and (max-width:1199px){.visible-md{display:block!important}table.visible-md{display:table!important}tr.visible-md{display:table-row!important}td.visible-md,th.visible-md{display:table-cell!important}}@media (min-width:992px) and (max-width:1199px){.visible-md-block{display:block!important}}@media (min-width:992px) and (max-width:1199px){.visible-md-inline{display:inline!important}}@media (min-width:992px) and (max-width:1199px){.visible-md-inline-block{display:inline-block!important}}@media (min-width:1200px){.visible-lg{display:block!important}table.visible-lg{display:table!important}tr.visible-lg{display:table-row!important}td.visible-lg,th.visible-lg{display:table-cell!important}}@media (min-width:1200px){.visible-lg-block{display:block!important}}@media (min-width:1200px){.visible-lg-inline{display:inline!important}}@media (min-width:1200px){.visible-lg-inline-block{display:inline-block!important}}@media (max-width:767px){.hidden-xs{display:none!important}}@media (min-width:768px) and (max-width:991px){.hidden-sm{display:none!important}}@media (min-width:992px) and (max-width:1199px){.hidden-md{display:none!important}}@media (min-width:1200px){.hidden-lg{display:none!important}}.visible-print{display:none!important}@media print{.visible-print{display:block!important}table.visible-print{display:table!important}tr.visible-print{display:table-row!important}td.visible-print,th.visible-print{display:table-cell!important}}.visible-print-block{display:none!important}@media print{.visible-print-block{display:block!important}}.visible-print-inline{display:none!important}@media print{.visible-print-inline{display:inline!important}}.visible-print-inline-block{display:none!important}@media print{.visible-print-inline-block{display:inline-block!important}}@media print{.hidden-print{display:none!important}}
/*# sourceMappingURL=bootstrap.min.css.map */
@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900);
/*Theme Colors*/
/*bootstrap Color*/
/*Normal Color*/
/*Border radius*/
/*Preloader*/
.preloader {
  width: 100%;
  height: 100%;
  top: 0px;
  position: fixed;
  z-index: 99999;
  background: #fff;
}
.preloader .cssload-speeding-wheel {
  position: absolute;
  top: calc(50% - 3.5px);
  left: calc(50% - 3.5px);
}
/*Just change your choise color here its theme Colors*/
body {
  background: #fff;
}
.top-left-part {
  background: #fff;
}
.top-left-part .dark-logo {
  display: none;
}
.top-left-part .light-logo {
  display: inline-block;
}
/*Top Header Part*/
.logo i {
  color: #ffffff;
}
.navbar-header {
  background: #2f323e;
}
.navbar-top-links > li > a {
  color: #ffffff;
}
.sidebar .sidebar-head {
  background: #ffffff;
}
.sidebar .sidebar-head h3 {
  color: #686868;
}
/*Right panel*/
.right-sidebar .rpanel-title {
  background: #41b3f9;
}
/*Bread Crumb*/
.bg-title .breadcrumb .active {
  color: #41b3f9;
}
/*Sidebar*/
.sidebar {
  background: #fff;
  box-shadow: 1px 0px 20px rgba(0, 0, 0, 0.08);
}
.sidebar .label-custom {
  background: #01c0c8;
}
#side-menu li a {
  color: #54667a;
}
#side-menu li a {
  color: #54667a;
  border-left: 0px solid #fff;
}
#side-menu > li > a {
  border-left: 3px solid transperant;
}
#side-menu > li > a:hover,
#side-menu > li > a:focus {
  background: rgba(0, 0, 0, 0.07);
}
#side-menu > li > a.active {
  background: transperant;
  color: #54667a;
  border-left: 3px solid #41b3f9;
  font-weight: 500;
}
#side-menu ul > li > a:hover {
  color: #41b3f9;
}
#side-menu ul > li > a.active {
  color: #54667a;
  font-weight: 500;
}
.user-profile .user-pro-body .u-dropdown {
  color: #54667a;
}
/*themecolor*/
.bg-theme {
  background-color: #707cd2 !important;
}
.bg-theme-dark {
  background-color: #41b3f9 !important;
}
/*Button*/
.btn-custom {
  background: #41b3f9;
  border: 1px solid #41b3f9;
  color: #ffffff;
}
.btn-custom:hover {
  background: #41b3f9;
  opacity: 0.8;
  color: #ffffff;
  border: 1px solid #41b3f9;
}
/*Custom tab*/
.customtab li.active a,
.customtab li.active a:hover,
.customtab li.active a:focus {
  border-bottom: 2px solid #41b3f9;
  color: #41b3f9;
}
.tabs-vertical li.active a,
.tabs-vertical li.active a:hover,
.tabs-vertical li.active a:focus {
  background: #41b3f9;
  border-right: 2px solid #41b3f9;
}
/*Nav-pills*/
.nav-pills > li.active > a,
.nav-pills > li.active > a:focus,
.nav-pills > li.active > a:hover {
  background: #41b3f9;
  color: #ffffff;
}
/*Extra css*/
.bg-theme {
  background-color: #41b3f9 !important;
}
.panel-themecolor,
.panel-theme {
  border-color: #41b3f9;
}
.panel-themecolor .panel-heading,
.panel-theme .panel-heading {
  border-color: #41b3f9;
  color: white;
  background-color: #41b3f9;
}
.panel-themecolor .panel-heading a,
.panel-theme .panel-heading a {
  color: #ffffff;
}
.panel-themecolor .panel-heading a:hover,
.panel-theme .panel-heading a:hover {
  color: rgba(255, 255, 255, 0.5);
}
.panel-themecolor a,
.panel-theme a {
  color: #41b3f9;
}
.panel-themecolor a:hover,
.panel-theme a:hover {
  color: #0791e6;
}

@charset "UTF-8";
@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900);

.preloader {
  width: 100%;
  height: 100%;
  top: 0px;
  position: fixed;
  z-index: 99999;
  background: #fff;
}
.preloader .cssload-speeding-wheel {
  position: absolute;
  top: calc(50% - 3.5px);
  left: calc(50% - 3.5px);
}
* {
  outline: none !important;
}
body {
  font-family: 'Rubik', sans-serif;
  margin: 0;
  overflow-x: hidden;
  color: #313131;
  font-weight: 300;
}
html {
  position: relative;
  min-height: 100%;
  background: #ffffff;
}
h1,
h2,
h3,
h4,
h5,
h6 {
  color: #313131;
  font-family: 'Rubik', sans-serif;
  margin: 10px 0;
  font-weight: 300;
}
h1 {
  line-height: 48px;
  font-size: 36px;
}
h2 {
  line-height: 36px;
  font-size: 24px;
}
h3 {
  line-height: 30px;
  font-size: 21px;
}
h4 {
  line-height: 22px;
  font-size: 18px;
}
h5 {
  font-size: 18px;
  font-size: 16px;
}
h5 {
  font-size: 16px;
  font-size: 14px;
}
.dn {
  display: none;
}
.db {
  display: block;
}
.light_op_text {
  color: rgba(255, 255, 255, 0.5);
}
blockquote {
  border-left: 5px solid #2cabe3 !important;
  border: 1px solid rgba(120, 130, 140, 0.13);
}
p {
  line-height: 1.6;
}
b {
  font-weight: 500;
}
a:hover {
  outline: 0;
  text-decoration: none;
}
a:active {
  outline: 0;
  text-decoration: none;
}
a:focus {
  outline: 0;
  text-decoration: none;
}
.clear {
  clear: both;
}
.font-12 {
  font-size: 12px;
}
hr {
  border-color: rgba(120, 130, 140, 0.13);
}
.b-t {
  border-top: 1px solid rgba(120, 130, 140, 0.13);
}
.b-b {
  border-bottom: 1px solid rgba(120, 130, 140, 0.13);
}
.b-l {
  border-left: 1px solid rgba(120, 130, 140, 0.13);
}
.b-r {
  border-right: 1px solid rgba(120, 130, 140, 0.13);
}
.b-all {
  border: 1px solid rgba(120, 130, 140, 0.13);
}
.b-none {
  border: 0px!important;
}
.max-height {
  height: 310px;
  overflow: auto;
}
.p-0 {
  padding: 0px !important;
}
.p-10 {
  padding: 10px !important;
}
.p-20 {
  padding: 20px !important;
}
.p-30 {
  padding: 30px !important;
}
.p-l-0 {
  padding-left: 0px !important;
}
.p-l-10 {
  padding-left: 10px !important;
}
.p-l-20 {
  padding-left: 20px !important;
}
.p-l-30 {
  padding-left: 30px !important;
}
.p-r-0 {
  padding-right: 0px !important;
}
.p-r-10 {
  padding-right: 10px !important;
}
.p-r-20 {
  padding-right: 20px !important;
}
.p-r-30 {
  padding-right: 30px !important;
}
.p-r-40 {
  padding-right: 40px !important;
}
.p-t-0 {
  padding-top: 0px !important;
}
.p-t-10 {
  padding-top: 10px !important;
}
.p-t-20 {
  padding-top: 20px !important;
}
.p-t-30 {
  padding-top: 30px !important;
}
.p-b-0 {
  padding-bottom: 0px !important;
}
.p-b-10 {
  padding-bottom: 10px !important;
}
.p-b-20 {
  padding-bottom: 20px !important;
}
.p-b-30 {
  padding-bottom: 30px !important;
}
.p-b-40 {
  padding-bottom: 40px !important;
}
.m-0 {
  margin: 0px !important;
}
.m-l-5 {
  margin-left: 5px !important;
}
.m-l-10 {
  margin-left: 10px !important;
}
.m-l-15 {
  margin-left: 15px !important;
}
.m-l-20 {
  margin-left: 20px !important;
}
.m-l-30 {
  margin-left: 30px !important;
}
.m-l-40 {
  margin-left: 40px !important;
}
.m-r-5 {
  margin-right: 5px !important;
}
.m-r-10 {
  margin-right: 10px !important;
}
.m-r-15 {
  margin-right: 15px !important;
}
.m-r-20 {
  margin-right: 20px !important;
}
.m-r-30 {
  margin-right: 30px !important;
}
.m-r-40 {
  margin-right: 40px !important;
}
.m-t-5 {
  margin-top: 5px !important;
}
.m-t-0 {
  margin-top: 0px !important;
}
.m-t-10 {
  margin-top: 10px !important;
}
.m-t-15 {
  margin-top: 15px !important;
}
.m-t-20 {
  margin-top: 20px !important;
}
.m-t-30 {
  margin-top: 30px !important;
}
.m-t-40 {
  margin-top: 40px !important;
}
.m-b-0 {
  margin-bottom: 0px !important;
}
.m-b-5 {
  margin-bottom: 5px !important;
}
.m-b-10 {
  margin-bottom: 10px !important;
}
.m-b-15 {
  margin-bottom: 15px !important;
}
.m-b-20 {
  margin-bottom: 20px !important;
}
.m-b-30 {
  margin-bottom: 30px !important;
}
.m-b-40 {
  margin-bottom: 40px !important;
}
.vt {
  vertical-align: top;
}
.vb {
  vertical-align: bottom;
}
.font-bold {
  font-weight: 700;
}
.font-medium {
  font-weight: 500;
}
.font-normal {
  font-weight: normal;
}
.font-light {
  font-weight: 300;
}
.pull-in {
  margin-left: -15px;
  margin-right: -15px;
}
.b-0 {
  border: none !important;
}
.vertical-middle,
.vm {
  vertical-align: middle;
}
.mdi {
  font-size: 17px;
}
.bx-shadow {
  -moz-box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.1);
  -webkit-box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.1);
  box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.1);
}
.mx-box {
  max-height: 380px;
  min-height: 380px;
}
.thumb-sm {
  height: 32px;
  width: 32px;
}
.thumb-md {
  height: 48px;
  width: 48px;
}
.thumb-lg {
  height: 88px;
  width: 88px;
}
.txt-oflo {
  text-overflow: ellipsis;
  overflow: hidden;
  white-space: nowrap;
}
.di {
  display: inline-block;
}
.get-code {
  color: #263238;
  cursor: pointer;
  border-radius: 100%;
  background: #ffffff;
  padding: 4px 5px;
  font-size: 10px;
  margin: 0 5px;
  vertical-align: middle;
}
/* Badge */
.badge {
  text-transform: uppercase;
  font-weight: 600;
  padding: 3px 5px;
  font-size: 12px;
  margin-top: 1px;
  background-color: #ffbb44;
}
.badge-xs {
  font-size: 9px;
}
.badge-xs,
.badge-sm {
  -webkit-transform: translate(0, -2px);
  -ms-transform: translate(0, -2px);
  -o-transform: translate(0, -2px);
  transform: translate(0, -2px);
}
.badge-success {
  background-color: #7ace4c;
}
.badge-info {
  background-color: #41b3f9;
}
.badge-warning {
  background-color: #ffbb44;
}
.badge-danger {
  background-color: #f33155;
}
.badge-purple {
  background-color: #707cd2;
}
.badge-red {
  background-color: #f33155;
}
.badge-inverse {
  background-color: #4c5667;
}
/*notify*/
.notify {
  position: relative;
  margin-top: -30px;
}
.notify .heartbit {
  position: absolute;
  top: -20px;
  right: -16px;
  height: 25px;
  width: 25px;
  z-index: 10;
  border: 5px solid #f33155;
  border-radius: 70px;
  -moz-animation: heartbit 1s ease-out;
  -moz-animation-iteration-count: infinite;
  -o-animation: heartbit 1s ease-out;
  -o-animation-iteration-count: infinite;
  -webkit-animation: heartbit 1s ease-out;
  -webkit-animation-iteration-count: infinite;
  animation-iteration-count: infinite;
}
.notify .point {
  width: 6px;
  height: 6px;
  -webkit-border-radius: 30px;
  -moz-border-radius: 30px;
  border-radius: 30px;
  background-color: #f33155;
  position: absolute;
  right: -6px;
  top: -10px;
}
@-moz-keyframes heartbit {
  0% {
    -moz-transform: scale(0);
    opacity: 0.0;
  }
  25% {
    -moz-transform: scale(0.1);
    opacity: 0.1;
  }
  50% {
    -moz-transform: scale(0.5);
    opacity: 0.3;
  }
  75% {
    -moz-transform: scale(0.8);
    opacity: 0.5;
  }
  100% {
    -moz-transform: scale(1);
    opacity: 0.0;
  }
}
@-webkit-keyframes heartbit {
  0% {
    -webkit-transform: scale(0);
    opacity: 0.0;
  }
  25% {
    -webkit-transform: scale(0.1);
    opacity: 0.1;
  }
  50% {
    -webkit-transform: scale(0.5);
    opacity: 0.3;
  }
  75% {
    -webkit-transform: scale(0.8);
    opacity: 0.5;
  }
  100% {
    -webkit-transform: scale(1);
    opacity: 0.0;
  }
}
/* Text colors */
.text-white {
  color: #ffffff;
}
.text-danger {
  color: #f33155;
}
.text-muted {
  color: #8d9ea7;
}
.text-warning {
  color: #ffbb44;
}
.text-success {
  color: #7ace4c;
}
.text-info {
  color: #41b3f9;
}
.text-inverse {
  color: #4c5667;
}
.text-blue {
  color: #02bec9;
}
.text-purple {
  color: #707cd2;
}
.text-primary {
  color: #7460ee;
}
.text-megna {
  color: #01c0c8;
}
.text-dark {
  color: #313131 !important;
}
.fw-500 {
  font-weight: 500;
}
/* Background colors */
.bg-primary {
  background-color: #7460ee !important;
}
.bg-success {
  background-color: #7ace4c !important;
}
.bg-info {
  background-color: #41b3f9 !important;
}
.bg-warning {
  background-color: #ffbb44 !important;
}
.bg-danger {
  background-color: #f33155 !important;
}
.bg-theme-alt {
  background-color: #f33155 !important;
}
.bg-theme {
  background-color: #2cabe3 !important;
}
.bg-theme-dark {
  background-color: #4F5467 !important;
}
.bg-inverse {
  background-color: #4c5667 !important;
}
.bg-purple {
  background-color: #707cd2 !important;
}
.bg-white {
  background-color: #ffffff !important;
}
.bg-light {
  background-color: #e4e7ea !important;
}
.bg-extralight {
  background-color: #f7fafc !important;
}
/* Labels */
.label {
  letter-spacing: 0.05em;
  border-radius: 60px;
  padding: 4px 12px 3px;
  font-weight: 500;
}
.label-rounded,
.label-rouded {
  border-radius: 60px;
  padding: 4px 12px 3px;
  font-weight: 500;
}
.label-custom {
  background-color: #01c0c8;
}
.label-success {
  background-color: #7ace4c;
}
.label-info {
  background-color: #41b3f9;
}
.label-warning {
  background-color: #ffbb44;
}
.label-danger {
  background-color: #f33155;
}
.label-megna {
  background-color: #01c0c8;
}
.label-primary {
  background-color: #7460ee;
}
.label-purple {
  background-color: #707cd2;
}
.label-red {
  background-color: #f33155;
}
.label-inverse {
  background-color: #4c5667;
}
.label-white {
  background-color: #ffffff;
}
.label-default {
  background-color: #e4e7ea;
}
/*Bootstrap overight*/
.dropdown-menu {
  border: 1px solid rgba(120, 130, 140, 0.13);
  border-radius: 0px;
  box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05) !important;
  -webkit-box-shadow: 0px!important;
  -moz-box-shadow: 0px!important;
  padding-bottom: 8px;
  margin-top: 0px;
}
.dropdown-menu > li > a {
  padding: 9px 20px;
}
.dropdown-menu > li > a:focus,
.dropdown-menu > li > a:hover {
  background: #f7fafc;
}
.navbar-top-links .progress {
  margin-bottom: 6px;
}
label {
  font-weight: 500;
}
.btn {
  border-radius: 3px;
}
.form-control {
  background-color: #ffffff;
  border: 1px solid #e4e7ea;
  border-radius: 0px;
  box-shadow: 4px;
  color: #565656;
  height: 38px;
  max-width: 100%;
  padding: 7px 12px;
  transition: all 300ms linear 0s;
}
.form-control:focus {
  box-shadow: none;
  border-color: #263238;
}
.input-sm {
  height: 30px;
  padding: 5px 10px;
  font-size: 12px;
  line-height: 1.5;
}
.input-lg {
  height: 44px;
  padding: 5px 10px;
  font-size: 18px;
}
.bootstrap-tagsinput {
  border: 1px solid #e4e7ea;
  border-radius: 0px;
  box-shadow: none;
  display: block;
  padding: 7px 12px;
}
.bootstrap-touchspin .input-group-btn-vertical > .btn {
  padding: 9px 10px;
}
.bootstrap-touchspin .input-group-btn-vertical .bootstrap-touchspin-up,
.bootstrap-touchspin .input-group-btn-vertical .bootstrap-touchspin-down {
  border-radius: 0px;
}
.input-group-btn .btn {
  padding: 8px 12px;
}
.form-horizontal .form-group {
  margin-bottom: 25px;
}
.form-group {
  margin-bottom: 25px;
}
.select2-container-multi .select2-choices {
  border: 1px solid #e4e7ea;
}
.list-group-item,
.list-group-item:first-child,
.list-group-item:last-child {
  border-radius: 0px;
  border-color: rgba(120, 130, 140, 0.13);
}
.list-group-item.active,
.list-group-item.active:focus,
.list-group-item.active:hover {
  background: #41b3f9;
  border-color: #41b3f9;
}
.list-task .list-group-item,
.list-task .list-group-item:first-child {
  border-radius: 0px;
  border: 0px;
}
.list-task .list-group-item:last-child {
  border-radius: 0px;
  border: 0px;
}
.media {
  border: 1px solid rgba(120, 130, 140, 0.13);
  margin-bottom: 10px;
  padding: 15px;
}
.media .media-heading {
  font-weight: 500;
}
.well,
pre {
  background: #ffffff;
  border-radius: 0px;
}
.nav-tabs > li > a {
  border-radius: 0px;
  color: #263238;
}
.nav-tabs > li > a:hover,
.nav-tabs > li > a:focus {
  background: #ffffff;
}
.modal-content {
  border-radius: 0px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}
.alert {
  border-radius: 0px;
}
.carousel-control {
  width: 8%;
}
.carousel-control span {
  position: absolute;
  top: 50%;
  /* pushes the icon in the middle of the height */
  z-index: 5;
  display: inline-block;
  font-size: 30px;
}
.popover {
  border-radius: 0px;
  z-index: 100;
}
.popover-title {
  padding: 5px 14px;
}
.container-fluid {
  padding-left: 25px;
  padding-right: 25px;
  padding-bottom: 15px;
}
/*
.col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
  padding-left:7.5px;
  padding-right:7.5px;
}
.row {
    margin-right: -7.5px;
    margin-left: -7.5px;
}*/
.btn-group-vertical > .btn:first-child:not(:last-child),
.btn-group-vertical > .btn:last-child:not(:first-child) {
  border-radius: 0px;
}
.table-responsive {
  overflow-y: hidden;
}
/* Pagination/ Pager */
.pagination > li:first-child > a,
.pagination > li:first-child > span {
  border-bottom-left-radius: 0px;
  border-top-left-radius: 0px;
}
.pagination > li:last-child > a,
.pagination > li:last-child > span {
  border-bottom-right-radius: 0px;
  border-top-right-radius: 0px;
}
.pagination > li > a,
.pagination > li > span {
  color: #263238;
}
.pagination > li > a:hover,
.pagination > li > span:hover,
.pagination > li > a:focus,
.pagination > li > span:focus {
  background-color: #e4e7ea;
}
.pagination-split li {
  margin-left: 5px;
  display: inline-block;
  float: left;
}
.pagination-split li:first-child {
  margin-left: 0;
}
.pagination-split li a {
  -moz-border-radius: 0px;
  -webkit-border-radius: 0px;
  border-radius: 0px;
}
.pagination > .active > a,
.pagination > .active > span,
.pagination > .active > a:hover,
.pagination > .active > span:hover,
.pagination > .active > a:focus,
.pagination > .active > span:focus {
  background-color: #2cabe3;
  border-color: #2cabe3;
}
.pager li > a,
.pager li > span {
  -moz-border-radius: 0px;
  -webkit-border-radius: 0px;
  border-radius: 0px;
  color: #263238;
}
.table-box {
  display: table;
  width: 100%;
}
.cell {
  display: table-cell;
  vertical-align: middle;
}
.jqstooltip {
  width: auto !important;
  height: auto !important;
}
#wrapper {
  width: 100%;
}
#page-wrapper {
  padding: 0px;
  min-height: 568px;
  background: #edf1f5;
  padding-bottom: 60px;
}
.footer {
  bottom: 0;
  color: #58666e;
  left: 240px;
  padding: 20px 30px;
  position: absolute;
  right: 0;
  background: #ffffff;
}
.bg-title {
  background: #ffffff;
  overflow: hidden;
  padding: 15px 10px 9px;
  margin-bottom: 25px;
  margin-left: -25.5px;
  margin-right: -25.5px;
}
.bg-title h4 {
  text-transform: uppercase;
  font-size: 14px;
  font-weight: 500;
  margin-top: 6px;
}
.bg-title .breadcrumb {
  background: none;
  margin-bottom: 0px;
  float: right;
  padding: 0;
  margin-top: 8px;
}
.bg-title .breadcrumb a {
  color: rgba(0, 0, 0, 0.5);
}
.bg-title .breadcrumb a:hover {
  color: #000000;
}
.bg-title .breadcrumb .active {
  color: #2cabe3;
}
.logo b {
  /*background:@themecolor;*/
  height: 60px;
  float: left;
  padding-left: 10px;
  width: auto;
  line-height: 59px;
  text-align: center;
}
.logo i {
  color: #ffffff;
}
.top-left-part {
  width: 240px;
  float: left;
  border-right: 1px solid rgba(0, 0, 0, 0.08);
}
.top-left-part a {
  color: #ffffff;
  line-height: 59px;
  font-size: 18px;
  padding-left: 10px;
  text-transform: uppercase;
}
.top-left-part .light-logo {
  display: none;
}
.navbar-header {
  width: 100%;
  background: #3c4451;
  border: 0px;
}
.navbar-default {
  border: 0px;
}
.navbar-top-links {
  margin-right: 0;
}
.navbar-top-links .badge {
  position: absolute;
  right: 6px;
  top: 15px;
}
.navbar-top-links > li {
  float: left;
}
.navbar-top-links > li > a {
  color: #ffffff;
  padding: 0 14px;
  line-height: 60px;
  min-height: 60px;
}
.navbar-top-links > li > a:hover {
  background: rgba(0, 0, 0, 0.1);
}
.navbar-top-links > li > a:focus {
  background: rgba(0, 0, 0, 0);
}
.nav .open > a,
.nav .open > a:focus,
.nav .open > a:hover {
  background: rgba(255, 255, 255, 0.2);
}
.navbar-top-links .dropdown-menu li {
  display: block;
}
.navbar-top-links .dropdown-menu li:last-child {
  margin-right: 0;
}
.navbar-top-links .dropdown-menu li a div {
  white-space: normal;
}
.navbar-top-links .dropdown-messages,
.navbar-top-links .dropdown-tasks,
.navbar-top-links .dropdown-alerts {
  width: 310px;
  min-width: 0;
}
.navbar-top-links .dropdown-messages {
  margin-left: 5px;
}
.navbar-top-links .dropdown-tasks {
  margin-left: -59px;
}
.navbar-top-links .dropdown-alerts {
  margin-left: -123px;
}
.navbar-top-links .dropdown-user {
  right: 0;
  left: auto;
  width: 280px;
}
.navbar-top-links .dropdown-user .dw-user-box {
  padding: 15px;
}
.navbar-top-links .dropdown-user .dw-user-box .u-img {
  width: 80px;
  display: inline-block;
  vertical-align: top;
}
.navbar-top-links .dropdown-user .dw-user-box .u-img img {
  width: 100%;
  border-radius: 5px;
}
.navbar-top-links .dropdown-user .dw-user-box .u-text {
  display: inline-block;
  padding-left: 10px;
}
.navbar-top-links .dropdown-user .dw-user-box .u-text h4 {
  margin: 0px;
}
.navbar-top-links .dropdown-user .dw-user-box .u-text p {
  margin-bottom: 3px;
}
.navbar-header .navbar-toggle {
  float: none;
  padding: 0 15px;
  line-height: 60px;
  border: 0px;
  color: rgba(255, 255, 255, 0.5);
  margin: 0px;
  display: inline-block;
  border-radius: 0px;
}
.navbar-header .navbar-toggle:hover,
.navbar-header .navbar-toggle:focus {
  background: rgba(0, 0, 0, 0.3);
  color: #ffffff;
}
/*Search*/
.app-search {
  position: relative;
  margin: 0px;
}
.app-search a {
  position: absolute;
  top: 20px;
  right: 10px;
  color: #4c5667;
}
.app-search .form-control,
.app-search .form-control:focus {
  border: none;
  font-size: 13px;
  color: #4c5667;
  padding-left: 20px;
  padding-right: 40px;
  background: rgba(255, 255, 255, 0.9);
  box-shadow: none;
  height: 30px;
  font-weight: 600;
  width: 180px;
  display: inline-block;
  line-height: 30px;
  margin-top: 15px;
  border-radius: 40px;
  transition: 0.5s ease-out;
}
.app-search .form-control::-moz-placeholder {
  color: #4c5667;
  opacity: 0.5;
}
.app-search .form-control::-webkit-input-placeholder {
  color: #4c5667;
  opacity: 0.5;
}
.app-search .form-control::-ms-placeholder {
  color: #4c5667;
  opacity: 0.5;
}
.nav-small-cap {
  color: #a6afbb;
  cursor: default;
  font-weight: 500;
  text-transform: uppercase;
  font-size: 13px;
  letter-spacing: 0.035em;
  padding: 12px 15px !important;
  pointer-events: none;
  margin: 20px 0 0 -15px;
}
.profile-pic {
  padding: 0px 20px;
  line-height: 50px;
}
.profile-pic img {
  margin-right: 10px;
}
.drop-title {
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
  color: #263238;
  font-size: 15px;
  font-weight: 600;
  padding: 11px 20px 15px;
}
.btn-outline {
  color: inherit;
  background-color: transparent;
  transition: all .5s;
}
.btn-rounded {
  border-radius: 60px;
}
.btn-custom,
.btn-custom.disabled {
  background: #2cabe3;
  border: 1px solid #2cabe3;
  color: #ffffff;
}
.btn-custom:hover,
.btn-custom.disabled:hover,
.btn-custom:focus,
.btn-custom.disabled:focus,
.btn-custom.focus,
.btn-custom.disabled.focus {
  background: #2cabe3;
  opacity: 0.8;
  color: #ffffff;
  border: 1px solid #2cabe3;
}
.btn-primary,
.btn-primary.disabled {
  background: #7460ee;
  border: 1px solid #7460ee;
}
.btn-primary:hover,
.btn-primary.disabled:hover,
.btn-primary:focus,
.btn-primary.disabled:focus,
.btn-primary.focus,
.btn-primary.disabled.focus {
  background: #7460ee;
  opacity: 0.8;
  border: 1px solid #7460ee;
}
.btn-success,
.btn-success.disabled {
  background: #7ace4c;
  border: 1px solid #7ace4c;
}
.btn-success:hover,
.btn-success.disabled:hover,
.btn-success:focus,
.btn-success.disabled:focus,
.btn-success.focus,
.btn-success.disabled.focus {
  background: #7ace4c;
  opacity: 0.8;
  border: 1px solid #7ace4c;
}
.btn-info,
.btn-info.disabled {
  background: #41b3f9;
  border: 1px solid #41b3f9;
}
.btn-info:hover,
.btn-info.disabled:hover,
.btn-info:focus,
.btn-info.disabled:focus,
.btn-info.focus,
.btn-info.disabled.focus {
  background: #41b3f9;
  opacity: 0.8;
  border: 1px solid #41b3f9;
}
.btn-warning,
.btn-warning.disabled {
  background: #ffbb44;
  border: 1px solid #ffbb44;
}
.btn-warning:hover,
.btn-warning.disabled:hover,
.btn-warning:focus,
.btn-warning.disabled:focus,
.btn-warning.focus,
.btn-warning.disabled.focus {
  background: #ffbb44;
  opacity: 0.8;
  border: 1px solid #ffbb44;
}
.btn-danger,
.btn-danger.disabled {
  background: #f33155;
  border: 1px solid #f33155;
}
.btn-danger:hover,
.btn-danger.disabled:hover,
.btn-danger:focus,
.btn-danger.disabled:focus,
.btn-danger.focus,
.btn-danger.disabled.focus {
  background: #f33155;
  opacity: 0.8;
  border: 1px solid #f33155;
}
.btn-default,
.btn-default.disabled {
  background: #e4e7ea;
  border: 1px solid #e4e7ea;
}
.btn-default:hover,
.btn-default.disabled:hover,
.btn-default:focus,
.btn-default.disabled:focus,
.btn-default.focus,
.btn-default.disabled.focus {
  opacity: 0.8;
  border: 1px solid #e4e7ea;
  background: #e4e7ea;
}
.btn-default.btn-outline {
  background-color: #ffffff;
}
.btn-default.btn-outline:hover,
.btn-default.btn-outline:focus,
.btn-default.btn-outline.focus {
  background: #e4e7ea;
}
.btn-primary.btn-outline {
  color: #7460ee;
  background-color: #ffffff;
}
.btn-primary.btn-outline:hover,
.btn-primary.btn-outline:focus,
.btn-primary.btn-outline.focus {
  background: #7460ee;
  color: #ffffff;
}
.btn-success.btn-outline {
  color: #7ace4c;
  background-color: transparent;
}
.btn-success.btn-outline:hover,
.btn-success.btn-outline:focus,
.btn-success.btn-outline.focus {
  background: #7ace4c;
  color: #ffffff;
}
.btn-info.btn-outline {
  color: #41b3f9;
  background-color: transparent;
}
.btn-info.btn-outline:hover,
.btn-info.btn-outline:focus,
.btn-info.btn-outline.focus {
  background: #41b3f9;
  color: #ffffff;
}
.btn-warning.btn-outline {
  color: #ffbb44;
  background-color: transparent;
}
.btn-warning.btn-outline:hover,
.btn-warning.btn-outline:focus,
.btn-warning.btn-outline.focus {
  background: #ffbb44;
  color: #ffffff;
}
.btn-danger.btn-outline {
  color: #f33155;
  background-color: transparent;
}
.btn-danger.btn-outline:hover,
.btn-danger.btn-outline:focus,
.btn-danger.btn-outline.focus {
  background: #f33155;
  color: #ffffff;
}
.button-box .btn {
  margin: 0 8px 8px 0px;
}
.btn-primary.btn-outline:hover,
.btn-success.btn-outline:hover,
.btn-info.btn-outline:hover,
.btn-warning.btn-outline:hover,
.btn-danger.btn-outline:hover {
  color: white;
}
.btn-label {
  background: rgba(0, 0, 0, 0.05);
  display: inline-block;
  margin: -6px 12px -6px -14px;
  padding: 7px 15px;
}
.btn-facebook {
  color: #ffffff !important;
  background-color: #3b5998 !important;
}
.btn-twitter {
  color: #ffffff !important;
  background-color: #55acee !important;
}
.btn-linkedin {
  color: #ffffff !important;
  background-color: #007bb6 !important;
}
.btn-dribbble {
  color: #ffffff !important;
  background-color: #ea4c89 !important;
}
.btn-googleplus {
  color: #ffffff !important;
  background-color: #dd4b39 !important;
}
.btn-instagram {
  color: #ffffff !important;
  background-color: #3f729b !important;
}
.btn-pinterest {
  color: #ffffff !important;
  background-color: #cb2027 !important;
}
.btn-dropbox {
  color: #ffffff !important;
  background-color: #007ee5 !important;
}
.btn-flickr {
  color: #ffffff !important;
  background-color: #ff0084 !important;
}
.btn-tumblr {
  color: #ffffff !important;
  background-color: #32506d !important;
}
.btn-skype {
  color: #ffffff !important;
  background-color: #00aff0 !important;
}
.btn-youtube {
  color: #ffffff !important;
  background-color: #bb0000 !important;
}
.btn-github {
  color: #ffffff !important;
  background-color: #171515 !important;
}
.btn-primary.active.focus,
.btn-primary.active:focus,
.btn-primary.active:hover,
.btn-primary.focus:active,
.btn-primary:active:focus,
.btn-primary:active:hover,
.open > .dropdown-toggle.btn-primary.focus,
.open > .dropdown-toggle.btn-primary:focus,
.open > .dropdown-toggle.btn-primary:hover,
.btn-primary.focus,
.btn-primary:focus {
  background-color: #7460ee;
  border: 1px solid #7460ee;
}
.btn-success.active.focus,
.btn-success.active:focus,
.btn-success.active:hover,
.btn-success.focus:active,
.btn-success:active:focus,
.btn-success:active:hover,
.open > .dropdown-toggle.btn-success.focus,
.open > .dropdown-toggle.btn-success:focus,
.open > .dropdown-toggle.btn-success:hover,
.btn-success.focus,
.btn-success:focus {
  background-color: #7ace4c;
  border: 1px solid #7ace4c;
}
.btn-info.active.focus,
.btn-info.active:focus,
.btn-info.active:hover,
.btn-info.focus:active,
.btn-info:active:focus,
.btn-info:active:hover,
.open > .dropdown-toggle.btn-info.focus,
.open > .dropdown-toggle.btn-info:focus,
.open > .dropdown-toggle.btn-info:hover,
.btn-info.focus,
.btn-info:focus {
  background-color: #41b3f9;
  border: 1px solid #41b3f9;
}
.btn-warning.active.focus,
.btn-warning.active:focus,
.btn-warning.active:hover,
.btn-warning.focus:active,
.btn-warning:active:focus,
.btn-warning:active:hover,
.open > .dropdown-toggle.btn-warning.focus,
.open > .dropdown-toggle.btn-warning:focus,
.open > .dropdown-toggle.btn-warning:hover,
.btn-warning.focus,
.btn-warning:focus {
  background-color: #ffbb44;
  border: 1px solid #ffbb44;
}
.btn-danger.active.focus,
.btn-danger.active:focus,
.btn-danger.active:hover,
.btn-danger.focus:active,
.btn-danger:active:focus,
.btn-danger:active:hover,
.open > .dropdown-toggle.btn-danger.focus,
.open > .dropdown-toggle.btn-danger:focus,
.open > .dropdown-toggle.btn-danger:hover,
.btn-danger.focus,
.btn-danger:focus {
  background-color: #f33155;
  border: 1px solid #f33155;
}
.btn-inverse,
.btn-inverse:hover,
.btn-inverse:focus,
.btn-inverse:active,
.btn-inverse.active,
.btn-inverse.focus,
.btn-inverse:active,
.btn-inverse:focus,
.btn-inverse:hover,
.open > .dropdown-toggle.btn-inverse {
  background-color: #4c5667;
  border: 1px solid #4c5667;
  color: #ffffff;
}
.chat {
  margin: 0;
  padding: 0;
  list-style: none;
}
.chat li {
  margin-bottom: 10px;
  padding-bottom: 5px;
  border-bottom: 1px dotted rgba(120, 130, 140, 0.13);
}
.chat li.left .chat-body {
  margin-left: 60px;
}
.chat li.right .chat-body {
  margin-right: 60px;
}
.chat li .chat-body p {
  margin: 0;
}
.panel .slidedown .glyphicon,
.chat .glyphicon {
  margin-right: 5px;
}
.chat-panel .panel-body {
  height: 350px;
  overflow-y: scroll;
}
.login-panel {
  margin-top: 25%;
}
.flot-chart {
  display: block;
  height: 400px;
}
.flot-chart-content {
  width: 100%;
  height: 100%;
}
table.dataTable thead .sorting,
table.dataTable thead .sorting_asc,
table.dataTable thead .sorting_desc,
table.dataTable thead .sorting_asc_disabled,
table.dataTable thead .sorting_desc_disabled {
  background: transparent;
}
table.dataTable thead .sorting_asc:after {
  content: "\f0de";
  float: right;
  font-family: fontawesome;
}
table.dataTable thead .sorting_desc:after {
  content: "\f0dd";
  float: right;
  font-family: fontawesome;
}
table.dataTable thead .sorting:after {
  content: "\f0dc";
  float: right;
  font-family: fontawesome;
  color: rgba(50, 50, 50, 0.5);
}
.btn-circle {
  width: 30px;
  height: 30px;
  padding: 6px 0;
  border-radius: 15px;
  text-align: center;
  font-size: 12px;
  line-height: 1.428571429;
}
.btn-circle.btn-lg {
  width: 50px;
  height: 50px;
  padding: 10px 16px;
  border-radius: 25px;
  font-size: 18px;
  line-height: 1.33;
}
.btn-circle.btn-xl {
  width: 70px;
  height: 70px;
  padding: 10px 16px;
  border-radius: 35px;
  font-size: 24px;
  line-height: 1.33;
}
.show-grid [class^="col-"] {
  padding-top: 10px;
  padding-bottom: 10px;
  border: 1px solid rgba(120, 130, 140, 0.13);
  background-color: #f7fafc;
}
.show-grid {
  margin: 15px 0;
}
.huge {
  font-size: 40px;
}
.white-box {
  background: #ffffff;
  padding: 25px;
  margin-bottom: 30px;
}
.white-box .box-title {
  margin: 0px 0px 12px;
  font-weight: 500;
  text-transform: uppercase;
  font-size: 16px;
}
.panel {
  border-radius: 0px;
  margin-bottom: 30px;
  border: 0px;
  box-shadow: none;
}
.panel .panel-heading {
  border-radius: 0px;
  font-weight: 500;
  font-size: 16px;
  padding: 20px 25px;
}
.panel .panel-heading .panel-title {
  font-size: 16px;
  color: #263238;
}
.panel .panel-heading a i {
  font-size: 12px;
  margin-left: 8px;
}
.panel .panel-action {
  float: right;
}
.panel .panel-action a {
  opacity: 0.5;
}
.panel .panel-action a:hover {
  opacity: 1;
}
.panel .panel-body {
  padding: 25px;
}
.panel .panel-body:first-child h3 {
  margin-top: 0px;
  font-weight: 500;
  font-family: 'Rubik', sans-serif;
  font-size: 14px;
  text-transform: uppercase;
}
.panel .panel-footer {
  background: #ffffff;
  border-radius: 0px;
  padding: 20px 25px;
}
.panel-green,
.panel-success {
  border-color: #7ace4c;
}
.panel-green .panel-heading,
.panel-success .panel-heading {
  border-color: #7ace4c;
  color: white;
  background-color: #7ace4c;
}
.panel-green .panel-heading a,
.panel-success .panel-heading a {
  color: #ffffff;
}
.panel-green .panel-heading a:hover,
.panel-success .panel-heading a:hover {
  color: rgba(255, 255, 255, 0.5);
}
.panel-green a,
.panel-success a {
  color: #7ace4c;
}
.panel-green a:hover,
.panel-success a:hover {
  color: #56a12c;
}
.panel-black,
.panel-inverse {
  border-color: #4c5667;
}
.panel-black .panel-heading,
.panel-inverse .panel-heading {
  border-color: #4c5667;
  color: white;
  background-color: #4c5667;
}
.panel-black .panel-heading a,
.panel-inverse .panel-heading a {
  color: #ffffff;
}
.panel-black .panel-heading a:hover,
.panel-inverse .panel-heading a:hover {
  color: rgba(255, 255, 255, 0.5);
}
.panel-black a,
.panel-inverse a {
  color: #4c5667;
}
.panel-black a:hover,
.panel-inverse a:hover {
  color: #2c313b;
}
.panel-darkblue,
.panel-primary {
  border-color: #7460ee;
}
.panel-darkblue .panel-heading,
.panel-primary .panel-heading {
  border-color: #7460ee;
  color: white;
  background-color: #7460ee;
}
.panel-darkblue .panel-heading a,
.panel-primary .panel-heading a {
  color: #ffffff;
}
.panel-darkblue .panel-heading a:hover,
.panel-primary .panel-heading a:hover {
  color: rgba(255, 255, 255, 0.5);
}
.panel-darkblue a,
.panel-primary a {
  color: #7460ee;
}
.panel-darkblue a:hover,
.panel-primary a:hover {
  color: #381be7;
}
.panel-blue,
.panel-info {
  border-color: #41b3f9;
}
.panel-blue .panel-heading,
.panel-info .panel-heading {
  border-color: #41b3f9;
  color: white;
  background-color: #41b3f9;
}
.panel-blue .panel-heading a,
.panel-info .panel-heading a {
  color: #ffffff;
}
.panel-blue .panel-heading a:hover,
.panel-info .panel-heading a:hover {
  color: rgba(255, 255, 255, 0.5);
}
.panel-blue a,
.panel-info a {
  color: #41b3f9;
}
.panel-blue a:hover,
.panel-info a:hover {
  color: #0791e6;
}
.panel-red,
.panel-danger {
  border-color: #f33155;
}
.panel-red .panel-heading,
.panel-danger .panel-heading {
  border-color: #f33155;
  color: white;
  background-color: #f33155;
}
.panel-red .panel-heading a,
.panel-danger .panel-heading a {
  color: #ffffff;
}
.panel-red .panel-heading a:hover,
.panel-danger .panel-heading a:hover {
  color: rgba(255, 255, 255, 0.5);
}
.panel-red a,
.panel-danger a {
  color: #f33155;
}
.panel-red a:hover,
.panel-danger a:hover {
  color: #cc0c2f;
}
.panel-yellow,
.panel-warning {
  border-color: #ffbb44;
}
.panel-yellow .panel-heading,
.panel-warning .panel-heading {
  border-color: #ffbb44;
  color: white;
  background-color: #ffbb44;
}
.panel-yellow .panel-heading a,
.panel-warning .panel-heading a {
  color: #ffffff;
}
.panel-yellow .panel-heading a:hover,
.panel-warning .panel-heading a:hover {
  color: rgba(255, 255, 255, 0.5);
}
.panel-yellow a,
.panel-warning a {
  color: #ffbb44;
}
.panel-yellow a:hover,
.panel-warning a:hover {
  color: #f69d00;
}
.panel-themecolor,
.panel-theme {
  border-color: #2cabe3;
}
.panel-themecolor .panel-heading,
.panel-theme .panel-heading {
  border-color: #2cabe3;
  color: white;
  background-color: #2cabe3;
}
.panel-themecolor .panel-heading a,
.panel-theme .panel-heading a {
  color: #ffffff;
}
.panel-themecolor .panel-heading a:hover,
.panel-theme .panel-heading a:hover {
  color: rgba(255, 255, 255, 0.5);
}
.panel-themecolor a,
.panel-theme a {
  color: #2cabe3;
}
.panel-themecolor a:hover,
.panel-theme a:hover {
  color: #177eac;
}
.panel-white,
.panel-default {
  border-color: rgba(120, 130, 140, 0.13);
}
.panel-white .panel-heading,
.panel-default .panel-heading {
  color: #263238;
  background-color: #ffffff;
  border-bottom: 1px solid rgba(120, 130, 140, 0.13);
}
.panel-white .panel-body,
.panel-default .panel-body {
  color: #263238;
}
.panel-white .panel-action a,
.panel-default .panel-action a {
  color: #263238;
  opacity: 0.5;
}
.panel-white .panel-action a:hover,
.panel-default .panel-action a:hover {
  opacity: 1;
  color: #263238;
}
.panel-white .panel-footer,
.panel-default .panel-footer {
  background: #ffffff;
  color: #263238;
  border-top: 1px solid rgba(120, 130, 140, 0.13);
}
.full-panel-info {
  border-color: #41b3f9;
}
.full-panel-info .panel-heading {
  border-color: #41b3f9;
  color: white;
  background-color: #41b3f9;
  border-bottom: 1px solid rgba(120, 130, 140, 0.13);
}
.full-panel-info .panel-body {
  background: #41b3f9;
  color: #ffffff;
}
.full-panel-info .panel-footer {
  background: #41b3f9;
  color: #ffffff;
  border-top: 1px solid rgba(120, 130, 140, 0.13);
}
.full-panel-info a {
  color: #41b3f9;
}
.full-panel-info a:hover {
  color: #0791e6;
}
.full-panel-warning {
  border-color: #ffbb44;
}
.full-panel-warning .panel-heading {
  border-color: #ffbb44;
  color: white;
  background-color: #ffbb44;
  border-bottom: 1px solid rgba(120, 130, 140, 0.13);
}
.full-panel-warning .panel-body {
  background: #ffbb44;
  color: #ffffff;
}
.full-panel-warning .panel-footer {
  background: #ffbb44;
  color: #ffffff;
  border-top: 1px solid rgba(120, 130, 140, 0.13);
}
.full-panel-warning a {
  color: #ffbb44;
}
.full-panel-warning a:hover {
  color: #f69d00;
}
.full-panel-success {
  border-color: #7ace4c;
}
.full-panel-success .panel-heading {
  border-color: #7ace4c;
  color: white;
  background-color: #7ace4c;
  border-bottom: 1px solid rgba(120, 130, 140, 0.13);
}
.full-panel-success .panel-body {
  background: #7ace4c;
  color: #ffffff;
}
.full-panel-success .panel-footer {
  background: #7ace4c;
  color: #ffffff;
  border-top: 1px solid rgba(120, 130, 140, 0.13);
}
.full-panel-success a {
  color: #7ace4c;
}
.full-panel-success a:hover {
  color: #56a12c;
}
.full-panel-purple {
  border-color: #707cd2;
}
.full-panel-purple .panel-heading {
  color: white;
  background-color: #707cd2;
  border-bottom: 1px solid rgba(120, 130, 140, 0.13);
}
.full-panel-purple .panel-body {
  background: #707cd2;
  color: #ffffff;
}
.full-panel-purple .panel-footer {
  background: #707cd2;
  color: #ffffff;
  border-top: 1px solid rgba(120, 130, 140, 0.13);
}
.full-panel-purple a {
  color: #707cd2;
}
.full-panel-purple a:hover {
  color: #3b4abb;
}
.full-panel-danger {
  border-color: #f33155;
}
.full-panel-danger .panel-heading {
  border-color: #f33155;
  color: white;
  background-color: #f33155;
  border-bottom: 1px solid rgba(120, 130, 140, 0.13);
}
.full-panel-danger .panel-body {
  background: #f33155;
  color: #ffffff;
}
.full-panel-danger .panel-footer {
  background: #f33155;
  color: #ffffff;
  border-top: 1px solid rgba(120, 130, 140, 0.13);
}
.full-panel-danger a {
  color: #f33155;
}
.full-panel-danger a:hover {
  color: #cc0c2f;
}
.full-panel-inverse {
  border-color: #4c5667;
}
.full-panel-inverse .panel-heading {
  border-color: #4c5667;
  color: white;
  background-color: #4c5667;
  border-bottom: 1px solid rgba(120, 130, 140, 0.13);
}
.full-panel-inverse .panel-body {
  background: #4c5667;
  color: #ffffff;
}
.full-panel-inverse .panel-footer {
  background: #4c5667;
  color: #ffffff;
  border-top: 1px solid rgba(120, 130, 140, 0.13);
}
.full-panel-inverse a {
  color: #4c5667;
}
.full-panel-inverse a:hover {
  color: #2c313b;
}
.full-panel-default {
  border-color: rgba(120, 130, 140, 0.13);
}
.full-panel-default .panel-heading {
  color: #263238;
  background-color: #ffffff;
  border-bottom: 1px solid rgba(120, 130, 140, 0.13);
}
.full-panel-default .panel-body {
  color: #263238;
}
.full-panel-default .panel-footer {
  background: #ffffff;
  color: #263238;
  border-top: 1px solid rgba(120, 130, 140, 0.13);
}
.full-panel-default a {
  color: #263238;
}
.full-panel-default a:hover {
  color: #2c313b;
}
.panel-opcl {
  float: right;
}
.panel-opcl i {
  margin-left: 8px;
  font-size: 10px;
  cursor: pointer;
}
.fa-fw {
  width: 20px!important;
  display: inline-block !important;
  text-align: left !important;
}
/*Wave Effeects*/
.waves-effect {
  position: relative;
  cursor: pointer;
  display: inline-block;
  overflow: hidden;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  -webkit-tap-highlight-color: transparent;
}
.waves-effect .waves-ripple {
  position: absolute;
  border-radius: 50%;
  width: 20px;
  height: 20px;
  margin-top: -10px;
  margin-left: -10px;
  opacity: 0;
  background: rgba(0, 0, 0, 0.08);
  -webkit-transition: all 0.5s ease-out;
  -moz-transition: all 0.5s ease-out;
  -o-transition: all 0.5s ease-out;
  transition: all 0.5s ease-out;
  -webkit-transition-property: -webkit-transform, opacity;
  -moz-transition-property: -moz-transform, opacity;
  -o-transition-property: -o-transform, opacity;
  transition-property: transform, opacity;
  -webkit-transform: scale(0) translate(0, 0);
  -moz-transform: scale(0) translate(0, 0);
  -ms-transform: scale(0) translate(0, 0);
  -o-transform: scale(0) translate(0, 0);
  transform: scale(0) translate(0, 0);
  -webkit-transform: scale(0);
  -moz-transform: scale(0);
  -ms-transform: scale(0);
  -o-transform: scale(0);
  transform: scale(0);
  pointer-events: none;
}
.waves-effect.waves-light .waves-ripple {
  background: rgba(255, 255, 255, 0.4);
  background: -webkit-radial-gradient(rgba(255, 255, 255, 0.2) 0, rgba(255, 255, 255, 0.3) 40%, rgba(255, 255, 255, 0.4) 50%, rgba(255, 255, 255, 0.5) 60%, rgba(255, 255, 255, 0) 70%);
  background: -o-radial-gradient(rgba(255, 255, 255, 0.2) 0, rgba(255, 255, 255, 0.3) 40%, rgba(255, 255, 255, 0.4) 50%, rgba(255, 255, 255, 0.5) 60%, rgba(255, 255, 255, 0) 70%);
  background: -moz-radial-gradient(rgba(255, 255, 255, 0.2) 0, rgba(255, 255, 255, 0.3) 40%, rgba(255, 255, 255, 0.4) 50%, rgba(255, 255, 255, 0.5) 60%, rgba(255, 255, 255, 0) 70%);
  background: radial-gradient(rgba(255, 255, 255, 0.2) 0, rgba(255, 255, 255, 0.3) 40%, rgba(255, 255, 255, 0.4) 50%, rgba(255, 255, 255, 0.5) 60%, rgba(255, 255, 255, 0) 70%);
}
.waves-effect.waves-classic .waves-ripple {
  background: rgba(0, 0, 0, 0.2);
}
.waves-effect.waves-classic.waves-light .waves-ripple {
  background: rgba(255, 255, 255, 0.4);
}
.waves-notransition {
  -webkit-transition: none !important;
  -moz-transition: none !important;
  -o-transition: none !important;
  transition: none !important;
}
.waves-button,
.waves-circle {
  -webkit-transform: translateZ(0);
  -moz-transform: translateZ(0);
  -ms-transform: translateZ(0);
  -o-transform: translateZ(0);
  transform: translateZ(0);
  -webkit-mask-image: -webkit-radial-gradient(circle, white 100%, black 100%);
}
.waves-button,
.waves-button:hover,
.waves-button:visited,
.waves-button-input {
  white-space: nowrap;
  vertical-align: middle;
  cursor: pointer;
  border: none;
  outline: none;
  color: inherit;
  background-color: rgba(0, 0, 0, 0);
  font-size: 1em;
  line-height: 1em;
  text-align: center;
  text-decoration: none;
  z-index: 1;
}
.waves-button {
  padding: 0.85em 1.1em;
  border-radius: 0.2em;
}
.waves-button-input {
  margin: 0;
  padding: 0.85em 1.1em;
}
.waves-input-wrapper {
  border-radius: 0.2em;
  vertical-align: bottom;
}
.waves-input-wrapper.waves-button {
  padding: 0;
}
.waves-input-wrapper .waves-button-input {
  position: relative;
  top: 0;
  left: 0;
  z-index: 1;
}
.waves-circle {
  text-align: center;
  width: 2.5em;
  height: 2.5em;
  line-height: 2.5em;
  border-radius: 50%;
}
.waves-float {
  -webkit-mask-image: none;
  -webkit-box-shadow: 0px 1px 1.5px 1px rgba(0, 0, 0, 0.12);
  box-shadow: 0px 1px 1.5px 1px rgba(0, 0, 0, 0.12);
  -webkit-transition: all 300ms;
  -moz-transition: all 300ms;
  -o-transition: all 300ms;
  transition: all 300ms;
}
.waves-float:active {
  -webkit-box-shadow: 0px 8px 20px 1px rgba(0, 0, 0, 0.3);
  box-shadow: 0px 8px 20px 1px rgba(0, 0, 0, 0.3);
}
.waves-block {
  display: block;
}
/*common ul Listing*/
.common-list {
  margin: 0px;
  padding: 0px;
}
.common-list li {
  list-style: none;
  display: block;
}
.common-list li a {
  padding: 12px 0px;
  color: #313131;
  display: block;
}
.common-list li a:hover {
  color: #2cabe3;
}
/* =============
   Checkbox and Radios
============= */
.checkbox {
  padding-left: 20px;
}
.checkbox label {
  display: inline-block;
  padding-left: 5px;
  position: relative;
}
.checkbox label::before {
  -o-transition: 0.3s ease-in-out;
  -webkit-transition: 0.3s ease-in-out;
  background-color: #ffffff;
  border-radius: 1px;
  border: 1px solid rgba(120, 130, 140, 0.13);
  content: "";
  display: inline-block;
  height: 17px;
  left: 0;
  margin-left: -20px;
  position: absolute;
  transition: 0.3s ease-in-out;
  width: 17px;
  outline: none !important;
}
.checkbox label::after {
  color: #263238;
  display: inline-block;
  font-size: 11px;
  height: 16px;
  left: 0;
  margin-left: -20px;
  padding-left: 3px;
  padding-top: 1px;
  position: absolute;
  top: 0;
  width: 16px;
}
.checkbox input[type="checkbox"] {
  cursor: pointer;
  opacity: 0;
  z-index: 1;
  outline: none !important;
}
.checkbox input[type="checkbox"]:disabled + label {
  opacity: 0.65;
}
.checkbox input[type="checkbox"]:focus + label::before {
  outline-offset: -2px;
  outline: none;
  outline: thin dotted;
}
.checkbox input[type="checkbox"]:checked + label::after {
  content: "\f00c";
  font-family: 'FontAwesome';
}
.checkbox input[type="checkbox"]:disabled + label::before {
  background-color: #e4e7ea;
  cursor: not-allowed;
}
.checkbox.checkbox-circle label::before {
  border-radius: 50%;
}
.checkbox.checkbox-inline {
  margin-top: 0;
}
.checkbox.checkbox-single label {
  height: 17px;
}
.checkbox-primary input[type="checkbox"]:checked + label::before {
  background-color: #7460ee;
  border-color: #7460ee;
}
.checkbox-primary input[type="checkbox"]:checked + label::after {
  color: #ffffff;
}
.checkbox-danger input[type="checkbox"]:checked + label::before {
  background-color: #f33155;
  border-color: #f33155;
}
.checkbox-danger input[type="checkbox"]:checked + label::after {
  color: #ffffff;
}
.checkbox-info input[type="checkbox"]:checked + label::before {
  background-color: #41b3f9;
  border-color: #41b3f9;
}
.checkbox-info input[type="checkbox"]:checked + label::after {
  color: #ffffff;
}
.checkbox-warning input[type="checkbox"]:checked + label::before {
  background-color: #ffbb44;
  border-color: #ffbb44;
}
.checkbox-warning input[type="checkbox"]:checked + label::after {
  color: #ffffff;
}
.checkbox-success input[type="checkbox"]:checked + label::before {
  background-color: #7ace4c;
  border-color: #7ace4c;
}
.checkbox-success input[type="checkbox"]:checked + label::after {
  color: #ffffff;
}
.checkbox-purple input[type="checkbox"]:checked + label::before {
  background-color: #707cd2;
  border-color: #707cd2;
}
.checkbox-purple input[type="checkbox"]:checked + label::after {
  color: #ffffff;
}
.checkbox-red input[type="checkbox"]:checked + label::before {
  background-color: #f33155;
  border-color: #f33155;
}
.checkbox-red input[type="checkbox"]:checked + label::after {
  color: #ffffff;
}
.checkbox-inverse input[type="checkbox"]:checked + label::before {
  background-color: #4c5667;
  border-color: #4c5667;
}
.checkbox-inverse input[type="checkbox"]:checked + label::after {
  color: #ffffff;
}
/* Radios */
.radio {
  padding-left: 20px;
}
.radio label {
  display: inline-block;
  padding-left: 5px;
  position: relative;
}
.radio label::before {
  -o-transition: border 0.5s ease-in-out;
  -webkit-transition: border 0.5s ease-in-out;
  background-color: #ffffff;
  border-radius: 50%;
  border: 1px solid rgba(120, 130, 140, 0.13);
  content: "";
  display: inline-block;
  height: 17px;
  left: 0;
  margin-left: -20px;
  position: absolute;
  transition: border 0.5s ease-in-out;
  width: 17px;
  outline: none !important;
}
.radio label::after {
  -moz-transition: -moz-transform 0.3s cubic-bezier(0.8, -0.33, 0.2, 1.33);
  -ms-transform: scale(0, 0);
  -o-transform: scale(0, 0);
  -o-transition: -o-transform 0.3s cubic-bezier(0.8, -0.33, 0.2, 1.33);
  -webkit-transform: scale(0, 0);
  -webkit-transition: -webkit-transform 0.3s cubic-bezier(0.8, -0.33, 0.2, 1.33);
  background-color: #263238;
  border-radius: 50%;
  content: " ";
  display: inline-block;
  height: 7px;
  left: 5px;
  margin-left: -20px;
  position: absolute;
  top: 5px;
  transform: scale(0, 0);
  transition: transform 0.3s cubic-bezier(0.8, -0.33, 0.2, 1.33);
  width: 7px;
}
.radio input[type="radio"] {
  cursor: pointer;
  opacity: 0;
  z-index: 1;
  outline: none !important;
}
.radio input[type="radio"]:disabled + label {
  opacity: 0.65;
}
.radio input[type="radio"]:focus + label::before {
  outline-offset: -2px;
  outline: 5px auto -webkit-focus-ring-color;
  outline: thin dotted;
}
.radio input[type="radio"]:checked + label::after {
  -ms-transform: scale(1, 1);
  -o-transform: scale(1, 1);
  -webkit-transform: scale(1, 1);
  transform: scale(1, 1);
}
.radio input[type="radio"]:disabled + label::before {
  cursor: not-allowed;
}
.radio.radio-inline {
  margin-top: 0;
}
.radio.radio-single label {
  height: 17px;
}
.radio-primary input[type="radio"] + label::after {
  background-color: #7460ee;
}
.radio-primary input[type="radio"]:checked + label::before {
  border-color: #7460ee;
}
.radio-primary input[type="radio"]:checked + label::after {
  background-color: #7460ee;
}
.radio-danger input[type="radio"] + label::after {
  background-color: #f33155;
}
.radio-danger input[type="radio"]:checked + label::before {
  border-color: #f33155;
}
.radio-danger input[type="radio"]:checked + label::after {
  background-color: #f33155;
}
.radio-info input[type="radio"] + label::after {
  background-color: #41b3f9;
}
.radio-info input[type="radio"]:checked + label::before {
  border-color: #41b3f9;
}
.radio-info input[type="radio"]:checked + label::after {
  background-color: #41b3f9;
}
.radio-warning input[type="radio"] + label::after {
  background-color: #ffbb44;
}
.radio-warning input[type="radio"]:checked + label::before {
  border-color: #ffbb44;
}
.radio-warning input[type="radio"]:checked + label::after {
  background-color: #ffbb44;
}
.radio-success input[type="radio"] + label::after {
  background-color: #7ace4c;
}
.radio-success input[type="radio"]:checked + label::before {
  border-color: #7ace4c;
}
.radio-success input[type="radio"]:checked + label::after {
  background-color: #7ace4c;
}
.radio-purple input[type="radio"] + label::after {
  background-color: #707cd2;
}
.radio-purple input[type="radio"]:checked + label::before {
  border-color: #707cd2;
}
.radio-purple input[type="radio"]:checked + label::after {
  background-color: #707cd2;
}
.radio-red input[type="radio"] + label::after {
  background-color: #f33155;
}
.radio-red input[type="radio"]:checked + label::before {
  border-color: #f33155;
}
.radio-red input[type="radio"]:checked + label::after {
  background-color: #f33155;
}
/* File Upload */
.fileupload {
  overflow: hidden;
  position: relative;
}
.fileupload input.upload {
  cursor: pointer;
  filter: alpha(opacity=0);
  font-size: 20px;
  margin: 0;
  opacity: 0;
  padding: 0;
  position: absolute;
  right: 0;
  top: 0;
}
/** Models **/
.model_img {
  cursor: pointer;
}
/*Nestable*/
.myadmin-dd .dd-list .dd-item .dd-handle {
  background: #ffffff;
  border: 1px solid rgba(120, 130, 140, 0.13);
  padding: 8px 16px;
  height: auto;
  font-weight: 600;
  border-radius: 0px;
}
.myadmin-dd .dd-list .dd-item .dd-handle:hover {
  color: #41b3f9;
}
.myadmin-dd .dd-list .dd-item button {
  height: auto;
  font-size: 17px;
  margin: 8px auto;
  color: #263238;
  width: 30px;
}
.myadmin-dd-empty .dd-list .dd3-handle {
  border: 1px solid rgba(120, 130, 140, 0.13);
  border-bottom: 0px;
  background: #ffffff;
  height: 36px;
  width: 36px;
}
.myadmin-dd-empty .dd-list .dd3-handle:before {
  color: inherit;
  top: 7px;
}
.myadmin-dd-empty .dd-list .dd3-handle:hover {
  color: #41b3f9;
}
.myadmin-dd-empty .dd-list .dd3-content {
  height: auto;
  border: 1px solid rgba(120, 130, 140, 0.13);
  padding: 8px 16px 8px 46px;
  background: #ffffff;
  font-weight: 600;
}
.myadmin-dd-empty .dd-list .dd3-content:hover {
  color: #41b3f9;
}
.myadmin-dd-empty .dd-list button {
  width: 26px;
  height: 26px;
  font-size: 16px;
  font-weight: 600;
}
/*Setting box*/
.settings_box {
  position: absolute;
  top: 75px;
  right: 0px;
  z-index: 100;
}
.settings_box a {
  background: #ffffff;
  padding: 15px;
  display: inline-block;
  vertical-align: top;
}
.settings_box a i {
  display: block;
  -webkit-animation-name: rotate;
  -webkit-animation-duration: 2s;
  -moz-animation-name: rotate;
  -moz-animation-duration: 2s;
  -moz-animation-iteration-count: infinite;
  -moz-animation-timing-function: linear;
  animation-name: rotate;
  font-size: 16px;
  animation-duration: 1s;
  animation-iteration-count: infinite;
  animation-timing-function: linear;
}
@-webkit-keyframes rotate {
  from {
    -webkit-transform: rotate(0deg);
  }
  to {
    -webkit-transform: rotate(360deg);
  }
}
@-moz-keyframes rotate {
  from {
    -moz-transform: rotate(0deg);
  }
  to {
    -moz-transform: rotate(360deg);
  }
}
@keyframes rotate {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}
.theme_color {
  margin: 0px;
  padding: 0px;
  display: inline-block;
  overflow: hidden;
  width: 0px;
  transition: 0.5s ease-out;
  background: #ffffff;
}
.theme_color li {
  list-style: none;
  width: 30%;
  float: left;
  margin: 0 1.5%;
}
.theme_color li a {
  padding: 5px;
  height: 50px;
  display: block;
}
.theme_color li a.theme-green {
  background: #7ace4c;
}
.theme_color li a.theme-red {
  background: #f33155;
}
.theme_color li a.theme-dark {
  background: #4c5667;
}
.theme_block {
  width: 200px;
  padding: 30px;
}
/*Common Ul*/
ul.common li {
  display: inline-block;
  line-height: 40px;
  list-style: outside none none;
  width: 48%;
}
ul.common li a {
  color: #313131;
}
ul.common li a:hover {
  color: #41b3f9;
}
/*Circles*/
.circle {
  border-radius: 100%;
  text-align: center;
  color: #ffffff;
}
.circle-sm {
  width: 40px;
  padding-top: 12px;
  height: 40px;
  font-size: 14px!important;
}
.circle-md {
  width: 60px;
  padding-top: 15px;
  height: 60px;
  font-size: 24px!important;
}
.circle-lg {
  width: 80px;
  padding-top: 20px;
  height: 80px;
  font-size: 30px!important;
}
/*ROW -IN*/
.row-in i {
  font-size: 24px;
}
/********* Megamenu widgets**********/
.megamenu {
  left: 0px;
  right: 0px;
  width: 100%;
}
.mega-dropdown {
  position: static !important;
}
.mega-dropdown-menu {
  padding: 20px;
  width: 100%;
  padding-left: 80px;
  box-shadow: none;
  -webkit-box-shadow: none;
  border: 0px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
}
.mega-dropdown-menu > li > ul {
  padding: 0;
  margin: 0;
}
.mega-dropdown-menu > li > ul > li {
  list-style: none;
}
.mega-dropdown-menu > li > ul > li > a {
  display: block;
  padding: 8px 0px;
  clear: both;
  line-height: 1.428571429;
  color: #313131;
  white-space: normal;
}
.mega-dropdown-menu > li > ul > li > a:hover,
.mega-dropdown-menu > li > ul > li > a:focus {
  text-decoration: none;
  color: #2cabe3;
}
.mega-dropdown-menu .dropdown-header {
  font-size: 16px;
  font-weight: 500;
  padding: 8px 0;
  margin-top: 12px;
}
.mega-dropdown-menu li.demo-box a {
  color: #ffffff;
  display: block;
}
.mega-dropdown-menu li.demo-box a:hover {
  opacity: 0.8;
}
/*Inbox widgets*/
.mailbox {
  width: 280px;
  overflow: auto;
  padding-bottom: 0px;
}
.message-center a {
  border-bottom: 1px solid rgba(120, 130, 140, 0.13);
  display: block;
  padding: 9px 15px;
}
.message-center a:hover {
  background: #f7fafc;
}
.message-center .user-img {
  width: 40px;
  float: left;
  position: relative;
  margin: 0 10px 15px 0px;
}
.message-center .user-img img {
  width: 100%;
}
.message-center .user-img .profile-status {
  border: 2px solid #ffffff;
  border-radius: 50%;
  display: inline-block;
  height: 10px;
  left: 30px;
  position: absolute;
  top: 1px;
  width: 10px;
}
.message-center .user-img .online {
  background: #7ace4c;
}
.message-center .user-img .busy {
  background: #f33155;
}
.message-center .user-img .away {
  background: #ffbb44;
}
.message-center .user-img .offline {
  background: #ffbb44;
}
.message-center .mail-contnet h5 {
  margin: 0px;
  font-weight: 400;
  text-overflow: ellipsis;
  overflow: hidden;
  white-space: nowrap;
}
.message-center .mail-contnet .mail-desc {
  font-size: 12px;
  display: block;
  margin: 5px 0;
  text-overflow: ellipsis;
  overflow: hidden;
  white-space: nowrap;
  color: #263238;
}
.message-center .mail-contnet .time {
  display: block;
  font-size: 10px;
  color: #263238;
}
.mail-contnet a.action {
  margin-left: 10px;
  font-size: 12px;
  visibility: hidden;
}
.mail-contnet:hover a.action {
  visibility: visible;
}
/*Inbox Center*/
.inbox-center td {
  white-space: nowrap;
}
.inbox-center .unread td {
  font-weight: 400;
}
.inbox-center a {
  color: #313131;
  padding: 2px 0 3px 0;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  display: inline-block;
}
/*Comment center*/
.comment-center {
  margin: 0 -25px;
}
.comment-center .comment-body {
  border-bottom: 1px solid rgba(120, 130, 140, 0.13);
  display: table;
  width: 100%;
  padding: 20px 25px;
}
.comment-center .comment-body:hover {
  background: #f7fafc;
}
.comment-center .user-img {
  width: 40px;
  display: table-cell;
  position: relative;
  margin: 0 10px 0px 0px;
}
.comment-center .user-img img {
  width: 100%;
}
.comment-center .mail-contnet {
  display: table-cell;
  padding-left: 15px;
  vertical-align: top;
}
.comment-center .mail-contnet h5 {
  margin-top: 0px;
  font-weight: 400;
  text-overflow: ellipsis;
  overflow: hidden;
  white-space: nowrap;
}
.comment-center .mail-contnet .mail-desc {
  font-size: 14px;
  display: block;
  margin: 15px 0;
  line-height: 25px;
  color: #848a96;
  overflow: hidden;
  max-height: 52px;
  text-overflow: ellipsis;
}
.comment-center .mail-contnet .time {
  display: inline-block;
  font-size: 12px;
  color: #98a6ad;
}
/*Sales report*/
.sales-report {
  background: #f7fafc;
  margin: 12px -25px;
  padding: 15px;
}
/*Task*/
.dropdown-tasks,
.dropdown-alerts {
  padding: 0px;
}
.dropdown-tasks li a,
.dropdown-alerts li a,
.mailbox li > a {
  padding: 15px 20px;
}
.dropdown-tasks li.divider,
.dropdown-alerts li.divider {
  margin: 0px;
}
/*col-in*/
.row-in-br {
  border-right: 1px solid rgba(120, 130, 140, 0.13);
}
.col-in {
  list-style: none;
  padding: 0px;
  margin: 0px;
}
.col-in li {
  display: inline-block;
  vertical-align: middle;
  padding: 0 10px;
}
.col-in li .circle {
  display: inline-block;
}
.col-in li.col-middle {
  width: 40%;
}
.col-in li.col-last {
  float: right;
}
.col-in h3 {
  font-size: 36px;
  font-weight: 100;
}
/* Basic List */
.basic-list {
  padding: 0px;
}
.basic-list li {
  display: block;
  padding: 15px 0px;
  border-bottom: 1px solid rgba(120, 130, 140, 0.13);
  line-height: 27px;
}
.basic-list li:last-child {
  border-bottom: 0px;
}
/*Steam line widget*/
.steamline {
  position: relative;
  border-left: 1px solid rgba(120, 130, 140, 0.13);
  margin-left: 20px;
}
.steamline .sl-left {
  float: left;
  margin-left: -20px;
  z-index: 1;
  width: 40px;
  line-height: 40px;
  text-align: center;
  height: 40px;
  border-radius: 100%;
  color: #ffffff;
  background: #263238;
  margin-right: 15px;
}
.steamline .sl-left img {
  max-width: 40px;
}
.steamline .sl-right {
  padding-left: 50px;
}
.steamline .sl-right .desc,
.steamline .sl-right .inline-photos {
  margin-bottom: 30px;
}
.steamline .sl-right div > a {
  color: #263238;
  font-weight: 400;
}
.steamline .sl-item {
  border-bottom: 1px solid rgba(120, 130, 140, 0.13);
  margin: 20px 0;
}
.sl-date {
  font-size: 10px;
  color: #98a6ad;
}
.time-item {
  border-color: $border;
  padding-bottom: 1px;
  position: relative;
}
.time-item:before {
  content: " ";
  display: table;
}
.time-item:after {
  background-color: #ffffff;
  border-color: rgba(120, 130, 140, 0.13);
  border-radius: 10px;
  border-style: solid;
  border-width: 2px;
  bottom: 0;
  content: '';
  height: 14px;
  left: 0;
  margin-left: -8px;
  position: absolute;
  top: 5px;
  width: 14px;
}
.time-item-item:after {
  content: " ";
  display: table;
}
.item-info {
  margin-bottom: 15px;
  margin-left: 15px;
}
.item-info p {
  margin-bottom: 10px !important;
}
/*User-box*/
.user-bg {
  margin: -25px;
  height: 230px;
  overflow: hidden;
  position: relative;
}
.user-bg .overlay-box {
  background: #707cd2;
  opacity: 0.9;
  position: absolute;
  top: 0px;
  left: 0px;
  right: 0px;
  height: 100%;
  text-align: center;
}
.user-bg .overlay-box .user-content {
  padding: 15px;
  margin-top: 30px;
}
.user-btm-box {
  padding: 40px 0 10px;
  clear: both;
  overflow: hidden;
}
/* Vertical Carousel */
.vertical .carousel-inner {
  height: 100%;
  position: relative;
}
.carousel.vertical .item {
  -webkit-transition: 0.6s ease-in-out top;
  -moz-transition: 0.6s ease-in-out top;
  -ms-transition: 0.6s ease-in-out top;
  -o-transition: 0.6s ease-in-out top;
  transition: 0.6s ease-in-out top;
}
.carousel.vertical .active {
  top: 0;
}
.carousel.vertical .next {
  top: 400px;
}
.carousel.vertical .prev {
  top: -400px;
}
.carousel.vertical .next.left,
.carousel.vertical .prev.right {
  top: 0;
}
.carousel.vertical .active.left {
  top: -400px;
}
.carousel.vertical .active.right {
  top: 400px;
}
.carousel.vertical .item {
  left: 0;
}
.twi-user img {
  margin-right: 20px;
  width: 50px;
}
.twi-user {
  margin: 18px 0;
}
.carousel-inner h3 {
  /*height: 112px;*/
  overflow: hidden;
}
.carousel-inner > .item > img {
  width: 100%;
}
/*Chart Box*/
.chart-box {
  margin: 25px -15px -17px -17px;
}
/*Todo list*/
.list-task .task-done span {
  text-decoration: line-through;
}
/* Chat widget */
.chat-list {
  list-style: none;
  padding: 0px 20px;
}
.chat-list li {
  margin-bottom: 24px;
  overflow: auto;
}
.chat-list .chat-image {
  display: inline-block;
  float: left;
  text-align: center;
  width: 50px;
}
.chat-list .chat-image img {
  border-radius: 100%;
  width: 100%;
}
.chat-list .chat-text {
  background: #e5f7ff;
  border-radius: 0px 8px 8px 8px;
  display: inline-block;
  padding: 15px;
  font-size: 14px;
  position: relative;
}
.chat-list .chat-text h4 {
  color: #1a2942;
  display: block;
  font-size: 14px;
  font-style: normal;
  font-weight: 500;
  margin: 0;
  line-height: 15px;
  position: relative;
}
.chat-list .chat-text p {
  margin: 0px;
  padding-top: 3px;
}
.chat-list .chat-text b {
  font-size: 10px;
  opacity: 0.8;
}
.chat-list .chat-body {
  display: inline-block;
  float: left;
  font-size: 12px;
  margin-left: 12px;
  width: 65%;
}
.chat-list .odd .chat-image {
  float: right !important;
}
.chat-list .odd .chat-body {
  float: right !important;
  margin-right: 12px;
  text-align: right;
}
.chat-list .odd .chat-text {
  background: #f7f7f7;
  border-radius: 8px 0px 8px 8px;
}
.chat-send {
  padding-left: 0px;
  padding-right: 30px;
}
.chat-send button {
  width: 100%;
}
/*Weather*/
.weather-box .weather-top {
  overflow: hidden;
  padding: 10px 25px;
  margin: 0 -25px;
  background: #f7fafc;
}
.weather-box .weather-top h2 {
  line-height: 24px;
}
.weather-box .weather-top h2 small {
  font-size: 13px;
}
.weather-box .weather-top .today_crnt {
  font-size: 45px;
  font-weight: 100;
}
.weather-box .weather-top .today_crnt canvas {
  display: inline-block;
  margin-right: 10px;
  vertical-align: middle;
}
.weather-box .weather-info {
  padding: 10px 0;
}
.weather-box .weather-time {
  overflow: hidden;
  text-align: center;
  padding-top: 15px;
}
.weather-box .weather-time li span {
  display: block;
}
.weather-box .weather-time li canvas {
  font-size: 20px;
  margin: 10px 0;
}
.demo-container {
  width: 100%;
  height: 350px;
}
.demo-placeholder {
  width: 100%;
  height: 100%;
  font-size: 14px;
  line-height: 1.2em;
}
/*Notification alert*/
.myadmin-alert {
  border-radius: 0px;
  color: #fff;
  padding: 12px 30px 12px 12px;
  position: relative;
  text-align: left;
}
.myadmin-alert a {
  color: inherit;
  font-weight: 600;
  text-decoration: underline;
}
.myadmin-alert h4 {
  color: inherit;
  font-size: 14px;
  font-weight: 600;
  line-height: normal;
  margin: 0;
}
.myadmin-alert .img {
  border-radius: 3px;
  height: 40px;
  left: 12px;
  position: absolute;
  top: 12px;
  width: 40px;
}
.myadmin-alert-img {
  min-height: 64px;
  padding-left: 65px;
}
.myadmin-alert-icon {
  padding-left: 20px;
}
.myadmin-alert-icon i {
  padding-right: 10px;
}
.myadmin-alert .closed {
  color: rgba(255, 255, 255, 0.5);
  font-size: 20px;
  font-weight: 500;
  padding: 4px;
  position: absolute;
  right: 3px;
  text-decoration: none;
  top: 0;
}
.myadmin-alert .closed:hover {
  color: #fff;
}
.myadmin-alert-click {
  cursor: pointer;
  padding-right: 12px;
}
.myadmin-alert .primary {
  background: rgba(0, 0, 0, 0.4) none repeat scroll 0 0;
  border: medium none;
  border-radius: 3px;
  color: inherit;
  outline: 0 none;
  padding: 4px 10px;
}
.myadmin-alert .cancel {
  background: rgba(255, 255, 255, 0.4) none repeat scroll 0 0;
  border: medium none;
  border-radius: 3px;
  color: rgba(0, 0, 0, 0.8);
  outline: 0 none;
  padding: 4px 10px;
}
.myadmin-alert .primary:hover,
.myadmin-alert .cancel:hover {
  opacity: 0.9;
}
.myadmin-alert-top,
.myadmin-alert-bottom,
.myadmin-alert-top-left,
.myadmin-alert-top-right,
.myadmin-alert-bottom-left,
.myadmin-alert-bottom-right,
.myadmin-alert-fullscreen {
  box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.1);
  display: none;
  position: fixed;
  z-index: 1000;
}
.myadmin-alert-top {
  left: 0;
  right: 0;
  top: 0;
}
.myadmin-alert-bottom {
  bottom: 0;
  left: 0;
  right: 0;
}
.myadmin-alert-top-left {
  left: 20px;
  top: 80px;
}
.myadmin-alert-top-right {
  right: 20px;
  top: 80px;
}
.myadmin-alert-bottom-left {
  bottom: 20px;
  left: 20px;
}
.myadmin-alert-bottom-right {
  bottom: 20px;
  right: 20px;
}
.myadmin-alert-fullsize {
  left: 50%;
  margin: -20px;
  top: 50%;
}
.alert-custom {
  background: #2cabe3;
  color: #ffffff;
  border-color: #2cabe3;
}
.alert-inverse {
  background: #4c5667;
  color: #ffffff;
  border-color: #4c5667;
}
.alert-success {
  background: #7ace4c;
  color: #ffffff;
  border-color: #7ace4c;
}
.alert-dark {
  background: #313131;
  color: #ffffff;
  border-color: #313131;
}
.alert-warning {
  background: #ffbb44;
  color: #ffffff;
  border-color: #ffbb44;
}
.alert-danger {
  background: #f33155;
  color: #ffffff;
  border-color: #f33155;
}
.alert-primary {
  background: #707cd2;
  color: #ffffff;
  border-color: #707cd2;
}
.alert-info {
  background: #41b3f9;
  color: #ffffff;
  border-color: #41b3f9;
}
.alert-info .closed {
  color: inherit;
}
.alert-info a.closed:hover {
  color: inherit;
}
/*custom tab*/
.tab-content {
  margin-top: 30px;
}
.customtab {
  border-bottom: 2px solid #f7fafc;
}
.customtab li.active a,
.customtab li.active a:hover,
.customtab li.active a:focus {
  background: #ffffff;
  border: 0px;
  border-bottom: 2px solid #2cabe3;
  margin-bottom: -1px;
  color: #2cabe3;
}
.customtab li a,
.customtab li a:hover,
.customtab li a:focus {
  border: 0px;
}
/*custom tab2*/
.customtab2 {
  border-bottom: 1px solid #f7fafc;
  border-top: 1px solid #f7fafc;
  padding: 10px 0;
}
.customtab2 li.active a,
.customtab2 li.active a:hover,
.customtab2 li.active a:focus {
  background: #2cabe3;
  border: 1px solid #2cabe3;
  color: #ffffff;
}
.customtab2 li a,
.customtab2 li a:hover,
.customtab2 li a:focus {
  border: 0px;
}
/*Vertical tabs*/
.vtabs {
  display: table;
}
.vtabs .tabs-vertical {
  width: 150px;
  border-right: 1px solid rgba(120, 130, 140, 0.13);
  display: table-cell;
  vertical-align: top;
}
.vtabs .tabs-vertical li a {
  color: #263238;
  margin-bottom: 10px;
}
.vtabs .tab-content {
  display: table-cell;
  padding: 20px;
  vertical-align: top;
}
.tabs-vertical li.active a,
.tabs-vertical li.active a:hover,
.tabs-vertical li.active a:focus {
  background: #2cabe3;
  border: 0px;
  border-right: 2px solid #2cabe3;
  margin-right: -1px;
  color: #ffffff;
}
/*Custom vertical tab*/
.customvtab .tabs-vertical li.active a,
.customvtab .tabs-vertical li.active a:hover,
.customvtab .tabs-vertical li.active a:focus {
  background: #ffffff;
  border: 0px;
  border-right: 2px solid #2cabe3;
  margin-right: -1px;
  color: #263238;
}
/*Nav pills*/
.nav-pills > li.active > a,
.nav-pills > li.active > a:focus,
.nav-pills > li.active > a:hover {
  background: #2cabe3;
  color: #ffffff;
}
.nav-pills > li > a {
  color: #263238;
  border-radius: 0px;
}
/*Accordion*/
.panel-group .panel .panel-heading a[data-toggle=collapse].collapsed:before {
  content: '\e64b';
}
.panel-group .panel .panel-heading .accordion-toggle.collapsed:before {
  content: '\e64b';
}
.panel-group .panel .panel-heading a[data-toggle=collapse] {
  display: block;
}
.panel-group .panel .panel-heading a[data-toggle=collapse]:before {
  content: '\e648';
  display: block;
  float: right;
  font-family: 'themify';
  font-size: 14px;
  text-align: right;
  width: 25px;
}
.panel-group .panel .panel-heading .accordion-toggle {
  display: block;
}
.panel-group .panel .panel-heading .accordion-toggle:before {
  content: '\e648';
  display: block;
  float: right;
  font-family: 'themify';
  font-size: 14px;
  text-align: right;
  width: 25px;
}
.panel-group .panel .panel-heading + .panel-collapse .panel-body {
  border-top: none;
}
.panel-group .panel-heading {
  padding: 12px 20px;
}
/*Progressbars*/
.progress {
  -webkit-box-shadow: none !important;
  background-color: rgba(120, 130, 140, 0.13);
  box-shadow: none !important;
  height: 4px;
  border-radius: 0px;
  margin-bottom: 18px;
  overflow: hidden;
}
.progress-bar {
  box-shadow: none;
  font-size: 8px;
  font-weight: 600;
  line-height: 12px;
}
.progress.progress-sm {
  height: 8px !important;
}
.progress.progress-sm .progress-bar {
  font-size: 8px;
  line-height: 5px;
}
.progress.progress-md {
  height: 15px !important;
}
.progress.progress-md .progress-bar {
  font-size: 10.8px;
  line-height: 14.4px;
}
.progress.progress-lg {
  height: 20px !important;
}
.progress.progress-lg .progress-bar {
  font-size: 12px;
  line-height: 20px;
}
.progress-bar-primary {
  background-color: #7460ee;
}
.progress-bar-success {
  background-color: #7ace4c;
}
.progress-bar-info {
  background-color: #41b3f9;
}
.progress-bar-megna {
  background-color: #01c0c8;
}
.progress-bar-warning {
  background-color: #ffbb44;
}
.progress-bar-danger {
  background-color: #f33155;
}
.progress-bar-inverse {
  background-color: #4c5667;
}
.progress-bar-purple {
  background-color: #707cd2;
}
.progress-bar-custom {
  background-color: #41b3f9;
}
.progress-animated {
  -webkit-animation-duration: 5s;
  -webkit-animation-name: myanimation;
  -webkit-transition: 5s all;
  animation-duration: 5s;
  animation-name: myanimation;
  transition: 5s all;
}
/* Progressbar Animated */
@-webkit-keyframes myanimation {
  from {
    width: 0;
  }
}
@keyframes myanimation {
  from {
    width: 0;
  }
}
/* Progressbar Vertical */
.progress-vertical {
  min-height: 250px;
  height: 250px;
  width: 4px;
  position: relative;
  display: inline-block;
  margin-bottom: 0;
  margin-right: 20px;
}
.progress-vertical .progress-bar {
  width: 100%;
}
.progress-vertical-bottom {
  min-height: 250px;
  height: 250px;
  position: relative;
  width: 4px;
  display: inline-block;
  margin-bottom: 0;
  margin-right: 20px;
}
.progress-vertical-bottom .progress-bar {
  width: 100%;
  position: absolute;
  bottom: 0;
}
.progress-vertical.progress-sm,
.progress-vertical-bottom.progress-sm {
  width: 8px !important;
}
.progress-vertical.progress-sm .progress-bar,
.progress-vertical-bottom.progress-sm .progress-bar {
  font-size: 8px;
  line-height: 5px;
}
.progress-vertical.progress-md,
.progress-vertical-bottom.progress-md {
  width: 15px !important;
}
.progress-vertical.progress-md .progress-bar,
.progress-vertical-bottom.progress-md .progress-bar {
  font-size: 10.8px;
  line-height: 14.4px;
}
.progress-vertical.progress-lg,
.progress-vertical-bottom.progress-lg {
  width: 20px !important;
}
.progress-vertical.progress-lg .progress-bar,
.progress-vertical-bottom.progress-lg .progress-bar {
  font-size: 12px;
  line-height: 20px;
}
/*Timeline*/
.timeline {
  position: relative;
  padding: 20px 0 20px;
  list-style: none;
  max-width: 1200px;
  margin: 0 auto;
}
.timeline:before {
  content: " ";
  position: absolute;
  top: 0;
  bottom: 0;
  left: 50%;
  width: 3px;
  margin-left: -1.5px;
  background-color: #eeeeee;
}
.timeline > li {
  position: relative;
  margin-bottom: 20px;
}
.timeline > li:before,
.timeline > li:after {
  content: " ";
  display: table;
}
.timeline > li:after {
  clear: both;
}
.timeline > li:before,
.timeline > li:after {
  content: " ";
  display: table;
}
.timeline > li:after {
  clear: both;
}
.timeline > li > .timeline-panel {
  float: left;
  position: relative;
  width: 46%;
  padding: 20px;
  border: 1px solid rgba(120, 130, 140, 0.13);
  border-radius: 0px;
  -webkit-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.05);
  box-shadow: 0 1px 6px rgba(0, 0, 0, 0.05);
}
.timeline > li > .timeline-panel:before {
  content: " ";
  display: inline-block;
  position: absolute;
  top: 26px;
  right: -8px;
  border-top: 8px solid transparent;
  border-right: 0 solid rgba(120, 130, 140, 0.13);
  border-bottom: 8px solid transparent;
  border-left: 8px solid rgba(120, 130, 140, 0.13);
}
.timeline > li > .timeline-panel:after {
  content: " ";
  display: inline-block;
  position: absolute;
  top: 27px;
  right: -7px;
  border-top: 7px solid transparent;
  border-right: 0 solid #fff;
  border-bottom: 7px solid transparent;
  border-left: 7px solid #fff;
}
.timeline > li > .timeline-badge {
  z-index: 100;
  position: absolute;
  top: 16px;
  left: 50%;
  width: 50px;
  height: 50px;
  margin-left: -25px;
  border-radius: 50% 50% 50% 50%;
  text-align: center;
  font-size: 1.4em;
  line-height: 50px;
  color: #fff;
  overflow: hidden;
  background-color: #4c5667;
}
.timeline > li.timeline-inverted > .timeline-panel {
  float: right;
}
.timeline > li.timeline-inverted > .timeline-panel:before {
  right: auto;
  left: -8px;
  border-right-width: 8px;
  border-left-width: 0;
}
.timeline > li.timeline-inverted > .timeline-panel:after {
  right: auto;
  left: -7px;
  border-right-width: 7px;
  border-left-width: 0;
}
.timeline-badge.primary {
  background-color: #7460ee !important;
}
.timeline-badge.success {
  background-color: #7ace4c !important;
}
.timeline-badge.warning {
  background-color: #ffbb44 !important;
}
.timeline-badge.danger {
  background-color: #f33155 !important;
}
.timeline-badge.info {
  background-color: #41b3f9 !important;
}
.timeline-title {
  margin-top: 0;
  color: inherit;
  font-weight: 400;
}
.timeline-body > p,
.timeline-body > ul {
  margin-bottom: 0;
}
.timeline-body > p + p {
  margin-top: 5px;
}
/*Easy Pie charts*/
.chart {
  position: relative;
  display: inline-block;
  width: 100px;
  height: 100px;
  margin-top: 20px;
  margin-bottom: 20px;
  text-align: center;
}
.chart canvas {
  position: absolute;
  top: 0;
  left: 0;
}
.chart.chart-widget-pie {
  margin-top: 5px;
  margin-bottom: 5px;
}
.pie-chart > span {
  left: 0;
  margin-top: -2px;
  position: absolute;
  right: 0;
  text-align: center;
  top: 50%;
  transform: translateY(-50%);
}
.chart > span > img {
  left: 0;
  margin-top: -2px;
  position: absolute;
  right: 0;
  text-align: center;
  top: 50%;
  width: 60%;
  height: 60%;
  transform: translateY(-50%);
  margin: 0 auto;
}
.percent {
  display: inline-block;
  line-height: 100px;
  z-index: 2;
  font-weight: 600;
  font-size: 18px;
  color: #263238;
}
.percent:after {
  content: '%';
  margin-left: 0.1em;
  font-size: .8em;
}
/*Tables*/
.table {
  margin-bottom: 10px;
}
.table-striped > tbody > tr:nth-of-type(odd),
.table-hover > tbody > tr:hover,
.table > thead > tr > td.active,
.table > tbody > tr > td.active,
.table > tfoot > tr > td.active,
.table > thead > tr > th.active,
.table > tbody > tr > th.active,
.table > tfoot > tr > th.active,
.table > thead > tr.active > td,
.table > tbody > tr.active > td,
.table > tfoot > tr.active > td,
.table > thead > tr.active > th,
.table > tbody > tr.active > th,
.table > tfoot > tr.active > th {
  background-color: #f7fafc !important;
}
.table > thead > tr > th,
.table > tbody > tr > th,
.table > tfoot > tr > th,
.table > thead > tr > td,
.table > tbody > tr > td,
.table > tfoot > tr > td,
.table > thead > tr > th,
.table-bordered {
  border-top: 1px solid #e4e7ea;
}
.table > tbody > tr > td,
.table > tbody > tr > th,
.table > tfoot > tr > td,
.table > tfoot > tr > th,
.table > thead > tr > td,
.table > thead > tr > th {
  padding: 15px 8px;
}
.table-bordered > thead > tr > th,
.table-bordered > tbody > tr > th,
.table-bordered > tfoot > tr > th,
.table-bordered > thead > tr > td,
.table-bordered > tbody > tr > td,
.table-bordered > tfoot > tr > td {
  border: 1px solid #e4e7ea;
}
.table > thead > tr > th {
  vertical-align: bottom;
  border-bottom: 1px solid #e4e7ea;
}
tbody {
  color: #797979;
}
th {
  color: #666666;
  font-weight: 500;
}
.table-bordered {
  border: 1px solid #e4e7ea;
}
table.focus-on tbody tr.focused th {
  background-color: #2cabe3;
  color: #ffffff;
}
table.focus-on tbody tr.focused td {
  background-color: #2cabe3;
  color: #ffffff;
}
.table-rep-plugin .table-responsive {
  border: none !important;
}
.table-rep-plugin tbody th {
  font-size: 14px;
  font-weight: normal;
}
.jsgrid .jsgrid-table {
  margin-bottom: 0px;
}
.jsgrid-selected-row > td {
  background: #f7fafc;
  border-color: #f7fafc;
}
.jsgrid-header-row > th {
  background: #ffffff;
}
.footable-odd {
  background-color: #f7fafc;
}
/*Inputs*/
.form-control-line {
  border-left: 0 none;
  border-radius: 0;
  border-right: 0 none;
  border-top: 0 none;
  box-shadow: none;
  padding-left: 0;
}
.has-success .form-control {
  border-color: #7ace4c;
  box-shadow: none !important;
}
.has-warning .form-control {
  border-color: #ffbb44;
  box-shadow: none !important;
}
.has-error .form-control {
  border-color: #f33155;
  box-shadow: none !important;
}
.input-group-addon {
  border-radius: 2px;
  border: 1px solid rgba(120, 130, 140, 0.13);
}
.input-daterange input:first-child,
.input-daterange input:last-child {
  border-radius: 0px;
}
/*Material inputs*/
.form-material .form-group {
  overflow: hidden;
}
.form-material .form-control {
  background-color: rgba(0, 0, 0, 0);
  background-position: center bottom, center calc(99%);
  background-repeat: no-repeat;
  background-size: 0 2px, 100% 1px;
  padding: 0;
  transition: background 0s ease-out 0s;
}
.form-material .form-control,
.form-material .form-control.focus,
.form-material .form-control:focus {
  background-image: linear-gradient(#707cd2, #707cd2), linear-gradient(rgba(120, 130, 140, 0.13), rgba(120, 130, 140, 0.13));
  border: 0 none;
  border-radius: 0;
  box-shadow: none;
  float: none;
}
.form-material .form-control.focus,
.form-material .form-control:focus {
  background-size: 100% 2px, 100% 1px;
  outline: 0 none;
  transition-duration: 0.3s;
}
.form-bordered .form-group {
  border-bottom: 1px solid rgba(120, 130, 140, 0.13);
  padding-bottom: 20px;
}
/*Select 2*/
.select2-container .select2-choice {
  background-image: none !important;
  border: none !important;
  height: auto !important;
  padding: 0px !important;
  line-height: 22px !important;
  background-color: transparent !important;
  box-shadow: none !important;
}
.select2-container .select2-choice .select2-arrow {
  background-image: none !important;
  background: transparent;
  border: none;
  width: 14px;
  top: -2px;
}
.select2-container .select2-container-multi.form-control {
  height: auto;
}
.select2-results .select2-highlighted {
  color: #ffffff;
  background-color: #41b3f9;
}
.select2-drop-active {
  border: 1px solid #e3e3e3 !important;
  padding-top: 5px;
}
.select2-search input {
  border: 1px solid rgba(120, 130, 140, 0.13);
}
.select2-container-multi {
  width: 100%;
}
.select2-container-multi .select2-choices {
  border: 1px solid #border !important;
  box-shadow: none !important;
  background-image: none !important;
  border-radius: 0px !important;
  min-height: 38px;
}
.select2-container-multi .select2-choices .select2-search-choice {
  padding: 4px 7px 4px 18px;
  margin: 5px 0 3px 5px;
  color: #555555;
  background: #f5f5f5;
  border-color: rgba(120, 130, 140, 0.13);
  -webkit-box-shadow: none;
  box-shadow: none;
}
.select2-container-multi .select2-choices .select2-search-field input {
  padding: 7px 7px 7px 10px;
  font-family: inherit;
}
/*Icons*/
.icon-list-demo div {
  cursor: pointer;
  line-height: 60px;
  white-space: nowrap;
  color: #313131;
}
.icon-list-demo div:hover {
  color: #263238;
}
.icon-list-demo div p {
  margin: 10px 0;
  padding: 5px 0;
}
.icon-list-demo i {
  -webkit-transition: all 0.2s;
  -webkit-transition: font-size 0.2s;
  display: inline-block;
  font-size: 18px;
  margin: 0 15px 0 10px;
  text-align: left;
  transition: all 0.2s;
  transition: font-size 0.2s;
  vertical-align: middle;
  width: auto;
  transition: all 0.3s ease 0s;
}
.icon-list-demo .col-md-4 {
  border-radius: 0px;
}
.icon-list-demo .col-md-4:hover {
  background-color: #f7fafc;
}
.icon-list-demo .col-md-4:hover i {
  font-size: 2em;
}
/*Google map*/
.gmaps,
.gmaps-panaroma {
  height: 300px;
}
.gmaps,
.gmaps-panaroma {
  height: 300px;
  background: #e4e7ea;
  border-radius: 3px;
}
.gmaps-overlay {
  display: block;
  text-align: center;
  color: #ffffff;
  font-size: 16px;
  line-height: 40px;
  background: #7460ee;
  border-radius: 4px;
  padding: 10px 20px;
}
.gmaps-overlay_arrow {
  left: 50%;
  margin-left: -16px;
  width: 0;
  height: 0;
  position: absolute;
}
.gmaps-overlay_arrow.above {
  bottom: -15px;
  border-left: 16px solid transparent;
  border-right: 16px solid transparent;
  border-top: 16px solid #7460ee;
}
.gmaps-overlay_arrow.below {
  top: -15px;
  border-left: 16px solid transparent;
  border-right: 16px solid transparent;
  border-bottom: 16px solid #7460ee;
}
.jvectormap-zoomin,
.jvectormap-zoomout {
  width: 10px;
  height: 10px;
  line-height: 10px;
}
.jvectormap-zoomout {
  top: 40px;
}
/*Error Page*/
.error-box {
  height: 100%;
  position: fixed;
  top: 20%;
  width: 100%;
}
.error-box .footer {
  width: 100%;
  left: 0px;
  right: 0px;
}
.error-body {
  padding-top: 5%;
}
.error-body h1 {
  font-size: 210px;
  font-weight: 900;
  line-height: 210px;
}
/* Login- register pages */
.login-register {
  background: url(../plugins/images/login-register.jpg) no-repeat center center / cover !important;
  height: 100%;
  position: fixed;
}
.login-box {
  background: #ffffff;
  width: 400px;
  margin: 0 auto;
  margin-top: 10%;
}
.login-box .footer {
  width: 100%;
  left: 0px;
  right: 0px;
}
.login-box .social {
  display: block;
  margin-bottom: 30px;
}
#recoverform {
  display: none;
}
.new-login-register {
  position: fixed;
  height: 100%;
}
.new-login-register .lg-info-panel {
  background: url(../plugins/images/login-register.jpg) no-repeat center center / cover !important;
  width: 500px;
  height: 100%;
  position: fixed;
}
.new-login-register .lg-info-panel .inner-panel {
  position: absolute;
  height: 100%;
  width: 100%;
  background: rgba(0, 0, 0, 0.5);
}
.new-login-register .lg-info-panel .lg-content {
  margin-top: 50%;
  text-align: center;
  padding: 0 50px;
}
.new-login-register .lg-info-panel .lg-content h2 {
  color: #ffffff;
}
.new-login-register .lg-info-panel .lg-content p {
  padding: 20px 0;
  color: rgba(255, 255, 255, 0.7);
  font-style: italic;
}
.new-login-register .new-login-box {
  margin-left: 50%;
  margin-top: 10%;
  width: 400px;
}
.new-login-register .new-login-box .new-lg-form {
  padding-top: 20px;
}
.new-login-register .new-login-box .new-lg-form label {
  text-transform: uppercase;
  font-size: 12px;
}
.new-login-register .new-login-box .social {
  display: block;
  margin-bottom: 30px;
}
/*Pricing*/
.pricing-box {
  position: relative;
  text-align: center;
  margin-top: 30px;
}
.featured-plan {
  margin-top: 0px;
}
.featured-plan .pricing-body {
  padding: 60px 0;
  background: #f7fafc;
  border: 1px solid #ddd;
}
.featured-plan .price-table-content .price-row {
  border-top: 1px solid rgba(120, 130, 140, 0.13);
}
.pricing-body {
  border-radius: 0px;
  border-top: 1px solid rgba(120, 130, 140, 0.13);
  border-bottom: 5px solid rgba(120, 130, 140, 0.13);
  vertical-align: middle;
  padding: 30px 0;
  position: relative;
}
.pricing-body h2 {
  position: relative;
  font-size: 56px;
  margin: 20px 0 10px;
  font-weight: 500;
}
.pricing-body h2 span {
  position: absolute;
  font-size: 15px;
  top: -10px;
  margin-left: -10px;
}
.price-table-content .price-row {
  padding: 20px 0;
  border-top: 1px solid rgba(120, 130, 140, 0.13);
}
.pricing-plan {
  padding: 0 15px;
}
.pricing-plan .no-padding {
  padding: 0px;
}
.price-lable {
  position: absolute;
  top: -10px;
  padding: 5px 10px;
  margin: 0 auto;
  display: inline-block;
  width: 100px;
  left: 0px;
  right: 0px;
}
/*Inbox*/
.mails a {
  color: #263238;
}
.mails td {
  vertical-align: middle !important;
  position: relative;
}
.mails td:last-of-type {
  width: 100px;
  padding-right: 20px;
}
.mails tr:hover .text-white {
  display: none;
}
.mails .mail-select {
  padding: 12px 20px;
  min-width: 134px;
}
.mails .checkbox {
  margin-bottom: 0px;
  margin-top: 0px;
  vertical-align: middle;
  display: inline-block;
  height: 17px;
}
.mails .checkbox label {
  min-height: 16px;
}
.mail-list .list-group-item {
  background-color: transparent;
  border: 0px;
  border-left: 3px solid #ffffff;
  border-radius: 0px;
}
.mail-list .list-group-item:hover {
  background: #f7fafc;
  border-left: 3px solid #f7fafc;
}
.mail-list .list-group-item:focus {
  border-left: 3px solid #f7fafc;
}
.mail-list .list-group-item.active:focus {
  background: #f7fafc;
  border-left: 3px solid #f33155;
}
.mail-list .list-group-item.active {
  border-left: 3px solid #f33155;
  border-radius: 0px;
  color: #263238 !important;
}
.mail_listing {
  min-height: 500px;
}
.inbox_listing .inbox-item:hover {
  background: #f7fafc;
}
.inbox_listing .inbox-item {
  padding-left: 20px;
}
.inbox-widget.inbox_listing .inbox-item .inbox-item-text {
  height: 19px;
  overflow: hidden;
}
.message-center .unread .mail-contnet h5,
.message-center .unread .mail-contnet .mail-desc {
  font-weight: 600;
  color: #263238 !important;
}
/*Calendar*/
.calendar {
  float: left;
  margin-bottom: 0px;
}
.fc-view {
  margin-top: 30px;
}
.none-border .modal-footer {
  border-top: none;
}
.fc-toolbar {
  margin-bottom: 5px;
  margin-top: 15px;
}
.fc-toolbar h2 {
  font-size: 18px;
  font-weight: 600;
  line-height: 30px;
  text-transform: uppercase;
}
.fc-day {
  background: #ffffff;
}
.fc-toolbar .fc-state-active,
.fc-toolbar .ui-state-active,
.fc-toolbar button:focus,
.fc-toolbar button:hover,
.fc-toolbar .ui-state-hover {
  z-index: 0;
}
.fc-widget-header {
  border: 0px !important;
}
.fc-widget-content {
  border-color: rgba(120, 130, 140, 0.13) !important;
}
.fc th.fc-widget-header {
  color: #ffffff;
  font-size: 14px;
  line-height: 20px;
  padding: 7px 0px;
  text-transform: uppercase;
}
.fc th.fc-sun,
.fc th.fc-tue,
.fc th.fc-thu,
.fc th.fc-sat {
  background: #34b6ef;
}
.fc th.fc-mon,
.fc th.fc-wed,
.fc th.fc-fri {
  background: #3bbcf5;
}
.fc-view {
  margin-top: 0px;
}
.fc-toolbar {
  background: #41b3f9;
  margin: 0px;
  padding: 24px 20px;
}
.fc-toolbar h2 {
  color: #ffffff;
}
.fc-button {
  background: #3bbcf5;
  border: 1px solid #41b3f9;
  color: #fff;
  text-transform: capitalize;
}
.fc-button:hover {
  background: #3bbcf5;
  opacity: 0.8;
}
.fc-text-arrow {
  font-family: inherit;
  font-size: 16px;
}
.fc-state-hover {
  background: #F5F5F5;
}
.fc-unthemed .fc-today {
  border: 1px solid #f33155;
  background: #f7fafc !important;
}
.fc-state-highlight {
  background: #f0f0f0;
}
.fc-cell-overlay {
  background: #f0f0f0;
}
.fc-unthemed .fc-today {
  background: #ffffff;
}
.fc-event {
  border-radius: 0px;
  border: none;
  cursor: move;
  font-size: 13px;
  margin: 1px -1px 0 -1px;
  padding: 5px 5px;
  text-align: center;
  background: #41b3f9;
}
.calendar-event {
  cursor: move;
  margin: 10px 5px 0 0;
  padding: 6px 10px;
  display: inline-block;
  color: #ffffff;
  min-width: 140px;
  text-align: center;
  background: #41b3f9;
}
.calendar-event a {
  float: right;
  opacity: 0.6;
  font-size: 10px;
  margin: 4px 0 0 10px;
  color: #ffffff;
}
.fc-basic-view td.fc-week-number span {
  padding-right: 5px;
}
.fc-basic-view .fc-day-number {
  padding: 10px 15px;
  display: inline-block;
}
/*Weather small widget*/
.weather h1 {
  color: #ffffff;
  font-size: 50px;
  font-weight: 100;
}
.weather i {
  color: #ffffff;
  font-size: 40px;
}
.weather .w-title-sub {
  color: rgba(255, 255, 255, 0.6);
}
/*Right sidebar*/
@-webkit-keyframes rotate {
  from {
    -webkit-transform: rotate(0deg);
  }
  to {
    -webkit-transform: rotate(360deg);
  }
}
@-moz-keyframes rotate {
  from {
    -moz-transform: rotate(0deg);
  }
  to {
    -moz-transform: rotate(360deg);
  }
}
@keyframes rotate {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}
.right-side-toggle {
  position: relative;
}
.right-side-toggle i {
  -webkit-transition-property: -webkit-transform;
  -webkit-transition-duration: 1s;
  -moz-transition-property: -moz-transform;
  -moz-transition-duration: 1s;
  transition-property: transform;
  transition-duration: 1s;
  -webkit-animation-name: rotate;
  -webkit-animation-duration: 2s;
  -webkit-animation-iteration-count: infinite;
  -webkit-animation-timing-function: linear;
  -moz-animation-name: rotate;
  -moz-animation-duration: 2s;
  -moz-animation-iteration-count: infinite;
  -moz-animation-timing-function: linear;
  animation-name: rotate;
  animation-duration: 2s;
  animation-iteration-count: infinite;
  animation-timing-function: linear;
  position: absolute;
  top: 7px;
  left: 8px;
}
.right-sidebar {
  position: fixed;
  right: -240px;
  width: 240px;
  display: none;
  z-index: 1200;
  background: #ffffff;
  top: 0px;
  height: 100%;
  box-shadow: 5px 1px 40px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}
.right-sidebar .rpanel-title {
  display: block;
  padding: 21px;
  color: #fff;
  text-transform: uppercase;
  font-size: 13px;
  background: #2cabe3;
}
.right-sidebar .rpanel-title span {
  float: right;
  cursor: pointer;
  font-size: 11px;
}
.right-sidebar .rpanel-title span:hover {
  color: #263238;
}
.right-sidebar .r-panel-body {
  padding: 20px;
}
.right-sidebar .r-panel-body ul {
  margin: 0px;
  padding: 0px;
}
.right-sidebar .r-panel-body ul li {
  list-style: none;
  padding: 5px 0;
}
.shw-rside {
  right: 0px;
  width: 240px;
  display: block;
}
/*Chat online*/
.chatonline img {
  margin-right: 10px;
  float: left;
  width: 30px;
}
.chatonline li a {
  padding: 13px 0;
  float: left;
  width: 100%;
}
.chatonline li a span {
  color: #313131;
}
.chatonline li a span small {
  display: block;
  font-size: 10px;
}
/*Style switcher*/
ul#themecolors {
  display: block;
}
ul#themecolors li {
  display: inline-block;
}
ul#themecolors li:first-child {
  display: block;
}
#themecolors li a {
  width: 50px;
  height: 50px;
  display: inline-block;
  margin: 5px;
  color: transparent;
  position: relative;
}
#themecolors li a.working:before {
  content: "\f00c";
  font-family: "FontAwesome";
  font-size: 18px;
  line-height: 50px;
  width: 50px;
  height: 50px;
  position: absolute;
  top: 0;
  left: 0;
  color: #fff;
  text-align: center;
}
.default-theme {
  background: #4c5667;
}
.green-theme {
  background: #7ace4c;
}
.yellow-theme {
  background: #a0aec4;
}
.blue-theme {
  background: #41b3f9;
}
.purple-theme {
  background: #707cd2;
}
.megna-theme {
  background: #e4e7ea;
}
.default-dark-theme {
  background: #4f5467;
  /* Old browsers */
  background: -moz-linear-gradient(left, #4f5467 0%, #4f5467 23%, #f33155 23%, #f33155 99%);
  /* FF3.6-15 */
  background: -webkit-linear-gradient(left, #4f5467 0%, #4f5467 23%, #f33155 23%, #f33155 99%);
  /* Chrome10-25,Safari5.1-6 */
  background: linear-gradient(to right, #4f5467 0%, #4f5467 23%, #f33155 23%, #f33155 99%);
}
.green-dark-theme {
  background: #4f5467;
  /* Old browsers */
  background: -moz-linear-gradient(left, #4f5467 0%, #4f5467 23%, #00c292 23%, #00c292 99%);
  /* FF3.6-15 */
  background: -webkit-linear-gradient(left, #4f5467 0%, #4f5467 23%, #00c292 23%, #00c292 99%);
  /* Chrome10-25,Safari5.1-6 */
  background: linear-gradient(to right, #4f5467 0%, #4f5467 23%, #00c292 23%, #00c292 99%);
}
.yellow-dark-theme {
  background: #4f5467;
  /* Old browsers */
  background: -moz-linear-gradient(left, #4f5467 0%, #4f5467 23%, #a0aec4 23%, #a0aec4 99%);
  /* FF3.6-15 */
  background: -webkit-linear-gradient(left, #4f5467 0%, #4f5467 23%, #a0aec4 23%, #a0aec4 99%);
  /* Chrome10-25,Safari5.1-6 */
  background: linear-gradient(to right, #4f5467 0%, #4f5467 23%, #a0aec4 23%, #a0aec4 99%);
}
.blue-dark-theme {
  background: #4f5467;
  /* Old browsers */
  background: -moz-linear-gradient(left, #4f5467 0%, #4f5467 23%, #41b3f9 23%, #41b3f9 99%);
  /* FF3.6-15 */
  background: -webkit-linear-gradient(left, #4f5467 0%, #4f5467 23%, #41b3f9 23%, #41b3f9 99%);
  /* Chrome10-25,Safari5.1-6 */
  background: linear-gradient(to right, #4f5467 0%, #4f5467 23%, #41b3f9 23%, #41b3f9 99%);
}
.purple-dark-theme {
  background: #4f5467;
  /* Old browsers */
  background: -moz-linear-gradient(left, #4f5467 0%, #4f5467 23%, #707cd2 23%, #707cd2 99%);
  /* FF3.6-15 */
  background: -webkit-linear-gradient(left, #4f5467 0%, #4f5467 23%, #707cd2 23%, #707cd2 99%);
  /* Chrome10-25,Safari5.1-6 */
  background: linear-gradient(to right, #4f5467 0%, #4f5467 23%, #707cd2 23%, #707cd2 99%);
}
.megna-dark-theme {
  background: #4f5467;
  /* Old browsers */
  background: -moz-linear-gradient(left, #4f5467 0%, #4f5467 23%, #e4e7ea 23%, #e4e7ea 99%);
  /* FF3.6-15 */
  background: -webkit-linear-gradient(left, #4f5467 0%, #4f5467 23%, #e4e7ea 23%, #e4e7ea 99%);
  /* Chrome10-25,Safari5.1-6 */
  background: linear-gradient(to right, #4f5467 0%, #4f5467 23%, #e4e7ea 23%, #e4e7ea 99%);
}
.red-dark-theme {
  background: #e20b0b;
  /* Old browsers */
  background: -moz-linear-gradient(left, #4f5467 0%, #4f5467 23%, #e20b0b 23%, #e20b0b 99%);
  /* FF3.6-15 */
  background: -webkit-linear-gradient(left, #4f5467 0%, #4f5467 23%, #e20b0b 23%, #e20b0b 99%);
  /* Chrome10-25,Safari5.1-6 */
  background: linear-gradient(to right, #4f5467 0%, #4f5467 23%, #e20b0b 23%, #e20b0b 99%);
}
/*visited ul li*/
.visited li a {
  color: #313131;
}
.visited li.active a {
  color: #2cabe3;
}
/*Stats Row*/
.stats-row {
  margin-bottom: 20px;
}
.stat-item {
  display: inline-block;
  padding-right: 15px;
}
.stat-item + .stat-item {
  padding-left: 15px;
  border-left: 1px solid #eee;
}
/*country-state*/
.country-state {
  list-style: none;
  margin: 0px;
  padding: 0px 0 0 10px;
}
.country-state h2 {
  margin: 0px;
}
.country-state .progress {
  margin-top: 8px;
}
/*Two part*/
.two-part li {
  width: 48.8%;
}
.two-part li i {
  font-size: 50px;
}
.two-part li span {
  font-size: 50px;
  font-weight: 100;
  font-family: 'Rubik', sans-serif;
}
/*News Slides*/
.news-slide {
  position: relative;
}
.news-slide .overlaybg {
  height: 370px;
  overflow: hidden;
}
.news-slide .overlaybg img {
  width: 100%;
  height: 100%;
}
.news-slide .news-content {
  position: absolute;
  height: 370px;
  background: rgba(0, 0, 0, 0.5);
  z-index: 10;
  width: 100%;
  top: 0px;
  padding: 30px;
}
.news-slide .news-content h2 {
  height: 240px;
  overflow: hidden;
  color: #ffffff;
}
.news-slide .news-content a {
  color: #ffffff;
  opacity: 0.6;
  text-transform: uppercase;
}
.news-slide .news-content a:hover {
  opacity: 1;
}
.dashboard-slide .overlaybg {
  height: 435px;
}
.dashboard-slide .news-content {
  height: 435px;
}
.dashboard-slide .news-content h2 {
  height: 320px;
}
/*Nav pill rounded*/
.nav-pills-rounded li {
  display: inline-block;
  float: none;
}
.nav-pills-rounded li a {
  border-radius: 60px;
  -moz-border-radius: 60px;
  -webkit-border-radius: 60px;
  color: #313131;
  padding: 10px 25px;
}
.nav-pills-rounded li.active a,
.nav-pills-rounded li.active a:focus,
.nav-pills-rounded li.active a:hover {
  background: #2cabe3;
  color: #ffffff;
}
/*analytics-info*/
.analytics-info .list-inline {
  margin-bottom: 0px;
}
.analytics-info .list-inline li {
  vertical-align: middle;
}
.analytics-info .list-inline li span {
  font-size: 24px;
}
.analytics-info .list-inline li i {
  font-size: 20px;
}
/*Feeds*/
.feeds {
  margin: 0px;
  padding: 0px;
}
.feeds li {
  list-style: none;
  padding: 10px;
  display: block;
}
.feeds li:hover {
  background: #f7fafc;
}
.feeds li > div {
  width: 40px;
  height: 40px;
  margin-right: 5px;
  display: inline-block;
  text-align: center;
  vertical-align: middle;
  border-radius: 100%;
}
.feeds li > div i {
  line-height: 40px;
}
.feeds li span {
  float: right;
  width: auto;
  font-size: 12px;
}
/*Jquery toaster*/
.jq-icon-info {
  background-color: #41b3f9;
  color: #ffffff;
}
.jq-icon-success {
  background-color: #7ace4c;
  color: #ffffff;
}
.jq-icon-error {
  background-color: #f33155;
  color: #ffffff;
}
.jq-icon-warning {
  background-color: #ffbb44;
  color: #ffffff;
}
/*Dropzone*/
.dropzone {
  border-style: dashed;
  border-width: 1px;
}
/*sales boxes*/
.weather h1 sup {
  font-size: 20px;
  top: -1.2em;
}
/* Button 1c */
.fcbtn {
  position: relative;
  -webkit-transition: all 0.3s;
  -moz-transition: all 0.3s;
  transition: all 0.3s;
  padding: 8px 20px;
}
.fcbtn:after {
  content: '';
  position: absolute;
  z-index: -1;
  -webkit-transition: all 0.3s;
  -moz-transition: all 0.3s;
  transition: all 0.3s;
}
/* Button 1b */
.btn-1b:after {
  width: 100%;
  height: 0;
  top: 0;
  left: 0;
}
.btn-1b:hover,
.btn-1b:active {
  color: #fff;
}
.btn-1b:hover:after,
.btn-1b:active:after {
  height: 100%;
}
.btn-1b.btn-info:after,
.btn-1c.btn-info:after,
.btn-1d.btn-info:after,
.btn-1e.btn-info:after,
.btn-1f.btn-info:after {
  background: #41b3f9;
}
.btn-1b.btn-warning:after,
.btn-1c.btn-warning:after,
.btn-1d.btn-warning:after,
.btn-1e.btn-warning:after,
.btn-1f.btn-warning:after {
  background: #ffbb44;
}
.btn-1b.btn-danger:after,
.btn-1c.btn-danger:after,
.btn-1d.btn-danger:after,
.btn-1e.btn-danger:after,
.btn-1f.btn-danger:after {
  background: #f33155;
}
.btn-1b.btn-primary:after,
.btn-1c.btn-primary:after,
.btn-1d.btn-primary:after,
.btn-1e.btn-primary:after,
.btn-1f.btn-primary:after {
  background: #707cd2;
}
.btn-1b.btn-success:after,
.btn-1c.btn-success:after,
.btn-1d.btn-success:after,
.btn-1e.btn-success:after,
.btn-1f.btn-success:after {
  background: #7ace4c;
}
.btn-1b.btn-inverse:after,
.btn-1c.btn-inverse:after,
.btn-1d.btn-inverse:after,
.btn-1e.btn-inverse:after,
.btn-1f.btn-inverse:after {
  background: #4c5667;
}
/* Button 1c */
.btn-1c:after {
  width: 0%;
  height: 100%;
  top: 0;
  left: 0;
}
.btn-1c:hover,
.btn-1c:active {
  color: #000;
}
.btn-1c:hover:after,
.btn-1c:active:after {
  width: 100%;
}
/* Button 1d */
.btn-1d {
  overflow: hidden;
}
.btn-1d:after {
  width: 0;
  height: 103%;
  top: 50%;
  left: 50%;
  opacity: 0;
  -webkit-transform: translateX(-50%) translateY(-50%);
  -moz-transform: translateX(-50%) translateY(-50%);
  -ms-transform: translateX(-50%) translateY(-50%);
  transform: translateX(-50%) translateY(-50%);
}
.btn-1d:hover:after {
  width: 100%;
  opacity: 1;
}
/* Button 1e */
.btn-1e {
  overflow: hidden;
}
.btn-1e:after {
  width: 100%;
  height: 0;
  top: 50%;
  left: 50%;
  background: #fff;
  opacity: 0;
  -webkit-transform: translateX(-50%) translateY(-50%) rotate(45deg);
  -moz-transform: translateX(-50%) translateY(-50%) rotate(45deg);
  -ms-transform: translateX(-50%) translateY(-50%) rotate(45deg);
  transform: translateX(-50%) translateY(-50%) rotate(45deg);
}
.btn-1e:hover:after {
  height: 260%;
  opacity: 1;
}
.btn-1e:active:after {
  height: 400%;
  opacity: 1;
}
/* Button 1f */
.btn-1f {
  overflow: hidden;
}
.btn-1f:after {
  width: 101%;
  height: 0;
  top: 50%;
  left: 50%;
  background: #fff;
  opacity: 0;
  -webkit-transform: translateX(-50%) translateY(-50%);
  -moz-transform: translateX(-50%) translateY(-50%);
  -ms-transform: translateX(-50%) translateY(-50%);
  transform: translateX(-50%) translateY(-50%);
}
.btn-1f:hover:after {
  height: 100%;
  opacity: 1;
}
.btn-1f:active:after {
  height: 130%;
  opacity: 1;
}
/*sweat Aleart*/
.sweet-alert {
  padding: 25px;
}
.sweet-alert h2 {
  margin-top: 0px;
}
.sweet-alert p {
  line-height: 30px;
}
/*List icon*/
ul.list-icons {
  margin: 0px;
  padding: 0px;
}
ul.list-icons li {
  list-style: none;
  line-height: 40px;
}
ul.list-icons li i {
  font-size: 12px;
  margin-right: 5px;
}
/*Tooltip*/
.demo-tooltip .tooltip,
.demo-popover .popover {
  position: relative;
  margin-right: 25px;
  opacity: 1;
  display: inline-block;
}
.tooltip-inner {
  border-radius: 3px;
  padding: 5px 10px;
}
.tooltip.in {
  opacity: 1;
}
.tooltip-primary.tooltip .tooltip-inner,
.tooltip-primary + .tooltip .tooltip-inner {
  color: #ffffff;
  background-color: #7460ee;
}
.tooltip-primary.tooltip.top .tooltip-arrow,
.tooltip-primary + .tooltip.top .tooltip-arrow {
  border-top-color: #7460ee;
}
.tooltip-primary.tooltip.right .tooltip-arrow,
.tooltip-primary + .tooltip.right .tooltip-arrow {
  border-right-color: #7460ee;
}
.tooltip-primary.tooltip.bottom .tooltip-arrow,
.tooltip-primary + .tooltip.bottom .tooltip-arrow {
  border-bottom-color: #7460ee;
}
.tooltip-primary.tooltip.left .tooltip-arrow,
.tooltip-primary + .tooltip.left .tooltip-arrow {
  border-left-color: #7460ee;
}
.tooltip-success.tooltip .tooltip-inner,
.tooltip-success + .tooltip .tooltip-inner {
  color: #ffffff;
  background-color: #7ace4c;
}
.tooltip-success.tooltip.top .tooltip-arrow,
.tooltip-success + .tooltip.top .tooltip-arrow {
  border-top-color: #7ace4c;
}
.tooltip-success.tooltip.right .tooltip-arrow,
.tooltip-success + .tooltip.right .tooltip-arrow {
  border-right-color: #7ace4c;
}
.tooltip-success.tooltip.bottom .tooltip-arrow,
.tooltip-success + .tooltip.bottom .tooltip-arrow {
  border-bottom-color: #7ace4c;
}
.tooltip-success.tooltip.left .tooltip-arrow,
.tooltip-success + .tooltip.left .tooltip-arrow {
  border-left-color: #7ace4c;
}
.tooltip-warning.tooltip .tooltip-inner,
.tooltip-warning + .tooltip .tooltip-inner {
  color: #ffffff;
  background-color: #ffbb44;
}
.tooltip-warning.tooltip.top .tooltip-arrow,
.tooltip-warning + .tooltip.top .tooltip-arrow {
  border-top-color: #ffbb44;
}
.tooltip-warning.tooltip.right .tooltip-arrow,
.tooltip-warning + .tooltip.right .tooltip-arrow {
  border-right-color: #ffbb44;
}
.tooltip-warning.tooltip.bottom .tooltip-arrow,
.tooltip-warning + .tooltip.bottom .tooltip-arrow {
  border-bottom-color: #ffbb44;
}
.tooltip-warning.tooltip.left .tooltip-arrow,
.tooltip-warning + .tooltip.left .tooltip-arrow {
  border-left-color: #ffbb44;
}
.tooltip-info.tooltip .tooltip-inner,
.tooltip-info + .tooltip .tooltip-inner {
  color: #ffffff;
  background-color: #41b3f9;
}
.tooltip-info.tooltip.top .tooltip-arrow,
.tooltip-info + .tooltip.top .tooltip-arrow {
  border-top-color: #41b3f9;
}
.tooltip-info.tooltip.right .tooltip-arrow,
.tooltip-info + .tooltip.right .tooltip-arrow {
  border-right-color: #41b3f9;
}
.tooltip-info.tooltip.bottom .tooltip-arrow,
.tooltip-info + tooltip.bottom .tooltip-arrow {
  border-bottom-color: #41b3f9;
}
.tooltip-info.tooltip.left .tooltip-arrow,
.tooltip-info + .tooltip.left .tooltip-arrow {
  border-left-color: #41b3f9;
}
.tooltip-danger.tooltip .tooltip-inner,
.tooltip-danger + .tooltip .tooltip-inner {
  color: #ffffff;
  background-color: #f33155;
}
.tooltip-danger.tooltip.top .tooltip-arrow,
.tooltip-danger + .tooltip.top .tooltip-arrow {
  border-top-color: #f33155;
}
.tooltip-danger.tooltip.right .tooltip-arrow,
.tooltip-danger + .tooltip.right .tooltip-arrow {
  border-right-color: #f33155;
}
.tooltip-danger.tooltip.bottom .tooltip-arrow,
.tooltip-danger + .tooltip.bottom .tooltip-arrow {
  border-bottom-color: #f33155;
}
.tooltip-danger.tooltip.left .tooltip-arrow,
.tooltip-danger + .tooltip.left .tooltip-arrow {
  border-left-color: #f33155;
}
.flotTip {
  padding: 8px 12px;
  background-color: #263238;
  z-index: 100;
  color: #ffffff;
  opacity: 0.9;
  font-size: 13px;
}
/*Popover*/
.popover {
  -webkit-box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
}
.popover .popover-title {
  border-radius: 0px;
}
.popover-primary + .popover .popover-title {
  color: #ffffff;
  background-color: #7460ee;
  border-color: #7460ee;
}
.popover-primary + .popover.bottom .arrow {
  border-bottom-color: #7460ee;
}
.popover-primary + .popover.bottom .arrow:after {
  border-bottom-color: #7460ee;
}
.popover-success + .popover .popover-title {
  color: #ffffff;
  background-color: #7ace4c;
  border-color: #7ace4c;
}
.popover-success + .popover.bottom .arrow {
  border-bottom-color: #7ace4c;
}
.popover-success + .popover.bottom .arrow:after {
  border-bottom-color: #7ace4c;
}
.popover-info + .popover .popover-title {
  color: #ffffff;
  background-color: #41b3f9;
  border-color: #41b3f9;
}
.popover-info + .popover.bottom .arrow {
  border-bottom-color: #41b3f9;
}
.popover-info + .popover.bottom .arrow:after {
  border-bottom-color: #41b3f9;
}
.popover-warning + .popover .popover-title {
  color: #ffffff;
  background-color: #ffbb44;
  border-color: #ffbb44;
}
.popover-warning + .popover.bottom .arrow {
  border-bottom-color: #ffbb44;
}
.popover-warning + .popover.bottom .arrow:after {
  border-bottom-color: #ffbb44;
}
.popover-danger + .popover .popover-title {
  color: #ffffff;
  background-color: #f33155;
  border-color: #f33155;
}
.popover-danger + .popover.bottom .arrow {
  border-bottom-color: #f33155;
}
.popover-danger + .popover.bottom .arrow:after {
  border-bottom-color: #f33155;
}
/*File Upload*/
.btn-file {
  overflow: hidden;
  position: relative;
  vertical-align: middle;
}
.btn-file > input {
  position: absolute;
  top: 0;
  right: 0;
  margin: 0;
  opacity: 0;
  filter: alpha(opacity=0);
  font-size: 23px;
  height: 100%;
  width: 100%;
  direction: ltr;
  cursor: pointer;
  border-radius: 0px;
}
.fileinput {
  margin-bottom: 9px;
  display: inline-block;
}
.fileinput .form-control {
  padding-top: 7px;
  padding-bottom: 5px;
  display: inline-block;
  margin-bottom: 0px;
  vertical-align: middle;
  cursor: text;
}
.fileinput .thumbnail {
  overflow: hidden;
  display: inline-block;
  margin-bottom: 5px;
  vertical-align: middle;
  text-align: center;
}
.fileinput .thumbnail > img {
  max-height: 100%;
}
.fileinput .btn {
  vertical-align: middle;
}
.fileinput-exists .fileinput-new,
.fileinput-new .fileinput-exists {
  display: none;
}
.fileinput-inline .fileinput-controls {
  display: inline;
}
.fileinput-filename {
  vertical-align: middle;
  display: inline-block;
  overflow: hidden;
}
.form-control .fileinput-filename {
  vertical-align: bottom;
}
.fileinput.input-group {
  display: table;
}
.fileinput.input-group > * {
  position: relative;
  z-index: 2;
}
.fileinput.input-group > .btn-file {
  z-index: 1;
}
/*Bootstrap select*/
.bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
  width: 100%;
}
.ms-container .ms-list {
  border-radius: 0px;
  box-shadow: none;
}
.ms-container .ms-selectable li.ms-elem-selectable,
.ms-container .ms-selection li.ms-elem-selection {
  padding: 6px 10px;
}
.ms-container .ms-selectable li.ms-hover,
.ms-container .ms-selection li.ms-hover {
  background: #41b3f9;
}
/*Dropzone*/
.dropzone .dz-message {
  text-align: center;
  margin: 10% 0;
}
/*xeditable*/
.editable-input .form-control {
  height: 30px;
}
/*ascolorpicker*/
.asColorPicker-trigger {
  position: absolute;
  top: 0;
  right: -35px;
  height: 38px;
  width: 37px;
  border: 0px;
}
.asColorPicker-dropdown {
  max-width: 260px;
}
.asColorPicker-clear {
  top: 7px;
  right: 16px;
}
/*Datepicker*/
.datepicker table tr td.today,
.datepicker table tr td.today:hover,
.datepicker table tr td.today.disabled,
.datepicker table tr td.today.disabled:hover {
  background-image: none;
  background: #2cabe3;
  color: #ffffff;
}
.datepicker table tr td.active,
.datepicker table tr td.active:hover,
.datepicker table tr td.active.disabled,
.datepicker table tr td.active.disabled:hover {
  background-image: none;
  background: #41b3f9;
  color: #ffffff;
}
/*Datatable*/
.editable-table + input.error {
  border: 1px solid #danger;
  outline: 0;
  outline-offset: 0;
}
.editable-table + input,
.editable-table + input:focus,
#editable-datatable_wrapper + input:focus {
  border: 1px solid #41b3f9 !important;
  outline: 0!important;
  outline-offset: 0 !important;
}
.editable-table td:focus {
  outline: 0;
}
/*USer-profile*/
.user-profile {
  padding: 70px 0 15px;
  position: relative;
  text-align: center;
}
.user-profile .user-pro-body {
  display: block;
}
.user-profile .user-pro-body img {
  width: 50px;
  display: block;
  margin: 0 auto;
  margin-bottom: 10px;
}
.user-profile .user-pro-body .u-dropdown {
  color: #97999f;
}
.user-profile .user-pro-body .dropdown-menu {
  right: 0px;
  width: 180px;
  left: 0px;
  margin: 0 auto;
}
/*Form-Wizard*/
.wizard-steps {
  display: table;
  width: 100%;
}
.wizard-steps > li {
  display: table-cell;
  padding: 10px 20px;
  background: #f7fafc;
}
.wizard-steps > li span {
  border-radius: 100%;
  border: 1px solid rgba(120, 130, 140, 0.13);
  width: 40px;
  height: 40px;
  display: inline-block;
  vertical-align: middle;
  padding-top: 9px;
  margin-right: 8px;
  text-align: center;
}
.wizard-content {
  padding: 25px;
  border-color: rgba(120, 130, 140, 0.13);
  margin-bottom: 30px;
}
.wizard-steps > li.current,
.wizard-steps > li.done {
  background: #41b3f9;
  color: #ffffff;
}
.wizard-steps > li.current span,
.wizard-steps > li.done span {
  border-color: #ffffff;
  color: #ffffff;
}
.wizard-steps > li.current h4,
.wizard-steps > li.done h4 {
  color: #ffffff;
}
.wizard-steps > li.done {
  background: #7ace4c;
}
.wizard-steps > li.error {
  background: #f33155;
}
.wiz-aco .pager {
  margin: 0px;
}
/*New Widgets*/
/*Status widgets*/
#morris-donut-chart svg text {
  font-family: 'Rubik', sans-serif !important;
  font-weight: 400!important;
}
/*Finance diagram*/
#diagram {
  margin: 0 auto;
  width: 250px;
  padding-top: 30px;
  height: 271px;
}
#diagram circle {
  fill: #ffffff;
}
#diagram text {
  fill: #313131;
}
.get {
  display: none;
}
/*Expense box*/
ul.expense-box {
  margin: 0px;
  padding: 0px;
}
ul.expense-box li {
  list-style: none;
  display: inline-block;
  padding: 8px 0 8px 20px;
}
ul.expense-box li i {
  width: 60px;
  font-size: 30px;
  vertical-align: middle;
  display: inline-block;
}
ul.expense-box li span {
  display: inline-block;
  vertical-align: middle;
}
ul.expense-box li span h2 {
  margin-bottom: 0px;
  font-weight: 400;
}
ul.expense-box li span h4 {
  margin-top: 0px;
}
.minus-margin {
  margin: 0 -25px;
}
/*manage users*/
.manage-users {
  margin-bottom: 30px;
}
.manage-users .tabs-style-iconbox nav {
  background: #41b3f9;
}
.manage-users .tabs-style-iconbox nav ul li a {
  color: rgba(255, 255, 255, 0.6);
  text-transform: uppercase;
}
.manage-users .tabs-style-iconbox nav ul li a.sticon:before {
  margin-bottom: 15px;
}
.manage-users .tabs-style-iconbox nav ul li.tab-current a {
  box-shadow: none;
}
ul.side-icon-text {
  margin: 0px;
  padding: 0px;
}
ul.side-icon-text > li {
  list-style: none;
  display: inline-block;
  margin-right: 10px;
}
ul.side-icon-text > li a {
  color: #313131;
  font-weight: 400;
}
ul.side-icon-text > li a:hover {
  color: #41b3f9;
}
ul.side-icon-text > li a span {
  margin-right: 10px;
}
.manage-table {
  border-top: 1px solid rgba(120, 130, 140, 0.13);
  margin: 10px -25px 0;
  background: #f7fafc;
  padding: 30px;
}
.table tbody tr.advance-table-row {
  border: 2px solid rgba(120, 130, 140, 0.13);
  white-space: nowrap;
}
.table tbody tr.advance-table-row .checkbox {
  margin: 0px;
}
.table tbody tr.advance-table-row.active {
  border: 2px solid #2cabe3;
}
.table tbody tr.advance-table-row td {
  vertical-align: middle!important;
  border: 0px!important;
  font-size: 16px;
  background: #ffffff;
}
td.sm-pd {
  padding: 5px 0 !important;
}
/*your wallet balance*/
.wallet-widgets #morris-area-chart2 text,
.demo-container .flot-x-axis,
.demo-container .flot-text {
  display: none;
}
ul.wallet-list {
  margin: 0px;
  padding: 0px;
}
ul.wallet-list li {
  list-style: none;
  display: block;
  font-size: 18px;
  padding: 20px 20px;
  border-top: 1px solid rgba(120, 130, 140, 0.13);
}
ul.wallet-list li i {
  font-size: 24px;
  display: inline-block;
  margin-right: 12px;
  vertical-align: middle;
  color: #41b3f9;
}
ul.wallet-list li a {
  vertical-align: middle;
  color: #313131;
}
ul.wallet-list li a:hover {
  color: #2cabe3;
}
/*ct-sales*/
@keyframes dasharray-craziness {
  0% {
    stroke-dasharray: 5px;
  }
  50% {
    stroke-dasharray: 6px;
  }
  100% {
    stroke-dasharray: 7px;
  }
}
#ct-sales,
#ct-weather,
#ct-extra,
#ct-bar-chart,
#ct-main-bal,
#ct-visits,
#ct-city-wth,
#ct-polar-chart,
#ct-daily-sales {
  position: relative;
}
#ct-sales .ct-series-a .ct-line,
#ct-weather .ct-series-a .ct-line,
#ct-extra .ct-series-a .ct-line,
#ct-sales .ct-series-a .ct-point,
#ct-weather .ct-series-a .ct-point,
#ct-extra .ct-series-a .ct-point {
  stroke: #ffffff;
  stroke-shadow: 3px 10px 10px #000;
}
#ct-sales .ct-series-a .ct-area,
#ct-weather .ct-series-a .ct-area,
#ct-extra .ct-series-a .ct-area {
  fill: none;
}
#ct-sales .ct-grid,
#ct-weather .ct-grid,
#ct-extra .ct-grid {
  stroke: rgba(255, 255, 255, 0.2);
  stroke-dasharray: 0px;
}
#ct-weather .ct-series-a .ct-line {
  animation: dasharray-craziness 2s infinite;
}
.ct-label {
  font-size: 1em;
}
#ct-extra .ct-series-a .ct-line,
#ct-extra .ct-series-a .ct-point {
  stroke: #41b3f9;
  animation: dasharray-craziness 0.5s infinite;
}
#ct-extra .ct-grid {
  stroke: rgba(0, 0, 0, 0.2);
  stroke-dasharray: 2px;
}
#ct-bar-chart .ct-series-a .ct-bar {
  stroke: #41b3f9;
  stroke-width: 7px;
}
#ct-main-bal .ct-series-a .ct-line,
#ct-main-bal .ct-series-a .ct-point {
  stroke: none;
  fill: #41b3f9;
  fill-opacity: 0.5;
}
#ct-main-bal .ct-series-b .ct-line,
#ct-main-bal .ct-series-b .ct-point {
  stroke: #41b3f9;
  stroke-width: 1px;
  animation: dasharray-craziness 2s infinite;
  opacity: 0.8;
}
#ct-main-bal .ct-series-b .ct-area {
  fill: #41b3f9;
  fill-opacity: 0.2;
}
#ct-visits .ct-series-a .ct-line,
#ct-visits .ct-series-a .ct-point {
  stroke: #98a6ad;
}
#ct-visits .ct-series-b .ct-line,
#ct-visits .ct-series-b .ct-point {
  stroke: #41b3f9;
}
#ct-visits .ct-series-a .ct-area {
  fill: #98a6ad;
  fill-opacity: 0.05;
}
#ct-visits .ct-series-b .ct-area {
  fill: #41b3f9;
  fill-opacity: 0.1;
}
#ct-visits .ct-line {
  stroke-width: 2px;
}
#ct-city-wth .ct-label {
  color: #ffffff;
}
#ct-city-wth .ct-series-a .ct-line,
#ct-city-wth .ct-series-a .ct-point {
  stroke: #41b3f9;
}
#ct-city-wth .ct-series-a .ct-area {
  fill: none;
}
#ct-polar-chart .ct-series-a .ct-point,
#ct-polar-chart .ct-series-b .ct-point,
#ct-polar-chart .ct-series-c .ct-point,
#ct-polar-chart .ct-series-d .ct-point {
  stroke-width: 3px;
}
#ct-polar-chart .ct-series-a .ct-area {
  fill: #41b3f9;
}
#ct-polar-chart .ct-series-b .ct-area {
  fill: #7ace4c;
}
#ct-polar-chart .ct-series-c .ct-area {
  fill: #f33155;
}
#ct-polar-chart .ct-series-d .ct-area {
  fill: #ffbb44;
}
#ct-daily-sales .ct-series-a .ct-bar {
  stroke: rgba(255, 255, 255, 0.7);
  stroke-width: 10px;
}
/*New weather widgets*/
.dp-table {
  display: table;
  width: 100%;
  margin: 0px;
  padding: 0px;
}
.dp-table li {
  margin: 0px;
  padding: 0px;
  list-style: none;
  display: table-cell;
  text-align: center;
}
/*Calendar widgets*/
.calendar-widget {
  display: block;
  background: #ffffff;
  overflow: hidden;
}
.calendar-widget .cal-left {
  width: 30%;
  float: left;
  position: absolute;
  padding: 5%;
  height: 100%;
}
.calendar-widget .cal-left .cal-btm-text {
  position: absolute;
  bottom: 40px;
  font-weight: 400;
}
.calendar-widget .cal-left h1 {
  font-size: 50px;
  margin-bottom: 0px;
  font-weight: 400;
}
.calendar-widget .cal-left span {
  width: 100px;
  border-top: 2px solid #7ace4c;
  height: 2px;
  margin: 3px 0;
  display: inline-block;
}
.calendar-widget .cal-right {
  width: 70%;
  float: right;
  min-height: 200px;
}
.calendar-widget .cal-right .cal-table {
  width: 100%;
}
.calendar-widget .cal-right .cal-table td {
  padding: 18px 15px;
  text-align: center;
  font-weight: 400;
}
.calendar-widget .cal-right .cal-table td h1 {
  text-align: left;
  font-weight: 400;
  padding-left: 30px;
}
.calendar-widget .cal-right .cal-table td .cal-add {
  font-size: 24px;
}
.calendar-widget .cal-right .cal-table td.cal-active {
  border-radius: 60px;
  background: rgba(0, 0, 0, 0.1);
}
/*Real-time-widgest*/
.real-time-widgets {
  text-align: center;
  position: relative;
}
.real-time-widgets .data-text {
  width: 200px;
  margin: 0 auto;
  position: absolute;
  left: 0;
  z-index: 200;
  right: 0;
  top: 110px;
}
.real-time-widgets .data-text h1 {
  font-size: 50px;
}
.real-time-widgets .data-text h5 {
  width: 70px;
  margin: 0 auto;
  padding-bottom: 8px;
  margin-bottom: 10px;
  border-bottom: 2px solid #7ace4c;
}
.real-time-widgets .data-text span {
  font-size: 18px;
  font-weight: 400;
}
/*Profile-widgets*/
.profile-social-icons {
  padding-bottom: 30px;
  font-size: 20px;
}
.profile-social-icons a {
  color: #98a6ad;
}
/*Mailbox widgets*/
.mailbox-widget .customtab {
  border-bottom: 0px;
}
.mailbox-widget .customtab li a {
  color: #ffffff;
}
.mailbox-widget .customtab li a:hover {
  background: transparent;
  opacity: 0.5;
}
.mailbox-widget .customtab li.active a,
.mailbox-widget .customtab li.active a:focus {
  background: none;
  color: #ffffff;
  border-color: #7ace4c;
}
/*sk-chat-widgets*/
.sk-chat-widgets .chatonline {
  padding: 0px;
}
.sk-chat-widgets .chatonline li {
  list-style: none;
  padding: 5px 0;
  position: relative;
}
.sk-chat-widgets .chatonline li a {
  float: none;
  display: inline-block;
}
.sk-chat-widgets .chatonline li a img {
  width: 40px;
}
.sk-chat-widgets .chatonline li .call-chat {
  position: absolute;
  right: 0px;
  display: none;
  top: 20px;
}
.sk-chat-widgets .chatonline li:hover .call-chat {
  display: block;
}
/*New Chat box widgets*/
.chat-box-input {
  border: 0px;
  width: 100%;
  height: 60px;
  resize: none;
  line-height: 24px;
}
/*manage-u-table*/
.manage-u-table select {
  max-width: 150px;
  border-radius: 60px;
}
.manage-u-table td {
  white-space: nowrap;
}
/*City weather widget*/
.city-weather-widget .side-icon-text i {
  font-size: 50px;
  margin-right: 15px;
}
.city-weather-widget .side-icon-text h1 {
  font-weight: 500;
}
.city-weather-days {
  padding: 0 15px;
}
.city-weather-days li {
  text-align: center;
  font-size: 16px;
  padding: 18px 0;
  border-left: 1px solid rgba(120, 130, 140, 0.13);
  border-top: 1px solid rgba(120, 130, 140, 0.13);
}
.city-weather-days li span {
  display: block;
  text-transform: uppercase;
  line-height: 24px;
  padding: 7px 0px;
}
.city-weather-days li i {
  font-size: 30px;
  color: #e8e8e8;
}
.city-weather-days li.active {
  border-bottom: 2px solid #f33155;
}
.city-weather-days li.active i {
  color: #f33155;
}
/*weather-with-bg*/
.weather-with-bg .wt-top .wt-img {
  width: 100%;
  height: 350px;
  padding: 40px 60px;
  background-size: cover;
  background-position: center center;
  overflow: hidden;
}
.weather-with-bg .wt-top .wt-img h1,
.weather-with-bg .wt-top .wt-img h4,
.weather-with-bg .wt-top .wt-img i {
  color: #ffffff;
}
.weather-with-bg .wt-top .wt-img .side-icon-text li i {
  font-size: 60px;
  margin-right: 20px;
}
.weather-with-bg .wt-top .wt-img .side-icon-text li h1 {
  font-size: 60px;
}
.weather-with-bg .wt-top .wt-img .wt-city-text {
  padding-top: 50px;
}
.weather-with-bg .wt-counter li {
  display: inline-block;
  padding: 10px 7.5px;
}
.weather-with-bg .wt-counter li a {
  min-width: 50px;
  display: block;
  padding: 13px;
  height: 50px;
  color: #313131;
  font-size: 17px;
  text-align: center;
  border-radius: 100%;
}
.weather-with-bg .wt-counter li.active a {
  background: #2cabe3;
  color: #ffffff;
}
/*mt Gauge chart*/
.mt-gauge {
  background: #ffffff;
  height: 314px;
}
/*Calendar Event*/
.calendar-events {
  padding: 8px 10px;
  border: 1px solid #ffffff;
  cursor: move;
}
.calendar-events:hover {
  border: 1px dashed rgba(120, 130, 140, 0.13);
}
.calendar-events i {
  margin-right: 8px;
}
/*earning-box-widgets*/
.earning-box {
  padding: 0px;
  margin: 0px;
}
.earning-box li {
  display: box;
  list-style: none;
  padding: 20px 0;
}
.earning-box li .er-row {
  overflow: hidden;
}
.earning-box li .er-row .er-pic {
  float: left;
  margin-right: 20px;
}
.earning-box li .er-row .er-pic img {
  width: 60px;
}
.earning-box li .er-row .er-text {
  float: left;
  width: 45%;
}
.earning-box li .er-row .er-text h3 {
  margin: 5px 0 0 0px;
  font-weight: 400;
  font-size: 18px;
  text-overflow: ellipsis;
  white-space: nowrap;
  overflow: hidden;
}
.earning-box li .er-row .er-count {
  float: right;
  font-size: 30px;
  padding-top: 5px;
  color: #41b3f9;
  font-weight: 400;
}
/*To-do list*/
.todo-list li {
  border: 0px;
  border-bottom: 1px solid rgba(120, 130, 140, 0.13);
  margin-bottom: 0px;
  padding: 20px 15px 15px 0px;
}
.todo-list li .checkbox label {
  font-weight: 400;
}
.todo-list li:last-child {
  border-bottom: 0px;
}
.todo-list li .assignedto {
  padding: 0px 0 0 27px;
  margin: 0px;
}
.todo-list li .assignedto li {
  list-style: none;
  padding: 0px;
  display: inline-block;
  border: 0px;
  margin-right: 2px;
}
.todo-list li .assignedto li img {
  width: 30px;
  border-radius: 100%;
}
.todo-list li .item-date {
  padding-left: 25px;
  font-size: 12px;
  display: inline-block;
}
.list-task .task-done span {
  text-decoration: line-through;
}
/*Designer form*/
.no-bg-addon .input-group-addon {
  background-color: #ffffff;
  border: 1px solid rgba(120, 130, 140, 0.13);
  left: -2px;
  position: relative;
  z-index: 10;
  border-left: 0px;
  color: #e4e7ea;
  border-radius: 0px 3px 3px 0;
}
.no-bg-addon .form-control {
  transition: 0s;
}
.no-bg-addon .form-control:focus + .input-group-addon {
  border-color: #313131;
  color: #313131;
}
.select-mode .btn {
  padding: 15px 0;
}
.select-mode .btn.btn-default:focus {
  border-color: #41b3f9;
  color: #ffffff;
  background: #41b3f9;
}
ul.select-row-icon {
  padding: 0px;
  margin: 0px;
}
ul.select-row-icon li {
  display: block;
  list-style: none;
}
ul.select-row-icon li a {
  display: block;
  color: #313131;
  padding: 8px 15px;
  position: relative;
  border: 2px solid #ffffff;
}
ul.select-row-icon li a i {
  font-size: 24px;
  vertical-align: middle;
  padding-right: 10px;
}
ul.select-row-icon li a i.whn-hov {
  color: #41b3f9;
  display: none;
  float: right;
  position: absolute;
  right: 15px;
  top: 10px;
}
ul.select-row-icon li a:hover,
ul.select-row-icon li a.selected {
  border: 2px solid rgba(120, 130, 140, 0.13);
}
ul.select-row-icon li a:hover i.whn-hov,
ul.select-row-icon li a.selected i.whn-hov {
  display: inline-block;
}
.sidebar {
  overflow-y: auto;
}
.sidebar .sidebar-nav.navbar-collapse {
  padding-left: 0;
  padding-right: 0;
}
.sidebar .fa-fw {
  width: 20px;
  text-align: center!important;
  display: inline-block;
  font-style: normal;
  font-weight: 500;
  margin-right: 7px;
  font-size: 16px;
  vertical-align: middle;
}
.sidebar .mdi {
  font-size: 21px;
}
.sidebar .sidebar-head {
  padding: 4px 20px;
  width: 240px;
  position: fixed;
  z-index: 10;
  left: 0px;
  top: 0px;
}
.sidebar .sidebar-head h3 {
  color: #ffffff;
  font-weight: 400;
}
.sidebar .sidebar-head h3 i {
  font-size: 20px;
}
.sidebar:hover .sidebar-head {
  width: 240px;
}
.sidebar .label {
  font-size: 10px;
  border-radius: 60px;
  padding: 6px 8px;
  min-width: 30px;
  height: 20px;
  margin-top: 4px;
}
.sidebar #side-menu .user-pro .img-circle {
  width: 30px;
  margin-right: 10px;
}
.sidebar #side-menu .user-pro > a {
  padding-left: 15px;
}
.sidebar #side-menu .user-pro ul li a {
  padding-left: 25px;
}
.sidebar #side-menu .user-pro .nav-second-level li i {
  margin-right: 10px;
}
#side-menu {
  overflow: hidden;
}
.sidebar .sidebar-search {
  padding: 15px;
}
#side-menu li.active > a {
  background: rgba(0, 0, 0, 0);
}
#side-menu li a {
  color: #97999f;
  width: 240px;
}
#side-menu li a:focus {
  background: rgba(0, 0, 0, 0);
}
#side-menu li.devider {
  margin: 7px 0;
  border-top: 1px solid rgba(120, 130, 140, 0.13);
}
#side-menu > li > a {
  padding: 15px 35px 15px 20px;
  display: block;
}
#side-menu > li > a:hover,
#side-menu > li > a:focus {
  background: rgba(0, 0, 0, 0.1);
}
#side-menu > li > a.active {
  color: #2cabe3;
}
#side-menu ul > li > a:hover {
  color: #2cabe3;
  background: none;
}
#side-menu ul > li > a.active {
  color: #2cabe3;
}
.sidebar .arrow {
  position: absolute;
  right: 20px;
  top: 23px;
}
.sidebar .nav-second-level .arrow {
  right: 20px;
  top: 17px;
}
.sidebar .fa.arrow:before {
  content: "\f105";
}
.sidebar .active > a > span > .fa.arrow:before {
  content: "\f107";
}
.sidebar .nav-second-level li,
.sidebar .nav-third-level li {
  border-bottom: none !important;
}
.sidebar .nav-second-level li a {
  padding: 14px 10px 14px 40px;
}
.sidebar .nav-third-level li a {
  padding-left: 60px;
}
.content-wrapper .nicescroll-rails {
  display: none!important;
}
/*!
 *  Font Awesome 4.5.0 by @davegandy - http://fontawesome.io - @fontawesome
 *  License - http://fontawesome.io/license (Font: SIL OFL 1.1, CSS: MIT License)
 */
/* FONT PATH
 * -------------------------- */
@font-face {
  font-family: 'FontAwesome';
  src: url('../less/icons/font-awesome/fonts/fontawesome-webfont3295.eot?v=4.5.0');
  src: url('../less/icons/font-awesome/fonts/fontawesome-webfontd41d.eot?#iefix&v=4.5.0') format('embedded-opentype'), url('../less/icons/font-awesome/fonts/fontawesome-webfont3295.html?v=4.5.0') format('woff2'), url('../less/icons/font-awesome/fonts/fontawesome-webfont3295.woff?v=4.5.0') format('woff'), url('../less/icons/font-awesome/fonts/fontawesome-webfont3295.ttf?v=4.5.0') format('truetype'), url('../less/icons/font-awesome/fonts/fontawesome-webfont3295.svg?v=4.5.0#fontawesomeregular') format('svg');
  font-weight: normal;
  font-style: normal;
}
.fa {
  display: inline-block;
  font: normal normal normal 14px/1 FontAwesome;
  font-size: inherit;
  text-rendering: auto;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
/* makes the font 33% larger relative to the icon container */
.fa-lg {
  font-size: 1.33333333em;
  line-height: 0.75em;
  vertical-align: -15%;
}
.fa-2x {
  font-size: 2em;
}
.fa-3x {
  font-size: 3em;
}
.fa-4x {
  font-size: 4em;
}
.fa-5x {
  font-size: 5em;
}
.fa-fw {
  width: 1.28571429em;
  text-align: center;
}
.fa-ul {
  padding-left: 0;
  margin-left: 2.14285714em;
  list-style-type: none;
}
.fa-ul > li {
  position: relative;
}
.fa-li {
  position: absolute;
  left: -2.14285714em;
  width: 2.14285714em;
  top: 0.14285714em;
  text-align: center;
}
.fa-li.fa-lg {
  left: -1.85714286em;
}
.fa-border {
  padding: .2em .25em .15em;
  border: solid 0.08em #eee;
  border-radius: .1em;
}
.fa-pull-left {
  float: left;
}
.fa-pull-right {
  float: right;
}
.fa.fa-pull-left {
  margin-right: .3em;
}
.fa.fa-pull-right {
  margin-left: .3em;
}
/* Deprecated as of 4.4.0 */
.pull-right {
  float: right;
}
.pull-left {
  float: left;
}
.fa.pull-left {
  margin-right: .3em;
}
.fa.pull-right {
  margin-left: .3em;
}
.fa-spin {
  -webkit-animation: fa-spin 2s infinite linear;
  animation: fa-spin 2s infinite linear;
}
.fa-pulse {
  -webkit-animation: fa-spin 1s infinite steps(8);
  animation: fa-spin 1s infinite steps(8);
}
@-webkit-keyframes fa-spin {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(359deg);
    transform: rotate(359deg);
  }
}
@keyframes fa-spin {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(359deg);
    transform: rotate(359deg);
  }
}
.fa-rotate-90 {
  filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=1);
  -webkit-transform: rotate(90deg);
  -ms-transform: rotate(90deg);
  transform: rotate(90deg);
}
.fa-rotate-180 {
  filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=2);
  -webkit-transform: rotate(180deg);
  -ms-transform: rotate(180deg);
  transform: rotate(180deg);
}
.fa-rotate-270 {
  filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
  -webkit-transform: rotate(270deg);
  -ms-transform: rotate(270deg);
  transform: rotate(270deg);
}
.fa-flip-horizontal {
  filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=0, mirror=1);
  -webkit-transform: scale(-1, 1);
  -ms-transform: scale(-1, 1);
  transform: scale(-1, 1);
}
.fa-flip-vertical {
  filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=2, mirror=1);
  -webkit-transform: scale(1, -1);
  -ms-transform: scale(1, -1);
  transform: scale(1, -1);
}
:root .fa-rotate-90,
:root .fa-rotate-180,
:root .fa-rotate-270,
:root .fa-flip-horizontal,
:root .fa-flip-vertical {
  filter: none;
}
.fa-stack {
  position: relative;
  display: inline-block;
  width: 2em;
  height: 2em;
  line-height: 2em;
  vertical-align: middle;
}
.fa-stack-1x,
.fa-stack-2x {
  position: absolute;
  left: 0;
  width: 100%;
  text-align: center;
}
.fa-stack-1x {
  line-height: inherit;
}
.fa-stack-2x {
  font-size: 2em;
}
.fa-inverse {
  color: #fff;
}
/* Font Awesome uses the Unicode Private Use Area (PUA) to ensure screen
   readers do not read off random characters that represent icons */
.fa-glass:before {
  content: "\f000";
}
.fa-music:before {
  content: "\f001";
}
.fa-search:before {
  content: "\f002";
}
.fa-envelope-o:before {
  content: "\f003";
}
.fa-heart:before {
  content: "\f004";
}
.fa-star:before {
  content: "\f005";
}
.fa-star-o:before {
  content: "\f006";
}
.fa-user:before {
  content: "\f007";
}
.fa-film:before {
  content: "\f008";
}
.fa-th-large:before {
  content: "\f009";
}
.fa-th:before {
  content: "\f00a";
}
.fa-th-list:before {
  content: "\f00b";
}
.fa-check:before {
  content: "\f00c";
}
.fa-remove:before,
.fa-close:before,
.fa-times:before {
  content: "\f00d";
}
.fa-search-plus:before {
  content: "\f00e";
}
.fa-search-minus:before {
  content: "\f010";
}
.fa-power-off:before {
  content: "\f011";
}
.fa-signal:before {
  content: "\f012";
}
.fa-gear:before,
.fa-cog:before {
  content: "\f013";
}
.fa-trash-o:before {
  content: "\f014";
}
.fa-home:before {
  content: "\f015";
}
.fa-file-o:before {
  content: "\f016";
}
.fa-clock-o:before {
  content: "\f017";
}
.fa-road:before {
  content: "\f018";
}
.fa-download:before {
  content: "\f019";
}
.fa-arrow-circle-o-down:before {
  content: "\f01a";
}
.fa-arrow-circle-o-up:before {
  content: "\f01b";
}
.fa-inbox:before {
  content: "\f01c";
}
.fa-play-circle-o:before {
  content: "\f01d";
}
.fa-rotate-right:before,
.fa-repeat:before {
  content: "\f01e";
}
.fa-refresh:before {
  content: "\f021";
}
.fa-list-alt:before {
  content: "\f022";
}
.fa-lock:before {
  content: "\f023";
}
.fa-flag:before {
  content: "\f024";
}
.fa-headphones:before {
  content: "\f025";
}
.fa-volume-off:before {
  content: "\f026";
}
.fa-volume-down:before {
  content: "\f027";
}
.fa-volume-up:before {
  content: "\f028";
}
.fa-qrcode:before {
  content: "\f029";
}
.fa-barcode:before {
  content: "\f02a";
}
.fa-tag:before {
  content: "\f02b";
}
.fa-tags:before {
  content: "\f02c";
}
.fa-book:before {
  content: "\f02d";
}
.fa-bookmark:before {
  content: "\f02e";
}
.fa-print:before {
  content: "\f02f";
}
.fa-camera:before {
  content: "\f030";
}
.fa-font:before {
  content: "\f031";
}
.fa-bold:before {
  content: "\f032";
}
.fa-italic:before {
  content: "\f033";
}
.fa-text-height:before {
  content: "\f034";
}
.fa-text-width:before {
  content: "\f035";
}
.fa-align-left:before {
  content: "\f036";
}
.fa-align-center:before {
  content: "\f037";
}
.fa-align-right:before {
  content: "\f038";
}
.fa-align-justify:before {
  content: "\f039";
}
.fa-list:before {
  content: "\f03a";
}
.fa-dedent:before,
.fa-outdent:before {
  content: "\f03b";
}
.fa-indent:before {
  content: "\f03c";
}
.fa-video-camera:before {
  content: "\f03d";
}
.fa-photo:before,
.fa-image:before,
.fa-picture-o:before {
  content: "\f03e";
}
.fa-pencil:before {
  content: "\f040";
}
.fa-map-marker:before {
  content: "\f041";
}
.fa-adjust:before {
  content: "\f042";
}
.fa-tint:before {
  content: "\f043";
}
.fa-edit:before,
.fa-pencil-square-o:before {
  content: "\f044";
}
.fa-share-square-o:before {
  content: "\f045";
}
.fa-check-square-o:before {
  content: "\f046";
}
.fa-arrows:before {
  content: "\f047";
}
.fa-step-backward:before {
  content: "\f048";
}
.fa-fast-backward:before {
  content: "\f049";
}
.fa-backward:before {
  content: "\f04a";
}
.fa-play:before {
  content: "\f04b";
}
.fa-pause:before {
  content: "\f04c";
}
.fa-stop:before {
  content: "\f04d";
}
.fa-forward:before {
  content: "\f04e";
}
.fa-fast-forward:before {
  content: "\f050";
}
.fa-step-forward:before {
  content: "\f051";
}
.fa-eject:before {
  content: "\f052";
}
.fa-chevron-left:before {
  content: "\f053";
}
.fa-chevron-right:before {
  content: "\f054";
}
.fa-plus-circle:before {
  content: "\f055";
}
.fa-minus-circle:before {
  content: "\f056";
}
.fa-times-circle:before {
  content: "\f057";
}
.fa-check-circle:before {
  content: "\f058";
}
.fa-question-circle:before {
  content: "\f059";
}
.fa-info-circle:before {
  content: "\f05a";
}
.fa-crosshairs:before {
  content: "\f05b";
}
.fa-times-circle-o:before {
  content: "\f05c";
}
.fa-check-circle-o:before {
  content: "\f05d";
}
.fa-ban:before {
  content: "\f05e";
}
.fa-arrow-left:before {
  content: "\f060";
}
.fa-arrow-right:before {
  content: "\f061";
}
.fa-arrow-up:before {
  content: "\f062";
}
.fa-arrow-down:before {
  content: "\f063";
}
.fa-mail-forward:before,
.fa-share:before {
  content: "\f064";
}
.fa-expand:before {
  content: "\f065";
}
.fa-compress:before {
  content: "\f066";
}
.fa-plus:before {
  content: "\f067";
}
.fa-minus:before {
  content: "\f068";
}
.fa-asterisk:before {
  content: "\f069";
}
.fa-exclamation-circle:before {
  content: "\f06a";
}
.fa-gift:before {
  content: "\f06b";
}
.fa-leaf:before {
  content: "\f06c";
}
.fa-fire:before {
  content: "\f06d";
}
.fa-eye:before {
  content: "\f06e";
}
.fa-eye-slash:before {
  content: "\f070";
}
.fa-warning:before,
.fa-exclamation-triangle:before {
  content: "\f071";
}
.fa-plane:before {
  content: "\f072";
}
.fa-calendar:before {
  content: "\f073";
}
.fa-random:before {
  content: "\f074";
}
.fa-comment:before {
  content: "\f075";
}
.fa-magnet:before {
  content: "\f076";
}
.fa-chevron-up:before {
  content: "\f077";
}
.fa-chevron-down:before {
  content: "\f078";
}
.fa-retweet:before {
  content: "\f079";
}
.fa-shopping-cart:before {
  content: "\f07a";
}
.fa-folder:before {
  content: "\f07b";
}
.fa-folder-open:before {
  content: "\f07c";
}
.fa-arrows-v:before {
  content: "\f07d";
}
.fa-arrows-h:before {
  content: "\f07e";
}
.fa-bar-chart-o:before,
.fa-bar-chart:before {
  content: "\f080";
}
.fa-twitter-square:before {
  content: "\f081";
}
.fa-facebook-square:before {
  content: "\f082";
}
.fa-camera-retro:before {
  content: "\f083";
}
.fa-key:before {
  content: "\f084";
}
.fa-gears:before,
.fa-cogs:before {
  content: "\f085";
}
.fa-comments:before {
  content: "\f086";
}
.fa-thumbs-o-up:before {
  content: "\f087";
}
.fa-thumbs-o-down:before {
  content: "\f088";
}
.fa-star-half:before {
  content: "\f089";
}
.fa-heart-o:before {
  content: "\f08a";
}
.fa-sign-out:before {
  content: "\f08b";
}
.fa-linkedin-square:before {
  content: "\f08c";
}
.fa-thumb-tack:before {
  content: "\f08d";
}
.fa-external-link:before {
  content: "\f08e";
}
.fa-sign-in:before {
  content: "\f090";
}
.fa-trophy:before {
  content: "\f091";
}
.fa-github-square:before {
  content: "\f092";
}
.fa-upload:before {
  content: "\f093";
}
.fa-lemon-o:before {
  content: "\f094";
}
.fa-phone:before {
  content: "\f095";
}
.fa-square-o:before {
  content: "\f096";
}
.fa-bookmark-o:before {
  content: "\f097";
}
.fa-phone-square:before {
  content: "\f098";
}
.fa-twitter:before {
  content: "\f099";
}
.fa-facebook-f:before,
.fa-facebook:before {
  content: "\f09a";
}
.fa-github:before {
  content: "\f09b";
}
.fa-unlock:before {
  content: "\f09c";
}
.fa-credit-card:before {
  content: "\f09d";
}
.fa-feed:before,
.fa-rss:before {
  content: "\f09e";
}
.fa-hdd-o:before {
  content: "\f0a0";
}
.fa-bullhorn:before {
  content: "\f0a1";
}
.fa-bell:before {
  content: "\f0f3";
}
.fa-certificate:before {
  content: "\f0a3";
}
.fa-hand-o-right:before {
  content: "\f0a4";
}
.fa-hand-o-left:before {
  content: "\f0a5";
}
.fa-hand-o-up:before {
  content: "\f0a6";
}
.fa-hand-o-down:before {
  content: "\f0a7";
}
.fa-arrow-circle-left:before {
  content: "\f0a8";
}
.fa-arrow-circle-right:before {
  content: "\f0a9";
}
.fa-arrow-circle-up:before {
  content: "\f0aa";
}
.fa-arrow-circle-down:before {
  content: "\f0ab";
}
.fa-globe:before {
  content: "\f0ac";
}
.fa-wrench:before {
  content: "\f0ad";
}
.fa-tasks:before {
  content: "\f0ae";
}
.fa-filter:before {
  content: "\f0b0";
}
.fa-briefcase:before {
  content: "\f0b1";
}
.fa-arrows-alt:before {
  content: "\f0b2";
}
.fa-group:before,
.fa-users:before {
  content: "\f0c0";
}
.fa-chain:before,
.fa-link:before {
  content: "\f0c1";
}
.fa-cloud:before {
  content: "\f0c2";
}
.fa-flask:before {
  content: "\f0c3";
}
.fa-cut:before,
.fa-scissors:before {
  content: "\f0c4";
}
.fa-copy:before,
.fa-files-o:before {
  content: "\f0c5";
}
.fa-paperclip:before {
  content: "\f0c6";
}
.fa-save:before,
.fa-floppy-o:before {
  content: "\f0c7";
}
.fa-square:before {
  content: "\f0c8";
}
.fa-navicon:before,
.fa-reorder:before,
.fa-bars:before {
  content: "\f0c9";
}
.fa-list-ul:before {
  content: "\f0ca";
}
.fa-list-ol:before {
  content: "\f0cb";
}
.fa-strikethrough:before {
  content: "\f0cc";
}
.fa-underline:before {
  content: "\f0cd";
}
.fa-table:before {
  content: "\f0ce";
}
.fa-magic:before {
  content: "\f0d0";
}
.fa-truck:before {
  content: "\f0d1";
}
.fa-pinterest:before {
  content: "\f0d2";
}
.fa-pinterest-square:before {
  content: "\f0d3";
}
.fa-google-plus-square:before {
  content: "\f0d4";
}
.fa-google-plus:before {
  content: "\f0d5";
}
.fa-money:before {
  content: "\f0d6";
}
.fa-caret-down:before {
  content: "\f0d7";
}
.fa-caret-up:before {
  content: "\f0d8";
}
.fa-caret-left:before {
  content: "\f0d9";
}
.fa-caret-right:before {
  content: "\f0da";
}
.fa-columns:before {
  content: "\f0db";
}
.fa-unsorted:before,
.fa-sort:before {
  content: "\f0dc";
}
.fa-sort-down:before,
.fa-sort-desc:before {
  content: "\f0dd";
}
.fa-sort-up:before,
.fa-sort-asc:before {
  content: "\f0de";
}
.fa-envelope:before {
  content: "\f0e0";
}
.fa-linkedin:before {
  content: "\f0e1";
}
.fa-rotate-left:before,
.fa-undo:before {
  content: "\f0e2";
}
.fa-legal:before,
.fa-gavel:before {
  content: "\f0e3";
}
.fa-dashboard:before,
.fa-tachometer:before {
  content: "\f0e4";
}
.fa-comment-o:before {
  content: "\f0e5";
}
.fa-comments-o:before {
  content: "\f0e6";
}
.fa-flash:before,
.fa-bolt:before {
  content: "\f0e7";
}
.fa-sitemap:before {
  content: "\f0e8";
}
.fa-umbrella:before {
  content: "\f0e9";
}
.fa-paste:before,
.fa-clipboard:before {
  content: "\f0ea";
}
.fa-lightbulb-o:before {
  content: "\f0eb";
}
.fa-exchange:before {
  content: "\f0ec";
}
.fa-cloud-download:before {
  content: "\f0ed";
}
.fa-cloud-upload:before {
  content: "\f0ee";
}
.fa-user-md:before {
  content: "\f0f0";
}
.fa-stethoscope:before {
  content: "\f0f1";
}
.fa-suitcase:before {
  content: "\f0f2";
}
.fa-bell-o:before {
  content: "\f0a2";
}
.fa-coffee:before {
  content: "\f0f4";
}
.fa-cutlery:before {
  content: "\f0f5";
}
.fa-file-text-o:before {
  content: "\f0f6";
}
.fa-building-o:before {
  content: "\f0f7";
}
.fa-hospital-o:before {
  content: "\f0f8";
}
.fa-ambulance:before {
  content: "\f0f9";
}
.fa-medkit:before {
  content: "\f0fa";
}
.fa-fighter-jet:before {
  content: "\f0fb";
}
.fa-beer:before {
  content: "\f0fc";
}
.fa-h-square:before {
  content: "\f0fd";
}
.fa-plus-square:before {
  content: "\f0fe";
}
.fa-angle-double-left:before {
  content: "\f100";
}
.fa-angle-double-right:before {
  content: "\f101";
}
.fa-angle-double-up:before {
  content: "\f102";
}
.fa-angle-double-down:before {
  content: "\f103";
}
.fa-angle-left:before {
  content: "\f104";
}
.fa-angle-right:before {
  content: "\f105";
}
.fa-angle-up:before {
  content: "\f106";
}
.fa-angle-down:before {
  content: "\f107";
}
.fa-desktop:before {
  content: "\f108";
}
.fa-laptop:before {
  content: "\f109";
}
.fa-tablet:before {
  content: "\f10a";
}
.fa-mobile-phone:before,
.fa-mobile:before {
  content: "\f10b";
}
.fa-circle-o:before {
  content: "\f10c";
}
.fa-quote-left:before {
  content: "\f10d";
}
.fa-quote-right:before {
  content: "\f10e";
}
.fa-spinner:before {
  content: "\f110";
}
.fa-circle:before {
  content: "\f111";
}
.fa-mail-reply:before,
.fa-reply:before {
  content: "\f112";
}
.fa-github-alt:before {
  content: "\f113";
}
.fa-folder-o:before {
  content: "\f114";
}
.fa-folder-open-o:before {
  content: "\f115";
}
.fa-smile-o:before {
  content: "\f118";
}
.fa-frown-o:before {
  content: "\f119";
}
.fa-meh-o:before {
  content: "\f11a";
}
.fa-gamepad:before {
  content: "\f11b";
}
.fa-keyboard-o:before {
  content: "\f11c";
}
.fa-flag-o:before {
  content: "\f11d";
}
.fa-flag-checkered:before {
  content: "\f11e";
}
.fa-terminal:before {
  content: "\f120";
}
.fa-code:before {
  content: "\f121";
}
.fa-mail-reply-all:before,
.fa-reply-all:before {
  content: "\f122";
}
.fa-star-half-empty:before,
.fa-star-half-full:before,
.fa-star-half-o:before {
  content: "\f123";
}
.fa-location-arrow:before {
  content: "\f124";
}
.fa-crop:before {
  content: "\f125";
}
.fa-code-fork:before {
  content: "\f126";
}
.fa-unlink:before,
.fa-chain-broken:before {
  content: "\f127";
}
.fa-question:before {
  content: "\f128";
}
.fa-info:before {
  content: "\f129";
}
.fa-exclamation:before {
  content: "\f12a";
}
.fa-superscript:before {
  content: "\f12b";
}
.fa-subscript:before {
  content: "\f12c";
}
.fa-eraser:before {
  content: "\f12d";
}
.fa-puzzle-piece:before {
  content: "\f12e";
}
.fa-microphone:before {
  content: "\f130";
}
.fa-microphone-slash:before {
  content: "\f131";
}
.fa-shield:before {
  content: "\f132";
}
.fa-calendar-o:before {
  content: "\f133";
}
.fa-fire-extinguisher:before {
  content: "\f134";
}
.fa-rocket:before {
  content: "\f135";
}
.fa-maxcdn:before {
  content: "\f136";
}
.fa-chevron-circle-left:before {
  content: "\f137";
}
.fa-chevron-circle-right:before {
  content: "\f138";
}
.fa-chevron-circle-up:before {
  content: "\f139";
}
.fa-chevron-circle-down:before {
  content: "\f13a";
}
.fa-html5:before {
  content: "\f13b";
}
.fa-css3:before {
  content: "\f13c";
}
.fa-anchor:before {
  content: "\f13d";
}
.fa-unlock-alt:before {
  content: "\f13e";
}
.fa-bullseye:before {
  content: "\f140";
}
.fa-ellipsis-h:before {
  content: "\f141";
}
.fa-ellipsis-v:before {
  content: "\f142";
}
.fa-rss-square:before {
  content: "\f143";
}
.fa-play-circle:before {
  content: "\f144";
}
.fa-ticket:before {
  content: "\f145";
}
.fa-minus-square:before {
  content: "\f146";
}
.fa-minus-square-o:before {
  content: "\f147";
}
.fa-level-up:before {
  content: "\f148";
}
.fa-level-down:before {
  content: "\f149";
}
.fa-check-square:before {
  content: "\f14a";
}
.fa-pencil-square:before {
  content: "\f14b";
}
.fa-external-link-square:before {
  content: "\f14c";
}
.fa-share-square:before {
  content: "\f14d";
}
.fa-compass:before {
  content: "\f14e";
}
.fa-toggle-down:before,
.fa-caret-square-o-down:before {
  content: "\f150";
}
.fa-toggle-up:before,
.fa-caret-square-o-up:before {
  content: "\f151";
}
.fa-toggle-right:before,
.fa-caret-square-o-right:before {
  content: "\f152";
}
.fa-euro:before,
.fa-eur:before {
  content: "\f153";
}
.fa-gbp:before {
  content: "\f154";
}
.fa-dollar:before,
.fa-usd:before {
  content: "\f155";
}
.fa-rupee:before,
.fa-inr:before {
  content: "\f156";
}
.fa-cny:before,
.fa-rmb:before,
.fa-yen:before,
.fa-jpy:before {
  content: "\f157";
}
.fa-ruble:before,
.fa-rouble:before,
.fa-rub:before {
  content: "\f158";
}
.fa-won:before,
.fa-krw:before {
  content: "\f159";
}
.fa-bitcoin:before,
.fa-btc:before {
  content: "\f15a";
}
.fa-file:before {
  content: "\f15b";
}
.fa-file-text:before {
  content: "\f15c";
}
.fa-sort-alpha-asc:before {
  content: "\f15d";
}
.fa-sort-alpha-desc:before {
  content: "\f15e";
}
.fa-sort-amount-asc:before {
  content: "\f160";
}
.fa-sort-amount-desc:before {
  content: "\f161";
}
.fa-sort-numeric-asc:before {
  content: "\f162";
}
.fa-sort-numeric-desc:before {
  content: "\f163";
}
.fa-thumbs-up:before {
  content: "\f164";
}
.fa-thumbs-down:before {
  content: "\f165";
}
.fa-youtube-square:before {
  content: "\f166";
}
.fa-youtube:before {
  content: "\f167";
}
.fa-xing:before {
  content: "\f168";
}
.fa-xing-square:before {
  content: "\f169";
}
.fa-youtube-play:before {
  content: "\f16a";
}
.fa-dropbox:before {
  content: "\f16b";
}
.fa-stack-overflow:before {
  content: "\f16c";
}
.fa-instagram:before {
  content: "\f16d";
}
.fa-flickr:before {
  content: "\f16e";
}
.fa-adn:before {
  content: "\f170";
}
.fa-bitbucket:before {
  content: "\f171";
}
.fa-bitbucket-square:before {
  content: "\f172";
}
.fa-tumblr:before {
  content: "\f173";
}
.fa-tumblr-square:before {
  content: "\f174";
}
.fa-long-arrow-down:before {
  content: "\f175";
}
.fa-long-arrow-up:before {
  content: "\f176";
}
.fa-long-arrow-left:before {
  content: "\f177";
}
.fa-long-arrow-right:before {
  content: "\f178";
}
.fa-apple:before {
  content: "\f179";
}
.fa-windows:before {
  content: "\f17a";
}
.fa-android:before {
  content: "\f17b";
}
.fa-linux:before {
  content: "\f17c";
}
.fa-dribbble:before {
  content: "\f17d";
}
.fa-skype:before {
  content: "\f17e";
}
.fa-foursquare:before {
  content: "\f180";
}
.fa-trello:before {
  content: "\f181";
}
.fa-female:before {
  content: "\f182";
}
.fa-male:before {
  content: "\f183";
}
.fa-gittip:before,
.fa-gratipay:before {
  content: "\f184";
}
.fa-sun-o:before {
  content: "\f185";
}
.fa-moon-o:before {
  content: "\f186";
}
.fa-archive:before {
  content: "\f187";
}
.fa-bug:before {
  content: "\f188";
}
.fa-vk:before {
  content: "\f189";
}
.fa-weibo:before {
  content: "\f18a";
}
.fa-renren:before {
  content: "\f18b";
}
.fa-pagelines:before {
  content: "\f18c";
}
.fa-stack-exchange:before {
  content: "\f18d";
}
.fa-arrow-circle-o-right:before {
  content: "\f18e";
}
.fa-arrow-circle-o-left:before {
  content: "\f190";
}
.fa-toggle-left:before,
.fa-caret-square-o-left:before {
  content: "\f191";
}
.fa-dot-circle-o:before {
  content: "\f192";
}
.fa-wheelchair:before {
  content: "\f193";
}
.fa-vimeo-square:before {
  content: "\f194";
}
.fa-turkish-lira:before,
.fa-try:before {
  content: "\f195";
}
.fa-plus-square-o:before {
  content: "\f196";
}
.fa-space-shuttle:before {
  content: "\f197";
}
.fa-slack:before {
  content: "\f198";
}
.fa-envelope-square:before {
  content: "\f199";
}
.fa-wordpress:before {
  content: "\f19a";
}
.fa-openid:before {
  content: "\f19b";
}
.fa-institution:before,
.fa-bank:before,
.fa-university:before {
  content: "\f19c";
}
.fa-mortar-board:before,
.fa-graduation-cap:before {
  content: "\f19d";
}
.fa-yahoo:before {
  content: "\f19e";
}
.fa-google:before {
  content: "\f1a0";
}
.fa-reddit:before {
  content: "\f1a1";
}
.fa-reddit-square:before {
  content: "\f1a2";
}
.fa-stumbleupon-circle:before {
  content: "\f1a3";
}
.fa-stumbleupon:before {
  content: "\f1a4";
}
.fa-delicious:before {
  content: "\f1a5";
}
.fa-digg:before {
  content: "\f1a6";
}
.fa-pied-piper:before {
  content: "\f1a7";
}
.fa-pied-piper-alt:before {
  content: "\f1a8";
}
.fa-drupal:before {
  content: "\f1a9";
}
.fa-joomla:before {
  content: "\f1aa";
}
.fa-language:before {
  content: "\f1ab";
}
.fa-fax:before {
  content: "\f1ac";
}
.fa-building:before {
  content: "\f1ad";
}
.fa-child:before {
  content: "\f1ae";
}
.fa-paw:before {
  content: "\f1b0";
}
.fa-spoon:before {
  content: "\f1b1";
}
.fa-cube:before {
  content: "\f1b2";
}
.fa-cubes:before {
  content: "\f1b3";
}
.fa-behance:before {
  content: "\f1b4";
}
.fa-behance-square:before {
  content: "\f1b5";
}
.fa-steam:before {
  content: "\f1b6";
}
.fa-steam-square:before {
  content: "\f1b7";
}
.fa-recycle:before {
  content: "\f1b8";
}
.fa-automobile:before,
.fa-car:before {
  content: "\f1b9";
}
.fa-cab:before,
.fa-taxi:before {
  content: "\f1ba";
}
.fa-tree:before {
  content: "\f1bb";
}
.fa-spotify:before {
  content: "\f1bc";
}
.fa-deviantart:before {
  content: "\f1bd";
}
.fa-soundcloud:before {
  content: "\f1be";
}
.fa-database:before {
  content: "\f1c0";
}
.fa-file-pdf-o:before {
  content: "\f1c1";
}
.fa-file-word-o:before {
  content: "\f1c2";
}
.fa-file-excel-o:before {
  content: "\f1c3";
}
.fa-file-powerpoint-o:before {
  content: "\f1c4";
}
.fa-file-photo-o:before,
.fa-file-picture-o:before,
.fa-file-image-o:before {
  content: "\f1c5";
}
.fa-file-zip-o:before,
.fa-file-archive-o:before {
  content: "\f1c6";
}
.fa-file-sound-o:before,
.fa-file-audio-o:before {
  content: "\f1c7";
}
.fa-file-movie-o:before,
.fa-file-video-o:before {
  content: "\f1c8";
}
.fa-file-code-o:before {
  content: "\f1c9";
}
.fa-vine:before {
  content: "\f1ca";
}
.fa-codepen:before {
  content: "\f1cb";
}
.fa-jsfiddle:before {
  content: "\f1cc";
}
.fa-life-bouy:before,
.fa-life-buoy:before,
.fa-life-saver:before,
.fa-support:before,
.fa-life-ring:before {
  content: "\f1cd";
}
.fa-circle-o-notch:before {
  content: "\f1ce";
}
.fa-ra:before,
.fa-rebel:before {
  content: "\f1d0";
}
.fa-ge:before,
.fa-empire:before {
  content: "\f1d1";
}
.fa-git-square:before {
  content: "\f1d2";
}
.fa-git:before {
  content: "\f1d3";
}
.fa-y-combinator-square:before,
.fa-yc-square:before,
.fa-hacker-news:before {
  content: "\f1d4";
}
.fa-tencent-weibo:before {
  content: "\f1d5";
}
.fa-qq:before {
  content: "\f1d6";
}
.fa-wechat:before,
.fa-weixin:before {
  content: "\f1d7";
}
.fa-send:before,
.fa-paper-plane:before {
  content: "\f1d8";
}
.fa-send-o:before,
.fa-paper-plane-o:before {
  content: "\f1d9";
}
.fa-history:before {
  content: "\f1da";
}
.fa-circle-thin:before {
  content: "\f1db";
}
.fa-header:before {
  content: "\f1dc";
}
.fa-paragraph:before {
  content: "\f1dd";
}
.fa-sliders:before {
  content: "\f1de";
}
.fa-share-alt:before {
  content: "\f1e0";
}
.fa-share-alt-square:before {
  content: "\f1e1";
}
.fa-bomb:before {
  content: "\f1e2";
}
.fa-soccer-ball-o:before,
.fa-futbol-o:before {
  content: "\f1e3";
}
.fa-tty:before {
  content: "\f1e4";
}
.fa-binoculars:before {
  content: "\f1e5";
}
.fa-plug:before {
  content: "\f1e6";
}
.fa-slideshare:before {
  content: "\f1e7";
}
.fa-twitch:before {
  content: "\f1e8";
}
.fa-yelp:before {
  content: "\f1e9";
}
.fa-newspaper-o:before {
  content: "\f1ea";
}
.fa-wifi:before {
  content: "\f1eb";
}
.fa-calculator:before {
  content: "\f1ec";
}
.fa-paypal:before {
  content: "\f1ed";
}
.fa-google-wallet:before {
  content: "\f1ee";
}
.fa-cc-visa:before {
  content: "\f1f0";
}
.fa-cc-mastercard:before {
  content: "\f1f1";
}
.fa-cc-discover:before {
  content: "\f1f2";
}
.fa-cc-amex:before {
  content: "\f1f3";
}
.fa-cc-paypal:before {
  content: "\f1f4";
}
.fa-cc-stripe:before {
  content: "\f1f5";
}
.fa-bell-slash:before {
  content: "\f1f6";
}
.fa-bell-slash-o:before {
  content: "\f1f7";
}
.fa-trash:before {
  content: "\f1f8";
}
.fa-copyright:before {
  content: "\f1f9";
}
.fa-at:before {
  content: "\f1fa";
}
.fa-eyedropper:before {
  content: "\f1fb";
}
.fa-paint-brush:before {
  content: "\f1fc";
}
.fa-birthday-cake:before {
  content: "\f1fd";
}
.fa-area-chart:before {
  content: "\f1fe";
}
.fa-pie-chart:before {
  content: "\f200";
}
.fa-line-chart:before {
  content: "\f201";
}
.fa-lastfm:before {
  content: "\f202";
}
.fa-lastfm-square:before {
  content: "\f203";
}
.fa-toggle-off:before {
  content: "\f204";
}
.fa-toggle-on:before {
  content: "\f205";
}
.fa-bicycle:before {
  content: "\f206";
}
.fa-bus:before {
  content: "\f207";
}
.fa-ioxhost:before {
  content: "\f208";
}
.fa-angellist:before {
  content: "\f209";
}
.fa-cc:before {
  content: "\f20a";
}
.fa-shekel:before,
.fa-sheqel:before,
.fa-ils:before {
  content: "\f20b";
}
.fa-meanpath:before {
  content: "\f20c";
}
.fa-buysellads:before {
  content: "\f20d";
}
.fa-connectdevelop:before {
  content: "\f20e";
}
.fa-dashcube:before {
  content: "\f210";
}
.fa-forumbee:before {
  content: "\f211";
}
.fa-leanpub:before {
  content: "\f212";
}
.fa-sellsy:before {
  content: "\f213";
}
.fa-shirtsinbulk:before {
  content: "\f214";
}
.fa-simplybuilt:before {
  content: "\f215";
}
.fa-skyatlas:before {
  content: "\f216";
}
.fa-cart-plus:before {
  content: "\f217";
}
.fa-cart-arrow-down:before {
  content: "\f218";
}
.fa-diamond:before {
  content: "\f219";
}
.fa-ship:before {
  content: "\f21a";
}
.fa-user-secret:before {
  content: "\f21b";
}
.fa-motorcycle:before {
  content: "\f21c";
}
.fa-street-view:before {
  content: "\f21d";
}
.fa-heartbeat:before {
  content: "\f21e";
}
.fa-venus:before {
  content: "\f221";
}
.fa-mars:before {
  content: "\f222";
}
.fa-mercury:before {
  content: "\f223";
}
.fa-intersex:before,
.fa-transgender:before {
  content: "\f224";
}
.fa-transgender-alt:before {
  content: "\f225";
}
.fa-venus-double:before {
  content: "\f226";
}
.fa-mars-double:before {
  content: "\f227";
}
.fa-venus-mars:before {
  content: "\f228";
}
.fa-mars-stroke:before {
  content: "\f229";
}
.fa-mars-stroke-v:before {
  content: "\f22a";
}
.fa-mars-stroke-h:before {
  content: "\f22b";
}
.fa-neuter:before {
  content: "\f22c";
}
.fa-genderless:before {
  content: "\f22d";
}
.fa-facebook-official:before {
  content: "\f230";
}
.fa-pinterest-p:before {
  content: "\f231";
}
.fa-whatsapp:before {
  content: "\f232";
}
.fa-server:before {
  content: "\f233";
}
.fa-user-plus:before {
  content: "\f234";
}
.fa-user-times:before {
  content: "\f235";
}
.fa-hotel:before,
.fa-bed:before {
  content: "\f236";
}
.fa-viacoin:before {
  content: "\f237";
}
.fa-train:before {
  content: "\f238";
}
.fa-subway:before {
  content: "\f239";
}
.fa-medium:before {
  content: "\f23a";
}
.fa-yc:before,
.fa-y-combinator:before {
  content: "\f23b";
}
.fa-optin-monster:before {
  content: "\f23c";
}
.fa-opencart:before {
  content: "\f23d";
}
.fa-expeditedssl:before {
  content: "\f23e";
}
.fa-battery-4:before,
.fa-battery-full:before {
  content: "\f240";
}
.fa-battery-3:before,
.fa-battery-three-quarters:before {
  content: "\f241";
}
.fa-battery-2:before,
.fa-battery-half:before {
  content: "\f242";
}
.fa-battery-1:before,
.fa-battery-quarter:before {
  content: "\f243";
}
.fa-battery-0:before,
.fa-battery-empty:before {
  content: "\f244";
}
.fa-mouse-pointer:before {
  content: "\f245";
}
.fa-i-cursor:before {
  content: "\f246";
}
.fa-object-group:before {
  content: "\f247";
}
.fa-object-ungroup:before {
  content: "\f248";
}
.fa-sticky-note:before {
  content: "\f249";
}
.fa-sticky-note-o:before {
  content: "\f24a";
}
.fa-cc-jcb:before {
  content: "\f24b";
}
.fa-cc-diners-club:before {
  content: "\f24c";
}
.fa-clone:before {
  content: "\f24d";
}
.fa-balance-scale:before {
  content: "\f24e";
}
.fa-hourglass-o:before {
  content: "\f250";
}
.fa-hourglass-1:before,
.fa-hourglass-start:before {
  content: "\f251";
}
.fa-hourglass-2:before,
.fa-hourglass-half:before {
  content: "\f252";
}
.fa-hourglass-3:before,
.fa-hourglass-end:before {
  content: "\f253";
}
.fa-hourglass:before {
  content: "\f254";
}
.fa-hand-grab-o:before,
.fa-hand-rock-o:before {
  content: "\f255";
}
.fa-hand-stop-o:before,
.fa-hand-paper-o:before {
  content: "\f256";
}
.fa-hand-scissors-o:before {
  content: "\f257";
}
.fa-hand-lizard-o:before {
  content: "\f258";
}
.fa-hand-spock-o:before {
  content: "\f259";
}
.fa-hand-pointer-o:before {
  content: "\f25a";
}
.fa-hand-peace-o:before {
  content: "\f25b";
}
.fa-trademark:before {
  content: "\f25c";
}
.fa-registered:before {
  content: "\f25d";
}
.fa-creative-commons:before {
  content: "\f25e";
}
.fa-gg:before {
  content: "\f260";
}
.fa-gg-circle:before {
  content: "\f261";
}
.fa-tripadvisor:before {
  content: "\f262";
}
.fa-odnoklassniki:before {
  content: "\f263";
}
.fa-odnoklassniki-square:before {
  content: "\f264";
}
.fa-get-pocket:before {
  content: "\f265";
}
.fa-wikipedia-w:before {
  content: "\f266";
}
.fa-safari:before {
  content: "\f267";
}
.fa-chrome:before {
  content: "\f268";
}
.fa-firefox:before {
  content: "\f269";
}
.fa-opera:before {
  content: "\f26a";
}
.fa-internet-explorer:before {
  content: "\f26b";
}
.fa-tv:before,
.fa-television:before {
  content: "\f26c";
}
.fa-contao:before {
  content: "\f26d";
}
.fa-500px:before {
  content: "\f26e";
}
.fa-amazon:before {
  content: "\f270";
}
.fa-calendar-plus-o:before {
  content: "\f271";
}
.fa-calendar-minus-o:before {
  content: "\f272";
}
.fa-calendar-times-o:before {
  content: "\f273";
}
.fa-calendar-check-o:before {
  content: "\f274";
}
.fa-industry:before {
  content: "\f275";
}
.fa-map-pin:before {
  content: "\f276";
}
.fa-map-signs:before {
  content: "\f277";
}
.fa-map-o:before {
  content: "\f278";
}
.fa-map:before {
  content: "\f279";
}
.fa-commenting:before {
  content: "\f27a";
}
.fa-commenting-o:before {
  content: "\f27b";
}
.fa-houzz:before {
  content: "\f27c";
}
.fa-vimeo:before {
  content: "\f27d";
}
.fa-black-tie:before {
  content: "\f27e";
}
.fa-fonticons:before {
  content: "\f280";
}
.fa-reddit-alien:before {
  content: "\f281";
}
.fa-edge:before {
  content: "\f282";
}
.fa-credit-card-alt:before {
  content: "\f283";
}
.fa-codiepie:before {
  content: "\f284";
}
.fa-modx:before {
  content: "\f285";
}
.fa-fort-awesome:before {
  content: "\f286";
}
.fa-usb:before {
  content: "\f287";
}
.fa-product-hunt:before {
  content: "\f288";
}
.fa-mixcloud:before {
  content: "\f289";
}
.fa-scribd:before {
  content: "\f28a";
}
.fa-pause-circle:before {
  content: "\f28b";
}
.fa-pause-circle-o:before {
  content: "\f28c";
}
.fa-stop-circle:before {
  content: "\f28d";
}
.fa-stop-circle-o:before {
  content: "\f28e";
}
.fa-shopping-bag:before {
  content: "\f290";
}
.fa-shopping-basket:before {
  content: "\f291";
}
.fa-hashtag:before {
  content: "\f292";
}
.fa-bluetooth:before {
  content: "\f293";
}
.fa-bluetooth-b:before {
  content: "\f294";
}
.fa-percent:before {
  content: "\f295";
}
@font-face {
  font-family: 'themify';
  src: url('../less/icons/themify-icons/fonts/themify9f24.eot?-fvbane');
  src: url('../less/icons/themify-icons/fonts/themifyd41d.eot?#iefix-fvbane') format('embedded-opentype'), url('../less/icons/themify-icons/fonts/themify9f24.woff?-fvbane') format('woff'), url('../less/icons/themify-icons/fonts/themify9f24.ttf?-fvbane') format('truetype'), url('../less/icons/themify-icons/fonts/themify9f24.svg?-fvbane#themify') format('svg');
  font-weight: normal;
  font-style: normal;
}
[class^="ti-"],
[class*=" ti-"] {
  font-family: 'themify';
  speak: none;
  font-style: normal;
  font-weight: normal;
  font-variant: normal;
  text-transform: none;
  line-height: 1;
  /* Better Font Rendering =========== */
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
.ti-wand:before {
  content: "\e600";
}
.ti-volume:before {
  content: "\e601";
}
.ti-user:before {
  content: "\e602";
}
.ti-unlock:before {
  content: "\e603";
}
.ti-unlink:before {
  content: "\e604";
}
.ti-trash:before {
  content: "\e605";
}
.ti-thought:before {
  content: "\e606";
}
.ti-target:before {
  content: "\e607";
}
.ti-tag:before {
  content: "\e608";
}
.ti-tablet:before {
  content: "\e609";
}
.ti-star:before {
  content: "\e60a";
}
.ti-spray:before {
  content: "\e60b";
}
.ti-signal:before {
  content: "\e60c";
}
.ti-shopping-cart:before {
  content: "\e60d";
}
.ti-shopping-cart-full:before {
  content: "\e60e";
}
.ti-settings:before {
  content: "\e60f";
}
.ti-search:before {
  content: "\e610";
}
.ti-zoom-in:before {
  content: "\e611";
}
.ti-zoom-out:before {
  content: "\e612";
}
.ti-cut:before {
  content: "\e613";
}
.ti-ruler:before {
  content: "\e614";
}
.ti-ruler-pencil:before {
  content: "\e615";
}
.ti-ruler-alt:before {
  content: "\e616";
}
.ti-bookmark:before {
  content: "\e617";
}
.ti-bookmark-alt:before {
  content: "\e618";
}
.ti-reload:before {
  content: "\e619";
}
.ti-plus:before {
  content: "\e61a";
}
.ti-pin:before {
  content: "\e61b";
}
.ti-pencil:before {
  content: "\e61c";
}
.ti-pencil-alt:before {
  content: "\e61d";
}
.ti-paint-roller:before {
  content: "\e61e";
}
.ti-paint-bucket:before {
  content: "\e61f";
}
.ti-na:before {
  content: "\e620";
}
.ti-mobile:before {
  content: "\e621";
}
.ti-minus:before {
  content: "\e622";
}
.ti-medall:before {
  content: "\e623";
}
.ti-medall-alt:before {
  content: "\e624";
}
.ti-marker:before {
  content: "\e625";
}
.ti-marker-alt:before {
  content: "\e626";
}
.ti-arrow-up:before {
  content: "\e627";
}
.ti-arrow-right:before {
  content: "\e628";
}
.ti-arrow-left:before {
  content: "\e629";
}
.ti-arrow-down:before {
  content: "\e62a";
}
.ti-lock:before {
  content: "\e62b";
}
.ti-location-arrow:before {
  content: "\e62c";
}
.ti-link:before {
  content: "\e62d";
}
.ti-layout:before {
  content: "\e62e";
}
.ti-layers:before {
  content: "\e62f";
}
.ti-layers-alt:before {
  content: "\e630";
}
.ti-key:before {
  content: "\e631";
}
.ti-import:before {
  content: "\e632";
}
.ti-image:before {
  content: "\e633";
}
.ti-heart:before {
  content: "\e634";
}
.ti-heart-broken:before {
  content: "\e635";
}
.ti-hand-stop:before {
  content: "\e636";
}
.ti-hand-open:before {
  content: "\e637";
}
.ti-hand-drag:before {
  content: "\e638";
}
.ti-folder:before {
  content: "\e639";
}
.ti-flag:before {
  content: "\e63a";
}
.ti-flag-alt:before {
  content: "\e63b";
}
.ti-flag-alt-2:before {
  content: "\e63c";
}
.ti-eye:before {
  content: "\e63d";
}
.ti-export:before {
  content: "\e63e";
}
.ti-exchange-vertical:before {
  content: "\e63f";
}
.ti-desktop:before {
  content: "\e640";
}
.ti-cup:before {
  content: "\e641";
}
.ti-crown:before {
  content: "\e642";
}
.ti-comments:before {
  content: "\e643";
}
.ti-comment:before {
  content: "\e644";
}
.ti-comment-alt:before {
  content: "\e645";
}
.ti-close:before {
  content: "\e646";
}
.ti-clip:before {
  content: "\e647";
}
.ti-angle-up:before {
  content: "\e648";
}
.ti-angle-right:before {
  content: "\e649";
}
.ti-angle-left:before {
  content: "\e64a";
}
.ti-angle-down:before {
  content: "\e64b";
}
.ti-check:before {
  content: "\e64c";
}
.ti-check-box:before {
  content: "\e64d";
}
.ti-camera:before {
  content: "\e64e";
}
.ti-announcement:before {
  content: "\e64f";
}
.ti-brush:before {
  content: "\e650";
}
.ti-briefcase:before {
  content: "\e651";
}
.ti-bolt:before {
  content: "\e652";
}
.ti-bolt-alt:before {
  content: "\e653";
}
.ti-blackboard:before {
  content: "\e654";
}
.ti-bag:before {
  content: "\e655";
}
.ti-move:before {
  content: "\e656";
}
.ti-arrows-vertical:before {
  content: "\e657";
}
.ti-arrows-horizontal:before {
  content: "\e658";
}
.ti-fullscreen:before {
  content: "\e659";
}
.ti-arrow-top-right:before {
  content: "\e65a";
}
.ti-arrow-top-left:before {
  content: "\e65b";
}
.ti-arrow-circle-up:before {
  content: "\e65c";
}
.ti-arrow-circle-right:before {
  content: "\e65d";
}
.ti-arrow-circle-left:before {
  content: "\e65e";
}
.ti-arrow-circle-down:before {
  content: "\e65f";
}
.ti-angle-double-up:before {
  content: "\e660";
}
.ti-angle-double-right:before {
  content: "\e661";
}
.ti-angle-double-left:before {
  content: "\e662";
}
.ti-angle-double-down:before {
  content: "\e663";
}
.ti-zip:before {
  content: "\e664";
}
.ti-world:before {
  content: "\e665";
}
.ti-wheelchair:before {
  content: "\e666";
}
.ti-view-list:before {
  content: "\e667";
}
.ti-view-list-alt:before {
  content: "\e668";
}
.ti-view-grid:before {
  content: "\e669";
}
.ti-uppercase:before {
  content: "\e66a";
}
.ti-upload:before {
  content: "\e66b";
}
.ti-underline:before {
  content: "\e66c";
}
.ti-truck:before {
  content: "\e66d";
}
.ti-timer:before {
  content: "\e66e";
}
.ti-ticket:before {
  content: "\e66f";
}
.ti-thumb-up:before {
  content: "\e670";
}
.ti-thumb-down:before {
  content: "\e671";
}
.ti-text:before {
  content: "\e672";
}
.ti-stats-up:before {
  content: "\e673";
}
.ti-stats-down:before {
  content: "\e674";
}
.ti-split-v:before {
  content: "\e675";
}
.ti-split-h:before {
  content: "\e676";
}
.ti-smallcap:before {
  content: "\e677";
}
.ti-shine:before {
  content: "\e678";
}
.ti-shift-right:before {
  content: "\e679";
}
.ti-shift-left:before {
  content: "\e67a";
}
.ti-shield:before {
  content: "\e67b";
}
.ti-notepad:before {
  content: "\e67c";
}
.ti-server:before {
  content: "\e67d";
}
.ti-quote-right:before {
  content: "\e67e";
}
.ti-quote-left:before {
  content: "\e67f";
}
.ti-pulse:before {
  content: "\e680";
}
.ti-printer:before {
  content: "\e681";
}
.ti-power-off:before {
  content: "\e682";
}
.ti-plug:before {
  content: "\e683";
}
.ti-pie-chart:before {
  content: "\e684";
}
.ti-paragraph:before {
  content: "\e685";
}
.ti-panel:before {
  content: "\e686";
}
.ti-package:before {
  content: "\e687";
}
.ti-music:before {
  content: "\e688";
}
.ti-music-alt:before {
  content: "\e689";
}
.ti-mouse:before {
  content: "\e68a";
}
.ti-mouse-alt:before {
  content: "\e68b";
}
.ti-money:before {
  content: "\e68c";
}
.ti-microphone:before {
  content: "\e68d";
}
.ti-menu:before {
  content: "\e68e";
}
.ti-menu-alt:before {
  content: "\e68f";
}
.ti-map:before {
  content: "\e690";
}
.ti-map-alt:before {
  content: "\e691";
}
.ti-loop:before {
  content: "\e692";
}
.ti-location-pin:before {
  content: "\e693";
}
.ti-list:before {
  content: "\e694";
}
.ti-light-bulb:before {
  content: "\e695";
}
.ti-Italic:before {
  content: "\e696";
}
.ti-info:before {
  content: "\e697";
}
.ti-infinite:before {
  content: "\e698";
}
.ti-id-badge:before {
  content: "\e699";
}
.ti-hummer:before {
  content: "\e69a";
}
.ti-home:before {
  content: "\e69b";
}
.ti-help:before {
  content: "\e69c";
}
.ti-headphone:before {
  content: "\e69d";
}
.ti-harddrives:before {
  content: "\e69e";
}
.ti-harddrive:before {
  content: "\e69f";
}
.ti-gift:before {
  content: "\e6a0";
}
.ti-game:before {
  content: "\e6a1";
}
.ti-filter:before {
  content: "\e6a2";
}
.ti-files:before {
  content: "\e6a3";
}
.ti-file:before {
  content: "\e6a4";
}
.ti-eraser:before {
  content: "\e6a5";
}
.ti-envelope:before {
  content: "\e6a6";
}
.ti-download:before {
  content: "\e6a7";
}
.ti-direction:before {
  content: "\e6a8";
}
.ti-direction-alt:before {
  content: "\e6a9";
}
.ti-dashboard:before {
  content: "\e6aa";
}
.ti-control-stop:before {
  content: "\e6ab";
}
.ti-control-shuffle:before {
  content: "\e6ac";
}
.ti-control-play:before {
  content: "\e6ad";
}
.ti-control-pause:before {
  content: "\e6ae";
}
.ti-control-forward:before {
  content: "\e6af";
}
.ti-control-backward:before {
  content: "\e6b0";
}
.ti-cloud:before {
  content: "\e6b1";
}
.ti-cloud-up:before {
  content: "\e6b2";
}
.ti-cloud-down:before {
  content: "\e6b3";
}
.ti-clipboard:before {
  content: "\e6b4";
}
.ti-car:before {
  content: "\e6b5";
}
.ti-calendar:before {
  content: "\e6b6";
}
.ti-book:before {
  content: "\e6b7";
}
.ti-bell:before {
  content: "\e6b8";
}
.ti-basketball:before {
  content: "\e6b9";
}
.ti-bar-chart:before {
  content: "\e6ba";
}
.ti-bar-chart-alt:before {
  content: "\e6bb";
}
.ti-back-right:before {
  content: "\e6bc";
}
.ti-back-left:before {
  content: "\e6bd";
}
.ti-arrows-corner:before {
  content: "\e6be";
}
.ti-archive:before {
  content: "\e6bf";
}
.ti-anchor:before {
  content: "\e6c0";
}
.ti-align-right:before {
  content: "\e6c1";
}
.ti-align-left:before {
  content: "\e6c2";
}
.ti-align-justify:before {
  content: "\e6c3";
}
.ti-align-center:before {
  content: "\e6c4";
}
.ti-alert:before {
  content: "\e6c5";
}
.ti-alarm-clock:before {
  content: "\e6c6";
}
.ti-agenda:before {
  content: "\e6c7";
}
.ti-write:before {
  content: "\e6c8";
}
.ti-window:before {
  content: "\e6c9";
}
.ti-widgetized:before {
  content: "\e6ca";
}
.ti-widget:before {
  content: "\e6cb";
}
.ti-widget-alt:before {
  content: "\e6cc";
}
.ti-wallet:before {
  content: "\e6cd";
}
.ti-video-clapper:before {
  content: "\e6ce";
}
.ti-video-camera:before {
  content: "\e6cf";
}
.ti-vector:before {
  content: "\e6d0";
}
.ti-themify-logo:before {
  content: "\e6d1";
}
.ti-themify-favicon:before {
  content: "\e6d2";
}
.ti-themify-favicon-alt:before {
  content: "\e6d3";
}
.ti-support:before {
  content: "\e6d4";
}
.ti-stamp:before {
  content: "\e6d5";
}
.ti-split-v-alt:before {
  content: "\e6d6";
}
.ti-slice:before {
  content: "\e6d7";
}
.ti-shortcode:before {
  content: "\e6d8";
}
.ti-shift-right-alt:before {
  content: "\e6d9";
}
.ti-shift-left-alt:before {
  content: "\e6da";
}
.ti-ruler-alt-2:before {
  content: "\e6db";
}
.ti-receipt:before {
  content: "\e6dc";
}
.ti-pin2:before {
  content: "\e6dd";
}
.ti-pin-alt:before {
  content: "\e6de";
}
.ti-pencil-alt2:before {
  content: "\e6df";
}
.ti-palette:before {
  content: "\e6e0";
}
.ti-more:before {
  content: "\e6e1";
}
.ti-more-alt:before {
  content: "\e6e2";
}
.ti-microphone-alt:before {
  content: "\e6e3";
}
.ti-magnet:before {
  content: "\e6e4";
}
.ti-line-double:before {
  content: "\e6e5";
}
.ti-line-dotted:before {
  content: "\e6e6";
}
.ti-line-dashed:before {
  content: "\e6e7";
}
.ti-layout-width-full:before {
  content: "\e6e8";
}
.ti-layout-width-default:before {
  content: "\e6e9";
}
.ti-layout-width-default-alt:before {
  content: "\e6ea";
}
.ti-layout-tab:before {
  content: "\e6eb";
}
.ti-layout-tab-window:before {
  content: "\e6ec";
}
.ti-layout-tab-v:before {
  content: "\e6ed";
}
.ti-layout-tab-min:before {
  content: "\e6ee";
}
.ti-layout-slider:before {
  content: "\e6ef";
}
.ti-layout-slider-alt:before {
  content: "\e6f0";
}
.ti-layout-sidebar-right:before {
  content: "\e6f1";
}
.ti-layout-sidebar-none:before {
  content: "\e6f2";
}
.ti-layout-sidebar-left:before {
  content: "\e6f3";
}
.ti-layout-placeholder:before {
  content: "\e6f4";
}
.ti-layout-menu:before {
  content: "\e6f5";
}
.ti-layout-menu-v:before {
  content: "\e6f6";
}
.ti-layout-menu-separated:before {
  content: "\e6f7";
}
.ti-layout-menu-full:before {
  content: "\e6f8";
}
.ti-layout-media-right-alt:before {
  content: "\e6f9";
}
.ti-layout-media-right:before {
  content: "\e6fa";
}
.ti-layout-media-overlay:before {
  content: "\e6fb";
}
.ti-layout-media-overlay-alt:before {
  content: "\e6fc";
}
.ti-layout-media-overlay-alt-2:before {
  content: "\e6fd";
}
.ti-layout-media-left-alt:before {
  content: "\e6fe";
}
.ti-layout-media-left:before {
  content: "\e6ff";
}
.ti-layout-media-center-alt:before {
  content: "\e700";
}
.ti-layout-media-center:before {
  content: "\e701";
}
.ti-layout-list-thumb:before {
  content: "\e702";
}
.ti-layout-list-thumb-alt:before {
  content: "\e703";
}
.ti-layout-list-post:before {
  content: "\e704";
}
.ti-layout-list-large-image:before {
  content: "\e705";
}
.ti-layout-line-solid:before {
  content: "\e706";
}
.ti-layout-grid4:before {
  content: "\e707";
}
.ti-layout-grid3:before {
  content: "\e708";
}
.ti-layout-grid2:before {
  content: "\e709";
}
.ti-layout-grid2-thumb:before {
  content: "\e70a";
}
.ti-layout-cta-right:before {
  content: "\e70b";
}
.ti-layout-cta-left:before {
  content: "\e70c";
}
.ti-layout-cta-center:before {
  content: "\e70d";
}
.ti-layout-cta-btn-right:before {
  content: "\e70e";
}
.ti-layout-cta-btn-left:before {
  content: "\e70f";
}
.ti-layout-column4:before {
  content: "\e710";
}
.ti-layout-column3:before {
  content: "\e711";
}
.ti-layout-column2:before {
  content: "\e712";
}
.ti-layout-accordion-separated:before {
  content: "\e713";
}
.ti-layout-accordion-merged:before {
  content: "\e714";
}
.ti-layout-accordion-list:before {
  content: "\e715";
}
.ti-ink-pen:before {
  content: "\e716";
}
.ti-info-alt:before {
  content: "\e717";
}
.ti-help-alt:before {
  content: "\e718";
}
.ti-headphone-alt:before {
  content: "\e719";
}
.ti-hand-point-up:before {
  content: "\e71a";
}
.ti-hand-point-right:before {
  content: "\e71b";
}
.ti-hand-point-left:before {
  content: "\e71c";
}
.ti-hand-point-down:before {
  content: "\e71d";
}
.ti-gallery:before {
  content: "\e71e";
}
.ti-face-smile:before {
  content: "\e71f";
}
.ti-face-sad:before {
  content: "\e720";
}
.ti-credit-card:before {
  content: "\e721";
}
.ti-control-skip-forward:before {
  content: "\e722";
}
.ti-control-skip-backward:before {
  content: "\e723";
}
.ti-control-record:before {
  content: "\e724";
}
.ti-control-eject:before {
  content: "\e725";
}
.ti-comments-smiley:before {
  content: "\e726";
}
.ti-brush-alt:before {
  content: "\e727";
}
.ti-youtube:before {
  content: "\e728";
}
.ti-vimeo:before {
  content: "\e729";
}
.ti-twitter:before {
  content: "\e72a";
}
.ti-time:before {
  content: "\e72b";
}
.ti-tumblr:before {
  content: "\e72c";
}
.ti-skype:before {
  content: "\e72d";
}
.ti-share:before {
  content: "\e72e";
}
.ti-share-alt:before {
  content: "\e72f";
}
.ti-rocket:before {
  content: "\e730";
}
.ti-pinterest:before {
  content: "\e731";
}
.ti-new-window:before {
  content: "\e732";
}
.ti-microsoft:before {
  content: "\e733";
}
.ti-list-ol:before {
  content: "\e734";
}
.ti-linkedin:before {
  content: "\e735";
}
.ti-layout-sidebar-2:before {
  content: "\e736";
}
.ti-layout-grid4-alt:before {
  content: "\e737";
}
.ti-layout-grid3-alt:before {
  content: "\e738";
}
.ti-layout-grid2-alt:before {
  content: "\e739";
}
.ti-layout-column4-alt:before {
  content: "\e73a";
}
.ti-layout-column3-alt:before {
  content: "\e73b";
}
.ti-layout-column2-alt:before {
  content: "\e73c";
}
.ti-instagram:before {
  content: "\e73d";
}
.ti-google:before {
  content: "\e73e";
}
.ti-github:before {
  content: "\e73f";
}
.ti-flickr:before {
  content: "\e740";
}
.ti-facebook:before {
  content: "\e741";
}
.ti-dropbox:before {
  content: "\e742";
}
.ti-dribbble:before {
  content: "\e743";
}
.ti-apple:before {
  content: "\e744";
}
.ti-android:before {
  content: "\e745";
}
.ti-save:before {
  content: "\e746";
}
.ti-save-alt:before {
  content: "\e747";
}
.ti-yahoo:before {
  content: "\e748";
}
.ti-wordpress:before {
  content: "\e749";
}
.ti-vimeo-alt:before {
  content: "\e74a";
}
.ti-twitter-alt:before {
  content: "\e74b";
}
.ti-tumblr-alt:before {
  content: "\e74c";
}
.ti-trello:before {
  content: "\e74d";
}
.ti-stack-overflow:before {
  content: "\e74e";
}
.ti-soundcloud:before {
  content: "\e74f";
}
.ti-sharethis:before {
  content: "\e750";
}
.ti-sharethis-alt:before {
  content: "\e751";
}
.ti-reddit:before {
  content: "\e752";
}
.ti-pinterest-alt:before {
  content: "\e753";
}
.ti-microsoft-alt:before {
  content: "\e754";
}
.ti-linux:before {
  content: "\e755";
}
.ti-jsfiddle:before {
  content: "\e756";
}
.ti-joomla:before {
  content: "\e757";
}
.ti-html5:before {
  content: "\e758";
}
.ti-flickr-alt:before {
  content: "\e759";
}
.ti-email:before {
  content: "\e75a";
}
.ti-drupal:before {
  content: "\e75b";
}
.ti-dropbox-alt:before {
  content: "\e75c";
}
.ti-css3:before {
  content: "\e75d";
}
.ti-rss:before {
  content: "\e75e";
}
.ti-rss-alt:before {
  content: "\e75f";
}
@font-face {
  font-family: 'simple-line-icons';
  src: url('../less/icons/simple-line-icons/fonts/Simple-Line-Icons4c82.eot?-i3a2kk');
  src: url('../less/icons/simple-line-icons/fonts/Simple-Line-Iconsd41d.eot?#iefix-i3a2kk') format('embedded-opentype'), url('../less/icons/simple-line-icons/fonts/Simple-Line-Icons4c82.ttf?-i3a2kk') format('truetype'), url('../less/icons/simple-line-icons/fonts/Simple-Line-Icons4c82.html?-i3a2kk') format('woff2'), url('../less/icons/simple-line-icons/fonts/Simple-Line-Icons4c82.woff?-i3a2kk') format('woff'), url('../less/icons/simple-line-icons/fonts/Simple-Line-Icons4c82.svg?-i3a2kk#simple-line-icons') format('svg');
  font-weight: normal;
  font-style: normal;
}
/*
 Use the following CSS code if you want to have a class per icon.
 Instead of a list of all class selectors, you can use the generic [class*="icon-"] selector, but it's slower: 
*/
.icon-user,
.icon-people,
.icon-user-female,
.icon-user-follow,
.icon-user-following,
.icon-user-unfollow,
.icon-login,
.icon-logout,
.icon-emotsmile,
.icon-phone,
.icon-call-end,
.icon-call-in,
.icon-call-out,
.icon-map,
.icon-location-pin,
.icon-direction,
.icon-directions,
.icon-compass,
.icon-layers,
.icon-menu,
.icon-list,
.icon-options-vertical,
.icon-options,
.icon-arrow-down,
.icon-arrow-left,
.icon-arrow-right,
.icon-arrow-up,
.icon-arrow-up-circle,
.icon-arrow-left-circle,
.icon-arrow-right-circle,
.icon-arrow-down-circle,
.icon-check,
.icon-clock,
.icon-plus,
.icon-close,
.icon-trophy,
.icon-screen-smartphone,
.icon-screen-desktop,
.icon-plane,
.icon-notebook,
.icon-mustache,
.icon-mouse,
.icon-magnet,
.icon-energy,
.icon-disc,
.icon-cursor,
.icon-cursor-move,
.icon-crop,
.icon-chemistry,
.icon-speedometer,
.icon-shield,
.icon-screen-tablet,
.icon-magic-wand,
.icon-hourglass,
.icon-graduation,
.icon-ghost,
.icon-game-controller,
.icon-fire,
.icon-eyeglass,
.icon-envelope-open,
.icon-envelope-letter,
.icon-bell,
.icon-badge,
.icon-anchor,
.icon-wallet,
.icon-vector,
.icon-speech,
.icon-puzzle,
.icon-printer,
.icon-present,
.icon-playlist,
.icon-pin,
.icon-picture,
.icon-handbag,
.icon-globe-alt,
.icon-globe,
.icon-folder-alt,
.icon-folder,
.icon-film,
.icon-feed,
.icon-drop,
.icon-drawar,
.icon-docs,
.icon-doc,
.icon-diamond,
.icon-cup,
.icon-calculator,
.icon-bubbles,
.icon-briefcase,
.icon-book-open,
.icon-basket-loaded,
.icon-basket,
.icon-bag,
.icon-action-undo,
.icon-action-redo,
.icon-wrench,
.icon-umbrella,
.icon-trash,
.icon-tag,
.icon-support,
.icon-frame,
.icon-size-fullscreen,
.icon-size-actual,
.icon-shuffle,
.icon-share-alt,
.icon-share,
.icon-rocket,
.icon-question,
.icon-pie-chart,
.icon-pencil,
.icon-note,
.icon-loop,
.icon-home,
.icon-grid,
.icon-graph,
.icon-microphone,
.icon-music-tone-alt,
.icon-music-tone,
.icon-earphones-alt,
.icon-earphones,
.icon-equalizer,
.icon-like,
.icon-dislike,
.icon-control-start,
.icon-control-rewind,
.icon-control-play,
.icon-control-pause,
.icon-control-forward,
.icon-control-end,
.icon-volume-1,
.icon-volume-2,
.icon-volume-off,
.icon-calender,
.icon-bulb,
.icon-chart,
.icon-ban,
.icon-bubble,
.icon-camrecorder,
.icon-camera,
.icon-cloud-download,
.icon-cloud-upload,
.icon-envelope,
.icon-eye,
.icon-flag,
.icon-heart,
.icon-info,
.icon-key,
.icon-link,
.icon-lock,
.icon-lock-open,
.icon-magnifier,
.icon-magnifier-add,
.icon-magnifier-remove,
.icon-paper-clip,
.icon-paper-plane,
.icon-power,
.icon-refresh,
.icon-reload,
.icon-settings,
.icon-star,
.icon-symble-female,
.icon-symbol-male,
.icon-target,
.icon-credit-card,
.icon-paypal,
.icon-social-tumblr,
.icon-social-twitter,
.icon-social-facebook,
.icon-social-instagram,
.icon-social-linkedin,
.icon-social-pintarest,
.icon-social-github,
.icon-social-gplus,
.icon-social-reddit,
.icon-social-skype,
.icon-social-dribbble,
.icon-social-behance,
.icon-social-foursqare,
.icon-social-soundcloud,
.icon-social-spotify,
.icon-social-stumbleupon,
.icon-social-youtube,
.icon-social-dropbox {
  font-family: 'simple-line-icons';
  speak: none;
  font-style: normal;
  font-weight: normal;
  font-variant: normal;
  text-transform: none;
  line-height: 1;
  /* Better Font Rendering =========== */
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
.icon-user:before {
  content: "\e005";
}
.icon-people:before {
  content: "\e001";
}
.icon-user-female:before {
  content: "\e000";
}
.icon-user-follow:before {
  content: "\e002";
}
.icon-user-following:before {
  content: "\e003";
}
.icon-user-unfollow:before {
  content: "\e004";
}
.icon-login:before {
  content: "\e066";
}
.icon-logout:before {
  content: "\e065";
}
.icon-emotsmile:before {
  content: "\e021";
}
.icon-phone:before {
  content: "\e600";
}
.icon-call-end:before {
  content: "\e048";
}
.icon-call-in:before {
  content: "\e047";
}
.icon-call-out:before {
  content: "\e046";
}
.icon-map:before {
  content: "\e033";
}
.icon-location-pin:before {
  content: "\e096";
}
.icon-direction:before {
  content: "\e042";
}
.icon-directions:before {
  content: "\e041";
}
.icon-compass:before {
  content: "\e045";
}
.icon-layers:before {
  content: "\e034";
}
.icon-menu:before {
  content: "\e601";
}
.icon-list:before {
  content: "\e067";
}
.icon-options-vertical:before {
  content: "\e602";
}
.icon-options:before {
  content: "\e603";
}
.icon-arrow-down:before {
  content: "\e604";
}
.icon-arrow-left:before {
  content: "\e605";
}
.icon-arrow-right:before {
  content: "\e606";
}
.icon-arrow-up:before {
  content: "\e607";
}
.icon-arrow-up-circle:before {
  content: "\e078";
}
.icon-arrow-left-circle:before {
  content: "\e07a";
}
.icon-arrow-right-circle:before {
  content: "\e079";
}
.icon-arrow-down-circle:before {
  content: "\e07b";
}
.icon-check:before {
  content: "\e080";
}
.icon-clock:before {
  content: "\e081";
}
.icon-plus:before {
  content: "\e095";
}
.icon-close:before {
  content: "\e082";
}
.icon-trophy:before {
  content: "\e006";
}
.icon-screen-smartphone:before {
  content: "\e010";
}
.icon-screen-desktop:before {
  content: "\e011";
}
.icon-plane:before {
  content: "\e012";
}
.icon-notebook:before {
  content: "\e013";
}
.icon-mustache:before {
  content: "\e014";
}
.icon-mouse:before {
  content: "\e015";
}
.icon-magnet:before {
  content: "\e016";
}
.icon-energy:before {
  content: "\e020";
}
.icon-disc:before {
  content: "\e022";
}
.icon-cursor:before {
  content: "\e06e";
}
.icon-cursor-move:before {
  content: "\e023";
}
.icon-crop:before {
  content: "\e024";
}
.icon-chemistry:before {
  content: "\e026";
}
.icon-speedometer:before {
  content: "\e007";
}
.icon-shield:before {
  content: "\e00e";
}
.icon-screen-tablet:before {
  content: "\e00f";
}
.icon-magic-wand:before {
  content: "\e017";
}
.icon-hourglass:before {
  content: "\e018";
}
.icon-graduation:before {
  content: "\e019";
}
.icon-ghost:before {
  content: "\e01a";
}
.icon-game-controller:before {
  content: "\e01b";
}
.icon-fire:before {
  content: "\e01c";
}
.icon-eyeglass:before {
  content: "\e01d";
}
.icon-envelope-open:before {
  content: "\e01e";
}
.icon-envelope-letter:before {
  content: "\e01f";
}
.icon-bell:before {
  content: "\e027";
}
.icon-badge:before {
  content: "\e028";
}
.icon-anchor:before {
  content: "\e029";
}
.icon-wallet:before {
  content: "\e02a";
}
.icon-vector:before {
  content: "\e02b";
}
.icon-speech:before {
  content: "\e02c";
}
.icon-puzzle:before {
  content: "\e02d";
}
.icon-printer:before {
  content: "\e02e";
}
.icon-present:before {
  content: "\e02f";
}
.icon-playlist:before {
  content: "\e030";
}
.icon-pin:before {
  content: "\e031";
}
.icon-picture:before {
  content: "\e032";
}
.icon-handbag:before {
  content: "\e035";
}
.icon-globe-alt:before {
  content: "\e036";
}
.icon-globe:before {
  content: "\e037";
}
.icon-folder-alt:before {
  content: "\e039";
}
.icon-folder:before {
  content: "\e089";
}
.icon-film:before {
  content: "\e03a";
}
.icon-feed:before {
  content: "\e03b";
}
.icon-drop:before {
  content: "\e03e";
}
.icon-drawar:before {
  content: "\e03f";
}
.icon-docs:before {
  content: "\e040";
}
.icon-doc:before {
  content: "\e085";
}
.icon-diamond:before {
  content: "\e043";
}
.icon-cup:before {
  content: "\e044";
}
.icon-calculator:before {
  content: "\e049";
}
.icon-bubbles:before {
  content: "\e04a";
}
.icon-briefcase:before {
  content: "\e04b";
}
.icon-book-open:before {
  content: "\e04c";
}
.icon-basket-loaded:before {
  content: "\e04d";
}
.icon-basket:before {
  content: "\e04e";
}
.icon-bag:before {
  content: "\e04f";
}
.icon-action-undo:before {
  content: "\e050";
}
.icon-action-redo:before {
  content: "\e051";
}
.icon-wrench:before {
  content: "\e052";
}
.icon-umbrella:before {
  content: "\e053";
}
.icon-trash:before {
  content: "\e054";
}
.icon-tag:before {
  content: "\e055";
}
.icon-support:before {
  content: "\e056";
}
.icon-frame:before {
  content: "\e038";
}
.icon-size-fullscreen:before {
  content: "\e057";
}
.icon-size-actual:before {
  content: "\e058";
}
.icon-shuffle:before {
  content: "\e059";
}
.icon-share-alt:before {
  content: "\e05a";
}
.icon-share:before {
  content: "\e05b";
}
.icon-rocket:before {
  content: "\e05c";
}
.icon-question:before {
  content: "\e05d";
}
.icon-pie-chart:before {
  content: "\e05e";
}
.icon-pencil:before {
  content: "\e05f";
}
.icon-note:before {
  content: "\e060";
}
.icon-loop:before {
  content: "\e064";
}
.icon-home:before {
  content: "\e069";
}
.icon-grid:before {
  content: "\e06a";
}
.icon-graph:before {
  content: "\e06b";
}
.icon-microphone:before {
  content: "\e063";
}
.icon-music-tone-alt:before {
  content: "\e061";
}
.icon-music-tone:before {
  content: "\e062";
}
.icon-earphones-alt:before {
  content: "\e03c";
}
.icon-earphones:before {
  content: "\e03d";
}
.icon-equalizer:before {
  content: "\e06c";
}
.icon-like:before {
  content: "\e068";
}
.icon-dislike:before {
  content: "\e06d";
}
.icon-control-start:before {
  content: "\e06f";
}
.icon-control-rewind:before {
  content: "\e070";
}
.icon-control-play:before {
  content: "\e071";
}
.icon-control-pause:before {
  content: "\e072";
}
.icon-control-forward:before {
  content: "\e073";
}
.icon-control-end:before {
  content: "\e074";
}
.icon-volume-1:before {
  content: "\e09f";
}
.icon-volume-2:before {
  content: "\e0a0";
}
.icon-volume-off:before {
  content: "\e0a1";
}
.icon-calender:before {
  content: "\e075";
}
.icon-bulb:before {
  content: "\e076";
}
.icon-chart:before {
  content: "\e077";
}
.icon-ban:before {
  content: "\e07c";
}
.icon-bubble:before {
  content: "\e07d";
}
.icon-camrecorder:before {
  content: "\e07e";
}
.icon-camera:before {
  content: "\e07f";
}
.icon-cloud-download:before {
  content: "\e083";
}
.icon-cloud-upload:before {
  content: "\e084";
}
.icon-envelope:before {
  content: "\e086";
}
.icon-eye:before {
  content: "\e087";
}
.icon-flag:before {
  content: "\e088";
}
.icon-heart:before {
  content: "\e08a";
}
.icon-info:before {
  content: "\e08b";
}
.icon-key:before {
  content: "\e08c";
}
.icon-link:before {
  content: "\e08d";
}
.icon-lock:before {
  content: "\e08e";
}
.icon-lock-open:before {
  content: "\e08f";
}
.icon-magnifier:before {
  content: "\e090";
}
.icon-magnifier-add:before {
  content: "\e091";
}
.icon-magnifier-remove:before {
  content: "\e092";
}
.icon-paper-clip:before {
  content: "\e093";
}
.icon-paper-plane:before {
  content: "\e094";
}
.icon-power:before {
  content: "\e097";
}
.icon-refresh:before {
  content: "\e098";
}
.icon-reload:before {
  content: "\e099";
}
.icon-settings:before {
  content: "\e09a";
}
.icon-star:before {
  content: "\e09b";
}
.icon-symble-female:before {
  content: "\e09c";
}
.icon-symbol-male:before {
  content: "\e09d";
}
.icon-target:before {
  content: "\e09e";
}
.icon-credit-card:before {
  content: "\e025";
}
.icon-paypal:before {
  content: "\e608";
}
.icon-social-tumblr:before {
  content: "\e00a";
}
.icon-social-twitter:before {
  content: "\e009";
}
.icon-social-facebook:before {
  content: "\e00b";
}
.icon-social-instagram:before {
  content: "\e609";
}
.icon-social-linkedin:before {
  content: "\e60a";
}
.icon-social-pintarest:before {
  content: "\e60b";
}
.icon-social-github:before {
  content: "\e60c";
}
.icon-social-gplus:before {
  content: "\e60d";
}
.icon-social-reddit:before {
  content: "\e60e";
}
.icon-social-skype:before {
  content: "\e60f";
}
.icon-social-dribbble:before {
  content: "\e00d";
}
.icon-social-behance:before {
  content: "\e610";
}
.icon-social-foursqare:before {
  content: "\e611";
}
.icon-social-soundcloud:before {
  content: "\e612";
}
.icon-social-spotify:before {
  content: "\e613";
}
.icon-social-stumbleupon:before {
  content: "\e614";
}
.icon-social-youtube:before {
  content: "\e008";
}
.icon-social-dropbox:before {
  content: "\e00c";
}
/*!
 *  Weather Icons 2.0
 *  Updated August 1, 2015
 *  Weather themed icons for Bootstrap
 *  Author - Erik Flowers - erik@helloerik.com
 *  Email: erik@helloerik.com
 *  Twitter: http://twitter.com/Erik_UX
 *  ------------------------------------------------------------------------------
 *  Maintained at http://erikflowers.github.io/weather-icons
 *
 *  License
 *  ------------------------------------------------------------------------------
 *  - Font licensed under SIL OFL 1.1 -
 *    http://scripts.sil.org/OFL
 *  - CSS, SCSS and LESS are licensed under MIT License -
 *    http://opensource.org/licenses/mit-license.html
 *  - Documentation licensed under CC BY 3.0 -
 *    http://creativecommons.org/licenses/by/3.0/
 *  - Inspired by and works great as a companion with Font Awesome
 *    "Font Awesome by Dave Gandy - http://fontawesome.io"
 */
@font-face {
  font-family: 'weathericons';
  src: url('../less/icons/weather-icons/font/weathericons-regular-webfont.eot');
  src: url('../less/icons/weather-icons/font/weathericons-regular-webfontd41d.eot?#iefix') format('embedded-opentype'), url('../less/icons/weather-icons/font/weathericons-regular-webfont.html') format('woff2'), url('../less/icons/weather-icons/font/weathericons-regular-webfont.woff') format('woff'), url('../less/icons/weather-icons/font/weathericons-regular-webfont.ttf') format('truetype'), url('../less/icons/weather-icons/font/weathericons-regular-webfont.svg#weather_iconsregular') format('svg');
  font-weight: normal;
  font-style: normal;
}
.wi {
  display: inline-block;
  font-family: 'weathericons';
  font-style: normal;
  font-weight: normal;
  line-height: 1;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
.wi-fw {
  text-align: center;
  width: 1.4em;
}
.wi-rotate-90 {
  filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=1);
  -webkit-transform: rotate(90deg);
  -ms-transform: rotate(90deg);
  transform: rotate(90deg);
}
.wi-rotate-180 {
  filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=2);
  -webkit-transform: rotate(180deg);
  -ms-transform: rotate(180deg);
  transform: rotate(180deg);
}
.wi-rotate-270 {
  filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
  -webkit-transform: rotate(270deg);
  -ms-transform: rotate(270deg);
  transform: rotate(270deg);
}
.wi-flip-horizontal {
  filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=0, mirror=1);
  -webkit-transform: scale(-1, 1);
  -ms-transform: scale(-1, 1);
  transform: scale(-1, 1);
}
.wi-flip-vertical {
  filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=2, mirror=1);
  -webkit-transform: scale(1, -1);
  -ms-transform: scale(1, -1);
  transform: scale(1, -1);
}
.wi-day-sunny:before {
  content: "\f00d";
}
.wi-day-cloudy:before {
  content: "\f002";
}
.wi-day-cloudy-gusts:before {
  content: "\f000";
}
.wi-day-cloudy-windy:before {
  content: "\f001";
}
.wi-day-fog:before {
  content: "\f003";
}
.wi-day-hail:before {
  content: "\f004";
}
.wi-day-haze:before {
  content: "\f0b6";
}
.wi-day-lightning:before {
  content: "\f005";
}
.wi-day-rain:before {
  content: "\f008";
}
.wi-day-rain-mix:before {
  content: "\f006";
}
.wi-day-rain-wind:before {
  content: "\f007";
}
.wi-day-showers:before {
  content: "\f009";
}
.wi-day-sleet:before {
  content: "\f0b2";
}
.wi-day-sleet-storm:before {
  content: "\f068";
}
.wi-day-snow:before {
  content: "\f00a";
}
.wi-day-snow-thunderstorm:before {
  content: "\f06b";
}
.wi-day-snow-wind:before {
  content: "\f065";
}
.wi-day-sprinkle:before {
  content: "\f00b";
}
.wi-day-storm-showers:before {
  content: "\f00e";
}
.wi-day-sunny-overcast:before {
  content: "\f00c";
}
.wi-day-thunderstorm:before {
  content: "\f010";
}
.wi-day-windy:before {
  content: "\f085";
}
.wi-solar-eclipse:before {
  content: "\f06e";
}
.wi-hot:before {
  content: "\f072";
}
.wi-day-cloudy-high:before {
  content: "\f07d";
}
.wi-day-light-wind:before {
  content: "\f0c4";
}
.wi-night-clear:before {
  content: "\f02e";
}
.wi-night-alt-cloudy:before {
  content: "\f086";
}
.wi-night-alt-cloudy-gusts:before {
  content: "\f022";
}
.wi-night-alt-cloudy-windy:before {
  content: "\f023";
}
.wi-night-alt-hail:before {
  content: "\f024";
}
.wi-night-alt-lightning:before {
  content: "\f025";
}
.wi-night-alt-rain:before {
  content: "\f028";
}
.wi-night-alt-rain-mix:before {
  content: "\f026";
}
.wi-night-alt-rain-wind:before {
  content: "\f027";
}
.wi-night-alt-showers:before {
  content: "\f029";
}
.wi-night-alt-sleet:before {
  content: "\f0b4";
}
.wi-night-alt-sleet-storm:before {
  content: "\f06a";
}
.wi-night-alt-snow:before {
  content: "\f02a";
}
.wi-night-alt-snow-thunderstorm:before {
  content: "\f06d";
}
.wi-night-alt-snow-wind:before {
  content: "\f067";
}
.wi-night-alt-sprinkle:before {
  content: "\f02b";
}
.wi-night-alt-storm-showers:before {
  content: "\f02c";
}
.wi-night-alt-thunderstorm:before {
  content: "\f02d";
}
.wi-night-cloudy:before {
  content: "\f031";
}
.wi-night-cloudy-gusts:before {
  content: "\f02f";
}
.wi-night-cloudy-windy:before {
  content: "\f030";
}
.wi-night-fog:before {
  content: "\f04a";
}
.wi-night-hail:before {
  content: "\f032";
}
.wi-night-lightning:before {
  content: "\f033";
}
.wi-night-partly-cloudy:before {
  content: "\f083";
}
.wi-night-rain:before {
  content: "\f036";
}
.wi-night-rain-mix:before {
  content: "\f034";
}
.wi-night-rain-wind:before {
  content: "\f035";
}
.wi-night-showers:before {
  content: "\f037";
}
.wi-night-sleet:before {
  content: "\f0b3";
}
.wi-night-sleet-storm:before {
  content: "\f069";
}
.wi-night-snow:before {
  content: "\f038";
}
.wi-night-snow-thunderstorm:before {
  content: "\f06c";
}
.wi-night-snow-wind:before {
  content: "\f066";
}
.wi-night-sprinkle:before {
  content: "\f039";
}
.wi-night-storm-showers:before {
  content: "\f03a";
}
.wi-night-thunderstorm:before {
  content: "\f03b";
}
.wi-lunar-eclipse:before {
  content: "\f070";
}
.wi-stars:before {
  content: "\f077";
}
.wi-storm-showers:before {
  content: "\f01d";
}
.wi-thunderstorm:before {
  content: "\f01e";
}
.wi-night-alt-cloudy-high:before {
  content: "\f07e";
}
.wi-night-cloudy-high:before {
  content: "\f080";
}
.wi-night-alt-partly-cloudy:before {
  content: "\f081";
}
.wi-cloud:before {
  content: "\f041";
}
.wi-cloudy:before {
  content: "\f013";
}
.wi-cloudy-gusts:before {
  content: "\f011";
}
.wi-cloudy-windy:before {
  content: "\f012";
}
.wi-fog:before {
  content: "\f014";
}
.wi-hail:before {
  content: "\f015";
}
.wi-rain:before {
  content: "\f019";
}
.wi-rain-mix:before {
  content: "\f017";
}
.wi-rain-wind:before {
  content: "\f018";
}
.wi-showers:before {
  content: "\f01a";
}
.wi-sleet:before {
  content: "\f0b5";
}
.wi-snow:before {
  content: "\f01b";
}
.wi-sprinkle:before {
  content: "\f01c";
}
.wi-storm-showers:before {
  content: "\f01d";
}
.wi-thunderstorm:before {
  content: "\f01e";
}
.wi-snow-wind:before {
  content: "\f064";
}
.wi-snow:before {
  content: "\f01b";
}
.wi-smog:before {
  content: "\f074";
}
.wi-smoke:before {
  content: "\f062";
}
.wi-lightning:before {
  content: "\f016";
}
.wi-raindrops:before {
  content: "\f04e";
}
.wi-raindrop:before {
  content: "\f078";
}
.wi-dust:before {
  content: "\f063";
}
.wi-snowflake-cold:before {
  content: "\f076";
}
.wi-windy:before {
  content: "\f021";
}
.wi-strong-wind:before {
  content: "\f050";
}
.wi-sandstorm:before {
  content: "\f082";
}
.wi-earthquake:before {
  content: "\f0c6";
}
.wi-fire:before {
  content: "\f0c7";
}
.wi-flood:before {
  content: "\f07c";
}
.wi-meteor:before {
  content: "\f071";
}
.wi-tsunami:before {
  content: "\f0c5";
}
.wi-volcano:before {
  content: "\f0c8";
}
.wi-hurricane:before {
  content: "\f073";
}
.wi-tornado:before {
  content: "\f056";
}
.wi-small-craft-advisory:before {
  content: "\f0cc";
}
.wi-gale-warning:before {
  content: "\f0cd";
}
.wi-storm-warning:before {
  content: "\f0ce";
}
.wi-hurricane-warning:before {
  content: "\f0cf";
}
.wi-wind-direction:before {
  content: "\f0b1";
}
.wi-alien:before {
  content: "\f075";
}
.wi-celsius:before {
  content: "\f03c";
}
.wi-fahrenheit:before {
  content: "\f045";
}
.wi-degrees:before {
  content: "\f042";
}
.wi-thermometer:before {
  content: "\f055";
}
.wi-thermometer-exterior:before {
  content: "\f053";
}
.wi-thermometer-internal:before {
  content: "\f054";
}
.wi-cloud-down:before {
  content: "\f03d";
}
.wi-cloud-up:before {
  content: "\f040";
}
.wi-cloud-refresh:before {
  content: "\f03e";
}
.wi-horizon:before {
  content: "\f047";
}
.wi-horizon-alt:before {
  content: "\f046";
}
.wi-sunrise:before {
  content: "\f051";
}
.wi-sunset:before {
  content: "\f052";
}
.wi-moonrise:before {
  content: "\f0c9";
}
.wi-moonset:before {
  content: "\f0ca";
}
.wi-refresh:before {
  content: "\f04c";
}
.wi-refresh-alt:before {
  content: "\f04b";
}
.wi-umbrella:before {
  content: "\f084";
}
.wi-barometer:before {
  content: "\f079";
}
.wi-humidity:before {
  content: "\f07a";
}
.wi-na:before {
  content: "\f07b";
}
.wi-train:before {
  content: "\f0cb";
}
.wi-moon-new:before {
  content: "\f095";
}
.wi-moon-waxing-cresent-1:before {
  content: "\f096";
}
.wi-moon-waxing-cresent-2:before {
  content: "\f097";
}
.wi-moon-waxing-cresent-3:before {
  content: "\f098";
}
.wi-moon-waxing-cresent-4:before {
  content: "\f099";
}
.wi-moon-waxing-cresent-5:before {
  content: "\f09a";
}
.wi-moon-waxing-cresent-6:before {
  content: "\f09b";
}
.wi-moon-first-quarter:before {
  content: "\f09c";
}
.wi-moon-waxing-gibbous-1:before {
  content: "\f09d";
}
.wi-moon-waxing-gibbous-2:before {
  content: "\f09e";
}
.wi-moon-waxing-gibbous-3:before {
  content: "\f09f";
}
.wi-moon-waxing-gibbous-4:before {
  content: "\f0a0";
}
.wi-moon-waxing-gibbous-5:before {
  content: "\f0a1";
}
.wi-moon-waxing-gibbous-6:before {
  content: "\f0a2";
}
.wi-moon-full:before {
  content: "\f0a3";
}
.wi-moon-waning-gibbous-1:before {
  content: "\f0a4";
}
.wi-moon-waning-gibbous-2:before {
  content: "\f0a5";
}
.wi-moon-waning-gibbous-3:before {
  content: "\f0a6";
}
.wi-moon-waning-gibbous-4:before {
  content: "\f0a7";
}
.wi-moon-waning-gibbous-5:before {
  content: "\f0a8";
}
.wi-moon-waning-gibbous-6:before {
  content: "\f0a9";
}
.wi-moon-third-quarter:before {
  content: "\f0aa";
}
.wi-moon-waning-crescent-1:before {
  content: "\f0ab";
}
.wi-moon-waning-crescent-2:before {
  content: "\f0ac";
}
.wi-moon-waning-crescent-3:before {
  content: "\f0ad";
}
.wi-moon-waning-crescent-4:before {
  content: "\f0ae";
}
.wi-moon-waning-crescent-5:before {
  content: "\f0af";
}
.wi-moon-waning-crescent-6:before {
  content: "\f0b0";
}
.wi-moon-alt-new:before {
  content: "\f0eb";
}
.wi-moon-alt-waxing-cresent-1:before {
  content: "\f0d0";
}
.wi-moon-alt-waxing-cresent-2:before {
  content: "\f0d1";
}
.wi-moon-alt-waxing-cresent-3:before {
  content: "\f0d2";
}
.wi-moon-alt-waxing-cresent-4:before {
  content: "\f0d3";
}
.wi-moon-alt-waxing-cresent-5:before {
  content: "\f0d4";
}
.wi-moon-alt-waxing-cresent-6:before {
  content: "\f0d5";
}
.wi-moon-alt-first-quarter:before {
  content: "\f0d6";
}
.wi-moon-alt-waxing-gibbous-1:before {
  content: "\f0d7";
}
.wi-moon-alt-waxing-gibbous-2:before {
  content: "\f0d8";
}
.wi-moon-alt-waxing-gibbous-3:before {
  content: "\f0d9";
}
.wi-moon-alt-waxing-gibbous-4:before {
  content: "\f0da";
}
.wi-moon-alt-waxing-gibbous-5:before {
  content: "\f0db";
}
.wi-moon-alt-waxing-gibbous-6:before {
  content: "\f0dc";
}
.wi-moon-alt-full:before {
  content: "\f0dd";
}
.wi-moon-alt-waning-gibbous-1:before {
  content: "\f0de";
}
.wi-moon-alt-waning-gibbous-2:before {
  content: "\f0df";
}
.wi-moon-alt-waning-gibbous-3:before {
  content: "\f0e0";
}
.wi-moon-alt-waning-gibbous-4:before {
  content: "\f0e1";
}
.wi-moon-alt-waning-gibbous-5:before {
  content: "\f0e2";
}
.wi-moon-alt-waning-gibbous-6:before {
  content: "\f0e3";
}
.wi-moon-alt-third-quarter:before {
  content: "\f0e4";
}
.wi-moon-alt-waning-crescent-1:before {
  content: "\f0e5";
}
.wi-moon-alt-waning-crescent-2:before {
  content: "\f0e6";
}
.wi-moon-alt-waning-crescent-3:before {
  content: "\f0e7";
}
.wi-moon-alt-waning-crescent-4:before {
  content: "\f0e8";
}
.wi-moon-alt-waning-crescent-5:before {
  content: "\f0e9";
}
.wi-moon-alt-waning-crescent-6:before {
  content: "\f0ea";
}
.wi-moon-0:before {
  content: "\f095";
}
.wi-moon-1:before {
  content: "\f096";
}
.wi-moon-2:before {
  content: "\f097";
}
.wi-moon-3:before {
  content: "\f098";
}
.wi-moon-4:before {
  content: "\f099";
}
.wi-moon-5:before {
  content: "\f09a";
}
.wi-moon-6:before {
  content: "\f09b";
}
.wi-moon-7:before {
  content: "\f09c";
}
.wi-moon-8:before {
  content: "\f09d";
}
.wi-moon-9:before {
  content: "\f09e";
}
.wi-moon-10:before {
  content: "\f09f";
}
.wi-moon-11:before {
  content: "\f0a0";
}
.wi-moon-12:before {
  content: "\f0a1";
}
.wi-moon-13:before {
  content: "\f0a2";
}
.wi-moon-14:before {
  content: "\f0a3";
}
.wi-moon-15:before {
  content: "\f0a4";
}
.wi-moon-16:before {
  content: "\f0a5";
}
.wi-moon-17:before {
  content: "\f0a6";
}
.wi-moon-18:before {
  content: "\f0a7";
}
.wi-moon-19:before {
  content: "\f0a8";
}
.wi-moon-20:before {
  content: "\f0a9";
}
.wi-moon-21:before {
  content: "\f0aa";
}
.wi-moon-22:before {
  content: "\f0ab";
}
.wi-moon-23:before {
  content: "\f0ac";
}
.wi-moon-24:before {
  content: "\f0ad";
}
.wi-moon-25:before {
  content: "\f0ae";
}
.wi-moon-26:before {
  content: "\f0af";
}
.wi-moon-27:before {
  content: "\f0b0";
}
.wi-time-1:before {
  content: "\f08a";
}
.wi-time-2:before {
  content: "\f08b";
}
.wi-time-3:before {
  content: "\f08c";
}
.wi-time-4:before {
  content: "\f08d";
}
.wi-time-5:before {
  content: "\f08e";
}
.wi-time-6:before {
  content: "\f08f";
}
.wi-time-7:before {
  content: "\f090";
}
.wi-time-8:before {
  content: "\f091";
}
.wi-time-9:before {
  content: "\f092";
}
.wi-time-10:before {
  content: "\f093";
}
.wi-time-11:before {
  content: "\f094";
}
.wi-time-12:before {
  content: "\f089";
}
.wi-direction-up:before {
  content: "\f058";
}
.wi-direction-up-right:before {
  content: "\f057";
}
.wi-direction-right:before {
  content: "\f04d";
}
.wi-direction-down-right:before {
  content: "\f088";
}
.wi-direction-down:before {
  content: "\f044";
}
.wi-direction-down-left:before {
  content: "\f043";
}
.wi-direction-left:before {
  content: "\f048";
}
.wi-direction-up-left:before {
  content: "\f087";
}
.wi-wind-beaufort-0:before {
  content: "\f0b7";
}
.wi-wind-beaufort-1:before {
  content: "\f0b8";
}
.wi-wind-beaufort-2:before {
  content: "\f0b9";
}
.wi-wind-beaufort-3:before {
  content: "\f0ba";
}
.wi-wind-beaufort-4:before {
  content: "\f0bb";
}
.wi-wind-beaufort-5:before {
  content: "\f0bc";
}
.wi-wind-beaufort-6:before {
  content: "\f0bd";
}
.wi-wind-beaufort-7:before {
  content: "\f0be";
}
.wi-wind-beaufort-8:before {
  content: "\f0bf";
}
.wi-wind-beaufort-9:before {
  content: "\f0c0";
}
.wi-wind-beaufort-10:before {
  content: "\f0c1";
}
.wi-wind-beaufort-11:before {
  content: "\f0c2";
}
.wi-wind-beaufort-12:before {
  content: "\f0c3";
}
.wi-yahoo-0:before {
  content: "\f056";
}
.wi-yahoo-1:before {
  content: "\f00e";
}
.wi-yahoo-2:before {
  content: "\f073";
}
.wi-yahoo-3:before {
  content: "\f01e";
}
.wi-yahoo-4:before {
  content: "\f01e";
}
.wi-yahoo-5:before {
  content: "\f017";
}
.wi-yahoo-6:before {
  content: "\f017";
}
.wi-yahoo-7:before {
  content: "\f017";
}
.wi-yahoo-8:before {
  content: "\f015";
}
.wi-yahoo-9:before {
  content: "\f01a";
}
.wi-yahoo-10:before {
  content: "\f015";
}
.wi-yahoo-11:before {
  content: "\f01a";
}
.wi-yahoo-12:before {
  content: "\f01a";
}
.wi-yahoo-13:before {
  content: "\f01b";
}
.wi-yahoo-14:before {
  content: "\f00a";
}
.wi-yahoo-15:before {
  content: "\f064";
}
.wi-yahoo-16:before {
  content: "\f01b";
}
.wi-yahoo-17:before {
  content: "\f015";
}
.wi-yahoo-18:before {
  content: "\f017";
}
.wi-yahoo-19:before {
  content: "\f063";
}
.wi-yahoo-20:before {
  content: "\f014";
}
.wi-yahoo-21:before {
  content: "\f021";
}
.wi-yahoo-22:before {
  content: "\f062";
}
.wi-yahoo-23:before {
  content: "\f050";
}
.wi-yahoo-24:before {
  content: "\f050";
}
.wi-yahoo-25:before {
  content: "\f076";
}
.wi-yahoo-26:before {
  content: "\f013";
}
.wi-yahoo-27:before {
  content: "\f031";
}
.wi-yahoo-28:before {
  content: "\f002";
}
.wi-yahoo-29:before {
  content: "\f031";
}
.wi-yahoo-30:before {
  content: "\f002";
}
.wi-yahoo-31:before {
  content: "\f02e";
}
.wi-yahoo-32:before {
  content: "\f00d";
}
.wi-yahoo-33:before {
  content: "\f083";
}
.wi-yahoo-34:before {
  content: "\f00c";
}
.wi-yahoo-35:before {
  content: "\f017";
}
.wi-yahoo-36:before {
  content: "\f072";
}
.wi-yahoo-37:before {
  content: "\f00e";
}
.wi-yahoo-38:before {
  content: "\f00e";
}
.wi-yahoo-39:before {
  content: "\f00e";
}
.wi-yahoo-40:before {
  content: "\f01a";
}
.wi-yahoo-41:before {
  content: "\f064";
}
.wi-yahoo-42:before {
  content: "\f01b";
}
.wi-yahoo-43:before {
  content: "\f064";
}
.wi-yahoo-44:before {
  content: "\f00c";
}
.wi-yahoo-45:before {
  content: "\f00e";
}
.wi-yahoo-46:before {
  content: "\f01b";
}
.wi-yahoo-47:before {
  content: "\f00e";
}
.wi-yahoo-3200:before {
  content: "\f077";
}
.wi-forecast-io-clear-day:before {
  content: "\f00d";
}
.wi-forecast-io-clear-night:before {
  content: "\f02e";
}
.wi-forecast-io-rain:before {
  content: "\f019";
}
.wi-forecast-io-snow:before {
  content: "\f01b";
}
.wi-forecast-io-sleet:before {
  content: "\f0b5";
}
.wi-forecast-io-wind:before {
  content: "\f050";
}
.wi-forecast-io-fog:before {
  content: "\f014";
}
.wi-forecast-io-cloudy:before {
  content: "\f013";
}
.wi-forecast-io-partly-cloudy-day:before {
  content: "\f002";
}
.wi-forecast-io-partly-cloudy-night:before {
  content: "\f031";
}
.wi-forecast-io-hail:before {
  content: "\f015";
}
.wi-forecast-io-thunderstorm:before {
  content: "\f01e";
}
.wi-forecast-io-tornado:before {
  content: "\f056";
}
.wi-wmo4680-0:before,
.wi-wmo4680-00:before {
  content: "\f055";
}
.wi-wmo4680-1:before,
.wi-wmo4680-01:before {
  content: "\f013";
}
.wi-wmo4680-2:before,
.wi-wmo4680-02:before {
  content: "\f055";
}
.wi-wmo4680-3:before,
.wi-wmo4680-03:before {
  content: "\f013";
}
.wi-wmo4680-4:before,
.wi-wmo4680-04:before {
  content: "\f014";
}
.wi-wmo4680-5:before,
.wi-wmo4680-05:before {
  content: "\f014";
}
.wi-wmo4680-10:before {
  content: "\f014";
}
.wi-wmo4680-11:before {
  content: "\f014";
}
.wi-wmo4680-12:before {
  content: "\f016";
}
.wi-wmo4680-18:before {
  content: "\f050";
}
.wi-wmo4680-20:before {
  content: "\f014";
}
.wi-wmo4680-21:before {
  content: "\f017";
}
.wi-wmo4680-22:before {
  content: "\f017";
}
.wi-wmo4680-23:before {
  content: "\f019";
}
.wi-wmo4680-24:before {
  content: "\f01b";
}
.wi-wmo4680-25:before {
  content: "\f015";
}
.wi-wmo4680-26:before {
  content: "\f01e";
}
.wi-wmo4680-27:before {
  content: "\f063";
}
.wi-wmo4680-28:before {
  content: "\f063";
}
.wi-wmo4680-29:before {
  content: "\f063";
}
.wi-wmo4680-30:before {
  content: "\f014";
}
.wi-wmo4680-31:before {
  content: "\f014";
}
.wi-wmo4680-32:before {
  content: "\f014";
}
.wi-wmo4680-33:before {
  content: "\f014";
}
.wi-wmo4680-34:before {
  content: "\f014";
}
.wi-wmo4680-35:before {
  content: "\f014";
}
.wi-wmo4680-40:before {
  content: "\f017";
}
.wi-wmo4680-41:before {
  content: "\f01c";
}
.wi-wmo4680-42:before {
  content: "\f019";
}
.wi-wmo4680-43:before {
  content: "\f01c";
}
.wi-wmo4680-44:before {
  content: "\f019";
}
.wi-wmo4680-45:before {
  content: "\f015";
}
.wi-wmo4680-46:before {
  content: "\f015";
}
.wi-wmo4680-47:before {
  content: "\f01b";
}
.wi-wmo4680-48:before {
  content: "\f01b";
}
.wi-wmo4680-50:before {
  content: "\f01c";
}
.wi-wmo4680-51:before {
  content: "\f01c";
}
.wi-wmo4680-52:before {
  content: "\f019";
}
.wi-wmo4680-53:before {
  content: "\f019";
}
.wi-wmo4680-54:before {
  content: "\f076";
}
.wi-wmo4680-55:before {
  content: "\f076";
}
.wi-wmo4680-56:before {
  content: "\f076";
}
.wi-wmo4680-57:before {
  content: "\f01c";
}
.wi-wmo4680-58:before {
  content: "\f019";
}
.wi-wmo4680-60:before {
  content: "\f01c";
}
.wi-wmo4680-61:before {
  content: "\f01c";
}
.wi-wmo4680-62:before {
  content: "\f019";
}
.wi-wmo4680-63:before {
  content: "\f019";
}
.wi-wmo4680-64:before {
  content: "\f015";
}
.wi-wmo4680-65:before {
  content: "\f015";
}
.wi-wmo4680-66:before {
  content: "\f015";
}
.wi-wmo4680-67:before {
  content: "\f017";
}
.wi-wmo4680-68:before {
  content: "\f017";
}
.wi-wmo4680-70:before {
  content: "\f01b";
}
.wi-wmo4680-71:before {
  content: "\f01b";
}
.wi-wmo4680-72:before {
  content: "\f01b";
}
.wi-wmo4680-73:before {
  content: "\f01b";
}
.wi-wmo4680-74:before {
  content: "\f076";
}
.wi-wmo4680-75:before {
  content: "\f076";
}
.wi-wmo4680-76:before {
  content: "\f076";
}
.wi-wmo4680-77:before {
  content: "\f01b";
}
.wi-wmo4680-78:before {
  content: "\f076";
}
.wi-wmo4680-80:before {
  content: "\f019";
}
.wi-wmo4680-81:before {
  content: "\f01c";
}
.wi-wmo4680-82:before {
  content: "\f019";
}
.wi-wmo4680-83:before {
  content: "\f019";
}
.wi-wmo4680-84:before {
  content: "\f01d";
}
.wi-wmo4680-85:before {
  content: "\f017";
}
.wi-wmo4680-86:before {
  content: "\f017";
}
.wi-wmo4680-87:before {
  content: "\f017";
}
.wi-wmo4680-89:before {
  content: "\f015";
}
.wi-wmo4680-90:before {
  content: "\f016";
}
.wi-wmo4680-91:before {
  content: "\f01d";
}
.wi-wmo4680-92:before {
  content: "\f01e";
}
.wi-wmo4680-93:before {
  content: "\f01e";
}
.wi-wmo4680-94:before {
  content: "\f016";
}
.wi-wmo4680-95:before {
  content: "\f01e";
}
.wi-wmo4680-96:before {
  content: "\f01e";
}
.wi-wmo4680-99:before {
  content: "\f056";
}
.wi-owm-200:before {
  content: "\f01e";
}
.wi-owm-201:before {
  content: "\f01e";
}
.wi-owm-202:before {
  content: "\f01e";
}
.wi-owm-210:before {
  content: "\f016";
}
.wi-owm-211:before {
  content: "\f016";
}
.wi-owm-212:before {
  content: "\f016";
}
.wi-owm-221:before {
  content: "\f016";
}
.wi-owm-230:before {
  content: "\f01e";
}
.wi-owm-231:before {
  content: "\f01e";
}
.wi-owm-232:before {
  content: "\f01e";
}
.wi-owm-300:before {
  content: "\f01c";
}
.wi-owm-301:before {
  content: "\f01c";
}
.wi-owm-302:before {
  content: "\f019";
}
.wi-owm-310:before {
  content: "\f017";
}
.wi-owm-311:before {
  content: "\f019";
}
.wi-owm-312:before {
  content: "\f019";
}
.wi-owm-313:before {
  content: "\f01a";
}
.wi-owm-314:before {
  content: "\f019";
}
.wi-owm-321:before {
  content: "\f01c";
}
.wi-owm-500:before {
  content: "\f01c";
}
.wi-owm-501:before {
  content: "\f019";
}
.wi-owm-502:before {
  content: "\f019";
}
.wi-owm-503:before {
  content: "\f019";
}
.wi-owm-504:before {
  content: "\f019";
}
.wi-owm-511:before {
  content: "\f017";
}
.wi-owm-520:before {
  content: "\f01a";
}
.wi-owm-521:before {
  content: "\f01a";
}
.wi-owm-522:before {
  content: "\f01a";
}
.wi-owm-531:before {
  content: "\f01d";
}
.wi-owm-600:before {
  content: "\f01b";
}
.wi-owm-601:before {
  content: "\f01b";
}
.wi-owm-602:before {
  content: "\f0b5";
}
.wi-owm-611:before {
  content: "\f017";
}
.wi-owm-612:before {
  content: "\f017";
}
.wi-owm-615:before {
  content: "\f017";
}
.wi-owm-616:before {
  content: "\f017";
}
.wi-owm-620:before {
  content: "\f017";
}
.wi-owm-621:before {
  content: "\f01b";
}
.wi-owm-622:before {
  content: "\f01b";
}
.wi-owm-701:before {
  content: "\f01a";
}
.wi-owm-711:before {
  content: "\f062";
}
.wi-owm-721:before {
  content: "\f0b6";
}
.wi-owm-731:before {
  content: "\f063";
}
.wi-owm-741:before {
  content: "\f014";
}
.wi-owm-761:before {
  content: "\f063";
}
.wi-owm-762:before {
  content: "\f063";
}
.wi-owm-771:before {
  content: "\f011";
}
.wi-owm-781:before {
  content: "\f056";
}
.wi-owm-800:before {
  content: "\f00d";
}
.wi-owm-801:before {
  content: "\f011";
}
.wi-owm-802:before {
  content: "\f011";
}
.wi-owm-803:before {
  content: "\f011";
}
.wi-owm-803:before {
  content: "\f012";
}
.wi-owm-804:before {
  content: "\f013";
}
.wi-owm-900:before {
  content: "\f056";
}
.wi-owm-901:before {
  content: "\f01d";
}
.wi-owm-902:before {
  content: "\f073";
}
.wi-owm-903:before {
  content: "\f076";
}
.wi-owm-904:before {
  content: "\f072";
}
.wi-owm-905:before {
  content: "\f021";
}
.wi-owm-906:before {
  content: "\f015";
}
.wi-owm-957:before {
  content: "\f050";
}
.wi-owm-day-200:before {
  content: "\f010";
}
.wi-owm-day-201:before {
  content: "\f010";
}
.wi-owm-day-202:before {
  content: "\f010";
}
.wi-owm-day-210:before {
  content: "\f005";
}
.wi-owm-day-211:before {
  content: "\f005";
}
.wi-owm-day-212:before {
  content: "\f005";
}
.wi-owm-day-221:before {
  content: "\f005";
}
.wi-owm-day-230:before {
  content: "\f010";
}
.wi-owm-day-231:before {
  content: "\f010";
}
.wi-owm-day-232:before {
  content: "\f010";
}
.wi-owm-day-300:before {
  content: "\f00b";
}
.wi-owm-day-301:before {
  content: "\f00b";
}
.wi-owm-day-302:before {
  content: "\f008";
}
.wi-owm-day-310:before {
  content: "\f008";
}
.wi-owm-day-311:before {
  content: "\f008";
}
.wi-owm-day-312:before {
  content: "\f008";
}
.wi-owm-day-313:before {
  content: "\f008";
}
.wi-owm-day-314:before {
  content: "\f008";
}
.wi-owm-day-321:before {
  content: "\f00b";
}
.wi-owm-day-500:before {
  content: "\f00b";
}
.wi-owm-day-501:before {
  content: "\f008";
}
.wi-owm-day-502:before {
  content: "\f008";
}
.wi-owm-day-503:before {
  content: "\f008";
}
.wi-owm-day-504:before {
  content: "\f008";
}
.wi-owm-day-511:before {
  content: "\f006";
}
.wi-owm-day-520:before {
  content: "\f009";
}
.wi-owm-day-521:before {
  content: "\f009";
}
.wi-owm-day-522:before {
  content: "\f009";
}
.wi-owm-day-531:before {
  content: "\f00e";
}
.wi-owm-day-600:before {
  content: "\f00a";
}
.wi-owm-day-601:before {
  content: "\f0b2";
}
.wi-owm-day-602:before {
  content: "\f00a";
}
.wi-owm-day-611:before {
  content: "\f006";
}
.wi-owm-day-612:before {
  content: "\f006";
}
.wi-owm-day-615:before {
  content: "\f006";
}
.wi-owm-day-616:before {
  content: "\f006";
}
.wi-owm-day-620:before {
  content: "\f006";
}
.wi-owm-day-621:before {
  content: "\f00a";
}
.wi-owm-day-622:before {
  content: "\f00a";
}
.wi-owm-day-701:before {
  content: "\f009";
}
.wi-owm-day-711:before {
  content: "\f062";
}
.wi-owm-day-721:before {
  content: "\f0b6";
}
.wi-owm-day-731:before {
  content: "\f063";
}
.wi-owm-day-741:before {
  content: "\f003";
}
.wi-owm-day-761:before {
  content: "\f063";
}
.wi-owm-day-762:before {
  content: "\f063";
}
.wi-owm-day-781:before {
  content: "\f056";
}
.wi-owm-day-800:before {
  content: "\f00d";
}
.wi-owm-day-801:before {
  content: "\f000";
}
.wi-owm-day-802:before {
  content: "\f000";
}
.wi-owm-day-803:before {
  content: "\f000";
}
.wi-owm-day-804:before {
  content: "\f00c";
}
.wi-owm-day-900:before {
  content: "\f056";
}
.wi-owm-day-902:before {
  content: "\f073";
}
.wi-owm-day-903:before {
  content: "\f076";
}
.wi-owm-day-904:before {
  content: "\f072";
}
.wi-owm-day-906:before {
  content: "\f004";
}
.wi-owm-day-957:before {
  content: "\f050";
}
.wi-owm-night-200:before {
  content: "\f02d";
}
.wi-owm-night-201:before {
  content: "\f02d";
}
.wi-owm-night-202:before {
  content: "\f02d";
}
.wi-owm-night-210:before {
  content: "\f025";
}
.wi-owm-night-211:before {
  content: "\f025";
}
.wi-owm-night-212:before {
  content: "\f025";
}
.wi-owm-night-221:before {
  content: "\f025";
}
.wi-owm-night-230:before {
  content: "\f02d";
}
.wi-owm-night-231:before {
  content: "\f02d";
}
.wi-owm-night-232:before {
  content: "\f02d";
}
.wi-owm-night-300:before {
  content: "\f02b";
}
.wi-owm-night-301:before {
  content: "\f02b";
}
.wi-owm-night-302:before {
  content: "\f028";
}
.wi-owm-night-310:before {
  content: "\f028";
}
.wi-owm-night-311:before {
  content: "\f028";
}
.wi-owm-night-312:before {
  content: "\f028";
}
.wi-owm-night-313:before {
  content: "\f028";
}
.wi-owm-night-314:before {
  content: "\f028";
}
.wi-owm-night-321:before {
  content: "\f02b";
}
.wi-owm-night-500:before {
  content: "\f02b";
}
.wi-owm-night-501:before {
  content: "\f028";
}
.wi-owm-night-502:before {
  content: "\f028";
}
.wi-owm-night-503:before {
  content: "\f028";
}
.wi-owm-night-504:before {
  content: "\f028";
}
.wi-owm-night-511:before {
  content: "\f026";
}
.wi-owm-night-520:before {
  content: "\f029";
}
.wi-owm-night-521:before {
  content: "\f029";
}
.wi-owm-night-522:before {
  content: "\f029";
}
.wi-owm-night-531:before {
  content: "\f02c";
}
.wi-owm-night-600:before {
  content: "\f02a";
}
.wi-owm-night-601:before {
  content: "\f0b4";
}
.wi-owm-night-602:before {
  content: "\f02a";
}
.wi-owm-night-611:before {
  content: "\f026";
}
.wi-owm-night-612:before {
  content: "\f026";
}
.wi-owm-night-615:before {
  content: "\f026";
}
.wi-owm-night-616:before {
  content: "\f026";
}
.wi-owm-night-620:before {
  content: "\f026";
}
.wi-owm-night-621:before {
  content: "\f02a";
}
.wi-owm-night-622:before {
  content: "\f02a";
}
.wi-owm-night-701:before {
  content: "\f029";
}
.wi-owm-night-711:before {
  content: "\f062";
}
.wi-owm-night-721:before {
  content: "\f0b6";
}
.wi-owm-night-731:before {
  content: "\f063";
}
.wi-owm-night-741:before {
  content: "\f04a";
}
.wi-owm-night-761:before {
  content: "\f063";
}
.wi-owm-night-762:before {
  content: "\f063";
}
.wi-owm-night-781:before {
  content: "\f056";
}
.wi-owm-night-800:before {
  content: "\f02e";
}
.wi-owm-night-801:before {
  content: "\f022";
}
.wi-owm-night-802:before {
  content: "\f022";
}
.wi-owm-night-803:before {
  content: "\f022";
}
.wi-owm-night-804:before {
  content: "\f086";
}
.wi-owm-night-900:before {
  content: "\f056";
}
.wi-owm-night-902:before {
  content: "\f073";
}
.wi-owm-night-903:before {
  content: "\f076";
}
.wi-owm-night-904:before {
  content: "\f072";
}
.wi-owm-night-906:before {
  content: "\f024";
}
.wi-owm-night-957:before {
  content: "\f050";
}
.glyphs.character-mapping {
  margin: 0 0 20px 0;
  padding: 20px 0 20px 30px;
  color: rgba(0, 0, 0, 0.5);
  border: 1px solid #d8e0e5;
  -webkit-border-radius: 3px;
  border-radius: 3px;
}
.glyphs.character-mapping li {
  margin: 0 30px 20px 0;
  display: inline-block;
  width: 90px;
  text-align: center;
  font-size: 24px;
  color: #263238;
}
.linea-icon {
  position: relative;
}
.linea-icon svg {
  fill: #000;
}
.glyphs.character-mapping input {
  margin: 0;
  padding: 5px 0;
  line-height: 12px;
  font-size: 12px;
  display: block;
  width: 100%;
  border: 1px solid #d8e0e5;
  text-align: center;
  outline: 0;
}
.glyphs.character-mapping input:focus {
  border: 1px solid #fbde4a;
  -webkit-box-shadow: inset 0 0 3px #fbde4a;
  box-shadow: inset 0 0 3px #fbde4a;
}
.glyphs.character-mapping input:hover {
  -webkit-box-shadow: inset 0 0 3px #fbde4a;
  box-shadow: inset 0 0 3px #fbde4a;
}
@font-face {
  font-family: "linea-arrows-10";
  src: url("../less/icons/linea-icons/fonts/linea-arrows-10.eot");
  src: url("../less/icons/linea-icons/fonts/linea-arrows-10d41d.eot?#iefix") format("embedded-opentype"), url("../less/icons/linea-icons/fonts/linea-arrows-10.woff") format("woff"), url("../less/icons/linea-icons/fonts/linea-arrows-10.ttf") format("truetype"), url("../less/icons/linea-icons/fonts/linea-arrows-10.svg#linea-arrows-10") format("svg");
  font-weight: normal;
  font-style: normal;
}
.linea-aerrow[data-icon]:before {
  font-family: "linea-arrows-10" !important;
  content: attr(data-icon);
  font-style: normal !important;
  font-weight: normal !important;
  font-variant: normal !important;
  text-transform: none !important;
  speak: none;
  line-height: 1;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
[class^="linea-icon-"]:before,
[class*="linea- icon-"]:before {
  font-family: "linea-arrows-10" !important;
  font-style: normal !important;
  font-weight: normal !important;
  font-variant: normal !important;
  text-transform: none !important;
  speak: none;
  line-height: 1;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
.icon-arrows-anticlockwise:before {
  content: "\e000";
}
.icon-arrows-anticlockwise-dashed:before {
  content: "\e001";
}
.icon-arrows-button-down:before {
  content: "\e002";
}
.icon-arrows-button-off:before {
  content: "\e003";
}
.icon-arrows-button-on:before {
  content: "\e004";
}
.icon-arrows-button-up:before {
  content: "\e005";
}
.icon-arrows-check:before {
  content: "\e006";
}
.icon-arrows-circle-check:before {
  content: "\e007";
}
.icon-arrows-circle-down:before {
  content: "\e008";
}
.icon-arrows-circle-downleft:before {
  content: "\e009";
}
.icon-arrows-circle-downright:before {
  content: "\e00a";
}
.icon-arrows-circle-left:before {
  content: "\e00b";
}
.icon-arrows-circle-minus:before {
  content: "\e00c";
}
.icon-arrows-circle-plus:before {
  content: "\e00d";
}
.icon-arrows-circle-remove:before {
  content: "\e00e";
}
.icon-arrows-circle-right:before {
  content: "\e00f";
}
.icon-arrows-circle-up:before {
  content: "\e010";
}
.icon-arrows-circle-upleft:before {
  content: "\e011";
}
.icon-arrows-circle-upright:before {
  content: "\e012";
}
.icon-arrows-clockwise:before {
  content: "\e013";
}
.icon-arrows-clockwise-dashed:before {
  content: "\e014";
}
.icon-arrows-compress:before {
  content: "\e015";
}
.icon-arrows-deny:before {
  content: "\e016";
}
.icon-arrows-diagonal:before {
  content: "\e017";
}
.icon-arrows-diagonal2:before {
  content: "\e018";
}
.icon-arrows-down:before {
  content: "\e019";
}
.icon-arrows-down-double:before {
  content: "\e01a";
}
.icon-arrows-downleft:before {
  content: "\e01b";
}
.icon-arrows-downright:before {
  content: "\e01c";
}
.icon-arrows-drag-down:before {
  content: "\e01d";
}
.icon-arrows-drag-down-dashed:before {
  content: "\e01e";
}
.icon-arrows-drag-horiz:before {
  content: "\e01f";
}
.icon-arrows-drag-left:before {
  content: "\e020";
}
.icon-arrows-drag-left-dashed:before {
  content: "\e021";
}
.icon-arrows-drag-right:before {
  content: "\e022";
}
.icon-arrows-drag-right-dashed:before {
  content: "\e023";
}
.icon-arrows-drag-up:before {
  content: "\e024";
}
.icon-arrows-drag-up-dashed:before {
  content: "\e025";
}
.icon-arrows-drag-vert:before {
  content: "\e026";
}
.icon-arrows-exclamation:before {
  content: "\e027";
}
.icon-arrows-expand:before {
  content: "\e028";
}
.icon-arrows-expand-diagonal1:before {
  content: "\e029";
}
.icon-arrows-expand-horizontal1:before {
  content: "\e02a";
}
.icon-arrows-expand-vertical1:before {
  content: "\e02b";
}
.icon-arrows-fit-horizontal:before {
  content: "\e02c";
}
.icon-arrows-fit-vertical:before {
  content: "\e02d";
}
.icon-arrows-glide:before {
  content: "\e02e";
}
.icon-arrows-glide-horizontal:before {
  content: "\e02f";
}
.icon-arrows-glide-vertical:before {
  content: "\e030";
}
.icon-arrows-hamburger1:before {
  content: "\e031";
}
.icon-arrows-hamburger-2:before {
  content: "\e032";
}
.icon-arrows-horizontal:before {
  content: "\e033";
}
.icon-arrows-info:before {
  content: "\e034";
}
.icon-arrows-keyboard-alt:before {
  content: "\e035";
}
.icon-arrows-keyboard-cmd:before {
  content: "\e036";
}
.icon-arrows-keyboard-delete:before {
  content: "\e037";
}
.icon-arrows-keyboard-down:before {
  content: "\e038";
}
.icon-arrows-keyboard-left:before {
  content: "\e039";
}
.icon-arrows-keyboard-return:before {
  content: "\e03a";
}
.icon-arrows-keyboard-right:before {
  content: "\e03b";
}
.icon-arrows-keyboard-shift:before {
  content: "\e03c";
}
.icon-arrows-keyboard-tab:before {
  content: "\e03d";
}
.icon-arrows-keyboard-up:before {
  content: "\e03e";
}
.icon-arrows-left:before {
  content: "\e03f";
}
.icon-arrows-left-double-32:before {
  content: "\e040";
}
.icon-arrows-minus:before {
  content: "\e041";
}
.icon-arrows-move:before {
  content: "\e042";
}
.icon-arrows-move2:before {
  content: "\e043";
}
.icon-arrows-move-bottom:before {
  content: "\e044";
}
.icon-arrows-move-left:before {
  content: "\e045";
}
.icon-arrows-move-right:before {
  content: "\e046";
}
.icon-arrows-move-top:before {
  content: "\e047";
}
.icon-arrows-plus:before {
  content: "\e048";
}
.icon-arrows-question:before {
  content: "\e049";
}
.icon-arrows-remove:before {
  content: "\e04a";
}
.icon-arrows-right:before {
  content: "\e04b";
}
.icon-arrows-right-double:before {
  content: "\e04c";
}
.icon-arrows-rotate:before {
  content: "\e04d";
}
.icon-arrows-rotate-anti:before {
  content: "\e04e";
}
.icon-arrows-rotate-anti-dashed:before {
  content: "\e04f";
}
.icon-arrows-rotate-dashed:before {
  content: "\e050";
}
.icon-arrows-shrink:before {
  content: "\e051";
}
.icon-arrows-shrink-diagonal1:before {
  content: "\e052";
}
.icon-arrows-shrink-diagonal2:before {
  content: "\e053";
}
.icon-arrows-shrink-horizonal2:before {
  content: "\e054";
}
.icon-arrows-shrink-horizontal1:before {
  content: "\e055";
}
.icon-arrows-shrink-vertical1:before {
  content: "\e056";
}
.icon-arrows-shrink-vertical2:before {
  content: "\e057";
}
.icon-arrows-sign-down:before {
  content: "\e058";
}
.icon-arrows-sign-left:before {
  content: "\e059";
}
.icon-arrows-sign-right:before {
  content: "\e05a";
}
.icon-arrows-sign-up:before {
  content: "\e05b";
}
.icon-arrows-slide-down1:before {
  content: "\e05c";
}
.icon-arrows-slide-down2:before {
  content: "\e05d";
}
.icon-arrows-slide-left1:before {
  content: "\e05e";
}
.icon-arrows-slide-left2:before {
  content: "\e05f";
}
.icon-arrows-slide-right1:before {
  content: "\e060";
}
.icon-arrows-slide-right2:before {
  content: "\e061";
}
.icon-arrows-slide-up1:before {
  content: "\e062";
}
.icon-arrows-slide-up2:before {
  content: "\e063";
}
.icon-arrows-slim-down:before {
  content: "\e064";
}
.icon-arrows-slim-down-dashed:before {
  content: "\e065";
}
.icon-arrows-slim-left:before {
  content: "\e066";
}
.icon-arrows-slim-left-dashed:before {
  content: "\e067";
}
.icon-arrows-slim-right:before {
  content: "\e068";
}
.icon-arrows-slim-right-dashed:before {
  content: "\e069";
}
.icon-arrows-slim-up:before {
  content: "\e06a";
}
.icon-arrows-slim-up-dashed:before {
  content: "\e06b";
}
.icon-arrows-square-check:before {
  content: "\e06c";
}
.icon-arrows-square-down:before {
  content: "\e06d";
}
.icon-arrows-square-downleft:before {
  content: "\e06e";
}
.icon-arrows-square-downright:before {
  content: "\e06f";
}
.icon-arrows-square-left:before {
  content: "\e070";
}
.icon-arrows-square-minus:before {
  content: "\e071";
}
.icon-arrows-square-plus:before {
  content: "\e072";
}
.icon-arrows-square-remove:before {
  content: "\e073";
}
.icon-arrows-square-right:before {
  content: "\e074";
}
.icon-arrows-square-up:before {
  content: "\e075";
}
.icon-arrows-square-upleft:before {
  content: "\e076";
}
.icon-arrows-square-upright:before {
  content: "\e077";
}
.icon-arrows-squares:before {
  content: "\e078";
}
.icon-arrows-stretch-diagonal1:before {
  content: "\e079";
}
.icon-arrows-stretch-diagonal2:before {
  content: "\e07a";
}
.icon-arrows-stretch-diagonal3:before {
  content: "\e07b";
}
.icon-arrows-stretch-diagonal4:before {
  content: "\e07c";
}
.icon-arrows-stretch-horizontal1:before {
  content: "\e07d";
}
.icon-arrows-stretch-horizontal2:before {
  content: "\e07e";
}
.icon-arrows-stretch-vertical1:before {
  content: "\e07f";
}
.icon-arrows-stretch-vertical2:before {
  content: "\e080";
}
.icon-arrows-switch-horizontal:before {
  content: "\e081";
}
.icon-arrows-switch-vertical:before {
  content: "\e082";
}
.icon-arrows-up:before {
  content: "\e083";
}
.icon-arrows-up-double-33:before {
  content: "\e084";
}
.icon-arrows-upleft:before {
  content: "\e085";
}
.icon-arrows-upright:before {
  content: "\e086";
}
.icon-arrows-vertical:before {
  content: "\e087";
}
/*Basic icon*/
@font-face {
  font-family: "linea-basic-10";
  src: url("../less/icons/linea-icons/fonts/linea-basic-10.eot");
  src: url("../less/icons/linea-icons/fonts/linea-basic-10d41d.eot?#iefix") format("embedded-opentype"), url("../less/icons/linea-icons/fonts/linea-basic-10.woff") format("woff"), url("../less/icons/linea-icons/fonts/linea-basic-10.ttf") format("truetype"), url("../less/icons/linea-icons/fonts/linea-basic-10.svg#linea-basic-10") format("svg");
  font-weight: normal;
  font-style: normal;
}
.linea-basic[data-icon]:before {
  font-family: "linea-basic-10" !important;
  content: attr(data-icon);
  font-style: normal !important;
  font-weight: normal !important;
  font-variant: normal !important;
  text-transform: none !important;
  speak: none;
  line-height: 1;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
[class^="linea-icon-"]:before,
[class*="linea- icon-"]:before {
  font-family: "linea-basic-10" !important;
  font-style: normal !important;
  font-weight: normal !important;
  font-variant: normal !important;
  text-transform: none !important;
  speak: none;
  line-height: 1;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
.icon-basic-accelerator:before {
  content: "a";
}
.icon-basic-alarm:before {
  content: "b";
}
.icon-basic-anchor:before {
  content: "c";
}
.icon-basic-anticlockwise:before {
  content: "d";
}
.icon-basic-archive:before {
  content: "e";
}
.icon-basic-archive-full:before {
  content: "f";
}
.icon-basic-ban:before {
  content: "g";
}
.icon-basic-battery-charge:before {
  content: "h";
}
.icon-basic-battery-empty:before {
  content: "i";
}
.icon-basic-battery-full:before {
  content: "j";
}
.icon-basic-battery-half:before {
  content: "k";
}
.icon-basic-bolt:before {
  content: "l";
}
.icon-basic-book:before {
  content: "m";
}
.icon-basic-book-pen:before {
  content: "n";
}
.icon-basic-book-pencil:before {
  content: "o";
}
.icon-basic-bookmark:before {
  content: "p";
}
.icon-basic-calculator:before {
  content: "q";
}
.icon-basic-calendar:before {
  content: "r";
}
.icon-basic-cards-diamonds:before {
  content: "s";
}
.icon-basic-cards-hearts:before {
  content: "t";
}
.icon-basic-case:before {
  content: "u";
}
.icon-basic-chronometer:before {
  content: "v";
}
.icon-basic-clessidre:before {
  content: "w";
}
.icon-basic-clock:before {
  content: "x";
}
.icon-basic-clockwise:before {
  content: "y";
}
.icon-basic-cloud:before {
  content: "z";
}
.icon-basic-clubs:before {
  content: "A";
}
.icon-basic-compass:before {
  content: "B";
}
.icon-basic-cup:before {
  content: "C";
}
.icon-basic-diamonds:before {
  content: "D";
}
.icon-basic-display:before {
  content: "E";
}
.icon-basic-download:before {
  content: "F";
}
.icon-basic-exclamation:before {
  content: "G";
}
.icon-basic-eye:before {
  content: "H";
}
.icon-basic-eye-closed:before {
  content: "I";
}
.icon-basic-female:before {
  content: "J";
}
.icon-basic-flag1:before {
  content: "K";
}
.icon-basic-flag2:before {
  content: "L";
}
.icon-basic-floppydisk:before {
  content: "M";
}
.icon-basic-folder:before {
  content: "N";
}
.icon-basic-folder-multiple:before {
  content: "O";
}
.icon-basic-gear:before {
  content: "P";
}
.icon-basic-geolocalize-01:before {
  content: "Q";
}
.icon-basic-geolocalize-05:before {
  content: "R";
}
.icon-basic-globe:before {
  content: "S";
}
.icon-basic-gunsight:before {
  content: "T";
}
.icon-basic-hammer:before {
  content: "U";
}
.icon-basic-headset:before {
  content: "V";
}
.icon-basic-heart:before {
  content: "W";
}
.icon-basic-heart-broken:before {
  content: "X";
}
.icon-basic-helm:before {
  content: "Y";
}
.icon-basic-home:before {
  content: "Z";
}
.icon-basic-info:before {
  content: "0";
}
.icon-basic-ipod:before {
  content: "1";
}
.icon-basic-joypad:before {
  content: "2";
}
.icon-basic-key:before {
  content: "3";
}
.icon-basic-keyboard:before {
  content: "4";
}
.icon-basic-laptop:before {
  content: "5";
}
.icon-basic-life-buoy:before {
  content: "6";
}
.icon-basic-lightbulb:before {
  content: "7";
}
.icon-basic-link:before {
  content: "8";
}
.icon-basic-lock:before {
  content: "9";
}
.icon-basic-lock-open:before {
  content: "!";
}
.icon-basic-magic-mouse:before {
  content: "\"";
}
.icon-basic-magnifier:before {
  content: "#";
}
.icon-basic-magnifier-minus:before {
  content: "$";
}
.icon-basic-magnifier-plus:before {
  content: "%";
}
.icon-basic-mail:before {
  content: "&";
}
.icon-basic-mail-multiple:before {
  content: "'";
}
.icon-basic-mail-open:before {
  content: "(";
}
.icon-basic-mail-open-text:before {
  content: ")";
}
.icon-basic-male:before {
  content: "*";
}
.icon-basic-map:before {
  content: "+";
}
.icon-basic-message:before {
  content: ",";
}
.icon-basic-message-multiple:before {
  content: "-";
}
.icon-basic-message-txt:before {
  content: ".";
}
.icon-basic-mixer2:before {
  content: "/";
}
.icon-basic-mouse:before {
  content: ":";
}
.icon-basic-notebook:before {
  content: ";";
}
.icon-basic-notebook-pen:before {
  content: "<";
}
.icon-basic-notebook-pencil:before {
  content: "=";
}
.icon-basic-paperplane:before {
  content: ">";
}
.icon-basic-pencil-ruler:before {
  content: "?";
}
.icon-basic-pencil-ruler-pen:before {
  content: "@";
}
.icon-basic-photo:before {
  content: "[";
}
.icon-basic-picture:before {
  content: "]";
}
.icon-basic-picture-multiple:before {
  content: "^";
}
.icon-basic-pin1:before {
  content: "_";
}
.icon-basic-pin2:before {
  content: "`";
}
.icon-basic-postcard:before {
  content: "{";
}
.icon-basic-postcard-multiple:before {
  content: "|";
}
.icon-basic-printer:before {
  content: "}";
}
.icon-basic-question:before {
  content: "~";
}
.icon-basic-rss:before {
  content: "\\";
}
.icon-basic-server:before {
  content: "\e000";
}
.icon-basic-server2:before {
  content: "\e001";
}
.icon-basic-server-cloud:before {
  content: "\e002";
}
.icon-basic-server-download:before {
  content: "\e003";
}
.icon-basic-server-upload:before {
  content: "\e004";
}
.icon-basic-settings:before {
  content: "\e005";
}
.icon-basic-share:before {
  content: "\e006";
}
.icon-basic-sheet:before {
  content: "\e007";
}
.icon-basic-sheet-multiple:before {
  content: "\e008";
}
.icon-basic-sheet-pen:before {
  content: "\e009";
}
.icon-basic-sheet-pencil:before {
  content: "\e00a";
}
.icon-basic-sheet-txt:before {
  content: "\e00b";
}
.icon-basic-signs:before {
  content: "\e00c";
}
.icon-basic-smartphone:before {
  content: "\e00d";
}
.icon-basic-spades:before {
  content: "\e00e";
}
.icon-basic-spread:before {
  content: "\e00f";
}
.icon-basic-spread-bookmark:before {
  content: "\e010";
}
.icon-basic-spread-text:before {
  content: "\e011";
}
.icon-basic-spread-text-bookmark:before {
  content: "\e012";
}
.icon-basic-star:before {
  content: "\e013";
}
.icon-basic-tablet:before {
  content: "\e014";
}
.icon-basic-target:before {
  content: "\e015";
}
.icon-basic-todo:before {
  content: "\e016";
}
.icon-basic-todo-pen:before {
  content: "\e017";
}
.icon-basic-todo-pencil:before {
  content: "\e018";
}
.icon-basic-todo-txt:before {
  content: "\e019";
}
.icon-basic-todolist-pen:before {
  content: "\e01a";
}
.icon-basic-todolist-pencil:before {
  content: "\e01b";
}
.icon-basic-trashcan:before {
  content: "\e01c";
}
.icon-basic-trashcan-full:before {
  content: "\e01d";
}
.icon-basic-trashcan-refresh:before {
  content: "\e01e";
}
.icon-basic-trashcan-remove:before {
  content: "\e01f";
}
.icon-basic-upload:before {
  content: "\e020";
}
.icon-basic-usb:before {
  content: "\e021";
}
.icon-basic-video:before {
  content: "\e022";
}
.icon-basic-watch:before {
  content: "\e023";
}
.icon-basic-webpage:before {
  content: "\e024";
}
.icon-basic-webpage-img-txt:before {
  content: "\e025";
}
.icon-basic-webpage-multiple:before {
  content: "\e026";
}
.icon-basic-webpage-txt:before {
  content: "\e027";
}
.icon-basic-world:before {
  content: "\e028";
}
/*Basic elaboration*/
@font-face {
  font-family: "linea-basic-elaboration-10";
  src: url("../less/icons/linea-icons/fonts/linea-basic-elaboration-10.eot");
  src: url("../less/icons/linea-icons/fonts/linea-basic-elaboration-10d41d.eot?#iefix") format("embedded-opentype"), url("../less/icons/linea-icons/fonts/linea-basic-elaboration-10.woff") format("woff"), url("../less/icons/linea-icons/fonts/linea-basic-elaboration-10.ttf") format("truetype"), url("../less/icons/linea-icons/fonts/linea-basic-elaboration-10.svg#linea-basic-elaboration-10") format("svg");
  font-weight: normal;
  font-style: normal;
}
.linea-elaborate[data-icon]:before {
  font-family: "linea-basic-elaboration-10" !important;
  content: attr(data-icon);
  font-style: normal !important;
  font-weight: normal !important;
  font-variant: normal !important;
  text-transform: none !important;
  speak: none;
  line-height: 1;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
[class^="linea-icon-"]:before,
[class*="linea- icon-"]:before {
  font-family: "linea-basic-elaboration-10" !important;
  font-style: normal !important;
  font-weight: normal !important;
  font-variant: normal !important;
  text-transform: none !important;
  speak: none;
  line-height: 1;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
.icon-basic-elaboration-bookmark-checck:before {
  content: "a";
}
.icon-basic-elaboration-bookmark-minus:before {
  content: "b";
}
.icon-basic-elaboration-bookmark-plus:before {
  content: "c";
}
.icon-basic-elaboration-bookmark-remove:before {
  content: "d";
}
.icon-basic-elaboration-briefcase-check:before {
  content: "e";
}
.icon-basic-elaboration-briefcase-download:before {
  content: "f";
}
.icon-basic-elaboration-briefcase-flagged:before {
  content: "g";
}
.icon-basic-elaboration-briefcase-minus:before {
  content: "h";
}
.icon-basic-elaboration-briefcase-plus:before {
  content: "i";
}
.icon-basic-elaboration-briefcase-refresh:before {
  content: "j";
}
.icon-basic-elaboration-briefcase-remove:before {
  content: "k";
}
.icon-basic-elaboration-briefcase-search:before {
  content: "l";
}
.icon-basic-elaboration-briefcase-star:before {
  content: "m";
}
.icon-basic-elaboration-briefcase-upload:before {
  content: "n";
}
.icon-basic-elaboration-browser-check:before {
  content: "o";
}
.icon-basic-elaboration-browser-download:before {
  content: "p";
}
.icon-basic-elaboration-browser-minus:before {
  content: "q";
}
.icon-basic-elaboration-browser-plus:before {
  content: "r";
}
.icon-basic-elaboration-browser-refresh:before {
  content: "s";
}
.icon-basic-elaboration-browser-remove:before {
  content: "t";
}
.icon-basic-elaboration-browser-search:before {
  content: "u";
}
.icon-basic-elaboration-browser-star:before {
  content: "v";
}
.icon-basic-elaboration-browser-upload:before {
  content: "w";
}
.icon-basic-elaboration-calendar-check:before {
  content: "x";
}
.icon-basic-elaboration-calendar-cloud:before {
  content: "y";
}
.icon-basic-elaboration-calendar-download:before {
  content: "z";
}
.icon-basic-elaboration-calendar-empty:before {
  content: "A";
}
.icon-basic-elaboration-calendar-flagged:before {
  content: "B";
}
.icon-basic-elaboration-calendar-heart:before {
  content: "C";
}
.icon-basic-elaboration-calendar-minus:before {
  content: "D";
}
.icon-basic-elaboration-calendar-next:before {
  content: "E";
}
.icon-basic-elaboration-calendar-noaccess:before {
  content: "F";
}
.icon-basic-elaboration-calendar-pencil:before {
  content: "G";
}
.icon-basic-elaboration-calendar-plus:before {
  content: "H";
}
.icon-basic-elaboration-calendar-previous:before {
  content: "I";
}
.icon-basic-elaboration-calendar-refresh:before {
  content: "J";
}
.icon-basic-elaboration-calendar-remove:before {
  content: "K";
}
.icon-basic-elaboration-calendar-search:before {
  content: "L";
}
.icon-basic-elaboration-calendar-star:before {
  content: "M";
}
.icon-basic-elaboration-calendar-upload:before {
  content: "N";
}
.icon-basic-elaboration-cloud-check:before {
  content: "O";
}
.icon-basic-elaboration-cloud-download:before {
  content: "P";
}
.icon-basic-elaboration-cloud-minus:before {
  content: "Q";
}
.icon-basic-elaboration-cloud-noaccess:before {
  content: "R";
}
.icon-basic-elaboration-cloud-plus:before {
  content: "S";
}
.icon-basic-elaboration-cloud-refresh:before {
  content: "T";
}
.icon-basic-elaboration-cloud-remove:before {
  content: "U";
}
.icon-basic-elaboration-cloud-search:before {
  content: "V";
}
.icon-basic-elaboration-cloud-upload:before {
  content: "W";
}
.icon-basic-elaboration-document-check:before {
  content: "X";
}
.icon-basic-elaboration-document-cloud:before {
  content: "Y";
}
.icon-basic-elaboration-document-download:before {
  content: "Z";
}
.icon-basic-elaboration-document-flagged:before {
  content: "0";
}
.icon-basic-elaboration-document-graph:before {
  content: "1";
}
.icon-basic-elaboration-document-heart:before {
  content: "2";
}
.icon-basic-elaboration-document-minus:before {
  content: "3";
}
.icon-basic-elaboration-document-next:before {
  content: "4";
}
.icon-basic-elaboration-document-noaccess:before {
  content: "5";
}
.icon-basic-elaboration-document-note:before {
  content: "6";
}
.icon-basic-elaboration-document-pencil:before {
  content: "7";
}
.icon-basic-elaboration-document-picture:before {
  content: "8";
}
.icon-basic-elaboration-document-plus:before {
  content: "9";
}
.icon-basic-elaboration-document-previous:before {
  content: "!";
}
.icon-basic-elaboration-document-refresh:before {
  content: "\"";
}
.icon-basic-elaboration-document-remove:before {
  content: "#";
}
.icon-basic-elaboration-document-search:before {
  content: "$";
}
.icon-basic-elaboration-document-star:before {
  content: "%";
}
.icon-basic-elaboration-document-upload:before {
  content: "&";
}
.icon-basic-elaboration-folder-check:before {
  content: "'";
}
.icon-basic-elaboration-folder-cloud:before {
  content: "(";
}
.icon-basic-elaboration-folder-document:before {
  content: ")";
}
.icon-basic-elaboration-folder-download:before {
  content: "*";
}
.icon-basic-elaboration-folder-flagged:before {
  content: "+";
}
.icon-basic-elaboration-folder-graph:before {
  content: ",";
}
.icon-basic-elaboration-folder-heart:before {
  content: "-";
}
.icon-basic-elaboration-folder-minus:before {
  content: ".";
}
.icon-basic-elaboration-folder-next:before {
  content: "/";
}
.icon-basic-elaboration-folder-noaccess:before {
  content: ":";
}
.icon-basic-elaboration-folder-note:before {
  content: ";";
}
.icon-basic-elaboration-folder-pencil:before {
  content: "<";
}
.icon-basic-elaboration-folder-picture:before {
  content: "=";
}
.icon-basic-elaboration-folder-plus:before {
  content: ">";
}
.icon-basic-elaboration-folder-previous:before {
  content: "?";
}
.icon-basic-elaboration-folder-refresh:before {
  content: "@";
}
.icon-basic-elaboration-folder-remove:before {
  content: "[";
}
.icon-basic-elaboration-folder-search:before {
  content: "]";
}
.icon-basic-elaboration-folder-star:before {
  content: "^";
}
.icon-basic-elaboration-folder-upload:before {
  content: "_";
}
.icon-basic-elaboration-mail-check:before {
  content: "`";
}
.icon-basic-elaboration-mail-cloud:before {
  content: "{";
}
.icon-basic-elaboration-mail-document:before {
  content: "|";
}
.icon-basic-elaboration-mail-download:before {
  content: "}";
}
.icon-basic-elaboration-mail-flagged:before {
  content: "~";
}
.icon-basic-elaboration-mail-heart:before {
  content: "\\";
}
.icon-basic-elaboration-mail-next:before {
  content: "\e000";
}
.icon-basic-elaboration-mail-noaccess:before {
  content: "\e001";
}
.icon-basic-elaboration-mail-note:before {
  content: "\e002";
}
.icon-basic-elaboration-mail-pencil:before {
  content: "\e003";
}
.icon-basic-elaboration-mail-picture:before {
  content: "\e004";
}
.icon-basic-elaboration-mail-previous:before {
  content: "\e005";
}
.icon-basic-elaboration-mail-refresh:before {
  content: "\e006";
}
.icon-basic-elaboration-mail-remove:before {
  content: "\e007";
}
.icon-basic-elaboration-mail-search:before {
  content: "\e008";
}
.icon-basic-elaboration-mail-star:before {
  content: "\e009";
}
.icon-basic-elaboration-mail-upload:before {
  content: "\e00a";
}
.icon-basic-elaboration-message-check:before {
  content: "\e00b";
}
.icon-basic-elaboration-message-dots:before {
  content: "\e00c";
}
.icon-basic-elaboration-message-happy:before {
  content: "\e00d";
}
.icon-basic-elaboration-message-heart:before {
  content: "\e00e";
}
.icon-basic-elaboration-message-minus:before {
  content: "\e00f";
}
.icon-basic-elaboration-message-note:before {
  content: "\e010";
}
.icon-basic-elaboration-message-plus:before {
  content: "\e011";
}
.icon-basic-elaboration-message-refresh:before {
  content: "\e012";
}
.icon-basic-elaboration-message-remove:before {
  content: "\e013";
}
.icon-basic-elaboration-message-sad:before {
  content: "\e014";
}
.icon-basic-elaboration-smartphone-cloud:before {
  content: "\e015";
}
.icon-basic-elaboration-smartphone-heart:before {
  content: "\e016";
}
.icon-basic-elaboration-smartphone-noaccess:before {
  content: "\e017";
}
.icon-basic-elaboration-smartphone-note:before {
  content: "\e018";
}
.icon-basic-elaboration-smartphone-pencil:before {
  content: "\e019";
}
.icon-basic-elaboration-smartphone-picture:before {
  content: "\e01a";
}
.icon-basic-elaboration-smartphone-refresh:before {
  content: "\e01b";
}
.icon-basic-elaboration-smartphone-search:before {
  content: "\e01c";
}
.icon-basic-elaboration-tablet-cloud:before {
  content: "\e01d";
}
.icon-basic-elaboration-tablet-heart:before {
  content: "\e01e";
}
.icon-basic-elaboration-tablet-noaccess:before {
  content: "\e01f";
}
.icon-basic-elaboration-tablet-note:before {
  content: "\e020";
}
.icon-basic-elaboration-tablet-pencil:before {
  content: "\e021";
}
.icon-basic-elaboration-tablet-picture:before {
  content: "\e022";
}
.icon-basic-elaboration-tablet-refresh:before {
  content: "\e023";
}
.icon-basic-elaboration-tablet-search:before {
  content: "\e024";
}
.icon-basic-elaboration-todolist-2:before {
  content: "\e025";
}
.icon-basic-elaboration-todolist-check:before {
  content: "\e026";
}
.icon-basic-elaboration-todolist-cloud:before {
  content: "\e027";
}
.icon-basic-elaboration-todolist-download:before {
  content: "\e028";
}
.icon-basic-elaboration-todolist-flagged:before {
  content: "\e029";
}
.icon-basic-elaboration-todolist-minus:before {
  content: "\e02a";
}
.icon-basic-elaboration-todolist-noaccess:before {
  content: "\e02b";
}
.icon-basic-elaboration-todolist-pencil:before {
  content: "\e02c";
}
.icon-basic-elaboration-todolist-plus:before {
  content: "\e02d";
}
.icon-basic-elaboration-todolist-refresh:before {
  content: "\e02e";
}
.icon-basic-elaboration-todolist-remove:before {
  content: "\e02f";
}
.icon-basic-elaboration-todolist-search:before {
  content: "\e030";
}
.icon-basic-elaboration-todolist-star:before {
  content: "\e031";
}
.icon-basic-elaboration-todolist-upload:before {
  content: "\e032";
}
/*Ecommerce*/
@font-face {
  font-family: "linea-ecommerce-10";
  src: url("../less/icons/linea-icons/fonts/linea-ecommerce-10.eot");
  src: url("../less/icons/linea-icons/fonts/linea-ecommerce-10d41d.eot?#iefix") format("embedded-opentype"), url("../less/icons/linea-icons/fonts/linea-ecommerce-10.woff") format("woff"), url("../less/icons/linea-icons/fonts/linea-ecommerce-10.ttf") format("truetype"), url("../less/icons/linea-icons/fonts/linea-ecommerce-10.svg#linea-ecommerce-10") format("svg");
  font-weight: normal;
  font-style: normal;
}
.linea-ecommerce[data-icon]:before {
  font-family: "linea-ecommerce-10" !important;
  content: attr(data-icon);
  font-style: normal !important;
  font-weight: normal !important;
  font-variant: normal !important;
  text-transform: none !important;
  speak: none;
  line-height: 1;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
[class^="linea-icon-"]:before,
[class*="linea- icon-"]:before {
  font-family: "linea-ecommerce-10" !important;
  font-style: normal !important;
  font-weight: normal !important;
  font-variant: normal !important;
  text-transform: none !important;
  speak: none;
  line-height: 1;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
.icon-ecommerce-bag:before {
  content: "a";
}
.icon-ecommerce-bag-check:before {
  content: "b";
}
.icon-ecommerce-bag-cloud:before {
  content: "c";
}
.icon-ecommerce-bag-download:before {
  content: "d";
}
.icon-ecommerce-bag-minus:before {
  content: "e";
}
.icon-ecommerce-bag-plus:before {
  content: "f";
}
.icon-ecommerce-bag-refresh:before {
  content: "g";
}
.icon-ecommerce-bag-remove:before {
  content: "h";
}
.icon-ecommerce-bag-search:before {
  content: "i";
}
.icon-ecommerce-bag-upload:before {
  content: "j";
}
.icon-ecommerce-banknote:before {
  content: "k";
}
.icon-ecommerce-banknotes:before {
  content: "l";
}
.icon-ecommerce-basket:before {
  content: "m";
}
.icon-ecommerce-basket-check:before {
  content: "n";
}
.icon-ecommerce-basket-cloud:before {
  content: "o";
}
.icon-ecommerce-basket-download:before {
  content: "p";
}
.icon-ecommerce-basket-minus:before {
  content: "q";
}
.icon-ecommerce-basket-plus:before {
  content: "r";
}
.icon-ecommerce-basket-refresh:before {
  content: "s";
}
.icon-ecommerce-basket-remove:before {
  content: "t";
}
.icon-ecommerce-basket-search:before {
  content: "u";
}
.icon-ecommerce-basket-upload:before {
  content: "v";
}
.icon-ecommerce-bath:before {
  content: "w";
}
.icon-ecommerce-cart:before {
  content: "x";
}
.icon-ecommerce-cart-check:before {
  content: "y";
}
.icon-ecommerce-cart-cloud:before {
  content: "z";
}
.icon-ecommerce-cart-content:before {
  content: "A";
}
.icon-ecommerce-cart-download:before {
  content: "B";
}
.icon-ecommerce-cart-minus:before {
  content: "C";
}
.icon-ecommerce-cart-plus:before {
  content: "D";
}
.icon-ecommerce-cart-refresh:before {
  content: "E";
}
.icon-ecommerce-cart-remove:before {
  content: "F";
}
.icon-ecommerce-cart-search:before {
  content: "G";
}
.icon-ecommerce-cart-upload:before {
  content: "H";
}
.icon-ecommerce-cent:before {
  content: "I";
}
.icon-ecommerce-colon:before {
  content: "J";
}
.icon-ecommerce-creditcard:before {
  content: "K";
}
.icon-ecommerce-diamond:before {
  content: "L";
}
.icon-ecommerce-dollar:before {
  content: "M";
}
.icon-ecommerce-euro:before {
  content: "N";
}
.icon-ecommerce-franc:before {
  content: "O";
}
.icon-ecommerce-gift:before {
  content: "P";
}
.icon-ecommerce-graph1:before {
  content: "Q";
}
.icon-ecommerce-graph2:before {
  content: "R";
}
.icon-ecommerce-graph3:before {
  content: "S";
}
.icon-ecommerce-graph-decrease:before {
  content: "T";
}
.icon-ecommerce-graph-increase:before {
  content: "U";
}
.icon-ecommerce-guarani:before {
  content: "V";
}
.icon-ecommerce-kips:before {
  content: "W";
}
.icon-ecommerce-lira:before {
  content: "X";
}
.icon-ecommerce-megaphone:before {
  content: "Y";
}
.icon-ecommerce-money:before {
  content: "Z";
}
.icon-ecommerce-naira:before {
  content: "0";
}
.icon-ecommerce-pesos:before {
  content: "1";
}
.icon-ecommerce-pound:before {
  content: "2";
}
.icon-ecommerce-receipt:before {
  content: "3";
}
.icon-ecommerce-receipt-bath:before {
  content: "4";
}
.icon-ecommerce-receipt-cent:before {
  content: "5";
}
.icon-ecommerce-receipt-dollar:before {
  content: "6";
}
.icon-ecommerce-receipt-euro:before {
  content: "7";
}
.icon-ecommerce-receipt-franc:before {
  content: "8";
}
.icon-ecommerce-receipt-guarani:before {
  content: "9";
}
.icon-ecommerce-receipt-kips:before {
  content: "!";
}
.icon-ecommerce-receipt-lira:before {
  content: "\"";
}
.icon-ecommerce-receipt-naira:before {
  content: "#";
}
.icon-ecommerce-receipt-pesos:before {
  content: "$";
}
.icon-ecommerce-receipt-pound:before {
  content: "%";
}
.icon-ecommerce-receipt-rublo:before {
  content: "&";
}
.icon-ecommerce-receipt-rupee:before {
  content: "'";
}
.icon-ecommerce-receipt-tugrik:before {
  content: "(";
}
.icon-ecommerce-receipt-won:before {
  content: ")";
}
.icon-ecommerce-receipt-yen:before {
  content: "*";
}
.icon-ecommerce-receipt-yen2:before {
  content: "+";
}
.icon-ecommerce-recept-colon:before {
  content: ",";
}
.icon-ecommerce-rublo:before {
  content: "-";
}
.icon-ecommerce-rupee:before {
  content: ".";
}
.icon-ecommerce-safe:before {
  content: "/";
}
.icon-ecommerce-sale:before {
  content: ":";
}
.icon-ecommerce-sales:before {
  content: ";";
}
.icon-ecommerce-ticket:before {
  content: "<";
}
.icon-ecommerce-tugriks:before {
  content: "=";
}
.icon-ecommerce-wallet:before {
  content: ">";
}
.icon-ecommerce-won:before {
  content: "?";
}
.icon-ecommerce-yen:before {
  content: "@";
}
.icon-ecommerce-yen2:before {
  content: "[";
}
/*Music */
@font-face {
  font-family: "linea-music-10";
  src: url("../less/icons/linea-icons/fonts/linea-music-10.eot");
  src: url("../less/icons/linea-icons/fonts/linea-music-10d41d.eot?#iefix") format("embedded-opentype"), url("../less/icons/linea-icons/fonts/linea-music-10.woff") format("woff"), url("../less/icons/linea-icons/fonts/linea-music-10.ttf") format("truetype"), url("../less/icons/linea-icons/fonts/linea-music-10.svg#linea-music-10") format("svg");
  font-weight: normal;
  font-style: normal;
}
.linea-music[data-icon]:before {
  font-family: "linea-music-10" !important;
  content: attr(data-icon);
  font-style: normal !important;
  font-weight: normal !important;
  font-variant: normal !important;
  text-transform: none !important;
  speak: none;
  line-height: 1;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
[class^="linea-icon-"]:before,
[class*="linea- icon-"]:before {
  font-family: "linea-music-10" !important;
  font-style: normal !important;
  font-weight: normal !important;
  font-variant: normal !important;
  text-transform: none !important;
  speak: none;
  line-height: 1;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
.icon-music-beginning-button:before {
  content: "a";
}
.icon-music-bell:before {
  content: "b";
}
.icon-music-cd:before {
  content: "c";
}
.icon-music-diapason:before {
  content: "d";
}
.icon-music-eject-button:before {
  content: "e";
}
.icon-music-end-button:before {
  content: "f";
}
.icon-music-fastforward-button:before {
  content: "g";
}
.icon-music-headphones:before {
  content: "h";
}
.icon-music-ipod:before {
  content: "i";
}
.icon-music-loudspeaker:before {
  content: "j";
}
.icon-music-microphone:before {
  content: "k";
}
.icon-music-microphone-old:before {
  content: "l";
}
.icon-music-mixer:before {
  content: "m";
}
.icon-music-mute:before {
  content: "n";
}
.icon-music-note-multiple:before {
  content: "o";
}
.icon-music-note-single:before {
  content: "p";
}
.icon-music-pause-button:before {
  content: "q";
}
.icon-music-play-button:before {
  content: "r";
}
.icon-music-playlist:before {
  content: "s";
}
.icon-music-radio-ghettoblaster:before {
  content: "t";
}
.icon-music-radio-portable:before {
  content: "u";
}
.icon-music-record:before {
  content: "v";
}
.icon-music-recordplayer:before {
  content: "w";
}
.icon-music-repeat-button:before {
  content: "x";
}
.icon-music-rewind-button:before {
  content: "y";
}
.icon-music-shuffle-button:before {
  content: "z";
}
.icon-music-stop-button:before {
  content: "A";
}
.icon-music-tape:before {
  content: "B";
}
.icon-music-volume-down:before {
  content: "C";
}
.icon-music-volume-up:before {
  content: "D";
}
/*Software*/
@font-face {
  font-family: "linea-software-10";
  src: url("../less/icons/linea-icons/fonts/linea-software-10.eot");
  src: url("../less/icons/linea-icons/fonts/linea-software-10d41d.eot?#iefix") format("embedded-opentype"), url("../less/icons/linea-icons/fonts/linea-software-10.woff") format("woff"), url("../less/icons/linea-icons/fonts/linea-software-10.ttf") format("truetype"), url("../less/icons/linea-icons/fonts/linea-software-10.svg#linea-software-10") format("svg");
  font-weight: normal;
  font-style: normal;
}
.linea-software[data-icon]:before {
  font-family: "linea-software-10" !important;
  content: attr(data-icon);
  font-style: normal !important;
  font-weight: normal !important;
  font-variant: normal !important;
  text-transform: none !important;
  speak: none;
  line-height: 1;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
[class^="linea-icon-"]:before,
[class*="linea- icon-"]:before {
  font-family: "linea-software-10" !important;
  font-style: normal !important;
  font-weight: normal !important;
  font-variant: normal !important;
  text-transform: none !important;
  speak: none;
  line-height: 1;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
.icon-software-add-vectorpoint:before {
  content: "a";
}
.icon-software-box-oval:before {
  content: "b";
}
.icon-software-box-polygon:before {
  content: "c";
}
.icon-software-box-rectangle:before {
  content: "d";
}
.icon-software-box-roundedrectangle:before {
  content: "e";
}
.icon-software-character:before {
  content: "f";
}
.icon-software-crop:before {
  content: "g";
}
.icon-software-eyedropper:before {
  content: "h";
}
.icon-software-font-allcaps:before {
  content: "i";
}
.icon-software-font-baseline-shift:before {
  content: "j";
}
.icon-software-font-horizontal-scale:before {
  content: "k";
}
.icon-software-font-kerning:before {
  content: "l";
}
.icon-software-font-leading:before {
  content: "m";
}
.icon-software-font-size:before {
  content: "n";
}
.icon-software-font-smallcapital:before {
  content: "o";
}
.icon-software-font-smallcaps:before {
  content: "p";
}
.icon-software-font-strikethrough:before {
  content: "q";
}
.icon-software-font-tracking:before {
  content: "r";
}
.icon-software-font-underline:before {
  content: "s";
}
.icon-software-font-vertical-scale:before {
  content: "t";
}
.icon-software-horizontal-align-center:before {
  content: "u";
}
.icon-software-horizontal-align-left:before {
  content: "v";
}
.icon-software-horizontal-align-right:before {
  content: "w";
}
.icon-software-horizontal-distribute-center:before {
  content: "x";
}
.icon-software-horizontal-distribute-left:before {
  content: "y";
}
.icon-software-horizontal-distribute-right:before {
  content: "z";
}
.icon-software-indent-firstline:before {
  content: "A";
}
.icon-software-indent-left:before {
  content: "B";
}
.icon-software-indent-right:before {
  content: "C";
}
.icon-software-lasso:before {
  content: "D";
}
.icon-software-layers1:before {
  content: "E";
}
.icon-software-layers2:before {
  content: "F";
}
.icon-software-layout:before {
  content: "G";
}
.icon-software-layout-2columns:before {
  content: "H";
}
.icon-software-layout-3columns:before {
  content: "I";
}
.icon-software-layout-4boxes:before {
  content: "J";
}
.icon-software-layout-4columns:before {
  content: "K";
}
.icon-software-layout-4lines:before {
  content: "L";
}
.icon-software-layout-8boxes:before {
  content: "M";
}
.icon-software-layout-header:before {
  content: "N";
}
.icon-software-layout-header-2columns:before {
  content: "O";
}
.icon-software-layout-header-3columns:before {
  content: "P";
}
.icon-software-layout-header-4boxes:before {
  content: "Q";
}
.icon-software-layout-header-4columns:before {
  content: "R";
}
.icon-software-layout-header-complex:before {
  content: "S";
}
.icon-software-layout-header-complex2:before {
  content: "T";
}
.icon-software-layout-header-complex3:before {
  content: "U";
}
.icon-software-layout-header-complex4:before {
  content: "V";
}
.icon-software-layout-header-sideleft:before {
  content: "W";
}
.icon-software-layout-header-sideright:before {
  content: "X";
}
.icon-software-layout-sidebar-left:before {
  content: "Y";
}
.icon-software-layout-sidebar-right:before {
  content: "Z";
}
.icon-software-magnete:before {
  content: "0";
}
.icon-software-pages:before {
  content: "1";
}
.icon-software-paintbrush:before {
  content: "2";
}
.icon-software-paintbucket:before {
  content: "3";
}
.icon-software-paintroller:before {
  content: "4";
}
.icon-software-paragraph:before {
  content: "5";
}
.icon-software-paragraph-align-left:before {
  content: "6";
}
.icon-software-paragraph-align-right:before {
  content: "7";
}
.icon-software-paragraph-center:before {
  content: "8";
}
.icon-software-paragraph-justify-all:before {
  content: "9";
}
.icon-software-paragraph-justify-center:before {
  content: "!";
}
.icon-software-paragraph-justify-left:before {
  content: "\"";
}
.icon-software-paragraph-justify-right:before {
  content: "#";
}
.icon-software-paragraph-space-after:before {
  content: "$";
}
.icon-software-paragraph-space-before:before {
  content: "%";
}
.icon-software-pathfinder-exclude:before {
  content: "&";
}
.icon-software-pathfinder-intersect:before {
  content: "'";
}
.icon-software-pathfinder-subtract:before {
  content: "(";
}
.icon-software-pathfinder-unite:before {
  content: ")";
}
.icon-software-pen:before {
  content: "*";
}
.icon-software-pen-add:before {
  content: "+";
}
.icon-software-pen-remove:before {
  content: ",";
}
.icon-software-pencil:before {
  content: "-";
}
.icon-software-polygonallasso:before {
  content: ".";
}
.icon-software-reflect-horizontal:before {
  content: "/";
}
.icon-software-reflect-vertical:before {
  content: ":";
}
.icon-software-remove-vectorpoint:before {
  content: ";";
}
.icon-software-scale-expand:before {
  content: "<";
}
.icon-software-scale-reduce:before {
  content: "=";
}
.icon-software-selection-oval:before {
  content: ">";
}
.icon-software-selection-polygon:before {
  content: "?";
}
.icon-software-selection-rectangle:before {
  content: "@";
}
.icon-software-selection-roundedrectangle:before {
  content: "[";
}
.icon-software-shape-oval:before {
  content: "]";
}
.icon-software-shape-polygon:before {
  content: "^";
}
.icon-software-shape-rectangle:before {
  content: "_";
}
.icon-software-shape-roundedrectangle:before {
  content: "`";
}
.icon-software-slice:before {
  content: "{";
}
.icon-software-transform-bezier:before {
  content: "|";
}
.icon-software-vector-box:before {
  content: "}";
}
.icon-software-vector-composite:before {
  content: "~";
}
.icon-software-vector-line:before {
  content: "\\";
}
.icon-software-vertical-align-bottom:before {
  content: "\e000";
}
.icon-software-vertical-align-center:before {
  content: "\e001";
}
.icon-software-vertical-align-top:before {
  content: "\e002";
}
.icon-software-vertical-distribute-bottom:before {
  content: "\e003";
}
.icon-software-vertical-distribute-center:before {
  content: "\e004";
}
.icon-software-vertical-distribute-top:before {
  content: "\e005";
}
/*Weather*/
@font-face {
  font-family: "linea-weather-10";
  src: url("../less/icons/linea-icons/fonts/linea-weather-10.eot");
  src: url("../less/icons/linea-icons/fonts/linea-weather-10d41d.eot?#iefix") format("embedded-opentype"), url("../less/icons/linea-icons/fonts/linea-weather-10.woff") format("woff"), url("../less/icons/linea-icons/fonts/linea-weather-10.ttf") format("truetype"), url("../less/icons/linea-icons/fonts/linea-weather-10.svg#linea-weather-10") format("svg");
  font-weight: normal;
  font-style: normal;
}
.linea-weather[data-icon]:before {
  font-family: "linea-weather-10" !important;
  content: attr(data-icon);
  font-style: normal !important;
  font-weight: normal !important;
  font-variant: normal !important;
  text-transform: none !important;
  speak: none;
  line-height: 1;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
[class^="linea-icon-"]:before,
[class*="linea- icon-"]:before {
  font-family: "linea-weather-10" !important;
  font-style: normal !important;
  font-weight: normal !important;
  font-variant: normal !important;
  text-transform: none !important;
  speak: none;
  line-height: 1;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
.icon-weather-aquarius:before {
  content: "\e000";
}
.icon-weather-aries:before {
  content: "\e001";
}
.icon-weather-cancer:before {
  content: "\e002";
}
.icon-weather-capricorn:before {
  content: "\e003";
}
.icon-weather-cloud:before {
  content: "\e004";
}
.icon-weather-cloud-drop:before {
  content: "\e005";
}
.icon-weather-cloud-lightning:before {
  content: "\e006";
}
.icon-weather-cloud-snowflake:before {
  content: "\e007";
}
.icon-weather-downpour-fullmoon:before {
  content: "\e008";
}
.icon-weather-downpour-halfmoon:before {
  content: "\e009";
}
.icon-weather-downpour-sun:before {
  content: "\e00a";
}
.icon-weather-drop:before {
  content: "\e00b";
}
.icon-weather-first-quarter:before {
  content: "\e00c";
}
.icon-weather-fog:before {
  content: "\e00d";
}
.icon-weather-fog-fullmoon:before {
  content: "\e00e";
}
.icon-weather-fog-halfmoon:before {
  content: "\e00f";
}
.icon-weather-fog-sun:before {
  content: "\e010";
}
.icon-weather-fullmoon:before {
  content: "\e011";
}
.icon-weather-gemini:before {
  content: "\e012";
}
.icon-weather-hail:before {
  content: "\e013";
}
.icon-weather-hail-fullmoon:before {
  content: "\e014";
}
.icon-weather-hail-halfmoon:before {
  content: "\e015";
}
.icon-weather-hail-sun:before {
  content: "\e016";
}
.icon-weather-last-quarter:before {
  content: "\e017";
}
.icon-weather-leo:before {
  content: "\e018";
}
.icon-weather-libra:before {
  content: "\e019";
}
.icon-weather-lightning:before {
  content: "\e01a";
}
.icon-weather-mistyrain:before {
  content: "\e01b";
}
.icon-weather-mistyrain-fullmoon:before {
  content: "\e01c";
}
.icon-weather-mistyrain-halfmoon:before {
  content: "\e01d";
}
.icon-weather-mistyrain-sun:before {
  content: "\e01e";
}
.icon-weather-moon:before {
  content: "\e01f";
}
.icon-weather-moondown-full:before {
  content: "\e020";
}
.icon-weather-moondown-half:before {
  content: "\e021";
}
.icon-weather-moonset-full:before {
  content: "\e022";
}
.icon-weather-moonset-half:before {
  content: "\e023";
}
.icon-weather-move2:before {
  content: "\e024";
}
.icon-weather-newmoon:before {
  content: "\e025";
}
.icon-weather-pisces:before {
  content: "\e026";
}
.icon-weather-rain:before {
  content: "\e027";
}
.icon-weather-rain-fullmoon:before {
  content: "\e028";
}
.icon-weather-rain-halfmoon:before {
  content: "\e029";
}
.icon-weather-rain-sun:before {
  content: "\e02a";
}
.icon-weather-sagittarius:before {
  content: "\e02b";
}
.icon-weather-scorpio:before {
  content: "\e02c";
}
.icon-weather-snow:before {
  content: "\e02d";
}
.icon-weather-snow-fullmoon:before {
  content: "\e02e";
}
.icon-weather-snow-halfmoon:before {
  content: "\e02f";
}
.icon-weather-snow-sun:before {
  content: "\e030";
}
.icon-weather-snowflake:before {
  content: "\e031";
}
.icon-weather-star:before {
  content: "\e032";
}
.icon-weather-storm-11:before {
  content: "\e033";
}
.icon-weather-storm-32:before {
  content: "\e034";
}
.icon-weather-storm-fullmoon:before {
  content: "\e035";
}
.icon-weather-storm-halfmoon:before {
  content: "\e036";
}
.icon-weather-storm-sun:before {
  content: "\e037";
}
.icon-weather-sun:before {
  content: "\e038";
}
.icon-weather-sundown:before {
  content: "\e039";
}
.icon-weather-sunset:before {
  content: "\e03a";
}
.icon-weather-taurus:before {
  content: "\e03b";
}
.icon-weather-tempest:before {
  content: "\e03c";
}
.icon-weather-tempest-fullmoon:before {
  content: "\e03d";
}
.icon-weather-tempest-halfmoon:before {
  content: "\e03e";
}
.icon-weather-tempest-sun:before {
  content: "\e03f";
}
.icon-weather-variable-fullmoon:before {
  content: "\e040";
}
.icon-weather-variable-halfmoon:before {
  content: "\e041";
}
.icon-weather-variable-sun:before {
  content: "\e042";
}
.icon-weather-virgo:before {
  content: "\e043";
}
.icon-weather-waning-cresent:before {
  content: "\e044";
}
.icon-weather-waning-gibbous:before {
  content: "\e045";
}
.icon-weather-waxing-cresent:before {
  content: "\e046";
}
.icon-weather-waxing-gibbous:before {
  content: "\e047";
}
.icon-weather-wind:before {
  content: "\e048";
}
.icon-weather-wind-e:before {
  content: "\e049";
}
.icon-weather-wind-fullmoon:before {
  content: "\e04a";
}
.icon-weather-wind-halfmoon:before {
  content: "\e04b";
}
.icon-weather-wind-n:before {
  content: "\e04c";
}
.icon-weather-wind-ne:before {
  content: "\e04d";
}
.icon-weather-wind-nw:before {
  content: "\e04e";
}
.icon-weather-wind-s:before {
  content: "\e04f";
}
.icon-weather-wind-se:before {
  content: "\e050";
}
.icon-weather-wind-sun:before {
  content: "\e051";
}
.icon-weather-wind-sw:before {
  content: "\e052";
}
.icon-weather-wind-w:before {
  content: "\e053";
}
.icon-weather-windgust:before {
  content: "\e054";
}
/***************************** 
    Stylish tabs page 
*****************************/
.sttabs {
  position: relative;
  overflow: hidden;
  margin: 0 auto;
  width: 100%;
  font-weight: 300;
}
.sticon::before {
  display: inline-block;
  margin: 0 0.4em 0 0;
  vertical-align: middle;
  font-size: 20px;
  speak: none;
  -webkit-backface-visibility: hidden;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
.sttabs nav {
  text-align: center;
}
.sttabs nav ul {
  position: relative;
  display: -ms-flexbox;
  display: -webkit-flex;
  display: -moz-flex;
  display: -ms-flex;
  display: flex;
  margin: 0 auto;
  padding: 0;
  font-family: 'Poppins', sans-serif;
  list-style: none;
  -ms-box-orient: horizontal;
  -ms-box-pack: center;
  -webkit-flex-flow: row wrap;
  -moz-flex-flow: row wrap;
  -ms-flex-flow: row wrap;
  flex-flow: row wrap;
  -webkit-justify-content: center;
  -moz-justify-content: center;
  -ms-justify-content: center;
  justify-content: center;
}
.sttabs nav ul li {
  position: relative;
  z-index: 1;
  display: block;
  margin: 0;
  text-align: center;
  -webkit-flex: 1;
  -moz-flex: 1;
  -ms-flex: 1;
  flex: 1;
}
.sttabs nav a {
  position: relative;
  display: block;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  line-height: 2.5;
}
.sttabs nav a span {
  vertical-align: middle;
  font-wight: 500;
  font-size: 14px;
  font-family: 'Rubik', sans-serif;
}
.sttabs nav a:focus {
  outline: none;
}
.sttabs nav li.tab-current a {
  color: #f33155;
}
.content-wrap {
  background: #ffffff;
}
/*****************************/
/* Bar tab*/
/*****************************/
.tabs-style-bar nav ul li a {
  margin: 0 2px;
  background-color: #f7fafc;
  color: #686868;
  padding: 5px 0;
  transition: background-color 0.2s, color 0.2s;
}
.tabs-style-bar nav ul li a:hover,
.tabs-style-bar nav ul li a:focus {
  color: #f33155;
}
.tabs-style-bar nav ul li a span {
  text-transform: uppercase;
  letter-spacing: 1px;
  font-size: 14px;
  font-family: 'Poppins', sans-serif;
}
.tabs-style-bar nav ul li.tab-current a {
  background: #fb9678;
  color: #fff;
}
/*****************************/
/* Icon box tab*/
/*****************************/
.tabs-style-iconbox nav {
  background: #f7fafc;
}
.tabs-style-iconbox nav ul li a {
  overflow: visible;
  padding: 25px 0;
  line-height: 1;
  -webkit-transition: color 0.2s;
  transition: color 0.2s;
  color: #263238;
}
.tabs-style-iconbox nav ul li.tab-current {
  z-index: 1;
}
.tabs-style-iconbox nav ul li.tab-current a {
  background: #41b3f9;
  color: #ffffff;
  box-shadow: -1px 0 0 #ffffff;
}
.tabs-style-iconbox nav ul li.tab-current a::after {
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -10px;
  width: 0;
  height: 0;
  border: solid transparent;
  border-width: 10px;
  border-top-color: #41b3f9;
  content: '';
  pointer-events: none;
}
.tabs-style-iconbox nav ul li:first-child::before,
.tabs-style-iconbox nav ul li::after {
  position: absolute;
  top: 20%;
  right: 0;
  z-index: -1;
  width: 1px;
  height: 60%;
  content: '';
}
.tabs-style-iconbox nav ul li:first-child::before {
  right: auto;
  left: 0;
}
.tabs-style-iconbox .sticon::before {
  display: block;
  margin: 0 0 0.25em 0;
}
/*****************************/
/* Underline tab*/
/*****************************/
.tabs-style-underline nav {
  border: 1px solid rgba(120, 130, 140, 0.13);
}
.tabs-style-underline nav a {
  padding: 20px 0;
  border-left: 1px solid rgba(120, 130, 140, 0.13);
  -webkit-transition: color 0.2s;
  transition: color 0.2s;
  color: #263238;
}
.tabs-style-underline nav li:last-child a {
  border-right: 1px solid rgba(120, 130, 140, 0.13);
}
.tabs-style-underline nav li a::after {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 6px;
  background: #fb9678;
  content: '';
  -webkit-transition: -webkit-transform 0.3s;
  transition: transform 0.3s;
  -webkit-transform: translate3d(0, 150%, 0);
  transform: translate3d(0, 150%, 0);
}
.tabs-style-underline nav li.tab-current a::after {
  -webkit-transform: translate3d(0, 0, 0);
  transform: translate3d(0, 0, 0);
}
/*****************************/
/* Triangle and line tab*/
/*****************************/
.tabs-style-linetriangle nav a {
  overflow: visible;
  border-bottom: 1px solid rgba(0, 0, 0, 0.2);
  -webkit-transition: color 0.2s;
  transition: color 0.2s;
}
.tabs-style-linetriangle nav a span {
  display: block;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  font-size: 14px;
  padding: 15px 0;
  color: #263238;
}
.tabs-style-linetriangle nav li.tab-current a:after,
.tabs-style-linetriangle nav li.tab-current a:before {
  position: absolute;
  top: 100%;
  left: 50%;
  width: 0;
  height: 0;
  border: solid transparent;
  content: '';
  pointer-events: none;
}
.tabs-style-linetriangle nav li.tab-current a:after {
  margin-left: -10px;
  border-width: 10px;
  border-top-color: #ffffff;
}
.tabs-style-linetriangle nav li.tab-current a span {
  color: #f33155;
}
.tabs-style-linetriangle nav li.tab-current a:before {
  margin-left: -11px;
  border-width: 11px;
  border-top-color: rgba(0, 0, 0, 0.2);
}
/*****************************/
/* Falling Icon tab */
/*****************************/
.tabs-style-iconfall {
  overflow: visible;
}
.tabs-style-iconfall nav {
  max-width: 1200px;
  margin: 0 auto;
}
.tabs-style-iconfall nav a {
  display: inline-block;
  overflow: visible;
  padding: 1em 0 2em;
  color: #263238;
  line-height: 1;
  -webkit-transition: color 0.3s cubic-bezier(0.7, 0, 0.3, 1);
  transition: color 0.3s cubic-bezier(0.7, 0, 0.3, 1);
}
.tabs-style-iconfall nav a:hover,
.tabs-style-iconfall nav a:focus {
  color: #f33155;
}
.tabs-style-iconfall nav li.tab-current a {
  color: #f33155;
}
.tabs-style-iconfall nav li::before {
  position: absolute;
  bottom: 1em;
  left: 50%;
  margin-left: -20px;
  width: 40px;
  height: 4px;
  background: #f33155;
  content: '';
  opacity: 0;
  -webkit-transition: -webkit-transform 0.2s ease-in;
  transition: transform 0.2s ease-in;
  -webkit-transform: scale3d(0, 1, 1);
  transform: scale3d(0, 1, 1);
}
.tabs-style-iconfall nav li.tab-current::before {
  opacity: 1;
  -webkit-transform: scale3d(1, 1, 1);
  transform: scale3d(1, 1, 1);
}
.tabs-style-iconfall nav li.tab-current .sticon::before {
  opacity: 1;
  -webkit-transform: translate3d(0, 0, 0);
  transform: translate3d(0, 0, 0);
}
.tabs-style-iconfall .sticon::before {
  display: block;
  margin: 0 0 0.35em;
  opacity: 0;
  font-size: 24px;
  -webkit-transition: -webkit-transform 0.2s, opacity 0.2s;
  transition: transform 0.2s, opacity 0.2s;
  -webkit-transform: translate3d(0, -100px, 0);
  transform: translate3d(0, -100px, 0);
  pointer-events: none;
}
@media screen and (max-width: 58em) {
  .tabs-style-iconfall nav li .sticon::before {
    opacity: 1;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
  }
}
/*****************************/
/* Moving Line tab */
/*****************************/
.tabs-style-linemove nav {
  background: #f7fafc;
}
.tabs-style-linemove nav li:last-child::before {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 4px;
  background: #f33155;
  content: '';
  -webkit-transition: -webkit-transform 0.3s;
  transition: transform 0.3s;
}
.tabs-style-linemove nav li:first-child.tab-current ~ li:last-child::before {
  -webkit-transform: translate3d(-400%, 0, 0);
  transform: translate3d(-400%, 0, 0);
}
.tabs-style-linemove nav li:nth-child(2).tab-current ~ li:last-child::before {
  -webkit-transform: translate3d(-300%, 0, 0);
  transform: translate3d(-300%, 0, 0);
}
.tabs-style-linemove nav li:nth-child(3).tab-current ~ li:last-child::before {
  -webkit-transform: translate3d(-200%, 0, 0);
  transform: translate3d(-200%, 0, 0);
}
.tabs-style-linemove nav li:nth-child(4).tab-current ~ li:last-child::before {
  -webkit-transform: translate3d(-100%, 0, 0);
  transform: translate3d(-100%, 0, 0);
}
.tabs-style-linemove nav a {
  padding: 30px 0;
  color: #263238;
  line-height: 1;
  -webkit-transition: color 0.3s, -webkit-transform 0.3s;
  transition: color 0.3s, transform 0.3s;
}
.tabs-style-linemove nav li.tab-current a {
  color: #f33155;
}
/*****************************/
/* Line tab*/
/*****************************/
.tabs-style-line nav a {
  padding: 20px 10px;
  box-shadow: inset 0 -2px #d1d3d2;
  color: #686868;
  text-align: left;
  text-transform: uppercase;
  letter-spacing: 1px;
  line-height: 1;
  -webkit-transition: color 0.3s, box-shadow 0.3s;
  transition: color 0.3s, box-shadow 0.3s;
}
.tabs-style-line nav a:hover,
.tabs-style-line nav a:focus {
  box-shadow: inset 0 -2px #74777b;
}
.tabs-style-line nav li.tab-current a {
  box-shadow: inset 0 -2px #f33155;
  color: #f33155;
}
@media screen and (max-width: 58em) {
  .tabs-style-line nav ul {
    display: block;
    box-shadow: none;
  }
  .tabs-style-line nav ul li {
    display: block;
    -webkit-flex: none;
    flex: none;
  }
}
/*****************************/
/* Circle tab*/
/*****************************/
.tabs-style-circle {
  overflow: visible;
}
.tabs-style-circle nav li {
  margin-top: 60px!important;
  margin-bottom: 60px!important;
}
.tabs-style-circle nav li::before {
  position: absolute;
  top: 50%;
  left: 50%;
  margin: -60px 0 0 -60px;
  width: 120px;
  height: 120px;
  border: 1px solid #fb9678;
  border-radius: 50%;
  content: '';
  opacity: 0;
  -webkit-transition: -webkit-transform 0.2s, opacity 0.2s;
  transition: transform 0.2s, opacity 0.2s;
  -webkit-transition-timing-function: cubic-bezier(0.7, 0, 0.3, 1);
  transition-timing-function: cubic-bezier(0.7, 0, 0.3, 1);
}
.tabs-style-circle nav a {
  overflow: visible;
  color: #2b2b2b;
  font-weight: 500;
  font-size: 14;
  line-height: 1.1;
  -webkit-transition: color 0.3s cubic-bezier(0.7, 0, 0.3, 1);
  transition: color 0.3s cubic-bezier(0.7, 0, 0.3, 1);
}
.tabs-style-circle nav a span {
  display: inline-block;
}
.tabs-style-circle nav a:hover,
.tabs-style-circle nav a:focus {
  color: #f33155;
}
.tabs-style-circle nav li.tab-current a {
  color: #f33155;
}
.tabs-style-circle nav li.tab-current a span {
  -webkit-transform: translate3d(0, 4px, 0);
  transform: translate3d(0, 4px, 0);
}
@media screen and (max-width: 58em) {
  .tabs-style-circle nav li::before {
    margin: -40px 0 0 -40px;
    width: 80px;
    height: 80px;
  }
}
.tabs-style-circle nav li.tab-current::before {
  opacity: 1;
  -webkit-transform: scale3d(1, 1, 1);
  transform: scale3d(1, 1, 1);
}
.tabs-style-circle nav a span,
.tabs-style-circle .icon::before {
  -webkit-transition: -webkit-transform 0.3s cubic-bezier(0.7, 0, 0.3, 1);
  transition: transform 0.3s cubic-bezier(0.7, 0, 0.3, 1);
}
.tabs-style-circle .sticon::before {
  display: block;
  margin: 0;
  pointer-events: none;
}
.tabs-style-circle nav li.tab-current .sticon::before {
  -webkit-transform: translate3d(0, -4px, 0);
  transform: translate3d(0, -4px, 0);
}
/*****************************/
/* Shape tab*/
/*****************************/
.tabs-style-shape {
  max-width: 1200px;
  margin: 0 auto;
}
.tabs-style-shape nav ul li {
  margin: 0 3em;
}
.tabs-style-shape nav ul li:first-child {
  margin-left: 0;
}
.tabs-style-shape nav ul li.tab-current {
  z-index: 1;
}
.tabs-style-shape nav li a {
  overflow: visible;
  margin: 0 -3em 0 0;
  padding: 0;
  color: #fff;
  font-weight: 500;
}
.tabs-style-shape nav li a svg {
  position: absolute;
  left: 100%;
  margin: 0;
  width: 3em;
  height: 100%;
  fill: #bdc2c9;
}
.tabs-style-shape nav li:first-child a span {
  padding-left: 2em;
  border-radius: 30px 0 0 0;
}
.tabs-style-shape nav li:last-child a span {
  padding-right: 2em;
  border-radius: 0 30px 0 0;
}
.tabs-style-shape nav li a svg:nth-child(2),
.tabs-style-shape nav li:last-child a svg {
  right: 100%;
  left: auto;
  -webkit-transform: scale3d(-1, 1, 1);
  transform: scale3d(-1, 1, 1);
}
.tabs-style-shape nav li a span {
  display: block;
  overflow: hidden;
  padding: 0.65em 0;
  background-color: #bdc2c9;
  text-overflow: ellipsis;
  white-space: nowrap;
}
.tabs-style-shape nav li a:hover span {
  background-color: #f33155;
}
.tabs-style-shape nav li a:hover svg {
  fill: #f33155;
}
.tabs-style-shape nav li a svg {
  pointer-events: none;
}
.tabs-style-shape nav li a svg use {
  pointer-events: auto;
}
.tabs-style-shape nav li.tab-current a span,
.tabs-style-shape nav li.tab-current a svg {
  -webkit-transition: none;
  transition: none;
}
.tabs-style-shape nav li.tab-current a span {
  background: #f7fafc;
}
.tabs-style-shape nav li.tab-current a svg {
  fill: #f7fafc;
}
.tabs-style-shape .content-wrap {
  background: #f7fafc;
}
@media screen and (max-width: 58em) {
  .tabs-style-shape nav ul {
    display: block;
    padding-top: 1.5em;
  }
  .tabs-style-shape nav ul li {
    display: block;
    margin: -1.25em 0 0;
    -webkit-flex: none;
    flex: none;
  }
  .tabs-style-shape nav ul li a {
    margin: 0;
  }
  .tabs-style-shape nav ul li svg {
    display: none;
  }
  .tabs-style-shape nav ul li a span {
    padding: 1.25em 0 2em !important;
    border-radius: 30px 30px 0 0 !important;
    box-shadow: 0 -1px 2px rgba(0, 0, 0, 0.1);
    line-height: 1;
  }
  .tabs-style-shape nav ul li:last-child a span {
    padding: 1.25em 0 !important;
  }
  .tabs-style-shape nav ul li.tab-current {
    z-index: 1;
  }
}
/*****************************/
/* Line Box tab*/
/*****************************/
.tabs-style-linebox nav ul li {
  margin: 0 0.5em;
  -webkit-flex: none;
  flex: none;
}
.tabs-style-linebox nav a {
  padding: 0 1.5em;
  color: #263238;
  font-weight: 500;
  -webkit-transition: color 0.3s;
  transition: color 0.3s;
}
.tabs-style-linebox nav a:hover,
.tabs-style-linebox nav a:focus {
  color: #f33155;
}
.tabs-style-linebox nav li.tab-current a {
  color: #ffffff;
}
.tabs-style-linebox nav a::after {
  position: absolute;
  top: 0;
  left: 0;
  z-index: -1;
  width: 100%;
  height: 100%;
  background: #d2d8d6;
  content: '';
  -webkit-transition: background-color 0.3s, -webkit-transform 0.3s;
  transition: background-color 0.3s, transform 0.3s;
  -webkit-transition-timing-function: ease, cubic-bezier(0.7, 0, 0.3, 1);
  transition-timing-function: ease, cubic-bezier(0.7, 0, 0.3, 1);
  -webkit-transform: translate3d(0, 100%, 0) translate3d(0, -3px, 0);
  transform: translate3d(0, 100%, 0) translate3d(0, -3px, 0);
}
.tabs-style-linebox nav li.tab-current a::after {
  -webkit-transform: translate3d(0, 0, 0);
  transform: translate3d(0, 0, 0);
}
.tabs-style-linebox nav a:hover::after,
.tabs-style-linebox nav a:focus::after,
.tabs-style-linebox nav li.tab-current a::after {
  background: #f33155;
}
@media screen and (max-width: 58em) {
  .tabs-style-linebox nav ul {
    display: block;
    box-shadow: none;
  }
  .tabs-style-linebox nav ul li {
    display: block;
    -webkit-flex: none;
    flex: none;
  }
}
/*****************************/
/* Flip tab*/
/*****************************/
.tabs-style-flip {
  max-width: 1200px;
  margin: 0 auto;
}
.tabs-style-flip nav a {
  padding: 0.5em 0;
  color: #263238;
  -webkit-transition: color 0.3s;
  transition: color 0.3s;
}
.tabs-style-flip nav a:hover,
.tabs-style-flip nav a:focus {
  color: #f33155;
}
.tabs-style-flip nav a span {
  text-transform: uppercase;
  letter-spacing: 1px;
}
.tabs-style-flip nav a::after {
  position: absolute;
  top: 0;
  left: 0;
  z-index: -1;
  width: 100%;
  height: 100%;
  background-color: #f0f0f0;
  content: '';
  -webkit-transition: -webkit-transform 0.3s, background-color 0.3s;
  transition: transform 0.3s, background-color 0.3s;
  -webkit-transform: perspective(900px) rotate3d(1, 0, 0, 90deg);
  transform: perspective(900px) rotate3d(1, 0, 0, 90deg);
  -webkit-transform-origin: 50% 100%;
  transform-origin: 50% 100%;
  -webkit-perspective-origin: 50% 100%;
  perspective-origin: 50% 100%;
}
.tabs-style-flip nav li.tab-current a {
  color: #f33155;
}
.tabs-style-flip nav li.tab-current a::after {
  background-color: #f7fafc;
  -webkit-transform: perspective(900px) rotate3d(1, 0, 0, 0deg);
  transform: perspective(900px) rotate3d(1, 0, 0, 0deg);
}
.tabs-style-flip .content-wrap {
  background: #f7fafc;
}
/*****************************/
/* Circle fill tab*/
/*****************************/
.tabs-style-circlefill {
  max-width: 800px;
  border: 1px solid #f33155;
  margin: 0 auto;
}
.tabs-style-circlefill nav ul li {
  overflow: hidden;
  border-right: 1px solid #f33155;
}
.tabs-style-circlefill nav li a {
  padding: 1.5em 0;
  color: #fff;
  font-size: 1.25em;
}
.tabs-style-circlefill nav li:first-child {
  border-left: none;
}
.tabs-style-circlefill nav li:last-child {
  border: none;
}
.tabs-style-circlefill nav li::before {
  position: absolute;
  top: 50%;
  left: 50%;
  margin: -40px 0 0 -40px;
  width: 80px;
  height: 80px;
  border: 1px solid #f33155;
  border-radius: 50%;
  background: #f33155;
  content: '';
  -webkit-transition: -webkit-transform 0.3s;
  transition: transform 0.3s;
}
.tabs-style-circlefill nav li.tab-current::before {
  -webkit-transform: scale3d(2.5, 2.5, 1);
  transform: scale3d(2.5, 2.5, 1);
}
.tabs-style-circlefill nav a {
  -webkit-transition: color 0.3s;
  transition: color 0.3s;
}
.tabs-style-circlefill nav a span {
  display: none;
}
.tabs-style-circlefill nav li.tab-current a {
  color: #ffffff;
}
.tabs-style-circlefill .icon::before {
  display: block;
  margin: 0;
  pointer-events: none;
}
.tabs-style-circlefill .content-wrap {
  border-top: 1px solid #f33155;
}
/* Content */
.content-wrap {
  position: relative;
}
.content-wrap section {
  display: none;
  margin: 0 auto;
  padding: 25px;
  min-height: 150px;
}
.content-wrap section p {
  margin: 0;
  padding: 0.75em 0;
}
.content-wrap section.content-current {
  display: block;
}
/* Fallback */
.no-js .content-wrap section {
  display: block;
  padding-bottom: 2em;
  border-bottom: 1px solid rgba(255, 255, 255, 0.6);
}
.no-flexbox nav ul {
  display: block;
}
.no-flexbox nav ul li {
  min-width: 15%;
  display: inline-block;
}
@media screen and (max-width: 58em) {
  .sttabs nav a span {
    display: none;
  }
  .sttabs nav a:before {
    margin-right: 0;
  }
}
/***************************** 
    Stylish tolltip page 
*****************************/
.mytooltip {
  display: inline;
  position: relative;
  z-index: 9999;
}
/* Trigger text */
.tooltip-item {
  background: rgba(0, 0, 0, 0.1);
  cursor: pointer;
  display: inline-block;
  font-weight: 500;
  padding: 0 10px;
}
/* Gap filler */
.tooltip-item::after {
  content: '';
  position: absolute;
  width: 360px;
  height: 20px;
  bottom: 100%;
  left: 50%;
  pointer-events: none;
  -webkit-transform: translateX(-50%);
  transform: translateX(-50%);
}
.mytooltip:hover .tooltip-item::after {
  pointer-events: auto;
}
/* Tooltip */
.tooltip-content {
  position: absolute;
  z-index: 9999;
  width: 360px;
  left: 50%;
  margin: 0 0 20px -180px;
  bottom: 100%;
  text-align: left;
  font-size: 14px;
  line-height: 30px;
  box-shadow: -5px -5px 15px rgba(48, 54, 61, 0.2);
  background: #2b2b2b;
  opacity: 0;
  cursor: default;
  pointer-events: none;
}
.tooltip-effect-1 .tooltip-content {
  -webkit-transform: translate3d(0, -10px, 0);
  transform: translate3d(0, -10px, 0);
  -webkit-transition: opacity 0.3s, -webkit-transform 0.3s;
  transition: opacity 0.3s, transform 0.3s;
  color: #ffffff;
}
.tooltip-effect-2 .tooltip-content {
  -webkit-transform-origin: 50% calc(110%);
  transform-origin: 50% calc(110%);
  -webkit-transform: perspective(1000px) rotate3d(1, 0, 0, 45deg);
  transform: perspective(1000px) rotate3d(1, 0, 0, 45deg);
  -webkit-transition: opacity 0.2s, -webkit-transform 0.2s;
  transition: opacity 0.2s, transform 0.2s;
}
.tooltip-effect-3 .tooltip-content {
  -webkit-transform: translate3d(0, 10px, 0) rotate3d(1, 1, 0, 25deg);
  transform: translate3d(0, 10px, 0) rotate3d(1, 1, 0, 25deg);
  -webkit-transition: opacity 0.3s, -webkit-transform 0.3s;
  transition: opacity 0.3s, transform 0.3s;
}
.tooltip-effect-4 .tooltip-content {
  -webkit-transform-origin: 50% 100%;
  transform-origin: 50% 100%;
  -webkit-transform: scale3d(0.7, 0.3, 1);
  transform: scale3d(0.7, 0.3, 1);
  -webkit-transition: opacity 0.2s, -webkit-transform 0.2s;
  transition: opacity 0.2s, transform 0.2s;
}
.tooltip-effect-5 .tooltip-content {
  width: 180px;
  margin-left: -90px;
  -webkit-transform-origin: 50% calc(106%);
  transform-origin: 50% calc(106%);
  -webkit-transform: rotate3d(0, 0, 1, 15deg);
  transform: rotate3d(0, 0, 1, 15deg);
  -webkit-transition: opacity 0.2s, -webkit-transform 0.2s;
  transition: opacity 0.2s, transform 0.2s;
  -webkit-transition-timing-function: ease, cubic-bezier(0.17, 0.67, 0.4, 1.39);
  transition-timing-function: ease, cubic-bezier(0.17, 0.67, 0.4, 1.39);
}
.mytooltip:hover .tooltip-content {
  pointer-events: auto;
  opacity: 1;
  -webkit-transform: translate3d(0, 0, 0) rotate3d(0, 0, 0, 0);
  transform: translate3d(0, 0, 0) rotate3d(0, 0, 0, 0);
}
.tooltip.tooltip-effect-2:hover .tooltip-content {
  -webkit-transform: perspective(1000px) rotate3d(1, 0, 0, 0deg);
  transform: perspective(1000px) rotate3d(1, 0, 0, 0deg);
}
/* Arrow */
.tooltip-content::after {
  content: '';
  top: 100%;
  left: 50%;
  border: solid transparent;
  height: 0;
  width: 0;
  position: absolute;
  pointer-events: none;
  border-color: transparent;
  border-top-color: #2a3035;
  border-width: 10px;
  margin-left: -10px;
}
/* Tooltip content*/
.tooltip-content img {
  position: relative;
  height: 140px;
  display: block;
  float: left;
  margin-right: 1em;
}
.tooltip-text {
  font-size: 14px;
  line-height: 24px;
  display: block;
  padding: 1.31em 1.21em 1.21em 0;
  color: #fff;
}
.tooltip-effect-5 .tooltip-text {
  padding: 1.4em;
}
a.mytooltip {
  font-weight: 500;
  color: #fb9678;
}
/* Tooltip 6 to 9 */
.tooltip-content2 {
  position: absolute;
  z-index: 9999;
  width: 80px;
  height: 80px;
  padding-top: 25px;
  left: 50%;
  margin-left: -40px;
  bottom: 100%;
  border-radius: 50%;
  text-align: center;
  background: #fb9678;
  color: #ffffff;
  opacity: 0;
  margin-bottom: 20px;
  cursor: default;
  pointer-events: none;
}
.tooltip-content2 i {
  opacity: 0;
}
.mytooltip:hover .tooltip-content2,
.mytooltip:hover .tooltip-content2 i {
  opacity: 1;
  font-size: 18px;
}
.tooltip-effect-6 .tooltip-content2 {
  -webkit-transform: translate3d(0, 10px, 0) rotate3d(1, 1, 1, 45deg);
  transform: translate3d(0, 10px, 0) rotate3d(1, 1, 1, 45deg);
  -webkit-transform-origin: 50% 100%;
  transform-origin: 50% 100%;
  -webkit-transition: opacity 0.3s, -webkit-transform 0.3s;
  transition: opacity 0.3s, transform 0.3s;
}
.tooltip-effect-6 .tooltip-content2 i {
  -webkit-transform: scale3d(0, 0, 1);
  transform: scale3d(0, 0, 1);
  -webkit-transition: opacity 0.3s, -webkit-transform 0.3s;
  transition: opacity 0.3s, transform 0.3s;
}
.tooltip-effect-7 .tooltip-content2 {
  -webkit-transform: translate3d(0, 10px, 0);
  transform: translate3d(0, 10px, 0);
  -webkit-transition: opacity 0.3s, -webkit-transform 0.3s;
  transition: opacity 0.3s, transform 0.3s;
}
.tooltip-effect-7 .tooltip-content2 i {
  -webkit-transform: translate3d(0, 15px, 0);
  transform: translate3d(0, 15px, 0);
  -webkit-transition: opacity 0.3s, -webkit-transform 0.3s;
  transition: opacity 0.3s, transform 0.3s;
}
.tooltip-effect-8 .tooltip-content2 {
  -webkit-transform: translate3d(0, 10px, 0) rotate3d(0, 1, 0, 90deg);
  transform: translate3d(0, 10px, 0) rotate3d(0, 1, 0, 90deg);
  -webkit-transform-origin: 50% 100%;
  transform-origin: 50% 100%;
  -webkit-transition: opacity 0.3s, -webkit-transform 0.3s;
  transition: opacity 0.3s, transform 0.3s;
}
.tooltip-effect-8 .tooltip-content2 i {
  -webkit-transform: scale3d(0, 0, 1);
  transform: scale3d(0, 0, 1);
  -webkit-transition: opacity 0.3s, -webkit-transform 0.3s;
  transition: opacity 0.3s, transform 0.3s;
}
.tooltip-effect-9 .tooltip-content2 {
  -webkit-transform: translate3d(0, -20px, 0);
  transform: translate3d(0, -20px, 0);
  -webkit-transition: opacity 0.3s, -webkit-transform 0.3s;
  transition: opacity 0.3s, transform 0.3s;
}
.tooltip-effect-9 .tooltip-content2 i {
  -webkit-transform: translate3d(0, 20px, 0);
  transform: translate3d(0, 20px, 0);
  -webkit-transition: opacity 0.3s, -webkit-transform 0.3s;
  transition: opacity 0.3s, transform 0.3s;
}
.mytooltip:hover .tooltip-content2,
.mytooltip:hover .tooltip-content2 i {
  pointer-events: auto;
  -webkit-transform: translate3d(0, 0, 0) scale3d(1, 1, 1);
  transform: translate3d(0, 0, 0) scale3d(1, 1, 1);
}
.tooltip-effect-6:hover .tooltip-content2 i {
  -webkit-transform: rotate3d(1, 1, 1, 0);
  transform: rotate3d(1, 1, 1, 0);
}
.tooltip-content2::after {
  content: '';
  position: absolute;
  top: 100%;
  left: 50%;
  margin: -7px 0 0 -15px;
  width: 30px;
  height: 20px;
  background: url(../images/tooltip1.svg) no-repeat center center;
  background-size: 100%;
}
/***********Bloated Tooltip ***********/
.tooltip-content3 {
  position: absolute;
  background: url(../images/shape1.svg) no-repeat center bottom;
  background-size: 100% 100%;
  z-index: 9999;
  width: 200px;
  bottom: 100%;
  left: 50%;
  margin-left: -100px;
  padding: 50px 30px;
  text-align: center;
  color: #fff;
  opacity: 0;
  cursor: default;
  font-size: 14;
  line-height: 27px;
  pointer-events: none;
  -webkit-transform: scale3d(0.1, 0.2, 1);
  transform: scale3d(0.1, 0.2, 1);
  -webkit-transform-origin: 50% 120%;
  transform-origin: 50% 120%;
  -webkit-transition: opacity 0.4s, -webkit-transform 0.4s;
  transition: opacity 0.4s, transform 0.4s;
  -webkit-transition-timing-function: ease, cubic-bezier(0.6, 0, 0.4, 1);
  transition-timing-function: ease, cubic-bezier(0.6, 0, 0.4, 1);
}
.mytooltip:hover .tooltip-content3 {
  opacity: 1;
  pointer-events: auto;
  -webkit-transform: scale3d(1, 1, 1);
  transform: scale3d(1, 1, 1);
}
/* Arrow */
.tooltip-content3::after {
  content: '';
  position: absolute;
  width: 16px;
  height: 16px;
  left: 50%;
  margin-left: -8px;
  top: 100%;
  background: #00AEEF;
  -webkit-transform: translate3d(0, -60%, 0) rotate3d(0, 0, 1, 45deg);
  transform: translate3d(0, -60%, 0) rotate3d(0, 0, 1, 45deg);
}
/*************Box Tooltip *************/
/* Trigger text */
.tooltip-item2 {
  color: #03a9f3;
  cursor: pointer;
  z-index: 100;
  position: relative;
  display: inline-block;
  font-weight: 500;
  -webkit-transition: background-color 0.3s, color 0.3s, -webkit-transform 0.3s;
  transition: background-color 0.3s, color 0.3s, transform 0.3s;
}
.mytooltip:hover .tooltip-item2 {
  color: #ffffff;
  -webkit-transform: translate3d(0, -0.5em, 0);
  transform: translate3d(0, -0.5em, 0);
}
/******************** Tooltip box ********************/
.tooltip-content4 {
  position: absolute;
  z-index: 99;
  width: 360px;
  left: 50%;
  margin-left: -180px;
  bottom: -5px;
  text-align: left;
  background: #03a9f3;
  opacity: 0;
  font-size: 14px;
  line-height: 27px;
  padding: 1.5em;
  color: #ffffff;
  border-bottom: 55px solid #2b2b2b;
  cursor: default;
  pointer-events: none;
  border-radius: 5px;
  -webkit-transform: translate3d(0, -0.5em, 0);
  transform: translate3d(0, -0.5em, 0);
  -webkit-transition: opacity 0.3s, -webkit-transform 0.3s;
  transition: opacity 0.3s, transform 0.3s;
}
.tooltip-content4 a {
  color: #2b2b2b;
}
.tooltip-text2 {
  opacity: 0;
  -webkit-transform: translate3d(0, 1.5em, 0);
  transform: translate3d(0, 1.5em, 0);
  -webkit-transition: opacity 0.3s, -webkit-transform 0.3s;
  transition: opacity 0.3s, transform 0.3s;
}
.mytooltip:hover .tooltip-content4,
.mytooltip:hover .tooltip-text2 {
  pointer-events: auto;
  opacity: 1;
  -webkit-transform: translate3d(0, 0, 0);
  transform: translate3d(0, 0, 0);
}
/*******Tooltip Line********/
.tooltip-content5 {
  position: absolute;
  z-index: 9999;
  width: 300px;
  left: 50%;
  bottom: 100%;
  font-size: 20px;
  line-height: 1.4;
  text-align: center;
  font-weight: 400;
  color: #ffffff;
  background: transparent;
  opacity: 0;
  margin: 0 0 20px -150px;
  cursor: default;
  pointer-events: none;
  -webkit-font-smoothing: antialiased;
  -webkit-transition: opacity 0.3s 0.3s;
  transition: opacity 0.3s 0.3s;
}
.mytooltip:hover .tooltip-content5 {
  opacity: 1;
  pointer-events: auto;
  -webkit-transition-delay: 0s;
  transition-delay: 0s;
}
.tooltip-content5 span {
  display: block;
}
.tooltip-text3 {
  border-bottom: 10px solid #fb9678;
  overflow: hidden;
  -webkit-transform: scale3d(0, 1, 1);
  transform: scale3d(0, 1, 1);
  -webkit-transition: -webkit-transform 0.3s 0.3s;
  transition: transform 0.3s 0.3s;
}
.mytooltip:hover .tooltip-text3 {
  -webkit-transition-delay: 0s;
  transition-delay: 0s;
  -webkit-transform: scale3d(1, 1, 1);
  transform: scale3d(1, 1, 1);
}
.tooltip-inner2 {
  background: #2b2b2b;
  padding: 40px;
  -webkit-transform: translate3d(0, 100%, 0);
  transform: translate3d(0, 100%, 0);
  webkit-transition: -webkit-transform 0.3s;
  transition: transform 0.3s;
}
.mytooltip:hover .tooltip-inner2 {
  -webkit-transition-delay: 0.3s;
  transition-delay: 0.3s;
  -webkit-transform: translate3d(0, 0, 0);
  transform: translate3d(0, 0, 0);
}
/* Arrow */
.tooltip-content5::after {
  content: '';
  bottom: -20px;
  left: 50%;
  border: solid transparent;
  height: 0;
  width: 0;
  position: absolute;
  pointer-events: none;
  border-color: transparent;
  border-top-color: #fb9678;
  border-width: 10px;
  margin-left: -10px;
}
/*For Laptop (1280px)*/
@media (max-width: 1350px) {
  .carousel .item h3 {
    font-size: 17px;
    height: 90px;
  }
  .inbox-center a {
    width: 400px;
  }
}
/********* Search Result Page**********/
.search-listing {
  padding: 0px;
  margin: 0px;
}
.search-listing li {
  list-style: none;
  padding: 15px 0;
  border-bottom: 1px solid rgba(120, 130, 140, 0.13);
}
.search-listing li h3 {
  margin: 0px;
  font-size: 18px;
}
.search-listing li h3 a {
  color: #41b3f9;
}
.search-listing li h3 a:hover {
  text-decoration: underline;
}
.search-listing li a {
  color: #7ace4c;
}
/*Data tables page*/
button.dt-button,
div.dt-button,
a.dt-button {
  background: #41b3f9;
  color: #ffffff;
  border-color: #41b3f9;
}
button.dt-button:hover,
div.dt-button:hover,
a.dt-button:hover {
  background: #41b3f9;
}
button.dt-button:hover:not(.disabled),
div.dt-button:hover:not(.disabled),
a.dt-button:hover:not(.disabled) {
  background: #f7fafc;
  color: #263238;
  border-color: rgba(120, 130, 140, 0.13);
}
.dataTables_filter input {
  border: 1px solid rgba(120, 130, 140, 0.13);
}
table.dataTable.display tbody tr.odd > .sorting_1,
table.dataTable.order-column.stripe tbody tr.odd > .sorting_1,
table.dataTable.display tbody tr:hover > .sorting_1,
table.dataTable.order-column.hover tbody tr:hover > .sorting_1,
table.dataTable.display tbody tr.even > .sorting_1,
table.dataTable.order-column.stripe tbody tr.even > .sorting_1 {
  background: none;
}
/*Summernote page*/
.note-editor {
  border: 1px solid rgba(120, 130, 140, 0.13);
}
.note-editor .panel-heading {
  padding: 6px 10px 10px;
}
/*left-right-aside-column*/
.page-aside {
  position: relative;
}
/*left-aside-column*/
.left-aside {
  position: absolute;
  background: #ffffff;
  border-right: 1px solid rgba(120, 130, 140, 0.13);
  padding: 20px;
  width: 250px;
  height: 100%;
}
.right-aside {
  padding: 20px;
  margin-left: 250px;
}
.right-aside .contact-list th {
  white-space: nowrap;
}
.right-aside .contact-list td {
  vertical-align: middle;
  white-space: nowrap;
  padding: 25px 10px;
}
.right-aside .contact-list td img {
  width: 30px;
}
.contact-list th {
  white-space: nowrap;
}
.contact-list td {
  vertical-align: middle;
  padding: 25px 10px;
  white-space: nowrap;
}
.contact-list td img {
  width: 30px;
}
.list-style-none {
  margin: 0px;
  padding: 0px;
}
.list-style-none li {
  list-style: none;
  margin: 0px;
}
.list-style-none li.box-label a {
  font-weight: 500;
}
.list-style-none li.divider {
  margin: 10px 0;
  height: 1px;
  background: rgba(120, 130, 140, 0.13);
}
.list-style-none li a {
  padding: 15px 10px;
  display: block;
  color: #313131;
}
.list-style-none li a:hover {
  color: #2cabe3;
}
.list-style-none li a span {
  float: right;
}
/*Chat-box page */
.chat-main-box {
  position: relative;
  background: #ffffff;
  overflow: hidden;
}
.chat-main-box .chat-left-aside {
  position: absolute;
  width: 250px;
  z-index: 9;
  top: 0px;
  border-right: 1px solid rgba(120, 130, 140, 0.13);
}
.chat-main-box .chat-left-aside .open-panel {
  display: none;
  cursor: pointer;
  position: absolute;
  left: -webkit-calc(99%);
  top: 50%;
  z-index: 100;
  background-color: #fff;
  -webkit-box-shadow: 1px 0 3px rgba(0, 0, 0, 0.2);
  box-shadow: 1px 0 3px rgba(0, 0, 0, 0.2);
  border-radius: 0 100px 100px 0;
  line-height: 1;
  padding: 15px 8px 15px 4px;
}
.chat-main-box .chat-left-aside .chat-left-inner .form-control {
  height: 60px;
}
.chat-main-box .chat-left-aside .chat-left-inner .style-none {
  padding: 0px;
}
.chat-main-box .chat-left-aside .chat-left-inner .style-none li {
  list-style: none;
  overflow: hidden;
}
.chat-main-box .chat-left-aside .chat-left-inner .style-none li a {
  padding: 20px;
}
.chat-main-box .chat-left-aside .chat-left-inner .style-none li a:hover,
.chat-main-box .chat-left-aside .chat-left-inner .style-none li a.active {
  background: #f7fafc;
}
.chat-main-box .chat-right-aside {
  margin-left: 250px;
}
.chat-main-box .chat-right-aside .chat-list {
  max-height: none;
  height: 100%;
  padding-top: 40px;
}
.chat-main-box .chat-right-aside .chat-list .chat-text {
  border-radius: 6px;
}
.chat-main-box .chat-right-aside .send-chat-box {
  position: relative;
}
.chat-main-box .chat-right-aside .send-chat-box .form-control {
  border: none;
  border-top: 1px solid rgba(120, 130, 140, 0.13);
  resize: none;
  height: 80px;
  padding-right: 180px;
}
.chat-main-box .chat-right-aside .send-chat-box .form-control:focus {
  border-color: rgba(120, 130, 140, 0.13);
}
.chat-main-box .chat-right-aside .send-chat-box .custom-send {
  position: absolute;
  right: 20px;
  bottom: 10px;
}
.chat-main-box .chat-right-aside .send-chat-box .custom-send .cst-icon {
  color: #313131;
  margin-right: 10px;
}
/*User Cards page*/
.el-element-overlay .white-box {
  padding: 0px;
}
.el-element-overlay .el-card-item {
  position: relative;
  padding-bottom: 25px;
}
.el-element-overlay .el-card-item .el-card-avatar {
  margin-bottom: 15px;
}
.el-element-overlay .el-card-item .el-card-content {
  text-align: center;
}
.el-element-overlay .el-card-item .el-card-content h3 {
  margin: 0px;
}
.el-element-overlay .el-card-item .el-card-content a {
  color: #313131;
}
.el-element-overlay .el-card-item .el-card-content a:hover {
  color: #2cabe3;
}
.el-element-overlay .el-card-item .el-overlay-1 {
  width: 100%;
  height: 100%;
  overflow: hidden;
  position: relative;
  text-align: center;
  cursor: default;
}
.el-element-overlay .el-card-item .el-overlay-1 img {
  display: block;
  position: relative;
  -webkit-transition: all .4s linear;
  transition: all .4s linear;
  width: 100%;
  height: auto;
}
.el-element-overlay .el-card-item .el-overlay-1:hover img {
  -ms-transform: scale(1.2) translateZ(0);
  -webkit-transform: scale(1.2) translateZ(0);
  /* transform: scale(1.2) translateZ(0); */
}
.el-element-overlay .el-card-item .el-overlay-1 .el-info {
  text-decoration: none;
  display: inline-block;
  text-transform: uppercase;
  color: #ffffff;
  background-color: transparent;
  filter: alpha(opacity=0);
  -webkit-transition: all 0.2s ease-in-out;
  transition: all 0.2s ease-in-out;
  padding: 0;
  margin: auto;
  position: absolute;
  top: 50%;
  left: 0;
  right: 0;
  transform: translateY(-50%) translateZ(0);
  -webkit-transform: translateY(-50%) translateZ(0);
  -ms-transform: translateY(-50%) translateZ(0);
}
.el-element-overlay .el-card-item .el-overlay-1 .el-info > li {
  list-style: none;
  display: inline-block;
  margin: 0 3px;
}
.el-element-overlay .el-card-item .el-overlay-1 .el-info > li a {
  border-color: #ffffff;
  color: #ffffff;
  padding: 12px 15px 10px;
}
.el-element-overlay .el-card-item .el-overlay-1 .el-info > li a:hover {
  background: #f33155;
  border-color: #f33155;
}
.el-element-overlay .el-card-item .el-overlay {
  width: 100%;
  height: 100%;
  position: absolute;
  overflow: hidden;
  top: 0;
  left: 0;
  opacity: 0;
  background-color: rgba(0, 0, 0, 0.7);
  -webkit-transition: all 0.4s ease-in-out;
  transition: all 0.4s ease-in-out;
}
.el-element-overlay .el-card-item .el-overlay-1:hover .el-overlay {
  opacity: 1;
  filter: alpha(opacity=100);
  -webkit-transform: translateZ(0);
  -ms-transform: translateZ(0);
  transform: translateZ(0);
}
.el-element-overlay .el-card-item .el-overlay-1 .scrl-dwn {
  top: -100%;
}
.el-element-overlay .el-card-item .el-overlay-1 .scrl-up {
  top: 100%;
  height: 0px;
}
.el-element-overlay .el-card-item .el-overlay-1:hover .scrl-dwn {
  top: 0px;
}
.el-element-overlay .el-card-item .el-overlay-1:hover .scrl-up {
  top: 0px;
  height: 100%;
}
/*Login page sidebar*/
.login-sidebar {
  position: absolute;
  right: 0px;
  margin-top: 0px;
  height: 100%;
}
/*table layouts page*/
.color-table.primary-table thead th {
  background-color: #7460ee;
  color: #ffffff;
}
.color-table.success-table thead th {
  background-color: #7ace4c;
  color: #ffffff;
}
.color-table.info-table thead th {
  background-color: #41b3f9;
  color: #ffffff;
}
.color-table.warning-table thead th {
  background-color: #ffbb44;
  color: #ffffff;
}
.color-table.danger-table thead th {
  background-color: #f33155;
  color: #ffffff;
}
.color-table.inverse-table thead th {
  background-color: #4c5667;
  color: #ffffff;
}
.color-table.dark-table thead th {
  background-color: #263238;
  color: #ffffff;
}
.color-table.red-table thead th {
  background-color: #f33155;
  color: #ffffff;
}
.color-table.purple-table thead th {
  background-color: #707cd2;
  color: #ffffff;
}
.color-table.muted-table thead th {
  background-color: #98a6ad;
  color: #ffffff;
}
.color-bordered-table.primary-bordered-table {
  border: 2px solid #7460ee;
}
.color-bordered-table.primary-bordered-table thead th {
  background-color: #7460ee;
  color: #ffffff;
}
.color-bordered-table.success-bordered-table {
  border: 2px solid #7ace4c;
}
.color-bordered-table.success-bordered-table thead th {
  background-color: #7ace4c;
  color: #ffffff;
}
.color-bordered-table.info-bordered-table {
  border: 2px solid #41b3f9;
}
.color-bordered-table.info-bordered-table thead th {
  background-color: #41b3f9;
  color: #ffffff;
}
.color-bordered-table.warning-bordered-table {
  border: 2px solid #ffbb44;
}
.color-bordered-table.warning-bordered-table thead th {
  background-color: #ffbb44;
  color: #ffffff;
}
.color-bordered-table.danger-bordered-table {
  border: 2px solid #f33155;
}
.color-bordered-table.danger-bordered-table thead th {
  background-color: #f33155;
  color: #ffffff;
}
.color-bordered-table.inverse-bordered-table {
  border: 2px solid #4c5667;
}
.color-bordered-table.inverse-bordered-table thead th {
  background-color: #4c5667;
  color: #ffffff;
}
.color-bordered-table.dark-bordered-table {
  border: 2px solid #263238;
}
.color-bordered-table.dark-bordered-table thead th {
  background-color: #263238;
  color: #ffffff;
}
.color-bordered-table.red-bordered-table {
  border: 2px solid #f33155;
}
.color-bordered-table.red-bordered-table thead th {
  background-color: #f33155;
  color: #ffffff;
}
.color-bordered-table.purple-bordered-table {
  border: 2px solid #707cd2;
}
.color-bordered-table.purple-bordered-table thead th {
  background-color: #707cd2;
  color: #ffffff;
}
.color-bordered-table.muted-bordered-table {
  border: 2px solid #98a6ad;
}
.color-bordered-table.muted-bordered-table thead th {
  background-color: #98a6ad;
  color: #ffffff;
}
.full-color-table.full-primary-table {
  background-color: rgba(171, 140, 228, 0.8);
}
.full-color-table.full-primary-table thead th {
  background-color: #7460ee;
  border: 0 !important;
  color: #ffffff;
}
.full-color-table.full-primary-table tbody td {
  border: 0 !important;
  color: #ffffff;
}
.full-color-table.full-primary-table tr:hover {
  background-color: #7460ee;
}
.full-color-table.full-success-table {
  background-color: rgba(0, 194, 146, 0.8);
}
.full-color-table.full-success-table thead th {
  background-color: #7ace4c;
  border: 0 !important;
  color: #ffffff;
}
.full-color-table.full-success-table tbody td {
  border: 0 !important;
  color: #ffffff;
}
.full-color-table.full-success-table tr:hover {
  background-color: #7ace4c;
}
.full-color-table.full-info-table {
  background-color: rgba(3, 169, 243, 0.8);
}
.full-color-table.full-info-table thead th {
  background-color: #41b3f9;
  border: 0 !important;
  color: #ffffff;
}
.full-color-table.full-info-table tbody td {
  border: 0 !important;
  color: #ffffff;
}
.full-color-table.full-info-table tr:hover {
  background-color: #41b3f9;
}
.full-color-table.full-warning-table {
  background-color: rgba(254, 193, 7, 0.8);
}
.full-color-table.full-warning-table thead th {
  background-color: #ffbb44;
  border: 0 !important;
  color: #ffffff;
}
.full-color-table.full-warning-table tbody td {
  border: 0 !important;
  color: #ffffff;
}
.full-color-table.full-warning-table tr:hover {
  background-color: #ffbb44;
}
.full-color-table.full-danger-table {
  background-color: rgba(251, 150, 120, 0.8);
}
.full-color-table.full-danger-table thead th {
  background-color: #f33155;
  border: 0 !important;
  color: #ffffff;
}
.full-color-table.full-danger-table tbody td {
  border: 0 !important;
  color: #ffffff;
}
.full-color-table.full-danger-table tr:hover {
  background-color: #f33155;
}
.full-color-table.full-inverse-table {
  background-color: rgba(76, 86, 103, 0.8);
}
.full-color-table.full-inverse-table thead th {
  background-color: #4c5667;
  border: 0 !important;
  color: #ffffff;
}
.full-color-table.full-inverse-table tbody td {
  border: 0 !important;
  color: #ffffff;
}
.full-color-table.full-inverse-table tr:hover {
  background-color: #4c5667;
}
.full-color-table.full-dark-table {
  background-color: rgba(43, 43, 43, 0.8);
}
.full-color-table.full-dark-table thead th {
  background-color: #263238;
  border: 0 !important;
  color: #ffffff;
}
.full-color-table.full-dark-table tbody td {
  border: 0 !important;
  color: #ffffff;
}
.full-color-table.full-dark-table tr:hover {
  background-color: #263238;
}
.full-color-table.full-red-table {
  background-color: rgba(251, 58, 58, 0.8);
}
.full-color-table.full-red-table thead th {
  background-color: #f33155;
  border: 0 !important;
  color: #ffffff;
}
.full-color-table.full-red-table tbody td {
  border: 0 !important;
  color: #ffffff;
}
.full-color-table.full-red-table tr:hover {
  background-color: #f33155;
}
.full-color-table.full-purple-table {
  background-color: rgba(150, 117, 206, 0.8);
}
.full-color-table.full-purple-table thead th {
  background-color: #707cd2;
  border: 0 !important;
  color: #ffffff;
}
.full-color-table.full-purple-table tbody td {
  border: 0 !important;
  color: #ffffff;
}
.full-color-table.full-purple-table tr:hover {
  background-color: #707cd2;
}
.full-color-table.full-muted-table {
  background-color: rgba(152, 166, 173, 0.8);
}
.full-color-table.full-muted-table thead th {
  background-color: #98a6ad;
  border: 0 !important;
  color: #ffffff;
}
.full-color-table.full-muted-table tbody td {
  border: 0 !important;
  color: #ffffff;
}
.full-color-table.full-muted-table tr:hover {
  background-color: #98a6ad;
}
/* Material Form Input page */
.floating-labels .form-group {
  position: relative;
}
.floating-labels .form-control {
  font-size: 20px;
  padding: 10px 10px 10px 0;
  display: block;
  border: none;
  border-bottom: 1px solid #e4e7ea;
}
.floating-labels select.form-control > option {
  font-size: 14px;
}
.has-error .form-control {
  border-bottom: 1px solid #f33155;
}
.has-warning .form-control {
  border-bottom: 1px solid #ffbb44;
}
.has-success .form-control {
  border-bottom: 1px solid #7ace4c;
}
.floating-labels .form-control:focus {
  outline: none;
  border: none;
}
.floating-labels label {
  color: #313131;
  font-size: 16px;
  position: absolute;
  cursor: auto;
  font-weight: 400;
  top: 10px;
  transition: 0.2s ease all;
  -moz-transition: 0.2s ease all;
  -webkit-transition: 0.2s ease all;
}
.floating-labels .form-control:focus ~ label,
.floating-labels .form-control:valid ~ label {
  top: -20px;
  font-size: 12px;
  color: #7460ee;
}
.floating-labels .bar {
  position: relative;
  display: block;
}
.floating-labels .bar:before,
.floating-labels .bar:after {
  content: '';
  height: 2px;
  width: 0;
  bottom: 1px;
  position: absolute;
  background: #7460ee;
  transition: 0.2s ease all;
  -moz-transition: 0.2s ease all;
  -webkit-transition: 0.2s ease all;
}
.floating-labels .bar:before {
  left: 50%;
}
.floating-labels .bar:after {
  right: 50%;
}
.floating-labels .form-control:focus ~ .bar:before,
.floating-labels .form-control:focus ~ .bar:after {
  width: 50%;
}
.floating-labels .highlight {
  position: absolute;
  height: 60%;
  width: 100px;
  top: 25%;
  left: 0;
  pointer-events: none;
  opacity: 0.5;
}
.floating-labels .input-lg ~ label,
.floating-labels .input-lg {
  font-size: 24px;
}
.floating-labels .input-sm ~ label,
.floating-labels .input-sm {
  font-size: 16px;
}
.has-warning .bar:before,
.has-warning .bar:after {
  background: #ffbb44;
}
.has-success .bar:before,
.has-success .bar:after {
  background: #7ace4c;
}
.has-error .bar:before,
.has-error .bar:after {
  background: #f33155;
}
.has-warning .form-control:focus ~ label,
.has-warning .form-control:valid ~ label {
  color: #ffbb44;
}
.has-success .form-control:focus ~ label,
.has-success .form-control:valid ~ label {
  color: #7ace4c;
}
.has-error .form-control:focus ~ label,
.has-error .form-control:valid ~ label {
  color: #f33155;
}
.has-feedback label ~ .t-0 {
  top: 0;
}
/*Data table page*/
.table.dataTable,
table.dataTable {
  width: 99.80% !important;
}
table.dataTable thead .sorting_asc::after,
table.dataTable thead .sorting::after,
table.dataTable thead .sorting_desc::after {
  float: none;
  padding-left: 10px;
}
/* style for realestate pages */
.re ul.two-part li i,
.re ul.two-part li span {
  font-size: 36px;
}
.bg-light h4 {
  font-weight: bold;
}
.agent-contact,
.pro-desc {
  font-size: 12px;
}
.form-agent-inq .form-group {
  margin-bottom: 10px;
}
.agent-info {
  max-height: 358px;
  height: 358px;
  background: #f7fafc;
}
.pro-list {
  margin-top: 15px;
}
.pro-img,
.pro-detail {
  display: table-cell;
  vertical-align: top;
}
.pro-detail h5 a {
  color: #313131;
  line-height: 20px;
  font-weight: 500;
}
.pro-box .pro-list-img {
  display: block;
  height: 210px;
  position: relative;
  overflow: hidden;
}
.pro-box .pro-label {
  position: absolute;
  text-transform: uppercase;
  top: 0;
  right: 0;
  border-radius: 2px;
  padding: 5px;
  font-size: 80%;
}
.pro-col-label {
  padding: 7px;
  width: 26%;
  display: block;
  margin-top: -15px;
  margin-left: 37%;
  border: 1px solid rgba(120, 130, 140, 0.13);
  text-transform: uppercase;
}
.pro-box .pro-label-img {
  position: absolute;
  top: 30px;
  right: 30px;
}
.pro-box.pro-horizontal pro-content {
  width: 100%;
  height: 210px;
}
.pro-content .pro-list-details {
  height: 138px;
  max-height: 142px;
  border-bottom: 1px solid rgba(120, 130, 140, 0.13);
  border-right: 1px solid rgba(120, 130, 140, 0.13);
}
.pro-content .pro-list-info {
  border-bottom: 1px solid rgba(120, 130, 140, 0.13);
}
.pro-content .pro-list-details h3,
.pro-content .pro-list-details h4,
.pro-list-info ul.pro-info li,
.pro-agent .agent-name h5,
.pro-agent .agent-name small,
ul.pro-info li span.label,
.pro-location span,
.pro-list-info-3-col ul.pro-info li,
.pro-content-3-col .pro-list-details h3,
.pro-content-3-col .pro-list-details h4,
.pro-content-3-col .pro-list-details h4 small,
.pro-agent-col-3 .agent-name h5,
.pro-agent-col-3 .agent-name small {
  font-weight: 500;
}
.pro-list-info ul.pro-info,
.pro-list-info-3-col ul.pro-info {
  padding: 16px 10px 10px 10px;
  list-style: none;
}
.pro-list-info ul.pro-info li {
  padding: 10px 0px 10px 20px;
  font-size: 12px;
}
ul.pro-info li span.label {
  width: 25px;
  height: 25px;
  padding: 8px;
  border-radius: 50%;
  margin-top: -4px;
  margin-right: 15px;
  font-size: 12px;
}
ul.pro-info li span img,
ul.pro-amenities li span img {
  margin-top: -8px;
  padding-right: 12px;
}
.pro-agent .agent-img a img,
.pro-agent-col-3 .agent-img a img {
  border: 3px solid #ffffff;
  box-shadow: 1px 1px 1px rgba(120, 130, 140, 0.13);
  /*width: 60px;
    height: 60px;*/
}
.pro-agent .agent-img,
.pro-agent .agent-name,
.pro-agent-col-3 .agent-img,
.pro-agent-col-3 .agent-name {
  float: left;
}
.pro-agent .agent-img {
  padding-top: 12px;
}
.pro-agent .agent-name {
  padding: 10px 0 0 15px;
}
.pro-location span {
  padding-top: 27px;
}
.pro-content-3-col {
  padding: 15px;
  background: #f7fafc;
}
.pro-content-3-col .pro-list-details h4 small {
  color: #f33155;
}
.pro-list-info-3-col ul.pro-info li {
  padding: 10px 5px;
}
.pro-agent-col-3 .agent-img {
  padding: 15px;
}
.pro-agent-col-3 .agent-name {
  padding: 15px 15px 15px 5px;
}
ul.pro-amenities {
  list-style: none;
  padding: 8px 0;
}
ul.pro-amenities li {
  padding: 10px 0 10px 0;
  font-size: 12px;
}
ul.pro-amenities li span i {
  padding-right: 12px;
}
.pro-rd .table > tbody > tr > td:first-child {
  font-weight: 500;
}
.pro-rd .table > tbody > tr > td,
.pro-rd .table > tbody > tr > th {
  border: none;
  padding: 8px 8px 8px 0;
  font-size: 12px;
}
.pd-agent-info {
  max-height: 200px;
  height: 200px;
  background: #f7fafc;
  margin-top: 15px;
}
.pd-agent-contact,
.pd-agent-inq {
  padding: 25px;
}
.pro-add-form .radio label,
.pro-add-form .checkbox label {
  font-weight: 100;
}
/* for Plugins section */
.plugin-details {
  display: none;
}
.plugin-details-active {
  display: block;
}
/*Register in steps page*/
.register-box {
  max-width: 600px;
  margin: 0 auto;
  padding-top: 2%;
}
.step-register {
  position: absolute;
  height: 100%;
}
/*Material design icon*/
.material-icon-list-demo .icons div {
  width: 33%;
  padding: 15px;
  display: inline-block;
  line-height: 40px;
}
.material-icon-list-demo .icons div i {
  font-size: 24px;
  vertical-align: middle;
  margin-right: 10px;
}
.material-icon-list-demo .icons div:hover {
  background: #f7fafc;
}
@media (max-width: 1680px) {
  .weather-with-bg .wt-counter li {
    padding: 10px 1px;
  }
}
@media (max-width: 1460px) {
  .weather-with-bg .wt-counter li {
    padding: 10px 0px;
  }
  .weather-with-bg .wt-counter li a {
    min-width: 38px;
    margin-bottom: 7px;
    height: 43px;
    padding: 10px;
  }
}
/*For Laptop (1280px)*/
@media (max-width: 1350px) {
  .carousel .item h3 {
    font-size: 17px;
    height: 90px;
  }
  .inbox-center a {
    width: 400px;
  }
  .new-login-register .lg-info-panel {
    width: 450px;
  }
  .new-login-register .new-login-box {
    margin-left: 500px;
  }
}
/*Small Desktop*/
@media (min-width: 1170px) {
  .app-search .form-control:focus {
    width: 300px;
  }
  .hide-sidebar .top-left-part {
    width: auto;
  }
  .hide-sidebar .top-left-part .logo span {
    display: none;
  }
  .hide-sidebar .sidebar {
    left: -240px;
    transition: 0.5s ease-out;
  }
  .hide-sidebar #page-wrapper {
    margin-left: 0px;
  }
  .hide-sidebar .footer {
    left: 0px;
  }
}
/*Ipad*/
@media (min-width: 768px) {
  #page-wrapper {
    position: inherit;
    margin: 0px 0 0px 240px;
  }
  .navbar-default {
    position: relative;
    width: 100%;
    top: 0px;
  }
  .sidebar {
    z-index: 1001;
    position: fixed;
    width: 240px;
    padding-top: 0px;
    height: 100%;
    transition: 0.05s ease-in;
  }
  .sidebar:hover {
    width: 240px;
  }
  .fix-header .navbar-static-top {
    position: fixed;
    z-index: 1010;
  }
  .fix-header #page-wrapper {
    margin-top: 60px;
  }
}
.navbar-top-links .dropdown-messages,
.navbar-top-links .dropdown-tasks,
.navbar-top-links .dropdown-alerts {
  margin-left: auto;
}
.mail_listing {
  border-left: 1px solid rgba(120, 130, 140, 0.13);
  padding-left: 20px;
}
.inbox-panel {
  padding-right: 20px;
}
.top-minus {
  margin-top: -62px;
  float: right;
}
/*This is for sidemenu*/
@media (max-width: 1170px) {
  .content-wrapper .sidebar {
    left: -240px;
  }
  .content-wrapper #page-wrapper {
    margin-left: 0px;
  }
  .content-wrapper.show-sidebar .sidebar {
    left: 0px;
  }
  .content-wrapper .footer {
    left: 0px;
  }
  .col-in {
    padding: 15px 0;
  }
  .col-in li.col-middle {
    width: 100%;
  }
}
@media (max-width: 1023px) {
  .b-r-none {
    border-right: 0px;
  }
  .carousel-inner h3 {
    height: 90px;
    overflow: hidden;
  }
  .inbox-center a {
    width: 300px;
  }
  .new-login-register .lg-info-panel {
    display: none;
  }
  .new-login-register .new-login-box {
    margin: 0px auto;
    margin-top: 10%;
  }
}
/*Phone*/
@media (max-width: 767px) {
  .navbar-top-links {
    float: left;
  }
  .navbar-top-links .profile-pic img {
    margin-right: 0px;
  }
  .top-left-part {
    width: 60px;
  }
  .navbar-top-links > li:last-child {
    margin-right: 0px;
  }
  .navbar-top-links > li > a {
    padding: 0 12px;
  }
  .navbar-top-links .dropdown-messages,
  .navbar-top-links .dropdown-tasks,
  .navbar-top-links .dropdown-alerts {
    width: 260px;
  }
  .show-sidebar .sidebar {
    width: 240px;
    top: 0px;
  }
  .show-sidebar .sidebar .hide-menu {
    display: inline;
  }
  .show-sidebar .sidebar .nav-small-cap {
    display: block;
  }
  .show-sidebar .sidebar .sidebar-head {
    width: 240px;
    display: block;
  }
  .sidebar {
    z-index: 1001;
    position: fixed;
    width: 0px;
    padding-top: 0px;
    height: 100%;
  }
  .sidebar-head {
    width: 0px;
    display: none;
  }
  #page-wrapper {
    margin: 0px;
  }
  .row-in-br {
    border-right: 0px;
    border-bottom: 1px solid rgba(120, 130, 140, 0.13);
  }
  .bg-title .breadcrumb {
    float: left;
    margin-top: 0px;
    margin-bottom: 10px;
  }
  /*Timeline*/
  ul.timeline:before {
    left: 40px;
  }
  ul.timeline > li > .timeline-panel {
    width: calc(100% - 90px);
  }
  ul.timeline > li > .timeline-badge {
    top: 16px;
    left: 15px;
    margin-left: 0;
  }
  ul.timeline > li > .timeline-panel {
    float: right;
  }
  ul.timeline > li > .timeline-panel:before {
    right: auto;
    left: -15px;
    border-right-width: 15px;
    border-left-width: 0;
  }
  ul.timeline > li > .timeline-panel:after {
    right: auto;
    left: -14px;
    border-right-width: 14px;
    border-left-width: 0;
  }
  .wizard-steps > li {
    display: block;
  }
  .dropdown .mailbox,
  .dropdown .dropdown-tasks {
    left: -94px;
  }
  /***** Start Update 1.5 *****/
  .fix-header .navbar-static-top {
    position: fixed;
    top: 0px;
    width: 100%;
  }
  .fix-header #page-wrapper {
    margin-top: 60px;
  }
  .mega-dropdown-menu {
    height: 340px;
    overflow: auto;
  }
  .left-aside {
    position: relative;
    width: 100%;
    border: 0px;
  }
  .right-aside {
    margin-left: 0px;
  }
  .chat-main-box .chat-left-aside {
    left: -250px;
    transition: 0.5s ease-in;
    background: #ffffff;
  }
  .chat-main-box .chat-left-aside.open-pnl {
    left: 0px;
  }
  .chat-main-box .chat-left-aside .open-panel {
    display: block;
  }
  .chat-main-box .chat-right-aside {
    margin: 0px;
  }
  /***** Close Update 1.5 *****/
  .table-responsive.pro-rd {
    border: none;
  }
  .step-register,
  .login-register,
  #msform fieldset {
    position: relative;
  }
  .mega-dropdown-menu {
    padding-left: 20px;
  }
  .calendar-widget .cal-left {
    position: relative;
    width: 100%;
  }
  .calendar-widget .cal-left .cal-btm-text {
    position: relative;
    bottom: 0px;
    padding-top: 30px;
  }
  .calendar-widget .cal-right {
    width: 100%;
  }
  .calendar-widget .cal-right .cal-table td {
    padding: 15px 0px;
  }
  .calendar-widget .cal-right .cal-table td h1 {
    padding-left: 20px;
  }
  .error-body h1 {
    font-size: 80px;
    line-height: 100px;
  }
  .weather-with-bg .wt-top .wt-img h1 {
    font-size: 24px;
    line-height: 24px;
  }
  .manage-table {
    margin: 0px;
  }
  .dp-table img {
    width: 50px;
  }
  .earning-box li .er-row .er-text {
    width: 37%;
  }
  .earning-box li .er-row .er-count {
    font-size: 24px;
  }
  .sidebar .nav-second-level li a,
  .sidebar:hover .nav-second-level li a {
    padding-left: 40px;
  }
  .sidebar .nav-third-level li a,
  .sidebar:hover .nav-third-level li a {
    padding-left: 60px;
  }
}
@media (max-width: 480px) {
  .vtabs .tabs-vertical {
    width: auto;
  }
  .stat-item {
    padding-right: 0px;
  }
  .login-box {
    width: 100%;
  }
  .pro-content .pro-list-details {
    height: 100px;
    border-right: none;
  }
  .pro-list-info ul.pro-info li {
    padding: 10px 0 10px 0;
  }
  .pro-list-info ul.pro-info {
    padding-left: 0;
  }
  .pro-agent .agent-img {
    padding-top: 3px;
  }
  .pro-agent .agent-name {
    padding: 2px 0 10px 15px;
  }
  .new-login-register .lg-info-panel {
    display: none;
  }
  .new-login-register .new-login-box {
    margin: 0px auto;
    width: 300px;
    margin-top: 10%;
  }
}

@media(max-width:767px) {
    .new-login-register{
       position:relative;
    }
} 
</style>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'ShuleSoft') }}</title>
        <!-- color CSS -->
   </head>
    <div class="row">
        <p><?= ucfirst($schema)?> Daily Report</p>
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="white-box">
                <h3 class="box-title">Users</h3>
                <div class="text-right"> <span class="text-muted">Total Users</span>
                    <h1><?= $users ?></h1> </div> <span class="text-success">Active Users</span>
                <div class="progress m-b-0">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:20%;"> <span class="sr-only"><?= $added_users ?> Added Today</span> </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="white-box">
                <h3 class="box-title">Students</h3>
                <div class="text-right"> <span class="text-muted">Total Students</span>
                    <h1><?= $students ?></h1> </div> <span class="text-success"><?=round($students*100/$users,1)?>% of all users</span>
                <div class="progress m-b-0">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:20%;"> <span class="sr-only"></span> </div>
                </div>
            </div>
        </div>


        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="white-box">
                <h3 class="box-title">Revenue</h3>
                <div class="text-right"> <span class="text-muted">Today Revenue</span>
                    <h1><?= $revenue->sum == null ? 0 : $revenue->sum ?></h1> </div>
                <span class="text-info">Payments +other sources</span>
                <div class="progress m-b-0">
                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:60%;"> <span class="sr-only">20% Complete</span> </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="white-box">
                <h3 class="box-title">Expense</h3>
                <div class="text-right"> <span class="text-muted">Today Expense</span>
                    <h1><?= $expense->sum == null ? 0 : $expense->sum ?></h1> </div> <span class="text-inverse">Without depreciation</span>
                <div class="progress m-b-0">
                    <div class="progress-bar progress-bar-inverse" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:80%;"> <span class="sr-only">230% Complete</span> </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="white-box">
                <h3 class="box-title">ShuleSoft</h3>
                <div class="text-right"> <span class="text-muted">Todays total requests</span>
                    <h1><?= $logs ?></h1> </div> <span class="text-success">20%</span>
                <div class="progress m-b-0">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:20%;"> <span class="sr-only"><?= $log_parents ?></i> From parents</span> </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="white-box">
                <h3 class="box-title">Birthdays</h3>
                <div class="text-right"> <span class="text-muted">Todays Birthdays</span>
                    <h1><?= $birthday ?></h1> </div> <span class="text-success">20%</span>
                <div class="progress m-b-0">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:20%;"> <span class="sr-only">20% Complete</span> </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="white-box">
                <h3 class="box-title"><small class="pull-right m-t-10 text-success"><i class="fa fa-sort-asc"></i> 18% High then last month</small> SMS & EMAILS</h3>
                <div class="stats-row">
                    <div class="stat-item">
                        <h6>Total SMS sent</h6> <b><?= $total_sms ?></b></div>
                    <div class="stat-item">
                        <h6>SMS sent Today</h6> <b><?= $sms ?></b></div>
                    <div class="stat-item">
                        <h6>Emails Sent Today</h6> <b><?= $email ?></b></div>
                </div>

            </div>

        </div>
    </div>
    <div class="comment-body">
        <div class="mail-contnet">
            <h5>By ShuleSoft</h5><span class="time">Sent: <?= date('d M Y h:m') ?></span>
            <br><span class="mail-desc">For more information, please login into your account.</span> ShuleSoft is a cloud based School management software that help schools to organize their information, generate different reports and statistics to help decision makers </div>
    </div>
