function getReion(parentId,tag){
  $.ajax({
    url: "?r=site/getregion",
    type: 'POST',
    dataType: 'json',
    data: {
      parentId: parentId
    },
    success: function(data, status) {
      $(tag).html("");
      $.each(data, function(index, address) {
        $(tag).append("<option value=" + address['id'] + ">" + address['name'] + "</option>");
      });
    }
  });
}

$(function() {
  getReion($("#addclientform-regionprovince").val(),"#addclientform-regioncity");
  $("#addclientform-regionprovince").bind('change', function() {
    getReion($(this).val(),"#addclientform-regioncity");
  });
  $("#addclientform-regioncity").bind('change',function (){
    getReion($(this).val(),"#addclientform-regioncountry");
  });
});
