(function(t,c){"function"===typeof define&&define.amd?define(["jquery"],c):"object"===typeof exports?module.exports=c(require("jquery")):t.bootbox=c(t.jQuery)})(this,function init(c,l){function p(a,b,d){a.stopPropagation();a.preventDefault();c.isFunction(d)&&!1===d.call(b,a)||b.modal("hide")}function y(a){var b,d=0;for(b in a)d++;return d}function k(a,b){var d=0;c.each(a,function(a,c){b(a,c,d++)})}function z(a){var b,d;if("object"!==typeof a)throw Error("Please supply an object of options");if(!a.message)throw Error("Please specify a message");
a=c.extend({},q,a);a.buttons||(a.buttons={});b=a.buttons;d=y(b);k(b,function(a,e,g){c.isFunction(e)&&(e=b[a]={callback:e});if("object"!==c.type(e))throw Error("button with key "+a+" must be an object");e.label||(e.label=a);e.className||(e.className=2>=d&&g===d-1?"btn-primary":"btn-default")});return a}function A(a,b){var d=a.length,c={};if(1>d||2<d)throw Error("Invalid argument length");2===d||"string"===typeof a[0]?(c[b[0]]=a[0],c[b[1]]=a[1]):c=a[0];return c}function u(a,b,d){return c.extend(!0,
{},a,A(b,d))}function v(a,b,c,f){a={className:"bootbox-"+a,buttons:w.apply(null,b)};return x(u(a,f,c),b)}function w(){for(var a={},b=0,c=arguments.length;b<c;b++){var f=arguments[b],e=f.toLowerCase(),f=f.toUpperCase(),g=m[q.locale];a[e]={label:g?g[f]:m.en[f]}}return a}function x(a,b){var c={};k(b,function(a,b){c[b]=!0});k(a.buttons,function(a){if(c[a]===l)throw Error("button key "+a+" is not allowed (options are "+b.join("\n")+")");});return a}var r={text:"<input class='bootbox-input bootbox-input-text form-control' autocomplete=off type=text />",
textarea:"<textarea class='bootbox-input bootbox-input-textarea form-control'></textarea>",email:"<input class='bootbox-input bootbox-input-email form-control' autocomplete='off' type='email' />",select:"<select class='bootbox-input bootbox-input-select form-control'></select>",checkbox:"<div class='checkbox'><label><input class='bootbox-input bootbox-input-checkbox' type='checkbox' /></label></div>",date:"<input class='bootbox-input bootbox-input-date form-control' autocomplete=off type='date' />",
time:"<input class='bootbox-input bootbox-input-time form-control' autocomplete=off type='time' />",number:"<input class='bootbox-input bootbox-input-number form-control' autocomplete=off type='number' />",password:"<input class='bootbox-input bootbox-input-password form-control' autocomplete='off' type='password' />"},q={locale:"en",backdrop:"static",animate:!0,className:null,closeButton:!0,show:!0,container:"body"},h={alert:function(){var a;a=v("alert",["ok"],["message","callback"],arguments);if(a.callback&&
!c.isFunction(a.callback))throw Error("alert requires callback property to be a function when provided");a.buttons.ok.callback=a.onEscape=function(){return c.isFunction(a.callback)?a.callback.call(this):!0};return h.dialog(a)},confirm:function(){var a;a=v("confirm",["cancel","confirm"],["message","callback"],arguments);a.buttons.cancel.callback=a.onEscape=function(){return a.callback.call(this,!1)};a.buttons.confirm.callback=function(){return a.callback.call(this,!0)};if(!c.isFunction(a.callback))throw Error("confirm requires a callback");
return h.dialog(a)},prompt:function(){var a,b,d,f,e,g;f=c("<form class='bootbox-form'></form>");b={className:"bootbox-prompt",buttons:w("cancel","confirm"),value:"",inputType:"text"};a=x(u(b,arguments,["title","callback"]),["cancel","confirm"]);b=a.show===l?!0:a.show;a.message=f;a.buttons.cancel.callback=a.onEscape=function(){return a.callback.call(this,null)};a.buttons.confirm.callback=function(){var b;switch(a.inputType){case "text":case "textarea":case "email":case "select":case "date":case "time":case "number":case "password":b=
e.val();break;case "checkbox":var d=e.find("input:checked");b=[];k(d,function(a,d){b.push(c(d).val())})}return a.callback.call(this,b)};a.show=!1;if(!a.title)throw Error("prompt requires a title");if(!c.isFunction(a.callback))throw Error("prompt requires a callback");if(!r[a.inputType])throw Error("invalid prompt type");e=c(r[a.inputType]);switch(a.inputType){case "text":case "textarea":case "email":case "date":case "time":case "number":case "password":e.val(a.value);break;case "select":var n={};
g=a.inputOptions||[];if(!c.isArray(g))throw Error("Please pass an array of input options");if(!g.length)throw Error("prompt with select requires options");k(g,function(a,b){var d=e;if(b.value===l||b.text===l)throw Error("given options in wrong format");b.group&&(n[b.group]||(n[b.group]=c("<optgroup/>").attr("label",b.group)),d=n[b.group]);d.append("<option value='"+b.value+"'>"+b.text+"</option>")});k(n,function(a,b){e.append(b)});e.val(a.value);break;case "checkbox":var B=c.isArray(a.value)?a.value:
[a.value];g=a.inputOptions||[];if(!g.length)throw Error("prompt with checkbox requires options");if(!g[0].value||!g[0].text)throw Error("given options in wrong format");e=c("<div/>");k(g,function(b,d){var f=c(r[a.inputType]);f.find("input").attr("value",d.value);f.find("label").append(d.text);k(B,function(a,b){b===d.value&&f.find("input").prop("checked",!0)});e.append(f)})}a.placeholder&&e.attr("placeholder",a.placeholder);a.pattern&&e.attr("pattern",a.pattern);a.maxlength&&e.attr("maxlength",a.maxlength);
f.append(e);f.on("submit",function(a){a.preventDefault();a.stopPropagation();d.find(".btn-primary").click()});d=h.dialog(a);d.off("shown.bs.modal");d.on("shown.bs.modal",function(){e.focus()});!0===b&&d.modal("show");return d},dialog:function(a){a=z(a);var b=c("<div class='bootbox modal' tabindex='-1' role='dialog'><div class='modal-dialog'><div class='modal-content'><div class='modal-body'><div class='bootbox-body'></div></div></div></div></div>"),d=b.find(".modal-dialog"),f=b.find(".modal-body"),
e=a.buttons,g="",h={onEscape:a.onEscape};if(c.fn.modal===l)throw Error("$.fn.modal is not defined; please double check you have included the Bootstrap JavaScript library. See http://getbootstrap.com/javascript/ for more details.");k(e,function(a,b){g+="<button data-bb-handler='"+a+"' type='button' class='btn "+b.className+"'>"+b.label+"</button>";h[a]=b.callback});f.find(".bootbox-body").html(a.message);!0===a.animate&&b.addClass("fade");a.className&&b.addClass(a.className);"large"===a.size?d.addClass("modal-lg"):
"small"===a.size&&d.addClass("modal-sm");a.title&&f.before("<div class='modal-header'><h4 class='modal-title'></h4></div>");a.closeButton&&(d=c("<button type='button' class='bootbox-close-button close' data-dismiss='modal' aria-hidden='true'>&times;</button>"),a.title?b.find(".modal-header").prepend(d):d.css("margin-top","-10px").prependTo(f));a.title&&b.find(".modal-title").html(a.title);g.length&&(f.after("<div class='modal-footer'></div>"),b.find(".modal-footer").html(g));b.on("hidden.bs.modal",
function(a){a.target===this&&b.remove()});b.on("shown.bs.modal",function(){b.find(".btn-primary:first").focus()});if("static"!==a.backdrop)b.on("click.dismiss.bs.modal",function(a){b.children(".modal-backdrop").length&&(a.currentTarget=b.children(".modal-backdrop").get(0));a.target===a.currentTarget&&b.trigger("escape.close.bb")});b.on("escape.close.bb",function(a){h.onEscape&&p(a,b,h.onEscape)});b.on("click",".modal-footer button",function(a){var d=c(this).data("bb-handler");p(a,b,h[d])});b.on("click",
".bootbox-close-button",function(a){p(a,b,h.onEscape)});b.on("keyup",function(a){27===a.which&&b.trigger("escape.close.bb")});c(a.container).append(b);b.modal({backdrop:a.backdrop?"static":!1,keyboard:!1,show:!1});a.show&&b.modal("show");return b},setDefaults:function(){var a={};2===arguments.length?a[arguments[0]]=arguments[1]:a=arguments[0];c.extend(q,a)},hideAll:function(){c(".bootbox").modal("hide");return h}},m={bg_BG:{OK:"\u041e\u043a",CANCEL:"\u041e\u0442\u043a\u0430\u0437",CONFIRM:"\u041f\u043e\u0442\u0432\u044a\u0440\u0436\u0434\u0430\u0432\u0430\u043c"},
br:{OK:"OK",CANCEL:"Cancelar",CONFIRM:"Sim"},cs:{OK:"OK",CANCEL:"Zru\u0161it",CONFIRM:"Potvrdit"},da:{OK:"OK",CANCEL:"Annuller",CONFIRM:"Accepter"},de:{OK:"OK",CANCEL:"Abbrechen",CONFIRM:"Akzeptieren"},el:{OK:"\u0395\u03bd\u03c4\u03ac\u03be\u03b5\u03b9",CANCEL:"\u0391\u03ba\u03cd\u03c1\u03c9\u03c3\u03b7",CONFIRM:"\u0395\u03c0\u03b9\u03b2\u03b5\u03b2\u03b1\u03af\u03c9\u03c3\u03b7"},en:{OK:"OK",CANCEL:"Cancel",CONFIRM:"OK"},es:{OK:"OK",CANCEL:"Cancelar",CONFIRM:"Aceptar"},et:{OK:"OK",CANCEL:"Katkesta",
CONFIRM:"OK"},fa:{OK:"\u0642\u0628\u0648\u0644",CANCEL:"\u0644\u063a\u0648",CONFIRM:"\u062a\u0627\u06cc\u06cc\u062f"},fi:{OK:"OK",CANCEL:"Peruuta",CONFIRM:"OK"},fr:{OK:"OK",CANCEL:"Annuler",CONFIRM:"D'accord"},he:{OK:"\u05d0\u05d9\u05e9\u05d5\u05e8",CANCEL:"\u05d1\u05d9\u05d8\u05d5\u05dc",CONFIRM:"\u05d0\u05d9\u05e9\u05d5\u05e8"},hu:{OK:"OK",CANCEL:"M\u00e9gsem",CONFIRM:"Meger\u0151s\u00edt"},hr:{OK:"OK",CANCEL:"Odustani",CONFIRM:"Potvrdi"},id:{OK:"OK",CANCEL:"Batal",CONFIRM:"OK"},it:{OK:"OK",CANCEL:"Annulla",
CONFIRM:"Conferma"},ja:{OK:"OK",CANCEL:"\u30ad\u30e3\u30f3\u30bb\u30eb",CONFIRM:"\u78ba\u8a8d"},lt:{OK:"Gerai",CANCEL:"At\u0161aukti",CONFIRM:"Patvirtinti"},lv:{OK:"Labi",CANCEL:"Atcelt",CONFIRM:"Apstiprin\u0101t"},nl:{OK:"OK",CANCEL:"Annuleren",CONFIRM:"Accepteren"},no:{OK:"OK",CANCEL:"Avbryt",CONFIRM:"OK"},pl:{OK:"OK",CANCEL:"Anuluj",CONFIRM:"Potwierd\u017a"},pt:{OK:"OK",CANCEL:"Cancelar",CONFIRM:"Confirmar"},ru:{OK:"OK",CANCEL:"\u041e\u0442\u043c\u0435\u043d\u0430",CONFIRM:"\u041f\u0440\u0438\u043c\u0435\u043d\u0438\u0442\u044c"},
sq:{OK:"OK",CANCEL:"Anulo",CONFIRM:"Prano"},sv:{OK:"OK",CANCEL:"Avbryt",CONFIRM:"OK"},th:{OK:"\u0e15\u0e01\u0e25\u0e07",CANCEL:"\u0e22\u0e01\u0e40\u0e25\u0e34\u0e01",CONFIRM:"\u0e22\u0e37\u0e19\u0e22\u0e31\u0e19"},tr:{OK:"Tamam",CANCEL:"\u0130ptal",CONFIRM:"Onayla"},zh_CN:{OK:"OK",CANCEL:"\u53d6\u6d88",CONFIRM:"\u786e\u8ba4"},zh_TW:{OK:"OK",CANCEL:"\u53d6\u6d88",CONFIRM:"\u78ba\u8a8d"}};h.addLocale=function(a,b){c.each(["OK","CANCEL","CONFIRM"],function(a,c){if(!b[c])throw Error("Please supply a translation for '"+
c+"'");});m[a]={OK:b.OK,CANCEL:b.CANCEL,CONFIRM:b.CONFIRM};return h};h.removeLocale=function(a){delete m[a];return h};h.setLocale=function(a){return h.setDefaults("locale",a)};h.init=function(a){return init(a||c)};return h});