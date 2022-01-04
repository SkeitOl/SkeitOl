<div class="container">
	<footer class="d-flex flex-wrap justify-content-between align-items-center pt-3 mt-4">
		<div class="col-md-12 d-flex align-items-center">
			<a href="https://skeitol.ru/" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
				<svg class="bi" width="30" height="24">
					<use xlink:href="#bootstrap"></use>
				</svg>
			</a>
			<span class="text-muted">© <?= date('Y') ?> SkeitOl, все права защищены.</span>
		</div>

	</footer>
</div>
<?php
echo '</body>';
echo '</html>';
include_once($_SERVER['DOCUMENT_ROOT'] . '/skeitol/epilog_after.php');