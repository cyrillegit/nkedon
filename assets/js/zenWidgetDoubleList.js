/****************************************************
 * zenWidgetDoubleList - jQuery plugin
 *
 *	http://www.zen-in-progress.com/zenWidgetDoubleList
 *
 * Copyright (c) 2010 BAREAU Stéphane
 *
 *
 *
 * Licence  : Creative Commons (by-nc-sa) 
 *   http://creativecommons.org/licenses/by-nc-sa/3.0/
 *
 ****************************************************/
 (function($) {
  // plugin definition
  $.fn.zenWidgetDoubleList = function(options) {
    var opts = $.extend({}, $.fn.zenWidgetDoubleList.defaults, options);
    
    return this.each(function(i,elt) {            
      $this = $(this);
      // Determine or build an ID for the reference list
      id = $this.attr('id');
      if( 0 == id.length) 
      {        
        id = 'wdl'+i; 
        j = i;
        while( 0 < $('#'+id).length ) id = 'wdl'+j++; 
        $this.attr('id',id);
      }
      size = $this.attr('size');
      if( 0 == size ) size = opts.default_size;
      //creation of each container : element associated, element unassociated, labels , button
      $('#'+id).wrap('<div id="'+id+'_dl"></div>');
      $('#'+id+'_dl').wrap('<div id="'+id+'_dl_container"></div>');
      
	  $('#'+id+'_dl_container').append('<div id="'+id+'_dl_unassociated">'+((''!=opts.label_list_unassociated)?'<span '+((''!=opts.label_list_class)?'class="'+opts.label_list_class+'"':'')+'>'+opts.label_list_unassociated+'</span><br />':'')+'<select id="'+id+'_unassociated" multiple size="'+size+'"></select></div>');
      
	  $('#'+id+'_dl_container').append('<div id="'+id+'_dl_button"><span><img src="'+opts.img_associate_all+'" id="'+id+'_bt_associate_all" /><br /><img src="'+opts.img_associate+'" id="'+id+'_bt_associate" /><br /><img src="'+opts.img_unassociate+'" id="'+id+'_bt_unassociate" /><br /><img src="'+opts.img_unassociate_all+'" id="'+id+'_bt_unassociate_all" /></span></div>');
      
	  $('#'+id+'_dl_container').append('<div id="'+id+'_dl_associated">'+((''!=opts.label_list_associated)?'<span '+((''!=opts.label_list_class)?'class="'+opts.label_list_class+'"':'')+'>'+opts.label_list_associated+'</span><br />':'')+'<select id="'+id+'_associated" multiple size="'+size+'"></select></div>');
      
	  $('#'+id+'_dl_container').append('<div style="clear:both"></div>');
      //hide the original list: this element is the reference and keep its ID int the form submission
      $('#'+id+'_dl').hide();
      
      // In order to align left to right each element => Apply css modification 
      $('#'+id+'_dl_associated').css('float','left');
	  $('#'+id+'_dl_associated').css('width', opts.width_associated + 'px');
      $('#'+id+'_dl_associated').css('height', opts.height_associated + 'px');
      $('#'+id+'_dl_button').css('float','left');
	  // Jperciot, le 20/12/2011
      $('#'+id+'_dl_button').css('padding-left','10px');
      $('#'+id+'_dl_button').css('padding-right','10px');
      // Jperciot, le 20/12/2011
      $('#'+id+'_dl_unassociated').css('float','left');
      $('#'+id+'_dl_unassociated').css('width', opts.width_unassociated + 'px');
	  $('#'+id+'_dl_unassociated').css('height', opts.height_unassociated + 'px');
      // align list width to the label element width
      $('#'+id+'_dl_container select').css('width','100%');
      //button must be align to the list element top : apply a padding equals to the label height
      if( (''!=opts.label_list_associated) && (''!=opts.label_list_unassociated) ) $('#'+id+'_dl_button').css('padding-top',$('#'+id+'_dl_associated span').css('line-height'));
      
      // Assign each element of the reference list to the correct list : associated or unassociated based on the attribute "selected"
      $('#'+id).children().filter(':selected').each(function(){ $('#'+id+'_associated').append($(this)); });
      $('#'+id+'_associated option').removeAttr('selected');
      $('#'+id).children().not(':selected').each(function(){ $('#'+id+'_unassociated').append($(this)); });
      //$('#'+id).children().not(':selected').remove();
      // syncrhonize : reference list from associated list
      $.fn.zenWidgetDoubleList.synchronize(id);
      
      $('#'+id+'_bt_associate_all').click(function(event){ $.fn.zenWidgetDoubleList.associate_all( $.fn.zenWidgetDoubleList.getIdFromBt1(event) ); });
      $('#'+id+'_bt_associate').click(function(event){ $.fn.zenWidgetDoubleList.associate( $.fn.zenWidgetDoubleList.getIdFromBt2(event) ); });
      $('#'+id+'_bt_unassociate').click(function(event){ $.fn.zenWidgetDoubleList.unassociate( $.fn.zenWidgetDoubleList.getIdFromBt3(event) ); });
      $('#'+id+'_bt_unassociate_all').click(function(event){ $.fn.zenWidgetDoubleList.unassociate_all( $.fn.zenWidgetDoubleList.getIdFromBt4(event) ); });
      if( opts.dblclick_enabled )
      {
        $('#'+id+'_associated option').live('dblclick',function(event){ $.fn.zenWidgetDoubleList.unassociate( $.fn.zenWidgetDoubleList.getIdFromLst1( event ) ); });
        $('#'+id+'_unassociated option').live('dblclick',function(event){ $.fn.zenWidgetDoubleList.associate( $.fn.zenWidgetDoubleList.getIdFromLst2( event ) ); });   
      }
	  
	  $('#'+id+'_associated').css ("height", opts.height_associated + 'px');
	  $('#'+id+'_unassociated').css ("height", opts.height_unassociated + 'px');
    });
  };
 
  $.fn.zenWidgetDoubleList.getIdFromLst1 = function(event)
  {
    id = $(event.target).parent().attr('id');
    id = id.substr(0, id.length - 11);
    return id;
  }
  
  $.fn.zenWidgetDoubleList.getIdFromLst2 = function(event)
  {
    id = $(event.target).parent().attr('id');
    id = id.substr(0, id.length - 13);
    return id;
  }
  
  $.fn.zenWidgetDoubleList.getIdFromBt1 = function(event)
  {
    id = $(event.target).attr('id');
    id = id.substr(0, id.length - 17);
    return id;
  }
  
  $.fn.zenWidgetDoubleList.getIdFromBt2 = function(event)
  {
    id = $(event.target).attr('id');
    id = id.substr(0, id.length - 13);
    return id;
  } 
  
  $.fn.zenWidgetDoubleList.getIdFromBt3 = function(event)
  {
    id = $(event.target).attr('id');
    id = id.substr(0, id.length - 15);
    return id;
  }  
  
  $.fn.zenWidgetDoubleList.getIdFromBt4 = function(event)
  {
    id = $(event.target).attr('id');
    id = id.substr(0, id.length - 19);
    return id;
  }    
  
  $.fn.zenWidgetDoubleList.synchronize = function(id)
  {
    $('#'+id).html('');
    $('#'+id+'_associated').children().each(function(){ $('#'+id).append( '<option value="'+$(this).attr('value')+'" selected>'+$(this).text()+'</option>' ) });  
    $('#'+id+'_unassociated').children().each(function(){ $('#'+id).append( '<option value="'+$(this).attr('value')+'">'+$(this).text()+'</option>' ) });  
  }
  
  $.fn.zenWidgetDoubleList.associate = function(id) {
    $('#'+id+'_unassociated option:selected').each( function(){ 
          $('#'+id+'_associated').append( '<option value="'+$(this).attr('value')+'">'+$(this).text()+'</option>' );
          $(this).remove();
    });
    $.fn.zenWidgetDoubleList.synchronize(id);
  };
  
  $.fn.zenWidgetDoubleList.unassociate = function(id) {
    $('#'+id+'_associated option:selected').each( function(){ 
          $('#'+id+'_unassociated').append( '<option value="'+$(this).attr('value')+'">'+$(this).text()+'</option>' );
          $(this).remove();
    });
  $.fn.zenWidgetDoubleList.synchronize(id);    
  };    
  
  $.fn.zenWidgetDoubleList.associate_all = function(id) {
    $('#'+id+'_unassociated option').each( function(){ 
          $('#'+id+'_associated').append( '<option value="'+$(this).attr('value')+'">'+$(this).text()+'</option>' );
          $(this).remove();
    });
    $.fn.zenWidgetDoubleList.synchronize(id);
  };
  
  $.fn.zenWidgetDoubleList.unassociate_all = function(id) {
    $('#'+id+'_associated option').each( function(){ 
          $('#'+id+'_unassociated').append( '<option value="'+$(this).attr('value')+'">'+$(this).text()+'</option>' );
          $(this).remove();
    });
  $.fn.zenWidgetDoubleList.synchronize(id);    
  };  
  
  // plugin defaults
  $.fn.zenWidgetDoubleList.defaults = {
      label_list_class:'',
      label_list_associated:'Associated',
      label_list_unassociated:'Unassociated',
      dblclick_enabled:false,
      default_size:5,
      img_associate:'assets/images/associate.png',
      img_associate_all:'assets/images/associate_all.png',
      img_unassociate:'assets/images/unassociate.png',
      img_unassociate_all:'assets/images/unassociate_all.png',
	  width_associated: 250,
	  width_unassociated: 250,
	  height_associated: 150,
	  height_unassociated: 150
  };

})(jQuery);


