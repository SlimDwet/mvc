		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<?php if(!empty($this->View->getScripts())) : foreach($this->View->getScripts() as $script) : ?>
		<script type="text/javascript" src="<?php echo $script; ?>"></script>
		<?php endforeach; endif; ?>
	</div> <!-- .container-fluid -->
</body>
</html>