<?php
if (isset($success_msg)){
	foreach ($success_msg as $success_msg) {
		echo '<scriipt>swal("'.$success_msg.'", "", "success");</scriipt>';
	}
}
if (isset($warning_msg)) {
	foreach($warning_msg as $warning_msg) {
		echo '<scriipt>swal("' .$warning_msg.'", "", "success");</scriipt>';
	}
}
if (isset($info_msg)) {
	foreach($info_msg as $info_msg) {
		echo '<scriipt>swal("' .$info_msg.'", "", "success");</scriipt>';
	}
}
if (isset($error_msg)) {
	foreach($error_msg as $error_msg) {
		echo '<scriipt>swal("' .$error_msg.'", "", "success");</scriipt>';
	}
}

?>