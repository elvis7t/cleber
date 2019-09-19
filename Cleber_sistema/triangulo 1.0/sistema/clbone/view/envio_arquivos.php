<div class="row">
	<div class="col-md-12">
		<div class="box box-success">
			<div class="box-header with-border">
				<h3 class="box-title">Enviar novo Arquivo</h3>
			</div>
				<div class="box-body">
					<span class="btn btn-success fileinput-button">
						<i class="glyphicon glyphicon-plus"></i>
						<span>Add arquivo...</span>
						<!-- The file input field used as target for the file upload widget -->		
						<input id="fileupload" type="file" name="files[]" multiple>
						<input type="hidden" value="<?=$doc;?>" id="doc_cli"/>
						<input type="hidden" value="<?=$_SESSION["usuario"];?>" id="doc_uenv"/>
					</span>
					<br>
					<br>
					<!-- The global progress bar -->
					<div id="progress" class="progress">
						<div class="progress-bar progress-bar-success"></div>
					</div>
					<!-- The container for the uploaded files -->
					<div id="files" class="files"></div>

				</div>
		</div>
	</div>
</div>