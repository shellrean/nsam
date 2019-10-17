<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Daftar sekolah
      </div>
      <div class="card-body">
      	<!-- <ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#gambar">Gambar</a></li>
  <li><a data-toggle="tab" href="#audio">Audio</a></li>
  <li><a data-toggle="tab" href="#video">Video</a></li>
  <li><a data-toggle="tab" href="#pdf">PDF</a></li>
</ul>

<div class="tab-content">
	<div id="gambar" class="tab-pane fade in active">
		<h3>Gambar</h3><p><?php include "daftar_gambar.php";?></p>
	</div>
	<div id="audio" class="tab-pane fade">
		<h3>Audio</h3><p><?php include "daftar_audio.php";?></p>
	</div>
	<div id="video" class="tab-pane fade">
		<h3>Video</h3><p><?php include "daftar_video.php";?></p>
	</div>
	<div id="pdf" class="tab-pane fade">
		<h3>PDF</h3><p><?php include "daftar_pdf.php";?></p>
	</div>
      </div> -->
      <nav>
	  	<div class="nav nav-tabs" id="nav-tab" role="tablist">
	    	<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#gambar" role="tab" aria-controls="gambar" aria-selected="true">Gambar</a>
	    	<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#adio" role="tab" aria-controls="adio" aria-selected="false">Profile</a>
	    	<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#video" role="tab" aria-controls="video" aria-selected="false">Contact</a>
	  	</div>
	  </nav>
	<div class="tab-content" id="nav-tabContent">
	  <div class="tab-pane fade show active" id="gambar" role="tabpanel" aria-labelledby="nav-home-tab">
	  	<?php include "daftar_gambar.php";?>
	  </div>
	  <div class="tab-pane fade" id="adio" role="tabpanel" aria-labelledby="nav-profile-tab">...</div>
	  <div class="tab-pane fade" id="video" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>
	</div>
    </div>
  </div>
</div>