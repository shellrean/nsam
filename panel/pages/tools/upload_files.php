<style>
  #preview
  {
  color:#cc0000;
  font-size:12px
  }

</style>
<script src="../js/jquery.wallform.js"></script>
<script>
var $jnoc = jQuery.noConflict(); 
$jnoc(document).ready(function() { 
  $jnoc('#photoimg').on('change', function()     { 
    $jnoc("#imageform").ajaxForm({target: '#preview', 
      beforeSubmit:function(){ 
        console.log('ttest');
        $jnoc("#imageloadstatus").show();
        $jnoc("#imageloadbutton").hide();
      }, 
      success:function(){ 
        console.log('test');
        $jnoc("#imageloadstatus").hide();
        $jnoc("#imageloadbutton").show();
      }, 
      error:function(){ 
        console.log('xtest');
        $jnoc("#imageloadstatus").hide();
        $jnoc("#imageloadbutton").show();
      } 
    }).submit();
          
  });
}); 
</script>

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Upload file pendukung
      </div>
      <div class="card-body">
        <div id="preview">
        </div>
      </div>
    </div>
  </div>
</div>