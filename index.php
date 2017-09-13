<?php

$note_name = 'note.txt';
$uniqueNotePerIP = true;

if($uniqueNotePerIP){
	
	// Use the user's IP as the name of the note.
	// This is useful when you have many people
	// using the app simultaneously.
	
	if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$note_name = 'notes/'.md5($_SERVER['HTTP_X_FORWARDED_FOR']).'.txt';
	}
	else{
		$note_name = 'notes/'.md5($_SERVER['REMOTE_ADDR']).'.txt';
	}
}


if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
	// This is an AJAX request
	
	if(isset($_POST['note'])){
		// Write the file to disk
		file_put_contents($note_name, $_POST['note']);
		echo '{"saved":1}';
	}
	
	exit;
}

$note_content = '

                Write your note here.

             It will be saved with AJAX.';

if( file_exists($note_name) ){
	$note_content = htmlspecialchars( file_get_contents($note_name) );
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Sermon Notes</title>
        
        <!-- Our stylesheet -->
        <link rel="stylesheet" href="assets/css/styles.css" />
        
        <!-- A custom google handwriting font -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Courgette" />

        
        <!--[if lt IE 9]>
          <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    
    <body>

		<div id="pad">
			<h2>Note</h2>
			<textarea id="note"><?php echo $note_content ?></textarea>
		</div>

		

        <div data-role="footer">
		<h4>Geekasoft &copy 2016</h4>
	</div>
        
        <!-- JavaScript includes. -->
		<script src="assets/js/jquery-1.8.1.min.js"></script>
		<script src="assets/js/script.js"></script>
		
    </body>
</html>
