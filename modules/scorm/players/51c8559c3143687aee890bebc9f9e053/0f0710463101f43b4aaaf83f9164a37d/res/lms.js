(function(){var g=void 0,i=!0,j=null,k=!1;function l(a){return function(){return this[a]}}var n,p=this;function q(a,c,b){a=a.split(".");b=b||p;!(a[0]in b)&&b.execScript&&b.execScript("var "+a[0]);for(var d;a.length&&(d=a.shift());)!a.length&&c!==g?b[d]=c:b=b[d]?b[d]:b[d]={}}
function aa(a){var c=typeof a;if("object"==c)if(a){if(a instanceof Array)return"array";if(a instanceof Object)return c;var b=Object.prototype.toString.call(a);if("[object Window]"==b)return"object";if("[object Array]"==b||"number"==typeof a.length&&"undefined"!=typeof a.splice&&"undefined"!=typeof a.propertyIsEnumerable&&!a.propertyIsEnumerable("splice"))return"array";if("[object Function]"==b||"undefined"!=typeof a.call&&"undefined"!=typeof a.propertyIsEnumerable&&!a.propertyIsEnumerable("call"))return"function"}else return"null";
else if("function"==c&&"undefined"==typeof a.call)return"object";return c}var ba="closure_uid_"+(1E9*Math.random()>>>0),ca=0;function da(a,c,b){return a.call.apply(a.bind,arguments)}function ea(a,c,b){if(!a)throw Error();if(2<arguments.length){var d=Array.prototype.slice.call(arguments,2);return function(){var b=Array.prototype.slice.call(arguments);Array.prototype.unshift.apply(b,d);return a.apply(c,b)}}return function(){return a.apply(c,arguments)}}
function r(a,c,b){r=Function.prototype.bind&&-1!=Function.prototype.bind.toString().indexOf("native code")?da:ea;return r.apply(j,arguments)}var fa=Date.now||function(){return+new Date};function t(a,c){function b(){}b.prototype=c.prototype;a.b=c.prototype;a.prototype=new b};function ga(a,c,b){this.q=a;this.ca=c;this.Z=b}ga.prototype.id=l("q");ga.prototype.name=l("ca");ga.prototype.email=l("Z");function ha(a){this.q=a}n=ha.prototype;n.t="";n.f=j;n.d=j;n.D="unanticipated";n.S=0;n.J=j;n.L=j;n.W=j;n.j=j;n.id=l("q");n.type=l("e");n.description=l("t");n.s=l("f");n.G=l("d");n.result=l("D");n.score=l("S");n.H=function(a){this.S=a};n.awardedScore=l("J");n.duration=l("L");n.I=l("W");function ia(a){a=String(a);if(/^\s*$/.test(a)?0:/^[\],:{}\s\u2028\u2029]*$/.test(a.replace(/\\["\\\/bfnrtu]/g,"@").replace(/"[^"\\\n\r\u2028\u2029\x00-\x08\x0a-\x1f]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,"]").replace(/(?:^|:|,)(?:[\s\u2028\u2029]*\[)+/g,"")))try{return eval("("+a+")")}catch(c){}throw Error("Invalid JSON string: "+a);}function ja(){this.v=g}
function ka(a,c,b){switch(typeof c){case "string":la(c,b);break;case "number":b.push(isFinite(c)&&!isNaN(c)?c:"null");break;case "boolean":b.push(c);break;case "undefined":b.push("null");break;case "object":if(c==j){b.push("null");break}if("array"==aa(c)){var d=c.length;b.push("[");for(var e="",f=0;f<d;f++)b.push(e),e=c[f],ka(a,a.v?a.v.call(c,String(f),e):e,b),e=",";b.push("]");break}b.push("{");d="";for(f in c)Object.prototype.hasOwnProperty.call(c,f)&&(e=c[f],"function"!=typeof e&&(b.push(d),la(f,
b),b.push(":"),ka(a,a.v?a.v.call(c,f,e):e,b),d=","));b.push("}");break;case "function":break;default:throw Error("Unknown type: "+typeof c);}}var ma={'"':'\\"',"\\":"\\\\","/":"\\/","\b":"\\b","\f":"\\f","\n":"\\n","\r":"\\r","\t":"\\t","\x0B":"\\u000b"},na=/\uffff/.test("\uffff")?/[\\\"\x00-\x1f\x7f-\uffff]/g:/[\\\"\x00-\x1f\x7f-\xff]/g;
function la(a,c){c.push('"',a.replace(na,function(a){if(a in ma)return ma[a];var c=a.charCodeAt(0),e="\\u";16>c?e+="000":256>c?e+="00":4096>c&&(e+="0");return ma[a]=e+c.toString(16)}),'"')};function oa(a){return a.replace(/^[\s\xa0]+|[\s\xa0]+$/g,"")};var u,pa,qa,ra;function sa(){return p.navigator?p.navigator.userAgent:j}ra=qa=pa=u=k;var v;if(v=sa()){var ta=p.navigator;u=0==v.lastIndexOf("Opera",0);pa=!u&&(-1!=v.indexOf("MSIE")||-1!=v.indexOf("Trident"));qa=!u&&-1!=v.indexOf("WebKit");ra=!u&&!qa&&!pa&&"Gecko"==ta.product}var ua=u,w=pa,x=ra,va=qa;function wa(){var a=p.document;return a?a.documentMode:g}var xa;
a:{var ya="",za;if(ua&&p.opera)var Aa=p.opera.version,ya="function"==typeof Aa?Aa():Aa;else if(x?za=/rv\:([^\);]+)(\)|;)/:w?za=/\b(?:MSIE|rv)[: ]([^\);]+)(\)|;)/:va&&(za=/WebKit\/(\S+)/),za)var Ba=za.exec(sa()),ya=Ba?Ba[1]:"";if(w){var Ca=wa();if(Ca>parseFloat(ya)){xa=String(Ca);break a}}xa=ya}var Da={};
function y(a){var c;if(!(c=Da[a])){c=0;for(var b=oa(String(xa)).split("."),d=oa(String(a)).split("."),e=Math.max(b.length,d.length),f=0;0==c&&f<e;f++){var h=b[f]||"",m=d[f]||"",s=RegExp("(\\d*)(\\D*)","g"),B=RegExp("(\\d*)(\\D*)","g");do{var z=s.exec(h)||["","",""],A=B.exec(m)||["","",""];if(0==z[0].length&&0==A[0].length)break;c=((0==z[1].length?0:parseInt(z[1],10))<(0==A[1].length?0:parseInt(A[1],10))?-1:(0==z[1].length?0:parseInt(z[1],10))>(0==A[1].length?0:parseInt(A[1],10))?1:0)||((0==z[2].length)<
(0==A[2].length)?-1:(0==z[2].length)>(0==A[2].length)?1:0)||(z[2]<A[2]?-1:z[2]>A[2]?1:0)}while(0==c)}c=Da[a]=0<=c}return c}var Ea=p.document,Fa=!Ea||!w?g:wa()||("CSS1Compat"==Ea.compatMode?parseInt(xa,10):5);function C(a,c){this.width=a;this.height=c}C.prototype.floor=function(){this.width=Math.floor(this.width);this.height=Math.floor(this.height);return this};C.prototype.scale=function(a,c){this.width*=a;this.height*="number"==typeof c?c:a;return this};!x&&!w||w&&w&&9<=Fa||x&&y("1.9.1");w&&y("9");w&&y("9");!va||y("528");x&&y("1.9b")||w&&y("8")||ua&&y("9.5")||va&&y("528");x&&!y("8")||w&&y("9");function Ga(a){if("function"!=aa(a))if(a&&"function"==typeof a.handleEvent)a=r(a.handleEvent,a);else throw Error("Invalid listener argument");p.setTimeout(a,10)};function Ha(a,c){this.e=a;this.ob=c||[]}q("iSpring.ios.mobile.MobileAppCommand",Ha,g);Ha.prototype.id=function(){return this[ba]||(this[ba]=++ca)};function D(a){this.length=a.length||a;for(var c=0;c<this.length;c++)this[c]=a[c]||0}D.prototype.BYTES_PER_ELEMENT=8;D.prototype.set=function(a,c){c=c||0;for(var b=0;b<a.length&&c+b<this.length;b++)this[c+b]=a[b]};D.prototype.toString=Array.prototype.join;if("undefined"==typeof Float64Array){try{D.BYTES_PER_ELEMENT=8}catch(Ia){}D.prototype.BYTES_PER_ELEMENT=D.prototype.BYTES_PER_ELEMENT;D.prototype.set=D.prototype.set;D.prototype.toString=D.prototype.toString;q("Float64Array",D,g)};function E(a){this.length=a.length||a;for(var c=0;c<this.length;c++)this[c]=a[c]||0}E.prototype.BYTES_PER_ELEMENT=4;E.prototype.set=function(a,c){c=c||0;for(var b=0;b<a.length&&c+b<this.length;b++)this[c+b]=a[b]};E.prototype.toString=Array.prototype.join;"undefined"==typeof Float32Array&&(E.BYTES_PER_ELEMENT=4,E.prototype.BYTES_PER_ELEMENT=E.prototype.BYTES_PER_ELEMENT,E.prototype.set=E.prototype.set,E.prototype.toString=E.prototype.toString,q("Float32Array",E,g));new Float64Array(3);new Float64Array(3);new Float64Array(4);new Float64Array(4);new Float64Array(4);new Float64Array(16);function Ja(){var a;var c=window.location.search.substr(1);if(c){a={};for(var c=c.split("&"),b=0;b<c.length;++b){var d=c[b].split("=");if(2==d.length){var e=decodeURIComponent(d[0].replace(/\+/g," ")),d=decodeURIComponent(d[1].replace(/\+/g," ")),e=e.toLowerCase();a[e]=d}}}else a={};return a}function Ka(){try{La||(window.open("","_self",""),window.close())}catch(a){}};function Ma(){function a(a){try{for(var c=0;255>c;++c){if(a.API)return a.API;var e=a.parent;if(!e||a==e)break;a=e}}catch(f){}return j}var c=window;return a(c)||c.opener&&a(c.opener)}function Na(a){var c=Math.floor(a/3600),b=Math.floor(a%3600/60);a=Math.floor(a%60);return(10>c?"0"+c:c)+":"+(10>b?"0"+b:b)+":"+(10>a?"0"+a:a)}function Oa(){var a=document.getElementById("preloader");a&&a.parentNode.removeChild(a)};function Pa(a){this.c=a}Pa.prototype.r=function(){try{return Qa(this.c.LMSInitialize(""))}catch(a){}return k};Pa.prototype.terminate=function(a){F(this,"cmi.core.exit",a?"suspend":"");try{return Qa(this.c.LMSFinish(""))}catch(c){}return k};Pa.prototype.F=function(){try{return Qa(this.c.LMSCommit(""))}catch(a){}return k};function Ra(a,c){try{return a.c.LMSGetValue(c)}catch(b){}return""}
function F(a,c,b){if("number"==typeof b){var d;(d!==g?d:i)?b=parseFloat(b.toFixed(2))+"":(d=Math.pow(10,2),b=Math.floor(b*d)/d+"");b+=""}try{a.c.LMSSetValue(c,b)}catch(e){}}function Qa(a){return"true"==a};function Sa(a,c,b,d,e){this.pb=a;this.ba=c;this.ja=b;this.tb=d;this.sb=e}Sa.prototype.login=l("ba");Sa.prototype.password=l("ja");function Ta(a){this.ia=a};function Ua(a){this.N=a}Ua.prototype.na=function(a,c,b){b=this.N.hasOwnProperty(a)?this.N[a]:b;if(b!==g){if(c!==g){a=this.$;for(var d in c)if(c.hasOwnProperty(d)){var e=c[d];a&&(d=a(d));b=b.replace(RegExp(d,"g"),e)}}return b}return""};Ua.prototype.getMessage=Ua.prototype.na;Ua.prototype.$=function(a){return"%"+a.toUpperCase()+"%"};function Va(a,c,b,d,e,f){this.ka=a;this.C=c;this.aa=new Ua(b);this.nb=d;this.rb=e;this.qb=f}Va.prototype.quizId=l("ka");Va.prototype.i18n=l("aa");var Wa;Wa=k;var Xa=sa();Xa&&-1!=Xa.indexOf("Firefox")&&(Wa=i);var Ya=Wa;var Za=Ja().user_agent||sa()||"",$a=Ja().small_screen,ab=-1!=Za.toLowerCase().indexOf("chrome"),bb=-1!=Za.toLowerCase().indexOf("android"),cb,db=Za.toLowerCase();cb=-1!=db.indexOf("android")||-1!=db.indexOf("mobile")||-1!=db.indexOf("touch")||$a;var eb=w&&-1!=Za.toLowerCase().indexOf("touch"),La=bb&&!ab&&!Ya&&!ua;
if(!$a){var fb=$a?new C(document.documentElement.clientWidth,document.documentElement.clientHeight):eb?new C(screen.width*screen.deviceXDPI/screen.logicalXDPI,screen.height*screen.deviceYDPI/screen.logicalYDPI):La?new C(screen.width/window.devicePixelRatio,screen.height/window.devicePixelRatio):!cb&&Ya||w?new C(screen.width*window.devicePixelRatio,screen.height*window.devicePixelRatio):new C(screen.width,screen.height);Math.min(fb.width,fb.height)};function G(){}q("ispring.events.IEventDispatcher",G,g);G.prototype.addHandler=function(){};G.prototype.addHandler=G.prototype.addHandler;G.prototype.removeHandler=function(){};G.prototype.removeHandler=G.prototype.removeHandler;function H(a,c){this.q=a;this.t=c}H.prototype.id=l("q");H.prototype.description=l("t");function I(){this.l=[]}I.prototype.count=function(){return this.l.length};function J(a,c){a.l.push(c)}I.prototype.getChoice=function(a){if(0>a||a>=this.count())throw Error("Index out of bounds");return this.l[a]};function K(){this.l=new I}K.prototype.choices=l("l");function gb(){this.T=new I;this.V=new I};var L={id:"id",type:"type",score:"weighting",ma:"correct_responses.%INDEX%.pattern",s:"student_response",result:"result",duration:"latency",I:"time"},hb={};function ib(){}q("Tincan.MobileHttpTransport.onRequestComplete",function(a,c,b){var d;jb||(jb=new ib);d=jb;var e=d.M[a];if(e==j)return"";delete d.M[a];Ga(function(){if(c)e.onload(b);else e.onerror()});return"ok"},g);var jb=j;ib.prototype.M={};function kb(a){this.C=a.C}q("iSpring.quiz.LMSAPI.Scorm12Api",kb,g);n=kb.prototype;n.c=j;n.r=function(a,c){var b=Ma();(this.c=b?new Pa(b):j)&&this.c.r()?a():c()};n.start=function(){};n.F=function(){this.c.F()};n.suspend=function(){this.c.terminate(i);Oa();Ka()};n.terminate=function(){this.c.terminate(k);Oa();Ka()};n.H=function(a,c,b,d){d!==j&&(a=0<b-c?a/(b-c)*d:0,b=d);F(this.c,"cmi.core.score.min",c);F(this.c,"cmi.core.score.max",b);F(this.c,"cmi.core.score.raw",a)};var M={Fa:"initializing",Ha:"inProgress",ab:"reviewing",ta:"completed",qa:"authorizating"};q("ispring.quiz.session.QuizState",M,g);q("INITIALIZING","initializing",M);q("IN_PROGRESS","inProgress",M);q("REVIEWING","reviewing",M);q("COMPLETED","completed",M);q("AUTHORIZATING","authorizating",M);var N={gb:"slidePool",ra:"authorizationForm",Ea:"informationSlide",Ga:"introSlide",$a:"resultSlide",Ca:"hotspotQuestion",Ka:"likertScaleQuestion",lb:"wordBankQuestion",xa:"essayQuestion",jb:"typeInQuestion",fb:"shortAnswerQuestion",ya:"fillInTheBlankQuestion",za:"fillInTheBlankSurveyQuestion",Ta:"numericQuestion",Ua:"numericSurveyQuestion",eb:"sequenceQuestion",Za:"rankingQuestion",kb:"whichWordQuestion",Oa:"multipleChoiceTextQuestion",Pa:"multipleChoiceTextSurveyQuestion",Na:"multipleChoiceQuestion",
Qa:"multipleResponseQuestion",Xa:"pickOneQuestion",Wa:"pickManyQuestion",ib:"trueFalseQuestion",mb:"yesNoQuestion",La:"matchingQuestion",Ma:"matchingSurveyQuestion"};q("ispring.quiz.slides.SlideType",N,g);function lb(a){return"slidePool"!=a&&"informationSlide"!=a&&"introSlide"!=a&&"resultSlide"!=a}q("SLIDE_POOL","slidePool",N);q("INFORMATION_SLIDE","informationSlide",N);q("INTRO_SLIDE","introSlide",N);q("HOTSPOT_QUESTION","hotspotQuestion",N);q("LIKERT_SCALE_QUESTION","likertScaleQuestion",N);
q("WORD_BANK_QUESTION","wordBankQuestion",N);q("RESULT_SLIDE","resultSlide",N);q("ESSAY_QUESTION","essayQuestion",N);q("TYPE_IN_QUESTION","typeInQuestion",N);q("SHORT_ANSWER_QUESTION","shortAnswerQuestion",N);q("FILL_IN_THE_BLANK_QUESTION","fillInTheBlankQuestion",N);q("FILL_IN_THE_BLANK_SURVEY_QUESTION","fillInTheBlankSurveyQuestion",N);q("NUMERIC_QUESTION","numericQuestion",N);q("NUMERIC_SURVEY_QUESTION","numericSurveyQuestion",N);q("SEQUENCE_QUESTION","sequenceQuestion",N);
q("RANKING_QUESTION","rankingQuestion",N);q("WHICH_WORD_QUESTION","whichWordQuestion",N);q("MULTIPLE_CHOICE_TEXT_QUESTION","multipleChoiceTextQuestion",N);q("MULTIPLE_CHOICE_TEXT_SURVEY_QUESTION","multipleChoiceTextSurveyQuestion",N);q("MULTIPLE_CHOICE_QUESTION","multipleChoiceQuestion",N);q("MULTIPLE_RESPONSE_QUESTION","multipleResponseQuestion",N);q("PICK_ONE_QUESTION","pickOneQuestion",N);q("PICK_MANY_QUESTION","pickManyQuestion",N);q("TRUE_FALSE_QUESTION","trueFalseQuestion",N);
q("YES_NO_QUESTION","yesNoQuestion",N);q("MATCHING_QUESTION","matchingQuestion",N);q("MATCHING_SURVEY_QUESTION","matchingSurveyQuestion",N);function mb(a,c,b,d){for(var e=d?",":"[,]",f=d?".":"[.]",h=[],m=0;m<a.count();++m){var s=a.getMatch(m),B=s.premise(),s=s.response(),z=c.getChoiceIndex(B),A=b.getChoiceIndex(s),B=d?nb(z,i):z+"_"+B.textRange().text(),s=d?nb(A,k):A+"_"+s.textRange().text(),B=O(B)+f+O(s);h.push(B)}return h.join(e)}function ob(a,c,b){for(var d=b?",":"[,]",e=[],f=0;f<c.count();++f){var h=c.getChoice(f),m=h.textRange().text(),h=a.getChoiceIndex(h);e.push(O(b?nb(h,i):h+"_"+m))}return e.join(d)}
function O(a){a=oa(a);return a=a.replace(/[^\w-]/g,"_")}function nb(a,c){a=c?a:36-a-1;return 0<=a&&36>a?"0123456789abcdefghijklmnopqrstuvwxyz"[a]:"0"};function pb(){}pb.prototype.create=function(a){if(!a.submitted())return j;var c=a.slide().id(),c=new ha(O(c));this.a(c,a);return c};pb.prototype.a=function(a,c){var b=c.slide().description().text();a.t=b;c.visited()&&(b=c.viewDuration(),a.L=b,b=c.firstVisitTime(),a.W=b)};function qb(a){return O(a)};function P(){}t(P,pb);P.prototype.a=function(a,c){P.b.a.call(this,a,c);a.D="neutral"};function Q(a){this.i=a}t(Q,P);Q.prototype.i=k;Q.prototype.a=function(a,c){Q.b.a.call(this,a,c);a.e="sequencing";var b=c.slide().items(),d=ob(b,c.items(),this.i);a.f=d;a.d=[d];b=this.g(b);a.j=b};Q.prototype.g=function(a){for(var c=new K,b=0;b<a.count();++b){var d=a.getChoice(b).textRange().text();J(c.choices(),new H(O(b+"_"+d),d))}return c};var rb={ua:"correct",Va:"partiallyCorrect",Da:"incorrect",Sa:"notAnswered"};q("ispring.quiz.session.slides.questions.graded.review.GradedQuestionStatus",rb,g);q("CORRECT","correct",rb);q("PARTIALLY_CORRECT","partiallyCorrect",rb);q("INCORRECT","incorrect",rb);q("NOT_ANSWERED","notAnswered",rb);function R(){}t(R,pb);R.prototype.a=function(a,c){R.b.a.call(this,a,c);var b=c.slide();a.H(b.maxScore());if(b=c.review()){var d=b.awardedScore();a.J=d;d="unanticipated";switch(b.status()){case "correct":d="correct";break;case "incorrect":d="incorrect";break;case "partiallyCorrect":d="partially"}a.D=d}};var S={wa:"equals",va:"differs",Aa:"greaterThan",Ia:"lessThan",Ba:"greaterThanOrEquals",Ja:"lessThanOrEquals",sa:"between"};q("ispring.quiz.slides.questions.graded.answers.numeric.ComparisonOperation",S,g);q("EQUALS","equals",S);q("DIFFERS","differs",S);q("GREATER_THAN","greaterThan",S);q("LESS_THAN","lessThan",S);q("GREATER_THAN_OR_EQUALS","greaterThanOrEquals",S);q("LESS_THAN_OR_EQUALS","lessThanOrEquals",S);q("BETWEEN","between",S);function sb(){}t(sb,R);sb.prototype.a=function(a,c){sb.b.a.call(this,a,c);a.e="fill-in";var b=c.slide(),d=c.initiated()?c.getAnswer().toString():"",b=this.k(b.answers());a.f=d;a.d=[b]};
sb.prototype.k=function(a){for(var c=[],b=0;b<a.count();++b){var d="",e=a.getAnswer(b),f=e.comparisonOperation();if("between"==f)d=e,d="between "+d.leftOperand()+" and "+d.rightOperand();else switch(f){case "differs":d="not equal to "+e.operand();break;case "equals":d="equal to "+e.operand();break;case "greaterThan":d="greater than "+e.operand();break;case "greaterThanOrEquals":d="greater than or equal to "+e.operand();break;case "lessThan":d="less than "+e.operand();break;case "lessThanOrEquals":d=
"less than or equal to "+e.operand()}c.push(d)}return c.join("[,]")};function tb(){}t(tb,P);tb.prototype.a=function(a,c){tb.b.a.call(this,a,c);a.e="other";var b=this.B(c.blanks());a.f=b;a.d=[b]};tb.prototype.B=function(a){for(var c=[],b=0;b<a.count();++b)c.push(a.getSection(b).answer());return c.join("[,]")};function T(a){this.i=a}t(T,R);T.prototype.i=k;T.prototype.a=function(a,c){T.b.a.call(this,a,c);a.e="sequencing";var b=c.slide().items(),d=ob(b,c.items(),this.i),e=ob(b,b,this.i);a.f=d;a.d=[e];b=this.g(b);a.j=b};T.prototype.g=function(a){for(var c=new K,b=0;b<a.count();++b){var d=a.getChoice(b).textRange().text();J(c.choices(),new H(O(b+"_"+d),d))}return c};function ub(){}t(ub,R);ub.prototype.a=function(a,c){ub.b.a.call(this,a,c);a.e="other";for(var b=[],d=[],e=c.placeholders(),f=0;f<e.count();++f){var h=e.getSection(f),m=h.answer();m&&(b.push(m.textRange().text()),h=h.section().answers(),d.push(h.getChoice(0).textRange().text()))}d=d.join("[,]");a.f=b.join("[,]");a.d=[d]};function vb(){}t(vb,P);vb.prototype.a=function(a,c){vb.b.a.call(this,a,c);a.e="fill-in";var b=c.initiated()?c.answer().toString():"";a.f=b;a.d=[b]};function wb(){this.l=new I;this.K=[]}t(wb,K);function U(){}t(U,P);U.prototype.a=function(a,c){U.b.a.call(this,a,c);a.e="choice";var b=c.slide().choices(),d=c.choices(),e=this.A(b,d);a.f=e;a.d=[e];b=this.g(b,d);a.j=b};
U.prototype.g=function(a,c){for(var b=new wb,d=0;d<a.count();++d){var e=a.getChoice(d),f;a:{f=e;for(var h=0;h<c.count();++h){var m=c.getChoiceState(h);if(m.choice()===f){f=m;break a}}throw Error("can't find choice state");}h=e.textRange().text();h=new H(this.o(f,d),h);J(b.choices(),h);e=e.customAnswerEnabled()?f.customAnswer():"";b.K[d]=e}return b};
U.prototype.A=function(a,c){for(var b=[],d=0;d<c.count();++d){var e=c.getChoiceState(d);if(e.selected()){var f=a.getChoiceIndex(e.choice()),e=this.o(e,f);b.push(e)}}return b.join("[,]")};U.prototype.o=function(a,c){var b=a.customizableChoice(),d=b.textRange().text(),d=c+"_"+d;b.customAnswerEnabled()&&(b=a.customAnswer(),d+=b?"_"+b:"");return O(d)};function xb(a){this.i=a}t(xb,P);xb.prototype.a=function(a,c){xb.b.a.call(this,a,c);a.e="matching";var b=c.slide(),d=mb(c.matches(),b.premises(),b.responses(),this.i);a.f=d;a.d=[d];b=this.z(b);a.j=b};xb.prototype.z=function(a){var c=new gb,b=a.premises();a=a.responses();for(var d=0;d<b.count();++d){var e=b.getChoice(d).textRange().text(),f=a.getChoice(d).textRange().text();J(c.T,new H(O(d+"_"+e),e));J(c.V,new H(O(d+"_"+f),f))}return c};function V(){}t(V,R);V.prototype.a=function(a,c){V.b.a.call(this,a,c);a.e="choice";var b=c.slide().responses(),d=this.p(b,c.responses()),e=this.k(b);a.f=d;a.d=[e];b=this.g(b);a.j=b};V.prototype.g=function(a){for(var c=new K,b=0;b<a.count();++b){var d=a.getGradedChoice(b).textRange().text();J(c.choices(),new H(O(b+"_"+d),d))}return c};
V.prototype.p=function(a,c){for(var b=[],d=0;d<c.count();++d){var e=c.getChoiceState(d),f=e.gradedChoice(),h=f.textRange().text();e.selected()&&b.push(qb(a.getChoiceIndex(f)+"_"+h))}return b.join("[,]")};V.prototype.k=function(a){for(var c=[],b=0;b<a.count();++b){var d=a.getGradedChoice(b);d.correct()&&c.push(qb(b+"_"+d.textRange().text()))}return c.join("[,]")};function yb(){}t(yb,R);yb.prototype.a=function(a,c){yb.b.a.call(this,a,c);a.e="other";for(var b=[],d=[],e=c.choices(),f=0;f<e.count();++f){var h=e.getSection(f),m=h.choices(),h=h.section().choices();this.w(m,b);for(var m=h,h=d,s=0;s<m.count();++s){var B=m.getGradedChoice(s);B.correct()&&h.push(B.textRange().text())}}a.f=b.join("[,]");a.d=[d.join("[,]")]};
yb.prototype.w=function(a,c){for(var b=0;b<a.count();++b){var d=a.getChoiceState(b);if(d.selected()){c.push(d.gradedChoice().textRange().text());break}}};function W(){}t(W,R);W.prototype.a=function(a,c){W.b.a.call(this,a,c);a.e="choice";var b=c.slide().choices(),d=this.p(b,c.choices()),e=this.k(b);a.f=d;a.d=[e];b=this.g(b);a.j=b};W.prototype.g=function(a){for(var c=new K,b=0;b<a.count();++b){var d=a.getGradedChoice(b).textRange().text();J(c.choices(),new H(O(b+"_"+d),d))}return c};
W.prototype.p=function(a,c){for(var b="",d=0;d<c.count();++d){var e=c.getChoiceState(d);if(e.selected()){b=a.getChoiceIndex(e.gradedChoice())+"_"+e.gradedChoice().textRange().text();break}}return O(b)};W.prototype.k=function(a){for(var c="",b=0;b<a.count();++b){var d=a.getGradedChoice(b);if(d.correct()){c=b+"_"+d.textRange().text();break}}return O(c)};function zb(){}t(zb,P);zb.prototype.a=function(a,c){zb.b.a.call(this,a,c);a.e="other";var b=c.answer();a.f=b;b=[c.answer()];a.d=b};function X(){}t(X,P);X.prototype.a=function(a,c){X.b.a.call(this,a,c);a.e="choice";var b=c.slide().choices(),d=c.choices(),e=this.A(b,d);a.f=e;a.d=[e];b=this.g(b,d);a.j=b};
X.prototype.g=function(a,c){for(var b=new wb,d=0;d<a.count();++d){var e=a.getChoice(d),f;a:{f=e;for(var h=0;h<c.count();++h){var m=c.getChoiceState(h);if(m.choice()===f){f=m;break a}}throw Error("can't find choice state");}h=e.textRange().text();h=new H(this.o(f,d),h);J(b.choices(),h);e=e.customAnswerEnabled()?f.customAnswer():"";b.K[d]=e}return b};X.prototype.A=function(a,c){for(var b=0;b<c.count();++b){var d=c.getChoiceState(b);if(d.selected())return b=a.getChoiceIndex(d.choice()),this.o(d,b)}return O("")};
X.prototype.o=function(a,c){var b=a.customizableChoice(),d=b.textRange().text(),d=c+"_"+d;b.customAnswerEnabled()&&(b=a.customAnswer(),d+=b?"_"+b:"");return O(d)};function Ab(){}t(Ab,X);function Bb(){}t(Bb,R);Bb.prototype.a=function(a,c){Bb.b.a.call(this,a,c);a.e="other";var b=c.slide(),b=this.k(b.answers()),d=c.answer();a.f=d;a.d=[b]};Bb.prototype.k=function(a){for(var c=[],b=0;b<a.count();++b){var d=a.getAnswer(b);c.push(d.text())}return c.join("[,]")};function Cb(){}t(Cb,P);Cb.prototype.a=function(a,c){Cb.b.a.call(this,a,c);a.e="other";for(var b=[],d=c.choices(),e=0;e<d.count();++e)this.w(d.getSection(e).choices(),b);b=b.join("[,]");a.f=b;a.d=[b]};Cb.prototype.w=function(a,c){for(var b=0;b<a.count();++b){var d=a.getChoiceState(b);if(d.selected()){c.push(d.choice().textRange().text());break}}};function Db(){}t(Db,R);Db.prototype.a=function(a,c){Db.b.a.call(this,a,c);a.e="other";var b=this.B(c.blanks());a.f=b.s;a.d=[b.G]};Db.prototype.B=function(a){for(var c=[],b=[],d=0;d<a.count();++d){var e=[],f=a.getSection(d),h=f.section().answers();c.push(f.answer());for(f=0;f<h.count();++f)e.push(h.getAnswer(f).text());b.push(e.join("[,]"))}return{s:c.join("[,]"),G:b.join("[.]")}};function Y(){}t(Y,R);Y.prototype.a=function(a,c){Y.b.a.call(this,a,c);a.e="other";var b=c.slide(),d=this.p(c.points()),b=this.k(b.hotAreas());a.f=d;a.d=[b]};Y.prototype.p=function(a){for(var c=[],b=0;b<a.count();++b){var d=a.getPoint(b);c.push(d.x()+"_"+d.y())}return c.join("[,]")};Y.prototype.k=function(a){for(var c=[],b=0;b<a.count();++b){var d=a.getHotArea(b);c.push(d.type()+"_"+d.left()+"_"+d.top()+"_"+d.width()+"_"+d.height())}return c.join("[,]")};function Eb(){}t(Eb,P);Eb.prototype.a=function(a,c){Eb.b.a.call(this,a,c);a.e="long-fill-in";var b=c.answer();a.f=b;b=[c.answer()];a.d=b};function Z(a){this.i=a}t(Z,R);Z.prototype.i=k;Z.prototype.a=function(a,c){Z.b.a.call(this,a,c);a.e="matching";var b=c.slide(),d=mb(c.matches(),b.premises(),b.responses(),this.i),e=mb(b.matches(),b.premises(),b.responses(),this.i);a.f=d;a.d=[e];b=this.z(b);a.j=b};Z.prototype.z=function(a){var c=new gb;a=a.matches();for(var b=0;b<a.count();++b){var d=a.getMatch(b),e=d.premise().textRange().text(),d=d.response().textRange().text();J(c.T,new H(O(b+"_"+e),e));J(c.V,new H(O(b+"_"+d),d))}return c};function Fb(){}t(Fb,P);Fb.prototype.a=function(a,c){Fb.b.a.call(this,a,c);a.e="other";for(var b=[],d=c.placeholders(),e=0;e<d.count();++e){var f=d.getSection(e).answer();f&&b.push(f.textRange().text())}b=b.join("[,]");a.f=b;a.d=[b]};function Gb(){}t(Gb,P);Gb.prototype.a=function(a,c){Gb.b.a.call(this,a,c);a.e="choice";for(var b=c.slide(),d=c.statements(),e=d.count(),f=[],b=b.statements(),h=0;h<e;++h){var m=d.getStatementState(h),s=m.scale(),m=m.statement();s&&f.push(qb(b.getChoiceIndex(m)+"_"+s.textRange().text()))}d=f.join("[,]");a.f=d;a.d=[d];d=this.g(b);a.j=d};Gb.prototype.g=function(a){for(var c=new K,b=0;b<a.count();++b){var d=a.getChoice(b).textRange().text();J(c.choices(),new H(O(b+"_"+d),d))}return c};function Hb(){}t(Hb,W);function Ib(a,c){var b="1.2"==c||"aicc"==c;switch(a){case "essayQuestion":return new Eb;case "likertScaleQuestion":return new Gb;case "hotspotQuestion":return new Y;case "fillInTheBlankQuestion":return new Db;case "wordBankQuestion":return new ub;case "typeInQuestion":return new Bb;case "fillInTheBlankSurveyQuestion":return new tb;case "shortAnswerQuestion":return new zb;case "whichWordQuestion":return new Fb;case "numericQuestion":return new sb;case "multipleChoiceQuestion":return new W;case "multipleResponseQuestion":return new V;
case "numericSurveyQuestion":return new vb;case "multipleChoiceTextQuestion":return new yb;case "sequenceQuestion":return new T(b);case "multipleChoiceTextSurveyQuestion":return new Cb;case "rankingQuestion":return new Q(b);case "pickManyQuestion":return new U;case "matchingQuestion":return new Z(b);case "matchingSurveyQuestion":return new xb(b);case "pickOneQuestion":return new X;case "trueFalseQuestion":return new Hb;case "yesNoQuestion":return new Ab}return j};var Jb={bb:"1.2",cb:"2004",hb:"tincan",oa:"aicc"};q("ispring.lmsconnector.ApiVersion",Jb,g);q("SCORM12","1.2",Jb);q("SCORM2004","2004",Jb);q("TINCAN","tincan",Jb);q("AICC","aicc",Jb);function Kb(a,c){var b=window.iSpring.quiz.LMSAPI;switch(a){case "1.2":return new b.Scorm12Api(c);case "2004":return new b.Scorm2004Api(c);case "aicc":return new b.AiccApi(c);case "tincan":return new b.TinCanApi(c)}throw Error("unknown api");};var Lb={Ya:"prompt",pa:"always",Ra:"never"};q("ispring.quiz.ResumeType",Lb,g);q("PROMPT_TO_RESUME","prompt",Lb);q("ALWAYS_RESUME","always",Lb);q("NEVER_RESUME","never",Lb);function $(a,c){this.Y=a;var b=c.tincan.auth,b=new Va(c.quizId,new Ta(c.flags),c.tincan.i18n,c.scorm2004?c.scorm2004.edition:"",c.tincan.endPoint,new Sa(b.type,b.login,b.password,b.name,b.email));this.U="never"!=c.resumeMode;this.h=Kb(a,b)}$.prototype.u=k;$.prototype.n=k;var Mb=$.prototype.m=j;q("iSpring.quiz.LMS.create",function(a,c){return Mb=new $(a,c)},g);q("iSpring.quiz.LMS.instance",function(){return Mb},g);$.prototype.r=function(a){this.h.r(r(this.ga,this,a),r(this.fa,this,a))};
$.prototype.initialize=$.prototype.r;$.prototype.ga=function(a){this.u=i;var c;if(this.U){var b=Ra(this.h.c,"cmi.suspend_data");if(b)a:{b=LZString.decompressFromBase64(b);try{c=ia(b);break a}catch(d){}c=j}else c=j}else c=j;a&&a(c)};$.prototype.fa=function(a){a&&a()};
$.prototype.start=function(a){if(this.u){this.R=a;a.closeWindowEvent().addHandler(this.da,this);a.startupCompleted()?this.P():a.startupCompletedEvent().addHandler(this.P,this);var c=new ga(Ra(this.h.c,"cmi.core.student_id"),Ra(this.h.c,"cmi.core.student_name"),"");c&&a.setUserInfo(c.id(),{USER_NAME:c.name(),USER_EMAIL:c.email()});this.U&&a.stateChangedEvent().addHandler(this.ha,this)}};$.prototype.start=$.prototype.start;
$.prototype.P=function(){var a=this.R,c=a.currentSession();c&&Nb(this,c);a.currentSessionChangedEvent().addHandler(this.ea,this)};$.prototype.ha=function(a){a.actionPrevented()||(a.preventAction(),Ob(this))};function Ob(a){var c=a.R.persistState();a=a.h;var b=[];ka(new ja,c,b);c=LZString.compressToBase64(b.join(""));F(a.c,"cmi.suspend_data",c)}$.prototype.ea=function(a){this.n?(Pb(this,this.m),this.m=a,Qb(this,a)):Nb(this,a)};function Nb(a,c){a.n=i;a.la=fa();a.m=c;a.h.start(c);Qb(a,c)}
function Qb(a,c){c.quizStateChangeEvent().addHandler(a.Q,a);c.slidePoolState().forEach(function(b){var c=b.slide().type();lb(c)&&b.submitEvent().addHandler(a.O,a)});Rb(a)}function Pb(a,c){c.quizStateChangeEvent().removeHandler(a.Q,a);c.slidePoolState().forEach(function(b){var c=b.slide().type();lb(c)&&b.submitEvent().removeHandler(a.O,a)})}$.prototype.X=function(){if(this.u){this.u=k;if(this.n){this.n=k;var a=fa()-this.la;F(this.h.c,"cmi.core.session_time",Na(a/1E3));Ob(this);Pb(this,this.m)}this.h.suspend()}};
$.prototype.closeLms=$.prototype.X;function Sb(a){a=a.quizState();return"completed"==a||"reviewing"==a}$.prototype.Q=function(){Sb(this.m)&&Rb(this)};
function Rb(a){var c=a.m,b="graded"==c.quiz().type()?c:j;if(b){var d=c.settings();a.h.H(b.awardedScore(),0,b.maxScore(),d.normalizedScoreEnabled()?d.maxNormalizedMeasure():j)}var e=(d=Sb(c))&&b?b.quizPassed():j,b=a.h,d=(c=e===j)?d:e,e="unknown";d===j||(e=c||!(b.C.ia&(d?2:1))?d?"completed":"incomplete":d?"passed":"failed");F(b.c,"cmi.core.lesson_status",e);a.h.F()}
$.prototype.O=function(a){if(a.initiated()){var c=Ib(a.slide().type(),this.Y).create(a);if(c){a=this.h.c;var b=c.id(),d=-1;c.id()in hb?d=hb[b]:(d=parseInt(Ra(a,"cmi.interactions._count"),10),d=250<=d?-1:d,hb[b]=d);if(!(0>d)){b="cmi.interactions."+d+".";F(a,b+L.id,c.id());F(a,b+L.type,c.type());F(a,b+L.score,c.score());for(var d=c.G()||[],e=0;e<d.length;++e){var f=L.ma.replace("%INDEX%",e);F(a,b+f,d[e])}(d=c.s())&&F(a,b+L.s,d);F(a,b+L.result,c.result());d=c.duration();d===j||F(a,b+L.duration,Na(d/
1E3));c=c.I();c===j||F(a,b+L.I,Na(3600*c.getHours()+60*c.getMinutes()+c.getSeconds()))}}}};$.prototype.da=function(a){this.n&&(a.suspend(),this.X())};})();
var LZString={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",_f:String.fromCharCode,compressToBase64:function(e){if(e==null)return"";var t="";var n,r,i,s,o,u,a;var f=0;e=LZString.compress(e);while(f<e.length*2){if(f%2==0){n=e.charCodeAt(f/2)>>8;r=e.charCodeAt(f/2)&255;if(f/2+1<e.length)i=e.charCodeAt(f/2+1)>>8;else i=NaN}else{n=e.charCodeAt((f-1)/2)&255;if((f+1)/2<e.length){r=e.charCodeAt((f+1)/2)>>8;i=e.charCodeAt((f+1)/2)&255}else r=i=NaN}f+=3;s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+LZString._keyStr.charAt(s)+LZString._keyStr.charAt(o)+LZString._keyStr.charAt(u)+LZString._keyStr.charAt(a)}return t},decompressFromBase64:function(e){if(e==null)return"";var t="",n=0,r,i,s,o,u,a,f,l,c=0,h=LZString._f;e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(c<e.length){u=LZString._keyStr.indexOf(e.charAt(c++));a=LZString._keyStr.indexOf(e.charAt(c++));f=LZString._keyStr.indexOf(e.charAt(c++));l=LZString._keyStr.indexOf(e.charAt(c++));i=u<<2|a>>4;s=(a&15)<<4|f>>2;o=(f&3)<<6|l;if(n%2==0){r=i<<8;if(f!=64){t+=h(r|s)}if(l!=64){r=o<<8}}else{t=t+h(r|i);if(f!=64){r=s<<8}if(l!=64){t+=h(r|o)}}n+=3}return LZString.decompress(t)},compressToUTF16:function(e){if(e==null)return"";var t="",n,r,i,s=0,o=LZString._f;e=LZString.compress(e);for(n=0;n<e.length;n++){r=e.charCodeAt(n);switch(s++){case 0:t+=o((r>>1)+32);i=(r&1)<<14;break;case 1:t+=o(i+(r>>2)+32);i=(r&3)<<13;break;case 2:t+=o(i+(r>>3)+32);i=(r&7)<<12;break;case 3:t+=o(i+(r>>4)+32);i=(r&15)<<11;break;case 4:t+=o(i+(r>>5)+32);i=(r&31)<<10;break;case 5:t+=o(i+(r>>6)+32);i=(r&63)<<9;break;case 6:t+=o(i+(r>>7)+32);i=(r&127)<<8;break;case 7:t+=o(i+(r>>8)+32);i=(r&255)<<7;break;case 8:t+=o(i+(r>>9)+32);i=(r&511)<<6;break;case 9:t+=o(i+(r>>10)+32);i=(r&1023)<<5;break;case 10:t+=o(i+(r>>11)+32);i=(r&2047)<<4;break;case 11:t+=o(i+(r>>12)+32);i=(r&4095)<<3;break;case 12:t+=o(i+(r>>13)+32);i=(r&8191)<<2;break;case 13:t+=o(i+(r>>14)+32);i=(r&16383)<<1;break;case 14:t+=o(i+(r>>15)+32,(r&32767)+32);s=0;break}}return t+o(i+32)},decompressFromUTF16:function(e){if(e==null)return"";var t="",n,r,i=0,s=0,o=LZString._f;while(s<e.length){r=e.charCodeAt(s)-32;switch(i++){case 0:n=r<<1;break;case 1:t+=o(n|r>>14);n=(r&16383)<<2;break;case 2:t+=o(n|r>>13);n=(r&8191)<<3;break;case 3:t+=o(n|r>>12);n=(r&4095)<<4;break;case 4:t+=o(n|r>>11);n=(r&2047)<<5;break;case 5:t+=o(n|r>>10);n=(r&1023)<<6;break;case 6:t+=o(n|r>>9);n=(r&511)<<7;break;case 7:t+=o(n|r>>8);n=(r&255)<<8;break;case 8:t+=o(n|r>>7);n=(r&127)<<9;break;case 9:t+=o(n|r>>6);n=(r&63)<<10;break;case 10:t+=o(n|r>>5);n=(r&31)<<11;break;case 11:t+=o(n|r>>4);n=(r&15)<<12;break;case 12:t+=o(n|r>>3);n=(r&7)<<13;break;case 13:t+=o(n|r>>2);n=(r&3)<<14;break;case 14:t+=o(n|r>>1);n=(r&1)<<15;break;case 15:t+=o(n|r);i=0;break}s++}return LZString.decompress(t)},compress:function(e){if(e==null)return"";var t,n,r={},i={},s="",o="",u="",a=2,f=3,l=2,c="",h=0,p=0,d,v=LZString._f;for(d=0;d<e.length;d+=1){s=e.charAt(d);if(!Object.prototype.hasOwnProperty.call(r,s)){r[s]=f++;i[s]=true}o=u+s;if(Object.prototype.hasOwnProperty.call(r,o)){u=o}else{if(Object.prototype.hasOwnProperty.call(i,u)){if(u.charCodeAt(0)<256){for(t=0;t<l;t++){h=h<<1;if(p==15){p=0;c+=v(h);h=0}else{p++}}n=u.charCodeAt(0);for(t=0;t<8;t++){h=h<<1|n&1;if(p==15){p=0;c+=v(h);h=0}else{p++}n=n>>1}}else{n=1;for(t=0;t<l;t++){h=h<<1|n;if(p==15){p=0;c+=v(h);h=0}else{p++}n=0}n=u.charCodeAt(0);for(t=0;t<16;t++){h=h<<1|n&1;if(p==15){p=0;c+=v(h);h=0}else{p++}n=n>>1}}a--;if(a==0){a=Math.pow(2,l);l++}delete i[u]}else{n=r[u];for(t=0;t<l;t++){h=h<<1|n&1;if(p==15){p=0;c+=v(h);h=0}else{p++}n=n>>1}}a--;if(a==0){a=Math.pow(2,l);l++}r[o]=f++;u=String(s)}}if(u!==""){if(Object.prototype.hasOwnProperty.call(i,u)){if(u.charCodeAt(0)<256){for(t=0;t<l;t++){h=h<<1;if(p==15){p=0;c+=v(h);h=0}else{p++}}n=u.charCodeAt(0);for(t=0;t<8;t++){h=h<<1|n&1;if(p==15){p=0;c+=v(h);h=0}else{p++}n=n>>1}}else{n=1;for(t=0;t<l;t++){h=h<<1|n;if(p==15){p=0;c+=v(h);h=0}else{p++}n=0}n=u.charCodeAt(0);for(t=0;t<16;t++){h=h<<1|n&1;if(p==15){p=0;c+=v(h);h=0}else{p++}n=n>>1}}a--;if(a==0){a=Math.pow(2,l);l++}delete i[u]}else{n=r[u];for(t=0;t<l;t++){h=h<<1|n&1;if(p==15){p=0;c+=v(h);h=0}else{p++}n=n>>1}}a--;if(a==0){a=Math.pow(2,l);l++}}n=2;for(t=0;t<l;t++){h=h<<1|n&1;if(p==15){p=0;c+=v(h);h=0}else{p++}n=n>>1}while(true){h=h<<1;if(p==15){c+=v(h);break}else p++}return c},decompress:function(e){if(e==null)return"";if(e=="")return null;var t=[],n,r=4,i=4,s=3,o="",u="",a,f,l,c,h,p,d,v=LZString._f,m={string:e,val:e.charCodeAt(0),position:32768,index:1};for(a=0;a<3;a+=1){t[a]=a}l=0;h=Math.pow(2,2);p=1;while(p!=h){c=m.val&m.position;m.position>>=1;if(m.position==0){m.position=32768;m.val=m.string.charCodeAt(m.index++)}l|=(c>0?1:0)*p;p<<=1}switch(n=l){case 0:l=0;h=Math.pow(2,8);p=1;while(p!=h){c=m.val&m.position;m.position>>=1;if(m.position==0){m.position=32768;m.val=m.string.charCodeAt(m.index++)}l|=(c>0?1:0)*p;p<<=1}d=v(l);break;case 1:l=0;h=Math.pow(2,16);p=1;while(p!=h){c=m.val&m.position;m.position>>=1;if(m.position==0){m.position=32768;m.val=m.string.charCodeAt(m.index++)}l|=(c>0?1:0)*p;p<<=1}d=v(l);break;case 2:return""}t[3]=d;f=u=d;while(true){if(m.index>m.string.length){return""}l=0;h=Math.pow(2,s);p=1;while(p!=h){c=m.val&m.position;m.position>>=1;if(m.position==0){m.position=32768;m.val=m.string.charCodeAt(m.index++)}l|=(c>0?1:0)*p;p<<=1}switch(d=l){case 0:l=0;h=Math.pow(2,8);p=1;while(p!=h){c=m.val&m.position;m.position>>=1;if(m.position==0){m.position=32768;m.val=m.string.charCodeAt(m.index++)}l|=(c>0?1:0)*p;p<<=1}t[i++]=v(l);d=i-1;r--;break;case 1:l=0;h=Math.pow(2,16);p=1;while(p!=h){c=m.val&m.position;m.position>>=1;if(m.position==0){m.position=32768;m.val=m.string.charCodeAt(m.index++)}l|=(c>0?1:0)*p;p<<=1}t[i++]=v(l);d=i-1;r--;break;case 2:return u}if(r==0){r=Math.pow(2,s);s++}if(t[d]){o=t[d]}else{if(d===i){o=f+f.charAt(0)}else{return null}}u+=o;t[i++]=f+o.charAt(0);r--;f=o;if(r==0){r=Math.pow(2,s);s++}}}};if(typeof module!=="undefined"&&module!=null){module.exports=LZString}
