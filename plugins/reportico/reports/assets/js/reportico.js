//$ = jQuery.noConflict();

//var reportico_ajax_script = "index.php";

/*
** Reportico Javascript functions
*/
function setupDynamicGrids()
{
    if (typeof reportico_dynamic_grids === 'undefined') {
        return;
    }
    if (  $.type(reportico_dynamic_grids) != 'undefined' )
    if ( reportico_dynamic_grids )
    {
        $(".swRepPage").each(function(){
            $(this).dataTable(
                {
                "retrieve" : true,
                "searching" : reportico_dynamic_grids_searchable,
                "ordering" : reportico_dynamic_grids_sortable,
                "paging" : reportico_dynamic_grids_paging,
                "iDisplayLength": reportico_dynamic_grids_page_size
                }
                );
        });
    }
}

function setupDatePickers()
{
    $(".swDateField").each(function(){
        $(this).datepicker({dateFormat: reportico_datepicker_language,
            dateFormat: reportico_datepicker_language,
            onSelect: function(dateText) {              // Automatically set a to date value from a from date
                id = this.id;
                if ( id.match(/_FROMDATE/) )
                {
                    todate = id.replace(/_FROMDATE/, "_TODATE");
                    $("#" + todate).prop("value", this.value);
                }
            },
            beforeShow: function()
            {
                setTimeout(function()
                {
                    $(".ui-datepicker").css("z-index", 999999);
                }, 10); 
            }
            });
    });
}

function setupTooltips()
{
return;
    $(".reportico_tooltip").each(function(){
        $(this).tooltip();
    });
}

// Sets jQuery attributes for dynamic criteria
function setupCriteriaItems()
{
    //$('#reportico_container').find("select").each(function() {
        //$(this).select2();
        //$(this).css("display", "inline-block");
        //$(this).css("text-align", "left");
        //
    //});;

    for ( i in reportico_criteria_items )
    {
        j = reportico_criteria_items[i];

        // Already checked values for prepopulation
        preselected =[];
        $("#select2_dropdown_" + j + ",#select2_dropdown_expanded_" + j).find("option").each(function() {
            lab = $(this).prop("label");
            value = $(this).prop("value");
            checked = $(this).attr("checked");
            if ( checked )
            {
                preselected.push(value);
            }
        });
        
        //reporticoSelect2.call($("#select2_dropdown_" + j + ",#select2_dropdown_expanded_" + j), {
        $("#select2_dropdown_" + j + ",#select2_dropdown_expanded_" + j).reporticoSelect2( {
          ajax: {
            url: reportico_ajax_script + "?execute_mode=CRITERIA&reportico_criteria=" + j,
            headers: { 'X-CSRF-TOKEN': reportico_csrf_token, 'X-OCTOBER-REQUEST-HANDLER': ajax_event_handler, 'X-OCTOBER-REQUEST-PARTIALS':'' },
            type: 'POST',
            error: function(data, status) {
                return {
                    results: [{ id: 'error', text: 'Unable to autocomplete', disabled: true }]
                }
            },
            dataType: 'json',
            delay: 250,
            data: function (params) {
                forms = $('#reportico_container').find(".swPrpForm");
	            formparams = forms.serialize();
                formparams += "&reportico_ajax_called=1";
                formparams += "&execute_mode=CRITERIA";
                formparams += "&reportico_criteria_match=" + params.term;;
              return formparams;
              return {
                q: params.term, // search term
                formparams: formparams,
                page: params.page
              };
            },
            processResults: function (data, params) {
              // parse the results into the format expected by Select2
              // since we are using custom formatting functions we do not need to
              // alter the remote JSON data, except to indicate that infinite
              // scrolling can be used

              params.page = params.page || 1;

              return {
                results: data.items,
                pagination: {
                  more: (params.page * 30) < data.total_count
                }
              };
            },
            cache: false,
            placeholder: "hello",
            allowClear: true
          },
          escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
          minimumInputLength: 1
          //templateResult: select2FormatResult, // omitted for brevity, see the source of this page
          //templateSelection: select2FormatSelection // omitted for brevity, see the source of this page
        });
        $("#select2_dropdown_" + j).val(preselected).trigger("change");

        // If select2 exists in expand tab then hide the search box .. its not relevant
        $("#select2_dropdown_expanded_" + j).each(function() {
            $("#expandsearch").hide();
            $("#reporticoSearchExpand").hide();
        });
    };

}

function select2FormatResult(data)
{
    return data;
}

function select2FormatSelection(data)
{
    return data.name;
}

function formatState (state) {
  if (!state.id) { return state.text; }
  var $state = $(
    '<span><img src="vendor/images/flags/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span>'
  );
  return $state;
};


function setupModals()
{
    var options = { } 
    $('#reporticoModal').modal(options);
}

function setupNoticeModals()
{
    var options = { } 
    $('#reporticoNoticeModal').modal(options);
}

function setupDropMenu()
{
    // In October, dropdown menu item selection causes overlay to appear which remains
    // after ajax call preventing anything being clicked. Until we sort this out, force removal of the overlay
    $('div.dropdown-overlay').remove();

    if ( $('ul.jd_menu').length != 0  )
    {
        $('ul.jd_menu').jdMenu();
        //$(document).bind('click', function() {
            //$('ul.jd_menu ul:visible').jdMenuHide();
        //});
    }
}

function setupCheckboxes()
{
    $('.reportico_bootstrap2_checkbox').on('click', function(event){
        //The event won't be propagated to the document NODE and 
        // therefore events delegated to document won't be fired
        event.stopPropagation();
    });
}

/*
* Where multiple data tables exist due to graphs
* resize the columns of all tables to match the first
*/
function resizeHeaders()
{
  // Size page header blocks to fit page headers
  $(".swPageHeaderBlock").each(function() {
    var parenty = $(this).position().top;
    var maxheight = 0;
    $(this).find(".swPageHeader").each(function() {
        var headerheight  = $(this).outerHeight();
        $(this).find("img").each(function() {
            var imgheight = $(this).prop("height");
            if ( imgheight > headerheight )
                headerheight = imgheight;
        });
        var margintop  = parseInt($(this).css("margin-top"));
        var marginbottom  = parseInt($(this).css("margin-bottom"));
        headerheight += margintop + marginbottom;
        if ( headerheight > maxheight )
            maxheight = headerheight;
   });
   $(this).css("height", maxheight + "px");
  });
  //$(".swNewPageHeaderBlock").hide();
        //ct = 1;
        //hdrpos = 0;
        //while ( $(".swPageFooterBlock"+ct).length )
        //{
            //if ( $(".swPageHeaderBlock"+(ct+1)).length )
                //hdrpos = $(".swPageHeaderBlock"+(ct+1)).offset().top;
            //else
                //hdrpos = hdrpos + 1000;
            //$(".swPageFooterBlock"+ct).css("top", ( hdrpos ) + "px" );
            //ct++;
        //}
    

  //$(".swRepForm").columnize();

}

/*
* Where multiple data tables exist due to graphs
* resize the columns of all tables to match the first
*/
function resizeTables()
{

  var tableArr = $('.swRepPage');
  if ( tableArr.length == 0 )
    return;
  var tableDataRow = $('.swRepResultLine:first');
  var cellWidths = new Array();
  $(tableDataRow).each(function() {
    for(j = 0; j < $(this)[0].cells.length; j++){
       var cell = $(this)[0].cells[j];
       if(!cellWidths[j] || cellWidths[j] < cell.clientWidth) cellWidths[j] = cell.clientWidth;
    }
  });

  var tablect = 0;
  $(tableArr).each(function() {
    tablect++;
    if ( tablect == 1 )
        return;

    $(this).find(".swRepResultLine:first").each(function() {
      for(j = 0; j < $(this)[0].cells.length; j++){
        $(this)[0].cells[j].style.width = cellWidths[j]+'px';
      }
   });
 });
}


//$(document).on('click', 'ul.dropdown-menu li a, ul.dropdown-menu li ul li a, ul.jd_menu li a, ul.jd_menu li ul li a', function(event) 
//{
    //event.preventDefault();
    //return false;
//});

//$(document).on('click', '.dropdown-toggle', function(event) 
//{
    //event.preventDefault();
//}

$(document).on('click', 'a.reportico-dropdown-item, ul li.r1eportico-dropdown a, ul li ul.reportico-dropdown li a, ul.jd_menu li a, ul.jd_menu li ul li a', function(event) 
{
    if (  $.type(reportico_ajax_mode) === 'undefined' || !reportico_ajax_mode)
    {
        return true;
    }

    var url = $(this).prop('href');
    params = "CSRF=" + reportico_csrf_token;
    runreport(url, params, this);
    //event.preventDefault();
    return false;
});

/* Load Date Pickers */
$(document).ready(function()
{

    setupDatePickers();
    setupTooltips();
    setupDropMenu();
    resizeHeaders();
    resizeTables();
    setupDynamicGrids();
    setupCriteriaItems();
    //$('#select2_dropdown_country').select2();

});

function reportico_initialise_page()
{
    setupDatePickers();
    setupTooltips();
    setupDropMenu();
    resizeHeaders();
    resizeTables();
    setupDynamicGrids();
    setupCriteriaItems();
};

$(document).on('click', '.reportico-notice-modal-close,.reportico-notice-modal-button', function(event) 
{
    $("#swMiniMaintain").html("");
    $('#reporticoNoticeModal').hide();
});

/*
$(document).on('click', '.reportico-bootstrap-modal-close', function(event) 
{
    $("#swMiniMaintain").html("");
    $('#reporticoModal').modal('hide');
});

$(document).on('click', '.reportico-modal-close', function(event) 
{
    $("#swMiniMaintain").html("");
    $('#reporticoModal').hide();
});
*/

$(document).on('click', '.swMiniMaintainSubmit,.reportico-bootstrap-modal-close,.reportico-modal-close', function(event) 
{

    if ( reportico_bootstrap_modal )
        var loadpanel = $("#reporticoModal .modal-dialog .modal-content .modal-header");
    else
        var loadpanel = $("#reporticoModal .reportico-modal-dialog .reportico-modal-content .reportico-modal-header");

	var expandpanel = $('#swPrpExpandCell');
    $(loadpanel).addClass("modal-loading");

    forms = $(this).closest('#reportico_container').find(".swPrpForm");
    if (    $.type(reportico_ajax_script) === 'undefined' )
    {
        var ajaxaction = $(forms).prop("action");
    }
    else
    {
        ajaxaction = reportico_ajax_script;
    }

	params = forms.serialize();
    params += "&" + $(this).prop("name") + "=1";
    params += "&reportico_ajax_called=1";
    params += "&execute_mode=PREPARE";

    //if ( reportico_ajax_mode == 1 )
        //ajaxaction += "?r=reportico/ajax";
    //else
        //ajaxaction += "reportico/ajax";

    var cont = this;
    $.ajax({
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': reportico_csrf_token, 'X-OCTOBER-REQUEST-HANDLER': ajax_event_handler, 'X-OCTOBER-REQUEST-PARTIALS':'' },
        url: ajaxaction,
        data: params,
        dataType: 'html',
        success: function(data, status) 
        {
          $(loadpanel).removeClass("modal-loading");
          if ( reportico_bootstrap_modal )
          {
            $('#reporticoModal').modal('hide');
            $('.modal-backdrop').remove();
            $('#reportico_container').closest('body').removeClass('modal-open');
          }
          else
            $('#reporticoModal').hide();
          $("#swMiniMaintain").html("");

          //$(reportico_container).removeClass("loading");
          fillDialog(data, cont);
        },
        error: function(xhr, desc, err) {
          $("#swMiniMaintain").html("");
          $('#reporticoModal').modal('hide');
          $('.modal-backdrop').remove();
          $(loadpanel).removeClass("modal-loading");
          $(loadpanel).prop('innerHTML',"Ajax Error: " + xhr + "\nTextStatus: " + desc + "\nErrorThrown: " + err);
        }
      });
      return false;
});

/*
** Trigger AJAX request for reportico button/link press if running in AJAX mode
** AJAX mode is in place when reportico session ("reportico_ajax_script") is set
** will generate full reportico output to replace the reportico_container tag
*/

$(document).on('click', '.swMiniMaintain', function(event) 
{
	var expandpanel = $(this).closest('#criteriaform').find('#swPrpExpandCell');
    var reportico_container = $(this).closest("#reportico_container");

    $(expandpanel).addClass("loading");
    forms = $(this).closest('.swMntForm,.swPrpForm,.swPrpSaveForm,form');
    if (    $.type(reportico_ajax_script) === 'undefined' )
    {
        var ajaxaction = $(forms).prop("action");
    }
    else
    {
        ajaxaction = reportico_ajax_script;
    }

    maintainButton = $(this).prop("name"); 
    $(".reportico-modal-title").html($(this).prop("title")); 
    bits = maintainButton.split("_");
	params = forms.serialize();
    params += "&execute_mode=MAINTAIN&partialMaintain=" + maintainButton + "&partial_template=mini&submit_" + bits[0] + "_SHOW=1";
    params += "&reportico_ajax_called=1";
    params += "&CSRF=" + reportico_csrf_token;

    //if ( reportico_ajax_mode == 1 )
        //ajaxaction += "?r=reportico/reports/ajax";
    //else
        //ajaxaction += "/reportico/reports/ajax";

    $.ajax({
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': reportico_csrf_token, 'X-OCTOBER-REQUEST-HANDLER': ajax_event_handler, 'X-OCTOBER-REQUEST-PARTIALS':'' },
        url: ajaxaction,
        data: params,
        dataType: 'html',
        success: function(data, status) 
        {
          $(expandpanel).removeClass("loading");
          $(reportico_container).removeClass("loading");
          if ( reportico_bootstrap_modal )
            setupModals();
          else
            $("#reporticoModal").show();
          $("#swMiniMaintain").html(data);
          x = $(".swMntButton").prop("name");
          $(".swMiniMaintainSubmit").prop("id", x);
        },
        error: function(xhr, desc, err) {
          $(expandpanel).removeClass("loading");
          $(reportico_container).removeClass("loading");
          $(expandpanel).prop('innerHTML',"Ajax Error: " + xhr + "\nTextStatus: " + desc + "\nErrorThrown: " + err);
        }
      });

    return false;

})

$(document).on('click', '.swPrpSaveButton', function(event) 
{
	var expandpanel = $(this).closest('#criteriaform').find('#swPrpExpandCell');
    var reportico_container = $(this).closest("#reportico_container");

    $(expandpanel).addClass("loading");
    if (    $.type(reportico_ajax_script) === 'undefined' )
    {
        var ajaxaction = $(forms).prop("action");
    }
    else
    {
        ajaxaction = reportico_ajax_script;
    }

    filename = $("#swPrpSaveFile").prop("value");
	params = "";
    params += "&execute_mode=MAINTAIN&submit_xxx_PREPARESAVE&xmlout=" + filename;
    params += "&reportico_ajax_called=1";
    params += "&CSRF=" + reportico_csrf_token;

    //if ( reportico_ajax_mode == 1 )
        //ajaxaction += "?r=reportico/reports/ajax";
    //else
        //ajaxaction += "?r=reportico/reports/ajax";

    $.ajax({
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': reportico_csrf_token, 'X-OCTOBER-REQUEST-HANDLER': ajax_event_handler, 'X-OCTOBER-REQUEST-PARTIALS':'' },
        url: ajaxaction,
        data: params,
        dataType: 'html',
        success: function(data, status) 
        {
          $(expandpanel).removeClass("loading");
          $(reportico_container).removeClass("loading");
          //alert(data);
        },
        error: function(xhr, desc, err) {
          $(expandpanel).removeClass("loading");
          $(reportico_container).removeClass("loading");
          showNoticeModal(xhr.responseText);
        }
      });

    return false;

})


/*
** Trigger AJAX request for reportico button/link press if running in AJAX mode
** AJAX mode is in place when reportico session ("reportico_ajax_script") is set
** will generate full reportico output to replace the reportico_container tag
*/
$(document).on('click', '.swAdminButton, .swAdminButton2, .swMenuItemLink, .swPrpSubmit, .swLinkMenu, .swLinkMenu2, .reporticoSubmit', function(event) 
{
    if ( $(this).hasClass("swNoSubmit" )  )
    {
        return false;
    }

    if ( $(this).parents("#swMiniMaintain").length == 1 ) 
    {
	    var expandpanel = $(this).closest('#criteriaform').find('#swPrpExpandCell');
        if ( reportico_bootstrap_modal )
            var loadpanel = $("#reporticoModal .modal-dialog .modal-content .modal-header");
        else
            var loadpanel = $("#reporticoModal .reportico-modal-dialog .reportico-modal-content .reportico-modal-header");
        var reportico_container = $(this).closest("#reportico_container");

        $(loadpanel).addClass("modal-loading");
        forms = $(this).closest('.swMiniMntForm');
        if (    $.type(reportico_ajax_script) === 'undefined' )
        {
            var ajaxaction = $(forms).prop("action");
        }
        else
        {
            ajaxaction = reportico_ajax_script;
        }

        params = forms.serialize();
           
        maintainButton = $(this).prop("name"); 
        params += "&execute_mode=MAINTAIN&partial_template=mini";
        params += "&" + $(this).prop("name") + "=1";
        params += "&reportico_ajax_called=1";
        params += "&CSRF=" + reportico_csrf_token;

        $.ajax({
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': reportico_csrf_token, 'X-OCTOBER-REQUEST-HANDLER': ajax_event_handler, 'X-OCTOBER-REQUEST-PARTIALS':'' },
            url: ajaxaction,
            data: params,
            dataType: 'html',
            success: function(data, status) 
            {
              $(loadpanel).removeClass("modal-loading");
              if ( reportico_bootstrap_modal )
                setupModals();
              $("#swMiniMaintain").html(data);
              x = $(".swMntButton").prop("name");
              $(".swMiniMaintainSubmit").prop("id", x);
            },
            error: function(xhr, desc, err) {
              $(loadpanel).removeClass("modal-loading");
              $(expandpanel).prop('innerHTML',"Ajax Error: " + xhr + "\nTextStatus: " + desc + "\nErrorThrown: " + err);
            }
          });

        return false;
    }

    if ( $(this).parent().hasClass("swRepPrintBox" )  )
    {
        //var data = $(this).closest("#reportico_container").html();
        //html_print(data);
        window.print();
        return false;
    }

    if (  $.type(reportico_ajax_mode) === 'undefined' || !reportico_ajax_mode)
    {
        return true;
    }

	var expandpanel = $(this).closest('#criteriaform').find('#swPrpExpandCell');
    var reportico_container = $(this).closest("#reportico_container");

    if ( !$(this).prop("href") )
    {
            $(expandpanel).addClass("loading");
            $(reportico_container).addClass("loading");

            forms = $(this).closest('.swMntForm,.swPrpForm,form');
            if (    $.type(reportico_ajax_script) === 'undefined' )
            {
                var ajaxaction = $(forms).prop("action");
            }
            else
            {
			    ajaxaction = reportico_ajax_script;
            }


            params = forms.serialize();
            params += "&" + $(this).prop("name") + "=1";
            params += "&reportico_ajax_called=1";
            params += "&CSRF=" + reportico_csrf_token;

            csvpdfoutput = false;

            if (  $(this).prop("name") != "submit_design_mode" )
            $(reportico_container).find("input:radio").each(function() { 
                d = 0;
                nm = $(this).prop("value");
                chk = $(this).prop("checked");
                if ( chk && ( nm == "PDF" || nm == "CSV"  ) )
                    csvpdfoutput = true;
            });

            if ( csvpdfoutput )
            {
                if (typeof reportico_pdf_delivery_mode == 'undefined'
                    || !reportico_pdf_delivery_mode || reportico_pdf_delivery_mode != "DOWNLOAD_SAME_WINDOW" 
                    )
                {
                    $(expandpanel).removeClass("loading");
                    $(reportico_container).removeClass("loading");
                    var windowSizeArray = [ "width=200,height=200",
                          "width=300,height=400,scrollbars=yes" ];

                    var url = ajaxaction +"?" + params;

                    var windowName = "popUp";//$(this).prop("name");
                    var windowSize = windowSizeArray[$(this).prop("rel")];
                    window.open(url, windowName, "width=400,height=400").focus();
                    $(expandpanel).removeClass("loading");
                    window.focus();
                }
                else
                {

                    $(expandpanel).removeClass("loading");
                    var buttonName = $(this).prop("name");
                    var formparams = forms.serializeObject();
                    formparams['reportico_ajax_called'] = '1';
                    formparams[buttonName] = '1';

                    // Download pdf/csv from within current window
                    ajaxFileDownload(ajaxaction, formparams, expandpanel, reportico_container);
                }

                return false;
            }


            var cont = this;
            $.ajax({
                type: 'POST',
                headers: { 'X-CSRF-TOKEN': reportico_csrf_token, 'X-OCTOBER-REQUEST-HANDLER': ajax_event_handler, 'X-OCTOBER-REQUEST-PARTIALS':'' },
                url: ajaxaction,
                data: params,
                dataType: 'html',
                success: function(data, status) 
                {
                  $(expandpanel).removeClass("loading");
                  $(reportico_container).removeClass("loading");
                  fillDialog(data, cont);
                },
                error: function(xhr, desc, err) {
                  $(expandpanel).removeClass("loading");
                  $(reportico_container).removeClass("loading");
                  $(expandpanel).prop('innerHTML',"Ajax Error: " + xhr + "\nTextStatus: " + desc + "\nErrorThrown: " + err);
                }
              });
              return false;
    }
    else
    {
        url = $(this).prop("href");
        params = "CSRF=" + reportico_csrf_token;
        runreport(url, params, this);
    }
    return false;
})

/*
 * Use ajax to return pdf or csv output and download to file.
 * For pdf, output is received in base64. 
 */
function ajaxFileDownload(url, data, expandpanel, reportico_container) {

    $.ajax({
      type: 'POST',
      headers: { 'X-CSRF-TOKEN': reportico_csrf_token, 'X-OCTOBER-REQUEST-HANDLER': ajax_event_handler, 'X-OCTOBER-REQUEST-PARTIALS':'' },
      url: url,
      data: data,
      dataType: 'html',
      success: function(data, status, request) {
        $(expandpanel).removeClass("loading");
        $(reportico_container).removeClass("loading");

        // PDF and CSV files are received in base64
        var contenttype = request.getResponseHeader('Content-Type');
        if ( contenttype == "application/pdf" )
        {
            var saveto = request.getResponseHeader('Content-Disposition');
            saveto = saveto.replace(/attachment;filename=/,"");
            objurl = "data:application/pdf;base64," + data;
            download(objurl, saveto, "application/pdf");
        }

        if ( contenttype == "application/octet-stream" )
        {
            var saveto = request.getResponseHeader('Content-Disposition');
            saveto = saveto.replace(/attachment;filename=/,"");
            objurl = "data:application/octet-stream;base64," + data;
            download(objurl, saveto, "application/pdf");
        }
      },
       error: function(xhr, desc, err) {
        $(expandpanel).removeClass("loading");
        $(reportico_container).removeClass("loading");
         try {
            // a try/catch is recommended as the error handler
            // could occur in many events and there might not be
            // a JSON response from the server
            var errstatus = $.parseJSON(xhr.responseText);
            var msg = errstatus.errmsg;
            //$(expandpanel).prop('innerHTML', msg);
            showNoticeModal(msg);

        } catch(e) { 
            showNoticeModal(xhr.responseText);
        }
       }
    
    });
}

//general serializeObject function - e.g. turn a form's fields into an object
$.fn.serializeObject = function() {
  var arrayData, objectData;
  arrayData = this.serializeArray();
  objectData = {};

  $.each(arrayData, function() {
    var value;

    if (this.value != null) {
      value = this.value;
    } else {
      value = '';
    }

    if (objectData[this.name] != null) {
      if (!objectData[this.name].push) {
        objectData[this.name] = [objectData[this.name]];
      }

      objectData[this.name].push(value);
    } else {
      objectData[this.name] = value;
    }
  });

  return objectData;
};
// ---------------------------------
/*
** Called when used presses ok in expand mode to 
** refresh middle prepare mode section with non expand mode 
** text
*/
$(document).on('click', '#returnFromExpand', function() {

	var critform = $(this).closest('#criteriaform');
	var expandpanel = $(this).closest('#criteriaform').find('#swPrpExpandCell');
    $(expandpanel).addClass("loading");

    var params = $(critform).serialize();
    params += "&execute_mode=PREPARE";
    params += "&partial_template=critbody";
    params += "&" + $(this).prop("name") + "=1";
    params += "&CSRF=" + reportico_csrf_token;

	forms = $(this).closest('.swMntForm,.swPrpForm,form');
    ajaxaction = reportico_ajax_script;

	fillPoint = $(this).closest('#criteriaform').find('#criteriabody');
		
    $.ajax({
      type: 'POST',
      headers: { 'X-CSRF-TOKEN': reportico_csrf_token, 'X-OCTOBER-REQUEST-HANDLER': ajax_event_handler, 'X-OCTOBER-REQUEST-PARTIALS':'' },
      url: ajaxaction,
      data: params,
      dataType: 'html',
      success: function(data, status) {
        $(expandpanel).removeClass("loading");
        $(fillPoint).html(data);
        setupDatePickers();
        setupTooltips();
        setupDropMenu();
        setupCriteriaItems();
        setupCheckboxes();
        },
        error: function(xhr, desc, err) {
        $(expandpanel).removeClass("loading");
        $(fillPoint).prop('innerHTML',"Ajax Error: " + xhr + "\nTextStatus: " + desc + "\nErrorThrown: " + err);
      }
    });
    return false;
	});

  $(document).on('click', '#reporticoPerformExpand', function() {

	forms = $(this).closest('.swMntForm,.swPrpForm,form');
	var ajaxaction = $(forms).prop("action");
	var critform = $(this).closest('#criteriaform');
    ajaxaction = reportico_ajax_script;

    var params = $(critform).serialize();
    params += "&execute_mode=PREPARE";
    params += "&partial_template=expand";
    params += "&" + $(this).prop("name") + "=1";
    params += "&CSRF=" + reportico_csrf_token;

	var fillPoint = $(this).closest('#criteriaform').find('#swPrpExpandCell');
    $(fillPoint).addClass("loading");

    //if ( reportico_ajax_mode == 1 )
         //ajaxaction += "?r=reportico/ajax";
    //else
         //ajaxaction += "/reportico/ajax";

    $.ajax({
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': reportico_csrf_token, 'X-OCTOBER-REQUEST-HANDLER': ajax_event_handler, 'X-OCTOBER-REQUEST-PARTIALS':'' },
        url: ajaxaction,
        data: params,
        dataType: 'html',
        success: function(data, status) {
          $(fillPoint).removeClass("loading");
          $(fillPoint).html(data);
          setupDatePickers();
          setupTooltips();
          setupDropMenu();
          setupCriteriaItems();
          setupCheckboxes();
        },
        error: function(xhr, desc, err) {
          $(fillPoint).removeClass("loading");
          $(fillPoint).prop('innerHTML',"Ajax Error: " + xhr + "\nTextStatus: " + desc + "\nErrorThrown: " + err);
        }
      });
      return false;
    });


/*
** AJAX call to run a report
** In pdf/csv mode this needs to trigger opening of a new browser window
** with output in rather that directing to screen
*/
$(document).on('click', '.swPrintBox,.prepareAjaxExecute,#prepareAjaxExecute', function() {

    var reportico_container = $(this).closest("#reportico_container");
    $(reportico_container).find("#rpt_format_pdf").prop("checked", false );
    $(reportico_container).find("#rpt_format_csv").prop("checked", false );
    $(reportico_container).find("#rpt_format_html").prop("checked", false );
    $(reportico_container).find("#rpt_format_json").prop("checked", false );
    $(reportico_container).find("#rpt_format_xml").prop("checked", false );
    if (  $(this).hasClass("swPDFBox") ) 
        $(reportico_container).find("#rpt_format_pdf").prop("checked", "checked");
    if (  $(this).hasClass("swCSVBox") ) 
        $(reportico_container).find("#rpt_format_csv").prop("checked", "checked");
    if (  $(this).hasClass("swHTMLBox") ) 
        $(reportico_container).find("#rpt_format_html").prop("checked", "checked");
    if (  $(this).hasClass("swHTMLGoBox") ) 
        $(reportico_container).find("#rpt_format_html").prop("checked", "checked");
    if (  $(this).hasClass("swXMLBox") ) 
        $(reportico_container).find("#rpt_format_xml").prop("checked", "checked");
    if (  $(this).hasClass("swJSONBox") ) 
        $(reportico_container).find("#rpt_format_json").prop("checked", "checked");
    if (  $(this).hasClass("swPrintBox") ) 
        $(reportico_container).find("#rpt_format_html").prop("checked", "checked");

    if (  !$(this).hasClass("swPrintBox") )
    if (  $.type(reportico_ajax_mode) === 'undefined' || !reportico_ajax_mode)
    {
        return true;
    }


	var expandpanel = $(this).closest('#criteriaform').find('#swPrpExpandCell');
	var critform = $(this).closest('#criteriaform');
    $(expandpanel).addClass("loading");

    params = $(critform).serialize();
    params += "&execute_mode=EXECUTE";
    params += "&" + $(this).prop("name") + "=1";

    forms = $(this).closest('.swMntForm,.swPrpForm,form');
    if ( jQuery.type(reportico_ajax_script) === 'undefined' || !reportico_ajax_script )
    {
        var ajaxaction = $(forms).prop("action");
    }
    else
    {
        ajaxaction = reportico_ajax_script;
    }

    var csvpdfoutput = false;
    var htmloutput = false;

    reportico_report_title = $(this).closest('#reportico_container').find('.swTitle').html();

    if (  !$(this).hasClass("swPrintBox") )
    {
        $(reportico_container).find("input:radio").each(function() { 
            d = 0;
            nm = $(this).prop("value");
            chk = $(this).prop("checked");
            if ( chk && ( nm == "PDF" || nm == "CSV"  ) )
                csvpdfoutput = true;
            //if ( chk && ( nm == "HTML" ) )
                //htmloutput = true;
        });
    }


    if ( csvpdfoutput )
    {
        if (typeof reportico_pdf_delivery_mode == 'undefined'
            || !reportico_pdf_delivery_mode || reportico_pdf_delivery_mode != "DOWNLOAD_SAME_WINDOW" 
             )
        {
            var windowSizeArray = [ "width=200,height=200",
                  "width=300,height=400,scrollbars=yes" ];

        if ( reportico_ajax_mode == 1 )
            var url = ajaxaction +"&" + params;
        else
            var url = ajaxaction +"?" + params;

            var windowName = "popUp";//$(this).prop("name");
            var windowSize = windowSizeArray[$(this).prop("rel")];
            window.open(url, windowName, "width=400,height=400").focus();
            $(expandpanel).removeClass("loading");
            $(reportico_container).removeClass("loading");
            window.focus();
        }
        else
        {
            // Download pdf/csv from within current window
            var buttonName = $(this).prop("name");
            var formparams = $(critform).serializeObject();
            formparams['execute_mode'] = 'EXECUTE';
            formparams[buttonName] = '1';
            formparams['reportico_ajax_called'] = '1';
            ajaxFileDownload(ajaxaction, formparams, expandpanel, reportico_container);
        }

        return false;
    }

    if (  $(this).hasClass("swPrintBox") )
    {
        htmloutput = true;
    }

    if ( !htmloutput )
        params += "&reportico_ajax_called=1";

    if (  $(this).hasClass("swPrintBox") )
        params += "&printable_html=1&new_reportico_window=1";

    params += "&CSRF=" + reportico_csrf_token;

    var cont = this;
    $.ajax({
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': reportico_csrf_token, 'X-OCTOBER-REQUEST-HANDLER': ajax_event_handler, 'X-OCTOBER-REQUEST-PARTIALS':'' },
        url: ajaxaction,
        data: params,
        dataType: 'html',
        success: function(data, status) {
        $(expandpanel).removeClass("loading");
        if ( htmloutput )
        {
            html_print(reportico_report_title, data);
        }
        else
            fillDialog(data, cont);
       },
       error: function(xhr, desc, err) {
         $(expandpanel).removeClass("loading");
         try {
            // a try/catch is recommended as the error handler
            // could occur in many events and there might not be
            // a JSON response from the server
            var errstatus = $.parseJSON(xhr.responseText);
            var msg = errstatus.errmsg;
            //$(expandpanel).prop('innerHTML', msg);
            showNoticeModal(msg);

        } catch(e) { 
            showNoticeModal(xhr.responseText);
        }
       }
     });
     return false;
   });

/*
 * Shows modal window containing the passed text
 */
function showNoticeModal(content)
{
    $("#reporticoNoticeModalBody").html("");
    if ( reportico_bootstrap_modal )
    {
        $('#reporticoNoticeModal').modal({});
    }
    else
        $("#reporticoNoticeModal").show();
    $("#reporticoNoticeModalBody").html(content);
}

/*
 * Shows modal window containing the passed text from within a child iframe
 */
function showParentNoticeModal(content)
{
    $("#reporticoNoticeModalBody",window.parent.document).html("");
    if ( reportico_bootstrap_modal )
    {
        $('#reporticoNoticeModal',window.parent.document).modal({});
    }
    else
        $("#reporticoNoticeModal",window.parent.document).show();
    $("#reporticoNoticeModalBody",window.parent.document).html(content);
}


/*
** Runs an AJAX reportico request from a link
*/
function runreport(url, params, container) 
{
    url += "&reportico_template=";
    url += "&reportico_ajax_called=1";
    $(container).closest("#reportico_container").addClass("loading");
    $.ajax({
        type: "POST",
        headers: { 'X-CSRF-TOKEN': reportico_csrf_token, 'X-OCTOBER-REQUEST-HANDLER': ajax_event_handler, 'X-OCTOBER-REQUEST-PARTIALS':'' },
        data: params,
        url: url,
        dataType: "html",
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert ("Ajax Error: " + XMLHttpRequest.responseText + "\nTextStatus: " + textStatus + "\nErrorThrown: " + errorThrown);
        },
        success: function(data, status) {
            $(container).closest("#reportico_container").removeClass("loading");
            fillDialog(data,container);
        }
    });
}

function fillDialog(results, cont) {
  x = $(cont).closest("#reportico_container");
  $(cont).closest("#reportico_container").replaceWith(results);
  setupDatePickers();
  setupTooltips();
  setupDropMenu();
  setupDynamicGrids();
  resizeHeaders();
  setupCriteriaItems();
  setupCheckboxes();
  resizeTables();
}

var ie7 = (document.all && !window.opera && window.XMLHttpRequest) ? true : false;

/*
** Shows and hides a block of design items fields
*/
function toggleCriteria(id) {
    if ( $(".displayGroup" + id ).css("display") == "none" )
    {
        $(".displayGroup" + id ).show();
        $("#swToggleCriteria" + id ).html("-");
    }
    else
    {
        $("#swToggleCriteria" + id ).html("+");
        $(".displayGroup" + id ).hide();
    }
} 

/*
** Shows and hides a block of design items fields
*/
function toggleLine(id) {

    var a = this;
    var nm = a.id;
    var togbut = document.getElementById(id);
    var ele = document.getElementById("toggleText");
    var elems = document.getElementsByTagName('*'),i;
    for (i in elems)
    {
		if ( ie7 )
		{
        	if((" "+elems[i].className+" ").indexOf(" "+id+" ") > -1)
			{
            	if(elems[i].style.display == "inline") {
                	elems[i].style.display = "none";
                	togbut.innerHTML = "+";
            	}
            	else {
                	togbut.innerHTML = "-";
                	elems[i].style.display = "";
                	elems[i].style.display = "inline";
            	}
			}
		}
		else
		{
        	if((" "+elems[i].className+" ").indexOf(" "+id+" ") > -1)
			{
            	if(elems[i].style.display == "table-row") {
                	elems[i].style.display = "none";
                	togbut.innerHTML = "+";
            	}
            	else {
                	togbut.innerHTML = "-";
                	elems[i].style.display = "";
                	elems[i].style.display = "table-row";
            	}
			}
		}
    }
} 

reporticohtmlwindow = null;
function html_div_print(data) 
{
    var reporticohtmlwindow = window.open('oooo', reportico_report_title, 'height=600,width=800');
    reporticohtmlwindow.document.write('<html><head><title>' + reportico_report_title + '</title>');
    reporticohtmlwindow.document.write('<link rel="stylesheet" href="' + reportico_css_path + '" type="text/css" />');
    reporticohtmlwindow.document.write('</head><body >');
    reporticohtmlwindow.document.write(data);
    reporticohtmlwindow.document.write('</body></html>');
    
    reporticohtmlwindow.print();
    reporticohtmlwindow.close();

    return true;
}

function html_print(title, data) 
{
    if (navigator.userAgent.indexOf('Chrome/') > 0) {
        if (reporticohtmlwindow) {
            reporticohtmlwindow.close();
            reporticohtmlwindow = null;
        }
    }

    reporticohtmlwindow = window.open('', "reportico_print", 'location=no,scrollbars=yes,status=no,height=600,width=800');
    d = reporticohtmlwindow.document.open("text/html","replace");
    reporticohtmlwindow.document.write(data);
    reporticohtmlwindow.document.close();

    setTimeout(html_print_fix,200);

    reporticohtmlwindow.focus();
    reporticohtmlwindow.focus();
    return true;
}

function html_print_fix() 
{
    if(!reporticohtmlwindow.resizeOutputTables) 
    {
        setTimeout(html_print_fix,1000);
    } 
    else
    { 
        reporticohtmlwindow.resizeOutputTables(reporticohtmlwindow); 
    }
}
