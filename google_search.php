<script src="http://www.google.com/jsapi" type="text/javascript"></script>
<?php if (!isset($_POST['q'])){ ?>
<div>
  <div class="searchContainer">
    
    <div class="close">
      <a href="#" onclick="tb_remove();">
        <img src="<?php echo base_url() ?>application/assets/images/close-icon.png" border="0" />
      </a>
    </div>
   
    <img src="<?php echo base_url() ?>application/assets/images/searc_txt.png" />
    <form id="cse-search-box-form-id" name="cse-search-box" class="gsc-search-box" method="post" action="<?php echo site_url('csb.search') ?>">
      <div class="search_button">
        <input type="image" src="<?php echo base_url() ?>application/assets/images/footer-subscribe-go.png" alt="Submit"/>
      </div>
      <div class="search_input">
        <input id="cse-search-input-box-id" autocomplete="off" name="q" class="newsletter_input" type="text" value="<?php echo isset($_POST['q']) ? $_POST['q'] : ''; ?>"/>
      </div>
    </form>
  </div>
</div>
 <?php } ?>
<style type="text/css">
  #TB_window {
    background-color: transparent !important;
    border: none !important;
  }
  #TB_title { display:none; }
  #cse-result-section-id div.gsc-control-cse {
    background-color: transparent;
    padding: 0; margin: 0;
    border: none;
  }
  #cse-result-section-id div.gcsc-branding { width:0; height:0; overflow:hidden}
  .loading_div {
    width: 100%; height: 13px;
    background: transparent url('<?php echo base_url() ?>application/assets/images/thickbox_loading.gif') no-repeat center center;
  }
  h3.search_title { margin: 10px 0 0 10px !important; }
  #cse-result-section-id div.gsc-result-info { margin: 0 !important; }
  div.gsc-above-wrapper-area { padding:0!important; }
</style>
<?php if (isset($_POST['q'])){ ?>
<h3 class="search_title">Search result for: <?php echo strip_tags($_POST['q']) ?></h3>
<div id="cse-result-section-id" style="width: 100%;">
  <div class="loading_div"></div>
</div>
<?php } ?>
<script type="text/javascript">
  var customSearchControl = '';
  var txtSearch = '<?php echo isset($_POST['q']) ? strip_tags($_POST['q']): '' ?>'; // $('#cse-search-input-box-id').val();

  function onLoad() {
    // Create a custom search control that uses a CSE restricted to
    // code.google.com
    customSearchControl = new google.search.CustomSearchControl(
            '013129908899227594987:srkgku878ek');

    var drawOptions = new google.search.DrawOptions();
    drawOptions.setAutoComplete(true);
    drawOptions.enableSearchResultsOnly();
    // Draw the control in content div
    customSearchControl.draw('cse-result-section-id', drawOptions);

    // Run current query
    customSearchControl.execute(txtSearch);
   
    /*$('#cse-search-box-form-id').submit(function(event) {
      txtSearch = $('#cse-search-input-box-id').val();
      if (txtSearch) {
        customSearchControl.execute(txtSearch);
      }
      event.preventDefault();
    });*/
  }
  
  if (txtSearch) {
    google.load('search', '1', {style: google.loader.themes.GREENSKY});
    google.setOnLoadCallback(onLoad);
  }
</script>
