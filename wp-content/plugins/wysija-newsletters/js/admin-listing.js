jQuery(function(e){function t(){flag=!1,e(".batch-select td").children().each(function(){e(this).hasClass("display")&&(flag=!0)}),flag?e(".batch-select").show():e(".batch-select").hide()}function l(){e("#force_select_all").is(":checked")&&e(".checkboxselec, #user-id input, #force_select_all").attr("checked",!1),subscriberCount=e("#posts-filter input.checkboxselec:checked").length,e(".batch-select div.clear_select_all").removeClass("display").hide(),subscriberCount>0?e(".batch-select div.force_to_select_all_link").removeClass("display").addClass("display").show():e(".batch-select div.force_to_select_all_link").removeClass("display").hide(),t()}var a=e("#_wpnonce").attr("disabled","disabled"),i=e(".global-action");i.change(function(){var e=i.val();"delete"==e||"bulk_delete"==e?a.prop("disabled",null):a.attr("disabled","disabled")}),e(".orderlink").click(function(){return e(this).parent("th.sortable , th.sorted").click(),!1}),e("#posts-filter").submit(function(){e("#wysija-pagination").length&&parseInt(e("#wysija-pagination").val())>parseInt(e("#wysija-pagination-max").val())&&e("#wysija-pagination").val(e("#wysija-pagination-max").val())}),e(".bulksubmit").click(function(){var t=i.data("locale"),l=i.val(),s=e("#posts-filter .check-column input:checked");if(0===s.length)return alert(wysijatrans.selecmiss),!1;switch(l){case"deleteusers":if(!confirm(1===s.length?t.delete:t.delete_bulk))return!1}return e("<input/>",{type:"hidden",name:"action",value:i.val()}).insertAfter(e(this)),a.prop("disabled",null),e("#_wpnonce").val(e(".global-action option:selected").data("nonce")),!0}),e('.check-column input[type="checkbox"]').click(function(){}),e("#user-id").click(l),e(".checkboxselec").click(function(){e(this).is(":checked")||(e("#user-id input, #force_select_all").attr("checked",!1),e(".batch-select div.force_to_select_all_link").removeClass("display").hide(),e(".batch-select div.clear_select_all").removeClass("display").hide()),t()}),e(".force_to_select_all_link a").click(function(l){l.preventDefault(),e(".checkboxselec, #user-id input, #force_select_all").attr("checked","checked"),e(".batch-select div.force_to_select_all_link").removeClass("display").hide(),e(".batch-select div.clear_select_all").removeClass("display").addClass("display").show(),t()}),e(".clear_select_all a").click(function(){e(".batch-select div.force_to_select_all_link").removeClass("display").hide(),e(".batch-select div.clear_select_all").removeClass("display").hide(),e(".checkboxselec, #user-id input, #force_select_all").attr("checked",!1),t()}),e("th.sortable , th.sorted").click(function(){var t="";t=e(this).hasClass("sorted")?e(this).hasClass("asc")?"desc":"asc":"desc";var l=e(this).attr("id");e("#wysija-orderby").length?(e("#wysija-orderby").val(l),e("#wysija-ordert").val(t)):(e("#posts-filter").append('<input id="wysija-ordert" type="hidden" name="ordert" value="'+t+'" />'),e("#posts-filter").append('<input id="wysija-orderby" type="hidden" name="orderby" value="'+l+'" />')),e("#posts-filter").submit()}),e("a.page-numbers").click(function(){var t=e(this).attr("alt");return e("#wysija-pagination").length?e("#wysija-pagination").val(t):e("#posts-filter").append('<input id="wysija-pagination" type="hidden" name="pagi" value="'+t+'" />'),e("#posts-filter").submit(),!1}),e("a.page-limit").click(function(){var t=e(this).html();return e("#wysija-pagelimit").length?e("#wysija-pagelimit").val(t):e("#posts-filter").append('<input id="wysija-pagelimit" type="hidden" name="limit_pp" value="'+t+'" />'),e("#posts-filter").submit(),!1}),e(document).ready(function(){e("a.exported-file").length&&window.open(e("a.exported-file").attr("href"),"Download")}),e(".searchbox").blur(function(){e(this).val(trim(e(this).val()))}),t()});