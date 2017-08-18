//Sanuich AjaxControls core scripts
//meaning of some parameters
//tagname: id of HTML TAG where returned data will be printed
//query: function name in model
//cond: string of patrameters for set query conditions if function gets data throu SQL
//      or other purposes. Format: field1,field2,...fieldN###value1,value2,...valueN (see controls.php)
//
function filloptions(tagname,query,cond,name,selected,all,func)
{
  $("#"+tagname).html('<img src="/bundles/Sanuich/AjaxControls/asset/img/throbber_o.gif" />');
  if(selected==undefined || selected==''){selected="-1";}//value of selected option. undefined or -1 for none
  if(all==undefined || all==''){all="0";}//add option - <option value="%">All</option> 1-yes,0-no
  if(name==undefined){name="";}//add disabled option with name and "-1" value of select. 
  //to make this option selected - set selected to "-1"
  //if(selected=="%" && all==0){all="1";}
  if(cond==undefined){cond="";}//
  $.ajax
    ({
      type: "POST",
      url: "/Sanuich/AjaxControls/fill_options/",
      data: {query: query, cond: cond, name: name, selected: selected, all: all}
     }).done(function( msg ) 
        {   
            $("#"+tagname).html(msg);
            if(func!==undefined && func!=''){window[func]();}            
        });
  return true;
}

function filldivs(tagname,query,cond,name,clas,click)
{
    $("#"+tagname).html('<img src="/bundles/Sanuich/AjaxControls/asset/img/throbber_o.gif" />');
	if(cond==undefined || cond==[] || cond==''){cond="";}
    if(name==undefined){name="";}
    if(clas==undefined){clas="";}//custom css class name of TAG
	if(click==undefined){click="";}//js function name for onclick event that use id field of returned array 
					//by query function in fills model
    $.ajax
        ({
            type: "POST",
            url: "/Sanuich/AjaxControls/fill_divs/",
			data: {query: query, cond: cond, name: name, clas: clas, click: click}
        }).done(function( msg ) 
        {   
            $("#"+tagname).html(msg);
        });
	return true;
}

function filltable(tagname,query,cond,name,head,id,options,name_function)
{
    $("#"+tagname).html('<img src="/bundles/Sanuich/AjaxControls/asset/img/throbber_o.gif" />');
	if(name==undefined){name="";}
	if(head==undefined || head!=''){head="1";}
    if(id==undefined || id!=''){id="1";}
    if(options==undefined){options="1";}//add column with options - edit and delete buttons that will call edit(id) and delete(id) js functions where id - id filed of returned array
    if(name_function==undefined){name_function="0";}//js function name that will be called by clicking on "name" column in table
	//if in column name presents 'hidden' - this column will be display:hidden
    if(cond==undefined){cond="";}
    $.ajax
    ({
        type: "POST",
        url: "/Sanuich/AjaxControls/fill_table/",
		data: {query: query, cond: cond, name: name, head: head, id: id, options: options, name_function: name_function}
    }).done(function( msg ) 
    {   
        $("#"+tagname).html(msg);
    });
	return true;
}

function get_data(tagname,query,cond,field_name)
{
	//field_name: value of field name field_name of 0 row from resulted array - returned by query function
	$("#"+tagname).html('<img src="/bundles/Sanuich/AjaxControls/asset/img/throbber_o.gif" />');
	if(cond==undefined){cond="";}
    $.ajax
    ({
        type: "POST",
        url: "/Sanuich/AjaxControls/get_data/",
		data: {query: query, cond: cond, field_name: field_name}
    }).done(function( msg ) 
    {        
        $("#"+tagname).html(msg);
    });
	return true;
}