var Xlock;
var benchtime=new Date();
function bench_start(){
	benchtime=new Date();
	//document.title='start:0';
}
function bench_tick(label){
	if(!label) label='';
	var benchtime_now = new Date();
}

/*
_ajax_post() allow to do an ajax call (post) with global (_post_onload, applyied on whole page) and local (_post, one shoot apply) passed values,
its usage require the following set up on each page:
-include this .js
-set any global (will be posted on each call), minimum requirement is URL for callback: _post_onload.URL='ajax.php';
-set any local (will be posted then erased), see example below.

usage example, head script section:
_post_onload.URL=ajax.php;
_post_onload.orderId=55;
usage example, body section:
<input type="button" onclick="_post.rowId=55;_ajax_post('deleteRow', this);" />
*/
var _post = new Object();
var _post_onload = new Object();
var _ajax_var = new Object();
_post_onload.URL='';

function _ajax_post(action, o){
	//url not passed as post but as ajax call destination
	
	url='';
	if(_post['URL']){ //call based
		url=_post['URL'];
	}else{ //else page based
		url=_post_onload['URL'];
	}
	
 	post='';
 	if(action){
		//action works like local
		post+='&_ajax_action=' + action;
	}
	//global
	for (var i in _post_onload) if(i!='URL'){	
	 	value=_post_onload[i];
	 	post+='&'+i+'='+value;
	 }
	//local
	for (var i in _post) if(i!='URL'){
	 	value=_post[i];
	 	if(typeof value == 'string'){
	 		value=value.replace(/\+/g,'%2B');
	 		//TODO find better replacement...
	 		value=value.replace(/&/g,' et '); //value=value.replace(/&/g,'%26');
	 	}
	 	post+='&'+i+'='+value;
	 }
	_post = new Object();//reset local
	Xajax(url,  post ,'Xfill', o);	
}

function _ajax_post_confirm(action, msg){
	if(msg==undefined)
		msg = "Etes-vous sûr?";
	if (confirm(msg)){
		_ajax_post(action);
	}
}
function _post(attr,val){
	_post[attr]=val;
}
function _post_node(node){
	_post['_node_id']=node.id;
	_post['_node_value']=node.value;
}

function _ajax_post_sync(action, o){
	url='';
	if(_post['URL']){
		url=_post['URL'];
	}else{
		url=_post_onload['URL'];
	}
	
 	post='';
	post+='&_ajax_action=' + action;
	for (var i in _post_onload) if(i!='URL'){	
	 	value=_post_onload[i];
	 	post+='&'+i+'='+value;
	 }
	for (var i in _post) if(i!='URL'){
	 	value=_post[i];
	 	if(typeof value == 'string'){
	 		value=value.replace(/\+/g,'%2B');
	 		value=value.replace(/&/g,' et ');
	 	}
	 	post+='&'+i+'='+value;
	 }
	_post = new Object();
	XajaxSync(url,  post ,'Xfill', o);	
}

function Xajax(url,post,xfunc,hl) {
	XajaxGeneric(url,post,xfunc,hl,true);
}

function XajaxSync(url,post,xfunc,hl) {
	XajaxGeneric(url,post,xfunc,hl,false);
}

function XajaxGeneric(url,post,xfunc,hl,is_asynchronous){
	// h1 No more use....
	document.body.style.cursor = "wait";

	bench_start();

	if(hl){
		//hl_undo=hl.style.backgroundColor;
		//hl.style.backgroundColor = "#dede87";
		//hl_undo= new Object();
		//hl_undo.image=$('#'+hl.id).css("background-image");
		//hl_undo.repeat=$(hl).css("background-repeat");
		//hl_undo.color=$(hl).css("background-color");
		//$(hl).css("background-image","url('ajaxwait.gif')");
		//$(hl).css("background-repeat","repeat");
		//$(hl).css("background-color", "#de8787");
			
	}
	function ajaxObject(){
		if (document.all && !window.opera) obj = new ActiveXObject("Microsoft.XMLHTTP");
		else obj = new XMLHttpRequest();
		return obj;
	}
	var ajaxHttp = ajaxObject();
	ajaxHttp.open('POST', url, is_asynchronous);
	ajaxHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');	
	ajaxHttp.onreadystatechange =
		function(){
			if(ajaxHttp.readyState == 4){
				
				if(xfunc) {
					eval(xfunc+'(\''+escape(ajaxHttp.responseText)+'\');');
				}

				document.body.style.cursor = "auto";
				Xlock = 0;
				bench_tick('ajax_end');
			}
		}

	ajaxHttp.send(post);
	// If synchronous, there's no readystate modification...
	if (!is_asynchronous) {
		document.body.style.cursor = "auto";
		Xlock = 0;		
	}
	else {
		Xlock = 1;
	}	   
}

/*
@desc parse server side callback then do client side actions
-added [append],[after], [prepend], [remove], [hide], [show], [wait]
-added [location]: document redirection, if empty url, document refresh
-added [set]: support replacing both input value or tag innerHTML, and value select
-added [value], [inner], [focus], [select], [class], [altsrc]
*/
function Xfill(html){
	html=unescape(html);
	if(html.indexOf('XDBUG')>0 || html.indexOf("( ! )")>0 || html.indexOf(">Call Stack")>0){
		html='<fieldset style="border:5px solid red;"><legend>Debug AJAX</legend>'+html+'</fieldset>';
		$("body").prepend(html);
	}
	td=html.split('</xfill>');
	bench_tick('fill_start');
	for( i = 0; i < td.length; i++){
		//alert(td[i]);
		td[i]=td[i].replace(/^\s+/g,'').replace(/\s+$/g,''); //trim fix
		if(td[i].length>0){
			//replace innerHTML by id
			if(td[i].indexOf('<xfill type="inner">')>0){
				o=td[i].split('<xfill type="inner">');
				if(document.getElementById(o[0]))
					id=o[0].replace(/:/, "\\\\:"); // jquery colon in id escaping
					$("#"+id).html(o[1]); //new mandatory method for jquery.livequery
			}
			//set value by id
			else if(td[i].indexOf('<xfill type="value">')>0){
				o=td[i].split('<xfill type="value">');
				if(document.getElementById(o[0]))
					document.getElementById(o[0]).value = o[1];
			}
			//if input tag: set value by id
			//if select tag: set selected value by id
			//else: replace innerHTML by id
			else if(td[i].indexOf('<xfill type="set">')>0){
				o=td[i].split('<xfill type="set">');
				if(document.getElementById(o[0])){
					switch(document.getElementById(o[0]).tagName){					
						case 'INPUT':
							document.getElementById(o[0]).value = o[1];
						break;
						case 'SELECT':
							for (var idx=0;idx<document.getElementById(o[0]).options.length;idx++) {
								if (o[1]==document.getElementById(o[0]).options[idx].value) {
									document.getElementById(o[0]).selectedIndex=idx;
									break;
								}
							}
						break;
						default:
							id=o[0].replace(/:/, "\\\\:"); // jquery colon in id escaping
							$("#"+id).html(o[1]); //new mandatory method for jquery.livequery
						break;
					}
				}		
			}
			// set an _ajax_var property
			else if(td[i].indexOf('<xfill type="var">')>0){
				o=td[i].split('<xfill type="var">');
				_ajax_var[o[0]]=o[1];
				alert(_ajax_var[o[0]]);
			}
			// select (highlight) form element value by id
			else if(td[i].indexOf('<xfill type="select">')>0){
				o=td[i].split('<xfill type="select">');
				if(document.getElementById(o[0])){
					document.getElementById(o[0]).select();
					document.getElementById(o[0]).focus(); //scroll to element
					
				}
			}
			// focus on form element by id 
			else if(td[i].indexOf('<xfill type="focus">')>0){
				o=td[i].split('<xfill type="focus">');
				//alert(o[0]);
				if(document.getElementById(o[0]))
					document.getElementById(o[0]).focus();
			}
			// change node class by id
			else if(td[i].indexOf('<xfill type="class">')>0){
				o=td[i].split('<xfill type="class">');
				if(document.getElementById(o[0]))
					document.getElementById(o[0]).className = o[1];
			}
			else if(td[i].indexOf('<xfill type="altsrc">')>0){
				o=td[i].split('<xfill type="altsrc">');
				if(document.getElementById(o[0])){
					document.getElementById(o[0]).alt = o[1];
					document.getElementById(o[0]).src = o[1]+'.png';
				}
			}
			// document close
			else if(td[i].indexOf('<xfill type="close">')>0){
				//not working yet
			}
			// document new location, if empty, refresh location
			else if(td[i].indexOf('<xfill type="location">')>0){
				o=td[i].split('<xfill type="location">');
				if(o[1]=='') location.reload();
				else location.replace(o[1]);
			}
			// document popup
			else if(td[i].indexOf('<xfill type="popup">')>0){
				o=td[i].split('<xfill type="popup">');
				window.open(o[1]);
			}
			
			
			//DOM append to element by id
			else if(td[i].indexOf('<xfill type="append">')>0){			
				o=td[i].split('<xfill type="append">');				
				$('#'+o[0]).append(o[1]);
			}
			//DOM after to element by id
			else if(td[i].indexOf('<xfill type="after">')>0){			
				o=td[i].split('<xfill type="after">');				
				$('#'+o[0]).after(o[1]);
			}
			//DOM prepend to element by id
			else if(td[i].indexOf('<xfill type="prepend">')>0){				
				o=td[i].split('<xfill type="prepend">');				
				$('#'+o[0]).prepend(o[1]);
			}
			// show modal window
			else if(td[i].indexOf('<xfill type="modal">')>0){			
				o=td[i].split('<xfill type="modal">');		
				showSimpleModal(o[1], true);
			}
			//DOM replace
			else if(td[i].indexOf('<xfill type="html">')>0){				
				o=td[i].split('<xfill type="html">');				
				$('#'+o[0]).html(o[1]);
			}
			//DOM remove element by id
			else if(td[i].indexOf('<xfill type="remove">')>0){	
				o=td[i].split('<xfill type="remove">');			
				$('#'+o[0]).remove();
			}
			//DOM hide element by id
			else if(td[i].indexOf('<xfill type="hide">')>0){				
				o=td[i].split('<xfill type="hide">');				
				$('#'+o[0]).hide();
			}
			//DOM show element by id
			else if(td[i].indexOf('<xfill type="show">')>0){				
				o=td[i].split('<xfill type="show">');				
				$('#'+o[0]).show();
			}
			//trigger alert
			else if(td[i].indexOf('<xfill type="alert">')>0){				
				o=td[i].split('<xfill type="alert">');		
				alert(o[1]);
			}
			//show wait overlay
			else if(td[i].indexOf('<xfill type="wait">')>0){				
				//o=td[i].split('<xfill type="wait">');	
				$.blockUI('<img src="loading.gif" />');
			}
			//hide wait overlay
			else if(td[i].indexOf('<xfill type="endwait">')>0){				
				//o=td[i].split('<xfill type="endwait">');	
				$.unblockUI();
			}
			else if(td[i].indexOf('<xfill type="dbug_clean">')!=-1){
		
				$("#body_ajax_dbug > div").remove();
			}
			// eval
			else if(td[i].indexOf('<xfill type="eval">')>0){
				o=td[i].split('<xfill type="eval">');
				//showSimpleModal(o[1],true);
				eval(o[1]);
			}
			// ajax dbug
			else if(td[i].indexOf('<xfill type="dbug">')!=-1){
				o=td[i].split('<xfill type="dbug">');
				if($('#body_ajax_dbug').length==0){
					html='<fieldset id="body_ajax_dbug" style="z-index:5000;position:absolute;top:32px;right:10%;width:50%;padding:2px;background:#ff7;color:#000border:5px solid red;"><legend id="body_ajax_dbug_handle" ondblclick="$(this).parent().remove();">Debug AJAX</legend></fieldset>';
					$("body").prepend(html);
				}
				$("#body_ajax_dbug").append('<div style="margin:5px;border:1px dotted black;" ondblclick="$(this).remove();" >'+o[1]+'</div>');
			}
			
		}
	}
	//document.title=doc_title;
	bench_tick('fill_end');
}

function Xurl(url){
	location.replace(unescape(url));
}
function Xdbug(html){
	alert(unescape(html));
}
